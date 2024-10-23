<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/ 
 * @copyright 2024 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSlider7Output extends RevSliderFunctions {

	public $zIndex				= 1;
	public $caching				= false;
	public $html_id;			//holds the current html id
	public $slider;				//holds the current slider
	public $slider_v7;			//holds the current slider in v7
	public $slide;				//holds the current slide
	public $slides;				//holds the current slides of the slider
	public $slides_v7;			//holds the current slides of the slider
	public $layers;				//holds the current layers of a slide
	public $layer;				//holds the current used layer
	public $stream_data			= array(); //hilds the stream data, if we are a post/stream			
	public $layer_depth			= '';
	public $static_slide		= array();
	public $revapi;				//holds the current JavaScript revapi
	public $slider_id			= 0; //holds the current slider id
	public $uid;				//holds the current layer unique id
	public $slide_id;			//holds the current slide id of a slide
	public $images 				= array(); //holds all images
	public $gallery_ids			= array();
	public $language			= 'all';

	public $offset 				= '';
	public $modal 				= '';
	public $usage 				= '';
	public $sc_layout			= '';
	public $ajax_loaded			= false;
	
	public $rs_module_open		= false;
	public $rs_module_closed	= false;
	
	public $enabled_sizes		= array();
	public $adv_resp_sizes		= array();
	public $icon_sets			= array();
	public $custom_order		= array();
	public $custom_settings		= array();
	public $custom_skin			= '';
	public $container_mode		= '';

	public $console_exception	= false;
	public $preview_mode		= false;
	public $add_to				= ''; //if set, the Slider will only be added if the current page/post meets what is into this variable

	public $global_settings     = false;

	public function __construct(){
		parent::__construct();
		$this->global_settings = $this->get_global_settings();
	}

	/**
	 * START: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	
	/**
	 * old version of check_add_to()
	 **/
	public static function isPutIn($empty_is_false = false){
		$o = new RevSlider7Output();
		$o->add_deprecation_message('isPutIn', 'check_add_to');
		return $o->check_add_to($empty_is_false);
	}
	
	/**
	 * END: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/

	/**
	 * get the language
	 */
	public function get_language(){
		return apply_filters('revslider_get_language', $this->language, $this);
	}
	
	/**
	 * set the language
	 */
	public function change_language($language){
		$this->language = apply_filters('revslider_change_language', $language, $this);
	}

	public function add_slider_to_stage($sid){
		global $SR_GLOBALS;
		
		do_action('revslider_add_slider_to_stage_pre', $sid, $this);

		if(!$this->check_add_to()) return false;

		$locale = setlocale(LC_NUMERIC, 0);
		if($locale !== 'C') setlocale(LC_NUMERIC, 'C');

		$this->set_slider_id($sid);
		$this->add_slider_base();
		
		if($locale !== 'C') setlocale(LC_NUMERIC, $locale);
		
		do_action('revslider_add_slider_to_stage_post', $sid, $this);

		return $this->get_slider();
	}

	/**
	 * get the last slider after the output
	 */
	public function get_slider(){
		return apply_filters('revslider_get_slider', $this->slider, $this);
	}

	/**
	 * get the current slider_id
	 */
	public function get_slider_id(){
		return apply_filters('revslider_get_slider_id', $this->slider_id, $this);
	}

	/**
	 * set the current slider_id
	 */
	public function set_slider_id($sid){
		$this->slider_id = apply_filters('revslider_set_slider_id', $sid, $this);
	}

	/**
	 * set the current revapi for JavaScript
	 */
	public function set_revapi($revapi){
		$this->revapi = $revapi;
	}

	/**
	 * set the slider manually
	 */
	public function set_slider($slider){
		$this->slider = apply_filters('revslider_set_slider', $slider, $this);
	}
	
	/**
	 * set slide data and layers
	 */
	public function set_slide($slide){
		$this->slide = apply_filters('revslider_set_slide', $slide, $this);
	}

	/**
	 * get slide data and layers
	 */
	public function get_slide(){
		return apply_filters('revslider_get_slide', $this->slide, $this);
	}
	
	/**
	 * set the output into ajax loaded mode
	 * so that i.e. fonts are pushed into footer
	 */
	public function set_ajax_loaded(){
		$this->ajax_loaded = true;
	}

	/**
	 * get the HTML ID
	 * @before: RevSliderOutput::getSliderHtmlID
	 */
	public function get_html_id($raw = true){
		$html_id = $this->html_id;
		$html_id = (!$raw) ? preg_replace("/[^a-zA-Z0-9]/", "", $html_id) : $html_id;
		
		return apply_filters('revslider_get_html_id', $html_id, $this, $raw);
	}

	/**
	 * set slide specific values that are needed by layers
	 * this is needed to be called before any layer is added to the stage
	 **/
	public function set_slide_params_for_layers(){
		$slide = $this->get_slide();
		$this->set_slide_id($slide->get_id());
		$this->set_layers($slide->get_layers());
	}
	
	public function set_offset($offset){
		$this->offset = wp_kses_post($offset);
	}
	
	public function get_offset(){
		return $this->offset;
	}
	
	public function set_modal($modal, $replace = true){
		if($replace){
			$this->modal = wp_kses_post($modal);
		}else{
			if(substr($this->modal, -1) !== ';') $this->modal .= ';';
			$this->modal .= wp_kses_post($modal);
		}
	}
	
	public function get_modal(){
		return $this->modal;
	}
	
	public function set_usage($usage){
		$this->usage = wp_kses_post($usage);
	}
	
	public function get_usage(){
		return $this->usage;
	}
	
	public function set_layout($sc_layout){
		$this->sc_layout = wp_kses_post($sc_layout);
	}
	
	public function get_layout(){
		return $this->sc_layout;
	}

	/**
	 * set slide slide_id
	 */
	public function set_slide_id($slide_id){
		$this->slide_id = apply_filters('revslider_set_slide_id', $slide_id, $this);
	}

	/**
	 * set the slides so that it can be used from anywhere
	 **/
	public function set_current_slides($slides){
		$this->slides = $this->transform_ids_v6_to_v7($slides);
	}

	/**
	 * set the slides so that it can be used from anywhere
	 **/
	public function set_current_slides_v7($slides){
		$this->slides_v7 = $slides;
	}
	
	/**
	 * get the slides so that it can be used from anywhere
	 **/
	public function get_current_slides(){
		return $this->slides;
	}
	
	/**
	 * get the slides so that it can be used from anywhere
	 **/
	public function get_current_slides_v7(){
		return $this->slides_v7;
	}
	
	/**
	 * set static_slide data and layers
	 */
	public function set_static_slide($slide){
		if(!empty($this->slider)) $slide = $this->transform_ids_v6_to_v7(array($slide))[0];

		$this->static_slide = apply_filters('revslider_set_static_slide', $slide, $this);
	}
	
	/**
	 * get static_slide data and layers
	 */
	public function get_static_slide(){		
		return apply_filters('revslider_get_static_slide', $this->static_slide, $this);
	}
	
	/**
	 * get do_static
	 */
	public function get_do_static(){
		return apply_filters('revslider_get_do_static_layers', $this->do_static, $this);
	}

	/**
	 * get slide slide_id
	 */
	public function get_slide_id(){
		return apply_filters('revslider_get_slide_id', $this->slide_id, $this);
	}
	
	/**
	 * set slide layers
	 */
	public function set_layers($layers){
		$this->layers = apply_filters('revslider_set_layers', $layers, $this);
	}
	
	/**
	 * get slide layers
	 */
	public function get_layers(){
		return apply_filters('revslider_get_layers', $this->layers, $this);
	}
	
	/**
	 * set slide layer
	 */
	public function set_layer($layer){
		$this->layer = apply_filters('revslider_set_layer', $layer, $this);
	}
	
	/**
	 * get slide layer
	 */
	public function get_layer(){
		return apply_filters('revslider_get_layer', $this->layer, $this);
	}

	/**
	 * set the gallery ids variable
	 * @before: RevSliderOutput::did not exist
	 */
	public function set_gallery_ids($ids){
		if(!empty($ids)) $ids = array_filter(array_map('intval', $ids));
		$this->gallery_ids = apply_filters('revslider_set_gallery_ids', $ids, $this);
	}
	
	/**
	 * get the gallery ids variable
	 * @before: RevSliderOutput::did not exist
	 */
	public function get_gallery_ids(){
		return apply_filters('revslider_get_gallery_ids', $this->gallery_ids, $this);
	}
	
	/**
	 * get current layer depth
	 */
	public function ld(){
		return $this->layer_depth;
	}
	
	/**
	 * increase current layer depth
	 * this is only for the HTML looks
	 */
	public function increase_layer_depth(){
		$this->layer_depth .= '	';
	}
	
	/**
	 * decrease current layer depth
	 * this is only for the HTML looks
	 */
	public function decrease_layer_depth(){
		if(!empty($this->layer_depth)){
			$this->layer_depth =  substr($this->layer_depth, 0, -1);
		}
	}

	/**
	 * get the preview
	 */
	public function get_preview_mode(){
		return apply_filters('revslider_get_preview_mode', $this->preview_mode, $this);
	}
	
	/**
	 * set the preview_mode
	 */
	public function set_preview_mode($preview_mode){
		global $SR_GLOBALS;
		$this->preview_mode = apply_filters('revslider_set_preview_mode', $preview_mode, $this);
		$SR_GLOBALS['preview_mode'] = $this->preview_mode;
	}

	/**
	 * set the markup_export variable
	 */
	public function set_markup_export($markup_export){
		global $SR_GLOBALS;
		$SR_GLOBALS['markup_export'] = apply_filters('revslider_set_markup_export', $markup_export, $this);
	}
	
	/**
	 * get the markup_export variable
	 */
	public function get_markup_export(){
		global $SR_GLOBALS;
		return apply_filters('revslider_get_markup_export', $SR_GLOBALS['markup_export'], $this);
	}
	
	/**
	 * set the custom settings
	 */
	public function set_custom_settings($settings){
		$settings = preg_replace('/\\\\u([0-9a-fA-F]{4})/', '', $settings);
		$settings = ($settings !== '' && !is_array($settings)) ? json_decode(str_replace(array('({', '})', "'"), array('[', ']', '"'), wp_kses_post($settings)), true) : $settings;
		
		$this->custom_settings = apply_filters('revslider_set_custom_settings', $settings, $this);
	}
	
	/**
	 * get the custom settings
	 */
	public function get_custom_settings(){
		return apply_filters('revslider_get_custom_settings', $this->custom_settings, $this);
	}

	/**
	 * register the alias for the JSON later to be printed
	 */
	public function register_module(){
		global $SR_GLOBALS;

		$SR_GLOBALS['sliders'][] = (!empty($this->slider_v7)) ? $this->slider_v7->get_alias() : $this->slider->get_alias();
	}
	
	/**
	 * check the add_to
	 * return true / false if the put in string match the current page.
	 * @before isPutIn()
	 */
	public function check_add_to($empty_is_false = false){
		$add_to = $this->get_add_to();
		
		if($empty_is_false && empty($add_to)) return false;
		
		if($add_to == 'homepage'){ //only add if we are the homepage
			if(is_front_page() == false && is_home() == false) return false;
		}elseif(!empty($add_to)){
			
			$add_to_pages = array();
			$add_to = explode(',', $add_to);
			if(!empty($add_to)){
				foreach($add_to as $page){
					$page = trim($page);
					
					if(is_numeric($page) || $page == 'homepage') $add_to_pages[] = $page;
				}
			}
			
			//check if current page is in list
			if(!empty($add_to_pages)){
				$cp_id = $this->get_current_page_id();
				if(array_search($cp_id, $add_to_pages) === false) return false;
			}else{
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * set the add_to variable
	 */
	public function set_add_to($add_to) {
		$this->add_to = apply_filters('revslider_set_add_to', $add_to, $this);
	}
	
	/**
	 * get the add_to variable
	 */
	public function get_add_to(){
		return apply_filters('revslider_get_add_to', trim(strtolower($this->add_to)), $this);
	}
	
	/**
	 * set the custom settings
	 */
	public function set_custom_skin($skin){
		$this->custom_skin = apply_filters('revslider_set_custom_skin', $skin, $this);
	}
	
	/**
	 * set the custom order
	 */
	public function set_custom_order($order){
		$order = ($order !== '' && !is_array($order)) ? explode(',', $order) : $order;
		
		$this->custom_order = apply_filters('revslider_set_custom_order', $order, $this);
	}
	
	/**
	 * set the current layer unique id
	 **/
	public function set_layer_unique_id(){
		global $SR_GLOBALS;

		$layer	= $this->get_layer();
		$uid	= ($SR_GLOBALS['use_table_version'] === 7) ? $this->get_val($layer, 'id') : $this->get_val($layer, 'uid');

		if(!is_numeric($uid)) $uid = $this->zIndex;
		//if($uid == '' && $uid !== 0 && $uid !== '0') $uid = $this->zIndex;
		
		$this->uid = apply_filters('revslider_set_layer_unique_id', $uid, $layer, $this);
	}

	/**
	 * set usage specific parameters to the output
	 **/
	public function set_usage_values(){
		$usage = $this->get_usage();

		//modal uses cover color and cover speed
		if($usage === 'modal'){
			$modal = '';
			if(!empty($this->slider_v7)){				
				$c = ($this->slider_v7->get_param(array('modal', 'cover'), true) === true) ? ($this->slider_v7->get_param(array('modal', 'bg'), 'rgba(0,0,0,0.5)')) : "transparent";
				$s = $this->slider_v7->get_param(array('modal', 'sp'), 1000);
				$scr = $this->slider_v7->get_param(array('modal', 'pS'),false) === true ? 'true' : 'false';	
				$h = $this->slider_v7->get_param(array('modal', 'h'), "center");
				$v = $this->slider_v7->get_param(array('modal', 'v'), "middle");
			}else{ //v6				
				$c = ($this->slider->get_param(array('modal', 'cover'), true) === true) ? $this->slider->get_param(array('modal', 'coverColor'), 'rgba(0,0,0,0.5)') : "transparent";
				$s = $this->slider->get_param(array('modal', 'coverSpeed'), 1000);
				$scr = $this->slider->get_param(array('modal', 'allowPageScroll'),false) === true ? 'true' : 'false';
				$h = $this->slider->get_param(array('modal', 'horizontal'), "center");
				$v = $this->slider->get_param(array('modal', 'vertical'), "middle");
			}
			if(!empty($c)) $modal .= 'bg:'.esc_attr($c).';';
			if(!empty($s)) $modal .= 'sp:'.esc_attr($s).';';
			if(!empty($scr)) $modal .= 'pS:'.esc_attr($scr).';';
			if(!empty($h)) $modal .= 'h:'.esc_attr($h).';';
			if(!empty($v)) $modal .= 'v:'.esc_attr($v).';';

			if(!empty($modal)) $this->set_modal($modal, false);
		}
	}
	
	/**
	 * get the current layer unique id
	 **/
	public function get_layer_unique_id(){		
		return apply_filters('revslider_get_layer_unique_id', $this->uid, $this);
	}

	/**
	 * get the simple link that can be inside the actions of a layer
	 **/
	public function get_action_link(){
		$link	= '';
		$layer	= $this->get_layer();
		$action	= $this->get_val($layer, array('actions', 'action'), array());

		if(!empty($action)){
			foreach($action as $act){
				// these are needed for the Social Share AddOn
				$action_type = apply_filters('rs_action_type', $this->get_val($act, 'action'));
				$link_type = apply_filters('rs_action_link_type', $this->get_val($act, 'link_type', ''));
				if(in_array($action_type, array('menu', 'link'), true)){
					if($action_type === 'link' && $link_type === 'jquery') break;

					$http			= $this->get_val($act, 'link_help_in', 'keep');
					$_link			= ($action_type === 'menu') ? $this->remove_http($this->get_val($act, 'menu_link', ''), $http) : $this->remove_http($this->get_val($act, 'image_link', ''), $http);
					$_link			= do_shortcode($_link);
					$link_open_in	= $this->get_val($act, 'link_open_in', '');
					$link			= 'href="'.esc_url($_link).'"';
					$link			.= ($link_open_in !== '') ? ' target="'.esc_attr($link_open_in).'"' : '';
					if($this->get_val($act, 'link_follow', '') === 'nofollow'){
						$link .= ' rel="nofollow';
						$link .= ($link_open_in === '_blank') ? ' noopener' : '';
						$link .= '"';
					}else{
						$link .= ($link_open_in === '_blank') ? ' rel="noopener"' : '';
					}
					break;
				}
			}
		}
		
		return $link;
	}

	/**
	 * add elements depending on v7 data
	 **/
	public function get_action_link_v7(){
		$html	= '';
		$layer	= $this->get_layer();
		$rel	= $this->get_val($layer, 'rel', '');

		if($this->get_val($layer, 'tag', 'sr7-txt') === 'a'){
			$html 	.= ' href="'.esc_url($this->get_val($layer, 'href', '')).'"';
			$target	= $this->get_val($layer, 'target', '');
			if(!empty($target)) $html .= ' target="'. esc_attr($target) .'"';
		}

		if(!empty($rel)) $html .= ' rel="'. esc_attr($rel) .'"';

		return $html;
	}


	/**
	 * create the layer action HTML
	 **/
	public function get_html_layer_action(&$html_simple_link){
		$layer		 = $this->get_layer();
		$events		 = array();
		$all_actions = $this->get_val($layer, 'actions', array());
		$actions	 = $this->get_val($all_actions, 'action', array());
		
		if(empty($actions)) return;

		foreach($actions as $num => $action){
			// Filter the Actions
			$events = apply_filters('rs_action_output_layer_action', $events, $action, $all_actions, $num, $this->slide, $this);
			if(!isset($html_simple_link)) $html_simple_link = '';

			$html_simple_link = apply_filters('rs_action_output_layer_simple_link', $html_simple_link, $action, $all_actions, $num, $this->slide, $this->slider, $events, $this);
		}
	}

	/**
	 * get the layer tag as it can change through settings and others
	 **/
	public function get_layer_tag($html_simple_link, $special_type = false){
		$layer	= $this->get_layer();
		$layer	= (!empty($this->slider_v7)) ? $this->filter_single_layer_tags($layer, 'tag', 'sr7-txt') : $this->filter_single_layer_tags($layer, 'htmltag', 'sr7-txt');
		$tag	= (!empty($this->slider_v7)) ? $this->get_val($layer, 'tag', 'sr7-txt') : $this->get_val($layer, 'htmltag', 'sr7-txt');
		
		if($html_simple_link !== '' && empty($this->slider_v7)) $tag = 'a';
		if($special_type !== false)	 $tag = 'sr7-'.$special_type; //if we are special type, only allow div to be the structure, as we will close with a div outside of this function

		return ($tag !== 'div') ? esc_attr($tag) : 'sr7-txt';
	}

	/**
	 * returns the HTML layer type
	 */
	public function get_html_layer_type(){
		return 'data-type="'.esc_attr($this->get_layer_type()).'"';
	}

	/**
	 * return the layer Type for further needs	 
	 */
	public function get_layer_type(){
		$layer = $this->get_layer();
		return $this->get_val($layer, 'type', 'text');
	} 

	/**
	 * get the html class for a layer
	 **/
	public function get_html_class($class, $layer_tag){
		$html	= '';
		$class	= trim($class);
		$c		= array();

		if($class !== '') $c = explode(' ', $class);
		if(!in_array($layer_tag, array('rs-row', 'rs-column', 'sr7-layer', 'rs-group', 'rs-bgvideo'), true)){
			$c[] = 'sr7-layer';
		}
		
		$slider	= (!empty($this->slider_v7)) ? $this->slider_v7 : $this->slider;
		$c		= apply_filters('revslider_add_layer_classes', $c, $this->layer, $this->slide, $slider);
		
		return (!empty($c)) ? 'class="'.implode(' ', $this->filter_class_name($c)).'"' : '';
	}

	/**
	 * retrieves the current layer attribute id by given target
	 **/
	public function get_layer_attribute_id($target){
		$layer_attribute_id = $this->slide->get_layer_id_by_uid($target, $this->static_slide);
		
		$id = (!empty($this->slider_v7)) ? $this->slider_v7->get_id() : $this->slider->get_id();
		if($target == 'backgroundvideo' || $target == 'firstvideo'){
			$layer_attribute_id = $target;
		}elseif(trim($layer_attribute_id) == ''){
			if(strpos($target, 'static-') !== false){
				$ss = $this->get_static_slide();
				$layer_attribute_id = 'slider-'.preg_replace("/[^\w]+/", "", $id).'-slide-'.$ss->get_id().'-layer-'.str_replace('static-', '', $target);
				//$layer_attribute_id = 'slider-'.preg_replace("/[^\w]+/", "", $this->slider->get_id()).'-slide-'.$this->get_slide_id().'-layer-'.str_replace('static-', '', $target);
			}elseif($this->static_slide){
				$layer_attribute_id = 'slider-'.preg_replace("/[^\w]+/", "", $id).'-slide-'.preg_replace("/[^\w]+/", "", $this->get_slide_id()).'-layer-'.str_replace('static-', '', $target);
			}else{
				$layer_attribute_id = 'slide-'.preg_replace("/[^\w]+/", "", $this->get_slide_id()).'-layer-'.$target;
			}
		}
		
		return $layer_attribute_id;
	}

	/**
	 * get the layer ids as HTML
	 **/
	public function get_html_layer_ids($raw = false){
		$layer	= $this->get_layer();
		$slide	= $this->get_slide();
		$ids	= (!empty($this->slider_v7)) ? $this->get_val($layer, array('attr', 'id')) : $this->get_val($layer, array('attributes', 'id'));
		$ids 	= (trim($ids) == '') ? $this->get_html_id().'-'.preg_replace("/[^\w]+/", "", $this->get_slide_id()).'-'.$this->get_layer_unique_id() : $ids;
		
		if($raw === false) $ids = ($ids != '') ? 'id="'.$this->filter_class_name($ids).'"' : '';
		
		return $ids;
	}

	/**
	 * adds the Slider Basis
	 * @before: RevSliderOutput::putSliderBase();
	 */
	public function add_slider_base(){
		try{
			global $SR_GLOBALS;

			$SR_GLOBALS['serial']++; //set the serial +1, so that if we have the slider two times, it has different ID's for sure

			if(empty($this->slider)){
				$this->slider = new RevSliderSlider(); 
				$this->slider->init_by_mixed($this->get_slider_id());
				if($this->slider->inited === false) $this->slider = null;
			}
			
			if(empty($this->slider_v7)){
				//$use = $SR_GLOBALS['use_table_version'];
				$SR_GLOBALS['use_table_version'] = 7;
				$this->slider_v7 = new RevSliderSlider(); 
				$this->slider_v7->init_by_mixed($this->get_slider_id(), false);
				if($this->slider_v7->inited === false) $this->slider_v7 = null;

				//$SR_GLOBALS['use_table_version'] = $use;
				if(empty($this->slider_v7)) $SR_GLOBALS['use_table_version'] = 6;
			}

			if(empty($this->slider_v7) && empty($this->slider)) return false;

			if(!empty($this->slider)) apply_filters('revslider_add_slider_base', $this->slider);
			if(!empty($this->slider_v7)) apply_filters('revslider_add_slider_base', $this->slider_v7);
			
			//set slider language
			if($this->get_preview_mode() === false){
				$SR_wpml = RevSliderGlobals::instance()->get('RevSliderWpml');
				$slider = (!empty($this->slider_v7)) ? $this->slider_v7 : $this->slider;
				$lang = $SR_wpml->get_slider_language($slider);
				if($lang !== 'all'){
					if(!empty($this->slider_v7)) $this->slider_v7->change_language($lang);
					if(!empty($this->slider)) $this->slider->change_language($lang);
					$this->change_language($lang);
				}
			}
			
			//the initial id can be an alias, so reset the id now
			$sid = (!empty($this->slider_v7)) ? $this->slider_v7->get_id() : $this->slider->get_id();
			$this->set_slider_id($sid);
			$this->set_usage_values();

			$mobile = (!empty($this->slider_v7)) ? $this->slider_v7->get_param(array('general', 'disableOnMobile'), false) : $this->slider->get_param(array('general', 'disableOnMobile'), false);
			if($mobile === true && wp_is_mobile()) return false;
			
			$pakps = (!empty($this->slider_v7)) ? $this->slider_v7->get_param('prem', false) : $this->slider->get_param('pakps', false);
			if($this->_truefalse($pakps) === true && $this->_truefalse(get_option('revslider-valid', 'false')) === false && $SR_GLOBALS['preview_mode'] === false){
				$this->console_exception = true;
				$this->throw_error(__('Please register the Slider Revolution plugin to use premium templates.', 'revslider'));
			}

			$this->register_module();

			if($this->get_from_caching()) return true;

			$slider_id	= (!empty($this->slider_v7)) ? $this->slider_v7->get_param('id', '') : $this->slider->get_param('id', '');
			$html_id	= (trim($slider_id) !== '') ? $slider_id : 'SR7_'.$sid.'_'.$SR_GLOBALS['serial'];
			$revapi		= (in_array('sr7'.$sid, $SR_GLOBALS['collections']['js']['revapi'], true)) ? 'sr7'.$sid.'_'.$SR_GLOBALS['serial'] : 'sr7'.$sid;
			$this->set_html_id($html_id);
			$this->set_revapi($revapi);
			
			ob_start();
			
			echo $this->get_slider_div();

			/**
			 * stream feed =  JSON -> it should gather the feeds, prepare slides and push in the SR7.M[sliderid].stream
			 * stream feed =  REST -> we get the data and prepare the slides, so that content is beeing written for SEO, we do not need to push it into SR_GLOBALS, as it gets fetched later on 
			 */
			$this->stream_data = (!empty($this->slider_v7)) ? $this->slider_v7->get_stream_data() : $this->slider->get_stream_data();
			if($this->get_val($this->global_settings, array('getTec', 'feed'), 'REST') === 'JSON'){
				if(!empty($this->stream_data)) $SR_GLOBALS['collections']['js']['stream'][$html_id] = $this->stream_data;
			}

			echo $this->get_slides();

			echo $this->close_slider_div();
			echo $this->js_get_start_size();
			
			if($SR_GLOBALS['loaded_by_editor'] === true){ //for elementor
				$this->add_js();
			}else{
				add_action('wp_print_footer_scripts', array($this, 'add_js'), 99);
			}

			$this->set_javascript_variables();

			do_action('revslider_add_slider_base_post', $this);
			
			$content = ob_get_contents();
			ob_clean();
			ob_end_clean();
			
			echo $content;

			if(!empty($this->slider_v7)){
				$this->add_fonts_v7();
			}else{
				$this->add_fonts_v6();
			}

		}catch(Exception $e){
			$message = $e->getMessage();
			if(ob_get_level() > 1){
				ob_clean();
				ob_end_clean();
			}

			if($this->console_exception){
				$this->print_error_message_console($message);
			}else{
				$this->print_error_message($message);
			}
		}
	}

	/**
	 * set the HTML ID
	 * @since 6.1.6: added option to check for duplications
	 */
	public function set_html_id($html_id, $check_for_duplication = true){
		$html_id = $this->set_html_id_v7($html_id, $check_for_duplication);
		
		$this->html_id = apply_filters('revslider_set_html_id', $html_id, $this);
	}

	/**
	 * return the responsive sizes
	 * @since: 5.0
	 **/
	public function get_responsive_size_v7($slider){
		$uSize = $slider->slider_v7->get_param('uSize');
		$sizes = array(
			'height'	=> $slider->slider_v7->get_param(array('size', 'height'), array()),
			'width'		=> $slider->slider_v7->get_param(array('size', 'width'), array()),
			'cacheSize'	=> $slider->slider_v7->get_param(array('size', 'cachedHeight'), array())
		);

		foreach($sizes as $type => $size){
			$default = $this->get_biggest_device_setting_v7($size, $this->enabled_sizes);
			if(empty($size)){
				$sizes[$type] = array_fill(0, 5, $default);
				continue;
			}

			foreach($size as $l => $v){										
				if(!empty($uSize) && isset($uSize[$l]) && $uSize[$l] === false){
					$sizes[$type][$l] = $default;
				}else{
					$default = $v;
				}
			}
		}
		foreach($sizes as $type => $size){
			$sizes[$type] = str_replace('px', '', implode(',', $sizes[$type]));
		}

		return $sizes;
	}


	public function get_responsive_size($slider){
		$csn = $slider->slider->get_param(array('size', 'custom', 'n'), false);
		$cst = $slider->slider->get_param(array('size', 'custom', 't'), false);
		$csi = $slider->slider->get_param(array('size', 'custom', 'm'), false);
		
		$w = $slider->slider->get_param(array('size', 'width', 'd'), 1240);
		$h = $slider->slider->get_param(array('size', 'height', 'd'), 1240);
		$r = $this->get_val($this->global_settings, array('size', 'desktop'), 1240);
		$c = $this->slider->get_param(array('size', 'editorCache', 'd'), false);
		
		if($csn == true || $cst == true || $csi == true){
			$d = $w;
			$w .= ',';
			$w .= ($csn == true) ? $slider->slider->get_param(array('size', 'width', 'n'), 1024) : $d;
			$d = ($csn == true) ? $slider->slider->get_param(array('size', 'width', 'n'), 1024) : $d;
			$w .= ',';
			$w .= ($cst == true) ? $slider->slider->get_param(array('size', 'width', 't'), 778) : $d;
			$d = ($cst == true) ? $slider->slider->get_param(array('size', 'width', 't'), 778) : $d;
			$w .= ',';
			$w .= ($csi == true) ? $slider->slider->get_param(array('size', 'width', 'm'), 480) : $d;

			$d = $h;
			$h .= ',';
			$h .= ($csn == true) ? $slider->slider->get_param(array('size', 'height', 'n'), 1024) : $d;
			$d = ($csn == true) ? $slider->slider->get_param(array('size', 'height', 'n'), 1024) : $d;
			$h .= ',';
			$h .= ($cst == true) ? $slider->slider->get_param(array('size', 'height', 't'), 778) : $d;
			$d = ($cst == true) ? $slider->slider->get_param(array('size', 'height', 't'), 778) : $d;
			$h .= ',';
			$h .= ($csi == true) ? $slider->slider->get_param(array('size', 'height', 'm'), 480) : $d;

			$d = $r;
			$r .= ',';
			$r .= ($csn == true) ? $this->get_val($this->global_settings, array('size', 'notebook'), 1024) : $d;
			$d = ($csn == true) ? $this->get_val($this->global_settings, array('size', 'notebook'), 1024) : $d;
			$r.= ',';
			$r .= ($cst == true) ? $this->get_val($this->global_settings, array('size', 'tablet'), 778) : $d;
			$d = ($cst == true) ? $this->get_val($this->global_settings, array('size', 'tablet'), 778) : $d;
			$r.= ',';
			$r .= ($csi == true) ? $this->get_val($this->global_settings, array('size', 'mobile'), 480) : $d;

			if($c !== false){
				$d = $c;
				$c .= ',';
				$c .= ($csn == true) ? $slider->slider->get_param(array('size', 'editorCache', 'n'), 1024) : $d;
				$d = ($csn == true) ? $slider->slider->get_param(array('size', 'editorCache', 'n'), 1024) : $d;
				$c .= ',';
				$c .= ($cst == true) ? $slider->slider->get_param(array('size', 'editorCache', 't'), 778) : $d;
				$d = ($cst == true) ? $slider->slider->get_param(array('size', 'editorCache', 't'), 778) : $d;
				$c .= ',';
				$c .= ($csi == true) ? $slider->slider->get_param(array('size', 'editorCache', 'm'), 480) : $d;
			}
		}else{
			$r .= ',';
			$r .= $this->get_val($this->global_settings, array('size', 'notebook'), 1024);
			$r .= ',';
			$r .= $this->get_val($this->global_settings, array('size', 'tablet'), 778);
			$r .= ',';
			$r .= $this->get_val($this->global_settings, array('size', 'mobile'), 480);
		}
		
		return array(
			'level' => str_replace('px', '', $r),
			'height' => str_replace('px', '', $h),
			'width' => str_replace('px', '', $w),
			'cacheSize' => str_replace('px', '', $c)
		);
	}

	/**
	 * creates the div container for Sliders
	 **/
	public function get_slider_div(){
		$class	= (!empty($this->slider_v7)) ? $this->slider_v7->get_param('class', '') : $this->slider->get_param('class', '');
		$class	= (!is_array($class) && !empty($class)) ? explode(' ', $class) : $class;
		$class	= (empty($class)) ? array() : (array)$class;
		$modal	= $this->get_modal();
		$id		= (!empty($this->slider_v7)) ? $this->slider_v7->get_id() : $this->slider->get_id();
		$alias	= (!empty($this->slider_v7)) ? $this->slider_v7->get_alias() : $this->slider->get_alias();
		$gallery = $this->get_gallery_ids();
		$this->rs_module_open = true;

		if(!empty($this->slider_v7)){
			if($this->slider_v7->get_param(array('size', 'overflow'), true) == true) $class[] = 'rs-ov-hidden';
		}else{
			if($this->slider->get_param(array('size', 'overflow'), true) == true) $class[] = 'rs-ov-hidden';
		}
		
		$r = "\n".RS_T4.'<p class="rs-p-wp-fix"></p>'."\n";
		$r .= RS_T4.'<sr7-module data-alias="'. esc_attr($alias) .'" data-id="'. esc_attr($id) .'" id="'. esc_attr($this->get_html_id()) .'"';
		$r .= (!empty($class)) ? ' class="'. implode(' ', $this->filter_class_name($class)) .'"' : '';
		$r .= ' data-version="'. RS_REVISION .'"';
		$r .= (!empty($modal)) ? ' data-style="display:none" data-modal="'.esc_attr($modal).'"' : '';
		$r .= (!empty($gallery)) ? ' data-source="wp-gallery" data-sourceids="'.implode(',', $gallery).'"' : '';
		$r .= '>'."\n";
		$r .= RS_T5.'<sr7-adjuster></sr7-adjuster>'."\n";
		$r .= RS_T5.'<sr7-content>'."\n";
		if(!empty($this->slider_v7)){
			if($this->slider_v7->get_param(array('type'), 'slider') == 'carousel') $r .= RS_T6.'<sr7-carousel>'."\n";
		}else{
			if($this->slider->get_param(array('type'), 'slider') == 'carousel') $r .= RS_T6.'<sr7-carousel>'."\n";
		}

		return apply_filters('revslider_get_slider_div', $r, $this);
	}

	/**
	 * close the div container for Sliders
	 **/
	public function close_slider_div(){
		$this->set_image_lists();

		$r = '';
		if(!empty($this->slider_v7)){
			if($this->slider_v7->get_param(array('type'), 'slider') == 'carousel') $r .= RS_T6.'</sr7-carousel>'."\n";
		}else{
			if($this->slider->get_param(array('type'), 'slider') == 'carousel') $r .= RS_T6.'</sr7-carousel>'."\n";
		}
		
		$r .= RS_T5.'</sr7-content>'."\n";
		if($this->get_markup_export() === false) $r .= $this->add_image_lists();
		$r .= RS_T4.'</sr7-module>'."\n";

		$this->rs_module_closed = true;
		
		return apply_filters('revslider_close_slider_div_and_call_prepare', $r, $this);
	}

	public function get_images_list(){
		return apply_filters('sr_get_image_lists', $this->images, $this);
	}

	public function set_image_lists(){
		foreach($this->stream_data ?? [] as $stream){
			$media = $this->get_val($stream, 'media');
			if(empty($media)) $media = $this->get_val($stream, 'thumb');
			if(empty($media)) continue;
			$this->images[] = array('src' => $media, 'orig' => $media);
		}

		if(!empty($this->slider_v7)){
			$images = $this->slider_v7->get_param('imgs', array());
			foreach($images ?? [] as $k => $image){
				if(!is_array($image)) $images[$k] = array('src' => $image);
				$images[$k]['orig'] = $this->get_val($image, 'src');
			}
			$this->images = array_merge($images, $this->images);
		}
	}

	/**
	 * prepares list of images found in the slider
	 * in case of a stream/post based slider, images will be added here, too
	 **/
	public function add_image_lists(){
		$used_images = $this->get_images_list();
		$images = array();
		foreach($used_images ?? [] as $image){
			$imgsrc	 = $this->remove_http($this->get_val($image, 'src'));
			$imgorig = $this->remove_http($this->get_val($image, 'orig'));
			if(empty($imgsrc) || empty($imgorig)) continue;

			$lib_id	 = $this->get_val($image, 'lib_id');
			$info	 = false;
			$attr	 = array(
				'alt' => $this->get_val($image, 'a', false),
				'title' => $this->get_val($image, 't', false),
			);
			foreach($attr as $key => $value){
				if($value === '#fn'){
					$info	= ($info === false) ? pathinfo($imgsrc) : $info;
					$value	= $this->get_val($info, 'filename', '');
				}else{
					$value 	 = ($value === 'c') ? $this->get_val($image, 'a') : $value;
					if($key === 'title'){
						$value 	 = ($value === false && intval($lib_id) > 0) ? get_the_title($lib_id) : '';
					}else{
						$value 	 = ($value === false && intval($lib_id) > 0) ? get_post_meta($lib_id, '_wp_attachment_image_alt', true) : '';
					}
				}
				$attr[$key]	= $value;
			}

			$additions = (!empty($lib_id)) ? ' data-libid="'. esc_attr($lib_id) .'"' : '';
			$additions .= (!empty($this->get_val($image, 'lib'))) ? ' data-lib="'. esc_attr($this->get_val($image, 'lib')) .'"' : '';
			foreach($attr as $key => $value){
				$additions .= (!empty($value)) ? ' '.$key.'="'. esc_attr(strip_tags($value)) .'"' : '';
			}
			$images[] = RS_T6.'<img data-src="'. $imgsrc .'"'.$additions.' width="0" height="0" data-dbsrc="'. base64_encode($imgorig) .'"/>';
		}

		$images = apply_filters('sr_add_image_lists', $images, $this);

		return (empty($images)) ? '' : RS_T5.'<image_lists style="display:none">'."\n".
				implode("\n", $images) . "\n" .
				RS_T5.'</image_lists>'."\n";
	}

	/**
	 * get the start size
	 **/
	public function js_get_start_size(){
		return (!empty($this->modal)) ? '' : RS_T4.'<script>'."\n". RS_T5.$this->get_html_js_start_size()."\n". RS_T4.'</script>'."\n";
	}

	/**
	 * set the start size of the slider through javascript
	 **/
	public function get_html_js_start_size(){
		$len = false;
		$sbt = false;
		$onh = 0;
		$onw = 0;
		$cpt = 0;
		$cpb = 0;
		$shdw = false;

		if(!empty($this->slider_v7)){
			$slides		= $this->get_current_slides_v7();
			$csizes		= $this->get_responsive_size_v7($this);
			$mtype		= $this->slider_v7->get_param(array('type'), 'standard');
			$vport		= ($this->adv_resp_sizes == true) ? implode("','", (array)$this->slider_v7->get_param(array('vPort'), '100px')) : $this->get_biggest_device_setting_v7($this->slider_v7->get_param(array('vPort'), '100px'), $this->enabled_sizes, '100px');
			if($mtype == 'carousel'){
				$cpt = intval($this->slider_v7->get_param(array('carousel', 'pT'), '0'));
				$cpb = intval($this->slider_v7->get_param(array('carousel', 'pB'), '0'));
			}
			$plType		= $this->slider_v7->get_param(array('pLoader', 'type'), 'off');
			$plColor	= ($plType !== 'off') ? $this->slider_v7->get_param(array('pLoader', 'color'), '#FFFFFF') : false;
			$shdw 		= $this->slider_v7->get_param(array('shdw'),false);

			// Kriki : get the height of the thumbs and tabs with padding to add it to height calulation
			$elements	= ['thumbs', 'tabs'];
			foreach($elements as $element){
				$navElementParams = $this->slider_v7->get_param(['nav', $element], []);
				$isElementSet = $navElementParams['set'] ?? false;
				$direction = $navElementParams['d']['1'] ?? '';
				$isOutside = $navElementParams['io'] ?? '' == 'o';

				if($isElementSet && $isOutside){
					$tempSize = $this->slider_v7->get_param(['nav', $element, 'size', $direction == 'horizontal' ? 'h' : 'w', '1'], 0);
					$tempPadding = $this->slider_v7->get_param(['nav', $element, 'wr', 'p', '1'], 0);

					if($direction == 'horizontal'){
						$onh += intval($tempSize) + intval($tempPadding) * 2;
					}elseif($direction == 'vertical'){
						$onw += intval($tempSize) + intval($tempPadding) * 2;
					}
				}
			}
			
			if($this->slider_v7->get_param(array('sbt', 'use'), false) === true && $this->slider_v7->get_param(array('sbt', 'f'), false) === true){
				$sbt = true;
				$len = 'default';
				foreach($slides ?? [] as $slide){
					$len = $slide->get_param(array('slideshow', 'len'), 'default');
					break;
				}
				if($len === 'default') $len = $this->slider_v7->get_param(array('default', 'len'), 'default');
				if($len === 'default') $len = 9000;
			}
			$fixed		= ($this->slider_v7->get_param('fixed', false) === true) ? true : false;
			$slider_type= $this->slider_v7->get_param('type', 'standard');			
			$fullwidth 	= ($this->slider_v7->get_param(array('size', 'fullWidth'),true) === true) ? true : false;	
			$fullheight	= ($this->slider_v7->get_param(array('size', 'fullHeight')) === true) ? true : false;
			$full_height_container	= $this->slider_v7->get_param(array('size', 'fullHeightOffset'), '');
			$bgcolor	= $this->slider_v7->get_param(array('bg', 'color'));
			$usebgimage = $this->slider_v7->get_param(array('bg', 'image','src'),'') !== '';
			
			if($usebgimage){
				$bgimage = $this->slider_v7->get_param(array('bg', 'image', 'src'));
				$bgpos = $this->slider_v7->get_param(array('bg', 'image', 'pos','x'),'center') . ' ' . $this->slider_v7->get_param(array('bg', 'image', 'pos','y'),'center');
				$bgrep = $this->slider_v7->get_param(array('bg', 'image', 'repeat'));
				$bgfit = $this->slider_v7->get_param(array('bg', 'image', 'size'));
			}

			$minH		= $this->slider_v7->get_param(array('size', 'minH'), 0);
		}else{
			$slides		= $this->get_current_slides();
			$csizes		= $this->get_responsive_size($this);
			$mtype		= $this->slider->get_param(array('type'), 'standard');			
			$plType		= $this->slider->get_param(array('layout', 'spinner', 'type'), 'off');
			$plColor	= ($plType !== 'off') ? $this->slider->get_param(array('layout', 'spinner', 'color'), '#FFFFFF') : false;
			$shdw 		= $this->slider->get_param(array('layout','bg','shadow'),false);
			$vport 		= ($this->_truefalse($this->slider->get_param(array('general', 'slideshow', 'globalViewPort'), 'false')) === true) ? $this->slider->get_param(array('general', 'slideshow', 'globalViewDist'), '100px') : '100px';
			if($this->_truefalse($this->slider->get_param(array('general', 'slideshow', 'viewPort'), false)) === true){
				$vport = ($this->adv_resp_sizes == true) ? $this->normalize_device_settings($this->slider->get_param(array('general', 'slideshow', 'viewPortArea')), $this->enabled_sizes, 'html-array', array('100px'), array(), "','") : $this->get_biggest_device_setting($this->slider->get_param(array('general', 'slideshow', 'viewPortArea'), '100px'), $this->enabled_sizes);
			}
						
			// Kriki : get the height of the thumbs and tabs with padding to add it to height calulation
			$elements = ['thumbs', 'tabs'];
			foreach($elements as $element){
				if($this->slider->get_param(['nav', $element, 'set'], false) === true){
					$innerOuter = $this->slider->get_param(['nav', $element, 'innerOuter'], 'inner');
					$isHorizontal = $innerOuter == 'outer-horizontal';
					$isVertical = $innerOuter == 'outer-vertical';

					if($isHorizontal || $isVertical){
						$dim = $isHorizontal ? 'height' : 'width';
						$tempDimension = $this->slider->get_param(['nav', $element, $dim], 0);
						$tempPadding = $this->slider->get_param(['nav', $element, 'padding'], 0);
						if($isHorizontal){
							$onh += intval($tempDimension) + intval($tempPadding) * 2;
						}else{
							$onw += intval($tempDimension) + intval($tempPadding) * 2;
						}
					}
				}
			}

			if($mtype == 'carousel'){
				$cpt = intval($this->slider->get_param(array('carousel', 'paddingTop'), '0'));
				$cpb = intval($this->slider->get_param(array('carousel', 'paddingBottom'), '0'));
			}
			if(strpos($plType, 'spinner') !== false) $plType = str_replace('spinner', 'prtl', $plType);
			if($this->slider->get_param(array('scrolltimeline', 'set'), false) === true && $this->slider->get_param(array('scrolltimeline', 'fixed'), false) === true){
				$sbt = true;
				$len = 'default';
				foreach($slides as $slide){
					$len = $slide->get_param(array('timeline', 'delay'), 'default');
					break;
				}
				if($len === 'default') $len = $this->slider->get_param(array('def', 'delay'), 'default');
				if($len === 'default') $len = 9000;
			}
			$fixed			= ($this->slider->get_param(array('layout', 'position', 'fixedOnTop'), false) === true) ? true : false;
			$slider_type	= $this->slider->get_param('type', 'standard');
			$fullheight		= ($this->slider->get_param('layouttype') == 'fullscreen') ? true : false;
			$fullwidth 		= $fullheight || ($this->slider->get_param('layouttype') == 'fullwidth') ? true : false;
			$full_height_container	= $this->slider->get_param(array('size', 'fullScreenOffsetContainer'), '');
			$full_height_offset		= $this->slider->get_param(array('size', 'fullScreenOffset'), '');
			$bgcolor		= $this->slider->get_param(array('layout', 'bg', 'color'));
			$usebgimage 	= $this->_truefalse($this->slider->get_param(array('layout', 'bg', 'useImage'))) !== false;
			if($usebgimage){
				$bgimage = $this->slider->get_param(array('layout', 'bg', 'image'));
				$bgpos = $this->slider->get_param(array('layout', 'bg', 'position'));
				$bgrep = $this->slider->get_param(array('layout', 'bg', 'repeat'));
				$bgfit = $this->slider->get_param(array('layout', 'bg', 'fit'));
			}
			$minH			= $this->slider->get_param(array('size', 'minHeight'), 0);
		}

		switch($this->get_layout()){ //check for gutenberg editor changes
			case 'auto';
				$fullwidth = false;
				$fullheight = false;
			break;
			case 'fullwidth';
				$fullwidth = true;
				$fullheight = false;
			break;
			case 'fullscreen';
				$fullwidth = true;
				$fullheight = true;
			break;
		}

		$html = '';
		if($csizes['cacheSize'] !== false){
			$cs = explode(',', $csizes['cacheSize']);
			if(!empty(array_diff($cs, array('0', 0, 'auto')))) $html .= 'el:['.esc_attr($csizes['cacheSize']).'],';
		}
		$html .= ($fixed !== false) ? "fixed:true," : '';
		$html .= "type:'".esc_attr($mtype)."',";
		if ($shdw!==false && $shdw!=="false") $html .= "shdw:'".esc_attr($shdw)."',";
		$html .= ($len !== false) ? "slideduration:'".esc_attr($len)."'," : '';
		$html .= "gh:[". esc_attr($csizes['height']) ."],";
		$html .= "gw:[". esc_attr($csizes['width']) ."],";
		$html .= "vpt:['".esc_attr($vport)."'],";
		$html .= "size:{fullWidth:".($fullwidth ? "true" : "false").", fullHeight:".($fullheight ? "true" : "false")."},";
		
		if($slider_type !== 'hero'){
			$check = array('tab' => 'tabs', 'thumb' => 'thumbs');
			$wpd = array('tabs' => 2, 'thumbs' => 10);
			foreach($check as $nk => $nav){
				if(!empty($this->slider_v7)){
					$nav_set		= $this->slider_v7->get_param(array('nav', $nav, 'set'), false);
					$nav_io			= $this->slider_v7->get_param(array('nav', $nav, 'io'), 'inner');
					$nav_widht_min	= json_encode($this->slider_v7->get_param(array('nav', $nav, 'size', 'w'), array('#a', 100, '#a', '#a', '#a')));
					$nav_padding	= json_encode($this->slider_v7->get_param(array('nav', $nav, 'wr', 'p'), array('#a', $wpd[$nav], '#a', '#a', '#a')));
					$nav_height		= json_encode($this->slider_v7->get_param(array('nav', $nav, 'size', 'h'), array('#a', 50, '#a', '#a', '#a')));
				}else{
					$nav_set		= $this->slider->get_param(array('nav', $nav, 'set'), false);
					$nav_io			= $this->slider->get_param(array('nav', $nav, 'innerOuter'), 'inner');
					$nav_widht_min	= $this->slider->get_param(array('nav', $nav, 'widthMin'), 100);
					$nav_padding	= intval($this->slider->get_param(array('nav', $nav, 'padding'), $wpd[$nav]));
					$nav_height		= $this->slider->get_param(array('nav', $nav, 'height'), 50);
				}
				
				if($nav_set !== true) continue;
				$do = false;
				if($nav_io === 'outer-vertical'){
					$html .= $nk.'w:"'.esc_attr($nav_widht_min).'",';
					$do = true;
				}elseif($nav_io === 'outer-horizontal'){
					$nav_height = ($nav_padding > 0) ? $nav_height + $nav_padding * 2 : $nav_height;
					$html .= $nk.'h:"'.esc_attr($nav_height).'",';
					$do = true;
				}
				
				if($do === false) continue;

				if(!empty($this->slider_v7)){
					$nav_hul = json_encode($this->slider_v7->get_param(array('nav', $nav, 'show'), 0));
				}else{
					if($this->slider->get_param(array('nav', $nav, 'hideUnder'), false) === false) continue;
					$nav_hul = esc_attr($this->slider->get_param(array('nav', $nav, 'hideUnderLimit'), 0));
				}

				$html .= $nk.'hide:"'.$nav_hul.'",';
			}
		}

		$fullscreen = ($fullwidth === true && $fullheight === true) ? true : false;
		$offset = $this->translate_shortcode_offset();

		if(!empty($offset)) $html .= "off:".json_encode($offset).",";
		if($fullscreen === true){
			if(!empty($this->slider_v7)){
				$html .= "fho:'". esc_attr($full_height_container) ."',";
			}else{
				$html .= "offsetContainer:'". esc_attr($full_height_container) ."',";
				$html .= "offset:'". esc_attr($full_height_offset) ."',";
			}
		}

		$mheight = ($fullscreen === false) ? $minH : $this->slider->get_param(array('size', 'minHeightFullScreen'), '0');
		$mheight = ($mheight == '' || $mheight == 'none') ? 0 : $mheight;
		$html .= "mh:'".esc_attr($mheight)."',";
		if($sbt) $html .= "sbt:{use:true},";
		
		if(!is_string($bgcolor)) $bgcolor = json_encode($bgcolor, JSON_HEX_APOS); else $bgcolor = esc_attr($bgcolor);
		$html .= "onh:".esc_attr($onh).",";
		$html .= "onw:".esc_attr($onw).",";
		$html .= "bg:{color:'".$bgcolor."'";
			
		if($usebgimage){
			if(!is_string($bgimage)) $bgimage = json_encode($bgimage, JSON_HEX_APOS); else $bgimage = esc_attr($bgimage);
			$html .= ",image:{src:'".$bgimage."'";
			$html .= ",size:'".esc_attr($bgfit)."'";
			$html .= ",position:'".esc_attr($bgpos)."'";
			$html .= ",repeat:'".esc_attr($bgrep)."'";
			$html .= "}";
		}
		$html .= "}";
		if (($this->get_val($this->global_settings, array('fontdownload'),'off'))=="disable") $html .=',googleFont:"ignore"';
		if($mtype == 'carousel') $html .= ",carousel:{pt:'".esc_attr($cpt)."',pb:'".esc_attr($cpb)."'}";
		if($plType !== 'off'){
			$html .= ",plType:'".esc_attr($plType)."',";
			$html .= "plColor:'".esc_attr($plColor)."'";
		}
		$html_id = esc_attr($this->get_html_id());
		$ret = 'SR7.PMH ??={}; '.
			'SR7.PMH["'. $html_id .'"] = {' .
			'cn:0,'.
			'state:false,'.
			'fn: function() {'.
				' if (_tpt!==undefined && _tpt.prepareModuleHeight !== undefined) {'.
				'  _tpt.prepareModuleHeight({id:"'. $html_id .'",'. $html .'});'.
				'   SR7.PMH["'. $html_id .'"].state=true;'.
				'} else if((SR7.PMH["'. $html_id .'"].cn++)<100)'.				
				'	setTimeout( SR7.PMH["'. $html_id .'"].fn,19);'.
			'}'.
			'};'.
				'SR7.PMH["'. $html_id .'" ].fn();';
		
		ob_start();
		do_action('revslider_fe_javascript_output', $this->slider, $html_id);
		$js_action = ob_get_contents();
		ob_clean();
		ob_end_clean();	
		$ret .= (!empty($js_action)) ? $js_action : '';

		return $ret;
	}

	/**
	 * get the HTML layer
	 **/
	public function get_html_layer(){
		$layer = $this->get_layer();
		$html = '';
		$type = $this->get_val($layer, 'type', 'text');
		$text = (!empty($this->slider_v7)) ? $this->get_val($layer, array('content', 'text')) : $this->get_val($layer, 'text');
		
		switch($type){
			case 'shape':
			case 'svg':
			case 'column':
			case 'image':
			break;
			case 'video':
				//for v6 fetching of rs_revicons
				if(empty($this->slider_7)){
					if(
						in_array(trim($this->get_val($layer, array('media', 'mediaType'))), array('streaminstagram', 'streaminstagramboth', 'html5'), true)
						&& $this->get_val($layer, array('media', 'largeControls'), true) === true
					){
						global $SR_GLOBALS;
						if(!isset($SR_GLOBALS['icon_sets']['RevIcon'])) $SR_GLOBALS['icon_sets']['RevIcon'] = array('css' => false, 'parsed' => false);
						$SR_GLOBALS['icon_sets']['RevIcon']['css'] = true;
					}
				}
			break;
			default:
			case 'text':
			case 'button':
				// this filter is needed for the weather AddOn
				$html = apply_filters('revslider_modify_layer_text', $text, $layer);
	
				$check_icons = array(
					$html,
					$this->get_val($layer, array('toggle', 'text')) //this part is needed for v6 data, to push icon sets //also check toggle data for v6
				);

				global $SR_GLOBALS;
				foreach($this->icon_sets as $font_handle => $is){
					foreach($check_icons as $_html){
						if(strpos($_html, $is) === false) continue;

						//include default Icon Sets if used
						if(!isset($SR_GLOBALS['icon_sets'][$font_handle])) $SR_GLOBALS['icon_sets'][$font_handle] = array('css' => false, 'parsed' => false);
						$SR_GLOBALS['icon_sets'][$font_handle]['css'] = true;

						$cache = RevSliderGlobals::instance()->get('RevSliderCache');
						$cache->add_addition('special', 'font_var', $font_handle);
					}
				}
			break;
		}
		
		if(!empty($this->slider_v7)){
			$ws = ($this->adv_resp_sizes == true) ? implode(',', (array)$this->get_val($layer, 'ws', 'full')) : $this->get_biggest_device_setting_v7($this->get_val($layer, 'ws', 'full'), $this->enabled_sizes, 'full');
		}else{
			$ws = ($this->adv_resp_sizes == true) ? $this->normalize_device_settings($this->get_val($layer, array('idle', 'whiteSpace')), $this->enabled_sizes, 'html-array', array('nowrap')) : $this->get_biggest_device_setting($this->get_val($layer, array('idle', 'whiteSpace'), 'nowrap'), $this->enabled_sizes);
		}
				
		//replace new lines with <br />
		$html = (strpos($ws, 'content') !== false || strpos($ws, 'full') !== false) ? nl2br($html) : $html;
		//do shortcodes here, so that nl2br is not done within the shortcode content
		
		return (!in_array($type, array('image', 'svg', 'column', 'shape'), true)) ? do_shortcode(stripslashes($html)) : $html;
	}

	/**
	 * get the layer ids as HTML
	 **/
	public function get_html_title(){
		$layer = $this->get_layer();
		$title	= (!empty($this->slider_v7)) ? $this->get_val($layer, array('attr', 'title')) : $this->get_val($layer, array('attributes', 'title'));
		
		return ($title != '') ? 'title="'.esc_attr($title).'"' : '';
	}

	/**
	 * get the HTML rel
	 **/
	public function get_html_rel(){
		$layer = $this->get_layer();
		$rel	= (!empty($this->slider_v7)) ? $this->get_val($layer, array('attr', 'rel')) : $this->get_val($layer, array('attributes', 'rel'));
		
		return ($rel != '') ? 'rel="'.esc_attr($rel).'"' : '';
	}

	/**
	 * get the Slides HTML of the Slider
	 **/
	public function get_slides(){
		$slides = (!empty($this->slider_v7)) ? $this->slider_v7->get_slides() : $this->slider->get_slides(); //fetch all slides connected to the Slider (no static slide)
		$slides = (!empty($this->slider_v7)) ? $this->slider_v7->get_language_slides_v7($slides) : $this->slider->get_language_slides_v7($slides); //get WPML language slides
		
		/**
		 * if we are now at 0 slides, there will be no more chances to add them
		 * so return back with no slides markup
		 **/
		if(empty($slides)) return false;

		/**
		 * if we are a stream
		 * duplicate slides as templates to the corresponding stream amount
		 * check if post, if the post has a specific slide template set
		 **/

		/**
		 * stream feed =  JSON
		 * - it should gather the feeds, prepare slides and push in the SR7.M[sliderid].stream
		 *
		 * stream feed =  REST
		 * - we gather feed, and print slides, layers and images that are SEO relevant
		 */
		$is_stream = (!empty($this->slider_v7)) ? $this->slider_v7->is_stream_post() : $this->slider->is_stream_post();
		if($is_stream) $slides = $this->multiply_slides($slides);

		$static_slide = (!empty($this->slider_v7)) ? $this->slider_v7->get_static_slide() : $this->slider->get_static_slide();

		if(!empty($static_slide)){
			$slides[] = $static_slide;
			$this->set_static_slide($static_slide);
		}

		$this->set_general_params_for_layers();

		if(!empty($this->slider_v7)){
			$this->set_current_slides_v7($slides);
		}else{
			$this->set_current_slides($slides);
		}
		
		foreach($slides ?? [] as $slide){
			$this->set_slide($slide);
			if($this->get_preview_mode() === false && !$slide->check_use_slide()) continue;
			$this->add_slide_li_pre();
			$this->add_slide_background_image();
			$this->set_slide_params_for_layers();
			$this->add_creative_layer();
			$this->add_slide_li_post();
		}
	}

	/**
	 * add the slide li with data attributes and so on
	 **/
	public function add_slide_li_pre(){
		echo RS_T6.'<sr7-slide';
		echo $this->get_html_slide_class();
		echo $this->get_html_slide_id();
		echo $this->get_html_slide_key();
		echo '>'."\n";
	}

	/**
	 * add the slide closing li 
	 **/
	public function add_slide_li_post(){
		echo RS_T6.'</sr7-slide>'."\n";
	}

	public function get_html_slide_class(){
		$class = (!empty($this->slider_v7)) ? $this->get_slide()->get_param(array('attr', 'class')) : $this->get_slide()->get_param(array('attributes', 'class'));
		
		return (!empty(trim($class))) ? ' class="'.esc_attr($class).'"' : '';
	}

	public function get_html_slide_id(){
		$id = (!empty($this->slider_v7)) ? $this->get_slide()->get_param(array('attr', 'id')) : $this->get_slide()->get_param(array('attributes', 'id'));
		$id = (empty($id)) ? $this->get_html_id().'-'.$this->get_slide()->get_id() : $id;

		return ' id="'.esc_attr($id).'"';
	}

	public function get_html_slide_key(){
		return ' data-key="'.esc_attr($this->get_slide()->get_id()).'"';
	}

	public function add_slide_background_image(){
		$slide	= $this->get_slide();
		
		if($slide->v7){
			$layer = $slide->get_bg_layer();
			$type	= '';
			
			if(!empty($layer)){
				$type			= 'image';
				$img			= $this->get_val($layer, array('bg', 'image', 'src'));
				if(empty($img)) return;

				$img_id			= $this->get_val($layer, array('bg', 'image', 'lib_id'));
				$img_filename	= basename($img);
				$alt_option 	= $slide->get_param(array('attr', 'aO'), $slide->get_param(array('attr', 'tO'), 'ml'));
				$title_option	= $slide->get_param(array('attr', 'tO'), 'ml');
				$this->set_layer($layer);
				$this->set_layer_unique_id();	
				$this->set_slide_id($slide->get_id());
				$ids			= $this->get_html_layer_ids();
			}
		}else{			
			$type			= $slide->get_param(array('bg', 'type'));
			$img			= $slide->image_url;
			if(empty($img)) return;

			$img_id			= $slide->image_id;
			$img_filename	= $slide->image_filename;
			$alt_option 	= $slide->get_param(array('attributes', 'altOption'), $slide->get_param(array('attributes', 'titleOption'), 'media_library'));
			$title_option	= $slide->get_param(array('attributes', 'titleOption'), 'media_library');
			$ids			= 'id="'.$this->get_html_id().'-'.$slide->get_id().'-slidebg"';
		}
		if($type !== 'image') return;
		
		$alt	= '';
		$title	= '';
		
		switch($alt_option){
			case 'ml':
			case 'media_library':
			default:
				$alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
			break;
			case 'fn':
			case 'file_name':
				$info = pathinfo($img_filename);
				$alt = $this->get_val($info, 'filename');
			break;
			case 'c':
			case 'custom':
				$alt = ($slide->v7) ? $slide->get_param(array('attr', 'a'), '') : $slide->get_param(array('attributes', 'alt'), '');
			break;
		}

		switch($title_option){
			case 'ml':
			case 'media_library':
			default:
				$title = get_the_title($img_id);
			break;
			case 'fn':
			case 'file_name':
				$info = pathinfo($img_filename);
				$title = $this->get_val($info, 'filename');
			break;
			case 'c':
			case 'custom':
				$title = ($slide->v7) ? $slide->get_param(array('attr', 't'), '') : $slide->get_param(array('attributes', 'title'), '');
			break;
		}

		$img = apply_filters('sr_add_slide_background_image_url', $img, $slide, $this);
		echo $this->ld().RS_T7.'<sr7-bg '.$ids.' class="sr7-layer"><noscript>';
		echo '<img src="'.esc_attr($img).'" alt="'.esc_attr(strip_tags($alt)).'" title="'.esc_attr(strip_tags($title)).'">';
		echo '</noscript></sr7-bg>'."\n";
	}

	/**
	 * put creative layer
	 */
	private function add_creative_layer(){
		$layers = $this->get_layers();
		if(empty($layers)) return false;
		
		$this->container_mode = '';
		foreach($layers as $layer){
			if(!in_array($this->get_val($layer, 'type', 'text'), array('text', 'button'), true)) continue; //only do text layer, if we are v6 data, then allow buttons also 
			if(!empty($this->slider_v7)){
				if(!in_array($this->get_val($layer, 'subtype', false), array('button', false), true)) continue; //only do text layer
			}
			
			$this->set_layer($layer);
			$this->add_layer(false);
		}
	}

	/**
	 * Adds a Layer to the stage
	 * Moved most code part from putCreativeLayer into putLayer
	 * @since: 5.3.0
	 * @before: RevSliderOutput::putLayer()
	 */
	public function add_layer($row_group_uid = false, $special_type = false){
		$layer = apply_filters('revslider_putLayer_pre', $this->get_layer(), $this, $row_group_uid, '', $special_type);
		//$layer = $this->get_layer(); //PK TODO, why was this added here? with it, the filter revslider_putLayer_pre is not properly used anymore
		$this->set_layer($layer);
		$this->set_layer_unique_id();
		
		/**
		 * top middle and bottom are placeholder layers, do not write them
		  **/
		if(in_array($this->get_layer_unique_id(), array('top', 'middle', 'bottom'), true)) return '';
		
		$slider_id			= (!empty($this->slider_v7)) ? $this->slider_v7->get_id() : $this->slider->get_id();
		$class				= '';
		$html_simple_link	= (!empty($this->slider_v7)) ? trim($this->get_action_link_v7()) : $this->get_action_link();
		$ids				= $this->get_html_layer_ids();
		if(empty($this->slider_v7)){ //this is only needed in v6 data, as $html_simple_link will be changed through an filter in addons
			$layer_actions		= $this->get_html_layer_action($html_simple_link);
		}
		$layer_tag			= $this->get_layer_tag($html_simple_link, $special_type);
		$html_class			= $this->get_html_class($class, $layer_tag);
		$html_title			= $this->get_html_title();
		$html_rel			= $this->get_html_rel();
		$html_layer			= $this->get_html_layer();
		$layertype 			= $this->get_layer_type();
		echo $this->ld().RS_T7.'<'.$layer_tag;
		echo ($ids != '')				? ' '.$ids : '';
		echo ($html_class !== '')		? ' '.$html_class : '';
		echo ($html_simple_link !== '')	? ' '.$html_simple_link : '';
		echo ($html_rel !== '')			? ' '.$html_rel : '';
		echo ($html_title !== '')		? ' '.$html_title : '';
		echo '>';//."\n";
		echo ($special_type === false && $layertype !== 'video') ? apply_filters('revslider_layer_content', $html_layer, $html_layer, $slider_id, $this->slide, $layer) : '';
		if($special_type === false){
			echo '</'.$layer_tag.'>'."\n";
		} //the closing will be written later, after all layers/columns are added
		
		$this->zIndex++;
	}
	
	public function get_custom_transitions(){
		$found	= array();
		$slides	= (!empty($this->slider_v7)) ? $this->get_current_slides_v7() : $this->get_current_slides();
		
		if(empty($slides)) return $found;

		$base_transitions = $this->get_base_transitions();

		$_transitions = array();
		if(!empty($this->slider_v7)){
			if($this->slider_v7->get_param(array('fs', 'as'), false) === true && $this->slider_v7->get_param('type') !== 'hero'){
				if($this->slider_v7->get_param(array('fs', 'a', 'rnd'), false) === true) $_transitions['rndany'] = 'rndany';
			}
		}else{
			if($this->slider->get_param(array('general', 'firstSlide', 'set'), false) == true && $this->slider->get_param('type') !== 'hero'){
				$transition = $this->slider->get_param(array('general', 'firstslide', 'type'), 'fade');
				if(in_array($transition, array('random', 'random-static', 'random-premium'), true)) $transition = 'rndany';
				$_transitions[$transition] = $transition;
			}
		}

		foreach($slides as $slide){
			if(!empty($this->slider_v7)){
				$layers = $slide->get_layers();
				if(empty($layers)) continue;
			
				foreach($layers as $layer){
					if($this->get_val($layer, 'subtype') !== 'slidebg') continue;
					if($this->get_val($layer, array('tl', 'in', 'bg', 'rnd'), false) === false) continue;
					$_transitions['rndany'] = 'rndany';
				}
			}else{
				$transitions = (array)$slide->get_param(array('timeline', 'transition'), 'fade');
				$preset		 = $slide->get_param(array('slideChange', 'preset'), false);

				if($preset !== false) $transitions[] = $preset;
				if(empty($transitions)) continue;

				foreach($transitions as $transition){
					if(in_array($transition, array('random', 'random-static', 'random-premium'), true)) $transition = 'rndany';
					$_transitions[$transition] = $transition;
				}
			}
		}

		if(empty($_transitions)) return $found;

		foreach($_transitions as $transition){
			if(strpos($transition, 'rnd') !== false) continue;

			foreach($base_transitions as $name => $keys){
				if(!is_array($keys) || empty($keys)) continue;

				foreach($keys as $k => $t){
					if(!is_array($t) || empty($t)) continue;
					
					if(!isset($t[$transition])) continue;

					if(!isset($found[$name])){
						$found[$name] = array();
						foreach($base_transitions[$name] as $key => $value){ //add strings like icon, noSubLevel
							if(is_array($value)) continue;

							$found[$name][$key] = $value;
						}
					}
					$found[$name][$transition] = $t[$transition];
					
					break;
				}
			}
		}
		foreach($_transitions as $transition){
			if(strpos($transition, 'rnd') === false) continue;
		
			$cat = array_keys($base_transitions);
			if(isset($cat[array_search('random', $cat)])) unset($cat[array_search('random', $cat)]);

			//push 10 random transitions from $base_transitions! make sure not to use the 'random' branch
			$max = 0;
			for($i = 0; $i < 10; $i++){
				$use_cat = $cat[array_rand($cat)];
				$sub_cat = array_keys($base_transitions[$use_cat]);

				//remove strings from the list to use
				foreach($base_transitions[$use_cat] as $check => $array){
					if(!is_array($array)) unset($sub_cat[array_search($check, $sub_cat)]);
				}
				
				$sub_index	= $sub_cat[array_rand($sub_cat)];
				$push_index = array_keys($base_transitions[$use_cat][$sub_index]);
				$push_key	= $push_index[array_rand($push_index)];
				
				if(isset($found[$use_cat]) && isset($found[$use_cat][$sub_index])){
					$i--; //already existing, get another one
				}else{
					if(!isset($found[$use_cat])) $found[$use_cat] = array();
					if(!isset($found[$use_cat][$sub_index])) $found[$use_cat][$sub_index] = array();
					$found[$use_cat][$sub_index][$push_key] = $base_transitions[$use_cat][$sub_index][$push_key];
				}
				$max++;
				if($max >= 100) $i = 10; //make sure to not fall into a loop here if all transitions are already added
			}

			break;
		}

		return $found;
	}

	/**
	 * get all custom navigations
	 * only needed if we are v6 data on a v7 output
	 **/
	public function get_custom_nagivations(){
		$found	= array('arrows' => array(), 'thumbs' => array(), 'bullets' => array(), 'tabs' => array(), 'scrubber' => array());
		
		//only push data if we are coming from v6 data and print a v7 frontend
		if(!empty($this->slider_v7)) return $found;
		if($this->slider->get_param('type', 'standard') === 'hero') return $found;

		$enable_arrows		= $this->slider->get_param(array('nav', 'arrows', 'set'), false);
		$enable_bullets		= $this->slider->get_param(array('nav', 'bullets', 'set'), false);
		$enable_tabs		= $this->slider->get_param(array('nav', 'tabs', 'set'), false);
		$enable_thumbnails	= $this->slider->get_param(array('nav', 'thumbs', 'set'), false);
		$enable_scrubber	= $this->slider->get_param(array('nav', 'scrubber', 'set'), false);
		
		if($enable_arrows == false && $enable_bullets == false && $enable_tabs == false && $enable_thumbnails == false && $enable_scrubber == false) return $found;
		$slides = $this->get_current_slides();
		
		if(empty($slides)) return $found;

		global $SR_GLOBALS;
		if(!isset($SR_GLOBALS['icon_sets']['RevIcon'])) $SR_GLOBALS['icon_sets']['RevIcon'] = array('css' => false, 'parsed' => false);
		$SR_GLOBALS['icon_sets']['RevIcon']['css'] = true;
		
		$rs_nav		= new RevSliderNavigation();
		$all_navs	= $rs_nav->get_all_navigations();
		if(empty($all_navs)) return $found;

		foreach($slides as $slide){
			foreach($all_navs as $key => $cur_nav){
				//get modifications out, wrap the class with slide class to be specific
				if($enable_arrows == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'arrows', 'style'), 'new-bullet-bar'))		$found['arrows'][$cur_nav['id']]	= $cur_nav;
				if($enable_bullets == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'bullets', 'style'), 'round'))			$found['bullets'][$cur_nav['id']]	= $cur_nav;
				if($enable_tabs == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'tabs', 'style'), 'round'))					$found['tabs'][$cur_nav['id']]		= $cur_nav;
				if($enable_thumbnails == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'thumbs', 'style'), 'new-bullet-bar'))	$found['thumbs'][$cur_nav['id']]	= $cur_nav;
				if($enable_scrubber == true && $cur_nav['id'] == $this->slider->get_param(array('nav', 'scrubber', 'style'), ''))				$found['scrubber'][$cur_nav['id']]	= $cur_nav;
			}
		}

		return $found;
	}


	/**
	 * Set variables that are later printed like in the add_js() function
	 **/
	public function set_javascript_variables(){
		global $SR_GLOBALS;
		$navs	= $this->get_custom_nagivations();
		$trans	= $this->get_custom_transitions();

		if(!empty($navs)){
			foreach($navs as $type => $_nav){
				if(empty($_nav)) continue;

				foreach($_nav as $key => $nav){
					if(isset($SR_GLOBALS['collections']['nav'][$type][$key])) continue;
					if(!isset($SR_GLOBALS['collections']['nav'][$type])) $SR_GLOBALS['collections']['nav'][$type] = array();

					$SR_GLOBALS['collections']['nav'][$type][$key] = $nav;
				}
			}
		}

		if(!empty($trans)){
			foreach($trans as $type => $_trans){
				if(empty($_trans)) continue;

				foreach($_trans as $key => $tran){
					if(isset($SR_GLOBALS['collections']['trans'][$type][$key])) continue;
					if(!isset($SR_GLOBALS['collections']['trans'][$type])) $SR_GLOBALS['collections']['trans'][$type] = array();

					$SR_GLOBALS['collections']['trans'][$type][$key] = $tran;
				}
			}
		}

		if(empty($this->slider)) return;
		$sid = $this->get_slider_id();
		$map = $this->get_v7_slider_map($sid);
		if(empty($map)) return;

		if(!isset($SR_GLOBALS['collections']['v6tov7'])) $SR_GLOBALS['collections']['v6tov7'] = array();
		if(!isset($SR_GLOBALS['collections']['v6tov7']['n'])) $SR_GLOBALS['collections']['v6tov7']['n'] = array();
		if(!isset($SR_GLOBALS['collections']['v6tov7']['s'])) $SR_GLOBALS['collections']['v6tov7']['s'] = array();
		if(isset($map['n']) && !empty($map['n'])) $SR_GLOBALS['collections']['v6tov7']['n'] += $map['n'];
		if(isset($map['s']) && !empty($map['s'])) $SR_GLOBALS['collections']['v6tov7']['s'] += $map['s'];
	}


	/**
	 * add JavaScript
	 **/
	public function add_js(){
		global $SR_GLOBALS;

		if($SR_GLOBALS['js_init'] === true && $SR_GLOBALS['loaded_by_editor'] !== true) return;

		echo '<script>'."\n";
		do_action('revslider_pre_add_js', $this);
		if($SR_GLOBALS['loaded_by_editor'] === true){
			echo RS_T.'SR7.E.elementorBackend  = true;'."\n";
		}
		
		if($this->get_val($this->global_settings, array('getTec', 'core'), 'MIX') !== 'REST' || $SR_GLOBALS['markup_export'] === true){
			//get all sliders that have been loaded and write their JSON
			$SR_front = RevSliderGlobals::instance()->get('RevSliderFront');
			echo $SR_front->load_v7_slider();
		}

		echo RS_T."if (SR7.F.init) SR7.F.init(); // DOUBLE CALL NOT A PROBLEM, MANAGED IN INIT"."\n";
		echo RS_T."document.addEventListener('DOMContentLoaded', function() {if (SR7.F.init) SR7.F.init(); else SR7.shouldBeInited = true;});"."\n";
		echo RS_T."window.addEventListener('load', function() {if (SR7.F.init) SR7.F.init(); else SR7.shouldBeInited = true; });"."\n";

		if(!empty($SR_GLOBALS['collections']['trans'])){
			echo RS_T.'SR7.E.transtable ??={};'."\n";
			echo RS_T.'SR7.E.transtable = JSON.parse('. $this->json_encode_client_side($SR_GLOBALS['collections']['trans'], JSON_INVALID_UTF8_IGNORE) .');'."\n";
		}
		if(!empty($SR_GLOBALS['collections']['nav'])){
			foreach($SR_GLOBALS['collections']['nav'] as $nav){
				if(!empty($nav)){
					echo RS_T.'SR7.NAV ??={};'."\n";
					echo RS_T.'SR7.NAV = JSON.parse('. $this->json_encode_client_side($SR_GLOBALS['collections']['nav'], JSON_INVALID_UTF8_IGNORE) .');'."\n";
					break;
				}
			}
		}
		if(!empty($SR_GLOBALS['collections']['js']) && !empty($SR_GLOBALS['collections']['js']['stream'])){
			echo RS_T.'SR7.M ??={};'."\n";
			foreach($SR_GLOBALS['collections']['js']['stream'] as $id => $stream){
				echo RS_T."SR7.M['".$id."'] ??={};"."\n";
				echo RS_T."SR7.M['".$id."'].stream ??={};"."\n";
				echo RS_T."SR7.M['".$id."'].stream = JSON.parse(". $this->json_encode_client_side($stream, JSON_INVALID_UTF8_IGNORE) .");"."\n";
			}
			$date = array(
				'date' => get_option('date_format'),
				'time' => get_option('time_format')
			);
			echo RS_T.'SR7.G??={}'."\n";
			echo RS_T.'SR7.G.formats??={}'."\n";
			echo RS_T.'SR7.G.formats.date = JSON.parse('. $this->json_encode_client_side($date, JSON_INVALID_UTF8_IGNORE) .');'."\n";
		}

		if(!empty($SR_GLOBALS['collections']['v6tov7']) && (isset($SR_GLOBALS['collections']['v6tov7']['n']) && !empty($SR_GLOBALS['collections']['v6tov7']['n']) || isset($SR_GLOBALS['collections']['v6tov7']['s']) && !empty($SR_GLOBALS['collections']['v6tov7']['s']))){
			echo RS_T.'SR7.E.v6v7ids ??= {}' ."\n";
			echo RS_T.'SR7.E.v6v7ids = JSON.parse('. $this->json_encode_client_side($SR_GLOBALS['collections']['v6tov7'], JSON_INVALID_UTF8_IGNORE) .');'."\n";
		}

		do_action('revslider_post_add_js', $this);
		echo '</script>'."\n";

		$SR_GLOBALS['js_init'] = true;
	}

	/**
	 * translates the offset that can be added to the shortcodes in a JS format for the specific slider
	 **/
	public function translate_shortcode_offset(){
		$offset = $this->offset;
		if(empty($offset)) return '';
		$pairs = explode(';', $offset);
		
		if(empty($pairs)) return '';
		
		$result = array();
		foreach($pairs as $pair){
			$parts	= explode(':', $pair);
			if(count($parts) !== 2) continue;

			$value	= $parts[1];
			$values = explode(',', $value);
			if(empty($values)) continue;
			
			if(count($values) < 5){
				while(count($values) < 5){
					array_unshift($values, $values[0]);
				}
			}
			$result[$parts[0]] = $values;
		}

		return $result;
	}

	/**
	 * if we are a stream, we use the slides as slide templates
	 * multiply them and add content depending on how mamy post/streams we have
	 */
	public function multiply_slides($slides){
		$custom		= array();
		$templates	= $slides;
		$slides		= array();
		$templates	= $this->assoc_to_array($templates);
		$count		= count($templates);
		$key		= 0;
		$post_slider= (!empty($this->slider_v7)) ? $this->slider_v7->is_posts() : $this->slider->is_posts();
		$stream_slider= (!empty($this->slider_v7)) ? $this->slider_v7->is_stream() : $this->slider->is_stream();
		$slider_id	= (!empty($this->slider_v7)) ? $this->slider_v7->get_id() : $this->slider->get_id();

		foreach($this->stream_data ?? [] as $k => $post){
			if($post_slider === true || $stream_slider !== false){
				$slide = new RevSliderSlide();
				$slide->init_by_post_data_v7($post, $templates[$key], $slider_id);
			}else{
				$slide	= clone $templates[$key];
			}
			$k	+= 1;
			$slide->set_id($slide->get_id().'STR'.$k);
			$key++;
			$slides[] = $slide;
			if($key == $count) $key = 0;
		}

		return $slides;
	}

	/**
	 * add error message into the console
	 */
	public function print_error_message_console($message){

		$message = (!empty($this->slider_v7)) ? $this->slider_v7->get_title().': '.$message : $this->slider->get_title().': '.$message;
		echo '<script>';
		echo 'console.log("'.esc_html($message).'")';
		echo '</script>'."\n";
	}

	/**
	 * put inline error message in a box.
	 * @before: RevSliderOutput::putErrorMessage
	 */
	public function print_error_message($message, $open_page = false){
		global $SR_GLOBALS;
		
		//$id	 = '';
		$html	 = '';
		$html_id = 'SR7_ERROR_'.$SR_GLOBALS['serial'];
		$data_id = 'ERROR'; //.$SR_GLOBALS['serial'];

		/*if(!empty($this->get_html_id()){
			$slides = (!empty($this->slider_v7)) ? $this->get_current_slides_v7() : $this->get_current_slides();
			
			if(!empty($slides)){
				foreach($slides as $slide){
					$id = $slide->get_id();
					break;
				}
			}
		}*/
		
		//$alias = (!empty($this->slider_v7)) ? $this->slider_v7->get_alias() : $this->slider->get_alias();
		
		//$url = (empty($html_id) || !is_user_logged_in() || $id === '') ? '' : admin_url('admin.php?page=revslider&view=slide&id='.$id);
		//$page_url = ($open_page === true && is_user_logged_in()) ? get_edit_post_link() : '';
		//$html .= (!empty($url)) ? '<br>'.__('Please follow this link to edit the slider:', 'revslider') : '';
		//$html .= (!empty($url)) ? RS_T6.'<a href="'.$url.'" target="_blank" rel="noopener" class="rs_error_message_button">Edit Module : "'.$alias.'"</a>'."\n" : '';
		//$html .= (!empty($page_url)) ? RS_T6.'<a href="'.$page_url.'" target="_blank" rel="noopener" class="rs_error_message_button">Edit Page</a>'."\n" : '';
		
		$html .= "\n".RS_T3.'<sr7-module data-alias="Error-Module" data-id="'.$data_id.'" id="'.$html_id.'" class="" data-version="'.RS_REVISION.'">'."\n";
		$html .= RS_T4.'<sr7-adjuster></sr7-adjuster>'."\n";
		$html .= RS_T4.'<sr7-content>'."\n";
		$html .= RS_T5.'<sr7-slide id="'.$html_id.'-1" data-key="1">'."\n";
		$html .= RS_T6.'<sr7-txt id="'.$html_id.'-1-1" class="sr7-layer">'.esc_html($message).'</sr7-txt>'."\n";
		$html .= RS_T6.'<sr7-txt id="'.$html_id.'-1-2" class="sr7-layer">There is nothing to show here!</sr7-txt>'."\n";
		$html .= RS_T6.'<sr7-txt id="'.$html_id.'-1-3" class="sr7-layer"><i class="fa-warning"></i></sr7-txt>'."\n";
		$html .= RS_T5.'</sr7-slide>'."\n";		
		$html .= RS_T4.'</sr7-content>'."\n";
		$html .= RS_T3.'</sr7-module>'."\n";
		$html .= RS_T3.'<script>'."\n";
		$html .= RS_T4.'window.SR7 ??= {};'."\n";
		$html .= RS_T4.'SR7.JSON ??= {};'."\n";
		$html .= RS_T4.'SR7.JSON["'.$html_id.'"] = {id:"'.$data_id.'", settings:{"title":"Error Module","alias":"Error Module","type":"hero", "size":{"width": [1240,1240,1024,778,480],"height": [600,600,600,600,480]}},"slides":{"1":{"slide":{"id":"1","version":"'.RS_REVISION.'","order":1},"layers":{"1":{"fluid":{"tx":true,"tr":true,"sp":true},"id":1,"alias":"Subtext","size":{"w":["850px","800px","600px","450px","450px"]}, "content":{"text":"'.esc_html($message).'"},"pos":{"y":["30px","30px","20px","16px","13px"],"h":["center","center","center","center","center"],"v":["middle","middle","middle","middle","middle"],"pos":"absolute"},"zIndex":6,"order":6,"display":["block","block","block","block","block"],"tl":{"in":{"content":{"all":[{"t":0,"d":0,"f":0,"e":"power3.inOut","pE":"d","sX":0.9,"sY":0.9,"o":0},{"t":370,"d":850,"f":850,"e":"power3.inOut","pE":"d","sX":1,"sY":1,"o":1}]}},"out":{"content":{"all":[{"t":0,"d":300,"f":300,"e":"power3.inOut","pE":"n","o":0}]}}},"tA":["center","center","center","center","center"],"color":["#000000","#000000","#000000","#000000","#000000"],"font":{"family":\'Arial, Helvetica, sans-serif\',"size":["#a",20,16,12,7],"weight":["200","200","200","200","200"],"ls":[0,0,0,0,0]},"lh":["#a","24px","20px","16px","7px"],"type":"text"},"2":{"fluid":{"tx":true,"tr":true,"sp":true},"id":2,"alias":"Title","content":{"text":"There is nothing to show here!"},"pos":{"y":["-20px","-20px","-16px","-12px","-7px"],"h":["center","center","center","center","center"],"v":["middle","middle","middle","middle","middle"],"pos":"absolute"},"zIndex":7,"order":7,"display":["block","block","block","block","block"],"tl":{"in":{"content":{"all":[{"t":0,"d":0,"f":0,"e":"power3.inOut","pE":"d","sX":0.9,"sY":0.9,"o":0},{"t":200,"d":1000,"f":1000,"e":"power3.inOut","pE":"d","sX":1,"sY":1,"o":1}]}},"out":{"content":{"all":[{"t":0,"d":300,"f":300,"e":"power3.inOut","pE":"n","o":0}]}}},"tA":["center","center","center","center","center"],"color":["#000000","#000000","#000000","#000000","#000000"],"font":{"family":"\'Arial, Helvetica, sans-serif\'","size":["30px","30px","24px","18px","11px"],"weight":["200","200","200","200","200"],"ls":[0,0,0,0,0]},"lh":["30px","30px","24px","18px","11px"],"type":"text"},"3":{"fluid":{"tx":true,"tr":true,"sp":true},"id":3,"alias":"Title","content":{"text":"<i class=\\"fa-warning\\"></i>"},"pos":{"y":["-70px","-70px","-57px","-43px","-26px"],"h":["center","center","center","center","center"],"v":["middle","middle","middle","middle","middle"],"pos":"absolute"},"zIndex":8,"order":8,"display":["block","block","block","block","block"],"tl":{"in":{"content":{"all":[{"t":0,"d":0,"f":0,"e":"power3.inOut","pE":"d","sX":0.9,"sY":0.9,"o":0},{"t":0,"d":1040,"f":1040,"e":"power3.inOut","pE":"d","sX":1,"sY":1,"o":1}]}},"out":{"content":{"all":[{"t":0,"d":300,"f":300,"e":"power3.inOut","pE":"n","o":0}]}}},"tA":["center","center","center","center","center"],"color":["#ff3a2d","#ff3a2d","#ff3a2d","#ff3a2d","#ff3a2d"],"font":{"family":"\'Arial, Helvetica, sans-serif\'","size":["50px","50px","41px","31px","19px"],"weight":[400,400,400,400,400],"ls":[0,0,0,0,0]},"lh":["50px","50px","41px","31px","19px"],"type":"text"},"32":{"rTo":"slide","id":32,"subtype":"slidebg","size":{"cMode":"cover"},"bg":{"color":"#ffffff"},"tl":{"in":{"bg":{"ms":1000,"rnd":false,"temp":{"t":"*opacity* Fade In","p":"fade","m":"basic","g":"fade"},"in":{"o":0},"out":{"a":false}}}},"type":"shape"}}}}}'."\n";
		$html .= RS_T4.'SR7.PMH ??={}; SR7.PMH["'. $html_id .'"] = {cn:0,state:false,fn: function() { if (_tpt!==undefined && _tpt.prepareModuleHeight !== undefined) {_tpt.prepareModuleHeight({id:"'. $html_id .'","size":{"width":[1240,1240,1024,778,480],"height":[900,900,768,960,720]}}); SR7.PMH["'. $html_id .'"].state=true;} else if((SR7.PMH["'. $html_id .'"].cn++)<100) setTimeout( SR7.PMH["'. $html_id .'"].fn,19);}}; SR7.PMH["'. $html_id .'" ].fn();';
		$html .= RS_T3.'</script>'."\n";

		add_action('wp_print_footer_scripts', array($this, 'add_js'), 100);
		
		echo $html;
	}

	/**
	 * set general values that are needed by layers
	 * this is needed to be called before any layer is added to the stage
	 **/
	public function set_general_params_for_layers(){
		if(!empty($this->slider_v7)){
			$this->enabled_sizes = $this->slider_v7->get_responsive_sizes();
			$this->adv_resp_sizes = $this->enabled_sizes['ld'] == true || $this->enabled_sizes['n'] == true || $this->enabled_sizes['t'] == true || $this->enabled_sizes['m'] == true;
		}else{
			$this->enabled_sizes = $this->slider->get_responsive_sizes();
			$this->adv_resp_sizes = $this->enabled_sizes['n'] == true || $this->enabled_sizes['t'] == true || $this->enabled_sizes['m'] == true;
		}

		$this->icon_sets = $this->set_icon_sets(array('material-icons'));
	}

	public function get_used_icons(){
		global $SR_GLOBALS;
		$icon_sets			= array();
		$ignore_fa			= $this->_truefalse($this->get_val($this->global_settings, 'fontawesomedisable', false));
		
		if($ignore_fa === false){
			if($this->get_val($SR_GLOBALS, array('icon_sets', 'FontAwesome', 'css'), false) === true)		$icon_sets['FontAwesome'] = true;
			if($this->get_val($SR_GLOBALS, array('icon_sets', 'FontAwesomeIcon', 'css'), false) === true)	$icon_sets['FontAwesome'] = true;
		}
		if($this->get_val($SR_GLOBALS, array('icon_sets', 'PeIcon', 'css'), false) === true)				$icon_sets['PeIcon'] = true;
		if($this->get_val($SR_GLOBALS, array('icon_sets', 'Materialicons', 'css'), false) === true)			$icon_sets['Materialicons'] = true;
		if($this->get_val($SR_GLOBALS, array('icon_sets', 'RevIcon', 'css'), false) === true)				$icon_sets['RevIcon'] = true;

		return $icon_sets;
	}

	public function add_fonts_v6(){
		global $SR_GLOBALS;
		$gfsub	= $this->slider->get_param('subsets', array());
		$gf		= $this->slider->get_used_fonts(false);
		$icons	= $this->get_used_icons();
		
		if(!empty($icons)){
			foreach($icons as $font => $values){
				if(in_array($font, array('Materialicons', 'PeIcon', 'FontAwesome', 'RevIcon'), true)){
					if(!isset($SR_GLOBALS['fonts'])) $SR_GLOBALS['fonts'] = array('queue' => array(), 'loaded' => array(), 'custom' => array());
					if($values === true) $SR_GLOBALS['fonts']['queue'][$font] = true;
				}
			}
		}
		
		foreach($gf as $gfk => $gfv){
			$variants	= array('normal' => array(), 'italic' => array());
			$subsets	= array('normal' => array(), 'italic' => array());
			if(!empty($gfv['variants'])){
				foreach($gfv['variants'] as $mgvk => $mgvv){
					if(strpos($mgvk, 'italic') !== false){
						$mgvk = str_replace('italic', '', $mgvk);
						$mgvk = (empty($mgvk)) ? 400 : $mgvk;
						$variants['italic'][$mgvk] = $mgvk;
					}else{
						$variants['normal'][$mgvk] = $mgvk;
					}
				}
			}
			
			if(!empty($gfv['subsets'])){
				foreach($gfv['subsets'] as $ssk => $ssv){
					if(array_search(esc_attr($gfk.'+'.$ssv), $gfsub) !== false){
						$subsets['normal'][$ssv] = $ssv;
					}
				}
			}
			
			$url = (isset($gfv['url'])) ? $gfv['url'] : '';

			$this->set_clean_font_import_v7($gfk, $url, $variants, $subsets);
		}
	}

	public function add_fonts_v7(){
		global $SR_GLOBALS;
		$gf	= $this->slider_v7->get_param('fonts', array());
		
		if(empty($gf)) return true;
		
		$custom_fonts = $this->get_val($this->global_settings, 'customFontList', array());
		$keys = array('normal', 'italic');
		
		foreach($gf as $font => $values){
			$branch = 'queue';
			if(in_array($font, array('Materialicons', 'PeIcon', 'FontAwesome', 'RevIcon'), true)){
				if(!isset($SR_GLOBALS['fonts'])) $SR_GLOBALS['fonts'] = array('queue' => array(), 'loaded' => array(), 'custom' => array());
				if($values === true) $SR_GLOBALS['fonts']['queue'][$font] = true;
			}
			if(!is_array($values)) continue;

			$variants	= array('normal' => array(), 'italic' => array());
			$subsets	= array('normal' => array(), 'italic' => array());
			foreach($keys as $key){
				if(!isset($values[$key]) || !is_array($values[$key])) continue;
				if(!isset($variants[$key])) $variants[$key] = array();
				
				foreach($values[$key] as $weight => $ign){
					$variants[$key][$weight] = $weight;
				}
			}

			if(empty($variants['normal']) && empty($variants['italic'])) $variants['normal'][400] = 400;

			if($this->get_val($values, 'custom', false) === true){
				//add url
				foreach($custom_fonts ?? [] as $cfont){
					if($cfont['family'] !== str_replace(array('"', "'"), '', $values['name'])) continue;
					$values['url'] = ($this->_truefalse($cfont['frontend']) === true) ? $cfont['url'] : '';
					break;
				}
			}else{ //only allow google fonts, no system fonts
				if(!isset($googlefonts)) include(RS_PLUGIN_PATH . 'includes/googlefonts.php');
				$_font = str_replace(array('+', '"', "'"), array(' ', '', ''), $font);
				if(!isset($googlefonts[$_font])) $branch = 'custom';
			}

			$url = (isset($values['url'])) ? $values['url'] : '';
			
			$this->set_clean_font_import_v7($font, $url, $variants, $subsets, $branch);
		}
	}

	/**
	 * set the font clean for import
	 * @before: RevSliderOperations::setCleanFontImport()
	 */
	public function set_clean_font_import_v7($font, $url = '', $variants = array(), $subsets = array(), $branch = 'queue'){
		global $SR_GLOBALS;
		
		if(!isset($SR_GLOBALS['fonts'])) $SR_GLOBALS['fonts'] = array('queue' => array(), 'loaded' => array(), 'custom' => array()); //if this is called without revslider.php beeing loaded
		
		if(!empty($variants) || !empty($subsets)){
			if(!isset($SR_GLOBALS['fonts'][$branch][$font])) $SR_GLOBALS['fonts'][$branch][$font] = array();
			if(!isset($SR_GLOBALS['fonts'][$branch][$font]['variants'])) $SR_GLOBALS['fonts'][$branch][$font]['variants'] = array();
			if(!isset($SR_GLOBALS['fonts'][$branch][$font]['subsets'])) $SR_GLOBALS['fonts'][$branch][$font]['subsets'] = array();
			
			if(!empty($variants)){
				foreach($variants as $type => $variant){
					if(empty($variant)) continue;
					if(!isset($SR_GLOBALS['fonts'][$branch][$font]['variants'][$type])) $SR_GLOBALS['fonts'][$branch][$font]['variants'][$type] = array();
					foreach($variant as $k => $v){
						//check if the variant is already in loaded
						if(!in_array($v, $SR_GLOBALS['fonts'][$branch][$font]['variants'][$type], true)){
							$SR_GLOBALS['fonts'][$branch][$font]['variants'][$type][] = $v;
						}else{ //already included somewhere, so do not call it anymore
							unset($variants[$type][$k]);
						}
					}
				}
			}

			foreach($subsets ?? [] as $k => $v){
				if(!in_array($v, $SR_GLOBALS['fonts'][$branch][$font]['subsets'], true)){
					$SR_GLOBALS['fonts'][$branch][$font]['subsets'][] = $v;
				}else{ //already included somewhere, so do not call it anymore
					unset($subsets[$k]);
				}
			}

			if($url !== ''){
				$SR_GLOBALS['fonts'][$branch][$font]['url'] = $url;
				$SR_GLOBALS['fonts'][$branch][$font]['load'] = true;
			}
		}
	}

	public function transform_ids_v6_to_v7($slides){
		if(empty($slides)) return $slides;

		$map = $this->get_v7_slider_map($this->get_slider_id());
		if(empty($map)) return $slides;

		foreach($slides ?? [] as $k => $slide){
			$oID = $slide->get_id();
			$append = '';

			$sk		= ($slide->get_param(array('static', 'isstatic'), false) === true) ? 's' : 'n';
			$from	= intval($oID);
			if ($from != $oID) $append = substr_replace($oID, '', 0, strlen($from));
			$to		= $this->get_val($map, array($sk, $from), false);
			if($to === false) continue;

			$slide->set_id($to . $append);
			$slides[$k] = $slide;
		}

		return $slides;
	}
	
	/**
	 * Check if shortcodes exists in the content
	 * @since: 5.0
	 */  
	public static function check_for_shortcodes($mid_content){
		if($mid_content === null) return false;
		if(!has_shortcode($mid_content, 'gallery')) return false;

		preg_match('/\[gallery.*ids=.(.*).\]/', $mid_content, $img_ids);
		
		return (isset($img_ids[1]) && $img_ids[1] !== '') ? explode(',', $img_ids[1]) : false;
	}

	/**
	 * add all options that change the slider here, for the cache to properly work
	 * @since: 6.4.6
	 **/
	public function get_transient_alias(){
		global $SR_GLOBALS;

		$transient = 'revslider_slider';
		$transient .= '_'.$this->get_slider_id();
		
		$args = array(
			'fontdownload' => $this->get_val($this->global_settings, 'fontdownload', 'off'),
			'serial'	=> $SR_GLOBALS['serial'],
			'admin'		=> is_admin(),
			'settings'	=> $this->custom_settings,
			'order'		=> $this->custom_order,
			'usage'		=> $this->usage,
			'modal'		=> $this->modal,
			'layout'	=> $this->sc_layout,
			'skin'		=> $this->custom_skin,
			'offset'	=> $this->offset,
			'mid_content' => $this->gallery_ids,
			//'export'	=> $this->markup_export,
			'preview'	=> $this->preview_mode,
			//'published'	=> $this->only_published
		);
		
		if($this->get_preview_mode() === false){
			$SR_wpml = RevSliderGlobals::instance()->get('RevSliderWpml');
			$slider = (!empty($this->slider_v7)) ? $this->slider_v7 : $this->slider;
			$args['lang'] = $SR_wpml->get_slider_language($slider);
		}
		
		$transient .= '_'.md5(json_encode($args));
		
		return $transient;
	}

	/**
	 * print data from caching if caching is on and data is existing
	 **/
	public function get_from_caching(){
		//check if caching should be active or not
		$cache			= RevSliderGlobals::instance()->get('RevSliderCache');
		$source_type	= (!empty($this->slider_v7)) ? $this->slider_v7->get_param(array('source', 'type'), 'gallery') : $this->slider->get_param('sourcetype', 'gallery');
		$can_do_cache	= ($this->get_preview_mode() === false && $cache->is_supported_type($source_type)) ? true : false;
		$this->caching	= ($cache->is_enabled() && $can_do_cache) ? true : false;
		$do_cache		= (!empty($this->slider_v7)) ? $this->slider_v7->get_param(array('general', 'icache'), 'default') : $this->slider->get_param(array('general', 'icache'), 'default');
		$this->caching	= ($do_cache === 'on' && $can_do_cache) ? true : $this->caching;
		$this->caching	= ($do_cache === 'off') ? false : $this->caching;
		
		//add caching if its enabled
		if($this->caching === false) return false;
		$transient	= $this->get_transient_alias();
		$content	= get_transient($transient);
		if($content === false) return false;
	
		$content = json_decode($content, true);
		if(!isset($content['html'])) return false;

		echo $cache->do_html_changes($content['html']);
		
		$cache->do_additions($this->get_val($content, 'addition', array()), $this);

		return true;
	}
}
