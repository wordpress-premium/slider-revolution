<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderApi extends RevSliderFunctions {
	private $global_settings	= array();
	public $demo_allowed		= array('get_template_information_short', 'import_template_slider', 'install_template_slide', 'get_list_of', 'get_global_settings', 'get_full_slider_object', 'subscribe_to_newsletter', 'check_system', 'load_module', 'get_addon_list', 'get_layers_by_slide', 'silent_slider_update', 'get_help_directory', 'set_tooltip_preference', 'load_builder', 'load_library_object', 'get_tooltips');
	public $user_allowed		= array('activate_plugin', 'deactivate_plugin', 'import_template_slider', 'install_template_slide', 'import_slider', 'delete_slider', 'create_navigation_preset', 'delete_navigation_preset', 'save_navigation', 'delete_animation', 'save_animation', 'check_system', 'fix_database_issues', 'trigger_font_deletion');
	public $no_cache			= array('get_template_information_short', 'export_slider', 'export_slider_html', 'getSliderImage', 'getSliderSizeLayout', 'get_list_of', 'load_wordpress_object', 'get_global_settings', 'get_slides_by_slider_id', 'get_full_slider_object', 'load_builder', 'subscribe_to_newsletter', 'check_system', 'get_layers_by_slide', 'export_layer_group', 'load_wordpress_image', 'load_library_image', 'get_help_directory', 'get_tooltips', 'get_addons_sizes', 'get_v5_slider_list');
	public $REST				= false;

 	public function __construct(){
		$this->add_actions();
		$this->global_settings = $this->get_global_settings();
	}

	/**
	 * Add all actions that the backend needs here
	 **/
	public function add_actions(){
		add_action('wp_ajax_revslider_ajax_action', array($this, 'do_ajax_action')); //ajax response to save slider options.
		add_action('wp_ajax_rs_ajax_action', array($this, 'do_ajax_action')); //ajax response to save slider options.
		add_action('wp_ajax_revslider_ajax_call_front', array($this, 'do_front_ajax_action'));
		add_action('wp_ajax_nopriv_revslider_ajax_call_front', array($this, 'do_front_ajax_action')); //for not logged in users
		add_action('rest_api_init', array($this, 'init_rest_api'));
	}

	/**
	 * Init the REST API
	 **/
	public function init_rest_api(){
		/**
			WP_REST_SERVER::READABLE = 'GET'
			WP_REST_SERVER::CREATABLE = 'POST'
			WP_REST_SERVER::EDITABLE = 'POST, PUT, PATCH'
			WP_REST_SERVER::DELETABLE = 'DELETE'
			WP_REST_SERVER::ALLMETHODS = 'GET, POST, PUT, PATCH, DELETE'
				return $_SERVER['REQUEST_METHOD']
		**/

		//{"code":"rest_no_route","message":"Es wurde keine Route gefunden, die mit der URL und der Request-Methode identisch ist.","data":{"status":404}}
		register_rest_route('sliderrevolution', '/sliders', array(
			'methods'				=> WP_REST_SERVER::READABLE,
			'callback'				=> array($this, 'get_full_slider_object'),
			'permission_callback'	=> array($this, 'setup_exception_handler')
		));
		register_rest_route('sliderrevolution', '/sliders/(?P<slider>[\w\-]+)', array(
			'methods'				=> WP_REST_SERVER::READABLE,
			'callback'				=> array($this, 'get_full_slider_object'),
			'permission_callback'	=> array($this, 'setup_exception_handler')
		));
		register_rest_route('sliderrevolution', '/sliders/slides/(?P<id>\d+)', array(
			'methods'				=> WP_REST_SERVER::READABLE,
			'callback'				=> array($this, 'get_full_slider_object'),
			'permission_callback'	=> array($this, 'setup_exception_handler')
		));
		//register_rest_route('sliderrevolution', '/sliders/stream/(?P<id>\d+)', array(
		register_rest_route('sliderrevolution', '/sliders/stream/(?P<id>[0-9,]+)', array(
			'methods'				=> WP_REST_SERVER::READABLE,
			'callback'				=> array($this, 'get_stream_data'),
			'permission_callback'	=> array($this, 'setup_exception_handler')
		));
		register_rest_route('sliderrevolution', '/sliders/modal/(?P<slider>[\w\-]+)', array(
			'methods'				=> WP_REST_SERVER::READABLE,
			'callback'				=> array($this, 'get_slider_modal_data'),
			'permission_callback'	=> array($this, 'setup_exception_handler')
		));
	}

	public function set_rest_call(){
		$this->REST = true;
	}

	public function is_rest_call(){
		return $this->REST;
	}
	
	public function check_nonce(){
		$this->setup_exception_handler();
		$nonce	= $this->get_request_var('nonce');
		$nonce	= (empty($nonce)) ? $this->get_request_var('rs-nonce') : $nonce;
		if(wp_verify_nonce($nonce, 'revslider_actions') == false){
			//check if it is wp nonce and if the action is refresh nonce
			$this->ajax_response_error(__('Bad Request', 'revslider'));
			exit;
		}

		$sr_admin = RevSliderGlobals::instance()->get('RevSliderAdmin');
		if(!current_user_can($sr_admin->get_user_role()) && apply_filters('revslider_restrict_role', true)){
			$this->ajax_response_error(__('Bad Request', 'revslider'));
			exit;
		}

		return true;
	}

	public function setup_exception_handler(){
		set_exception_handler(array($this, 'handle_rest_exceptions'));

		return true;
	}

	public function handle_rest_exceptions(Throwable $exception){
		//http_response_code(500);
		//if(!$this->is_rest_call()) return;

		$response = array(
			'success'	=> false,
			'message'	=> $exception->getMessage()
		);

		wp_send_json($response);
	}

	/**
	 * The Ajax Action part for backend actions only
	 **/
	public function do_ajax_action(){
		global $SR_GLOBALS;

		$slider	= new RevSliderSlider();
		$slide	= new RevSliderSlide();
		$action	= $this->get_request_var('client_action');
		$nonce	= $this->get_request_var('nonce');
		$nonce	= (empty($nonce)) ? $this->get_request_var('rs-nonce') : $nonce;
		//for now, set also the data for ajax calls here, later to be removed!
		$data	= $this->get_request_var('data', '', false);
		$data	= ($data == '') ? array() : $data;

		try{
			if(RS_DEMO && !in_array($action, $this->demo_allowed)){
				$this->ajax_response_error(__('Function Not Available in Demo Mode', 'revslider'));
				exit;
			}
			
			$sr_admin = RevSliderGlobals::instance()->get('RevSliderAdmin');
			if(!current_user_can($sr_admin->get_user_role()) && apply_filters('revslider_restrict_role', true)){
				if(in_array($action, $this->user_allowed)){
					$this->ajax_response_error(__('Function only available for administrators', 'revslider'));
					exit;
				}else{
					$return = apply_filters('revslider_admin_onAjaxAction_user_restriction', true, $action, $data, $slider, $slide);
					if($return !== true){
						$this->ajax_response_error(__('Function only available for administrators', 'revslider'));
						exit;
					}
				}
			}

			if(wp_verify_nonce($nonce, 'revslider_actions') == false){
				//check if it is wp nonce and if the action is refresh nonce
				$this->ajax_response_error(__('Bad Request', 'revslider'));
				exit;
			}

			if(!in_array($action, $this->no_cache)) $this->flush_wp_cache();
			
			switch($action){
				/**
				 * new to v7 calls
				 **/
				case 'save_slider_v7':
					$this->save_slider();
				break;
				case 'clear_v7_tables':
					$this->truncate_v7_tables();
				break;
				case 'set_v7_migration_failed':
					$this->set_v7_migration_failed();
				break;
				case 'get_full_slider_object_v7':
					$this->get_full_slider_object(false, false);
				break;

				/**
				 * The old ajax calls, all of these are not in the REST API yet
				 **/
				case 'load_google_font':
					$google_font = $this->get_val($data, 'font', '');
					$this->download_collected_fonts($google_font);
					$this->ajax_response_success('', '');
				break;
				case 'collect_google_fonts':
					$page = $this->get_val($data, 'page', 1);
					$return = $this->collect_used_fonts(true, true, $page);

					$this->ajax_response_data($return);
				break;
				case 'delete_full_fonts_cache':
					$this->delete_google_fonts();
					$this->ajax_response_success(__('Successfully deleted all fonts cache', 'revslider'));
				break;
				case 'activate_plugin':
					$result	 = false;
					$code	 = trim($this->get_val($data, 'code'));
					$selling = $this->get_addition('selling');
					$rs_license = new RevSliderLicense();
					
					if(!empty($code)){
						$result = $rs_license->activate_plugin($code);
					}else{
						$error = ($selling === true) ? __('The License Key needs to be set!', 'revslider') : __('The Purchase Code needs to be set!', 'revslider');
						$this->ajax_response_error($error);
						exit;
					}

					if($result === true){
						$this->ajax_response_success(__('Plugin successfully activated', 'revslider'));
					}elseif($result === false){
						$error = ($selling === true) ? __('License Key is invalid', 'revslider') : __('Purchase Code is invalid', 'revslider');
						$this->ajax_response_error($error);
					}else{
						if($result == 'exist'){
							$error = ($selling === true) ? __('License Key already registered!', 'revslider') : __('Purchase Code already registered!', 'revslider');
							$this->ajax_response_error($error);
						}elseif($result == 'banned'){
							$error = ($selling === true) ? __('License Key was locked, please contact the ThemePunch support!', 'revslider') : __('Purchase Code was locked, please contact the ThemePunch support!', 'revslider');
							$this->ajax_response_error($error);
						}
						$error = ($selling === true) ? __('License Key could not be validated', 'revslider') : __('Purchase Code could not be validated', 'revslider');
						$this->ajax_response_error($error);
					}
				break;
				case 'deactivate_plugin':
					$rs_license = new RevSliderLicense();
					$result = $rs_license->deactivate_plugin();

					if($result){
						$this->ajax_response_success(__('Plugin deregistered', 'revslider'));
					}else{
						$this->ajax_response_error(__('Deregistration failed!', 'revslider'));
					}
				break;
				case 'close_deregister_popup':
					update_option('revslider-deregister-popup', 'false');
					$this->ajax_response_success(__('Saved', 'revslider'));
				break;
				case 'deactivate_trustpilot':
					update_option('revslider-trustpilot', 'false');
					$this->ajax_response_success(__('Saved', 'revslider'));
				break;
				case 'dismiss_dynamic_notice':
					$ids = $this->get_val($data, 'id', array());
					$notices_discarded = get_option('revslider-notices-dc', array());
					if(!empty($ids)){
						foreach($ids as $_id){
							$notices_discarded[] = esc_attr(trim($_id));
						}
						
						update_option('revslider-notices-dc', $notices_discarded);
					}
					
					$this->ajax_response_success(__('Saved', 'revslider'));
				break;
				case 'check_for_updates':
					$update = new RevSliderUpdate(RS_REVISION);
					$update->force = true;
					
					$update->_retrieve_version_info();
					$version = get_option('revslider-latest-version', RS_REVISION);
					
					if($version !== false){
						$this->ajax_response_data(array('version' => $version));
					}else{
						$this->ajax_response_error(__('Connection to Update Server Failed', 'revslider'));
					}
				break;
				case 'get_template_information_short':
					$templates = new RevSliderTemplate();
					$sliders = $templates->get_tp_template_sliders();

					$this->ajax_response_data(array('templates' => $sliders));
				break;
				case 'import_template_slider': //before: import_slider_template_slidersview
					$uid		= $this->get_val($data, 'uid');
					$sliderID	= intval($this->get_val($data, 'sliderid', 0));
					$templates	= new RevSliderTemplate();
					$filepath	= $templates->_download_template($uid);

					if($filepath !== false){
						$templates->remove_old_template($uid);
						$slider = new RevSliderSliderImport();
						$return = $slider->import_slider(false, $filepath, $uid, false, true);

						if($this->get_val($return, 'success') == true){
							$new_id = $this->get_val($return, 'sliderID');
							if(intval($new_id) > 0){
								$map = $this->get_val($return, 'map',  array());
								$folder_id = $this->get_val($data, 'folderid', -1);
								if(intval($folder_id) > 0){
									$folder = new RevSliderFolder();
									$folder->add_slider_to_folder($new_id, $folder_id, false);
								}

								$new_slider = new RevSliderSlider();
								$new_slider->init_by_id($new_id);
								$data = $new_slider->get_overview_data();

								$hiddensliderid = $templates->get_slider_id_by_uid($uid);
								
								$templates->_delete_template($uid); //delete template file
								$this->ajax_response_data(array('slider' => $data, 'hiddensliderid' => $hiddensliderid, 'map' => $map, 'uid' => $uid));
							}
						}

						$templates->_delete_template($uid); //delete template file
						
						$error = ($this->get_val($return, 'error') !== '') ? $this->get_val($return, 'error') : __('Slider Import Failed', 'revslider');
						$this->ajax_response_error($error);
					}
					$this->ajax_response_error(__('Template Slider Import Failed', 'revslider'));
				break;
				case 'install_template_slide':
					$template = new RevSliderTemplate();
					$slider_id = intval($this->get_val($data, 'slider_id'));
					$slide_id = intval($this->get_val($data, 'slide_id'));

					if($slider_id == 0 || $slide_id == 0){
					}else{
						$new_slide_id = $slide->duplicate_slide_by_id($slide_id, $slider_id);

						if($new_slide_id !== false){
							$slide->init_by_id($new_slide_id);
							$_slides[] = array(
								'order' => $slide->get_order(),
								'params' => $slide->get_params(),
								'layers' => $slide->get_layers(),
								'id' => $slide->get_id(),
							);

							$this->ajax_response_data(array('slides' => $_slides));
						}
					}

					$this->ajax_response_error(__('Slide duplication failed', 'revslider'));
				break;
				case 'import_slider':
					$import = new RevSliderSliderImport();
					$return = $import->import_slider();

					if($this->get_val($return, 'success') == true){
						$new_id = $this->get_val($return, 'sliderID');

						if(intval($new_id) > 0){
							$folder = new RevSliderFolder();
							$folder_id = $this->get_val($data, 'folderid', -1);
							if(intval($folder_id) > 0){
								$folder->add_slider_to_folder($new_id, $folder_id, false);
							}

							$new_slider = new RevSliderSlider();
							$new_slider->init_by_id($new_id);
							$data = $new_slider->get_overview_data();

							$this->ajax_response_data(array('slider' => $data, 'hiddensliderid' => $new_id));
						}
					}

					$error = ($this->get_val($return, 'error') !== '') ? $this->get_val($return, 'error') : __('Slider Import Failed', 'revslider');

					$this->ajax_response_error($error);
				break;
				case 'add_to_media_library':
					$sr_admin = RevSliderGlobals::instance()->get('RevSliderAdmin');
					$return = $sr_admin->import_upload_media();
					
					if($this->get_val($return, 'error', false) !== false){
						$this->ajax_response_error($this->get_val($return, 'error', false));
					}else{
						$this->ajax_response_data($return);
					}
				break;
				case 'adjust_modal_ids':
					$map = $this->get_val($data, 'map', array());
					
					if(!empty($map)){
						$slider_ids = $this->get_val($map, 'slider_map', array());
						$slides_ids = $this->get_val($map, 'slides_map', array());
						
						$ztt = $this->get_val($slider_ids, 'zip_to_template', array());
						$s_a = array();
						if(!empty($slides_ids)){
							foreach($slides_ids as $k => $v){
								if(is_array($v)){
									foreach($v as $vk => $vv){
										$s_a[$vk] = $vv;
									}
									unset($slides_ids[$k]);
								}
							}
						}
						
						if(!empty($ztt)){
							foreach($ztt as $old => $new){
								$slider = new RevSliderSliderImport();
								$slider->init_by_id($new);
								$slider->update_modal_ids($ztt, $slides_ids);
							}
						}
						$this->ajax_response_data(array());
					}else{
						$this->ajax_response_error(__('Slider Map Empty', 'revslider'));
					}
				break;
				case 'adjust_js_css_ids':
					$map = $this->get_val($data, 'map', array());
					
					if(!empty($map)){
						$slider_map = array();
						foreach($map as $m){
							$slider_ids = $this->get_val($m, 'slider_map', array());
							if(!empty($slider_ids)){
								foreach($slider_ids as $old => $new){
									$slider = new RevSliderSliderImport();
									$slider->init_by_id($new);
									
									$slider_map[] = $slider;
								}
							}
						}
						
						if(!empty($slider_map)){
							foreach($slider_map as $slider){
								foreach($map as $m){
									$slider_ids = $this->get_val($m, 'slider_map', array());
									$slide_ids = $this->get_val($m, 'slide_map', array());
									if(!empty($slider_ids)){
										foreach($slider_ids as $old => $new){
											$slider->update_css_and_javascript_ids($old, $new, $slide_ids);
										}
									}
								}
							}
						}
					}
				break;
				case 'export_slider':
					$export = new RevSliderSliderExport();
					$id = intval($this->get_request_var('id'));
					$export->export_slider($id);

					//will never be called if all is good
					$this->ajax_response_error(__('Slider Export Error!!!', 'revslider'));
				break;
				case 'export_slider_html':
					$export = new RevSliderSliderExportHtml();
					$id = intval($this->get_request_var('id'));
					$export->export_slider_html($id);

					//will never be called if all is good
					$this->ajax_response_error(__('Slider HTML Export Error!!!', 'revslider'));
				break;
				case 'delete_slider':
					$id = $this->get_val($data, 'id');
					$slider->init_by_id($id);
					$slider->delete_slider();

					$this->ajax_response_success(__('Slider Deleted', 'revslider'));
				break;
				case 'duplicate_slider':
					$id = $this->get_val($data, 'id');
					$new_id = $slider->duplicate_slider_by_id($id);
					if(intval($new_id) > 0){
						$new_slider = new RevSliderSlider();
						$new_slider->init_by_id($new_id);
						$data = $new_slider->get_overview_data();
						$this->ajax_response_data(array('slider' => $data));
					}

					$this->ajax_response_error(__('Duplication Failed', 'revslider'));
				break;
				case 'save_slide':
					$slide_id = $this->get_val($data, 'slide_id');
					$slider_id = $this->get_val($data, 'slider_id');
					$return = $slide->save_slide($slide_id, $data, $slider_id);
					
					$cache = RevSliderGlobals::instance()->get('RevSliderCache');
					$cache->clear_transients_by_slider($slider_id);
					
					if($return){
						$v7_slider_map = $this->get_v7_slider_map($slider_id);

						$this->ajax_response_data(array('v7' => $v7_slider_map));
					}else{
						$this->ajax_response_error(__('Slide not found', 'revslider'));
					}
				break;
				case 'save_slide_advanced':
					$slide_id = $this->get_val($data, 'slide_id');
					$slider_id = $this->get_val($data, 'slider_id');
					$return = $slide->save_slide_advanced($slide_id, $data, $slider_id);
					
					$cache = RevSliderGlobals::instance()->get('RevSliderCache');
					$cache->clear_transients_by_slider($slider_id);
					
					if($return){
						$this->ajax_response_success(__('Slide Saved', 'revslider'));
					}else{
						$this->ajax_response_error(__('Slide not found', 'revslider'));
					}
				break;
				case 'save_slider':
					$slider_id = $this->get_val($data, 'slider_id');
					$slide_ids = $this->get_val($data, 'slide_ids', array());
					$return = $slider->save_slider($slider_id, $data);
					$missing_slides = array();
					$delete_slides = array();
					
					$cache = RevSliderGlobals::instance()->get('RevSliderCache');
					$cache->clear_transients_by_slider($slider_id);
					
					if($return === false) $this->ajax_response_error(__('Slider not found', 'revslider'));

					if(!empty($slide_ids)){
						$slides = $slider->get_slides(false, true);

						//get the missing Slides (if any at all)
						foreach($slide_ids as $slide_id){
							foreach($slides as $_slide){
								if($_slide->get_id() !== $slide_id) continue;
								$missing_slides[] = $slide_id;
								break;
							}
						}

						//get the Slides that are no longer needed and delete them
						$existing_slide_ids = array();
						foreach($slides as $key => $_slide){
							$id = $_slide->get_id();
							if(!in_array($id, $slide_ids)){
								$delete_slides[] = $id;
							}else{
								$existing_slide_ids[] = $id;
							}
						}
						
						foreach($slides as $key => $_slide){
							//check if the parentID exists in the $slides, if not remove this child slide
							$parentID = $_slide->get_param(array('child', 'parentId'), false);
							if($parentID !== false){
								if(!in_array($parentID, $existing_slide_ids)){
									$slid = $_slide->get_id();
									if(!in_array($slid, $delete_slides)){ 
										$delete_slides[] = $slid;
									}
								}
							}
						}
						
						if(!empty($delete_slides)){
							//check for parentID's and if they exist, if the parentID will be deleted
							foreach($slides as $key => $_slide){
								//params -> child -> parentID
								$parentID = $_slide->get_param(array('child', 'parentId'), false);
								$child = $_slide->get_param(array('child'), false);
								
								if($parentID !== false){
									if(in_array($parentID, $delete_slides)){
										$delete_slides[] = $_slide->get_id();
									}
								}
							}
							
							foreach($slides as $key => $_slide){
								$id = $_slide->get_id();
								if(in_array($id, $delete_slides)){
									unset($slides[$key]); //remove none existing slides for further ordering process
								}
							}

							foreach($delete_slides as $delete_slide){
								$slide->delete_slide_by_id($delete_slide);
							}
						}

						//change the order of slides
						$slide = new RevSliderSlide();
						foreach($slide_ids as $order => $id){
							$new_order = $order + 1;
							$slide->change_slide_order($id, $new_order);
						}
					}

					$v7_slider_map = $this->get_v7_slider_map($slider_id);

					$trans_ids = $this->get_val($data, 'trans_ids');
					if(!empty($trans_ids)){
						foreach($trans_ids ?? [] as $t_id){
							$t_v7id = $this->get_v7_slider_map(false, $t_id);
							if(intval($t_v7id) === 0) continue;
							if(!isset($v7_slider_map['n'])) $v7_slider_map['n'] = array();
							$v7_slider_map['n'][$t_id] = $t_v7id;
						}
					}
					
					$this->ajax_response_data(array('missing' => $missing_slides, 'delete' => $delete_slides, 'v7' => $v7_slider_map));
				break;
				case 'delete_slide':
					$slide_id = intval($this->get_val($data, 'slide_id', ''));
					if($slide_id > 0){
						$slide->init_by_id($slide_id);
						$slider_id = $slide->get_slider_id();
						$cache = RevSliderGlobals::instance()->get('RevSliderCache');
						$cache->clear_transients_by_slider($slider_id);
					}
					$return = ($slide_id > 0) ? $slide->delete_slide_by_id($slide_id) : false;
					
					if($return !== false){
						$this->ajax_response_success(__('Slide deleted', 'revslider'));
					}else{
						$this->ajax_response_error(__('Slide could not be deleted', 'revslider'));
					}
				break;
				case 'duplicate_slide':
					$slide_id	= intval($this->get_val($data, 'slide_id', ''));
					$slider_id	= intval($this->get_val($data, 'slider_id', ''));
					
					$new_slide_id = $slide->duplicate_slide_by_id($slide_id, $slider_id);
					if($new_slide_id !== false){
						$slide->init_by_id($new_slide_id);
						$_slide = $slide->get_overview_data();
						
						$this->ajax_response_data(array('slide' => $_slide));
					}else{
						$this->ajax_response_error(__('Slide could not duplicated', 'revslider'));
					}
				break;
				case 'update_slide_order':
					$slide_ids	= $this->get_val($data, 'slide_ids', array());
					
					//change the order of slides
					if(!empty($slide_ids)){
						$init = false;
						foreach($slide_ids as $order => $id){
							if($init === false){
								$slide->init_by_id($id);
								$init = true;
							}
							$new_order = $order + 1;
							$slide->change_slide_order($id, $new_order);
						}
						
						$slider_id = $slide->get_slider_id();
						$cache = RevSliderGlobals::instance()->get('RevSliderCache');
						$cache->clear_transients_by_slider($slider_id);
						
						$this->ajax_response_success(__('Slide order changed', 'revslider'));
					}else{
						$this->ajax_response_error(__('Slide order could not be changed', 'revslider'));
					}
				break;
				case 'getSliderImage':
					// Available Sliders
					$slider = new RevSliderSlider();
					$arrSliders = $slider->get_sliders();

					// Given Alias
					$alias = $this->get_val($data, 'alias');
					$return = array_search($alias,$arrSliders);

					foreach($arrSliders as $sliderony){
						if($sliderony->get_alias() != $alias) continue;

						$slider_found	= $sliderony->get_overview_data();
						$return			= $this->get_val($slider_found, array('bg', 'src'));
						$title			= $this->get_val($slider_found, 'title');
						$premium_state	= $this->get_val($slider_found, 'premium');

						break;
					}

					if(!$return) $return = '';

					if(!empty($title)){
						$this->ajax_response_data(array('image' => $return, 'title' => $title, 'premium' => $premium_state));
					}else{
						$this->ajax_response_error( __('The Slider with the alias "' . $alias . '" is not available!', 'revslider') );
					}

				break;
				case 'getSliderSizeLayout':
					// Available Sliders
					$slider = new RevSliderSlider();
					$arrSliders = $slider->get_sliders();

					// Given Alias
					$alias	= $this->get_val($data, 'alias');
					$return = array_search($alias, $arrSliders);
					$title	= '';
					foreach($arrSliders as $sliderony){
						if($sliderony->get_alias() == $alias){
							$slider_found = $sliderony->get_overview_data();
							$return	= $slider_found['size'];
							$title	= $slider_found['title'];
						}
					}
					
					$this->ajax_response_data(array('layout' => $return, 'title' => $title));
				break;
				case 'get_list_of':
					$type = $this->get_val($data, 'type');
					switch($type){
						case 'sliders':
							$slider = new RevSliderSlider();
							$arrSliders = $slider->get_sliders();
							$return = array();
							foreach($arrSliders as $sliderony){
								$return[$sliderony->get_id()] = array('slug' => $sliderony->get_alias(), 'title' => $sliderony->get_title(), 'type' => $sliderony->get_type(), 'subtype' => $sliderony->get_param(array('source', 'post', 'subType'), false));
							}
							$this->ajax_response_data(array('sliders' => $return));
						break;
						case 'pages':
							$pages = get_pages(array());
							$return = array();
							foreach($pages as $page){
								if(!$page->post_password){
									$return[$page->ID] = array('slug' => $page->post_name, 'title' => $page->post_title);
								}

							}
							$this->ajax_response_data(array('pages' => $return));
						break;
						case 'posttypes':
							$args = array(
								'public' => true,
								'_builtin' => false,
							);
							$output = 'objects';
							$operator = 'and';
							$post_types = get_post_types($args, $output, $operator);
							$return['post'] = array('slug' => 'post', 'title' => __('Posts', 'revslider'));

							foreach($post_types as $post_type){
								$return[$post_type->rewrite['slug']] = array('slug' => $post_type->rewrite['slug'], 'title' => $post_type->labels->name);
								if(!in_array($post_type->name, array('post', 'page', 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'custom_changeset', 'user_request'))){
									$taxonomy_objects = get_object_taxonomies($post_type->name, 'objects');
									if(!empty($taxonomy_objects)){
										$return[$post_type->rewrite['slug']]['tax'] = array();
										foreach($taxonomy_objects as $name => $tax){
											$return[$post_type->rewrite['slug']]['tax'][$name] = $tax->label;
										}
									}
								}
							}

							$this->ajax_response_data(array('posttypes' => $return));
						break;
					}
				break;
				case 'load_wordpress_object':
					$id = $this->get_val($data, 'id', 0);
					$type = $this->get_val($data, 'type', 'full');
					
					$file = wp_get_attachment_image_src($id, $type);
					if($file !== false){
						$this->ajax_response_data(array('url' => $this->get_val($file, 0)));
					}else{
						$this->ajax_response_error(__('File could not be loaded', 'revslider'));
					}
				break;
				case 'get_global_settings':
					$this->ajax_response_data(array('global_settings' => $this->global_settings));
				break;
				case 'update_global_settings':
					$global = $this->get_val($data, 'global_settings', array());
					if(!empty($global)){
						$update = $this->get_val($data, 'update', false);
						$return = $this->set_global_settings($global, $update);
						if($return === true){
							$this->ajax_response_success(__('Global Settings saved/updated', 'revslider'));
						}else{
							$this->ajax_response_error(__('Global Settings not saved/updated', 'revslider'));
						}
					}else{
						$this->ajax_response_error(__('Global Settings not saved/updated', 'revslider'));
					}
				break;
				case 'create_navigation_preset':
					$nav = new RevSliderNavigation();
					$return = $nav->add_preset($data);

					if($return === true){
						$this->ajax_response_success(__('Navigation preset saved/updated', 'revslider'), array('navs' => $nav->get_all_navigations_builder()));
					}else{
						if($return === false){
							$return = __('Preset could not be saved/values are the same', 'revslider');
						}

						$this->ajax_response_error($return);
					}
				break;
				case 'delete_navigation_preset':
					$nav = new RevSliderNavigation();
					$return = $nav->delete_preset($data);

					if($return === true){
						$this->ajax_response_success(__('Navigation preset deleted', 'revslider'), array('navs' => $nav->get_all_navigations_builder()));
					}else{
						if($return === false){
							$return = __('Preset not found', 'revslider');
						}

						$this->ajax_response_error($return);
					}
				break;
				case 'save_navigation': //also deletes if requested

					if(!current_user_can('administrator') && apply_filters('revslider_restrict_role', true)){
						$this->ajax_response_error(__('Function only available for administrators', 'revslider'));
					}

					$_nav = new RevSliderNavigation();
					$navs = (array) $this->get_val($data, 'navs', array());
					$delete_navs = (array) $this->get_val($data, 'delete', array());

					if(!empty($delete_navs)){
						foreach($delete_navs as $dnav){
							$_nav->delete_navigation($dnav);
						}
					}

					if(!empty($navs)){
						$_nav->create_update_full_navigation($navs);
					}

					$navigations = $_nav->get_all_navigations_builder();

					$this->ajax_response_data(array('navs' => $navigations));
				break;
				case 'delete_animation':
					$animation_id = $this->get_val($data, 'id');
					$return = $sr_admin->delete_animation($animation_id);
					if($return){
						$this->ajax_response_success(__('Animation deleted', 'revslider'));
					}else{
						$this->ajax_response_error(__('Deletion failed', 'revslider'));
					}
				break;
				case 'save_animation':
					$id		= $this->get_val($data, 'id', false);
					$type	= $this->get_val($data, 'type', 'in');
					$animation = $this->get_val($data, 'obj');

					if($id !== false){
						$return = $sr_admin->update_animation($id, $animation, $type);
					}else{
						$return = $sr_admin->insert_animation($animation, $type);
					}

					if(intval($return) > 0){
						$this->ajax_response_data(array('id' => $return));
					} elseif($return === true){
						$this->ajax_response_success(__('Animation saved', 'revslider'));
					}else{
						if($return == false){
							$this->ajax_response_error(__('Animation could not be saved', 'revslider'));
						}
						$this->ajax_response_error($return);
					}
				break;
				case 'get_slides_by_slider_id':
					$sid	 = intval($this->get_val($data, 'id'));
					$slides	 = array();
					$_slides = $slide->get_slides_by_slider_id($sid);
					
					if(!empty($_slides)){
						foreach($_slides as $slide){
							$slides[] = $slide->get_overview_data();
						}
					}
					
					$this->ajax_response_data(array('slides' => $slides));
				break;
				case 'get_full_slider_object':
					$slide_id = $this->get_val($data, 'id');
					$slide_id = RevSliderFunctions::esc_attr_deep($slide_id);
					$slider_alias = $this->get_val($data, 'alias', '');
					$slider_alias = RevSliderFunctions::esc_attr_deep($slider_alias);

					if($slider_alias !== ''){
						$slider->init_by_alias($slider_alias);
						$slider_id = $slider->get_id();
					}else{
						if(strpos($slide_id, 'slider-') !== false){
							$slider_id = str_replace('slider-', '', $slide_id);
						}else{
							$slide->init_by_id($slide_id);

							$slider_id = $slide->get_slider_id();
							if(intval($slider_id) == 0){
								$this->ajax_response_error(__('Slider could not be loaded', 'revslider'));
							}
						}

						$slider->init_by_id($slider_id);
					}
					if($slider->inited === false){
						$this->ajax_response_error(__('Slider could not be loaded', 'revslider'));
					}
					
					//check if an update is needed
					if(version_compare($slider->get_param(array('settings', 'version')), get_option('revslider_update_version', '6.0.0'), '<')){
						$upd = new RevSliderPluginUpdate();
						$upd->upgrade_slider_to_latest($slider);
						$slider->init_by_id($slider_id);
					}
					
					//create static Slide if the Slider not yet has one
					$static_slide_id = $slide->get_static_slide_id($slider_id);
					$static_slide_id = (intval($static_slide_id) === 0) ? $slide->create_slide($slider_id, '', true) : $static_slide_id;
					
					$static_slide = false;
					if(intval($static_slide_id) > 0){
						$static_slide = new RevSliderSlide();
						$static_slide->init_by_static_id($static_slide_id);
					}
					
					$slides	 = $slider->get_slides(false, true);
					$_slides = array();
					$_static_slide = array();

					foreach($slides ?? [] as $s){
						$_slides[] = array(
							'order' => $s->get_order(),
							'params' => $s->get_params(),
							'layers' => $s->get_layers(),
							'id' => $s->get_id(),
						);
					}

					if(!empty($static_slide)){
						$_static_slide = array(
							'params' => $static_slide->get_params(),
							'layers' => $static_slide->get_layers(),
							'id' => $static_slide->get_id(),
						);
					}
					
					$obj = array(
						'id'				=> $slider_id,
						'alias'				=> $slider->get_alias(),
						'title'				=> $slider->get_title(),
						'slider_params' 	=> $slider->get_params(),
						'slider_settings'	=> $slider->get_settings(),
						'slides'			=> $_slides,
						'static_slide'		=> $_static_slide,
					);
					
					$uid = $this->get_val($obj, array('slider_params', 'uid'));
					if(!empty($uid)){
						$templates		= new RevSliderTemplate();
						$rslb			= RevSliderGlobals::instance()->get('RevSliderLoadBalancer');
						$temp_url		= $rslb->get_url('templates', 0, true).'/'.$templates->templates_server_path;
						$defaults		= $this->get_addition(array('templates', 'guide'));
						
						$template_data	= $templates->get_tp_template_sliders($uid);
						if(!empty($template_data)){
							foreach($template_data as $data){
								$title			= $this->get_val($data, 'guide_title');
								$url			= $this->get_val($data, 'guide_url');
								$img			= $this->get_val($data, 'guide_img');
								$template_img	= $this->get_val($data, 'img');
								$obj['guide'] = array(
									'title'			=> (empty($title)) ? $this->get_val($defaults, 'title') : $title,
									'url'			=> (empty($url)) ? $this->get_val($defaults, 'url') : $url,
									'img'			=> (empty($img)) ? $this->get_val($defaults, 'img') : $temp_url.'/'.$img,
									'template_img'	=> (empty($template_img)) ? $this->get_val($defaults, 'img') : $template_img,
									'template_title'=> $this->get_val($data, 'title'),
								);

								break;
							}
						}
					}

					$this->ajax_response_data($obj);
				break;
				case 'load_builder':
					ob_start();
					require_once(RS_PLUGIN_PATH . 'admin/views/builder.php');
					$builder = ob_get_contents();
					ob_clean();
					ob_end_clean();

					$this->ajax_response_data($builder);
				break;
				case 'create_slider_folder':
					$folder = new RevSliderFolder();
					$title = $this->get_val($data, 'title', __('New Folder', 'revslider'));
					$parent = $this->get_val($data, 'parentFolder', 0);
					$new = $folder->create_folder($title, $parent);

					if($new !== false){
						$overview_data = $new->get_overview_data();
						$this->ajax_response_data(array('folder' => $overview_data));
					}else{
						$this->ajax_response_error(__('Folder Creation Failed', 'revslider'));
					}
				break;
				case 'delete_slider_folder':
					$id = $this->get_val($data, 'id');
					$folder = new RevSliderFolder();
					$is = $folder->init_folder_by_id($id);
					if($is === true){
						$folder->delete_slider();
						$this->ajax_response_success(__('Folder Deleted', 'revslider'));
					}else{
						$this->ajax_response_error(__('Folder Deletion Failed', 'revslider'));
					}
				break;
				case 'update_slider_tags':
					$id = $this->get_val($data, 'id');
					$tags = $this->get_val($data, 'tags');

					$return = $slider->update_slider_tags($id, $tags);
					if($return == true){
						$this->ajax_response_success(__('Tags Updated', 'revslider'));
					}else{
						$this->ajax_response_error(__('Failed to Update Tags', 'revslider'));
					}
				break;
				case 'save_slider_folder':
					$folder = new RevSliderFolder();
					$children = $this->get_val($data, 'children');
					$folder_id = $this->get_val($data, 'id');

					$return = $folder->add_slider_to_folder($children, $folder_id);

					if($return == true){
						$this->ajax_response_success(__('Slider Moved to Folder', 'revslider'));
					}else{
						$this->ajax_response_error(__('Failed to Move Slider Into Folder', 'revslider'));
					}
				break;
				case 'update_slider_name':
				case 'update_folder_name':
					$slider_id = $this->get_val($data, 'id');
					$new_title = $this->get_val($data, 'title');

					$slider->init_by_id($slider_id, $new_title);
					$return = $slider->update_title($new_title);
					if($return != false){
						$this->ajax_response_success(__('Title updated', 'revslider'), array('title' => $return));
					}else{
						$this->ajax_response_error(__('Failed to update Title', 'revslider'));
					}
				break;
				case 'preview_slider':
					$slider_id = $this->get_val($data, 'id');
					$slider_data = $this->get_val($data, 'data');
					$title = __('Slider Revolution Preview', 'revslider');
					
					global $SR_GLOBALS;
					$SR_GLOBALS['preview_mode'] = true;

					if(intval($slider_id) > 0 && empty($slider_data)){
						$slider->init_by_id($slider_id);

						//check if an update is needed
						if(version_compare($slider->get_param(array('settings', 'version')), get_option('revslider_update_version', '6.0.0'), '<')){
							$upd = new RevSliderPluginUpdate();
							$upd->upgrade_slider_to_latest($slider);
							$slider->init_by_id($slider_id);
						}
						$content = '[rev_slider alias="' . esc_attr($slider->get_alias()) . '"][/rev_slider]';
					}elseif(!empty($slider_data)){
						$_slides = array();
						$_static = array();
						$slides = array();
						$static_slide = array();
						
						$_slider = array(
							'id'		=> $slider_id,
							'title'		=> 'Preview',
							'alias'		=> 'preview',
							'settings'	=> json_encode(array('version' => RS_REVISION)),
							'params'	=> stripslashes($this->get_val($slider_data, 'slider'))
						);
						
						$slide_order = json_decode(stripslashes($this->get_val($slider_data, array('slide_order'))), true);
						
						foreach($slider_data as $sk => $sd){
							if(in_array($sk, array('slider', 'slide_order'), true)) continue;
							
							if(strpos($sk, 'static_') !== false){
								$_static = array(
									'params' => stripslashes($this->get_val($sd, 'params')),
									'layers' => stripslashes($this->get_val($sd, 'layers')),
								);
							}else{
								$_slides[$sk] = array(
									'id'		=> $sk,
									'slider_id'	=> $slider_id,
									'slide_order' => array_search($sk, $slide_order),
									'params'	=> stripslashes($this->get_val($sd, 'params')),
									'layers'	=> stripslashes($this->get_val($sd, 'layers')),
									'settings'	=> array('version' => RS_REVISION)
								);
							}
						}
						
						$slider->set_slides($_slides);
						//set_preview_mode
						$output = ($SR_GLOBALS['front_version'] === 6) ? new RevSliderOutput() : new RevSlider7Output();
						//$output = new RevSliderOutput();
						$output->set_preview_mode(true);
						$slider->init_by_data($_slider);
						
						if($slider->is_stream() || $slider->is_posts()){
							$slides = $slider->get_slides_for_output();
						}else{
							if(!empty($_slides)){
								//reorder slides
								usort($_slides, function($a, $b) {
									return $a['slide_order'] - $b['slide_order'];
								});

								foreach($_slides as $_slide){
									$slide = new RevSliderSlide();
									$slide->init_by_data($_slide);
									if($slide->get_param(array('publish', 'state'), 'published') === 'unpublished') continue;
									$slides[] = $slide;
								}
							}
						}
						if(!empty($_static)){
							$slide = new RevSliderSlide();
							$slide->init_by_data($_static);
							$static_slide = $slide;
						}
						
						$output->set_slider($slider);
						$output->set_current_slides($slides);
						$output->set_static_slide($static_slide);
						
						ob_start();
						$slider = $output->add_slider_to_stage($slider_id);
						$content = ob_get_contents();
						ob_clean();
						ob_end_clean();
					}
					
					//get dimensions of slider
					$size = array(
						'width'	 => $slider->get_param(array('size', 'width'), array()),
						'height' => $slider->get_param(array('size', 'height'), array()),
						'custom' => $slider->get_param(array('size', 'custom'), array())
					);
					
					if(empty($size['width'])){
						$size['width'] = array(
							'd' => $this->get_val($this->global_settings, array('size', 'desktop'), '1240'),
							'n' => $this->get_val($this->global_settings, array('size', 'notebook'), '1024'),
							't' => $this->get_val($this->global_settings, array('size', 'tablet'), '778'),
							'm' => $this->get_val($this->global_settings, array('size', 'mobile'), '480')
						);
					}
					if(empty($size['height'])){
						$size['height'] = array('d' => '868', 'n' => '768', 't' => '960', 'm' => '720'); 
					}
					
					if(extension_loaded('newrelic')){ //Ensure PHP agent is available
						if(function_exists('newrelic_disable_autorum')){
							newrelic_disable_autorum();
						}
					}
					
					$rev_slider_front = new RevSliderFront(); //needed to be called, to load header properly
					$admin = new RevSliderAdmin();
					$post = $admin->create_fake_post($content, $title);
					
					define('SHOW_CT_BUILDER', false); //fix for oxygen builder plugin to not remove the <html> tag and so on
					
					ob_start();
					include(RS_PLUGIN_PATH . 'public/views/revslider-page-template.php');
					$html = ob_get_contents();
					ob_clean();
					ob_end_clean();
					
					$return = array('html' => $html, 'size' => $size, 'layouttype' => $slider->get_param('layouttype', 'fullwidth'));
					$return = apply_filters('revslider_preview_slider_addition', $return, $slider);
					
					$this->ajax_response_data($return);
					
					exit;
				break;
				case 'subscribe_to_newsletter':
					$email = $this->get_val($data, 'email');
					if(!empty($email)){
						$return = ThemePunch_Newsletter::subscribe($email);

						if($return !== false){
							if(!isset($return['status']) || $return['status'] === 'error'){
								$error = $this->get_val($return, 'message', __('Invalid Email', 'revslider'));
								$this->ajax_response_error($error);
							}else{
								$this->ajax_response_success(__('Success! Please check your E-Mails to finish the subscription', 'revslider'), $return);
							}
						}
						$this->ajax_response_error(__('Invalid Email/Could not connect to the Newsletter server', 'revslider'));
					}

					$this->ajax_response_error(__('No Email given', 'revslider'));
				break;
				case 'check_system':
					//recheck the connection to themepunch server
					$update = new RevSliderUpdate(RS_REVISION);
					$update->force = true;
					$update->_retrieve_version_info();

					$system = $sr_admin->get_system_requirements();

					$this->ajax_response_data(array('system' => $system));
				break;
				case 'load_module':
					$module = $this->get_val($data, 'module', array('all'));
					$module_uid = $this->get_val($data, 'module_uid', false);
					$module_slider_id = $this->get_val($data, 'module_id', false);
					$refresh_from_server = $this->get_val($data, 'refresh_from_server', false);
					$get_static_slide = $this->_truefalse($this->get_val($data, 'static', false));
					
					if($module_uid === false){
						$module_uid = $module_slider_id;
					}

					$modules = $sr_admin->get_full_library($module, $module_uid, $refresh_from_server, $get_static_slide);
					
					$this->ajax_response_data(array('modules' => $modules));
				break;
				case 'set_favorite':
					$do = $this->get_val($data, 'do', 'add');
					$type = $this->get_val($data, 'type', 'slider');
					$id = esc_attr($this->get_val($data, 'id'));

					$favorite = RevSliderGlobals::instance()->get('RevSliderFavorite');
					$favorite->set_favorite($do, $type, $id);

					$this->ajax_response_success(__('Favorite Changed', 'revslider'));
				break;
				case 'load_library_object':
					$library = new RevSliderObjectLibrary();

					$cover = false;
					$id = $this->get_val($data, 'id');
					$type = $this->get_val($data, 'type');
					if($type == 'thumb'){
						$thumb = $library->_get_object_thumb($id, 'thumb');
					}elseif($type == 'video'){
						$thumb = $library->_get_object_thumb($id, 'video_full', true);
						$cover = $library->_get_object_thumb($id, 'cover', true);
					}elseif($type == 'layers'){
						$thumb = $library->_get_object_layers($id);
					}else{
						$thumb = $library->_get_object_thumb($id, 'orig', true);
						if(isset($thumb['error']) && $thumb['error'] === false){
							$url = $library->get_correct_size_url($id, $type);
							if($url !== ''){
								$thumb['url'] = $url;
							}
						}
					}

					if(isset($thumb['error']) && $thumb['error'] !== false){
						$this->ajax_response_error(__('Object could not be loaded', 'revslider'));
					}else{
						if($type == 'layers'){
							$return = array('layers' => $this->get_val($thumb, 'data'));
						}else{
							$return = array('url' => $this->get_val($thumb, 'url'));
						}

						if($cover !== false){
							if(isset($cover['error']) && $cover['error'] !== false){
								$this->ajax_response_error(__('Video cover could not be loaded', 'revslider'));
							}

							$return['cover'] = $this->get_val($cover, 'url');
						}

						$this->ajax_response_data($return);
					}
				break;
				case 'create_slide':
					$slider_id = $this->get_val($data, 'slider_id', false);
					$amount = $this->get_val($data, 'amount', 1);
					$amount = intval($amount);
					$slide_ids = array();

					if(intval($slider_id) > 0 && ($amount > 0 && $amount < 50)){
						for ($i = 0; $i < $amount; $i++){
							$slide_ids[] = $slide->create_slide($slider_id);
						}
					}

					if(!empty($slide_ids)){
						$this->ajax_response_data(array('slide_id' => $slide_ids));
					}else{
						$this->ajax_response_error(__('Could not create Slide', 'revslider'));
					}
				break;
				case 'create_slider':
					/**
					 * 1. create a blank Slider
					 * 2. create a blank Slide
					 * 3. create a blank Static Slide
					 **/

					$slide_id = false;
					$slider_id = $slider->create_blank_slider();
					if($slider_id !== false){
						$slide_id = $slide->create_slide($slider_id); //normal slide
						$slide->create_slide($slider_id, '', true); //static slide
					}

					if($slide_id !== false){
						$this->ajax_response_data(array('slide_id' => $slide_id, 'slider_id' => $slider_id));
					}else{
						$this->ajax_response_error(__('Could not create Slider', 'revslider'));
					}
				break;
				case 'get_addon_list':
					$addon = new RevSliderAddons();
					$addons = $addon->get_addon_list();
					
					update_option('rs-addons-counter', 0); //set the counter back to 0
										
					$this->ajax_response_data(array('addons' => $addons));
				break;
				case 'get_layers_by_slide':
					$slide_id = $this->get_val($data, 'slide_id');

					$slide->init_by_id($slide_id);
					$layers = $slide->get_layers();

					$this->ajax_response_data(array('layers' => $layers));
				break;
				case 'activate_addon':
					$handle = $this->get_val($data, 'addon');
					$update = $this->get_val($data, 'update', false);
					$addon = new RevSliderAddons();

					$return = $addon->install_addon($handle, $update);

					if($return === true){
						$version = $addon->get_addon_version($handle);
						//return needed files of the plugin somehow
						$data = array();
						$data = apply_filters('revslider_activate_addon', $data, $handle);

						$this->ajax_response_data(array($handle => $data, 'version' => $version));
					}else{
						$error = ($return === false) ? __('AddOn could not be activated', 'revslider') : $return;
						
						$this->ajax_response_error($error);
					}
				break;
				case 'deactivate_addon':
					$handle = $this->get_val($data, 'addon');
					$addon = new RevSliderAddons();
					$return = $addon->deactivate_addon($handle);

					if($return){
						//return needed files of the plugin somehow
						$this->ajax_response_success(__('AddOn deactivated', 'revslider'));
					}else{
						$this->ajax_response_error(__('AddOn could not be deactivated', 'revslider'));
					}
				break;
				case 'create_draft_page':
					$response	= array('open' => false, 'edit' => false);
					$slider_ids = $this->get_val($data, 'slider_ids');
					$modals		= $this->get_val($data, 'modals', array());
					$additions	= $this->get_val($data, 'additions', array());
					$page_id	= $sr_admin->create_slider_page($slider_ids, $modals, $additions);
					
					if($page_id > 0){
						$response['open'] = get_permalink($page_id);
						$response['edit'] = get_edit_post_link($page_id);
					}
					$this->ajax_response_data($response);
				break;
				case 'generate_attachment_metadata':
					$this->generate_attachment_metadata();
					$this->ajax_response_success('');
				break;
				case 'export_layer_group': //developer function only :)
					$title = $this->get_val($data, 'title', $this->get_request_var('title'));
					$videoid = intval($this->get_val($data, 'videoid', $this->get_request_var('videoid')));
					$thumbid = intval($this->get_val($data, 'thumbid', $this->get_request_var('thumbid')));
					$layers = $this->get_val($data, 'layers', $this->get_request_var('layers', '', false));

					$export = new RevSliderSliderExport($title);
					$url = $export->export_layer_group($videoid, $thumbid, $layers);

					$this->ajax_response_data(array('url' => $url));
				break;
				case 'silent_slider_update':
					$upd = new RevSliderPluginUpdate();
					$return = $upd->upgrade_next_slider();
					
					$this->ajax_response_data($return);
				break;
				case 'load_wordpress_image':
					$id = $this->get_val($data, 'id', 0);
					$type = $this->get_val($data, 'type', 'orig');
					
					$img = wp_get_attachment_image_url($id, $type);
					if(empty($img)){
						$this->ajax_response_error(__('Image could not be loaded', 'revslider'));
					}
					
					$this->ajax_response_data(array('url' => $img));
				break;
				case 'load_library_image':
					$images	= (!is_array($data)) ? (array)$data : $data;
					$images	= RevSliderFunctions::esc_attr_deep($images);
					$images	= RevSliderAdmin::esc_js_deep($images);
					$img_data = array();
					
					if(!empty($images)){
						$templates = new RevSliderTemplate();
						$obj = new RevSliderObjectLibrary();
						
						foreach($images as $image){
							$type = $this->get_val($image, 'librarytype');
							$img = $this->get_val($image, 'id');
							$ind = $this->get_val($image, 'ind');
							$mt = $this->get_val($image, 'mediatype');
							switch($type){
								case 'moduletemplates':
								case 'moduletemplateslides':
									$img = $templates->_check_file_path($img, true);
									$img_data[] = array(
										'ind' => $ind,
										'url' => $img,
										'mediatype' => $mt
									);
								break;
								case 'image':
								case 'images':
								case 'layers':
								case 'objects':
									$get = ($mt === 'video') ? 'video_thumb' : 'thumb';
									$img = $obj->_get_object_thumb($img, $get, true);
									if($this->get_val($img, 'error', false) === false){
										$img_data[] = array(
											'ind' => $ind,
											'url' => $this->get_val($img, 'url'),
											'mediatype' => $mt
										);
									}
								break;
								case 'videos':
									$get = ($mt === 'img') ? 'video' : 'video_thumb';
									$img = $obj->_get_object_thumb($img, $get, true);
									if($this->get_val($img, 'error', false) === false){
										$img_data[] = array(
											'ind' => $ind,
											'url' => $this->get_val($img, 'url'),
											'mediatype' => $mt
										);
									}
								break;
							}
						}
					}
					
					$this->ajax_response_data(array('data' => $img_data));
				break;
				case 'create_customlibrary_tags':
					$obj = new RevSliderObjectLibrary();
					
					$name = $this->get_val($data, 'name', '');
					$type = $this->get_val($data, 'type', '');
					
					$return = $obj->create_custom_tag($name, $type);
					if(!is_array($return)){
						$this->ajax_response_error($return);	
					}else{
						$this->ajax_response_data($return);
					}
				break;
				case 'edit_customlibrary_tags':
					$obj = new RevSliderObjectLibrary();
					
					$id = $this->get_val($data, 'id', '');
					$name = $this->get_val($data, 'name', '');
					$type = $this->get_val($data, 'type', '');
					
					$return = $obj->edit_custom_tag($id, $name, $type);
					if($return !== true){
						$this->ajax_response_error($return);	
					}else{
						$this->ajax_response_success(__('Tag successfully saved', 'revslider'));
					}
				break;
				case 'delete_customlibrary_tags':
					$obj = new RevSliderObjectLibrary();
					
					$id = $this->get_val($data, 'id', '');
					$type = $this->get_val($data, 'type', '');
					
					$return = $obj->delete_custom_tag($id, $type);
					if($return !== true){
						$this->ajax_response_error($return);	
					}else{
						$this->ajax_response_success(__('Tag successfully deleted', 'revslider'));
					}
				break;
				case 'upload_customlibrary_item':
					if(!current_user_can('administrator') && apply_filters('revslider_restrict_role', true)){
						$this->ajax_response_error(__('Function only available for administrators', 'revslider'));
					}

					$obj = new RevSliderObjectLibrary();
					
					$return = $obj->upload_custom_item($data);
					
					if(!is_array($return)){
						$this->ajax_response_error($return);
					}else{
						$return['tags'] = $this->get_val($obj->get_custom_tags(), 'svgcustom', array());
						$this->ajax_response_data($return);
					}
				break;
				case 'edit_customlibrary_item':
					$obj = new RevSliderObjectLibrary();
					
					$id = $this->get_val($data, 'id', '');
					$type = $this->get_val($data, 'type', '');
					$name = $this->get_val($data, 'name', '');
					$tags = $this->get_val($data, 'tags', '');
					$return = $obj->edit_custom_item($id, $type, $name, $tags);
					if($return !== true){
						$this->ajax_response_error(__('Item could not be changed', 'revslider'));	
					}else{
						$this->ajax_response_success(__('Item successfully changed', 'revslider'));
					}
				break;
				case 'delete_customlibrary_item':
					$obj = new RevSliderObjectLibrary();
					
					$id = $this->get_val($data, 'id', '');
					$type = $this->get_val($data, 'type', '');
					$return = $obj->delete_custom_item($id, $type);
					if($return !== true){
						$this->ajax_response_error(__('Item could not be deleted', 'revslider'));
					}else{
						$this->ajax_response_success(__('Item successfully deleted', 'revslider'));
					}
				break;
				case 'get_help_directory':
					include_once(RS_PLUGIN_PATH . 'admin/includes/help.class.php');

					if(class_exists('RevSliderHelp')){
						$help_data = RevSliderHelp::getIndex();
						$this->ajax_response_data(array('data' => $help_data));
					}else{
						$this->ajax_response_error(__('Error loading RevSliderHelp', 'revslider'));
					}
				break;
				case 'get_tooltips':
					include_once(RS_PLUGIN_PATH . 'admin/includes/tooltips.class.php');

					if(class_exists('RevSliderTooltips')){
						$tooltips = RevSliderTooltips::getTooltips();
						$this->ajax_response_data(array('data' => $tooltips));
					}else{
						$this->ajax_response_error(__('Error loading RevSliderTooltips', 'revslider'));
					}
				break;
				case 'set_tooltip_preference':
					update_option('revslider_hide_tooltips', true);
					$this->ajax_response_success(__('Preference Updated', 'revslider'));
				break;
				case 'save_color_preset':
					$presets = $this->get_val($data, 'presets', array());
					$color_presets = RSColorpicker::save_color_presets($presets);
					$this->ajax_response_data(array('presets' => $color_presets));
				break;
				case 'get_facebook_photosets':
					if(empty($data['app_id'])){
						$this->ajax_response_error(__('Facebook API error: Empty Access Token', 'revslider'));
					}
					if(empty($data['page_id'])){
						$this->ajax_response_error(__('Facebook API error: Empty Page ID', 'revslider'));
					}

					$facebook = RevSliderGlobals::instance()->get('RevSliderFacebook');
					$return = $facebook->get_photo_set_photos_options($data['app_id'], $data['page_id']);

					if(empty($return)){
						$error = __('Could not fetch Facebook albums', 'revslider');
						$this->ajax_response_error($error);
					}
					if(!empty($return['error'])){
						$this->ajax_response_error(__('Facebook API error: ', 'revslider') . $return['message']);
					}

					$this->ajax_response_success(__('Successfully fetched Facebook albums', 'revslider'), array('html' => implode(' ', $return)));
				break;
				case 'get_flickr_photosets':
					$error = __('Could not fetch flickr album', 'revslider');
					if(!empty($data['url']) && !empty($data['key'])){
						$flickr = new RevSliderFlickr($data['key']);
						$user_id = $flickr->get_user_from_url($data['url']);
						$return = $flickr->get_photo_sets($user_id, $data['count'], $data['set']);
						if(!empty($return)){
							$this->ajax_response_success(__('Successfully fetched flickr albums', 'revslider'), array('data' => array('html' => implode(' ', $return))));
						}else{
							$error = __('Could not fetch flickr albums', 'revslider');
						}
					}else{
						if(empty($data['url']) && empty($data['key'])){
							$this->ajax_response_success(__('Cleared Albums', 'revslider'), array('html' => implode(' ', $return)));
						}elseif(empty($data['url'])){
							$error = __('No User URL - Could not fetch flickr albums', 'revslider');
						}else{
							$error = __('No API KEY - Could not fetch flickr albums', 'revslider');
						}
					}
					
					$this->ajax_response_error($error);
				break;
				case 'get_youtube_playlists':
					if(!empty($data['id'])){
						$youtube = new RevSliderYoutube(trim($data['api']), trim($data['id']));
						$return = $youtube->get_playlist_options($data['playlist']);
						$this->ajax_response_success(__('Successfully fetched YouTube playlists', 'revslider'), array('data' => array('html' => implode(' ', $return))));
					}else{
						$this->ajax_response_error(__('Could not fetch YouTube playlists', 'revslider'));
					}
				break;
				case 'fix_database_issues':
					update_option('revslider_table_version', '1.0.0');
					RevSliderFront::create_tables(true);
					$this->ajax_response_success(__('Slider Revolution database structure was updated', 'revslider'));
				break;
				case 'clear_internal_cache':
					$cache = RevSliderGlobals::instance()->get('RevSliderCache');
					$cache->clear_all_transients();
					
					$this->ajax_response_success(__('Slider Revolution internal cache was fully cleared', 'revslider'));
				break;
				case 'get_same_aspect_ratio':
					$images = $this->get_val($data, 'images', array());
					$return = $sr_admin->get_same_aspect_ratio_images($images);
					
					$this->ajax_response_data(array('images' => $return));
				break;
				case 'get_addons_sizes':
					$addons = $this->get_val($data, 'addons', array());
					$sizes = $sr_admin->get_addon_sizes($addons);
					
					$this->ajax_response_data(array('addons' => $sizes));
				break;
				case 'save_custom_templates_slidetransitions':
					$return = $this->save_custom_slidetransitions($data);
					if ($return === false || intval($return) === 0) {
						$this->ajax_response_success(__('Slide transition template could not be saved', 'revslider'));
					} else {
						$this->ajax_response_success(__('Slide transition template saved', 'revslider'), array('data' => array('id' => $return)));
					}
				break;
				case 'delete_custom_templates_slidetransitions':
					if ($this->delete_custom_slidetransitions($data)) {
						$this->ajax_response_success(__('Slide transition template deleted', 'revslider'));
					} else {
						$this->ajax_response_error(__('Slide transition template could not be deleted', 'revslider'));
					}
				break;
				case 'create_image_from_raw':
					$mpeg = $this->get_val($data, 'mpeg', '');
					$slideid = $this->get_val($data, 'slideid', 0);
					$bitmap = $this->get_val($data, 'bitmap', '');
					$mpeg = basename($mpeg);
					if(empty($mpeg)) {
						$this->ajax_response_error(__('mpeg not set', 'revslider'));
					}
					
					$return = $this->import_media_raw($mpeg, $slideid, $bitmap);
					if(!is_array($return) && ($return === false || intval($return) === 0)){
						if ($return === false) {
							$this->ajax_response_error(__('Image could not be created', 'revslider'));
						} else {
							$this->ajax_response_error($return);
						}
					}
					if(isset($return['id'])){
						$return['path'] = wp_get_attachment_url($return['id']);
					}
					
					$this->ajax_response_data($return);
				break;
				default:
					$return = ''; //''is not allowed to be added directly in apply_filters(), so its needed like this
					$return = apply_filters('revslider_do_ajax', $return, $action, $data);
					if($return){
						if(is_array($return)){
							if(isset($return['error'])){
								$this->ajax_response_error($return['error']);
							}
							if(isset($return['message'])){
								$this->ajax_response_data(array('message' => $return['message'], 'data' => $return['data']));
							}

							$this->ajax_response_data(array('data' => $return['data']));
						}else{
							$this->ajax_response_success($return);
						}
					}
				break;
			}
		}catch(Exception $e){
			$message = $e->getMessage();
			if(in_array($action, array('preview_slide', 'preview_slider'))){
				echo $message;
				wp_die();
			}
			$this->ajax_response_error($message);
		}

		//it's an ajax action, so exit
		$this->ajax_response_error(__('No response on action', 'revslider'));
		wp_die();
	}

	/**
	 * Ajax handling for frontend, no privileges here
	 */
	public function do_front_ajax_action(){
		global $SR_GLOBALS;
		$error = false;

		$action	= $this->get_request_var('client_action', false);
		$nonce	= $this->get_request_var('nonce');
		$nonce	= (empty($nonce)) ? $this->get_request_var('rs-nonce') : $nonce;

		//if($is_verified){
		switch($action){
			case 'get_full_slider_object':
				$this->get_full_slider_object();
			break;
			case 'get_stream_data':
				$this->get_stream_data();
			break;
			case 'get_modal_data':
				$this->get_slider_modal_data();
			break;
			/**
			 * OLD CALLS
			 **/
			case 'get_transitions':
				$transitions = $this->get_base_transitions();
				$this->ajax_response_data(array('transitions' => $transitions));
			break;
			case 'get_slider_html':
				$alias = $this->get_post_var('alias', '');
				$usage = $this->get_post_var('usage', '');
				$modal = $this->get_post_var('modal', '');
				$layout = $this->get_post_var('layout', '');
				$offset = $this->get_post_var('offset', '');
				$id = intval($this->get_post_var('id', 0));
				
				//check if $alias exists in database, transform it to id
				if($alias !== ''){
					$sr = new RevSliderSlider();
					$id = intval($sr->alias_exists($alias, true));
				}
				
				if($id > 0){
					ob_start();
					global $SR_GLOBALS;
					if($SR_GLOBALS['front_version'] === 6){
						$slider = new RevSliderOutput();
						$slider->set_ajax_loaded();
						$slider_class = $slider->add_slider_to_stage($id, $usage, $layout, $offset, $modal);
					}else{
						$slider = new RevSlider7Output();
						$slider->set_ajax_loaded();
						$slider_class = $slider->add_slider_to_stage($id);
					}
					
					$html = ob_get_contents();
					ob_clean();
					ob_end_clean();
					
					$result = !empty($slider_class) && $html !== '';
					
					if(!$result){
						$error = __('Slider not found', 'revslider');
					}else{
						if($html !== false){
							$htmlid = $slider->get_html_id();
							$return = array('data' => $html, 'waiting' => array(), 'toload' => array(), 'htmlid' => $htmlid);
							$return = apply_filters('revslider_get_slider_html_addition', $return, $slider);
							$this->ajax_response_data($return);
						}else{
							$error = __('Slider not found', 'revslider');
						}
					}
				}else{
					$error = __('No Data Received', 'revslider');
				}
			break;
		}

		if($error !== false){
			$show_error = ($error !== true) ? __('Loading Error', 'revslider') : __('Loading Error: ', 'revslider') . $error;

			$this->ajax_response_error($show_error, false);
		}
		exit;
	}

	public function truncate_v7_tables(){
		$this->check_nonce();
		$this->truncate_v7();
		$this->ajax_response_success(__('V7 Tables Cleared', 'revslider'));
	}

	public function save_slider($data = false){
		global $SR_GLOBALS;
		$this->check_nonce();

		$slider		 = new RevSliderSlider();
		$slide		 = new RevSliderSlide();
		$data		 = $this->get_data($data);
		$slider_id	 = $this->get_val($data, 'id');
		$slides_data = $this->get_val($data, 'slides');
		$slides_data = $this->json_decode_slashes($slides_data);
		
		if($this->_truefalse($this->get_val($data, 'fromSR6')) === true){
			$SR_GLOBALS['use_table_version'] = 7;
			//$save			 = $this->get_val($data, 'save', 'database');
			$title			 = $this->get_val($data, 'title');
			$alias			 = $this->get_val($data, 'alias');
			$slider_data	 = $this->get_val($data, 'settings');
			$slider_id		 = $slider->save_slider_v7($slider_id, $slider_data, $title, $alias);
			//probably kill all v7 slides here first
			if(!empty($slides_data)){
				foreach($slides_data as $id => $_slide){
					$slide->save_slide_v7($id, $_slide, $slider_id);
				}
			}
			$SR_GLOBALS['use_table_version'] = 6;
		}else{
			$slider_id		 = $slider->save_slider($slider_id, $data);
			if(!empty($slides_data)){
				foreach($slides_data as $id => $_slide){
					$slide->save_slide($id, $_slide, $slider_id);
				}
			}
		}

		$cache = RevSliderGlobals::instance()->get('RevSliderCache');
		$cache->clear_transients_by_slider($slider_id);
		
		$this->ajax_response_success(__('Slider Saved as V7 Slider', 'revslider'));
	}
	
	public function set_v7_migration_failed($data = false){
		global $SR_GLOBALS;
		$this->check_nonce();

		$data		 = $this->get_data($data);
		$slider_id	 = $this->get_val($data, 'id');
		$error_text	 = $this->get_val($data, 'text');
		$this->update_v7_migration_failed_map($slider_id, $error_text);
		$this->ajax_response_success(__('Saved', 'revslider'));
	}


	/**
	 * central function to either fill the $_data by REST API or by ajax requests
	 **/
	public function get_data($data = false){
		if($data instanceof WP_REST_Request){
			$_data = $data->get_params('GET');
			$this->set_rest_call();
		}else{
			$_data = $this->get_request_var('data', '', false);
			$_data = ($_data == '') ? array() : $_data;
		}

		$this->set_use_db_version();

		return $_data;
	}

	public function set_use_db_version(){
		global $SR_GLOBALS;

		$SR_GLOBALS['use_table_version'] = get_sr_current_engine();
	}

	public function get_stream_data($data = false){
		$slider	= new RevSliderSlider();
		$slide	= new RevSliderSlide();
		$data	= $this->get_data($data);
		$slider_id = explode(',', $this->get_val($data, 'id'));
		$lang	= $this->get_val($data, 'srlang', 'all');

		if(count($slider_id) > 1){
			$slider->set_gallery_ids($slider_id);
			$slider->set_param('sourcetype', 'specific_posts');
			$slider->set_param(array('source'), array());
			$slider->set_param(array('source', 'type'), 'specific_posts');
		}else{
			$slider_id = $slider_id[0];
			$slider->init_by_id($slider_id, false);
			
			if($slider->inited === false){ //try to get v6|v7 data then
				global $SR_GLOBALS;
				$SR_GLOBALS['use_table_version'] = ($SR_GLOBALS['use_table_version'] === 7) ? 6 : 7;
				
				$slider->init_by_id($slider_id, false);
			}
	
			if($slider->inited === false){
				$this->ajax_response_error(__('Slider could not be loaded', 'revslider'));
			}
		}
		
		//set language if given
		if($lang !== 'all'){
			$slider->change_language($lang);
			$SR_wpml = RevSliderGlobals::instance()->get('RevSliderWpml');
			$SR_wpml->change_lang($lang, false, array(), $slider);
		}

		$stream_data = $slider->get_stream_data();

		return $this->ajax_response_data(array('data' => $stream_data));
	}

	public function get_slider_modal_data($data = false){
		global $SR_GLOBALS;

		$slider	= new RevSliderSlider();
		$data	= $this->get_data($data);
		if($this->REST === true){
			if(isset($data['slider'])){
				if(intval($data['slider']) === 0){
					$data['alias'] = $data['slider'];
				}else{
					$data['id'] = $data['slider'];
				}
			}
		}

		$slider_id		= RevSliderFunctions::esc_attr_deep($this->get_val($data, 'id'));
		$slider_alias	= RevSliderFunctions::esc_attr_deep($this->get_val($data, 'alias', ''));
		$obj			= array(
			'id'	=> '',
			'bg'	=> '',
			'sp'	=> '',
			'addons' => array(),
			'v6v7ids' => array(),
		);

		//allow a fallback to the v6 data here? I guess yes
		if($SR_GLOBALS['use_table_version'] === 7){
			if($slider_alias !== ''){
				if(!$slider->check_alias($slider_alias)) $SR_GLOBALS['use_table_version'] = 6;
			}else{
				if(!$slider->check_slider_id($slider_id)) $SR_GLOBALS['use_table_version'] = 6;
			}
		}

		if($slider_alias !== ''){
			$slider->init_by_alias($slider_alias);
			$slider_id = $slider->get_id();
		}else{
			$slider->init_by_id($slider_id);
		}

		if($SR_GLOBALS['use_table_version'] === 7){
			if($slider->inited === false) $this->ajax_response_error(__('V7 Slider could not inited', 'revslider'));
			
			if($slider->get_param(array('modal', 'cover'), true) === true){
				$obj['bg'] = $slider->get_param(array('modal', 'bg'), 'rgba(0,0,0,0.5)');
				$obj['sp'] = $slider->get_param(array('modal', 'sp'), 1);
			}
		}else{
			if($slider->inited === false) $this->ajax_response_error(__('Modal data could not be loaded', 'revslider'));

			if($slider->get_param(array('modal', 'cover'), true) === true){
				$obj['bg'] = $slider->get_param(array('modal', 'coverColor'), 'rgba(0,0,0,0.5)');
				$obj['sp'] = $slider->get_param(array('modal', 'coverSpeed'), 1);
			}
		}

		$obj['id'] = $slider_id;
		$obj['v6v7ids'] = $this->get_v7_slider_map($slider_id);

		return $this->ajax_response_data($obj);
	}


	public function get_full_slider_object($data = false, $modify = true){
		global $SR_GLOBALS;

		$slider	= new RevSliderSlider();
		$slide	= new RevSliderSlide();
		$data	= $this->get_data($data);

		if($this->REST === true){
			if(isset($data['slider'])){
				if(intval($data['slider']) === 0){
					$data['alias'] = $data['slider'];
				}else{
					$data['id'] = 'slider-'.$data['slider'];
				}
			}
		}
		
		$slide_id		= RevSliderFunctions::esc_attr_deep($this->get_val($data, 'id'));
		$slider_alias	= RevSliderFunctions::esc_attr_deep($this->get_val($data, 'alias', ''));
		$slide_ids		= RevSliderFunctions::esc_attr_deep($this->get_val($data, 'slideid', array()));
		$raw			= RevSliderFunctions::esc_attr_deep($this->get_val($data, 'raw', false));

		if($SR_GLOBALS['use_table_version'] === 7){
			if($slider_alias !== ''){
				if(!$slider->check_alias($slider_alias)) $SR_GLOBALS['use_table_version'] = 6;
			}elseif(strpos($slide_id, 'slider-') !== false){
				$slider_id = str_replace('slider-', '', $slide_id);
				if(!$slider->check_slider_id($slider_id)) $SR_GLOBALS['use_table_version'] = 6;
			}
		}

		if($SR_GLOBALS['use_table_version'] !== 7){
			if($slider_alias !== ''){
				$slider->init_by_alias($slider_alias);
				$slider_id = $slider->get_id();
			}else{
				if(strpos($slide_id, 'slider-') !== false){
					$slider_id = str_replace('slider-', '', $slide_id);
				}else{
					$slide->init_by_id($slide_id);

					$slider_id = $slide->get_slider_id();
					if(intval($slider_id) == 0){
						$this->ajax_response_error(__('Slider could not be loaded', 'revslider'));
					}
				}
				
				$slider->init_by_id($slider_id);
			}

			if($slider->inited === false) $this->ajax_response_error(__('Slider could not be loaded', 'revslider'));

		}else{
			if($slider_alias !== ''){
				$slider->init_by_alias($slider_alias);
				$slider_id = $slider->get_id();
			}else{
				if(strpos($slide_id, 'slider-') !== false){
					$slider_id = str_replace('slider-', '', $slide_id);
				}else{
					$slide->init_by_id($slide_id);

					$slider_id = $slide->get_slider_id();
					if(intval($slider_id) == 0){
						$this->ajax_response_error(__('V7 Slider could not be found', 'revslider'));
					}
				}
				$slider->init_by_id($slider_id);
			}

			if($slider->inited === false) $this->ajax_response_error(__('V7 Slider could not inited', 'revslider'));

		}

		$JSON = $slider->get_full_slider_JSON(false, true, $slide_ids, array(), $raw, $modify);
		
		return $this->ajax_response_data(apply_filters('sr_get_full_slider_object', $JSON, $slider));
	}
	
	/**
	 * echo json ajax response as error
	 * @before: RevSliderBaseAdmin::ajaxResponseError();
	 */
	public function ajax_response_error($message, $data = null){
		$this->ajax_response(false, $message, $data);
	}

	/**
	 * echo ajax success response with redirect instructions
	 * @before: RevSliderBaseAdmin::ajaxResponseSuccessRedirect();
	 */
	public function ajax_response_redirect($message, $url){
		$data = array('is_redirect' => true, 'redirect_url' => $url);

		$this->ajax_response(true, $message, $data);
	}

	/**
	 * echo json ajax response, without message, only data
	 * @before: RevSliderBaseAdmin::ajaxResponseData()
	 */
	public function ajax_response_data($data){
		$data = (gettype($data) == 'string') ? array('data' => $data) : $data;

		return $this->ajax_response(true, '', $data);
	}

	/**
	 * echo ajax success response
	 * @before: RevSliderBaseAdmin::ajaxResponseSuccess();
	 */
	public function ajax_response_success($message, $data = null){

		$this->ajax_response(true, $message, $data);
	}

	/**
	 * echo json ajax response
	 * before: RevSliderBaseAdmin::ajaxResponse
	 * @param bool $success
	 * @param string $message
	 * @param mixed $data
	 */
	private function ajax_response($success, $message, $data = null){
		http_response_code(200);

		$response = array(
			'success' => $success,
			'message' => $message,
		);

		if(!empty($data)){
			if(gettype($data) == 'string'){
				$data = array('data' => $data);
			}

			$response = array_merge($response, $data);
		}

		if($this->is_rest_call()){
			echo json_encode($response);
			exit;
			return new WP_REST_Response($response);
		}else{
			echo json_encode($response);
			wp_die();
		}
	}

}
?>