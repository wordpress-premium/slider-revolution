<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderSlider extends RevSliderFunctions {
	
	public $id;
	public $title;
	public $alias;
	public $settings		= array();
	public $params			= array();
	public $metas			= array();
	public $slides;
	public $type;
	public $inited			= false;
	public $map;
	public $is_woocommerce	= false;
	public $gallery_ids		= false;
	public $is_gallery		= false;
	public $language		= 'all';
	public $v7				= false;

	/**
	 * @var RevSliderSlide
	 */
	public $_static_slide;
	
	/**
	 * used to determinate if we need to init the layers of the Slides
	 * can cause heavy ram usage on slider overview page if we have 100+ Sliders
	 **/
	public $init_layer = true;

	public function __construct(){
		parent::__construct();
		$this->map = array();
	}
	
	/**
	 * START: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * old version of get_param();
	 * added for compatibility with old AddOns
	 **/
	public function getParam($key, $default = '', $validateType = null, $title = ''){
		$this->add_deprecation_message('getParam', 'get_param');
		return $this->get_param($key, $default);
	}
	
	/**
	 * old version of get_param();
	 * added for compatibility with old AddOns
	 **/
	public function getParams(){
		$this->add_deprecation_message('getParams', 'get_params');
		return $this->get_params();
	}
	
	/**
	 * old version of get_id();
	 * added for compatibility with old AddOns
	 **/
	public function getID(){
		$this->add_deprecation_message('getID', 'get_id');
		return $this->get_id();
	}
	
	/**
	 * old version of get_sliders();
	 * added for compatibility with old AddOns
	 **/
	public function getArrSliders($templates = false){
		$this->add_deprecation_message('getArrSliders', 'get_sliders');
		return $this->get_sliders($templates);
	}
	
	/**
	 * old version of init_by_mixed();
	 * added for compatibility with old Themes
	 **/
	public function initByMixed($mixed){
		$this->add_deprecation_message('initByMixed', 'init_by_mixed');
		$this->init_by_mixed($mixed);
	}
	
	/**
	 * old version of init_by_id();
	 * added for compatibility with old AddOns
	 **/
	public function initByID($sid){
		$this->add_deprecation_message('initByID', 'init_by_id');
		$this->init_by_id($sid);
	}
	
	/**
	 * old version of initByAlias();
	 */
	public function initByAlias($alias){
		$this->add_deprecation_message('initByAlias', 'init_by_alias');
		$this->init_by_alias($alias);
	}
	
	/**
	 * old version of get_alias();
	 */
	public function getAlias(){
		$this->add_deprecation_message('getAlias', 'get_alias');
		return $this->get_alias();
	}
	
	/**
	 * old version of check_alias();
	 */
	public function isAliasExistsInDB($alias){
		$this->add_deprecation_message('isAliasExistsInDB', 'check_alias');
		return $this->check_alias($alias);
	}
	
	/**
	 * old version of get_shortcode();
	 */
	public function getShortcode(){
		$this->add_deprecation_message('getShortcode', 'get_shortcode');
		return $this->get_shortcode();
	}
	
	/**
	 * old version of get_first_slide_id_from_gallery();
	 */
	public function getFirstSlideIdFromGallery(){
		$this->add_deprecation_message('getFirstSlideIdFromGallery', 'get_first_slide_id_from_gallery');
		return $this->get_first_slide_id_from_gallery();
	}
	
	/**
	 * old version of is_posts();
	 */
	public function isSlidesFromPosts(){
		$this->add_deprecation_message('isSlidesFromPosts', 'is_posts');
		return $this->is_posts();
	}
	
	/**
	 * old version of is_stream();
	 */
	public function isSlidesFromStream(){
		$this->add_deprecation_message('isSlidesFromStream', 'is_stream');
		return $this->is_stream();
	}
	
	/**
	 * used in featured addon 
	 **/
	public function getNumSlidesRaw(){
		$this->add_deprecation_message('getNumSlidesRaw', 'get_slides');
		return $this->get_slides();
	}
	
	/**
	 * used in featured addon 
	 **/
	public function getNumSlides(){
		$this->add_deprecation_message('getNumSlides', 'get_slides');
		return $this->get_slides();
	}
	
	/**
	 * used in featured addon 
	 * old version of get_wanted_slides();
	 * @obsolete: $published obsolete
	 **/
	public function getNumRealSlides($published = false, $type = 'post'){
		$this->add_deprecation_message('getNumRealSlides', 'get_wanted_slides');
		return $this->get_wanted_slides($type);
	}
	
	/**
	 * old version of get_title();
	 */
	public function getTitle(){
		$this->add_deprecation_message('getTitle', 'get_title');
		return $this->get_title();
	}
	
	/**
	 * old version of get_sliders_short();
	 */		
	public function getArrSlidersShort($exclude_id = null, $filter = 'all'){
		$this->add_deprecation_message('getArrSlidersShort', 'get_sliders_short');
		return $this->get_sliders_short($exclude_id, $filter);
	}
	
	/**
	 * old version of init_by_data();
	 */
	public function initByDBData($data){
		$this->add_deprecation_message('initByDBData', 'init_by_data');
		$this->init_by_data($data);
	}
	
	/**
	 * old version of alias_exists();
	 */
	public static function isAliasExists($alias, $return_id = false){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		$f->add_deprecation_message('isAliasExists', 'alias_exists');
		return self::alias_exists($alias, $return_id);
	}
	
	/**
	 * old version of get_slide_names();
	 */
	public function getArrSlideNames(){
		$this->add_deprecation_message('getArrSlideNames', 'get_slide_names');
		return $this->get_slide_names();
	}
	
	/**
	 * this function does not exist anymore, only added for backwards compatibility,
	 * as a theme author, please use different functionality to recreate this
	 */
	public function getAllSliderAliases(){
		$this->add_deprecation_message('getAllSliderAliases', false);
		return array();
	}
	
	/**
	 * old version of get_slides();
	 */
	public function getSlidesFromGallery($published = false, $allwpml = false, $first = false){
		$this->add_deprecation_message('getSlidesFromGallery', 'get_slides');
		return $this->get_slides($published, $allwpml, $first);
	}
	
	/**
	 * old version of import_slider();
	 * $updateStatic is obsolete now
	 */
	public function importSliderFromPost($update_animation = true, $updateStatic = true, $exact_filepath = false, $is_template = false, $single_slide = false, $update_navigation = true, $install = true){
		$this->add_deprecation_message('importSliderFromPost', 'import_slider');
		$i = new RevSliderSliderImport();
		$r = $i->import_slider($update_animation, $exact_filepath, $is_template, $single_slide, $update_navigation);
		
		return $r;
	}
	
	/**
	 * old version of delete_slider();
	 */
	public function deleteSlider(){
		$this->add_deprecation_message('deleteSlider', 'delete_slider');
		$this->delete_slider();
	}
	
	/**
	 * old version of get_slider_for_admin_menu();
	 */
	public function getAllSliderForAdminMenu(){
		$this->add_deprecation_message('getAllSliderForAdminMenu', 'get_slider_for_admin_menu');
		return $this->get_slider_for_admin_menu();
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

	public function set_gallery_ids($gallery_ids){
		$this->gallery_ids	= $gallery_ids;
		$this->is_gallery	= true;
	}

	public function get_gallery_ids(){
		return $this->gallery_ids;
	}

	/**
	 * Check if an alias exists in database
	 */
	public function check_id_v7($id){
		global $wpdb;
		
		$v = '7';

		$slider	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE id = %d", $id), ARRAY_A);
		
		return !empty($slider);
	}

	/**
	 * return the map of slide IDs
	 **/
	public function get_map(){
		return $this->map;
	}
	 
	/**
	 * init by id or alias
	 * @param mixed $mixed  slider id or alias
	 * @param bool $show_error
	 */
	public function init_by_mixed($mixed, $show_error = true){
		if(is_numeric($mixed)){
			$this->init_by_id($mixed, $show_error);
		}else{
			$this->init_by_alias($mixed, $show_error);
		}
	}
	
	
	/**
	 * initialize the slider data by given id
	 * @param int $sid  slider id
	 * @param bool $show_error
	 */
	public function init_by_id($sid, $show_error = true){
		global $wpdb, $SR_GLOBALS;
		$this->validate_numeric($sid, 'Slider ID');

		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';

		$slider_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE id = %d", $sid), ARRAY_A);
		if(empty($slider_data) && !is_admin() && $show_error === true) $this->throw_error('Slider not found.');
		
		if(!empty($slider_data)) $this->init_by_data($slider_data);
	}
	
	
	/**
	 * initialize the slider data by given alias
	 * @param string $alias  slider alias
	 * @param bool $show_error
	 */
	public function init_by_alias($alias, $show_error = true){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';

		$_alias = str_replace(' ', '-', $alias); //make sure that no spaces are added
		$slider_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE alias = %s", $_alias), ARRAY_A);
		if(empty($slider_data)){ //go back to an very old option where an slider alias could have a space
			$slider_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE alias = %s", $alias), ARRAY_A);
		}
		if(empty($slider_data) && !is_admin() && $show_error === true){
			$this->throw_error('Slider with alias '.sanitize_text_field(esc_attr($alias)).' not found.');
		}
		
		if(!empty($slider_data)) $this->init_by_data($slider_data);
	}
	
	
	/**
	 * init slider by db data
	 */
	public function init_by_data($data){
		global $SR_GLOBALS;
		$data = apply_filters('revslider_slider_init_by_data', $data, $this);
		
		$this->id		= $this->get_val($data, 'id');
		$this->title	= $this->get_val($data, 'title');
		$this->alias	= $this->get_val($data, 'alias');
		$this->settings	= (array)json_decode($this->get_val($data, 'settings'), true);
		$this->params	= (array)json_decode($this->get_val($data, 'params'), true);
		
		$this->params['version'] = $this->get_val($this->settings, 'version');
		
		$this->type		= $this->get_val($data, 'type');
		$this->inited	= true;
		$this->v7		= ($SR_GLOBALS['use_table_version'] === 7) ? true : false;

		$do_action = (is_admin()) ? false : true;
		$do_action = (wp_doing_ajax() || wp_is_json_request()) ? true : $do_action;
		$do_action = ($SR_GLOBALS['preview_mode']) ? true : $do_action;
		
		if($do_action){
			global $SR_GLOBALS;
			if($SR_GLOBALS['data_init'] === true){
				do_action('revslider_slider_init_by_data_post', $this);
			}
		}
		
		$this->modify_by_global_settings();
	}
	
	
	/**
	 * set slider params
	 */
	public function set_params($params){
		$this->params = $params;
	}
	
	
	/**
	 * return params of current initialized Slider
	 */
	public function get_params(){
		return $this->params;
	}
	
	
	/**
	 * set specific slider param
	 * @since: 5.1.1
	 */
	public function set_param($name, $value){
		if(is_array($name)){
			$params = &$this->params;
			if(!empty($name)){
				foreach($name as $key){
					if(is_array($params)){
						$params = &$params[$key];
					}elseif(is_object($params)){
						$params = &$params->$key;
					}
				}
			}
			$params = $value;
		}else{
			$this->params[$name] = $value;
		}
	}
	
	/**
	 * return certain param of current initialized Slider
	 * before: RevSliderSlider::get_param()
	 * @param mixed $key
	 * @param string $default
	 * @return mixed
	 */
	public function get_param($key, $default = ''){
		if(!is_array($key)){
			return $this->get_val($this->params, $key, $default);
		}else{
			$a = $this->params;
			foreach($key as $k => $v){
				$a = $this->get_val($a, $v, $default);
			}
			
			return $a;
		}
	}
	
	
	/*
	 * return settings of current initialized Slider
	 * @since: 5.0
	 * before: RevSliderSlider::getSettings()
	 */
	public function get_settings(){
		return $this->settings;
	}
	
	
	/*
	 * return certain setting
	 * @since: 5.0
	 */
	public function get_setting($handle, $default){
		return $this->get_val($this->settings, $handle, $default);
	}
	
	
	/**
	 * get the slider title
	 * @before: RevSliderSlider::getTitle()
	 */
	public function get_title(){
		return $this->title;
	}
	
	
	/**
	 * get the slider alias
	 * @before: RevSliderSlider::getAlias()
	 */
	public function get_alias(){
		return $this->alias;
	}
	
	
	/**
	 * get slider shortcode
	 * @before: RevSliderSlider::getShortcode() 
	 */
	public function get_shortcode(){
		return '[rev_slider alias="'.$this->alias.'"]';
	}
	
	/**
	 * get the slider tags
	 * @since: 6.0
	 */
	public function get_tags(){
		return $this->get_val($this->settings, 'tags', array());
	}
	
	
	/**
	 * get the slider id
	 * @before: RevSliderSlider::getID()
	 */
	public function get_id(){
		return $this->id;
	}
	
	/**
	 * return if the slider source is from posts
	 * @before: RevSliderSlider::isSlidesFromPosts();
	 */
	public function is_posts(){
		$source = ($this->v7) ?  $this->get_param(array('source', 'type'), 'gallery') : $this->get_param('sourcetype', 'gallery');
		return in_array($source, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo'), true); //, 'gallery'
	}
	
	
	/**
	 * return if the slider source is from posts
	 * @before: RevSliderSlider::isSlidesFromPosts();
	 */
	public function is_posts_pre60(){
		$source = $this->get_param('source_type', 'gallery');
		return in_array($source, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo'), true);
	}
	
	
	/**
	 * return if the slider source is from specific posts
	 */
	public function is_specific_posts(){
		$source = ($this->v7) ? $this->get_param(array('source', 'type'), 'gallery') : $this->get_param('source_type', 'gallery');
		return in_array($source, array('specific_posts', 'specific_post'), true);
	}


	/**
	 * return if the slider source is from stream
	 * @before: RevSliderSlider::isSlidesFromStream();
	 */
	public function is_stream(){
		$source = ($this->v7) ? $this->get_param(array('source', 'type'), 'gallery') : $this->get_param('sourcetype', 'gallery');
		return (!in_array($source, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo', 'gallery'), true)) ? $source : false;
	}
	
	
	/**
	 * return if the slider source is from stream
	 * @since: 6.0.0
	 */
	public function is_stream_pre60(){
		$source = $this->get_param('source_type', 'gallery');
		return (!in_array($source, array('post', 'posts', 'specific_posts', 'specific_post', 'current_post', 'woocommerce', 'woo', 'gallery'), true)) ? $source : false;
	}

	/**
	 * return if slider source is stream or post
	 */
	public function is_stream_post(){
		return ($this->is_stream() || $this->is_posts()) ? true : false;
	}
	
	/**
	 * get real slides number, from posts, social streams ect.
	 */
	public function get_wanted_slides($type = 'post'){
		$ns = count($this->slides);
		
		switch($type){
			case 'post':
				if($this->get_param(array('source', 'post', 'fetchType'), 'cat_tag') == 'next_prev'){
					$ns = 2;
				}else{
					$ns = $this->get_param(array('source', 'post', 'maxPosts'), $ns);
					if(intval($ns) == 0) $ns = '∞';
				}
			break;
			case 'facebook':
			case 'instagram':
			case 'flickr':
			case 'youtube':
			case 'vimeo':
				$ns = $this->get_param(array('source', $type, 'count'), $ns);
			break;
		}
		
		return $ns;
	}
	
	/*
	 * return true if slider is favorite
	 * @since: 5.0
	 * @before: RevSliderSlider::isFavorite()
	 * @obsolete since 6.0 as it was moved to the favorite.class.php
	 */
	public function is_favorite(){
		return $this->get_val($this->settings, 'favorite', 'false') == 'true';
	}
	
	
	/**
	 * return the number of Sliders existing
	 */
	public function get_slider_count(){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';

		return count($wpdb->get_results("SELECT COUNT(*) FROM ".$wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE `type` = '' OR `type` IS NULL", ARRAY_A));
	}
	
	
	/**
	 * get the first slide ID of the current slider
	 * @before: RevSliderSlider::getFirstSlideIdFromGallery()
	 */
	public function get_first_slide_id_from_gallery(){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$slides = array();
		$record = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v ." WHERE slider_id = %s ORDER BY slide_order ASC LIMIT 0,1", array($this->get_id())), ARRAY_A);
		
		if(!empty($record)){
			$slide = new RevSliderSlide();
			$slide->init_by_data($record);
			$sid = $slide->get_id();
			$slides[$sid] = $slide;
			
			return $slides;
		}
		
		return false;
	}
	
	
	/**
	 * get the alias of an slider by id
	 **/
	public function get_alias_by_id($slider_id){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';

		$record = $wpdb->get_row($wpdb->prepare("SELECT `alias` FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE id = %s LIMIT 0,1", array($slider_id)), ARRAY_A);
		return (!empty($record)) ? $this->get_val($record, 'alias') : false;
	}
	
	
	/**
	 * get all sliders that have a certain string in the params
	 * @since: 6.4.6
	 **/
	public function get_slider_by_param_string($string, $templates = false){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$string = (array)$string;
		if(empty($string)) return array();

		$sql = "SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE ";
		$add = '';
		
		if($templates === true) $sql .= "(";
		
		foreach($string as $k => $v){
			//$sql .= $add. "params LIKE '%%%s%%'";
			$string[$k] = '%'.$v.'%';
			
			$sql .= $add. "params LIKE %s";
			if($add === '') $add = " OR ";
		}
		if($templates === true) $sql .= ")";
		
		return $wpdb->get_results($wpdb->prepare($sql, $string), ARRAY_A);
	}
	
	
	/**
	 * get all images that are beeing used by the Slider
	 **/
	public function get_images(){
		$images = array();
		$ret	= array();
		$image = $this->get_val($this->params, array('layout', 'bg', 'image'));
		$a_url = $this->get_val($this->params, array('troubleshooting', 'alternateURL'));
		
		if($image != '') $images[$image] = true;
		if($a_url != '') $images[$a_url] = true;
		
		if(!empty($this->slides) && count($this->slides) > 0){
			foreach($this->slides as $key => $slide){
				$params = $slide->get_params();
				$layers = $slide->get_layers();
				$image	= $this->get_val($params, array('bg', 'image'));
				$thumb	= $this->get_val($params, array('thumb', 'customThumbSrc'));
				$a_thumb = $this->get_val($params, array('thumb', 'customAdminThumbSrc'));
				
				if($image != ''){
					$altOption	 = $this->get_val($params, array('attributes', 'altOption'), 'media_library');
					$titleOption = $this->get_val($params, array('attributes', 'titleOption'), 'media_library');
					$alt		 = '';
					$title		 = '';
					switch($altOption){
						case 'media_library';
							$id = attachment_url_to_postid($image);
							if($id > 0) $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
						break;
						case 'file_name';
							$alt = $image;
						break;
						case 'custom';
							$alt = $this->get_val($params, array('attributes', 'alt'), '');
						break;
					}
					switch($titleOption){
						case 'media_library';
							$id = attachment_url_to_postid($image);
							if($id > 0) $title = get_the_title($id);
						break;
						case 'file_name';
							$title = $image;
						break;
						case 'custom';
							$title = $this->get_val($params, array('attributes', 'title'), '');
						break;
					}
					$images[$image] = array(
						'src' => $image,
						'alt' => $alt,
						'title' => $title
					);
				}
				if($thumb != '' && !isset($images[$thumb])) $images[$thumb] = true;
				if($a_thumb != '' && !isset($images[$a_thumb])) $images[$a_thumb] = true;
				
				if(!empty($layers)){
					foreach($layers as $layer){
						$type		= $this->get_val($layer, 'type', 'text');
						$image		= $this->get_val($layer, array('media', 'imageUrl'));
						$bg_image	= $this->get_val($layer, array('idle', 'backgroundImage'));
						
						if($image != '' && !isset($images[$image]))	$images[$image] = true;
						if($bg_image != '' && !isset($images[$bg_image])) $images[$bg_image] = true;
						
						if(in_array($type, array('video', 'audio'))){
							$poster = $this->get_val($layer, array('media', 'posterUrl'), '');
							if($poster != '' && !isset($images[$poster])) $images[$poster] = true;
						}
						if($type === 'video'){
							$very_big	= $this->get_val($layer, array('media', 'thumbs', 'veryBig'));
							$big		= $this->get_val($layer, array('media', 'thumbs', 'big'));
							$large		= $this->get_val($layer, array('media', 'thumbs', 'large'));
							$medium		= $this->get_val($layer, array('media', 'thumbs', 'medium'));
							$small		= $this->get_val($layer, array('media', 'thumbs', 'small'));
							
							$very_big	= (is_array($very_big) && isset($very_big['url'])) ? $very_big['url'] : $very_big;
							$big		= (is_array($big) && isset($big['url'])) ? $big['url'] : $big;
							$large		= (is_array($large) && isset($large['url'])) ? $large['url'] : $large;
							$medium		= (is_array($medium) && isset($medium['url'])) ? $medium['url'] : $medium;
							$small		= (is_array($small) && isset($small['url'])) ? $small['url'] : $small;
							
							if($very_big != '' && !isset($images[$very_big])) $images[$very_big] = true;
							if($big != '' && !isset($images[$big]))			  $images[$big] = true;
							if($large != '' && !isset($images[$large]))		  $images[$large] = true;
							if($medium != '' && !isset($images[$medium]))	  $images[$medium] = true;
							if($small != '' && !isset($images[$small]))		  $images[$small] = true;
						}
					}
				}
			}
		}
		
		if(!empty($images)){
			foreach($images as $img => $b){
				if(!is_bool($b)){
					$ret[] = $b;
				}else{
					$alt = '';
					$title = '';
					$id = attachment_url_to_postid($img);
					if($id > 0){
						if($id > 0) $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
						if($id > 0) $title = get_the_title($id);
					}
					$ret[] = array(
						'src' => $img,
						'alt' => $alt,
						'title' => $title
					);
				}
			}
		}
		
		return $ret;
	}
	
	
	/**
	 * check if alias already exists
	 * @before: RevSliderSlider::isAliasExists()
	 */
	public static function alias_exists($alias, $return_id = false){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$alias_exists = $wpdb->get_row($wpdb->prepare("SELECT id FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE alias = %s", $alias), ARRAY_A);
		
		if($return_id === true){
			return (!empty($alias_exists)) ? $alias_exists['id'] : false;
		}else{
			return !empty($alias_exists);
		}
	}
	
	
	/**
	 * delete slider from datatase
	 * @before RevSliderSlider::deleteSlider();
	 */
	public function delete_slider(){
		global $wpdb, $SR_GLOBALS;
		
		//delete slider
		$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_SLIDER, array('id' => $this->id));
		$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_SLIDER . '7', array('id' => $this->id));
		
		//delete slides
		$this->delete_all_slides();
		if($SR_GLOBALS['use_table_version'] !== 7) $this->delete_static_slide();

		do_action('revslider_slider_on_delete_slider', $this->id);
	}
	
	
	/**
	 * delete all slides
	 * @before: RevSliderSlider::deleteAllSlides();
	 */
	public function delete_all_slides(){
		global $wpdb, $SR_GLOBALS;
		
		$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_SLIDES, array('slider_id' => $this->id));
		$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_SLIDES . '7', array('slider_id' => $this->id));
		
		do_action('revslider_slider_delete_all_slides', $this->id);
		do_action('revslider_slider_deleteAllSlides', $this->id);
	}
	

	/**
	 * delete static slide
	 * @before: RevSliderSlider::deleteStaticSlide();
	 */
	public function delete_static_slide(){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		if($SR_GLOBALS['use_table_version'] === 7){
			$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES . $v, array('slider_id' => $this->id, 'static' => true));
		}else{
			$wpdb->delete($wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES . $v, array('slider_id' => $this->id));
		}

		do_action('revslider_slider_delete_static_slide', $this->id);
	}
	
	
	/**
	 * duplicate a slide by given data
	 * @before: RevSliderSlider::duplicateSliderFromData();
	 */
	public function duplicate_slider_by_id($id, $is_template = false){
		$this->validate_not_empty($id, 'Slider ID');
		$this->init_by_id($id);
		
		$title = $this->get_title();
		if($is_template){
			$title = str_replace(' Template', '', $title); //remove the added Template from the title in copy process
			$talias	= $title;
		}else{
			$talias	= $this->get_alias();
		}
		
		$ti = 1;
		while($this->alias_exists($talias)){ //set a new alias and title if its existing in database
			$talias = $title. ' ' .$ti;
			$ti++;
		}
		
		return $this->duplicate_slider($talias);
	}
	
	
	/**
	 * update the Slider title
	 */
	public function update_title($new_title){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$new_title = stripslashes(esc_html($new_title));
		if(!empty($new_title)){
			$this->title = $new_title;
			
			$return = $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, array('title' => $this->title), array('id' => $this->id));
		}else{
			$return = $this->title;
		}
		
		return ($return) ? $this->title : false;
	}
	
	
	/**
	 * update the Slider Tags
	 * @since: 6.0
	 */
	public function update_slider_tags($slider_id, $tags){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$this->validate_not_empty($slider_id, 'Slider ID');
		
		$record	  = $wpdb->get_row($wpdb->prepare("SELECT `settings` FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE id = %s", $slider_id), ARRAY_A);
		$cur_tags = array();
		
		if(!empty($tags)){	
			foreach($tags as $tag){
				$tag		= preg_replace('/ /', '-', $tag);
				$tag		= preg_replace('/[^-0-9a-zA-Z_-]/', '', $tag);
				$cur_tags[] = $tag;
			}
		}
			
		if(!isset($record['settings'])){
			$record['settings'] = array();
		}else{
			$record['settings'] = json_decode($record['settings'], true);
		}
		
		if(!isset($record['settings']['tags'])) $record['settings']['tags'] = array();
		
		$record['settings']['tags'] = $cur_tags;
		$settings					= json_encode($record['settings']);
		
		return $wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, array('settings' => $settings), array('id' => $slider_id));
	}
	
	
	/**
	 * get the last Slider ID
	 * @since: 6.0
	 */
	public function get_last_slider_id(){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$record = $wpdb->get_row("SELECT `id` FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." ORDER BY `id` DESC LIMIT 0,1", ARRAY_A);
		$id 	= (!empty($record)) ? $this->get_val($record, 'id') : -1;
		
		return $id;
	}
	
	
	/**
	 * get all slide children
	 * @before: RevSliderSlider::getArrSlideChildren();
	 */
	public function get_slide_children($slide_id){
		$slides = $this->get_slides();
		
		if(!isset($slides[$slide_id])){
			$this->throw_error(__('Slide not found in the main slides of the slider. Maybe it', 'revslider'));
		}
		
		$slide		= $slides[$slide_id];
		$children	= $slide->get_children();
		
		return $children;
	}
	
	
	/**
	 * get array of slide names
	 * @before: RevSliderSlider::getArrSlideNames();
	 */
	public function get_slide_names(){
		if(empty($this->slides)){
			$this->get_slides();
		}
		
		$names = array();
		if(!empty($this->slides)){
			foreach($this->slides as $slide){
				$id		 = $slide->get_id();
				$file	 = $slide->image_filename;	
				$title	 = $slide->get_title();
				$name	 = $title;
				$name 	.= (!empty($file)) ? ' ('. $file .')' : '';
				
				$childs	 = $slide->get_child_ids();
				
				$names[$id] = array(
					'name'			 => $name,
					'arrChildrenIDs' => $childs,
					'title'			 => $title
				);
			}
		}
		
		return $names;
	}
	
	
	/**
	 * duplicate slider in datatase
	 * @before: RevSliderSlider::duplicateSlider();
	 */
	private function duplicate_slider($title = false, $prefix = false){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$old_slider_id = $this->id;
		//select a slider and then duplicate it
		$select = $wpdb->prepare("SELECT title, alias, params, type, settings FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE id = %s", array($this->id));
		$wpdb->query("INSERT INTO ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." (title, alias, params, type, settings) (".$select.")");
		
		//update the slider title and alias to a new one
		$slider_last_id	= $wpdb->insert_id;
		$params			= $this->params;
		$this->validate_not_empty($slider_last_id, 'Slider ID');
		$slider_counter = $this->get_slider_count(); //get last slider number
		
		if($title === false){
			$slider_counter++;
			$new_title = 'Slider'.$slider_counter;
			$new_alias = 'slider'.$slider_counter;
		}else{
			$new_title = ($prefix !== false) ? sanitize_text_field($title.' '.$this->get_val($params, 'title')) : sanitize_text_field($title);
			$new_alias = ($prefix !== false) ? sanitize_title($title.' '.$this->get_val($params, 'title')) : sanitize_title($title);
			
			//check if alias exists
			$c_title = $new_title;
			$c_alias = $new_alias;
			while($this->alias_exists($c_alias)){
				$c_title = $new_title . $slider_counter;
				$c_alias = $new_alias . $slider_counter;
				$slider_counter++;
			}
			$new_title = $c_title;
			$new_alias = $c_alias;
		}
		
		$params['title']	 = $new_title;
		$params['alias']	 = $new_alias;
		$params['shortcode'] = '[rev_slider alias="'. $new_alias .'"]';

		$wpdb->update(
			$wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v,
			array(
				'title'	 => $new_title,
				'alias'	 => $new_alias,
				'params' => json_encode($params),
				'type'	 => ''
			),
			array('id' => $slider_last_id)
		);
		
		
		//duplicate slides and add them to the new Slider
		$slides = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v ." WHERE slider_id = %s", $this->id), ARRAY_A);
		if(!empty($slides)){
			foreach($slides as $slide){
				$slide['slider_id'] = $slider_last_id;
				$slide_id = $slide['id'];
				unset($slide['id']);
				$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v, $slide);
				
				if(isset($slide_id)){
					$this->map[$slide_id] = $wpdb->insert_id;
				}
			}
		}
		
		//update actions
		$slides = $wpdb->get_results($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v ." WHERE slider_id = %s", $slider_last_id), ARRAY_A);

		if($SR_GLOBALS['use_table_version'] !== 7){
			//duplicate static slide if exists
			$slide		= new RevSliderSlide();
			$staticID	= $slide->get_static_slide_id($this->id);
			$static_id	= 0;
			if($staticID !== false){
				$record = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES . $v ." WHERE id = %s", $staticID), ARRAY_A);
				unset($record['id']);
				$record['slider_id'] = $slider_last_id;
				
				$wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES . $v, $record);
				$static_id = $wpdb->insert_id;
			}
			if($static_id > 0){
				$slides_static = $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES . $v ." WHERE id = %s", $static_id), ARRAY_A);
				if(!empty($slides_static)) $slides[] = $slides_static;
			}
		}
		
		if(!empty($slides)){
			foreach($slides as $slide){
				$c_slide	= new RevSliderSlide();
				$c_slide->init_by_data($slide);
				$layers		= $c_slide->get_layers();
				
				//change for WPML the parent IDs if necessary
				$parent_id	= ($this->v7) ? $this->get_val($c_slide, array('params', 'parentID'), false) : $this->get_val($c_slide, array('params', 'child', 'parentId'), false);
				
				if(!in_array($parent_id, array(false, ''), true) && isset($this->map[$parent_id])){
					$create = array('params' => $this->get_val($c_slide, 'params', array()));
					
					if($this->v7){
						$this->set_val($create, array('params', 'parentID'), $this->map[$parent_id]);
					}else{
						$this->set_val($create, array('params', 'child', 'parentId'), $this->map[$parent_id]);
					}
					
					$new_params = json_encode($create['params']);
					$new_params = (empty($new_params)) ? stripslashes(json_encode($create['params'])) : $new_params;
					$create['params'] = $new_params;
					
					$wpdb->update(
						$wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v,
						$create,
						array('id' => $slide['id'])
					);
				}
				
				$did_change	= false;
				if(!empty($layers)){
					foreach($layers as $key => $value){
						$actions = $this->get_val($value, array('actions', 'action'));
						
						if(!empty($actions)){
							foreach($actions as $a_k => $action){
								$jtsval = $this->get_val($action, 'jump_to_slide');
								if(isset($this->map[$jtsval])){
									$this->set_val($layers, array($key, 'actions', 'action', $a_k, 'jump_to_slide'), $this->map[$jtsval]);
									$did_change = true;
								}
							}
						}
					}
				}
				if($did_change === true){
					$create		= array();
					$my_layers	= json_encode($layers);
					$create['layers'] = (empty($my_layers)) ? stripslashes(json_encode($layers)) : $my_layers;
					
					if($SR_GLOBALS['use_table_version'] !== 7 && $slide['id'] == $static_id){
						$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES . $v, $create, array('id' => $static_id));
					}else{
						$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v, $create, array('id' => $slide['id']));
					}
				}
			}
		}
		
		//change the javascript api ID to the correct one
		$c_slider = new RevSliderSliderImport();
		$c_slider->init_by_id($slider_last_id);
		
		$upd = new RevSliderPluginUpdate();
		$upd->upgrade_slider_to_latest($c_slider);
		
		$c_slider->update_css_and_javascript_ids($old_slider_id, $slider_last_id, $this->map);
		$c_slider->update_color_ids($this->map);
		
		do_action('revslider_duplicate_slider', $slider_last_id, $old_slider_id, $slides, $this);
		
		return $slider_last_id;
	}
	
	
	/**
	 * update the modal id and the alias in the layer actions
	 **/
	public function update_modal_ids($slider_ids, $slide_ids){
		$slides = $this->get_slides();
		
		if(empty($slides)) return;
		
		foreach($slides as $skey => $slide){
			if(version_compare($slide->get_param('version', '1.0.0'), '6.0.0', '<')) continue;
			$layers = $slide->get_layers();
			
			if(empty($layers)) continue;
			$change = false;
			foreach($layers as $lk => $layer){
				$actions = $this->get_val($layer, array('actions', 'action'), array());
			
				if(empty($actions)) continue;
				
				foreach($actions as $ak => $a){
					if($this->get_val($a, 'action', '') !== 'open_modal') continue;

					$v = intval($this->get_val($a, 'openmodalId', 0)); //only openmodal is set (alias), openmodalId is not set!
					
					if(isset($slider_ids[$v])){
						$slider_alias = $this->get_alias_by_id($slider_ids[$v]);
						$change = true;
						$this->set_val($layers, array($lk, 'actions', 'action', $ak, 'openmodalId'), $slider_ids[$v]);
						$this->set_val($layers, array($lk, 'actions', 'action', $ak, 'openmodal'), $slider_alias);
						
						$sv = $this->get_val($a, 'modalslide', 0);
						if($sv !== 0){
							$_sv = intval(str_replace('rs-', '', $sv));
							if($_sv > 0 && isset($slide_ids[$_sv])){
								$this->set_val($layers, array($lk, 'actions', 'action', $ak, 'modalslide'), 'rs-'.$slide_ids[$_sv]);
							}
						}
					}
				}
			}
			
			if($change){
				$slide->set_layers_raw($layers);
				$slide->save_layers();
			}
		}
	}
	
	/**
	 * Check if an alias exists in database
	 * @before: RevSliderSlider::isAliasExistsInDB();
	 */
	public function check_slider_id($id){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$slider	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE id = %d", $id), ARRAY_A);
		
		return !empty($slider);
	}
	
	/**
	 * Check if an alias exists in database
	 * @before: RevSliderSlider::isAliasExistsInDB();
	 */
	public function check_alias($alias){
		global $wpdb, $SR_GLOBALS;
		
		$v		= ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		$add	= (!empty($this->id)) ? $wpdb->prepare(" AND id != %s", array($this->id)) : '';
		$slider	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE alias = %s", $alias).$add, ARRAY_A);
		
		return !empty($slider);
	}
	
	
	/**
	 * Create a blank Slider
	 **/
	public function create_blank_slider(){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$title		= 'Slider ';
		$alias		= 'slider-';
		$counter	= 1;
		$new_alias	= $alias.$counter;
		
		while($this->alias_exists($new_alias)){
			$counter++;
			$new_alias = $alias.$counter;
		}
		
		$title .= $counter;
		
		//insert slider to database
		$slider_data = array(
			'title'		=> $title,
			'alias'		=> $new_alias,
			'params'	=> json_encode(array(), JSON_FORCE_OBJECT),
			'settings'	=> json_encode(array('version' => RS_REVISION), JSON_FORCE_OBJECT),
			'type'		=> ''
		);
		
		$result		= $wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, $slider_data);
		$slider_id	= ($result) ? $wpdb->insert_id : false;
		
		return $slider_id;
	}
	
	public function save_slider_v7($slider_id, $settings, $title, $alias){
		global $wpdb, $SR_GLOBALS;

		$v			= '7';
		$settings	= $this->json_decode_slashes($settings);
		$title		= (empty($title)) ? $this->get_val($settings, 'title') : $title;
		$alias		= (empty($alias)) ? $this->get_val($settings, 'alias') : $alias;
		$exists		= $this->check_id_v7($slider_id);

		if(!current_user_can('administrator') && apply_filters('revslider_restrict_role', true)){
			if(isset($settings['codes']) && isset($settings['codes']['css'])) unset($settings['codes']['css']);
			if(isset($settings['codes']) && isset($settings['codes']['js'])) unset($settings['codes']['js']);
		}
		
		if($exists){
			$t = $SR_GLOBALS['use_table_version'];
			$SR_GLOBALS['use_table_version'] = 7;
			$this->init_by_id($slider_id);
			$SR_GLOBALS['use_table_version'] = $t;
			
			if(!current_user_can('administrator') && apply_filters('revslider_restrict_role', true)){
				//check for js and css, add it to $params
				$settings['codes'] = [
					'css' => $this->get_param(['codes', 'css'], ''),
					'js' => $this->get_param(['codes', 'js'], '')
				];
			}
		}

		//insert slider to database
		$slider_data = array(
			'title'		=> $title,
			'alias'		=> $alias,
			'params'	=> json_encode($settings),
			'settings'	=> json_encode(['version' => RS_REVISION], JSON_FORCE_OBJECT),
			'type'		=> ''
		);

		if(!$exists){ //create slider
			$slider_data['id'] = $slider_id;
			$result		= $wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, $slider_data);
			$slider_id	= ($result) ? $wpdb->insert_id : false;
		}else{ //update slider
			$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, $slider_data, array('id' => $slider_id));
		}
		
		do_action('revslider_save_slider_v7', $slider_id);

		return $slider_id;
	}

	/**
	 * Save Slider Settings
	 * @before: RevSliderSlider::createUpdateSliderFromOptions();
	 **/
	public function save_slider($slider_id, $data){
		global $wpdb, $SR_GLOBALS;
		
		$v = ''; //($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$params		= $this->get_val($data, 'params');
		$params 	= $this->json_decode_slashes($params);
		$settings	= $this->get_val($data, 'settings');
		$settings	= $this->json_decode_slashes($settings);
		$settings['version'] = $this->get_val($params, 'version', $this->get_val($settings, 'version'));
		
		$title	= sanitize_text_field($this->get_val($params, 'title'));
		$alias	= sanitize_text_field($this->get_val($params, 'alias'));
		
		unset($params['title']);
		unset($params['alias']);
		
		$this->validate_not_empty($title, 'Title');
		$this->validate_not_empty($alias, 'Alias');
		
		
		//params css and js check
		if(!current_user_can('administrator') && apply_filters('revslider_restrict_role', true)){
			//dont allow css and javascript from users other than administrator
			if(isset($params['codes']) && isset($params['codes']['css'])){
				unset($params['codes']['css']);
			}
			if(isset($params['codes']) && isset($params['codes']['javascript'])){
				unset($params['codes']['javascript']);
			}
		}
		
		if(!empty($slider_id)){
			$this->init_by_id($slider_id);
			
			if(!current_user_can('administrator') && apply_filters('revslider_restrict_role', true)){
				//check for js and css, add it to $params
				$params['codes'] = array();
				$params['codes']['css']			= $this->get_param(array('codes', 'css'), '');
				$params['codes']['javascript']	= $this->get_param(array('codes', 'javascript'), '');
			}
		}
		
		if($this->check_alias($alias)){
			$this->throw_error(__('A Slider with the given alias already exists', 'revslider'));
		}
		
		//insert slider to database
		$slider_data = array(
			'title'		=> $title,
			'alias'		=> $alias,
			'params'	=> json_encode($params),
			'settings'	=> json_encode($settings),
			'type'		=> ''
		);
		
		if(empty($slider_id)){ //create slider	
			$result		= $wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, $slider_data);
			$slider_id	= ($result) ? $wpdb->insert_id : false;
		}else{ //update slider
			$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, $slider_data, array('id' => $slider_id));
		}
		
		do_action('revslider_save_slider', $slider_id);

		return $slider_id;
	}
	
	
	/**
	 * update some params in the slider
	 * @before: RevSliderSlider::updateParam();
	 */
	public function update_params($update, $replace = false){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';

		$this->params = ($replace) ? $update : array_merge($this->params, $update);
		//$this->params = ($replace) ? $update : $this->params + $update;

		$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, array('params' => json_encode($this->params)), array('id' => $this->id));
	}
	
	
	/**
	 * update some settings in the slider
	 * @before: RevSliderSlider::updateSetting()
	 */
	public function update_settings($update){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';

		$this->settings = array_merge($this->settings, $update);
		$wpdb->update($wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v, array('settings' => json_encode($this->settings)), array('id' => $this->id));
	}
	
	
	/**
	 * get array of slides numbers by id's
	 * RevSliderSlider::getSlidesNumbersByIDs();
	 */
	public function get_slide_numbers_by_id($published = false){
		$numbers = array();
		$counter = 0;
		
		if(empty($this->slide)){
			$this->get_slides($published);
		}
		
		if(empty($this->arr_slides)){
			foreach($this->slides as $slide){
				$counter++;
				$id				= $slide->get_id();
				$numbers[$id]	= $counter;
			}
		}
		
		return $numbers;
	}
	
	
	/**
	 * get sliders array - function don't belong to the object!
	 * @before: RevSliderSlider::getArrSliders();
	 */
	public function get_sliders($templates = false, $page = 0){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$SR_GLOBALS['data_init'] = false;
		$sliders	= array();
		$do_order	= 'id';
		$direction	= 'ASC';
		$page		= intval($page);
		$limit		= '';

		if($page > 0){
			$end	= 50 * $page;
			$start	= $end - 50;
			$limit	= ' LIMIT '.$start.', '.$end;
		}

		$slider_data = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE `type` != 'folder' ORDER BY %s %s".$limit, array($do_order, $direction)), ARRAY_A); //WHERE `type` = '' OR `type` IS NULL 
		if(!empty($slider_data)){
			foreach($slider_data as $data){
				$slider = new RevSliderSlider();
				$slider->init_by_data($data);
				$sliders[] = $slider;
			}
		}
		
		$SR_GLOBALS['data_init'] = true;
		
		return $sliders;
	}

	/**
	 * get sliders shortlist object 
	 */
	public function get_sliders_short_list(){
		global $wpdb, $SR_GLOBALS;
		
		$v6 = $wpdb->get_results($wpdb->prepare("SELECT id, title, alias FROM " . $wpdb->prefix . RevSliderFront::TABLE_SLIDER . " WHERE `type` != 'folder' ORDER BY %s %s", array('id', 'ASC')), ARRAY_A);
		$v7 = $wpdb->get_results($wpdb->prepare("SELECT id, title, alias FROM " . $wpdb->prefix . RevSliderFront::TABLE_SLIDER . "7 WHERE `type` != 'folder' ORDER BY %s %s", array('id', 'ASC')), ARRAY_A);
		$_v7 = array();
		foreach($v7 ?? [] as $k => $slider){
			$_v7[$slider['id']] = $slider;
		}
		
		$failed = $this->get_v7_migration_failed_map();
		foreach($v6 ?? [] as $k => $slider){
			$v6[$k]['v7'] = (isset($_v7[$slider['id']])) ? true : false;
			$v6[$k]['v7error'] = (isset($failed[$slider['id']])) ? $failed[$slider['id']] : false;
		}

		return (object)$v6;
	}
	
	
	/**
	 * get array of alias
	 * @before: getAllSliderForAdminMenu()
	 */
	public function get_slider_for_admin_menu(){
		global $SR_GLOBALS;
		
		$SR_GLOBALS['data_init'] = false;
		$sliders = $this->get_sliders();
		$SR_GLOBALS['data_init'] = true;
		
		$short = array();
		if(!empty($sliders)){
			foreach($sliders as $slider){
				$id = $slider->get_id();
				
				$short[$id] = array('title' => $slider->get_title(), 'alias' => $slider->get_alias());
			}
		}
		
		return $short;
	}
	
	public function set_slides($slides){
		$this->slides = array();
		if(!empty($slides)){
			foreach($slides as $slide){
				$rslide = new RevSliderSlide();
				$rslide->init_by_data($slide);
				$this->slides[] = $rslide;
			}
		}
	}
	
	/**
	 * get slides from gallery
	 * force from gallery - get the slide from the gallery only
	 * before: RevSliderSlider::getSlides() and also RevSliderSlider::getSlidesFromGallery()
	 */
	public function get_slides($published = false, $allwpml = false, $first = false){
		global $SR_GLOBALS;
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';

		$cache_key = $this->get_wp_cache_key('get_slides_by_slider_id', array($this->id, $published, $allwpml, $first, $this->init_layer, $v));		
		$this->slides = wp_cache_get($cache_key, self::CACHE_GROUP);

		if(!empty($this->slides)) return $this->slides;

		$slide			= new RevSliderSlide();
		$this->slides	= $slide->get_slides_by_slider_id($this->id, $published, $allwpml, $first, $this->init_layer);
		wp_cache_set($cache_key, $this->slides, self::CACHE_GROUP);

		return $this->slides;
	}

	/**
	 * same as get_slides(), but allows for temporary modifications, i.e. changing customThumbUrl
	 * should only be used at frontend stage, so that the data saved is not modified inproperly
	 */
	public function get_slides_modified($published = false, $allwpml = false, $first = false){
		$slides = $this->get_slides($published, $allwpml, $first);

		foreach($slides ?? [] as $key => $slide){
			$thumb_url = $this->get_thumb_url($slide);
			if(!empty($thumb_url)){
				$set = ($this->v7) ? array('thumb', 'src') : array('thumb', 'customThumbSrc');
				//$thumb = $slide->get_param('thumb', false);
				//if($thumb === false) $slide->set_param('thumb', array());
				$slide->set_param($set, $thumb_url);
			}

			//parse all slide and layers shortcodes
			if($slide->get_param(array('seo', 'set'), false) == true){
				if($slide->get_param(array('seo', 'type'), 'regular') !== 'slide'){
					$_link = $slide->get_param(array('seo', 'link'), '');
					$link = do_shortcode($_link);
					if($_link !== $link) $slide->set_param(array('seo', 'link'), $link);
				}
			}

			$layers		= $slide->get_layers();
			$text_key	= ($this->v7) ? array('content', 'text') : 'text';
			foreach($layers ?? [] as $_key => $layer){
				if(!in_array($this->get_val($layer, 'type', 'text'), array('image', 'svg', 'column', 'shape'), true)){
					//parse text shortcodes
					$text = $this->get_val($layer, $text_key);
					$_text = do_shortcode(stripslashes($text));
					if($text !== $_text) $_text = '#srfshcd#'.$_text;
					$this->set_val($layers[$_key], $text_key, $_text);

					//parse toggle text shortcodes
					$text_toggle = $this->get_val($layer, array('toggle', 'text'));
					$_text_toggle = do_shortcode(stripslashes($text_toggle));
					if($text_toggle !== $_text_toggle) $_text_toggle = '#srfshcd#'.$_text_toggle;
					$this->set_val($layers[$_key], array('toggle', 'text'), $_text_toggle);

					//parse actions shortcodes
					$action	= $this->get_val($layer, array('actions', 'action'), array());
					foreach($action ?? [] as $a_k => $act){
						$action_type = apply_filters('rs_action_type', $this->get_val($act, 'action'));
						$link_type = apply_filters('rs_action_link_type', $this->get_val($act, 'link_type', ''));

						if(in_array($action_type, array('menu', 'link'), true)){
							if($action_type === 'link' && $link_type === 'jquery') continue;
							$_link = ($action_type === 'menu') ? 'menu_link' : 'image_link';
							$link = $this->get_val($act, $action_type, '');
							$link = do_shortcode($link);
							$this->set_val($layers[$_key], array('actions', 'action', $a_k, $_link), $link);
						}
					}
				}
			}
			$slide->set_layers_raw($layers);

			$slides[$key] = $slide;
		}
		
		return $slides;
	}
	
	/**
	 * get slides for export
	 * before: RevSliderSlider::getSlidesForExport()
	 */
	public function get_slides_for_export(){
		$slides = $this->get_slides(false, true);
		$export = array();
		
		if(!empty($slides)){
			foreach($slides as $slide){
				$export[] = array(
					'id'			=> $slide->get_id(),
					'params'		=> $slide->get_params_for_export(),
					'slide_order'	=> $slide->get_order(),
					'layers'		=> $slide->get_layers_for_export(),
					'settings'		=> $slide->get_settings()
				);
			}
		}
		
		return apply_filters('revslider_get_slides_for_export', apply_filters('revslider_getSlidesForExport', $export));
	}
	
	
	/**
	 * get static slide for export
	 * before: RevSliderSlider::getStaticSlideForExport()
	 */
	public function get_static_slide_for_export(){
		$static_slide	= array();
		$slide			= new RevSliderSlide();
		$static_id		= $slide->get_static_slide_id($this->id);
		
		if($static_id !== false){
			$slide->init_by_static_id($static_id);
			$params = $slide->get_params_for_export();
			if(!isset($params['static'])) $params['static'] = array();
			$params['static']['isstatic'] = true;
			
			$static_slide[] = array(
				'params'		=> $params,
				'slide_order'	=> $slide->get_order(),
				'layers'		=> $slide->get_layers_for_export(),
				'settings'		=> $slide->get_settings()
			);
		}
		
		return apply_filters('revslider_getStaticSlideForExport', $static_slide);
	}
	
	
	/**
	 * get array of sliders with slides, short, assoc.
	 * @before: RevSliderSlider::getArrSlidersWithSlidesShort();
	 */
	public function get_sliders_with_slides_short($filter = 'all'){
		$output	 = array();
		$sliders = $this->get_sliders_short(null, $filter);
		
		if(!empty($sliders)){
			foreach($sliders as $sid => $slider_name){
				$slider = new RevSliderSlider();
				$slider->init_by_id($sid);
				$is_posts = $slider->is_posts();
				
				if($filter == 'posts' && $is_posts == false) continue; //filter by gallery only
				if($filter == 'gallery' && $is_posts == true) continue;
				if($filter == 'template' && $is_posts == false)	continue; //filter by template type
				
				$slides = $slider->get_slides_from_gallery_short();
				foreach($slides ?? [] as $slide_id => $slide_name){
					$output[$slide_id] = $slider_name.', '.$slide_name;
				}
			}
		}
		
		return $output;
	}
	
	
	/**
	 * get slide id and slide title from gallery
	 * @before: RevSliderSlider::getArrSlidesFromGalleryShort()
	 */
	public function get_slides_from_gallery_short(){
		$counter = 0;
		$output	 = array();
		$slides	 = $this->get_slides();
		
		foreach($slides ?? [] as $slide){
			$id			 = $slide->get_id();
			$name		 = 'Slide '.$counter;
			$title		 = $slide->get_param('title', '');
			$output[$id] = (!empty($title)) ? $name.' - ('.$title.')' : $name;
			
			$counter++;
		}
		
		return $output;
	}
	
	
	/**
	 * get slides for output
	 * one level only without children
	 * @before: RevSliderSlider::getSlidesForOutput();
	 */
	public function get_slides_for_output($published = false, $lang = 'all'){
		global $SR_GLOBALS;

		$parent_slides = $this->get_parent_slides($published, $lang);
		
		if($SR_GLOBALS['front_version'] !== 6) return $parent_slides;
		if($lang == 'all' || $this->is_stream()) return $parent_slides;	//$this->is_posts() || 	

		$slides = array();
		foreach($parent_slides ?? [] as $parent_slide){
			$parent_lang = $parent_slide->get_param(array('child', 'language'), 'all');
			if($parent_lang == $lang) $slides[] = $parent_slide;
			
			$added = false;
			$children = $parent_slide->get_children();
			foreach($children ?? [] as $child){
				if($child->get_param(array('child', 'language'), 'all') == $lang){
					$slides[] = $child;
					$added = true;
					break;
				}
			}
			
			if($added == false && $parent_lang == 'all') $slides[] = $parent_slide;
		}
		
		return $slides;
	}

	
	/**
	 * if the WPML is used and we are post based
	 * get the slides by the selected language
	 */
	public function get_language_slides_v7($slides){
		$lang = $this->get_language();
		if($lang === 'all') return $slides; //!$this->is_posts() || 

		$parents = $slides;
		$slides = array();
		$s_lang = (!empty($this->v7)) ? array('language') : array('child', 'language');
		foreach($parents ?? [] as $_slide){
			$_lang = (!empty($this->v7)) ? $_slide->get_param($s_lang) : $_slide->get_param($s_lang, 'all');
			if($_lang == $lang) $slides[$_slide->get_id()] = $_slide;
			
			$added = false;
			$children = $_slide->get_children();
			foreach($children ?? [] as $child){
				if($child->get_param($s_lang, 'all') !== $_lang) continue;
				$slides[$child->get_id()] = $child;
				$added = true;
				break;
			}
			
			if($added == false && $_lang == 'all') $slides[$_slide->get_id()] = $_slide;
		}

		return $slides;
	}
	
	
	/**
	 * get the parent Slides if the Slide has any
	 **/
	public function get_parent_slides($published, $lang){
		global $SR_GLOBALS;
		
		apply_filters('revslider_get_parent_slides_pre', $lang, $published, array(), $this);
		
		if($SR_GLOBALS['front_version'] !== 6){
			$parent_slides = $this->get_slides($published);
		}else{
			if($this->is_posts()){
				$parent_slides = $this->get_slides_data_from_posts($published, $lang);
			}elseif($this->is_stream() !== false){
				$parent_slides = $this->get_slides_data_from_stream($published);
			}else{
				$parent_slides = $this->get_slides($published);
			}
		}
		
		apply_filters('revslider_get_parent_slides_post', $parent_slides, $published, array(), $this);
		
		return $parent_slides;
	}

	/**
	 * get all stream/post data
	 **/
	public function get_stream_data(){
		$stream_data = array();
		
		if($this->is_posts()){
			$stream_data = $this->get_slides_data_from_posts_v7();
		}elseif($this->is_stream()){
			$stream_data = $this->get_slides_data_from_stream_v7();
		}
		
		return $stream_data;
	}
	
	
	/**
	 * get array of slider id -> title
	 * @before: RevSliderSlider::getArrSlidersShort();
	 */		
	public function get_sliders_short($exclude_id = null, $filter = 'all'){
		$sliders	= $this->get_sliders();
		$short		= array();
		if(!empty($sliders)){
			foreach($sliders as $slider){
				$id			= $slider->get_id();
				$from_post	= $slider->is_posts();
				
				//filter by gallery only
				if($filter == 'posts' && $from_post == false) 	 continue;
				if($filter == 'gallery' && $from_post == true) 	 continue;
				if($filter == 'template' && $from_post == false) continue; //filter by template type
				if(!empty($exclude_id) && $exclude_id == $id)	 continue; //filter by except
				
				$short[$id] = $slider->get_title();
			}
		}
		
		return $short;
	}
	
	
	/**
	 * get the maximum order
	 * @before: RevSliderSlider::getMaxOrder()
	 */
	public function get_max_order(){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$record = $wpdb->get_row($wpdb->prepare("SELECT slide_order FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v ." WHERE slider_id = %d ORDER BY slide_order DESC LIMIT 0,1", $this->id), ARRAY_A);
		
		return (empty($record)) ? 0 : $this->get_val($record, 'slide_order');
	}
	
	
	/**
	 * get the slider type
	 */
	public function get_type(){
		$type		= 'gallery';
		$is_stream	= $this->is_stream();
		
		if($this->is_posts() == true){
			$type = (in_array($this->get_param('sourcetype', 'gallery'), array('woocommerce', 'woo'), true)) ? 'woocommerce' : 'posts';
			if($this->is_specific_posts()) $type = 'specific_posts';
		}elseif($is_stream !== false){
			$type = (in_array($is_stream, array('facebook', 'twitter', 'instagram', 'flickr', 'youtube', 'vimeo'))) ? $is_stream : $type;
		}
		
		return $type;
	}
	
	
	/**
	 * get the slider type before 60, needed for partial update proceess introduced in 6.0.0
	 * @since: 6.0.0
	 */
	public function get_type_pre60(){
		$type		= 'gallery';
		$is_stream	= $this->is_stream_pre60();
		
		if($this->is_posts_pre60() == true){
			$type = ($this->get_param('source_type', 'gallery') == 'woocommerce') ? 'woocommerce' : 'posts';
			
			if(in_array($this->get_param('sourcetype', 'gallery'), array('specific_posts', 'specific_post'), true)){
				$type = 'specific_posts';
			}
			
		}elseif($is_stream !== false){
			$type = (in_array($is_stream, array('facebook', 'twitter', 'instagram', 'flickr', 'youtube', 'vimeo'))) ? $is_stream : $type;
		}
		
		return $type;
	}
	
	
	/**
	 * copy slide from one Slider to the given Slider ID
	 * @since: 5.0
	 * @before: RevSliderSlider::copySlideToSlider()
	 */
	public function copy_slide_to_slider($data){
		global $wpdb, $SR_GLOBALS;
		
		$v = ($SR_GLOBALS['use_table_version'] === 7) ? '7' : '';
		
		$slider_id		= intval($this->get_val($data, 'slider_id'));
		$slide_id		= intval($this->get_val($data, 'slide_id'));
		$add_to_slider	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDER . $v ." WHERE id = %s", $slider_id), ARRAY_A); //check if ID exists
		
		if(empty($add_to_slider))
			return __('Slide could not be duplicated', 'revslider');
		
		//get last slide in slider for the order
		$slide_order	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v ." WHERE slider_id = %s ORDER BY slide_order DESC", $slider_id), ARRAY_A);
		$slide_to_copy	= $wpdb->get_row($wpdb->prepare("SELECT * FROM ". $wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v ." WHERE id = %s", $slide_id), ARRAY_A);
		
		if(empty($slide_to_copy))
			return __('Slide could not be duplicated', 'revslider');
		
		unset($slide_to_copy['id']); //remove the ID of the Slide, as it will be a new Slide
		$slide_to_copy['slider_id']		= $slider_id; //set the new Slider ID to the Slide
		$slide_to_copy['slide_order']	= (empty($slide_order)) ? 1 : $this->get_val($slide_order, 'slide_order') + 1; //set the next slide order, to set slide to the end
		
		$response = $wpdb->insert($wpdb->prefix . RevSliderFront::TABLE_SLIDES . $v, $slide_to_copy);
		
		if(isset($slide_id) && $response !== false){
			$this->map[$slide_id] = $wpdb->insert_id;
		}
		
		return ($response === false) ? __('Slide could not be duplicated', 'revslider') : true;
	}

	/**
	 * get slider' static slide
	 * 
	 * @since: 6.4.6
	 * @return false | RevSliderSlide
	 */
	public function get_static_slide()
	{
		$slider_id = $this->get_id();
		if (empty($slider_id)) return false;
		
		if ($this->_static_slide instanceof RevSliderSlide && $this->_static_slide->get_slider_id() == $slider_id) 
			return $this->_static_slide;

		$slide = new RevSliderSlide();
		$is_init = $slide->init_static_slide_by_slider_id($slider_id);
		if (!$is_init) return false;
		
		$this->_static_slide = $slide;
		return $this->_static_slide;
	}
	
	
	/**
	 * get all used fonts in the current Slider
	 * @since: 5.1.0
	 * @before: RevSliderSlider::getUsedFonts();
	 */
	public function get_used_fonts($full = false){
		$gf			= array();
		$sl			= new RevSliderSlide();
		$mslides	= $this->get_slides(true);
		
		$static_slide = $this->get_static_slide();
		if($static_slide !== false){
			$mslides = array_merge($mslides, array($static_slide));
		}
		
		if(!empty($mslides)){
			foreach($mslides as $ms){
				$mf = $ms->get_used_fonts($full);
				
				if(!empty($mf)){
					foreach($mf as $mfk => $mfv){
						if(!isset($gf[$mfk])){
							$gf[$mfk] = $mfv;
						}else{
							foreach($mfv['variants'] as $mfvk => $mfvv){
								$gf[$mfk]['variants'][$mfvk] = true;
							}
						}
						$gf[$mfk]['slide'][] = array('id' => $ms->get_id(), 'title' => $ms->get_title());
					}
				}
			}
		}
		
		return apply_filters('revslider_getUsedFonts', $gf);
	}
	
	public function get_slides_data_from_posts_v7(){
		$posts = $this->get_post_data();
		
		return $this->streamline_posts_data($posts);
	}

	/**
	 * get slides from posts
	 * @before: RevSliderSlider::getSlidesFromPosts();
	 */
	public function get_slides_data_from_posts($published = false, $lang = 'all'){
		$templates = $this->get_slides($published);
		$templates = $this->assoc_to_array($templates);
		if(count($templates) == 0) return array();
		$posts		= $this->get_post_data($published);
		$slides		= array();
		$key		= 0;
		$num_temp	= count($templates);
		
		foreach($posts ?? [] as $post_data){
			$found = false;
			if($lang !== 'all' && $this->get_val($templates[$key], array('params', 'child', 'language'), 'all') !== $lang){
				$children = $templates[$key]->get_children();
				if(!empty($children)){
					foreach($children as $child){
						if($this->get_val($child, array('params', 'child', 'language'), 'all') === $lang){
							$template = clone $child;
							$found = true;
							break;
						}
					}
				}
			}
			
			if($found === false){
				$template = clone $templates[$key];
			}
			//advance the templates
			$key++;
			if($key == $num_temp){
				$key		= 0;
				$templates	= $this->get_slides($published); //reset as clone did not work properly
				$templates	= $this->assoc_to_array($templates);
			}

			$slide = new RevSliderSlide();
			$slide->init_by_post_data($post_data, $template, $this->id);
			
			$slides[] = $slide;
		}

		$this->slides = $slides;
		
		return $this->slides;
	}
	
	public function get_post_data($published = false){
		$posts		= array();
		$gal_ids	= $this->get_gallery_ids();
		if(!empty($gal_ids)) ($this->v7) ? $this->set_param(array('source', 'type'), 'specific_posts') : $this->set_param('sourcetype', 'specific_posts');
		$source = ($this->v7) ? $this->get_param(array('source', 'type'), 'gallery') : $this->get_param('sourcetype', 'gallery');

		switch($source){
			case 'posts':
			case 'post':
				$subtype = $this->get_param(array('source', 'post', 'subType'), 'post');

				if($subtype === 'current_post'){
					global $post;
					//if empty, check referer and get ID from that one if exists
					$post_id = (empty($post)) ? url_to_postid($this->get_val($_SERVER, 'HTTP_REFERER')) : $this->get_val($post, 'ID');
					$posts = $this->get_specific_posts(array('', $post_id));
				}elseif(in_array($subtype, array('specific_posts', 'specific_post'), true)){
					$posts = $this->get_specific_posts($gal_ids);
				}else{
					//check where to get posts from
					switch($this->get_param(array('source', 'post', 'fetchType'), 'cat_type')){
						case 'cat_tag':
						default:
							$posts = $this->get_posts_by_categories($published);
						break;
						case 'related':
							$posts = $this->get_related_posts();
						break;
						case 'popular':
							$posts = $this->get_popular_posts();
						break;
						case 'recent':
							$posts = $this->get_latest_posts();
						break;
						case 'next_prev':
							$posts = $this->get_next_previous_post();
						break;
					}
				}
			break;
			case 'specific_posts':
			case 'specific_post':
				$posts = $this->get_specific_posts($gal_ids);
			break;
			case 'woocommerce':
			case 'woo':
				$posts = $this->get_products_from_categories($published);
			break;
			default:
				$this->throw_error(__('This Source Type must be from posts.', 'revslider'));
			break;
		}

		return $posts;
	}
	
	/**
	 * get related posts from current one
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsFromRelated();
	 */
	public function get_related_posts(){
		$my_posts	= array();
		$tags		= '';
		$post_id	= get_the_ID();
		$sort_by	= $this->get_param(array('source', 'post', 'sortBy'), 'ID');
		$source		= $this->get_param('source');
		$post		= $this->get_val($source, 'post');
		$max_posts	= $this->get_val($post, 'maxPosts', 30);
		$max_posts	= (empty($max_posts) || !is_numeric($max_posts)) ? -1 :  $max_posts;
		$post_tags	= get_the_tags();
		
		if($post_tags){
			foreach($post_tags as $post_tag){
				$tags .= $post_tag->slug . ',';
			}
		}
		
		$query = array(
			'numberposts' => $max_posts,
			'exclude'	=> $post_id,
			'order'		=> $this->get_param(array('source', 'post', 'sortDirection'), 'DESC'),
			'tag'		=> $tags
		);

		$tax_query = $this->get_tax_query();
		if(!empty($tax_query)) $query['tax_query'] = $tax_query;
		
		if(strpos($sort_by, 'meta_num_') === 0){
			$query['orderby']	= 'meta_value_num';
			$query['meta_key']	= str_replace('meta_num_', '', $sort_by);
		}elseif(strpos($sort_by, 'meta_') === 0){
			$query['orderby']	= 'meta_value';
			$query['meta_key']	= str_replace('meta_', '', $sort_by);
		}else{
			$query['orderby']	= $sort_by;
		}

		$get_relateds		= apply_filters('revslider_get_related_posts', $query, $post_id);
		$tag_related_posts	= get_posts($get_relateds);
		
		if(count($tag_related_posts) < $max_posts){
			$ignore = array();
			foreach($tag_related_posts as $tag_related_post){
				$ignore[] = $tag_related_post->ID;
			}
			$article_categories = get_the_category($post_id);
			$category_string = '';
			foreach($article_categories as $category){
				$category_string .= $category->cat_ID . ',';
			}
			
			$max	= $max_posts - count($tag_related_posts);
			$excl	= implode(',', $ignore);
			$query	= array(
				'exclude'		=> $excl,
				'numberposts'	=> $max,
				'category'		=> $category_string
			);
			
			if(strpos($sort_by, 'meta_num_') === 0){
				$query['orderby']	= 'meta_value_num';
				$query['meta_key']	= str_replace('meta_num_', '', $sort_by);
			}else
			if(strpos($sort_by, 'meta_') === 0){
				$query['orderby']	= 'meta_value';
				$query['meta_key']	= str_replace('meta_', '', $sort_by);
			}else{
				$query['orderby']	= $sort_by;
			}
			
			$get_relateds		= apply_filters('revslider_get_related_posts', $query, $post_id);
			$cat_related_posts	= get_posts($get_relateds);
			$tag_related_posts	= $tag_related_posts + $cat_related_posts;
		}

		foreach($tag_related_posts as $post){
			$the_post = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
			if($the_post['ID'] == $post_id) continue;
			$my_posts[] = $the_post;
		}
		
		return $my_posts;
	}
	
	
	/**
	 * get popular posts
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsFromPopular();
	 * @moved: 6.1.3
	 */
	public function get_popular_posts($max_posts = false){
		$post_id	= get_the_ID();
		$my_posts	= array();
		
		if($max_posts == false){
			$source		= $this->get_param('source');
			$post		= $this->get_val($source, 'post');
			$max_posts	= $this->get_val($post, 'maxPosts', 30);
			$max_posts = (empty($max_posts) || !is_numeric($max_posts)) ? -1 : $max_posts;
		}else{
			$max_posts = intval($max_posts);
		}

		$args = array(
			'suppress_filters' => 0,
			'posts_per_page' => $max_posts,
			'post_type'	=> 'any',
			'meta_key'  => '_thumbnail_id',
			'orderby'   => 'comment_count',
			'order'     => 'DESC'
		);

		$tax_query = $this->get_tax_query();
		if(!empty($tax_query)) $args['tax_query'] = $tax_query;
		
		$args	= apply_filters('revslider_get_popular_posts', $args, $post_id);
		$posts	= get_posts($args);
		
		foreach($posts as $post){
			$my_posts[] = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
		}
		
		return $my_posts;
	}
	
	
	/**
	 * get recent posts
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsFromRecent()
	 * @moved: 6.1.3
	 */
	public function get_latest_posts($max_posts = false){
		$post_id	= get_the_ID();
		$my_posts	= array();
		$args		= array(
			'post_type' => 'any',
			'suppress_filters' => 0,
			'meta_key'	=> '_thumbnail_id',
			'orderby'	=> 'date',
			'order'		=> 'DESC'
		);
		
		if($max_posts == false){
			$source		= $this->get_val($this->params, 'source');
			$post		= $this->get_val($source, 'post');
			$max_posts	= $this->get_val($post, 'maxPosts', 30);
			$max_posts	= (empty($max_posts) || !is_numeric($max_posts)) ? -1 : $max_posts;
		}else{
			$max_posts = intval($max_posts);
		}
		
		$args['posts_per_page']	= $max_posts;
		
		$tax_query = $this->get_tax_query();
		if(!empty($tax_query)) $args['tax_query'] = $tax_query;

		$args	= apply_filters('revslider_get_latest_posts', $args, $post_id);
		$posts	= get_posts($args);
		
		if(!empty($posts)){
			foreach($posts as $post){
				$my_posts[] = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
			}
		}
		
		return $my_posts;
	}
	
	
	/**
	 * get recent posts
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsNextPrevious();
	 */
	public function get_next_previous_post(){
		$my_posts = array();
		
		$startup_next_post = get_next_post();
		if(!empty($startup_next_post)){
			$my_posts[] = (method_exists($startup_next_post, 'to_array')) ? $startup_next_post->to_array() : (array)$startup_next_post;
		}    
		$startup_previous_post = get_previous_post();
		if(!empty($startup_previous_post)){
			$my_posts[] = (method_exists($startup_previous_post, 'to_array')) ? $startup_previous_post->to_array() : (array)$startup_previous_post;
		}
		
		return $my_posts;
	}


	public function get_tax_query(){
		$cat_ids	= $this->get_param(array('source', 'post', 'category'));
		$data		= $this->get_tax_by_cat_id($cat_ids);
		$tax_query	= false;
		if(isset($data['tax']) && isset($data['tax']) && !empty($data['tax']) && !empty($data['cats'])){
			$cat_id = (strpos($data['cats'], ',') !== false) ? explode(',', $data['cats']) : array($data['cats']);
			$tax_query = array('relation' => 'OR');

			//add taxomonies to the query
			$taxonomies = (strpos($data['tax'], ',') !== false) ? explode(',', $data['tax']) : array($data['tax']);
			foreach($taxonomies as $taxomony){
				$tax_query[] = array(
					'taxonomy'	=> $taxomony,
					'field'		=> 'id',
					'terms'		=> $cat_id
				);			
			}
		}

		return $tax_query;
	}
	
	public function _get_stream_data(){
		global $SR_GLOBALS;
		$posts		 = array();
		$max_allowed = 999999;
		$sourcetype	 = ($this->v7) ? $this->get_param(array('source', 'type'), 'gallery') : $this->get_param('sourcetype', 'gallery');
		$additions	 = array();
		$max_posts	 = 0;
		
		ob_start();
		switch($sourcetype){
			case 'facebook':
				$facebook = RevSliderGlobals::instance()->get('RevSliderFacebook');
				$facebook->setTransientSec($this->get_param(array('source', 'facebook', 'transient'), '1200'));
				if($this->get_param(array('source', 'facebook', 'typeSource'), 'timeline') == 'album'){
					$posts = $facebook->get_photo_set_photos(
						$this->id,
						$this->get_param(array('source', 'facebook', 'appId')),
						$this->get_param(array('source', 'facebook', 'album')),
						$this->get_param(array('source', 'facebook', 'count'), 8)
					);
					$additions['fb_type']	 = 'album';
				}else{
					$posts = $facebook->get_photo_feed(
						$this->id,
						$this->get_param(array('source', 'facebook', 'appId')),
						$this->get_param(array('source', 'facebook', 'page_id')),
						$this->get_param(array('source', 'facebook', 'count'), 8)
					);
					$additions['fb_type'] = 'timeline';
				}
				
				$max_posts	 = $this->get_param(array('source', 'facebook', 'count'), '25');
				$max_allowed = 25;
			break;
			case 'twitter':
				$this->throw_error(__('Twitter Stream is no longer available, for further information, please check https://www.sliderrevolution.com/faq/why-are-we-dropping-twitter-api-integration/', 'revslider'));
			break;
			case 'instagram':
				$instagram	= RevSliderGlobals::instance()->get('RevSliderInstagram');
				$instagram->setTransientSec($this->get_param(array('source', 'instagram', 'transient'), '1200'));
				$posts		= $instagram->get_public_photos($this->get_id(), $this->get_param(array('source', 'instagram', 'token')), $this->get_param(array('source', 'instagram', 'count'), '33'));
				$max_posts	= $this->get_param(array('source', 'instagram', 'count'), '33');
				$profile	= $instagram->get_user_profile($this->get_param(array('source', 'instagram', 'token')));
				$additions['instagram_user'] = isset($profile['username']) ? $profile['username'] : '';
				$max_allowed = 33;
			break;
			case 'flickr':
				$flickr = new RevSliderFlickr($this->get_param(array('source', 'flickr', 'apiKey')), $this->get_param(array('source', 'flickr', 'transient'), '1200'));
				switch($this->get_param(array('source', 'flickr', 'type'))){
					case 'publicphotos':
						$user_id = $flickr->get_user_from_url($this->get_param(array('source', 'flickr', 'userURL')));
						$posts	 = $flickr->get_public_photos($user_id, $this->get_param(array('source', 'flickr', 'count')));
					break;
					case 'gallery':
						$gallery_id	= $flickr->get_gallery_from_url($this->get_param(array('source', 'flickr', 'galleryURL')));
						$posts		= $flickr->get_gallery_photos($gallery_id, $this->get_param(array('source', 'flickr', 'count')));
					break;
					case 'group':
						$group_id	= $flickr->get_group_from_url($this->get_param(array('source', 'flickr', 'groupURL')));
						$posts		= $flickr->get_group_photos($group_id, $this->get_param(array('source', 'flickr', 'count')));
					break;
					case 'photosets':
						$posts = $flickr->get_photo_set_photos($this->get_param(array('source', 'flickr', 'photoSet')), $this->get_param(array('source', 'flickr', 'count')));
					break;
				}
				$max_posts = $this->get_param(array('source', 'flickr', 'count'), '99');
			break;
			case 'youtube':
				$channel_id	 = $this->get_param(array('source', 'youtube', 'channelId'));
				$youtube	 = new RevSliderYoutube($this->get_param(array('source', 'youtube', 'api')), $channel_id, $this->get_param(array('source', 'youtube', 'transient'), '1200'));
				if($this->get_param(array('source', 'youtube', 'typeSource')) == 'playlist'){
					$posts = $youtube->show_playlist_videos($this->get_param(array('source', 'youtube', 'playList')), $this->get_param(array('source', 'youtube', 'count')));
				}else{
					$posts = $youtube->show_channel_videos($this->get_param(array('source', 'youtube', 'count')));
				}
				
				$additions['yt_type'] = $this->get_param(array('source', 'youtube', 'typeSource'), 'channel');
				$max_posts	 = $this->get_param(array('source', 'youtube', 'count'), '25');
				$max_allowed = 50;
			break;
			case 'vimeo':
				$vimeo		= new RevSliderVimeo($this->get_param(array('source', 'vimeo', 'transient'), '1200'));
				$vimeo_type	= $this->get_param(array('source', 'vimeo', 'typeSource'));
				$max_posts	= $this->get_param(array('source', 'vimeo', 'count'), '25');
				$max_allowed = 60;
				if(intval($max_posts) > $max_allowed) $max_posts = $max_allowed;

				switch($vimeo_type){
					case 'user':
						$posts = $vimeo->get_vimeo_videos($vimeo_type, $this->get_param(array('source', 'vimeo', 'userName')), $max_posts);
					break;
					case 'channel':
						$posts = $vimeo->get_vimeo_videos($vimeo_type, $this->get_param(array('source', 'vimeo', 'channelName')), $max_posts);
					break;
					case 'group':
						$posts = $vimeo->get_vimeo_videos($vimeo_type, $this->get_param(array('source', 'vimeo', 'groupName')), $max_posts);
					break;
					case 'album':
						$posts = $vimeo->get_vimeo_videos($vimeo_type, $this->get_param(array('source', 'vimeo', 'albumId')), $max_posts);
					break;
					default:
					break;
				}
				
				$additions['vim_type'] = $this->get_param(array('source', 'vimeo', 'typeSource'), 'user');
			break;
			default:
				if($SR_GLOBALS['preview_mode']){
					$admin = new RevSliderAdmin();
					$admin->ajax_response_error(__('Make sure that the stream settings are properly selected in "Module General Options -> Content -> Stream Settings".', 'revslider'));
				}else{
					$this->throw_error(__('Make sure that the stream settings are properly selected in "Module General Options -> Content -> Stream Settings".', 'revslider'));
				}
			break;
		}
		$content = ob_get_contents();
		ob_clean();
		ob_end_clean();

		if($posts === false) $this->throw_error($content);

		return array('posts' => $posts, 'additions' => $additions, 'max_allowed' => $max_allowed, 'max_posts' => $max_posts, 'sourcetype' => $sourcetype);
	}

	public function get_slides_data_from_stream_v7(){
		$_posts = $this->_get_stream_data();
		$posts	= $this->get_val($_posts, 'posts', array());
		$sourcetype	= $this->get_val($_posts, 'sourcetype', array());
		$additions	= $this->get_val($_posts, 'additions', array());

		return $this->streamline_stream_data($posts, $sourcetype, $additions);
	}

	/**
	 * get slides from posts
	 * @before: RevSliderSlider::getSlidesFromStream();
	 */
	public function get_slides_data_from_stream($published = false){
		$templates = $this->get_slides($published);
		$templates = $this->assoc_to_array($templates);
		
		if(count($templates) == 0) return array();
		
		$_slides	 = array();
		$_posts 	 = $this->_get_stream_data();
		$posts		 = $this->get_val($_posts, 'posts', array());
		$sourcetype	 = $this->get_val($_posts, 'sourcetype', array());
		$additions	 = $this->get_val($_posts, 'additions', array());
		$max_posts	 = $this->get_val($_posts, 'max_posts', array());
		$max_allowed = $this->get_val($_posts, 'max_allowed', array());

		$max_posts = intval($max_posts);
		if($max_posts < 0) $max_posts *= -1;
		
		$posts = apply_filters('revslider_pre_mod_stream_data', $posts, $sourcetype, $this->id);
		$posts = (is_string($posts) || is_bool($posts)) ? array() : $posts;
		
		while(count($posts) > $max_posts || count($posts) > $max_allowed){
			array_pop($posts);
		}
		
		$posts = apply_filters('revslider_post_mod_stream_data', $posts, $sourcetype, $this->id);
		
		if(empty($posts)){
			global $SR_GLOBALS;
			if($SR_GLOBALS['preview_mode']){
				$admin = new RevSliderAdmin();
				$admin->ajax_response_error(__('Make sure that the stream settings are properly selected in "Module General Options -> Content -> Stream Settings".', 'revslider'));
			}else{
				$this->throw_error(__('Make sure that the stream settings are properly selected in "Module General Options -> Content -> Stream Settings".', 'revslider'));
			}
		}

		if(!empty($posts)){
			$i = 0;
			$tk = 0;
			foreach($posts as $data){
				if(empty($data)) continue; //ignore empty entries, like from instagram
				
				$slide_template = $templates[$tk];
				
				//advance the templates
				$tk++;
				$tk = ($tk == count($templates)) ? 0 : $tk;
				$_slides[$i] = new RevSliderSlide();

				$_slides[$i]->init_by_stream_data($data, $slide_template, $this->id, $sourcetype, $additions);
				
				$i++;
			}
		}
		
		$this->slides = $_slides;
		
		return $this->slides;
	}
	
	
	/**
	 * get posts from categories (by the slider params).
	 * @before: RevSliderSlider::getPostsFromCategories();
	 */
	private function get_posts_by_categories($published = false){
		$cat_ids	= $this->get_param(array('source', 'post', 'category'));
		$data		= $this->get_tax_by_cat_id($cat_ids);
		$post_types = $this->get_param(array('source', 'post', 'types'), 'post');
		$sort_by	= $this->get_param(array('source', 'post', 'sortBy'), 'ID');
		$sort_dir	= $this->get_param(array('source', 'post', 'sortDirection'), 'DESC');
		$sort_dir	= ($sort_by == 'menu_order') ? 'ASC' : $sort_dir;
		$source		= $this->get_param('source');
		$post		= $this->get_val($source, 'post');
		$max_posts	= $this->get_val($post, 'maxPosts', 30);
		$max_posts	= (empty($max_posts) || !is_numeric($max_posts)) ? -1 : $max_posts;
		$addition	= array();
		
		if($published == true){
			$addition['post_status'] = 'publish';
		}
		
		$slider_id	= $this->get_id();
		$post		= $this->get_posts_by_category($slider_id, $data['cats'], $sort_by, $sort_dir, $max_posts, $post_types, $data['tax'], $addition, 'post');
		
		return apply_filters('revslider_get_posts_by_categories', $post, $this);
	}
	
	
	/**
	 * get products from categories (by the slider params).
	 * @since: 5.1.0
	 * @before: RevSliderSlider::getProductsFromCategories();
	 */
	private function get_products_from_categories($published = false){
		$slider_id	= $this->get_id();
		$cat_ids	= $this->get_param(array('source', 'woo', 'category'));
		$data		= $this->get_tax_by_cat_id($cat_ids);
		$cat_ids	= $data['cats'];
		$taxonomies	= $data['tax'];
		$sort_by	= $this->get_param(array('source', 'woo', 'sortBy'), 'ID');
		$sort_dir	= $this->get_param(array('source', 'woo', 'sortDirection'), 'DESC');
		$sort_dir	= ($sort_by == 'menu_order') ? 'ASC' : $sort_dir;
		$max_posts	= $this->get_param(array('source', 'woo', 'maxProducts'), 30);
		$max_posts	= (empty($max_posts) || !is_numeric($max_posts)) ? -1 : $max_posts;
		$post_types	= $this->get_param(array('source', 'woo', 'types'), 'any');
		$addition	= array();
		$this->is_woocommerce = true;
		
		if($published == true){ //Events integration
			$addition['post_status'] = 'publish';
		}
		
		$addition = array_merge($addition, RevSliderWooCommerce::get_meta_query($this->get_params()));

		return $this->get_posts_by_category($slider_id, $cat_ids, $sort_by, $sort_dir, $max_posts, $post_types, $taxonomies, $addition);
	}
	
	
	/**
	 * get setting - start with slide
	 * @before: RevSliderSlider::getStartWithSlideSetting();
	 */
	public function get_start_with_slide_setting(){
		$slide = $this->get_param(array('general', 'firstSlide', 'alternativeFirstSlide'), 1);
		if(is_numeric($slide)){
			$slide = (int)$slide - 1;
			if($slide < 0 || $slide >= count($this->slides)) $slide = 0;
		}else{
			$slide = 0;
		}
		
		return $slide;
	}
	
	
	/**
	 * get the Slider Overview Structure
	 * @since: 6.0
	 */
	public function get_overview_data($slider = false, $slides = false, $slide_ids = false){
		//if we are pre 6.0.0, we have to create the data from the old data instead of the new format!
		
		$favorite	= RevSliderGlobals::instance()->get('RevSliderFavorite');
		$slider		= ($slider == false || $slider instanceof RevSliderFolder) ? $this : $slider;
		$post60		= (version_compare($slider->get_setting('version', '1.0.0'), '6.0.0', '<')) ? false : true;
		$id			= 0;
		$slides		= ($slides !== false) ? $slides :  $slider->get_slides();
		$type		= ($post60) ? $slider->get_type() : $this->get_type_pre60();
		$image		= '';
		$sid		= $slider->get_id();
		$do_ids		= ($slide_ids !== false) ? false : true;
		$addons_used = array();

		if(!empty($slides)){
			foreach($slides as $slide){
				$id		= $slide->get_id();
				$image	= ($post60) ? $slide->get_overview_image_attributes($type) : $slide->get_overview_image_attributes_pre60($type);
				break;
			}
			if($do_ids) $slide_ids = array();
			
			foreach($slides as $slide){
				if($do_ids) $slide_ids[] = $slide->get_id();

				$addons = $slide->get_param('addOns');
				if(!empty($addons)){
					foreach($addons as $addon => $values){
						if($this->_truefalse($this->get_val($values, 'enable', false)) === true){
							if(!in_array($addon, $addons_used)) $addons_used[] = $addon;
						}
					}
				}
			}
		}

		$addons = $slider->get_param('addOns');
		if(!empty($addons)){
			foreach($addons as $addon => $values){
				if($this->_truefalse($this->get_val($values, 'enable', false)) === true){
					if(!in_array($addon, $addons_used)) $addons_used[] = $addon;
				}
			}
		}

		return array(
			'id'		=> $sid,
			'slide_id'	=> $id,
			'slide_ids'	=> $slide_ids,
			'title'		=> esc_html($slider->get_title()),
			'alias'		=> $slider->get_alias(),
			'source'	=> esc_html($type),
			'type'		=> ($post60) ? $slider->get_param('type', 'standard') : $slider->get_param('slider-type', 'standard'),
			'size'		=> ($post60) ? $slider->get_param('layouttype') : $slider->get_param('slider_type', 'fullwidth'),
			'bg'		=> $image,
			'addons'	=> $addons_used,
			'premium'	=> $slider->get_param('pakps', false),
			'tags'		=> $this->get_tags(),
			'favorite'	=> $favorite->is_favorite('modules', $sid),
			'children'	=> ($slider instanceof RevSliderFolder) ? $slider->get_children() : array(),
			'folder'	=> $slider instanceof RevSliderFolder
		);
	}
	
	
	/**
	 * get posts from specific posts list
	 * @before: RevSliderSlider::getPostsFromSpecificList();
	 */
	public function get_specific_posts($gal_ids = array()){
		$additional	= array();
		$slider_id	= $this->get_id();
		
		if(!empty($gal_ids) && $gal_ids[0] !== ''){
			$posts	= $gal_ids;
			$posts	= apply_filters('revslider_set_posts_list_gal', $posts, $this->get_id());
		}else{
			if(isset($gal_ids[0])){
				unset($gal_ids[0]);
				$posts					= implode(',', $gal_ids);
				$additional['order']	= 'none';
				$additional['orderby']	= 'post__in';
			}else{
				$posts = $this->get_param(array('source', 'post', 'list'), '');	
				$additional['order'] = $this->get_param(array('source', 'post', 'sortDirection'), 'DESC');
				$additional['orderby'] = $this->get_param(array('source', 'post', 'sortBy'), '');
			}
			$posts = apply_filters('revslider_set_posts_list', $posts, $this->get_id());
		}
		
		return $this->get_posts_by_id($posts, $slider_id, $this->is_gallery, $additional);
	}
	
	
	/**
	 * get posts by coma saparated posts
	 * @before: RevSliderFunctionsWP::getPostsByIDs();
	 */
	public function get_posts_by_id($ids, $slider_id, $is_gal, $additional = array()){
		$arr = (is_string($ids)) ? explode(',', $ids) : $ids;

		$query = array(
			'ignore_sticky_posts' => 1,
			'post_type'	=> 'any',
			'post__in'	=> $arr
		);
		if($is_gal){
			$query['post_status']	= 'inherit';
			$query['orderby']		= 'post__in';
		}
		
		$query	= array_merge($query, $additional);
		$query	= apply_filters('revslider_get_posts', $query, $slider_id);
		$object	= new WP_Query($query);
		$posts	= $object->posts;

		//check if we used the [gallery] shortcode, but added posts instead if images
		if(empty($posts) && $is_gal){
			unset($query['post_status']);
			$object	= new WP_Query($query);
			$posts	= $object->posts;
			if(!empty($posts)) $this->is_gallery = false; //setting this will make sure to fetch images from the posts instead of the image id directly
		}

		foreach($posts ?? [] as $key => $post){
			$posts[$key] = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
		}

		return $posts;
	}
	
	
	/**
	 * get posts by some category
	 * could be multiple
	 * @before: RevSliderFunctionsWP::getPostsByCategory()
	 */
	public function get_posts_by_category($slider_id, $cat_id, $sort_by = 'ID', $direction = 'DESC', $max_posts = -1, $post_types = 'any', $taxonomies = 'category', $addition = array(), $type = ''){
		$a = apply_filters('revslider_get_posts_by_category', array('slider_id' => $slider_id, 'cat_id' => $cat_id, 'sort_by' => $sort_by, 'direction' => $direction, 'max_posts' => $max_posts, 'post_types' => $post_types, 'taxonomies' => $taxonomies, 'addition' => $addition, 'type' => $type), $this);
		$slider_id	= $this->get_val($a, 'slider_id');
		$cat_id		= $this->get_val($a, 'cat_id');
		$sort_by	= $this->get_val($a, 'sort_by');
		$direction	= $this->get_val($a, 'direction');
		$max_posts	= $this->get_val($a, 'max_posts');
		$post_types	= $this->get_val($a, 'post_types');
		$taxonomies	= $this->get_val($a, 'taxonomies');
		$addition	= $this->get_val($a, 'addition');
		$type		= $this->get_val($a, 'type');
		$tax		= (!empty($taxonomies)) ? explode(',', $taxonomies) : array(); //get taxonomies array
		
		if(!is_array($post_types)){
			if(strpos($post_types, ',') !== false){
				$post_types = explode(',', $post_types);
				$post_types = (array_search('any', $post_types) !== false) ? 'any' : $post_types;
			}
		}
		$post_types	= (empty($post_types)) ? 'any' : $post_types;
		$cat_id		= (strpos($cat_id, ',') !== false) ? explode(',', $cat_id) : array($cat_id);
		
		$query		= array(
			'order'					=> $direction,
			'ignore_sticky_posts'	=> 1,
			'posts_per_page'		=> $max_posts,
			'showposts'				=> $max_posts,
			'post_type'				=> $post_types
		);		

		//add sort by (could be by meta)
		if(strpos($sort_by, 'meta_num_') === 0){
			$query['orderby']	= 'meta_value_num';
			$query['meta_key']	= str_replace('meta_num_', '', $sort_by);
		}elseif(strpos($sort_by, 'meta_') === 0){
			$query['orderby']	= 'meta_value';
			$query['meta_key']	= str_replace('meta_', '', $sort_by);
		}else{
			$query['orderby']	= $sort_by;
		}
		
		if(!empty($taxonomies)){
			$tax_query = array('relation' => 'OR');
		
			//add taxomonies to the query
			$taxonomies = (strpos($taxonomies, ',') !== false) ? explode(',', $taxonomies) : array($taxonomies);
			foreach($taxonomies as $taxomony){
				$tax_query[] = array('taxonomy' => $taxomony, 'field' => 'id', 'terms' => $cat_id);			
			}

			$query['tax_query'] = $tax_query;
		}
		
		if(!empty($addition)){
			$tax_query = $this->get_val($addition, 'tax_query', array());
			if(!empty($tax_query)){
				if(!isset($query['tax_query'])) $query['tax_query'] = array();
				if(is_array($tax_query)){
					foreach($tax_query as $tk => $tv){
						if(is_numeric($tk)){
							$query['tax_query'][] = $tv;
						}else{
							$query['tax_query'][$tk] = $tv;
						}
					}
				}
				unset($addition['tax_query']);
			}
			$query = array_merge($query, $addition);
		}
		
		$query		= apply_filters('revslider_get_posts', $query, $slider_id);
		$full_posts	= new WP_Query($query);
		$posts		= $full_posts->posts;
		
		if($this->is_woocommerce) $posts = RevSliderWooCommerce::filter_products_by_price($posts, $this->get_params());

		if(!empty($posts)){
			foreach($posts as $key => $post){
				$arr_post = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
				$arr_post['categories'] = $this->get_post_categories($post, $tax);
				
				$posts[$key] = $arr_post;
			}
		}
		
		return $posts;
	}
	
	
	/**
	 * get post categories by post ID and taxonomies
	 * the post ID can be post object or array too
	 * @before: RevSliderFunctionsWP::getPostCategories()
	 */
	public function get_post_categories($post_id, $tax){
		if(!is_numeric($post_id)){
			$post_id = (array)$post_id;
			$post_id = $post_id['ID'];
		}
		$cats = wp_get_post_terms($post_id, $tax);
		
		return $this->class_to_array($cats);
	}
	
	
	/**
	 * get cats and taxanomies data from the category id's
	 * @before: RevSliderFunctionsWP::getCatAndTaxData()
	 */
	public function get_tax_by_cat_id($cat_ids){
		$ret	= array('tax' => '', 'cats' => '');
		$tax	= array();
		$cats	= '';
		$taxs	= '';
		
		if(is_string($cat_ids)){
			$cat_ids = trim($cat_ids);
			$cat_ids = (empty($cat_ids)) ? array() : explode(',', $cat_ids);
		}
		
		if(!empty($cat_ids)){
			foreach($cat_ids as $cat){
				if(strpos($cat, 'option_disabled') === 0) continue;
				
				$pos = strrpos($cat, '_');
				if($pos === false) $this->throw_error(__('Wrong category format', 'revslider'));
				
				$tax_name		= substr($cat, 0, $pos);
				$tax[$tax_name]	= $tax_name;
				$cats			.= (!empty($cats)) ? ',' : '';
				$cats			.= substr($cat, $pos + 1, strlen($cat) - $pos - 1); //category id
			}
			
			$ret['cats'] = $cats;
		}
		
		if(!empty($tax)){
			foreach($tax as $tax_name){
				$taxs .= (!empty($taxs)) ? ','.$tax_name : $tax_name;
			}
		}
		$ret['tax'] = $taxs;
		
		return $ret;
	}
	
	/**
	 * check for global settings lazy load and modify slider settings
	 * only do these changes on outputting the slider
	 * @since: 6.4.12
	 **/
	public function modify_by_global_settings(){
		global $SR_GLOBALS;
		if(is_admin() && !$SR_GLOBALS['preview_mode']) return true;
		
		$gs = $this->get_global_settings();
		$loazyload = $this->get_val($this->params, array('general', 'lazyLoad'), 'none');
		if($loazyload === 'none'){
			$forceLazyLoading = $this->get_val($gs, 'forceLazyLoading', 'smart');
			$this->set_val($this->params, array('general', 'lazyLoad'), $forceLazyLoading);
		}
		
		$forceViewport = $this->get_val($gs, 'forceViewport', true);
		$forceViewportDist = $this->get_val($gs, 'forcedViewportDistance', '-200px');
		$this->set_val($this->params, array('general', 'slideshow', 'globalViewPort'), $forceViewport);
		$this->set_val($this->params, array('general', 'slideshow', 'globalViewDist'), $forceViewportDist);
	}

	/**
	 * fetches data from a post that we want to use later on
	 */
	public function streamline_posts_data($data){
		if(empty($data) || !is_array($data)) return $data;

		$templates 			= $this->get_slides(false);
		$templates 			= $this->assoc_to_array($templates);
		$metas				= $this->get_used_metas();
		$post_data			= array();
		$ignore_taxonomies	= apply_filters('revslider_slide_ignore_taxonomies', array('post_tag', 'translation_priority', 'language', 'post_translations'), $this);
		//$source_type		= $this->get_param('sourcetype', 'gallery');
		$key				= 0;
		$num_temp			= count($templates);
		$excerpt_limit		= $this->get_val($this->params, array('source', 'post', 'excerptLimit'), 55);
		$excerpt_type		= (strpos($excerpt_limit, 'chars') !== false) ? 'chars' : 'words';
		$excerpt_limit		= (strpos($excerpt_limit, 'chars') !== false) ? str_replace('chars', '', $excerpt_limit) : str_replace(array('char', 'words'), '', $excerpt_limit); //char is a fallback from before 6.3.4
		$excerpt_limit		= (int)$excerpt_limit;

		foreach($data as $k => $entry){
			if(!empty($templates)){
				$template = clone $templates[$key];
				$key++;
				if($key == $num_temp){
					$key		= 0;
					$templates	= $this->get_slides(false); //reset as clone did not work properly
					$templates	= $this->assoc_to_array($templates);
				}
			}
			$author						= get_user_by('ID', $this->get_val($entry, 'post_author'));
			$post_id					= $this->get_val($entry, 'ID');
			$cats						= $this->get_val($entry, array('source', 'post', 'category'));
			$full						= false;
			//$post_image_id				= ($source_type === 'specific_posts') ? $post_id : get_post_thumbnail_id($post_id);
			$post_image_id				= ($this->is_gallery) ? $post_id : get_post_thumbnail_id($post_id);
			$featured_image_url			= wp_get_attachment_image_src($post_image_id, 'full'); //get full and thumbnail
			$featured_image_url_thumb	= wp_get_attachment_image_src($post_image_id, 'thumbnail'); //get full and thumbnail
			
			if(empty($cats)){
				$cats		= array();
				$taxonomies = get_object_taxonomies($this->get_val($entry, 'post_type'));
				
				foreach($taxonomies ?? [] as $ptt){
					if(in_array($ptt, $ignore_taxonomies, true)) continue;
					$temp_cats = get_the_terms($post_id, $ptt);
					if(!empty($temp_cats)){
						$cats = array_merge($cats, $temp_cats);
						$full = true;
					}
				}
			}
			$title	 = $this->get_val($entry, array('post_title'));
			$excerpt = str_replace(array('<br/>', '<br />'), '', strip_tags($this->get_val($entry, array('post_excerpt')), '<b><br><i><strong><small>'));
			$excerpt = ($excerpt_type === 'words') ? $this->get_text_intro($excerpt, $excerpt_limit) : $this->get_text_intro_chars($excerpt, $excerpt_limit);

			$raw_data = array(
				'id'			=> $post_id,
				'author'		=> $this->get_val($author, array('data', 'display_name')),
				'content'		=> array('content' => $this->get_val($entry, array('post_content'))),
				'excerpt'		=> $excerpt,
				'link'			=> get_permalink($this->get_val($entry, 'ID')),
				'media'			=> ($featured_image_url !== false) ? $featured_image_url[0] : '',//$this->get_val($entry, array('full_picture')),
				'mediatag'		=> ($featured_image_url !== false) ?'<img src="'.$featured_image_url[0].'" width="'.$featured_image_url[1].'" height="'.$featured_image_url[2].'" alt="'.esc_attr($title).'" data-no-retina />' : '',//$this->get_val($entry, array('full_picture')),
				'meta'			=> array(),
				'modified'		=> $this->convert_post_date($this->get_val($entry, 'post_modified')),
				'numcomments'	=> $this->get_val($entry, array('comment_count')),		
				'publish'		=> $this->convert_post_date($this->get_val($entry, 'post_date_gmt')),
				'navthumb'		=> (!empty($templates)) ? $this->get_thumb_url($template, $post_image_id) : '',
				'thumb'			=> ($featured_image_url_thumb !== false) ? $featured_image_url_thumb[0] : '', //$this->get_val($entry, array('picture')),
				'thumbtag'		=> ($featured_image_url_thumb !== false) ?'<img src="'.$featured_image_url_thumb[0].'" width="'.$featured_image_url_thumb[1].'" height="'.$featured_image_url_thumb[2].'" alt="'.esc_attr($title).'" data-no-retina />' : '',//$this->get_val($entry, array('full_picture')),
				'taglist'		=> get_the_tag_list('', ',', '', $post_id),
				'title'			=> $title,
			);

			if(!empty($metas)){
				foreach($metas as $meta){
					switch($meta){
						case 'id':
							$raw_data['id'] = $this->get_val($entry, 'ID');
						break;
						case 'alias':
							$raw_data['alias'] = $this->get_val($entry, 'post_name');
						break;
						case 'catlist':
							$raw_data['catlist'] = $this->get_categories_html($cats, null, $post_id, $full);
						break;
						case 'catlist_raw':
							$raw_data['catlistraw'] = strip_tags($this->get_categories_html($cats, null, $post_id, $full));
						break;
						case 'taglist':
							$raw_data['taglist'] = get_the_tag_list('', ',', '', $post_id);
						break;
						case 'author_website':
							$raw_data['author_website'] = $this->get_val($author, 'user_url');
						break;
						case 'author_posts':
							$raw_data['author_posts'] = get_author_posts_url($this->get_val($entry, 'post_author'));
						break;
					}

					$_meta = (strpos($meta, ':') !== false) ? explode(':', $meta) : false;
					if($_meta === false) continue;
					if($_meta[0] === 'meta'){
						$raw_data['meta'][$_meta[1]] = get_post_meta($post_id, $_meta[1], true);
					}elseif($_meta[0] === 'author_avatar'){
						if(count($_meta) !== 2) continue;
						$_meta[1] = intval($_meta[1]);
						if($_meta[1] === 0 || $_meta[1] < 0) continue;
						
						$raw_data['author_avatar'] = get_avatar_url($this->get_val($data, 'authorID'), array('size'=> $_meta[1]));
					}else{
						//this works only for metas that are already defined in $raw_data
						$value = '';
						if(!isset($raw_data[$_meta[0]])) continue;
						if(count($_meta) !== 3) continue;
						$_meta[2] = intval($_meta[2]);
						if($_meta[2] === 0) continue;

						$text = ($_meta[0] === 'content') ? $raw_data[$_meta[0]]['content'] : $raw_data[$_meta[0]];
						switch($_meta[1]){
							case 'words':
								$value = explode(' ', strip_tags($text), $_meta[2] + 1);
								if(is_array($value) && count($value) > $_meta[2]) array_pop($value);
								$value = implode(' ', $value);
							break;
							case 'chars':
								$value = mb_substr(strip_tags($text), 0, $_meta[2]);
							break;
							default:
								continue 2;
							break;
						}

						if($_meta[0] === 'content'){
							if(!isset($raw_data['content'][$_meta[1]])) $raw_data['content'][$_meta[1]] = array();
							$raw_data['content'][$_meta[1]][$_meta[2]] = $value;
						}else{
							if(!isset($raw_data['meta'][$_meta[0]])) $raw_data['meta'][$_meta[0]] = array();
							if(!isset($raw_data['meta'][$_meta[0]][$_meta[1]])) $raw_data['meta'][$_meta[0]][$_meta[1]] = array();
							$raw_data['meta'][$_meta[0]][$_meta[1]][$_meta[2]] = $value;
						}
					}
				}
			}
			
			$post_data[] = $raw_data;
		}

		$post_data = apply_filters('sr_streamline_post_data_post', $post_data, $data, $metas, $this);

		return $post_data;
	}

	/**
	 * streamline the stream data to an universal array
	 */
	public function streamline_stream_data($data, $sourcetype, $additions){
		$_data = array();
		switch($sourcetype){
			case 'facebook':
				$_data = $this->streamline_by_facebook($data, $additions);
			break;
			case 'flickr':
				$_data = $this->streamline_by_flickr($data, $additions);
			break;
			case 'instagram':
				$_data = $this->streamline_by_instagram($data, $additions);
			break;
			case 'vimeo':
				$_data = $this->streamline_by_vimeo($data, $additions);
			break;
			case 'youtube':
				$_data = $this->streamline_by_youtube($data, $additions);
			break;
			default:
				$return = apply_filters('revslider_streamline_stream_data', false, $data, $sourcetype, $additions, $this);
				
				if($return === false) $this->throw_error(__('Source must be from a stream', 'revslider'));
			break;
		}

		$_data = $this->add_stream_metas($_data, $data, $sourcetype, $additions);
		
		return $_data;
	}


	public function streamline_by_facebook($data, $additions){
		$fb_data	= array();
		
		if(empty($data) || !is_array($data)) return $fb_data;

		foreach($data as $k => $entry){
			$likes			= $this->get_val($entry, array('likestream', 'summary', 'can_like'));
			$num_comments	= $this->get_val($entry, array('commentstream', 'summary', 'can_comment'));
			if(empty($likes) || $likes === false)				$likes = $this->get_val($entry, array('likestream', 'summary', 'total_count'));
			if(empty($num_comments) || $num_comments === false)	$num_comments = $this->get_val($entry, array('commentstream', 'summary', 'total_count'));

			$fb_data[] = array(
				'author'		=> $this->get_val($entry, array('from', 'name')),
				'customMetas'	=> array(),
				'content'		=> array('content' => nl2br($this->get_val($entry, array('message')))),
				'likes'			=> $likes,
				'link'			=> $this->get_val($entry, array('permalink_url')),
				'media'			=> $this->get_val($entry, array('full_picture')),
				'modified'		=> $this->convert_post_date($this->get_val($entry, array('updated_time'))),
				'num_comments'	=> $num_comments,			
				'publish'		=> $this->convert_post_date($this->get_val($entry, array('created_time'))),
				'thumb'			=> $this->get_val($entry, array('picture')),
				'title'			=> $this->get_val($entry, array('message'))
			);
		}

		return $fb_data;
	}

	private function flickr_base_encode($num, $alphabet = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ')
	{
		$base_count = strlen($alphabet);
		$encoded = '';
		while ($num >= $base_count) {
			$div = $num / $base_count;
			$mod = ($num - ($base_count * intval($div)));

			/* 2.1.5 */
			$mod = intval($mod);
			$encoded = $alphabet[$mod] . $encoded;

			$num = intval($div);
		}
		if ($num) $encoded = $alphabet[$num] . $encoded;
		return $encoded;
	}

	public function streamline_by_flickr($data, $additions){
		$fl_data = array();
		if(empty($data) || !is_array($data)) return $fl_data;
		
		foreach($data as $k => $entry){
			$fl_data[] = array(
				'author'		=> $this->get_val($entry, array('ownername')),
				'content'		=> array('content' => nl2br($this->get_val($entry, array('description', '_content')))),
				'link'			=> '//flic.kr/p/'.$this->flickr_base_encode($this->get_val($entry, array('id'))),
				'media'			=> $this->remove_http($this->get_val($entry, array('url_o'))),
				'modified'		=> $this->convert_post_date($this->get_val($entry, array('datetaken'))),
				'publish'		=> $this->convert_post_date($this->get_val($entry, array('datetaken'))),
				'thumb'			=> $this->remove_http($this->get_val($entry, array('url_t'))),
				'title'			=> $this->get_val($entry, array('title')),
				'views'			=> $this->get_val($entry, array('views'))
			);
		}

		return $fl_data;
	}

	public function streamline_by_instagram($data, $additions){
		$ig_data = array();
		if(empty($data) || !is_array($data)) return $ig_data;

		foreach($data as $k => $entry){
			$image = $this->get_val($entry, array('thumbnail_url'));
			$video = $this->get_val($entry, array('media_url'));
			$ig_data[] = array(
				'author'		=> $this->get_val($entry, array('username')),
				'content'		=> array('content' => nl2br($this->get_val($entry, array('caption')))),
				'link'			=> $this->get_val($entry, array('link')),
				'media'			=> (empty($image)) ? '' : $video,
				'num_comments'	=> $this->get_val($entry, array('stats_number_of_comments')),
				'publish'		=> $this->convert_post_date($this->get_val($entry, array('taken_at_timestamp'))),
				'title'			=> $this->get_val($entry, array('caption')),
				'thumb'			=> (empty($image)) ? $video : $image,
				'views'			=> $this->get_val($entry, array('stats_number_of_plays'))
			);
		}

		return $ig_data;
	}

	public function streamline_by_vimeo($data, $additions){
		$vm_data = array();
		if(empty($data) || !is_array($data)) return $vm_data;

		//TODO: check $additions['vim_type'];
		foreach($data as $k => $entry){
			$vm_data[] = array(
				'author'		=> $this->get_val($entry, array('user', 'user_name')),
				'content'		=> array('content' => nl2br($this->get_val($entry, array('description')))),
				'likes'			=> $this->get_val($entry, array('stats_number_of_likes')),
				'link'			=> $this->get_val($entry, array('url')),
				'media'			=> $this->get_val($entry, array('id')),
				'num_comments'	=> $this->get_val($entry, array('stats_number_of_comments')),
				'publish'		=> $this->convert_post_date($this->get_val($entry, array('upload_date'))),
				'title'			=> $this->get_val($entry, array('title')),
				'thumb'			=> $this->get_val($entry, array('thumbnail_large')),
				'views'			=> $this->get_val($entry, array('stats_number_of_plays'))
			);
		}

		return $vm_data;
	}

	public function streamline_by_youtube($data, $additions){
		$yt_data = array();
		
		if(empty($data) || !is_array($data)) return $yt_data;

		$channel = ($additions['yt_type'] === 'channel') ? true : false;
		foreach($data as $k => $entry){
			$id			= ($channel) ? $this->get_val($entry, array('id', 'videoId')) : $this->get_val($entry, array('snippet', 'resourceId', 'videoId'));
			$thumb		= $this->get_val($entry, array('snippet', 'thumbnails', 'maxres', 'url'));
			if(empty($thumb)) $thumb = $this->get_val($entry, array('snippet', 'thumbnails', 'high', 'url'));
			$yt_data[]	= array(
				'author'	=> ($channel) ? '' : $this->get_val($entry, array('snippet', 'author')),
				'content'	=> nl2br($this->get_val($entry, array('snippet', 'description'))),
				'link'		=> '//youtube.com/watch?v=' .  $id,
				'publish'	=> ($channel) ? '' : $this->convert_post_date($this->get_val($entry, array('snippet', 'publishedAt'))),
				'media'		=> $id,
				'thumb'		=> $this->remove_http($thumb),
				'title'		=> $this->get_val($entry, array('snippet', 'title'))
			);
		}
		
		return $yt_data;
	}
	
	public function add_stream_metas($streams, $stream_data, $source_type, $additions = array()){
		$metas = $this->get_used_metas();

		if(empty($metas)) return $streams;
		if(empty($streams)) return $streams;

		foreach($streams as $k => $data){
			foreach($metas as $meta){
				switch($meta){
					case 'alias':
						$streams[$k]['alias'] = $this->get_val($stream_data, array($k, 'alias'));
					break;
				}

				$_meta = (strpos($meta, ':') !== false) ? explode(':', $meta) : false;
				if($_meta === false) continue;
				
				//this works only for metas that are already defined in $data
				$value = '';
				if(!isset($data[$_meta[0]])) continue;
				if(count($_meta) !== 3) continue;
				$_meta[2] = intval($_meta[2]);
				if($_meta[2] === 0) continue;

				$text = $data[$_meta[0]];
				if(is_array($text)) $text = $text[$_meta[0]];
				switch($_meta[1]){
					case 'words':
						$value = explode(' ', strip_tags($text), $_meta[2] + 1);
						if(is_array($value) && count($value) > $_meta[2]) array_pop($value);
						$value = implode(' ', $value);
					break;
					case 'chars':
						$value = mb_substr(strip_tags($text), 0, $_meta[2]);
					break;
					default:
						continue 2;
					break;
				}

				if($_meta[0] === 'content'){
					if(!isset($streams[$k]['content'][$_meta[1]])) $streams[$k]['content'][$_meta[1]] = array();
					$streams[$k]['content'][$_meta[1]][$_meta[2]] = $value;
				}else{
					if(!isset($streams[$k]['meta'])) $streams[$k]['meta'] = array();
					if(!isset($streams[$k]['meta'][$_meta[0]])) $streams[$k]['meta'][$_meta[0]] = array();
					if(!isset($streams[$k]['meta'][$_meta[0]][$_meta[1]])) $streams[$k]['meta'][$_meta[0]][$_meta[1]] = array();
					$streams[$k]['meta'][$_meta[0]][$_meta[1]][$_meta[2]] = $value;
				}
			}
		}

		return $streams;
	}

	public function get_used_metas(){
		if(!empty($this->metas)) return $this->metas;
		if(empty($this->slides)) $this->get_slides_for_output();
		
		$text = serialize($this->slides);
		preg_match_all('/{{(.*?)}}/', $text, $matches, PREG_PATTERN_ORDER);
		
		$placeholders = $this->get_val($matches, 1, array());
		
		if(empty($placeholders)) return $this->metas;
		
		$this->metas = $placeholders;

		return $this->metas;
	}

	/**
	 * returns a slider object with all slides and static slide in v6 or v7 format for JSON/REST
	 * sensitive data needs to be removed: source as it contains stream login data
	 */
	public function get_full_slider_JSON($slider = false, $full = true, $slide_ids = array(), $forced_ids = array(), $raw = false, $modify = true){
		global $SR_GLOBALS;

		if($slider === false) $slider = $this;
		if(!empty($slide_ids) && !is_array($slide_ids)) $slide_ids = (array)$slide_ids;

		$SR_wpml = RevSliderGlobals::instance()->get('RevSliderWpml');
		$lang	 = $SR_wpml->get_slider_language($slider);
		if($lang !== 'all' && $modify === true) $slider->change_language($lang);
		
		$slider_id		= $slider->get_id();
		$modify_allow	= array('excerptLimit', 'maxPosts', 'maxProducts', 'count');
		$modify_sources	= array('post', 'specific_posts', 'specific_post', 'woo', 'woocommerce', 'instagram', 'facebook', 'flickr', 'twitter', 'vimeo', 'youtube');
		$modify_setting	= ($slider->v7) ? 'settings' : 'slider_params';

		if($slider->v7){
			$obj = (empty($slide_ids)) ? array('settings' => $slider->get_params(), 'slides' => array(), 'id' => $slider_id) : array('slides' => array());

			$slides = ($raw) ? $slider->get_slides(false, true) : $slider->get_slides_modified(false, true);
			if($lang !== 'all' && $modify === true) $slides = $slider->get_language_slides_v7($slides);//get WPML language slides

			if(empty($slides)) return $obj;
			
			$first = ($full === false) ? true : false;
			foreach($slides as $slide_id => $slide){
				if(!empty($slide_ids) && !in_array($slide_id, $slide_ids)) continue;
				if($modify === true && !$slide->check_use_slide()) continue;
				if($SR_GLOBALS['serial'] > 2 && !empty($forced_ids) && !in_array($slide_id, $forced_ids)) continue;

				$obj['slides'][$slide_id] = array(
					'id'	 => $slide_id,
					'slide'	 => $slide->get_params(),
					'layers' => ($full === true || $full === false && $first === true) ? $slide->get_layers(true) : array()
				);
				$first = false;
			}

			$static_slide_id = $slide->get_static_slide_id($slider_id);
			if(!empty($slide_ids) && !in_array($static_slide_id, $slide_ids, true)) $static_slide_id = 0;

			if(intval($static_slide_id) > 0){
				$static_slide = new RevSliderSlide();
				$static_slide->init_by_static_id($static_slide_id);
				if(!empty($static_slide)){
					$obj['slides'][$static_slide_id] = array( //'static_'.
						'id'		=> $static_slide_id,
						'slide'		=> $static_slide->get_params(),
						'layers'	=> $static_slide->get_layers()
					);
				}
			}
		}else{
			$slides = ($raw) ? $slider->get_slides() : $slider->get_slides_modified();
			if($lang !== 'all' && $modify === true) $slides = $slider->get_language_slides_v7($slides);//get WPML language slides

			$_slides = array();
			$_static_slide = array();

			if(!empty($slides)){
				foreach($slides as $s){
					$slide_id = $s->get_id();
					if(!empty($slide_ids) && !in_array($slide_id, $slide_ids)) continue;
					if($modify === true && !$s->check_use_slide()) continue;
					if($SR_GLOBALS['serial'] > 2 && !empty($forced_ids) && !in_array($slide_id, $forced_ids)) continue;

					if($SR_GLOBALS['use_table_version'] === 6 && $SR_GLOBALS['front_version'] === 7){
						$t_v7id = $this->get_v7_slider_map(false, $slide_id);
						if(intval($t_v7id) !== 0) $slide_id = $t_v7id;
					}
					$_slides[] = array(
						'order' => $s->get_order(),
						'params' => $s->get_params(),
						'layers' => $s->get_layers(),
						'id' => $slide_id,
					);
				}

				$static_slide_id = $s->get_static_slide_id($slider_id);
				if(!empty($slide_ids) && !in_array($static_slide_id, $slide_ids)) $static_slide_id = 0;
				//$static_slide_id = (intval($static_slide_id) === 0) ? $slide->create_slide($slider_id, '', true) : $static_slide_id;
			
				$static_slide = false;
				
				if(intval($static_slide_id) > 0){
					$static_slide = new RevSliderSlide();
					$static_slide->init_by_static_id($static_slide_id);
				}
				
				if(!empty($static_slide)){
					$slide_id = $static_slide->get_id();
					if($SR_GLOBALS['use_table_version'] === 6 && $SR_GLOBALS['front_version'] === 7){
						$t_v7id = $this->get_v7_slider_map(false, 'static_'.$slide_id);
						if(intval($t_v7id) !== 0) $slide_id = $t_v7id;
					}
					$_static_slide = array(
						'params' => $static_slide->get_params(),
						'layers' => $static_slide->get_layers(),
						'id' => $slide_id,
					);
				}
			}
			
			$obj = (empty($slide_ids)) ? array(
				'id' => $slider_id,
				'alias' => $slider->get_alias(),
				'title' => $slider->get_title(),
				'slider_params' => $slider->get_params(true),
				'slider_settings' => $slider->get_settings(),
				'slides' => $_slides,
				'static_slide' => $_static_slide,
			) : array('slides' => $_slides, 'static_slide' => $_static_slide);

			if(empty($slide_ids)){
				$rs7output	= new RevSlider7Output();
				$rs7output->slider = $slider;
				$rs7output->set_slider_id($slider->get_id());
				$rs7output->slides = $slides;
				$rs7output->set_javascript_variables();
				$obj['navs']	= (object)array_filter($this->get_val($SR_GLOBALS, array('collections', 'nav'), array()), function($value) { return !empty($value); });
				$obj['trans']	= (object)array_filter($this->get_val($SR_GLOBALS, array('collections', 'trans'), array()), function($value) { return !empty($value); });
				$obj['v6v7ids']	= (object)$this->get_v7_slider_map($slider_id);
			}else{ //set modify -> false as we do not have slider_settings
				$modify = false;
			}
		}

		if($modify === true && isset($obj[$modify_setting]['source'])){ //make sure to have the source overwritten for streams, if we are not in backend
			$source = $obj[$modify_setting]['source'];
			$obj[$modify_setting]['source'] = array('type' => $this->get_val($obj, array($modify_setting, 'source', 'type')));
			foreach($modify_sources as $m_source){
				if(!isset($source[$m_source])) continue;
				foreach($modify_allow as $allow){
					if(!isset($source[$m_source][$allow])) continue;

					$obj[$modify_setting]['source'][$m_source][$allow] = $source[$m_source][$allow];
				}
			}
		}
		
		$obj['addOns'] = array();
		
		return apply_filters('sr_get_full_slider_JSON', $obj, $slider);
	}

	/**
	 * get the thumb url for the slide (navigation may need it)
	 **/
	public function get_thumb_url($slide, $post_id = false){
		$bullet_set		= ($this->v7) ? $this->get_param(array('nav', 'bullets', 'set'), false) : $this->get_param(array('nav', 'bullets', 'set'), false);
		$thumbs_set		= ($this->v7) ? $this->get_param(array('nav', 'thumbs', 'set'), false) : $this->get_param(array('nav', 'thumbs', 'set'), false);
		$arrows_set		= ($this->v7) ? $this->get_param(array('nav', 'arrows', 'set'), false) : $this->get_param(array('nav', 'arrows', 'set'), false);
		$tabs_set		= ($this->v7) ? $this->get_param(array('nav', 'tabs', 'set'), false) : $this->get_param(array('nav', 'tabs', 'set'), false);
		$scrubber_set	= ($this->v7) ? $this->get_param(array('nav', 'scrubber', 'set'), false) : $this->get_param(array('nav', 'scrubber', 'set'), false);
		$arrows_style	= ($this->v7) ? $this->get_param(array('nav', 'arrows', 't'), 'round') : $this->get_param(array('nav', 'arrows', 'style'), 'round');
		$bullets_style	= ($this->v7) ? $this->get_param(array('nav', 'bullets', 't'), 'round') : $this->get_param(array('nav', 'bullets', 'style'), 'round');
		$bglayer		= ($this->v7) ? $slide->get_bg_layer() : array();
		$is_posts		= $this->is_posts();
		$active			= ($bullet_set == true || $thumbs_set == true || $arrows_set == true || $tabs_set == true || $scrubber_set == true) ? true : false;
		$special		= (
			in_array($arrows_style, array('preview1', 'preview2', 'preview3', 'preview4', 'custom'), true) ||
			in_array($bullets_style, array('preview1', 'preview2', 'preview3', 'preview4', 'custom'), true)
		) ? true : false;

		if($active === false && $special === false) return '';
		
		if($is_posts && $post_id !== false){
			$thumb_src = wp_get_attachment_image_src($post_id, 'orig');
			$slide->image_url = ($thumb_src !== false) ? $thumb_src[0] : '';
		}else{
			$thumb_src	= ($this->v7) ? $slide->get_param(array('thumb', 'src'), '') : $slide->get_param(array('thumb', 'customThumbSrc'), '');
			$slide->image_url = (!empty($thumb_src)) ? $thumb_src : '';
		}
		if(empty($slide->image_url)){
			$slide->image_url = ($this->v7) ? $this->get_val($bglayer, array('bg', 'image', 'src'), '') :  $slide->get_param(array('bg', 'image'), '');
		}
		$slide->image_url = (empty($slide->image_url) && $this->v7) ? $this->get_val($bglayer, array('bg', 'video', 'poster', 'src'), '') : $slide->image_url;

		if($arrows_set === true && in_array(intval($arrows_style), array(1012))) return $slide->image_url; //check if we are dione and if, then return full image // or custom 

		$bg_stream		= ($this->v7) ? $slide->get_param(array('bg', 'image', 'fromStream'), false) : $slide->get_param(array('bg', 'imageFromStream'), false);
		$source_type	= ($this->v7) ? $this->get_param(array('source', 'type'), 'gallery') : $this->get_param('sourcetype');
		$dimension		= $slide->get_param(array('thumb', 'dimension'), 'slider');
		$url			= ($is_posts && $bg_stream === true) ? '' : $slide->image_url;
		if($this->v7){
			$slide_bg = 'trans';
			if(!empty($this->get_val($bglayer, array('bg', 'image'), array()))) $slide_bg = 'image';
			if(!empty($this->get_val($bglayer, array('bg', 'video'), array()))) $slide_bg = 'video';
		}else{
			$slide_bg = $slide->get_param(array('bg', 'type'), 'trans');
		}

		if(
			$dimension == 'slider' &&
			($is_posts ||
			in_array($source_type, array('youtube', 'vimeo'), true) || 
			in_array($slide_bg, array('image', 'video', 'vimeo', 'youtube', 'html5', 'streamvimeo', 'streamyoutube', 'streaminstagram', 'streamvimeoboth', 'streamyoutubeboth', 'streaminstagramboth'), true))
		){ //use the slider settings for width / height
			$w = ($this->v7) ? intval(str_replace('px', '', $this->get_param(array('nav', 'p', 'w'), 100))) : intval($this->get_param(array('nav', 'preview', 'width'), $this->get_param(array('nav', 'thumbs', 'width'), 100)));
			$h = ($this->v7) ? intval(str_replace('px', '', $this->get_param(array('nav', 'p', 'h'), 50))) : intval($this->get_param(array('nav', 'preview', 'height'), $this->get_param(array('nav', 'thumbs', 'height'), 50)));

			$w = ($w == 0) ? 100 : $w;
			$h = ($h == 0) ? 50 : $h;

			if(empty($url)){ //try to get resized thumb
				$url = rev_aq_resize($slide->image_url, $w, $h, true, true, true);
			}else{
				$url = rev_aq_resize($url, $w, $h, true, true, true);
				if(empty($url)){
					$url = $slide->image_url;
					$url = rev_aq_resize($url, $w, $h, true, true, true);
				}
			}
		}
		
		$url = (empty($url)) ? $slide->image_url : $url; //if empty - put regular image

		return ($this->check_valid_image($url)) ? $url : '';
	}

	/**
	 * return the responsive sizes depending on v6 or v7
	 */
	public function get_responsive_sizes(){
		if($this->v7){
			$sizes = $this->get_param('uSize');
			$enabled_sizes = array(
				'ld' => $this->get_val($sizes, 0, false),
				'd' => $this->get_val($sizes, 1, false),
				'n' => $this->get_val($sizes, 2, false),
				't' => $this->get_val($sizes, 3, false),
				'm' => $this->get_val($sizes, 4, false)
			);
			if(in_array(true, $enabled_sizes) === false) $enabled_sizes['d'] = true;

			return $enabled_sizes;
		}

		return array(
			'ld' => true,
			'd' => true,
			'n' => $this->get_param(array('size', 'custom', 'n'), false),
			't' => $this->get_param(array('size', 'custom', 't'), false),
			'm' => $this->get_param(array('size', 'custom', 'm'), false)
		);
	}
}
