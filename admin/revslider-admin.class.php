<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderAdmin extends RevSliderFunctionsAdmin {
	private $view			 = 'slider';
	private $user_role		 = 'administrator';
	private $global_settings = array();
	private $screens		 = array(); //holds all RevSlider Relevant screens in it
	private $allowed_views	 = array('sliders', 'slider', 'slide', 'update'); //holds pages, that are allowed to be included
	private $pages			 = array('revslider'); //, 'revslider_navigation', 'rev_addon', 'revslider_global_settings'
	private $dev_mode		 = false;
	private $path_views;
	
	
	/**
	 * START: DEPRECATED FUNCTIONS PRIOR 6.2.0 THAT ARE IN HERE FOR OLD THEMES TO WORK PROPERLY
	 **/
	
	/**
	 * Activate the Plugin through the ThemePunch Servers
	 * @before: RevSliderOperations::checkPurchaseVerification();
	 * @moved to RevSliderLicense::activate_plugin();
	 **/
	public function activate_plugin($code){
		$this->add_deprecation_message('RevSliderAdmin->activate_plugin', 'RevSliderLicense->active_plugin');
		$rs_license = new RevSliderLicense();
		return $rs_license->activate_plugin($code);
	}
	
	
	/**
	 * Deactivate the Plugin through the ThemePunch Servers
	 * @before: RevSliderOperations::doPurchaseDeactivation();
	 * @moved to RevSliderLicense::deactivate_plugin();
	 **/
	public function deactivate_plugin(){
		$this->add_deprecation_message('RevSliderAdmin->deactivate_plugin', 'RevSliderAdmin->deactivate_plugin');
		$rs_license = new RevSliderLicense();
		return $rs_license->deactivate_plugin();
	}
	
	/**
	 * END: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	
	/**
	 * construct admin part
	 **/
	public function __construct(){
		parent::__construct();
		
		if(!file_exists(RS_PLUGIN_PATH.'admin/assets/js/plugins/utils.min.js') && !file_exists(RS_PLUGIN_PATH.'admin/assets/js/modules/editor.min.js')){
			$this->dev_mode = true;
		}
		
		$this->path_views = RS_PLUGIN_PATH . 'admin/views/';
		$this->global_settings = $this->get_global_settings();
		
		$this->set_current_page();
		$this->set_user_role();
		$this->do_update_checks();
		$this->add_actions();
		$this->add_filters();
	}
	
	/**
	 * enqueue all admin styles
	 **/
	public function enqueue_admin_styles(){
		global $pagenow;
		if(!in_array($this->get_val($_GET, 'page'), $this->pages) && !$this->is_edit_page() && (!isset($pagenow) || $pagenow !== 'plugins.php')) return;
		
		$f	 = new RevSliderFunctions();
		$gs	 = $f->get_global_settings();
		$fdl = $f->get_val($gs, 'fontdownload', 'off');
		if($fdl === 'preload'){
			$fonts = array('Open Sans' => 'Open+Sans:wght@300;400;600;700;800', 'Roboto' => 'Roboto:wght@300;400;500;700');//, 'Material Icons' => 'Material+Icons'
			$html = $f->preload_fonts($fonts);
			if(!empty($html)) echo $html;
			echo "\n<style>@font-face {
	font-family: 'Material Icons';
	font-style: normal;
	font-weight: 400;
	src: local('Material Icons'),
	local('MaterialIcons-Regular'),
	url(".RS_PLUGIN_URL_CLEAN."sr6/assets/fonts/material/MaterialIcons-Regular.woff2) format('woff2'),
	url(".RS_PLUGIN_URL_CLEAN."sr6/assets/fonts/material/MaterialIcons-Regular.woff) format('woff'),  
	url(".RS_PLUGIN_URL_CLEAN."sr6/assets/fonts/material/MaterialIcons-Regular.ttf) format('truetype');
}
.material-icons {
	font-family: 'Material Icons';
	font-weight: normal;
	font-style: normal;
		font-size: inherit;
	display: inline-block;  
	text-transform: none;
	letter-spacing: normal;
	word-wrap: normal;
	white-space: nowrap;
	direction: ltr;
	vertical-align: top;
	line-height: inherit;
	/* Support for IE. */
	font-feature-settings: 'liga';
	
	-webkit-font-smoothing: antialiased;
	text-rendering: optimizeLegibility;
	-moz-osx-font-smoothing: grayscale;
}
</style>\n";
		}else{ //off or disabled
			$url_css = $f->modify_fonts_url('https://fonts.googleapis.com/css2?family=');
			$url_material = str_replace('css?', 'icon?', $url_css);
			wp_enqueue_style('rs-open-sans', $url_css.'Open+Sans:wght@300;400;600;700;800');
			wp_enqueue_style('rs-roboto', $url_css.'Roboto');
			wp_enqueue_style('tp-material-icons', $url_material.'Material+Icons');
		}
		
		//wp_enqueue_style('revslider-global-styles', RS_PLUGIN_URL_CLEAN . 'admin/assets/css/global.css', array(), RS_REVISION);
		wp_enqueue_style(array('wp-jquery-ui', 'wp-jquery-ui-core', 'wp-jquery-ui-dialog', 'wp-color-picker'));
		wp_enqueue_style('revbuilder-color-picker-css', RS_PLUGIN_URL_CLEAN . 'admin/assets/css/tp-color-picker.css', array(), RS_REVISION);
	
		wp_enqueue_style('revbuilder-ddTP', RS_PLUGIN_URL_CLEAN . 'admin/assets/css/ddTP.css', array(), RS_REVISION);
		//wp_enqueue_style('RevMirror-css', RS_PLUGIN_URL_CLEAN .'admin/assets/css/RevMirror.css', array(), RS_REVISION);
		wp_enqueue_style('rs-frontend-settings', RS_PLUGIN_URL_CLEAN . 'sr6/assets/css/rs6.css', array(), RS_REVISION);
		wp_enqueue_style('rs-icon-set-fa-icon-', RS_PLUGIN_URL_CLEAN . 'sr6/assets/fonts/font-awesome/css/font-awesome.css', array(), RS_REVISION);
		wp_enqueue_style('rs-icon-set-pe-7s-', RS_PLUGIN_URL_CLEAN . 'sr6/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css', array(), RS_REVISION);
		wp_enqueue_style('revslider-basics-css', RS_PLUGIN_URL_CLEAN . 'admin/assets/css/basics.css', array(), RS_REVISION); //'rs-new-plugin-settings'
		wp_enqueue_style('rs-new-plugin-settings', RS_PLUGIN_URL_CLEAN . 'admin/assets/css/builder.css', array('revslider-basics-css'), RS_REVISION);
		if(is_rtl()){
			wp_enqueue_style('rs-new-plugin-settings-rtl', RS_PLUGIN_URL_CLEAN . 'admin/assets/css/builder-rtl.css', array('rs-new-plugin-settings'), RS_REVISION);
		}
	}
	
	/**
	 * enqueue all admin scripts
	 **/
	public function enqueue_admin_scripts(){
		global $pagenow;
		if(!in_array($this->get_val($_GET, 'page'), $this->pages) && !$this->is_edit_page() && (!isset($pagenow) || $pagenow !== 'plugins.php')) return;

		wp_enqueue_script(array('jquery', 'jquery-ui-core', 'jquery-ui-mouse', 'jquery-ui-accordion', 'jquery-ui-datepicker', 'jquery-ui-dialog', 'jquery-ui-slider', 'jquery-ui-autocomplete', 'jquery-ui-sortable', 'jquery-ui-droppable', 'jquery-ui-tabs', 'jquery-ui-widget', 'wp-color-picker', 'wpdialogs', 'updates'));
		wp_enqueue_script(array('wp-color-picker'));

		//include all media upload scripts
		$this->add_media_upload_includes();

		global $wp_scripts;
		$view = $this->get_val($_GET, 'view');

		wp_enqueue_script('jquery-ui-droppable', array('jquery'), RS_REVISION);
		
		/**
		 * dequeue tp-tools to make sure that always the latest is loaded
		 **/
		if(version_compare($this->get_val($wp_scripts, array('registered', 'tp-tools', 'ver'), '1.0'), RS_TP_TOOLS, '<')){
			wp_deregister_script('tp-tools');
			wp_dequeue_script('tp-tools');
		}

		wp_enqueue_script('tp-tools', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/rbtools.min.js', array(), RS_TP_TOOLS);
		
		if($view == '' && $this->get_val($_GET, 'page') === 'revslider'){ //overview page
			wp_enqueue_script('_tpt', RS_PLUGIN_URL_CLEAN . 'public/js/libs/tptools.js', '', RS_REVISION);
		}

		if($this->dev_mode){
			wp_enqueue_script('revbuilder-admin', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/admin.js', array('jquery'), RS_REVISION, false);
			wp_localize_script('revbuilder-admin', 'RVS_LANG', $this->get_javascript_multilanguage()); //Load multilanguage for JavaScript
			wp_enqueue_script('revbuilder-basics', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/basics.js', array('jquery'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-ddTP', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/plugins/ddTP.js', array('jquery'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-color-picker-js', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/plugins/tp-color-picker.min.js', array('jquery', 'revbuilder-ddTP', 'wp-color-picker'), RS_REVISION);
			wp_enqueue_script('revbuilder-clipboard', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/plugins/clipboard.min.js', array('jquery'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-objectlibrary', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/objectlibrary.js', array('jquery'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-optimizer', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/optimizer.js', array('jquery'), RS_REVISION, false);
		}else{
			wp_enqueue_script('revbuilder-admin', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/admin.min.js', array('jquery'), RS_REVISION, false);
			wp_localize_script('revbuilder-admin', 'RVS_LANG', $this->get_javascript_multilanguage()); //Load multilanguage for JavaScript
			wp_enqueue_script('revbuilder-utils', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/plugins/utils.min.js', array('jquery', 'wp-color-picker'), RS_REVISION, false);
		}
		
		if($view == 'slide' && $this->dev_mode){
			wp_enqueue_script('revbuilder-help', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/helpinit.js', array('jquery', 'revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-toolbar', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/rightclick.js', array('jquery', 'revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-effects', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/timeline.js', array('jquery','revbuilder-admin'), RS_REVISION, false);				
			wp_enqueue_script('revbuilder-panzoom', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.panzoom.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-slideanim', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.slideanims.js', array('jquery','revbuilder-admin'), RS_REVISION, false);		
			wp_enqueue_script('revbuilder-layer', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/layer.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-layertools', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/layertools.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-quick-style', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/quickstyle.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-navigations', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/navigation.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-layeractions', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/layeractions.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-layerlist', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/layerlist.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-slide', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/slide.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder-slider', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/slider.js', array('jquery','revbuilder-admin'), RS_REVISION, false);
			wp_enqueue_script('revbuilder', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/builder.js', array('jquery','revbuilder-admin', 'jquery-ui-sortable'), RS_REVISION, false);
			add_action('admin_print_scripts', array($this, 'add_editor_mode'), 1);
		}elseif($view == 'slide' && !$this->dev_mode){
			wp_enqueue_script('revbuilder-editor', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/editor.min.js', array('jquery', 'revbuilder-admin', 'jquery-ui-sortable'), RS_REVISION, false);
			add_action('admin_print_scripts', array($this, 'add_editor_mode'), 1);
		}

		if($view == '' || $view == 'sliders'){
			if($this->dev_mode){
				wp_enqueue_script('revbuilder-overview', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/overview.js', array('jquery'), RS_REVISION, false);
			}else{
				wp_enqueue_script('revbuilder-overview', RS_PLUGIN_URL_CLEAN . 'admin/assets/js/modules/overview.min.js', array('jquery'), RS_REVISION, false);
			}
			
			if(!file_exists(RS_PLUGIN_PATH.'sr6/assets/js/rs6.min.js')){
				wp_enqueue_script('revmin', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.main.js', 'tp-tools', RS_REVISION, false);
				//if on, load all libraries instead of dynamically loading them
				wp_enqueue_script('revmin-actions', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.actions.js', 'tp-tools', RS_REVISION, false);
				wp_enqueue_script('revmin-carousel', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.carousel.js', 'tp-tools', RS_REVISION, false);
				wp_enqueue_script('revmin-layeranimation', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.layeranimation.js', 'tp-tools', RS_REVISION, false);
				wp_enqueue_script('revmin-navigation', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.navigation.js', 'tp-tools', RS_REVISION, false);
				wp_enqueue_script('revmin-panzoom', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.panzoom.js', 'tp-tools', RS_REVISION, false);
				wp_enqueue_script('revmin-parallax', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.parallax.js', 'tp-tools', RS_REVISION, false);
				wp_enqueue_script('revmin-slideanims', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.slideanims.js', 'tp-tools', RS_REVISION, false);				
				wp_enqueue_script('revmin-video', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.video.js', 'tp-tools', RS_REVISION, false);
			}else{
				wp_enqueue_script('revmin', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/rs6.min.js', array('jquery', 'tp-tools'), RS_REVISION, false);
			}
		}
	}
	
	/**
	 * adds needed JavaScript to the header
	 * to tell the scripts that we are in the editor
	 * @since: 6.4.0
	 **/
	public function add_editor_mode(){
		echo '<script>'."\n";
		echo "var _R_is_Editor = 'true';\n";
		echo '</script>'."\n";
	}

	/**
	 * add all js and css needed for media upload
	 */
	protected static function add_media_upload_includes(){
		if(function_exists('wp_enqueue_media')) wp_enqueue_media();

		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_style('thickbox');
	}
	
	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain(){
		load_plugin_textdomain('revslider', false, dirname(RS_PLUGIN_SLUG_PATH) . '/languages/');
		load_plugin_textdomain('revsliderhelp', false, dirname(RS_PLUGIN_SLUG_PATH) . '/languages/');
	}

	/**
	 * set the user role, to restrict plugin usage to certain groups
	 * @since: 6.0
	 **/
	public function set_user_role(){
		$this->user_role = $this->get_val($this->global_settings, 'permission', 'administrator');
		if($this->user_role === 'admin') $this->user_role = 'administrator';
		if(!in_array($this->user_role, array('author', 'editor', 'administrator'))) $this->user_role = 'administrator';
		
		switch($this->user_role){
			case 'author':
				$this->user_role = 'edit_published_posts';
			break;
			case 'editor':
				$this->user_role = 'edit_pages';
			break;
			default:
			case 'admin':
			case 'administrator':
				$this->user_role = 'manage_options';
			break;
		}
	}

	/**
	 * return the user role
	 **/
	public function get_user_role(){
		return $this->user_role;
	}

	/**
	 * add the admin pages to the WordPress backend
	 * @since: 6.0
	 **/
	public function add_admin_pages(){
		//$this->screens[] = add_menu_page('Slider Revolution', 'Slider Revolution', $this->user_role, 'revslider', array($this, 'display_admin_page'), 'dashicons-update');

		$tp_premium = $this->_truefalse(get_option('revslider-valid', 'false'));
		$tp_ticket = ($tp_premium !== true) ? ' class="revslider_premium"' : '';

		$this->screens[] = add_menu_page('Slider Revolution', 'Slider Revolution', $this->user_role, 'revslider', null, 'dashicons-update');
		$this->screens[] = add_submenu_page('revslider', __('Slider Revolution - Overview', 'revslider'), __('Overview', 'revslider'), $this->user_role, 'revslider', array($this, 'display_admin_page'));
		$this->screens[] = add_submenu_page('revslider', '', __('<div id="revslider_manual_link">Getting Started</div>', 'revslider'), $this->user_role, 'revslider-documentation', array($this, 'display_external_redirects'));
		$this->screens[] = add_submenu_page('revslider', '', __('<div id="revslider_helpcenter_link">Help Center</div>', 'revslider'), $this->user_role, 'revslider-help-center', array($this, 'display_external_redirects'));
		$this->screens[] = add_submenu_page('revslider', '', __('<div id="revslider_templates_link">Templates</div>', 'revslider'), $this->user_role, 'revslider-templates', array($this, 'display_external_redirects'));
		$this->screens[] = add_submenu_page('revslider', '', __('<div id="revslider_ticket_link"'. $tp_ticket .'>Premium Support</div>', 'revslider'), $this->user_role, 'revslider-ticket', array($this, 'display_external_redirects'));
		
		if($tp_premium !== true){
			$this->screens[] = add_submenu_page('revslider', '', '<div id="revslider_premium_link"><span class="dashicons dashicons-star-filled" style="font-size: 17px"></span> '.__('Go Premium', 'revslider')."</div>", $this->user_role, 'revslider-buy-license', array($this, 'display_external_redirects'));
		}
	}

	/**
 	 * opens the external sliderrevolution.com menu URLs in a blank tab
 	 * @since 6.5.11
 	 */
	  public function add_js_menu_open_blank() {
		echo '<script>
				jQuery(document).ready(function(){
					jQuery("#revslider_manual_link, #revslider_helpcenter_link, #revslider_templates_link, #revslider_ticket_link, #revslider_premium_link").parent().attr("target","_blank");
				});
			</script>';
	}

	/**
	 * redirect to external URLs
	 * @since 6.5.10
	 */
	public function display_external_redirects() {
		$page = $this->get_val($_GET, 'page');
		if(empty($page)) return;

		$tp_premium = get_option('revslider-valid', 'false');

		switch($page){
			case 'revslider-buy-license':
				wp_redirect('https://account.sliderrevolution.com/portal/pricing/?utm_source=admin&utm_medium=menu&utm_campaign=srusers&utm_content=buykey');
				exit;
			break;
			case 'revslider-documentation':
				wp_redirect('https://www.sliderrevolution.com/manual/quick-setup-register-your-plugin/?utm_source=admin&utm_medium=menu&utm_campaign=srusers&utm_content=usedocumentation&premium='.$tp_premium);
				exit;
			break;
			case 'revslider-help-center':
				wp_redirect('https://www.sliderrevolution.com/help-center?utm_source=admin&utm_medium=menu&utm_campaign=srusers&utm_content=help&premium='.$tp_premium);
				exit;
			break;
			case 'revslider-templates':
				wp_redirect('https://www.sliderrevolution.com/examples?utm_source=admin&utm_medium=menu&utm_campaign=srusers&utm_content=templates&premium='.$tp_premium);
				exit;
			break;
			case 'revslider-ticket':
				wp_redirect('https://support.sliderrevolution.com?utm_source=admin&utm_medium=menu&utm_campaign=srusers&utm_content=support&premium='.$tp_premium);
				exit;
			break;
			default:
			break;
		}
		return;
	}
	
	
	/**
	 * add wildcards metabox variables to posts
	 * @var $post_types: null = all, post = only posts
	 */
	public function add_slider_meta_box($post_types = null){
		try {
			$post_types = array();
			add_meta_box('slider_revolution_metabox', 'Slider Revolution', array('RevSliderAdmin', 'add_meta_box_content'), $post_types, 'side', 'default');
		} catch (Exception $e){}
	}

	/**
	 * on add metabox content
	 */
	public static function add_meta_box_content($post, $boxData){
		call_user_func(array('RevSliderAdmin', 'custom_post_fields_output'));
	}

	/**
	 *  custom output function
	 */
	public static function custom_post_fields_output(){
		$slider = new RevSliderSlider();
		$output = array();
		$output['default'] = 'default';

		$meta = get_post_meta(get_the_ID(), 'slide_template', true);
		$meta = ($meta == '') ? 'default' : $meta;

		$page_bg = get_post_meta(get_the_ID(), 'rs_page_bg_color', true);
		$page_bg = ($page_bg == '') ? '' : $page_bg;

		$blank = get_page_template_slug(get_the_ID()) == "../public/views/revslider-page-template.php";
		$blankcheck = $blank ? 'checked' : '';
		$hide_page_bg =  $blank ? '' : 'style="display:none;"';
		
		
		$slides = $slider->get_sliders_with_slides_short('template');
		$output = $output + $slides; //union arrays

		$latest_version	= get_option('revslider-latest-version', RS_REVISION);

		?>
		<ul class="revslider_settings _TPRB_">
			<li id="slide_template_row">
				<label class="rs_wp_ppset" for="revslider_blank_template"><?php _e('Blank Template','revslider'); ?></label><input id="rs_blank_template" name="rs_blank_template" <?php echo $blankcheck;?> class="" type="checkbox" >
			</li>
			<li id="slide_template_row">
				<div id="rs_page_bg_color_column" class="" <?php echo $hide_page_bg;?>>
					<label class="rs_wp_ppset"><?php _e('Page Color', 'revslider');?></label><input type="text" data-editing="<?php _e('Background Color', 'revslider');?>" name="rs_page_bg_color" id="rs_page_bg_color" class="my-color-field" value="<?php echo $page_bg; ?>">					
				</div>
				<div class="clear"></div>				
			</li>
			<li id="slide_template_row">				
				<label class="rs_wp_ppset" id="slide_template_text"><?php _e('Slide Template', 'revslider');?></label><select style="max-width:82px" name="slide_template" id="slide_template">
				<?php
				foreach($output as $handle => $name){
					echo '<option ' . selected($handle, $meta) . ' value="' . $handle . '">' . $name . '</option>';
				}
				?></select>
			</li>
			<li id="slide_template_row" style="margin-top:40px">
				<solidiconbox><i class="material-icons">flag</i></solidiconbox><div class="pli_twoline_wp"><div class="pli_subtitle"><?php _e('Installed Version', 'revslider');?></div><div class="dynamicval pli_subtitle"><?php echo RS_REVISION; ?></div></div>
				<div class="div5"></div>
				<solidiconbox id="available_version_icon"><i class="material-icons">cloud_download</i></solidiconbox><div id="available_version_content" class="pli_twoline_wp"><div class="pli_subtitle"><?php _e('Available Version', 'revslider');?></div><div class="available_latest_version dynamicval pli_subtitle"><?php echo $latest_version; ?></div></div>				
			</li>
			<li>
				<div class="rs_wp_plg_act_wrapper"><span><?php _e('Unlock All Features', 'revslider');?></span></div>
			</li>
		</ul>
		
		<?php
	}
	
	
	
	/**
	 * 
	 * on save post meta. Update metaboxes data from post, add it to the post meta 
	 * @before: RevSliderBaseAdmin::onSavePost();
	 */
	public static function on_save_post(){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');

		$post_id = $f->get_post_var('ID');

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id; //protection against autosave
		if(empty($post_id)) return false;
		
		// Slide Template
		$slide_template = $f->get_post_var('slide_template');
		if(in_array($slide_template, array('', 'default'))){
			delete_post_meta($post_id, 'slide_template');
		}else{
			update_post_meta($post_id, 'slide_template', $slide_template);
		}

		// Blank Page Template Background Color
		$rs_page_bg_color = $f->get_post_var('rs_page_bg_color');
		if(strtolower($rs_page_bg_color) === '#ffffff'){
			delete_post_meta($post_id, 'rs_page_bg_color');
		}else{
			update_post_meta($post_id, 'rs_page_bg_color', $rs_page_bg_color);
		}

		// Set/Unset Blank Template depending on Blank Template Switch
		$rs_blank_template = $f->get_post_var('rs_blank_template');
		if(empty($rs_blank_template) && !empty($rs_page_bg_color) && get_post_meta($post_id, '_wp_page_template', true) == '../public/views/revslider-page-template.php'){
			update_post_meta($post_id, '_wp_page_template','');
		}
		if(!empty($rs_blank_template) &&  $rs_blank_template == 'on'){
			update_post_meta($post_id, '_wp_page_template','../public/views/revslider-page-template.php');
		}
	}
	
	
	/**
	 * we dont want to show notices in our plugin
	 **/
	public function hide_notices(){
		if(in_array($this->get_val($_GET, 'page'), $this->pages)){
			remove_all_actions('admin_notices');
		}
	}

	/**
	 * check if we need to search for updates, if yes. Do them
	 **/
	private function do_update_checks(){
		$upgrade	= new RevSliderUpdate(RS_REVISION);
		$library	= new RevSliderObjectLibrary();
		$template	= new RevSliderTemplate();
		
		$uol = isset($_REQUEST['update_object_library']);
		$library->_get_list($uol);
		
		$us = isset($_REQUEST['update_shop']);
		$template->_get_template_list($us);

		$upgrade->force = in_array($this->get_val($_REQUEST, 'checkforupdates', 'false'), array('true', true), true);
		$upgrade->_retrieve_version_info();
		$upgrade->add_update_checks();
	}

	/**
	 * Add Classes to the WordPress body
	 * @since    6.0
	 * @param string $classes
	 * @return string
	 */
	function modify_admin_body_class($classes){
		$classes .= ($this->get_val($_GET, 'page') == 'revslider' && $this->get_val($_GET, 'view') == 'slide') ? ' rs-builder-mode' : '';
		$classes .= ($this->_truefalse($this->get_val($this->global_settings, 'highContrast', false)) === true && $this->get_val($_GET, 'page') === 'revslider') ? ' rs-high-contrast' : '';
		
		return $classes;
	}


	/**
	 * Add all actions that the backend needs here
	 **/
	public function add_actions(){
		global $pagenow;
		
		$cache = RevSliderGlobals::instance()->get('RevSliderCache');
		
		add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
		add_action('admin_head', array($this, 'hide_notices'), 1);
		add_action('admin_menu', array($this, 'add_admin_pages'));
		add_action('admin_init', array($this, 'display_external_redirects'));
		add_action('admin_head', array($this, 'add_js_menu_open_blank'));
		add_action('add_meta_boxes', array($this, 'add_slider_meta_box'));
		add_action('save_post', array($this, 'on_save_post'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
		
		add_action('save_post', array($cache, 'check_for_post_transient_deletion'));
		add_action('future_to_publish', array($cache, 'check_for_post_transient_deletion'));
		add_action('publish_post', array($cache, 'check_for_post_transient_deletion'));
		add_action('publish_future_post', array($cache, 'check_for_post_transient_deletion'));
		
		if(isset($pagenow) && $pagenow == 'plugins.php'){
			add_action('admin_notices', array($this, 'add_plugins_page_notices'));
			if($this->_truefalse(get_option('revslider-valid', 'false')) === false){
				add_filter('plugin_action_links_' . RS_PLUGIN_SLUG_PATH, array($this, 'add_plugin_action_links'));
			}
		}
		
		add_action('admin_init', array($this, 'merge_addon_notices'), 99);
		add_action('admin_init', array($this, 'add_suggested_privacy_content'), 15);
		add_action('admin_init', array($this, 'open_welcome_page'));
		
		$instagram = RevSliderGlobals::instance()->get('RevSliderInstagram');
		$instagram->add_actions();

		$facebook = RevSliderGlobals::instance()->get('RevSliderFacebook');
		$facebook->add_actions();
	}

	/**
	 * Add all filters that the backend needs here
	 **/
	public function add_filters(){
		add_filter('admin_body_class', array($this, 'modify_admin_body_class'));
		add_filter('plugin_locale', array($this, 'change_lang'), 10, 2);
	}
	
	/**
	 * Change the language of the Slider Backend even if WordPress is set to be a different language
	 * @since: 6.1.6
	 **/
	public function change_lang($locale, $domain = ''){
		return (in_array($domain, array('revslider', 'revsliderhelp'), true)) ? $this->get_val($this->global_settings, 'lang', 'default') : $locale;
	}

	/**
	 * merge the revslider addon notices into one bigger notice
	 * @since: 2.2.0
	 **/
	public function merge_addon_notices(){
		global $wp_filter;
		
		if(!isset($wp_filter['admin_notices'])) return;
		if(!isset($wp_filter['admin_notices']->callbacks)) return;
		
		global $SR_GLOBALS;
		$slugs = array(
			'Revslider_404_Addon_Verify', 'RsAddOnBackupNotice', 'RsAddOnBeforeAfterNotice', 'RsAddOnBubblemorphNotice', 'Revslider_Domain_Switch_Addon_Verify',
			'RsAddOnDuotoneNotice', 'RsAddOnExplodinglayersNotice', 'Revslider_Featured_Addon_Verify', 'RsAddOnFilmstripNotice', 'Revslider_Gallery_Addon_Verify',
			'RsAddOnLiquideffectNotice', 'Revslider_Login_Addon_Verify', 'Revslider_Maintenance_Addon_Verify', 'RsAddOnMousetrapNotice', 'RsAddOnPaintbrushNotice',
			'RsAddOnPanoramaNotice', 'RsAddOnParticlesNotice', 'RsAddOnPolyfoldNotice', 'Revslider_Prev_Next_Addon_Verify', 'RsAddOnRefreshNotice',
			'Revslider_Related_Posts_Addon_Verify', 'RsAddOnRevealerNotice', 'RsAddOnShapebuilderNotice', 'Revslider_Sharing_Addon_Verify', 'RsAddOnSliceyNotice',
			'RsAddOnSnowNotice', 'RsAddOnSunbeamNotice', 'RsAddOnTypewriterNotice', 'Revslider_Weather_Addon_Verify', 'Revslider_Whiteboard_Addon_Verify',
			'Revslider_Whiteboard_Addon_Verify'
		);
	
		foreach($wp_filter['admin_notices']->callbacks as $k => $o){
			if(!empty($o)){
				foreach($o as $ok => $f){
					if(!isset($f['function'])) continue;
					if(!is_array($f['function'])) continue;
					if(!isset($f['function'][0])) continue;
					if(!is_object($f['function'][0])) continue;
					
					
					$class = get_class($f['function'][0]);
					if(in_array($class, $slugs, true)){
						unset($wp_filter['admin_notices']->callbacks[$k][$ok]);
						$SR_GLOBALS['addon_notice_merged']++;
					}
				}
			}
		}

		if($SR_GLOBALS['addon_notice_merged'] > 0) add_action('admin_notices', array($this, 'add_addon_plugins_page_notices'));
	}
	
	/**
	 * add addon merged notices
	 * @since: 6.2.0
	 **/
	public function add_addon_plugins_page_notices(){
		?>
		<div class="error below-h2 soc-notice-wrap revaddon-notice" style="display: none;">
			<p><?php echo __('Action required for Slider Revolution AddOns: Please <a href="https://www.sliderrevolution.com/manual-section/manual/getting-started/quick-setup/" target="_blank" rel="noopener">install</a>/<a href="https://www.sliderrevolution.com/manual-section/manual/getting-started/quick-setup/register-plugin/" target="_blank" rel="noopener">activate</a>/<a href="https://www.sliderrevolution.com/manual-section/manual/getting-started/quick-setup/update-plugin/" target="_blank" rel="noopener">update</a> Slider Revolution</a>', 'revslider'); ?><span data-addon="rs-addon-notice" data-noticeid="rs-addon-merged-notices" style="float: right; cursor: pointer" class="revaddon-dismiss-notice dashicons dashicons-dismiss"></span></p>
		</div>
		<?php
	}

	/**
	 * add plugin notices to the Slider Revolution Plugin at the overview page of plugins
	 **/
	public static function add_plugins_page_notices(){
		$plugins = get_plugins();

		foreach($plugins as $plugin_id => $plugin){
			$slug = dirname($plugin_id);
			if(empty($slug) || $slug !== 'revslider') continue;
			
			if(get_option('revslider-valid', 'false') == 'false' && version_compare(get_option('revslider-latest-version', RS_REVISION), $plugin['Version'], '>')){
				add_action('after_plugin_row_' . $plugin_id, array('RevSliderAdmin', 'show_purchase_notice'), 10, 3);
				add_action('admin_footer', array('RevSliderAdmin', 'add_ajax_footer_functionality'));
			}

			break;
		}
	}

	/**
	 * Show message for activation benefits
	 **/
	public static function show_purchase_notice($plugin_file, $plugin_data, $plugin_status){
		$wp_list_table		= _get_list_table( 'WP_Plugins_List_Table' );
		$rs_latest_version	= get_option('revslider-latest-version', RS_REVISION);
		$revision			= str_replace('.', '-', $rs_latest_version);
		?>
		<tr class="plugin-update-tr active">
            <td colspan="<?php echo $wp_list_table->get_column_count(); ?>" class="plugin-update colspanchange">
                <div class="update-message notice inline notice-warning notice-alt">
				<p><?php _e('There is a new version (<a href="https://www.sliderrevolution.com/documentation/changelog/?utm_source=admin&utm_medium=wpplugins&utm_campaign=srusers&utm_content=updateinfo#'.$revision.'" target="_blank">'.$rs_latest_version.'</a>) of Slider Revolution available. To update directly <a href="javascript:;" onclick="RVS.F.showRegisterSliderInfo();">register your license key now</a> or <a href="https://account.sliderrevolution.com/portal/pricing/?utm_source=admin&utm_medium=wpplugins&utm_campaign=srusers&utm_content=updateinfo" target="_blank">purchase a new license key</a> to access <a href="https://www.sliderrevolution.com/premium-slider-revolution/?utm_source=admin&utm_medium=wpplugins&utm_campaign=srusers&utm_content=updateinfo" target="_blank">all premium features</a>.', 'revslider'); ?></p>
                </div>
			</td>
        </tr>
		<style>tr[data-slug="slider-revolution"] td, tr[data-slug="slider-revolution"] th { box-shadow: none!important} #revslider-update{display: none;}</style>
		<?php
	}
	
	/**
	 * add a go premium button to the plugins page for Slider Revolution
	 **/
	public function add_plugin_action_links($links){
		$links['go_premium'] = '<a href="https://account.sliderrevolution.com/portal/pricing/?utm_source=admin&utm_medium=button&utm_campaign=srusers&utm_content=buykey" target="_blank" style="color: #F7345E; font-weight: 700;">'.__('Go Premium', 'revslider').'</a>';

		return $links;
	}

	/**
	 * Add the suggested privacy policy text to the policy postbox.
	 */
	public function add_suggested_privacy_content() {
		if(function_exists('wp_add_privacy_policy_content')){
			$content = $this->get_default_privacy_content();
			wp_add_privacy_policy_content(__('Slider Revolution'), $content);
		}
	}
	
	/**
	 * Return the default suggested privacy policy content.
	 *
	 * @return string The default policy content.
	 */
	public function get_default_privacy_content(){
		return __('<h2>In case you’re using Google Web Fonts (default) or playing videos or sounds via YouTube or Vimeo in Slider Revolution we recommend to add the corresponding text phrase to your privacy police:</h2>
		<h3>YouTube</h3> <p>Our website uses plugins from YouTube, which is operated by Google. The operator of the pages is YouTube LLC, 901 Cherry Ave., San Bruno, CA 94066, USA.</p> <p>If you visit one of our pages featuring a YouTube plugin, a connection to the YouTube servers is established. Here the YouTube server is informed about which of our pages you have visited.</p> <p>If you\'re logged in to your YouTube account, YouTube allows you to associate your browsing behavior directly with your personal profile. You can prevent this by logging out of your YouTube account.</p> <p>YouTube is used to help make our website appealing. This constitutes a justified interest pursuant to Art. 6 (1) (f) DSGVO.</p> <p>Further information about handling user data, can be found in the data protection declaration of YouTube under <a href="https://www.google.de/intl/de/policies/privacy" target="_blank" rel="noopener">https://www.google.de/intl/de/policies/privacy</a>.</p>
		<h3>Vimeo</h3> <p>Our website uses features provided by the Vimeo video portal. This service is provided by Vimeo Inc., 555 West 18th Street, New York, New York 10011, USA.</p> <p>If you visit one of our pages featuring a Vimeo plugin, a connection to the Vimeo servers is established. Here the Vimeo server is informed about which of our pages you have visited. In addition, Vimeo will receive your IP address. This also applies if you are not logged in to Vimeo when you visit our plugin or do not have a Vimeo account. The information is transmitted to a Vimeo server in the US, where it is stored.</p> <p>If you are logged in to your Vimeo account, Vimeo allows you to associate your browsing behavior directly with your personal profile. You can prevent this by logging out of your Vimeo account.</p> <p>For more information on how to handle user data, please refer to the Vimeo Privacy Policy at <a href="https://vimeo.com/privacy" target="_blank" rel="noopener">https://vimeo.com/privacy</a>.</p>
		<h3>Google Web Fonts</h3> <p>For uniform representation of fonts, this page uses web fonts provided by Google. When you open a page, your browser loads the required web fonts into your browser cache to display texts and fonts correctly.</p> <p>For this purpose your browser has to establish a direct connection to Google servers. Google thus becomes aware that our web page was accessed via your IP address. The use of Google Web fonts is done in the interest of a uniform and attractive presentation of our plugin. This constitutes a justified interest pursuant to Art. 6 (1) (f) DSGVO.</p> <p>If your browser does not support web fonts, a standard font is used by your computer.</p> <p>Further information about handling user data, can be found at <a href="https://developers.google.com/fonts/faq" target="_blank" rel="noopener">https://developers.google.com/fonts/faq</a> and in Google\'s privacy policy at <a href="https://www.google.com/policies/privacy/" target="_blank" rel="noopener">https://www.google.com/policies/privacy/</a>.</p>
		<h3>SoundCloud</h3><p>On our pages, plugins of the SoundCloud social network (SoundCloud Limited, Berners House, 47-48 Berners Street, London W1T 3NF, UK) may be integrated. The SoundCloud plugins can be recognized by the SoundCloud logo on our site.</p>
			<p>When you visit our site, a direct connection between your browser and the SoundCloud server is established via the plugin. This enables SoundCloud to receive information that you have visited our site from your IP address. If you click on the “Like” or “Share” buttons while you are logged into your SoundCloud account, you can link the content of our pages to your SoundCloud profile. This means that SoundCloud can associate visits to our pages with your user account. We would like to point out that, as the provider of these pages, we have no knowledge of the content of the data transmitted or how it will be used by SoundCloud. For more information on SoundCloud’s privacy policy, please go to https://soundcloud.com/pages/privacy.</p><p>If you do not want SoundCloud to associate your visit to our site with your SoundCloud account, please log out of your SoundCloud account.</p>', 'revslider');
	}

	/**
	 * Add functionality to the footer to do ajax requests outside of revslider pages
	 **/
	public static function add_ajax_footer_functionality(){
		?>
		<script>
			window.RVS = window.RVS === undefined ? {F:{}, C:{}, ENV:{}, LIB:{}, V:{}, S:{}, DOC:jQuery(document), WIN:jQuery(window)} : window.RVS;
			RVS.ENV.nonce			= '<?php echo wp_create_nonce('revslider_actions'); ?>';
			RVS.ENV.slug			= '<?php echo RS_PLUGIN_SLUG; ?>';
			RVS.ENV.plugin_dir		= 'revslider';
			RVS.ENV.ajax_pre		= 'rs';
		</script>
		<!-- WAIT A MINUTE OVERLAY CONTAINER -->
		<div id="waitaminute" class="_TPRB_">
			<div class="waitaminute-message"><i class="eg-icon-emo-coffee"></i><br><?php _e('Please Wait...', 'revslider'); ?></div>
		</div>
		<?php
	}

	/**
	 * echo json ajax response as error
	 */
	public function ajax_response_error($message, $data = null){
		$this->ajax_response(false, $message, $data);
	}

	/**
	 * echo ajax success response with redirect instructions
	 */
	public function ajax_response_redirect($message, $url){
		$data = array('is_redirect' => true, 'redirect_url' => $url);

		$this->ajax_response(true, $message, $data);
	}

	/**
	 * echo json ajax response, without message, only data
	 */
	public function ajax_response_data($data){
		$data = (gettype($data) == 'string') ? array('data' => $data) : $data;

		$this->ajax_response(true, '', $data);
	}

	/**
	 * echo ajax success response
	 */
	public function ajax_response_success($message, $data = null){
		$this->ajax_response(true, $message, $data);
	}

	/**
	 * echo json ajax response
	 */
	private function ajax_response($success, $message, $data = null){

		$response = array(
			'success' => $success,
			'message' => $message,
		);

		if(!empty($data)){
			if(gettype($data) == 'string') $data = array('data' => $data);
			$response = array_merge($response, $data);
		}

		echo json_encode($response);

		wp_die();
	}

	
	/**
	 * set the page that should be shown
	 **/
	private function set_current_page(){
		$this->view = $this->get_get_var('view', 'sliders');
	}

	/**
	 * include/display the previously set page
	 * only allow certain pages to be showed
	 **/
	public function display_admin_page(){
		try{
			if(!in_array($this->view, $this->allowed_views)) $this->throw_error(__('Bad Request', 'revslider'));
			
			switch($this->view){ //switch URLs to corresponding php files
				case 'slide':
					$view = 'builder';
				break;
				case 'sliders':
				default:
					$view = 'overview';
				break;
			}

			$this->validate_filepath($this->path_views . $view . '.php', 'View');

			require($this->path_views . 'header.php');
			require($this->path_views . $view . '.php');
			require($this->path_views . 'footer.php');

		}catch(Exception $e){
			$this->show_error($this->view, $e->getMessage());
		}
	}

	public function open_welcome_page(){
		if(!get_transient('_revslider_welcome_screen_activation_redirect')) return;
		if(is_network_admin() || isset($_GET['activate-multi'])) return;
		
		delete_transient('_revslider_welcome_screen_activation_redirect');

		update_option('rs_cache_overlay', '1.0.0');
		wp_safe_redirect(add_query_arg(array('page' => 'revslider'), admin_url('index.php')));
	}

	/**
	 * show an nice designed error
	 **/
	public function show_error($view, $message){
		echo '<div class="rs-error">';
		echo __('Slider Revolution encountered the following error: ', 'revslider');
		echo esc_attr($view);
		echo ' - Error: <span>';
		echo esc_attr($message);
		echo '</span>';
		echo '</div>';
		exit;
	}
	
	
	/**
	 * validate that some file exists, if not - throw error
	 * @before: RevSliderFunctions::validateFilepath
	 */
	public function validate_filepath($filepath, $prefix = null){
		if(file_exists($filepath) == true) return true;
		
		$prefix	 = ($prefix == null) ? 'File' : $prefix;
		$message = $prefix.' '.esc_attr($filepath).' not exists!';
		
		$this->throw_error($message);
	}
	
	
	/**
	 * Create a temporary fake page/post
	 * @since: 6.0
	 **/
	public function create_fake_post($content, $title = 'Slider Revolution'){
		$post				 = new stdClass();
		$post->ID			 = -1;
		$post->post_author	 = get_current_user_id();
		$post->post_date	 = current_time('mysql');
		$post->post_date_gmt = current_time('mysql', 1);
		$post->post_title	 = $title;
		$post->post_content	 = $content;
		$post->post_status	 = 'publish';
		$post->comment_status = 'closed';
		$post->ping_status	 = 'closed';
		$post->post_name	 = 'rs-fake-page-' . rand(1, 99999); //append random number to avoid clash
		$post->post_type	 = 'page';
		$post->filter		 = 'raw'; //important
		
		//$post->post_meta		= new stdClass();
		//$post->post_meta->_wp_page_template= '../public/views/revslider-page-template.php';
		
		//Convert to WP_Post object
		$wp_post = new WP_Post($post);
		//Add the fake post to the cache
		wp_cache_add(-1, $wp_post, 'posts');
		
		global $wp, $wp_query;

		// Update the main query
		$wp_query->queried_object_id = -1;
		$wp_query->post				 = $wp_post;
		$wp_query->posts			 = array($wp_post);
		$wp_query->queried_object	 = $wp_post;
		$wp_query->found_posts		 = 1;
		$wp_query->post_count		 = 1;
		$wp_query->max_num_pages	 = 1;
		$wp_query->is_page			 = true;
		$wp_query->is_singular		 = true;
		$wp_query->is_single		 = false;
		$wp_query->is_attachment	 = false;
		$wp_query->is_archive		 = false;
		$wp_query->is_category		 = false;
		$wp_query->is_tag			 = false;
		$wp_query->is_tax			 = false;
		$wp_query->is_author		 = false;
		$wp_query->is_date			 = false;
		$wp_query->is_year			 = false;
		$wp_query->is_month			 = false;
		$wp_query->is_day			 = false;
		$wp_query->is_time			 = false;
		$wp_query->is_search		 = false;
		$wp_query->is_feed			 = false;
		$wp_query->is_comment_feed	 = false;
		$wp_query->is_trackback		 = false;
		$wp_query->is_home			 = false;
		$wp_query->is_embed			 = false;
		$wp_query->is_404			 = false;
		$wp_query->is_paged			 = false;
		$wp_query->is_admin			 = false;
		$wp_query->is_preview		 = false;
		$wp_query->is_robots		 = false; 
		$wp_query->is_posts_page	 = false;
		$wp_query->is_post_type_archive	= false;
		
		//Update globals
		$GLOBALS['wp_query'] = $wp_query;
		$wp->register_globals();
		
		return $wp_post;
	}
	
	
	/**
	 * esc attr recursive
	 * @since: 6.0
	 */
	public static function esc_js_deep($value){
		$value = is_array($value) ? array_map(array('RevSliderAdmin', 'esc_js_deep'), $value) : esc_js($value);
		
		return $value;
	}

}