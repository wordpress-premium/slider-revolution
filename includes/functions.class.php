<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderFunctions extends RevSliderData {
	
	public function __construct(){
	}
	
	/**
	 * START: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * old version of get_val();
	 * added for compatibility with old AddOns
	 **/
	public static function getVal($arr, $key, $default = ''){
		//echo 'Slider Revolution Notice: Please do not use RevSliderFunctions::getVal() anymore, use $f->get_val()'."\n";
		$f = new RevSliderFunctions();
		return $f->get_val($arr, $key, $default);
	}
	
	/**
	 * old version of class_to_array_single();
	 * added for compatibility with old AddOns
	 **/
	public static function cleanStdClassToArray($arr){
		$f = new RevSliderFunctions();
		return $f->class_to_array_single($arr);
	}
	
	/**
	 * END: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	
	
	/**
	 * Get Global Settings
	 * @before: RevSliderOperations::getGeneralSettingsValues()
	 **/
	public function get_global_settings(){
		$gs = get_option('revslider-global-settings', '');
		if(!is_array($gs)){
			$gs = json_decode($gs, true);
		}
		
		return apply_filters('rs_get_global_settings', $gs);
	}
	
	/**
	 * update general settings
	 * @before: RevSliderOperations::updateGeneralSettings()
	 */
	public function set_global_settings($global){
		$global = json_encode($global);
		
		return update_option('revslider-global-settings', $global);
	}
	
	
	/**
	 * throw an error
	 * @before: RevSliderFunctions::throwError()
	 **/
	public function throw_error($message, $code = null){
		if(!empty($code)){
			throw new Exception($message, $code);
		}else{
			throw new Exception($message);
		}
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
	 * get value from array. if not - return alternative
	 * before: RevSliderFunctions::get_val();
	 */
	public function get_val($arr, $key, $default = ''){
		$arr = (array)$arr;	
		
		if(is_array($key)){
			$a = $arr;
			foreach($key as $k => $v){
				$a = $this->get_val($a, $v, $default);				
			}
			return $a;
			/*$val = $default;
			foreach($key as $k => $v){
				$val = (array)$val;
				$val = (isset($val[$v])) ? $val[$v] : $default;
			}*/
		}else{						
			$val = (isset($arr[$key])) ? $arr[$key] : $default;			 		
		}
		return $val;
	}

	
	/**
	 * set parameter
	 * @since: 6.0
	 */
	public function set_val(&$base, $name, $value){
		if(is_array($name)){
			foreach($name as $key){
				if(is_array($base)){
					if(!isset($base[$key])) $base[$key] = array();
					$base = &$base[$key];
				}elseif(is_object($base)){
					if(!isset($base->$key)) $base->$key = new stdClass();
					$base = &$base->$key;
				}
			}
			$base = $value;
		}else{
			$base[$name] = $value;
		}
		//no return required, as the base is given with &$base
		//return $base;
	}
	
	
	/**
	 * get POST variable
	 * before: RevSliderBase::getPostVar();
	 */
	public function get_post_var($key, $default = ''){
		$val = $this->get_var($_POST, $key, $default);
		
		return $val;			
	}
	
	
	/**
	 * get GET variable
	 * before: RevSliderBase::getGetVar();
	 */
	public function get_get_var($key, $default = ''){
		$val = $this->get_var($_GET, $key, $default);
		
		return $val;
	}
	
	
	/**
	 * get POST or GET variable in this order
	 * before: RevSliderBase::getPostGetVar();
	 */
	public function get_request_var($key, $default = ''){
		$val = (array_key_exists($key, $_POST)) ? $this->get_var($_POST, $key, $default) : $this->get_var($_GET, $key, $default);
		
		return $val;
	}
	
	
	/**
	 * get a variable from an array,
	 * before: RevSliderBase::getVar()
	 */
	public function get_var($arr, $key, $default = ''){
		$val = (isset($arr[$key])) ? $arr[$key] : $default;
		
		return $val;
	}
	
	
	/**
	 * check for true and false in all possible ways
	 * @since: 6.0
	 **/
	public function _truefalse($v){
		if($v === 'false' || $v === false || $v === 'off' || $v ===	NULL || $v === 0 || $v === -1){
			$v = false;
		}elseif($v === 'true' || $v === true || $v === 'on'){
			$v = true;
		}
		
		return $v;
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
	 * validate that some value is numeric
	 * before: RevSliderFunctions::validateNumeric
	 */
	public function validate_numeric($val, $fn = 'Field'){
		$this->validate_not_empty($val, $fn);
		
		if(!is_numeric($val))
			$this->throw_error($fn.__(' should be numeric', 'revslider'));
	}
	
	
	/**
	 * validate that some variable not empty
	 * before: RevSliderFunctions::validateNotEmpty
	 */
	public function validate_not_empty($val, $fn = 'Field'){
		if(empty($val) && is_numeric($val) == false)
			$this->throw_error($fn.__(' should not be empty', 'revslider'));
	}
	
	
	
	/**
	 * encode array into json for client side
	 * @before: RevSliderFunctions::jsonEncodeForClientSide()
	 */
	public function json_encode_client_side($arr){
		$json = '';
		
		if(!empty($arr)){
			$json = json_encode($arr);
			$json = addslashes($json);
		}

		$json = (empty($json)) ? '{}' : "'".$json."'";
		
		return $json;
	}
	
	
	/**
	 * turn a string into an array, check also for slashes!
	 * @since: 6.0
	 */
	public function json_decode_slashes($data){
		if(gettype($data) == 'string'){
			$data_decoded = json_decode(stripslashes($data), true);
			if(empty($data_decoded))
				$data_decoded = json_decode($data, true);
			
			$data = $data_decoded;
		}
		
		return $data;
	}
	
	
	/**
	 * convert assoc array to array
	 * @before: RevSliderFunctions::assocToArray();
	 */
	public static function assoc_to_array($assoc){
		$arr = array();
		foreach($assoc as $item)
			$arr[] = $item;
		
		return $arr;
	}
	
	
	/**
	 * Convert std class to array, with all sons
	 * before: RevSliderFunctions::convertStdClassToArray();
	 */
	public function class_to_array($arr){
		$arr = (array)$arr;
		$new = array();
		
		if(!empty($arr)){
			foreach($arr as $key => $item){
				$new[$key]	= (array)$item;
			}
		}else{
			$new = $arr;
		}
		
		return $new;
	}
	
	
	/**
	 * Convert std class to array, single
	 * before: RevSliderFunctions::cleanStdClassToArray();
	 */
	public function class_to_array_single($arr){
		$arr = (array)$arr;
		$new = array();
		
		foreach($arr as $key => $item){
			$new[$key] = $item;
		}
		
		return $new;
	}
	
	/**
	 * Check Array for Value Recursive
	 */
	public function in_array_r($needle, $haystack, $strict = false){
		if(is_array($haystack) && !empty($haystack)){
			foreach($haystack as $item){
				if(($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))){
					return true;
				}
			}
		}
	
		return false;
	}
	
	/**
	 * get attachment image url
	 * before: RevSliderFunctionsWP::getUrlAttachmentImage();
	 */
	public function get_url_attachment_image($id, $size = 'full'){
		$image	= wp_get_attachment_image_src($id, $size);
		$url	= (empty($image)) ? false : $this->get_val($image, 0);
		if($url === false){
			$url = wp_get_attachment_url($id);
		}
		
		return $url;
	}
	
	
	/**
	 * retrieve the image id from the given image url
	 * before: RevSliderFunctionsWP::get_image_id_by_url();
	 */
	public function get_image_id_by_url($image_url){
		global $wpdb;
		
		$attachment_id = false;
		
		if($image_url !== ''){
			$attachment_id = (function_exists('attachment_url_to_postid')) ? attachment_url_to_postid($image_url) : 0;
			//for WP < 4.0.0
			if(0 == $attachment_id){ //get it the old school way
				$upload_dir_paths = wp_upload_dir();
				
				// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
				if(false !== strpos($image_url, $upload_dir_paths['baseurl'])){
					$image_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_url);
					$image_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $image_url);
					$attachment_id = $wpdb->get_var($wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $image_url));
				}else{
					$attachment_id = false;
				}
			}
		}
		
		return (is_null($attachment_id)) ? false : $attachment_id;
	}
	
	
	/**
	 * get image url from image path.
	 * @before: RevSliderFunctionsWP::getImageUrlFromPath();
	 */
	public function get_image_url_from_path($path){
		if(empty($path)) return '';
		
		//check if the path ends with /, if yes its not a correct image path
		$lc = substr($path, -1);
		if(in_array($lc, array('/', '\\'))) return '';
		
		//protect from absolute url
		$lower = strtolower($path);
		$return = (strpos($lower, 'http://') !== false || strpos($lower, 'https://') !== false || strpos($lower, 'www.') === 0) ? $path : $this->get_base_url().$path;
		
		return ($return !== $this->get_base_url()) ? $return : '';
	}
	
	
	/**
	 * get image relative path from image url (from upload)
	 * before: RevSliderFunctionsWP::getImagePathFromURL()
	 */
	public function get_image_path_from_url($url){
		$path = str_replace($this->get_base_url(), '', $url);
		
		return $path;
	}
	
	/**
	 * Check if Path is a Valid Image File	 	
	 **/	 
	public function check_valid_image($url){		
		$pos = strrpos($url, '.', -1);
	    if($pos === false) return false;
	    $ext = strtolower(substr($url, $pos));
	    $img_exts = array('.gif', '.jpg', '.jpeg', '.png');
	    if(in_array($ext, $img_exts)) return $url;
		
	    return false;
	}
	
	/**
	 * get the upload URL of images
	 * before: RevSliderFunctionsWP::getUrlUploads()
	 */
	public static function get_base_url(){
		if(is_multisite() == false){ //without multisite
			$url = content_url().'/';
		}else{	//for multisite
			$upload_dir	= wp_upload_dir();
			$url = $upload_dir['baseurl'].'/';
		}
		
		return $url;
	}
	
	
	/**
	 * get wp-content path
	 * before: RevSliderFunctionsWP::getPathContent()
	 */
	public function get_content_path(){
		if(is_multisite()){
			$path = (!defined('BLOGUPLOADDIR')) ? ABSPATH.'wp-content/' : BLOGUPLOADDIR;
		}else{
			$path = (!defined('WP_CONTENT_DIR')) ? WP_CONTENT_DIR.'/' : ABSPATH.'wp-content/'; //FIX FOR PHP5
			//$path = (!empty(WP_CONTENT_DIR)) ? WP_CONTENT_DIR.'/' : ABSPATH.'wp-content/';
		}
		
		return $path;
	}
	
	
	/**
	 * strip slashes recursive
	 * @since: 5.0
	 * before: RevSliderBase::stripslashes_deep()
	 */
	public static function stripslashes_deep($value){
		$value = is_array($value) ? array_map(array('RevSliderFunctions', 'stripslashes_deep'), $value) : stripslashes($value);
		
		return $value;
	}
	
	/**
	 * esc attr recursive
	 * @since: 6.0
	 */
	public static function esc_attr_deep($value){
		$value = is_array($value) ? array_map(array('RevSliderFunctions', 'esc_attr_deep'), $value) : esc_attr($value);
		
		return $value;
	}
	
	/**
	 * esc attr recursive
	 * @since: 6.0
	 */
	public static function esc_js_deep($value){
		$value = is_array($value) ? array_map(array('RevSliderFunctions', 'esc_js_deep'), $value) : esc_js($value);
		
		return $value;
	}
	
	
	/**
	 * get post types with categories for client side.
	 * before: RevSliderOperations::getPostTypesWithCatsForClient();
	 */
	public function get_post_types_with_categories_for_client(){
		$post_types		= $this->get_post_types_with_categories();
		$globalCounter	= 0;
		$arrOutput		= array();
		foreach($post_types as $postType => $arrTaxWithCats){

			$arrCats = array();
			foreach($arrTaxWithCats as $tax){
				$taxName	= $tax['name'];
				$taxTitle	= $tax['title'];
				$globalCounter++;
				$arrCats['option_disabled_'.$globalCounter] = '---- '.$taxTitle.' ----';
				foreach($tax['cats'] as $catID=>$catTitle){
					$arrCats[$taxName.'_'.$catID] = $catTitle;
				}
			}//loop tax

			$arrOutput[$postType] = $arrCats;

		}//loop types
		
		return $arrOutput;
	}
	
	
	/**
	 * get post types array with taxomonies
	 * before: RevSliderFunctionsWP::getPostTypesWithTaxomonies()
	 */
	public function get_post_types_with_taxonomies(){
		$post_types = $this->get_post_type_assoc();
		
		foreach($post_types as $post_type => $title){
			$post_types[$post_type]	= $this->get_post_type_taxonomies($post_type);
		}
		
		return $post_types;
	}
	
	
	/**
	 * 
	 * get array of post types with categories (the taxonomies is between).
	 * get only those taxomonies that have some categories in it.
	 * before: RevSliderFunctionsWP::getPostTypesWithCats()
	 */
	public function get_post_types_with_categories(){
		$post_types_categories	= array();
		$post_types				= $this->get_post_types_with_taxonomies();
		
		foreach($post_types as $name => $tax){
			$ptwc = array();
			if(!empty($tax)){
				foreach($tax as $tax_name => $tax_title){
					$cats = $this->get_categories_assoc($tax_name);
					if(!empty($cats)){
						$ptwc[] = array(
							'name'	=> $tax_name,
							'title'	=> $tax_title,
							'cats'	=> $cats
						);
					}
				}
			}
			$post_types_categories[$name] = $ptwc;
		}
		
		return $post_types_categories;
	}
	
	
	/**
	 * get all the post types including custom ones
	 * the put to top items will be always in top (they must be in the list)
	 * before: RevSliderFunctionsWP::getPostTypesAssoc()
	 */
	public function get_post_type_assoc($put_to_top = array()){
		$build_in		= array('post' => 'post', 'page'=>'page');
		$custom_types	= get_post_types(array('_builtin' => false));
		
		//top items validation - add only items that in the customtypes list
		$top_updated	= array();
		foreach($put_to_top as $top){
			if(in_array($top, $custom_types) == true){
				$top_updated[$top] = $top;
				unset($custom_types[$top]);
			}
		}
		
		$post_types = array_merge($top_updated, $build_in, $custom_types);
		
		//update label
		foreach($post_types as $key => $type){
			$post_types[$key] = $this->get_post_type_title($type);
		}
		
		return $post_types;
	}
	
	
	/**
	 * return post type title from the post type
	 * before: RevSliderFunctionsWP::getPostTypeTitle()
	 */
	public static function get_post_type_title($post_type){
		$obj_type	= get_post_type_object($post_type);
		$title		= (empty($obj_type)) ? ($post_type) : $obj_type->labels->singular_name;
		
		return $title;
	}
	
	
	/**
	 * get post type taxomonies
	 * before: RevSliderFunctionsWP::getPostTypeTaxomonies()
	 */
	public function get_post_type_taxonomies($post_type){
		$names	= array();
		$tax	= get_object_taxonomies(array('post_type' => $post_type), 'objects');

		if(!empty($tax)){
			foreach($tax as $obj_tax){
				if($post_type === 'product' && !in_array($obj_tax->name, array('product_cat', 'product_tag'))) continue;
				$names[$obj_tax->name] = $obj_tax->labels->name;
			}
		}
		
		return $names;
	}
	
	
	/**
	 * get post categories list assoc - id / title
	 * before: RevSliderFunctionsWP::getCategoriesAssoc()
	 */
	public function get_categories_assoc($taxonomy = 'category'){
		$categories	= array();
		if(strpos($taxonomy, ',') !== false){
			$taxes		= explode(',', $taxonomy);
			foreach($taxes as $tax){
				$cats		= $this->get_categories_assoc($tax);
				$categories	= array_merge($categories, $cats);
			}
		}else{
			$args = array('taxonomy' => $taxonomy);
			$cats = get_categories($args);
			foreach($cats as $cat){
				$num				= $cat->count;
				$id					= $cat->cat_ID;
				$name				= ($num == 1) ? 'item' : 'items';
				$title				= $cat->name . ' ('.$num.' '.$name.')';
				$categories[$id]	= $title;
			}
		}
		
		return $categories;
	}
	
	
	/**
	 * check if css string is rgb
	 * @before: RevSliderFunctions::isrgb()
	 **/
	public function is_rgb($rgba){
		return (strpos($rgba, 'rgb') !== false) ? true : false;
	}
	
	
	/**
	 * change rgba to hex
	 * @since: 5.0
	 */
	public function rgba2hex($rgba){
		if(strtolower($rgba) == 'transparent') return $rgba;
		
		$temp = explode(',', $rgba);
		$rgb = array();
		if(count($temp) == 4) unset($temp[3]);
		foreach($temp as $val){
			$t = dechex(preg_replace('/[^\d.]/', '', $val));
			if(strlen($t) < 2) $t = '0'.$t;
			$rgb[] = $t;
		}
		
		return '#'.implode('', $rgb);
	}
	
	
	/**
	 * get transparency from rgba
	 * @since: 5.0
	 */
	public function get_trans_from_rgba($rgba, $in_percent = false){
		if(strtolower($rgba) == 'transparent') return 100;
		
		$temp = explode(',', $rgba);
		if(count($temp) == 4){
			return ($in_percent) ? preg_replace('/[^\d.]/', '', $temp[3]) : preg_replace('/[^\d.]/', "", $temp[3]) * 100;
		}
		
		return 100;
	}
	
	
	/**
	 * check if file is in zip
	 * @since: 5.0
	 */
	public function check_file_in_zip($d_path, $image, $alias, &$alreadyImported, $add_path = false){
		global $wp_filesystem;
		
		if(trim($image) !== ''){
			if(strpos($image, 'http') !== false){
				//dont change, as it is an external image
			}else{
				$strip	= false;
				$zimage	= $wp_filesystem->exists($d_path.'images/'.$image);
				if(!$zimage){
					$zimage	= $wp_filesystem->exists(str_replace('//', '/', $d_path.'images/'.$image));
					$strip	= true;
				}
				
				if(!$zimage){
				}else{
					if(!isset($alreadyImported['images/'.$image])){
						//check if we are object folder, if yes, do not import into media library but add it to the object folder
						$uimg = ($strip == true) ? str_replace('//', '/', 'images/'.$image) : $image; //pclzip
						
						$object_library = (strpos($uimg, 'revslider/objects/') === 0) ? true : false;
						
						if($object_library === true){ //copy the image to the objects folder if false
							$objlib = new RevSliderObjectLibrary();
							$importImage = $objlib->_import_object($d_path.'images/'.$uimg);
						}else{
							$importImage = $this->import_media($d_path.'images/'.$uimg, $alias.'/');
						}
						
						if($importImage !== false){
							$alreadyImported['images/'.$image] = $importImage['path'];
							
							$image = $importImage['path'];
						}
					}else{
						$image = $alreadyImported['images/'.$image];
					}
				}
				if($add_path){
					$upload_dir	= wp_upload_dir();
					$cont_url	= $upload_dir['baseurl'];
					$image		= str_replace('uploads/uploads/', 'uploads/', $cont_url . '/' . $image);
				}
			}
		}
		
		return $image;
	}
	
	
	/**
	 * Import media from url
	 * @param string $file_url URL of the existing file from the original site
	 * @param int $folder_name The slidername will be used as folder name in import
	 * @return boolean True on success, false on failure
	 */
	public function import_media($file_url, $folder_name){
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		
		$ul_dir	 = wp_upload_dir();
		$art_dir = 'revslider/';
		$return	 = false;
		
		//if the directory doesn't exist, create it	
		if(!file_exists($ul_dir['basedir'].'/'.$art_dir)) mkdir($ul_dir['basedir'].'/'.$art_dir);
		if(!file_exists($ul_dir['basedir'].'/'.$art_dir.$folder_name)) mkdir($ul_dir['basedir'].'/'.$art_dir.$folder_name);
		
		//rename the file... alternatively, you could explode on "/" and keep the original file name
		$filename = basename($file_url);
		
		$s_dir = str_replace('//', '/', $art_dir.$folder_name.$filename);
		
		if(@fclose(@fopen($file_url, 'r'))){ //make sure the file actually exists
			$save_dir	= $ul_dir['basedir'].'/'.$s_dir;
			$atc_id		= $this->get_image_id_by_url($s_dir);
			
			/**
			 * check if the files have matching md5, if not change the filename
			 * change save_dir so that the file is not
			 **/
			if($atc_id !== false && $atc_id !== NULL){
				if(!is_file($ul_dir['basedir'].'/'.$s_dir) || md5_file($file_url) !== md5_file($ul_dir['basedir'].'/'.$s_dir)){
					$file = explode('.', $filename);
					$nr = 1;
					while(1 === 1){
						$s_dir_2 = $art_dir.$folder_name.$file[0].$nr.'.'.$file[1];
						$save_dir = $ul_dir['basedir'].'/'.$s_dir_2;
						if(is_file($save_dir)){
							if(md5_file($file_url) === md5_file($save_dir)){
								$atc_id = $this->get_image_id_by_url($s_dir_2);
								break;
							}
						}else{
							break;
						}
						
						$nr++;
					}
					
					$atc_id = $this->get_image_id_by_url($s_dir_2);
					$filename = $file[0].$nr.'.'.$file[1];
				}
			}
			//we might have a new $filename here, so do again
			$s_dir = str_replace('//', '/', $art_dir.$folder_name.$filename);
			
			if($atc_id == false || $atc_id == NULL){
				copy($file_url, $save_dir);
				
				$file_info = getimagesize($save_dir);
				
				$artdata = array( //create an array of attachment data to insert into wp_posts table
					'post_author'	 => 1, 
					'post_date'		 => current_time('mysql'),
					'post_date_gmt'	 => current_time('mysql'),
					'post_title'	 => $filename, 
					'post_status'	 => 'inherit',
					'comment_status' => 'closed',
					'ping_status'	 => 'closed',
					'post_name'		 => sanitize_title_with_dashes(str_replace('_', '-', $filename)),
					'post_modified'	 => current_time('mysql'),
					'post_modified_gmt' => current_time('mysql'),
					'post_parent'	 => '',
					'post_type'		 => 'attachment',
					'guid'			 => $ul_dir['baseurl'].'/'.$s_dir,
					'post_mime_type' => $file_info['mime'],
					'post_excerpt'	 => '',
					'post_content'	 => ''
				);
				//insert the database record
				$attach_id = wp_insert_attachment($artdata, $s_dir);
				
				//generate metadata and thumbnails
				add_filter('intermediate_image_sizes_advanced', array('RevSliderFunctions', 'temporary_remove_sizes'), 10, 2);
				
				$rs_meta_create = get_option('rs_image_meta_todo', array());
				if(!isset($rs_meta_create[$attach_id])){
					$rs_meta_create[$attach_id] = $save_dir;
					update_option('rs_image_meta_todo', $rs_meta_create);
				}
				if($attach_data = wp_generate_attachment_metadata($attach_id, $save_dir)){
					wp_update_attachment_metadata($attach_id, $attach_data);
				}
			}else{
				$attach_id = $atc_id;
			}
			
			$art_dir = (!is_multisite()) ? 'uploads/'.$art_dir : $art_dir;
			$s_dir = str_replace('//', '/', $art_dir.$folder_name.$filename);
			
			$return	 = array('id' => $attach_id, 'path' => $s_dir);
		}
		
		return $return;
	}
	
	
	/**
	 * generate missing attachement metadata for images
	 * @since: 6.0
	 **/
	public function generate_attachment_metadata(){
		$rs_meta_create = get_option('rs_image_meta_todo', array());
		if(!empty($rs_meta_create)){
			foreach($rs_meta_create as $attach_id => $save_dir){
				if($attach_data = wp_generate_attachment_metadata($attach_id, $save_dir)){
					wp_update_attachment_metadata($attach_id, $attach_data);
				}
				unset($rs_meta_create[$attach_id]);
				
				update_option('rs_image_meta_todo', $rs_meta_create);
			}
		}
	}
	
	
	/**
	 * temporary remove image sizes so that only the needed thumb will be created
	 * @since: 6.0
	 **/
	public static function temporary_remove_sizes($sizes, $meta = false){
		foreach($sizes as $size => $values){
			if($size == 'thumbnail'){
				return array($size => $values);
			}
		}
		return $sizes;
	}
	
	
	/**
	 * explodes google fonts and returns the number of font weights of all fonts
	 * before: RevSliderBase::get_font_weight_count();
	 * @since: 5.0
	 **/
	public function get_font_weight_count($string){
		$string	= explode(':', $string);
		$nums	= 0;

		if(count($string) >= 2){
			$string = $string[1];
			if(strpos($string, '&') !== false){
				$string = explode('&', $string);
				$string = $string[0];
			}
			
			$nums = count(explode(',', $string));
		}
		
		return $nums;
	}
	
	
	/**
	 * get contents of the css table
	 * @before: RevSliderOperations::getCaptionsContentArray();
	 */
	public function get_captions_content($handle = false){
		$css = new RevSliderCssParser();
		$this->fill_css();
		
		return $css->db_array_to_array($this->css, $handle);
	}
	
	
	/**
	 * get animation params by id
	 * @before: RevSliderOperations::getFullCustomAnimationByID()
	 */
	public function get_custom_animation_by_id($id){
		$this->fill_animations();
		
		foreach($this->animations as $animation){
			if($animation['id'] == $id){
				return array(
					'id'	 => $animation['id'],
					'handle' => $animation['handle'],
					'params' => json_decode(str_replace("'", '"', $this->get_val($animation, 'params', array())), true),
					'settings' => $animation['settings']
				);
			}
		}
		
		return false;
	}
	
	
	/**
	 * get wp-content path
	 * @before: RevSliderFunctionsWP::getPathUploads()
	 */
	public function get_upload_path(){
		if(is_multisite()){
			global $wpdb;
			$path = (!defined('BLOGUPLOADDIR')) ? ABSPATH . 'wp-content/uploads/sites/' . $wpdb->blogid : BLOGUPLOADDIR;
		}else{
			$wp_dir = WP_CONTENT_DIR;
			$path = (!empty($wp_dir)) ? WP_CONTENT_DIR . '/' : ABSPATH . 'wp-content/uploads/';
		}
		
		return $path;
	}
	
	
	/**
	 * get contents of the static css file
	 * @before: RevSliderOperations::getStaticCss()
	 */
	public function get_static_css(){
		if(!get_option('revslider-static-css')){
			if(file_exists(RS_PLUGIN_PATH . 'public/assets/css/static-captions.css')){
				$css = @file_get_contents(RS_PLUGIN_PATH . 'public/assets/css/static-captions.css');
				$this->update_static_css($css);
			}
		}
		
		return get_option('revslider-static-css', '');
	}
	
	
	/**
	 * get contents of the static css file
	 * @before: RevSliderOperations::updateStaticCss()
	 */
	public function update_static_css($content){
		$content = str_replace(array("\'", '\"', '\\\\'),array("'", '"', '\\'), trim($content));
		
		update_option('revslider-static-css', $content, 'off');

		return $content;
	}
	
	
	/**
	 * set the font clean for import
	 * @before: RevSliderOperations::setCleanFontImport()
	 */
	public function set_clean_font_import($font, $class = '', $url = '', $variants = array(), $subsets = array()){
		global $revslider_fonts;
		
		if(!isset($revslider_fonts)) $revslider_fonts = array('queue' => array(), 'loaded' => array()); //if this is called without revslider.php beeing loaded
		
		if(!empty($variants) || !empty($subsets)){
			if(!isset($revslider_fonts['queue'][$font])) $revslider_fonts['queue'][$font] = array();
			if(!isset($revslider_fonts['queue'][$font]['variants'])) $revslider_fonts['queue'][$font]['variants'] = array();
			if(!isset($revslider_fonts['queue'][$font]['subsets'])) $revslider_fonts['queue'][$font]['subsets'] = array();
			
			if(!empty($variants)){
				foreach($variants as $k => $v){
					//check if the variant is already in loaded
					if(!in_array($v, $revslider_fonts['queue'][$font]['variants'], true)){
						$revslider_fonts['queue'][$font]['variants'][] = $v;
					}else{ //already included somewhere, so do not call it anymore
						unset($variants[$k]);
					}
				}
			}
			if(!empty($subsets)){
				foreach($subsets as $k => $v){
					if(!in_array($v, $revslider_fonts['queue'][$font]['subsets'], true)){
						$revslider_fonts['queue'][$font]['subsets'][] = $v;
					}else{ //already included somewhere, so do not call it anymore
						unset($subsets[$k]);
					}
				}
			}
		}
	}
	
	
	/**
	 * print html font import
	 * @before: RevSliderOperations::printCleanFontImport()
	 */
	public function print_clean_font_import(){
		global $revslider_fonts;
		
		$font_first	= true;
		$ret	= '';
		$tcf	= '';
		$tcf2	= '';
		$fonts	= array();
		
		$gs = $this->get_global_settings();
		$fdl = $this->get_val($gs, 'fontdownload', 'off');
		
		if($fdl === 'disable') return $ret;
		
		if(!empty($revslider_fonts['queue'])){
			foreach($revslider_fonts['queue'] as $f_n => $f_s){
				if($f_n !== ''){
					$_variants = $this->get_val($f_s, 'variants', array());
					$_subsets = $this->get_val($f_s, 'subsets', array());
					if(!empty($_variants) || !empty($_subsets)){
						if(!isset($revslider_fonts['loaded'][$f_n])) $revslider_fonts['loaded'][$f_n] = array();
						if(!isset($revslider_fonts['loaded'][$f_n]['variants'])) $revslider_fonts['loaded'][$f_n]['variants'] = array();
						if(!isset($revslider_fonts['loaded'][$f_n]['subsets'])) $revslider_fonts['loaded'][$f_n]['subsets'] = array();
						
						if(strpos($f_n, 'href=') === false){
							$t_tcf = '';
							
							if($font_first == false) $t_tcf .= '%7C'; //'|';
							$t_tcf .= urlencode($f_n).':';
							
							if(!empty($_variants)){
								$mgfirst = true;
								foreach($f_s['variants'] as $mgvk => $mgvv){
									if(in_array($mgvv, $revslider_fonts['loaded'][$f_n]['variants'], true)) continue;
									
									$revslider_fonts['loaded'][$f_n]['variants'][] = $mgvv;
									
									if(!$mgfirst) $t_tcf .= urlencode(',');
									$t_tcf .= urlencode($mgvv);
									$mgfirst = false;
								}
								
								//we did not add any variants, so dont add the font
								if($mgfirst === true) continue;
							}
							
							$fonts[$f_n] = $t_tcf; //we do not want to add the subsets
							
							if(!empty($_subsets)){
								$mgfirst = true;
								foreach($f_s['subsets'] as $ssk => $ssv){
									if(in_array($mgvv, $revslider_fonts['loaded'][$f_n]['subsets'], true)) continue;
									
									$revslider_fonts['loaded'][$f_n]['subsets'][] = $ssv;
									
									if($mgfirst) $t_tcf .= urlencode('&subset=');
									if(!$mgfirst) $t_tcf .= urlencode(',');
									$t_tcf .= urlencode($ssv);
									$mgfirst = false;
								}
							}
							
							$tcf .= $t_tcf;
						}else{
							//$f_n = $this->$this->remove_http($f_n);
							$tcf2 .= html_entity_decode(stripslashes($f_n));
							
							$fonts[$f_n] = $tcf2;
						}
					}
					$font_first = false;
				}
			}
		}
		
		if($fdl === 'preload'){
			if(!empty($fonts)){
				$upload_dir	= wp_upload_dir();
				$base_dir	= $upload_dir['basedir'];
				$base_url	= $upload_dir['baseurl'];
				$rs_google_ts = get_option('rs_google_font', 0);
				
				foreach($fonts as $key => $font){
					//check if we downloaded the font already
					$font = str_replace('%7C', '', $font);
					$font_name = preg_replace('/[^-a-z0-9 ]+/i', '', $key);
					$font_name = strtolower(str_replace(' ', '-', esc_attr($font_name)));
					
					if(!is_file($base_dir.'/revslider/gfonts/'. $font_name . '/' . $font_name . '.woff2') || filemtime($base_dir.'/revslider/gfonts/'. $font_name . '/' . $font_name . '.woff2') < $rs_google_ts){
						if(!is_dir($base_dir.'/revslider/gfonts/')){
							mkdir($base_dir.'/revslider/gfonts/');
						}
						
						if(!is_dir($base_dir.'/revslider/gfonts/'.$font_name)){
							mkdir($base_dir.'/revslider/gfonts/'.$font_name);
						}
						
						$regex_url	= "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
						$url		= 'https://fonts.googleapis.com/css?family='.$font;
						$content	= wp_remote_get($url);
						$body = $this->get_val($content, 'body', '');
						
						if(preg_match_all($regex_url, $body, $found_fonts)){
							foreach($found_fonts as $found_font){
								$found_font = $found_font[0];
								$found_font = rtrim($found_font, ')');
								
								$f_c = wp_remote_get($found_font);
								
								$f_c_body = $this->get_val($f_c, 'body', '');
								
								$file = $base_dir.'/revslider/gfonts/'. $font_name . '/' . $font_name . '.woff2';
								@mkdir(dirname($file));
								@file_put_contents($file, $f_c_body);
								
								break;
							}
						}
					}
					
					$f_raw		= explode(':', $font);
					$weights	= (!empty($f_raw) && is_array($f_raw) && isset($f_raw[1])) ? explode(',', $f_raw[1]) : array('400');
					$f_family	= str_replace('+', ' ', $f_raw[0]);
					
					if(!empty($weights) && is_array($weights)){
						$ret .= '<style type="text/css">';
						foreach($weights as $weight){
							$ret .=
"@font-face {
  font-family: '".$f_family."';
  font-style: normal;
  font-weight: ".$weight.";
  src: local('".$f_family."'), local('".$f_family."'), url(".$base_url.'/revslider/gfonts/'. $font_name . '/' . $font_name . '.woff2'.") format('woff2');
}";
						}
						$ret .= '</style>';
					}
				}
			}
			
		}else{
			$url = $this->modify_fonts_url('https://fonts.googleapis.com/css?family=');
			
			if($tcf !== ''){
				$ret .= '<link href="'.$url.$tcf.'" rel="stylesheet" property="stylesheet" type="text/css" media="all">'."\n"; //id="rev-google-font"
			}
			if($tcf2 !== ''){
				$ret .= html_entity_decode(stripslashes($tcf2));
			}
		}
		
		return apply_filters('revslider_printCleanFontImport', $ret);
	}
	
	
	/**
	 * Change FontURL to new URL (added for chinese support since google is blocked there)
	 * @since: 5.0
	 * @before: RevSliderFront::modify_punch_url()
	 */
	public function modify_fonts_url($url){
		$gs = $this->get_global_settings();
		$df = $this->get_val($gs, 'fonturl', '');
		
		return ($df !== '') ? $df : $url;
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

		foreach($posts as $key => $post){
			$posts[$key] = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
		}
		
		return $posts;
	}
	
	
	/**
	 * get recent posts
	 * @since: 5.1.1
	 * before: RevSliderSlider::getPostsFromRecent()
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
		if (!empty($startup_next_post)){
			$my_posts[] = (method_exists($startup_next_post, 'to_array')) ? $startup_next_post->to_array() : (array)$startup_next_post;
		}    
		$startup_previous_post = get_previous_post();
		if (!empty($startup_previous_post)){
			$my_posts[] =(method_exists($startup_previous_post, "to_array")) ? $startup_previous_post->to_array() : (array)$startup_previous_post;
		}
		
		return $my_posts;
	}
	
	
	/**
	 * get posts from specific posts list
	 * @before: RevSliderSlider::getPostsFromSpecificList();
	 */
	public function get_specific_posts($gal_ids = array()){
		$is_gal		= false;
		$additional	= array();
		$slider_id	= $this->get_id();
		
		if(!empty($gal_ids) && $gal_ids[0] !== ''){
			$posts	= $gal_ids;
			$posts	= apply_filters('revslider_set_posts_list_gal', $posts, $this->get_id());
			$is_gal	= true;
		}else{
			if(isset($gal_ids[0])){
				unset($gal_ids[0]);
				$posts					= implode(',', $gal_ids);
				$additional['order']	= 'none';
				$additional['orderby']	= 'post__in';
			}else {
				$posts = $this->get_param(array('source', 'post', 'list'), '');	
				$additional['order'] = $this->get_param(array('source', 'post', 'sortDirection'), 'DESC');
				$additional['orderby'] = $this->get_param(array('source', 'post', 'sortBy'), '');
			}
			$posts = apply_filters('revslider_set_posts_list', $posts, $this->get_id());
		}
		
		return $this->get_posts_by_id($posts, $slider_id, $is_gal, $additional);
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
			if(strpos($taxonomies, ',' !== false)){	//multiple taxomonies
				$taxonomies = explode(',', $taxonomies);
				foreach($taxonomies as $taxomony){
					$tax_query[] = array(
						'taxonomy'	=> $taxomony,
						'field'		=> 'id',
						'terms'		=> $cat_id
					);			
				}
			}else{		//single taxomony
				$tax_query[] = array(
					'taxonomy' => $taxonomies,
					'field' => 'id',
					'terms' => $cat_id
				);			
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
		
		$query = apply_filters('revslider_get_posts', $query, $slider_id);
		$full_posts	= new WP_Query($query);
		$posts		= $full_posts->posts;
		
		foreach($posts as $key => $post){
			$arr_post = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
			$arr_post['categories'] = $this->get_post_categories($post, $tax);
			
			$posts[$key] = $arr_post;
		}
		
		return $posts;
	}
	
	
	/**
	 * get popular posts
	 * @since: 5.1.1
	 * @before: RevSliderSlider::getPostsFromPopular();
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
		
		$args	= apply_filters('revslider_get_popular_posts', $args, $post_id);
		$posts	= get_posts($args);
		
		foreach($posts as $post){
			$my_posts[] = (method_exists($post, 'to_array')) ? $post->to_array() : (array)$post;
		}
		
		return $my_posts;
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
			foreach($article_categories as $category) { 
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
	 * convert date to the date format that the user chose.
	 * @before: RevSliderFunctionsWP::convertPostDate();
	 */
	public function convert_post_date($date, $with_time = false){
		if(!empty($date)){
			$date = ($with_time) ? date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($date)) : date_i18n(get_option('date_format'), strtotime($date));
		}
		return $date;
	}
	
	
	/**
	 * get categories list, copy the code from default wp functions
	 * @before: RevSliderFunctionsWP::getCategoriesHtmlList();
	 */
	public function get_categories_html($cat_ids, $tax = null,$post_id = ""){
		global $wp_rewrite;

		if(!empty($post_id)) return get_the_category_list( ', ', null, $post_id );
		
		$categories	= $this->get_categories_by_id($cat_ids, $tax);
		$errors		= $this->get_val($categories, 'errors');
		$list		= '';
		$rel 		= (is_object($wp_rewrite) && $wp_rewrite->using_permalinks()) ? 'rel="category tag"' : 'rel="category"';
		
		if(!empty($errors)){
			foreach($errors as $error){
				$err .= implode($error, ',');
			}
			$this->throw_error(__('retrieving categories error: '.esc_html($err)));
		}
		
		$sep = false;
		foreach($categories as $category){
			if(is_object($category)){
				$category = (array)$category;
			}
			
			$link = get_category_link($category['term_id']);
			$name = $category['name'];
			$list.= ($sep == true) ? ',' : '';
			$list.= (!empty($link)) ? '<a href="' . esc_url($link) . '" title="' . esc_attr(sprintf(__('View all posts in %s', 'revslider'), $category['name'])) .'" '. $rel .'>'. $name .'</a>' : $name;
			$sep  = true;
		}
		
		return $list;
	}
	
	
	/**
	 * get categories by id's
	 * @before: RevSliderFunctionsWP::getCategoriesByIDs();
	 */
	public function get_categories_by_id($ids, $tax = null){
		if(empty($ids)) array();
		
		$string_ids = (is_string($ids)) ? $ids : implode(',', $ids);
		$args		= array('include' => $string_ids);
		if(!empty($tax)){
			$args['taxonomy'] = (is_string($tax)) ? explode(',', $tax) : $tax;
		}
		$cats = get_categories($args);
		
		return (!empty($cats)) ? $this->class_to_array($cats) : $cats;
	}
	
	
	/**
	 * get excerpt from post id
	 * @before: RevSliderFunctionsWP::getExcerptById();
	 */
	public function get_excerpt_by_id($id, $limit = 55){

		$post	 = get_post($id);
		$excerpt = trim($post->post_excerpt);
		$excerpt = (empty($excerpt)) ? $post->post_content : $excerpt;
		$excerpt = strip_tags($excerpt, '<b><br><br/><i><strong><small>');
		$excerpt = $this->get_text_intro($excerpt, $limit);

		return apply_filters('revslider_getExcerptById', $excerpt, $post, $limit);
	}
	
	
	/**
	 * get text intro, limit by number of words
	 * @before: RevSliderFunctionsWP::getTextIntro();
	 */
	public function get_text_intro($text, $limit){
		$array = explode(' ', $text, $limit);
		
		if(count($array) >= $limit){
			array_pop($array);
			$intro = implode(' ', $array);
			$intro = trim($intro);
			$intro = (!empty($intro)) ? '...' : '';
		}else{
			$intro = $text;
		}
		
		return preg_replace('`\[[^\]]*\]`', '', $intro);
	}
	
	
	/**
	 * return biggest value of object depending on which devices are enabled
	 * @since: 5.0
	 **/
	public function get_biggest_device_setting($obj, $enabled_devices, $default = '########'){
		
		if($this->get_val($enabled_devices, 'd') === true && $this->get_val($obj, array('d', 'v')) != '') return $this->get_val($obj, array('d', 'v'));
		if($default !== '########') return $default;
		if($this->get_val($enabled_devices, 'n') === true && $this->get_val($obj, array('n', 'v')) != '') return $this->get_val($obj, array('n', 'v'));
		if($this->get_val($enabled_devices, 't') === true && $this->get_val($obj, array('t', 'v')) != '') return $this->get_val($obj, array('t', 'v'));
		if($this->get_val($enabled_devices, 'm') === true && $this->get_val($obj, array('m', 'v')) != '') return $this->get_val($obj, array('m', 'v'));
		
		return '';
	}
	
	
	/**
	 * convert string to boolean
	 * @before: RevSliderFunctions::strToBool();
	 */
	public function str_to_bool($str){
		if(is_bool($str))	 return $str;
		if(empty($str))		 return false;
		if(is_numeric($str)) return $str != 0;
		
		$str = strtolower($str);
		return ($str == 'true') ? true : false;
	}
	
	
	/**
	 * normalize object with device informations depending on what is enabled for the Slider
	 * @since: 5.0
	 **/
	public function normalize_device_settings($obj, $enabled_devices, $return = 'obj', $default = array(), $set_to_if = array(), $use = ','){ //array -> from -> to
		/*d n t m*/
		$obj = $this->fill_device_settings($obj);
		
		if(!empty($set_to_if)){
			foreach($obj as $device => $key){
				foreach($set_to_if as $from => $to){
					if(trim($this->get_val($obj, array($device, 'v'))) == $from) $obj[$device]['v'] = $to;
				}
			}
		}
		
		$_def = '########';
		if(!empty($default)){
			foreach($default as $_d){
				$_def = $_d;
				break;
			}
		}
		
		$inherit_size = $this->get_biggest_device_setting($obj, $enabled_devices, $_def);
		if($enabled_devices['d'] === true){			
			if($this->get_val($obj, array('d', 'v'), '') === ''){
				$obj['d']['v'] = ($_def !== '########') ? $_def : $inherit_size;
			}else{
				$inherit_size = $obj['d']['v'];
			}
		}else{
			$obj['d']['v'] = $inherit_size;
		}
		
		if($enabled_devices['n'] === true){
			if($this->get_val($obj, array('n', 'v'), '') === ''){
				$obj['n']['v'] = ($_def !== '########') ? $_def : $inherit_size;
			}else{
				$inherit_size = $obj['n']['v'];
			}
		}else{
			$obj['n']['v'] = $inherit_size;
		}
		
		if($enabled_devices['t'] === true){
			if($this->get_val($obj, array('t', 'v'), '') === ''){
				$obj['t']['v'] = ($_def !== '########') ? $_def : $inherit_size;
			}else{
				$inherit_size = $obj['t']['v'];
			}
		}else{
			$obj['t']['v'] = $inherit_size;
		}
		
		if($enabled_devices['m'] === true){
			if($this->get_val($obj, array('m', 'v'), '') === ''){
				$obj['m']['v'] = ($_def !== '########') ? $_def : $inherit_size;
			}else{
				$inherit_size = $obj['m']['v'];
			}
		}else{
			$obj['m']['v'] = $inherit_size;
		}
		
		switch($return){
			case 'obj':
				//order according to: desktop, notebook, tablet, mobile
				$new_obj = array();
				$new_obj['d'] = $obj['d']['v'];
				$new_obj['n'] = $obj['n']['v'];
				$new_obj['t'] = $obj['t']['v'];
				$new_obj['m'] = $obj['m']['v'];
				
				return $new_obj;
			break;
			case 'html-array':
				$html_array = '';
				if($obj['d']['v'] === $obj['n']['v'] && $obj['d']['v'] === $obj['m']['v'] && $obj['d']['v'] === $obj['t']['v']){
					$html_array = $obj['d']['v'];
				}else{
					$html_array = @$obj['d']['v'];
					$html_array .= $use.@$obj['n']['v'];
					$html_array .= $use.@$obj['t']['v'];
					$html_array .= $use.@$obj['m']['v'];
				}
				
				if(!empty($default)){

					//KRIKI CHANGE
					foreach($default as $key => $value){
						if((is_string($html_array) && $html_array == "".$value) || (!(is_string($html_array)) && $html_array == $value)){
							$html_array = '';	
							break;
						}
					}
					/* ALTE ZEUG if(in_array($html_array, $default)){
						$html_array = '';
					}*/
				}
				return $html_array;
			break;
			case 'array':
				$array = array();
				if($obj['d']['v'] === $obj['n']['v'] && $obj['d']['v'] === $obj['m']['v'] && $obj['d']['v'] === $obj['t']['v']){
					$array[$obj['d']['v']] = $obj['d']['v'];
				}else{
					$array[$obj['d']['v']] = $this->get_val($obj, array('d', 'v'));
					$array[$obj['n']['v']] = $this->get_val($obj, array('n', 'v'));
					$array[$obj['t']['v']] = $this->get_val($obj, array('t', 'v'));
					$array[$obj['m']['v']] = $this->get_val($obj, array('m', 'v'));
					if(!empty($array)){
						foreach($array as $k => $v){
							if(trim($v) === ''){
								unset($array[$k]);
							}
						}
					}
				}
				
				return $array;
			break;
		}
		
		return $obj;
	}
	
	
	/**
	 * fill object with default values
	 * @since: 6.0
	 **/
	public function fill_device_settings($obj){
		$push = array('d', 'n', 't', 'm');
		
		if(is_string($obj)){
			$t = $obj;
			$obj = array();
			foreach($push as $p){
				$obj[$p] = array('v' => $t);
			}
		}
		
		foreach($push as $p){
			if(!isset($obj[$p])){
				$obj[$p] = array();
			}
			if(!isset($obj[$p]['v'])){
				$obj[$p]['v'] = '';
				$obj[$p]['u'] = '';
			}
		}
		
		return $obj;
	}
	
	
	/**
	 * add missing px/% to value, do also for object and array
	 * @since: 5.0
	 **/
	public function add_missing_val($obj, $set_to = 'px'){
		if(is_array($obj)){
			foreach($obj as $key => $value){
				if(strpos($value, $set_to) === false){
					$obj[$key] = $value.$set_to;
				}
			}
		}elseif(is_object($obj)){
			foreach($obj as $key => $value){
				if(is_object($value)){
					if(isset($value->v)){
						if(strpos($value->v, $set_to) === false){
							$obj->$key->v = $value->v.$set_to;
						}
					}
				}else{
					if(strpos($value, $set_to) === false){
						$obj->$key = $value.$set_to;
					}
				}
			}
		}else{
			if(strpos($obj, $set_to) === false){
				$obj .= $set_to;
			}
		}
		
		return $obj;
	}
	
	/**
	 * strip suffixes from number values for accurate comparisons
	 * @since: 6.0
	 */  
	 public function strip_suffix_val($val){
		if(!is_string($val)) return $val;
		
		$val = trim($val);
		$len = strlen($val);
		if($len < 2) return $val;
		
		$suffix = false;
		$strips = array('ms', 'px', '%', 'deg');
		
		foreach($strips as $px){
			$chars = strlen($px);
			if($chars > $len) continue;
			if(strpos($val, $px, $len - $chars) !== false){
				$suffix = $chars;
				break;
			}
		}
		
		if($suffix !== false){
			$num = substr($val, 0, -$suffix);
			if(is_numeric($num)) $val = $num;
		}
		
		return $val;
		
	 }
	
	/**
	 * strip suffixes from number values for accurate comparisons
	 * @since: 6.0
	 */  
	public function strip_suffix($val){
		if(is_object($val)) $val = (array)$val;
		
		if(is_array($val)){
			foreach($val as $key => $v){
				if(is_array($v) || is_object($v)){
					$val[$key] = $this->strip_suffix($v);
				}else{
					$val[$key] = $this->strip_suffix_val($v);
				}
			}
		}else{
			$val = $this->strip_suffix_val($val);
		}
		
		return $val;
	
	}
	
	/**
	 * Check if shortcodes exists in the content
	 * @since: 5.0
	 */  
	public static function check_for_shortcodes($mid_content){
		if($mid_content !== null){ 
			if(has_shortcode($mid_content, 'gallery')){
				
				preg_match('/\[gallery.*ids=.(.*).\]/', $mid_content, $img_ids);
				
				if(isset($img_ids[1])){
					if($img_ids[1] !== '') return explode(',', $img_ids[1]);
				}
			}
		}
		return false;
	}
	
	
	/**
	 * return the responsive sizes
	 * @since: 5.0
	 **/
	 public function get_responsive_size($slider){
		$global = $this->get_global_settings();
		
		$csn = $slider->slider->get_param(array('size', 'custom', 'n'), false);
		$cst = $slider->slider->get_param(array('size', 'custom', 't'), false);
		$csi = $slider->slider->get_param(array('size', 'custom', 'm'), false);
		
		$w = $slider->slider->get_param(array('size', 'width', 'd'), 1240);
		$h = $slider->slider->get_param(array('size', 'height', 'd'), 1240);
		$r = $this->get_val($global, array('size', 'desktop'), 1240);
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
			$d = ($csi == true) ? $slider->slider->get_param(array('size', 'width', 'm'), 480) : $d;
			
			$d = $h;
			$h .= ',';
			$h .= ($csn == true) ? $slider->slider->get_param(array('size', 'height', 'n'), 1024) : $d;
			$d = ($csn == true) ? $slider->slider->get_param(array('size', 'height', 'n'), 1024) : $d;
			$h .= ',';
			$h .= ($cst == true) ? $slider->slider->get_param(array('size', 'height', 't'), 778) : $d;
			$d = ($cst == true) ? $slider->slider->get_param(array('size', 'height', 't'), 778) : $d;
			$h .= ',';
			$h .= ($csi == true) ? $slider->slider->get_param(array('size', 'height', 'm'), 480) : $d;
			$d = ($csi == true) ? $slider->slider->get_param(array('size', 'height', 'm'), 480) : $d;
			
			$d = $r;
			$r .= ',';
			$r .= ($csn == true) ? $this->get_val($global, array('size', 'notebook'), 1024) : $d;
			$d = ($csn == true) ? $this->get_val($global, array('size', 'notebook'), 1024) : $d;
			$r.= ',';
			$r .= ($cst == true) ? $this->get_val($global, array('size', 'tablet'), 778) : $d;
			$d = ($cst == true) ? $this->get_val($global, array('size', 'tablet'), 778) : $d;
			$r.= ',';
			$r .= ($csi == true) ? $this->get_val($global, array('size', 'mobile'), 480) : $d;
			$d = ($csi == true) ? $this->get_val($global, array('size', 'mobile'), 480) : $d;
			
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
				$d = ($csi == true) ? $slider->slider->get_param(array('size', 'editorCache', 'm'), 480) : $d;
			}
		}else{
			$r .= ',';
			$r .= $this->get_val($global, array('size', 'notebook'), 1024);
			$r .= ',';
			$r .= $this->get_val($global, array('size', 'tablet'), 778);
			$r .= ',';
			$r .= $this->get_val($global, array('size', 'mobile'), 480);
		}
		
		return array(
			'level' => str_replace('px', '', $r),
			'height' => str_replace('px', '', $h),
			'width' => str_replace('px', '', $w),
			'cacheSize' => str_replace('px', '', $c)
		);
	}
	
	
	/**
	 * get the current page id
	 * @since: 6.0
	 **/
	public function get_current_page_id(){
		$id = '';
		
		if(is_front_page() == true || is_home() == true){
			$id = 'homepage';
		}else{
			global $post;
			$id = (isset($post->ID)) ? $post->ID : $id;
		}
		
		return $id;
	}
	
	
	/**
	 * parse animation params
	 * 5.0.5: added (R) for reverse
	 * @before: RevSliderOperations::parseCustomAnimationByArray();
	 */
	public function parse_custom_animation_by_array($layer, $frame_nr = 0, $type = 'chars'){
		$ret = '';
		
		$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rx'), false) == true)						? '(R)' : ''; //movex reverse
		$ret	.= (!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'x'), ''), array('', 'inherit')))	? 'x:'.$this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'x'), '').$reverse.';' : ''; //movex
		$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'ry'), false) == true)						? '(R)' : ''; //movey reverse
		$ret	.= (!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'y')), array('', 'inherit')))		? 'y:'.$this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'y')).$reverse.';' : ''; //movey
		$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rz'), false) == true)						? '(R)' : ''; //movey reverse
		$ret	.= (!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'z')), array('', 'inherit')))		? 'z:'.$this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'z')).$reverse.';' : ''; //movez

		$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rrotationX')) == true)							? '(R)' : ''; //rotationx reverse
		$ret	.= (!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rotationX')), array('', 'inherit')))	? 'rX:'.$this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rotationX')).$reverse.';' : ''; //rotationx
		$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rrotationY')) == true)							? '(R)' : ''; //rotationy reverse
		$ret	.= (!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rotationY')), array('', 'inherit')))	? 'rY:'.$this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rotationY')).$reverse.';' : ''; //rotationy
		$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rrotationZ')) == true)							? '(R)' : ''; //rotationz reverse
		$ret	.= (!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rotationZ')), array('', 'inherit')))	? 'rZ:'.$this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rotationZ')).$reverse.';' : ''; //rotationz

		if(!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'scaleX', '')), array('', 'inherit'))){ //scalex
			$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rscaleX')) == true) ? '(R)' : ''; //scalex reverse
			$ret	.= 'sX:';
			$ret	.= ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'scaleX')) == 0) ? 0 : $this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'scaleX'));
			$ret	.= $reverse.';';
		}
		if(!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'scaleY')), array('', 'inherit'))){ //scaley
			$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rscaleY')) == true) ? '(R)' : ''; //scaley reverse
			$ret	.= 'sY:';
			$ret	.= ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'scaleY')) == 0) ? 0 : $this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'scaleY'));
			$ret	.= $reverse.';';
		}
		
		$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rskewX', false)) == true)					? '(R)' : ''; //skewx reverse
		$ret	.= (!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'skewX')), array('', 'inherit')))	? 'skX:'.$this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'skewX')).$reverse.';' : ''; //skewx
		$reverse = ($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'rskewY', false)) == true)					? '(R)' : ''; //skewy reverse
		$ret	.= (!in_array($this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'skewY')), array('', 'inherit')))	? 'skY:'.$this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'skewY')).$reverse.';' : ''; //skewy

		$opacity = $this->get_val($layer, array('timeline', 'frames', 'frame_'.$frame_nr, $type, 'opacity'));
		if(!in_array($opacity, array('', 'inherit'))){ //captionopacity
			$ret .= 'opacity:';
			$opa  = (intval($opacity) > 1) ? $opacity / 100 : $opacity;
			$ret .= $opa.';';
		}
		
		return $ret;
	}
	
	
	/**
	 * change hex to rgba
	 */
    public function hex2rgba($hex, $transparency = false, $raw = false, $do_rgb = false){
        if($transparency !== false){
			$transparency = ($transparency > 0) ? number_format(($transparency / 100), 2, '.', '') : 0;
        }else{
            $transparency = 1;
        }

        $hex = str_replace('#', '', $hex);
		
        if(strlen($hex) == 3){
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        }elseif($this->is_rgb($hex)){
			return $hex;
		}else{
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
		
		$ret = ($do_rgb) ? $r.', '.$g.', '.$b : $r.', '.$g.', '.$b.', '.$transparency;
		
		return ($raw) ? $ret : 'rgba('.$ret.')';
    }
	
	
	/**
	 * Activate the Plugin through the ThemePunch Servers
	 * @before: RevSliderOperations::checkPurchaseVerification();
	 **/
	public function activate_plugin($code){
		$rslb = new RevSliderLoadBalancer();
		$data = array(
			'code'		=> urlencode($code),
			'version'	=> urlencode(RS_REVISION),
			'product'	=> urlencode(RS_PLUGIN_SLUG)
		);
		
		$response	  = $rslb->call_url('activate.php', $data, 'updates');
		$version_info = wp_remote_retrieve_body($response);
		
		if(is_wp_error($version_info)){
			return false;
		}
		
		if($version_info == 'valid'){
			update_option('revslider-valid', 'true');
			update_option('revslider-code', $code);
			return true;
		}elseif($version_info == 'exist'){
			return 'exist';
		}elseif($version_info == 'banned'){
			return 'banned';
		}
		
		return false;
	}
	
	
	/**
	 * Deactivate the Plugin through the ThemePunch Servers
	 * @before: RevSliderOperations::doPurchaseDeactivation();
	 **/
	public function deactivate_plugin(){
		$rslb = new RevSliderLoadBalancer();
		$code = get_option('revslider-code', '');
		$data = array(
			'code'		=> urlencode($code),
			'product'	=> urlencode(RS_PLUGIN_SLUG)
		);
		$res = $rslb->call_url('deactivate.php', $data, 'updates');
		$vi	 = wp_remote_retrieve_body($res);
		
		if(is_wp_error($vi)){
			return false;
		}

		if($vi == 'valid'){
			update_option('revslider-valid', 'false');
			update_option('revslider-code', '');
			return true;
		}
		
		return false;
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
	 * returns an object of current system values
	 **/
	public function get_system_requirements(){
		$dir	= wp_upload_dir();
		$basedir = $this->get_val($dir, 'basedir').'/';
		$ml		= ini_get('memory_limit');
		$mlb	= wp_convert_hr_to_bytes($ml);
		$umf	= ini_get('upload_max_filesize');
		$umfb	= wp_convert_hr_to_bytes($umf);
		$pms	= ini_get('post_max_size');
		$pmsb	= wp_convert_hr_to_bytes($pms);
		
		
		$mlg  = ($mlb >= 268435456) ? true : false;
		$umfg = ($umfb >= 33554432) ? true : false;
		$pmsg = ($pmsb >= 33554432) ? true : false;
		
		return array(
			'memory_limit' => array(
				'has' => size_format($mlb),
				'min' => size_format(268435456),
				'good'=> $mlg
			),
			'upload_max_filesize' => array(
				'has' => size_format($umfb),
				'min' => size_format(33554432),
				'good'=> $umfg
			),
			'post_max_size' => array(
				'has' => size_format($pmsb),
				'min' => size_format(33554432),
				'good'=> $pmsg
			),
			'upload_folder_writable'	=> wp_is_writable($basedir),
			'object_library_writable'	=> wp_image_editor_supports(array('methods' => array('resize', 'save'))),
			'server_connect'			=> get_option('revslider-connection', false),
		);
	}
	
	/**
	 * set the rs_google_font to current date, so that it will be redownloaded
	 * @before: RevSliderOperations::deleteGoogleFonts();
	 */
	public function delete_google_fonts(){
		update_option('rs_google_font', time());
	}
	
	
	/**
	 * Check if it is an empty array or object
	 * @since: 6.0.0
	 **/
	public function isEmptyObject($vars){ //object	
		//$vars = get_object_vars($object);
		if(empty($vars) && $vars !== 0){ // && $vars !== false
		//if(!is_array($vars) && !is_object($vars) && trim($vars) === '' && $vars !== 0){
			return true;
		}else{
			$vars = (array)$vars;
			foreach($vars as $var){
				if(!is_array($var)){ //!is_object($var) && 
					return false;
				}else{
					return $this->isEmptyObject($var);
				}
			}
		}
	}
	
	/**
	 * Remove http:// and https://
	 * @since: 6.0.0
	 **/
	public function remove_http($url){
		return str_replace(array('http://', 'https://'), '//' , $url);
	}
	
	/**
	 * check the current post for the existence of a short code
	 * @before: hasShortcode()
	 */  
	public function has_shortcode($shortcode = ''){  
		$found = false; 
		
		if(empty($shortcode)) return false;
		if(!is_singular()) return false;
		
		$post = get_post(get_the_ID());  
		if(stripos($post->post_content, '[' . $shortcode) !== false) $found = true;  
		
		return $found;  
	}

	
	/**
	 * shortden values for output
	 * @since: 6.0.0
	 **/
	public function shorten($s, $f, $t){
		return str_replace($f, $t, $s);
	}
	
	
	/**
	 * perform checks to see how to write a JavaScript variable
	 **/
	public function write_js_var($v, $pp = '"'){
		if(is_bool($v)) $v = ($v) ? 'true' : 'false';
		return (is_numeric($v) || substr($v, 0, 1) === '[' || in_array($v, array('true', 'false'))) ? $v : $pp.$v.$pp;
	}
	
	/**
	 * add "a" tags to links within a text
	 * @since: 5.0
	 * @before: RevSliderBase::add_wrap_around_url()
	 */
	public function add_wrap_around_url($text){
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		// Check if there is a url in the text
		if(preg_match($reg_exUrl, $text, $url)){
			// make the urls hyper links
			return preg_replace($reg_exUrl, '<a href="'.$url[0].'" rel="nofollow" target="_blank">'.$url[0].'</a>', $text);
		}else{
			// if no urls in the text just return the text
			return $text;
		}
	}
	
	/**
	 * Encode the flickr ID for URL (base58)
	 * @since    1.0.0
	 * @param    string    $num 	flickr photo id
	 */
	public function base_encode($num, $alphabet = '123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ'){
		$base_count = strlen($alphabet);
		$encoded = '';
		while ($num >= $base_count){
			$div = $num / $base_count;
			$mod = ($num - ($base_count * intval($div)));
			$encoded = $alphabet[$mod] . $encoded;
			$num = intval($div);
		}
		if($num) $encoded = $alphabet[$num] . $encoded;
		return $encoded;
	}
	
	
	/**
	 * depending on PHP version, use optional parameter of unserialize
	 * @since: 6.0.0
	 **/
	public function rs_unserialize($string){
		if(version_compare(phpversion(), '7.0.0', '<')){
			return @unserialize($string);
		}
		
		//return @unserialize($string, false);
		return @unserialize($string);
	}
	
	/**
	 * go through folders and return all files, $only checking for certain file types
	 **/
	/*public function get_all_files($dir, &$results = array(), $only = false){
		$files = scandir($dir);
		
		foreach($files as $key => $value){
			$add	= true;
			$path	= realpath($dir.DIRECTORY_SEPARATOR.$value);
			if($only !== false){
				$path_parts = pathinfo($path);
				if($this->get_val($path_parts, 'extension') != $only){
					$add = false;
				}
			}
			
			if(!is_dir($path)){
				if($add){
					$results[] = $path;
				}
			}elseif($value != '.' && $value != '..'){
				$this->get_all_files($path, $results, $only);
				if($add){
					$results[] = $path;
				}
			}
		}

		return $results;
	}*/

}

//class RevSliderFunctions extends rs_functions {}
//logConsole( $tpmissiotheme_nav_background_main, "Background" );
?>