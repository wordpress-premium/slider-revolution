<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();
 
global $revslider_rev_start_size_loaded;

$revslider_rev_start_size_loaded = false;

class RevSliderFunctions extends RevSliderData {

	public function __construct(){
		parent::__construct();
	}

	/**
	 * START: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * old version of get_val();
	 * added for compatibility with old AddOns
	 **/
	public static function getVal($arr, $key, $default = ''){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		$f->add_deprecation_message('getVal', 'get_val');
		return $f->get_val($arr, $key, $default);
	}
	
	/**
	 * old version of class_to_array_single();
	 * added for compatibility with old AddOns
	 **/
	public static function cleanStdClassToArray($arr){
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');
		$f->add_deprecation_message('cleanStdClassToArray', 'class_to_array_single');
		return $f->class_to_array_single($arr);
	}
	
	/**
	 * END: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/

	/**
	 * attempt to load cache for _get_global_settings
	 * @return mixed
	 */
	public function get_global_settings(){
		return $this->get_wp_cache('_get_global_settings');
	}

	/**
	 * Get Global Settings
	 * @before: RevSliderOperations::getGeneralSettingsValues()
	 **/
	protected function _get_global_settings(){
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
	public function set_global_settings($global, $merge = false){
		$this->delete_wp_cache('_get_global_settings');
		if($this->_truefalse($merge) === true){
			$_global = $this->get_global_settings();
			if(!is_array($_global)) $_global = array();
			if(!is_array($global)) $global = array();
			$global = array_replace_recursive($_global, $global);
		}
		
		$global = json_encode($global);
		
		update_option('revslider-global-settings', $global);
		
		return true;
	}


	/**
	 * get all additions from the update checks
	 * @since: 6.2.0
	 **/
	public function get_addition($key = ''){
		$additions = (array)get_option('revslider-additions', array());
		$additions = (!is_array($additions)) ? json_decode($additions, true) : $additions;
		
		return (empty($key)) ? $additions : $this->get_val($additions, $key);
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
	 * get value from array. if not - return alternative
	 * before: RevSliderFunctions::get_val();
	 * 
	 * @param mixed $arr  could be array | object | scalar 
	 * @param mixed $key  could be array | string
	 * @param mixed $default  value to return if key not found
	 * @return mixed  
	 */
	public function get_val($arr, $key, $default = ''){
		//scalar =  int, float, string и bool
		if(is_scalar($arr)) return $default;
		//convert obj to array 
		if(is_object($arr)) $arr = (array)$arr;
		//if key is string, check immediately 
		if(!is_array($key)) return (isset($arr[$key])) ? $arr[$key] : $default;
		//loop thru keys
		foreach($key as $v){
			if(is_object($arr)) $arr = (array)$arr;
			if(isset($arr[$v])) {
				$arr = $arr[$v];
			} else {
				return $default;
			}
		}
		return $arr;
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
	}
	
	/**
	 * get POST variable
	 * before: RevSliderBase::getPostVar();
	 */
	public function get_post_var($key, $default = '', $esc = true){
		$val = $this->get_var($_POST, $key, $default);
		return ($esc) ? esc_html($val) : $val;
	}
	
	/**
	 * get GET variable
	 * before: RevSliderBase::getGetVar();
	 */
	public function get_get_var($key, $default = '', $esc = true){
		$val = $this->get_var($_GET, $key, $default);
		return ($esc) ? esc_html($val) : $val;
	}
	
	/**
	 * get POST or GET variable in this order
	 * before: RevSliderBase::getPostGetVar();
	 */
	public function get_request_var($key, $default = '', $esc = true){
		$val = (array_key_exists($key, $_POST)) ? $this->get_var($_POST, $key, $default) : $this->get_var($_GET, $key, $default);
		return ($esc) ? esc_html($val) : $val;
	}
	
	/**
	 * get a variable from an array,
	 * before: RevSliderBase::getVar()
	 */
	public function get_var($arr, $key, $default = ''){
		return (isset($arr[$key])) ? $arr[$key] : $default;
	}
	
	/**
	 * check for true and false in all possible ways
	 * @since: 6.0
	 **/
	public function _truefalse($v){
		if(in_array($v, array('false', false, 'off', NULL, 0, -1), true)){
			return false;
		}elseif(in_array($v, array('true', true, 'on'), true)){
			return true;
		}
		
		return $v;
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
			$json = (defined('JSON_INVALID_UTF8_IGNORE')) ? json_encode($arr, JSON_INVALID_UTF8_IGNORE) : json_encode($arr);
			$json = (!empty($json)) ? addslashes($json) : $json;
		}
		
		return (empty($json)) ? '{}' : "'".$json."'";
	}
	
	
	/**
	 * turn a string into an array, check also for slashes!
	 * @since: 6.0
	 */
	public function json_decode_slashes($data){
		if(gettype($data) !== 'string') return $data;
	
		$data_decoded = json_decode(stripslashes($data), true);
		if(empty($data_decoded)) $data_decoded = json_decode($data, true);
		
		return $data_decoded;
	}
	
	
	/**
	 * Convert std class to array, with all sons
	 * before: RevSliderFunctions::convertStdClassToArray();
	 * @return array|null
	 */
	public function class_to_array($arr){
		return json_decode(json_encode($arr), true);
	}
	
	/**
	 * Convert std class to array, single
	 * before: RevSliderFunctions::cleanStdClassToArray();
	 * @return array
	 */
	public function class_to_array_single($arr){
		return (array)$arr;
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
	 * compress an array/object/string to a string
	 * @since 6.6.0
	 **/
	public function do_compress($data, $level = 9){
		if(is_array($data) || is_object($data)) $data = json_encode($data);
		
		if(!function_exists('gzcompress') || !function_exists('gzuncompress')) return $data; //gzencode / gzdecode

		return base64_encode(gzcompress($data, $level));
	}

	/**
	 * decompress an string to an array/object/string
	 * @since 6.6.0
	 **/
	public function do_uncompress($data){
		if($data === false || empty($data) || is_array($data) || is_object($data)) return $data;
		$_data = json_decode($data, true);
		if(is_array($_data) || is_object($_data)) return $_data;
		if(!function_exists('gzcompress') || !function_exists('gzuncompress')) return $data; //gzencode / gzdecode

		$data = gzuncompress(base64_decode($data));
		$_data = json_decode($data, true);

		return (!empty($_data)) ? $_data : $data;
	}

	/**
	 * get attachment image url
	 * before: RevSliderFunctionsWP::getUrlAttachmentImage();
	 */
	public function get_url_attachment_image($id, $size = 'full'){
		$image	= wp_get_attachment_image_src($id, $size);
		$url	= (empty($image)) ? false : $this->get_val($image, 0);
		if($url === false) $url = wp_get_attachment_url($id);
		
		return $url;
	}


	/**
	 * gets a temporary path where files can be stored
	 **/
	public function get_temp_path($path = 'rstemp'){
		if(function_exists('sys_get_temp_dir')){
			$temp = sys_get_temp_dir();
			if(@is_dir($temp) && wp_is_writable($temp)){
				$dir = trailingslashit($temp).$path.'/';
				if(!is_dir($dir)) @mkdir($dir, 0777, true);
				if(is_dir($dir) && wp_is_writable($dir)) return $dir;
			}
		}
	
		$temp = ini_get('upload_tmp_dir');
		if(@is_dir($temp) && wp_is_writable($temp)){
			$dir = trailingslashit($temp).$path.'/';
			if(!is_dir($dir)) @mkdir($dir, 0777, true);
			if(is_dir($dir) && wp_is_writable($dir)) return $dir;
		}

		$temp_dir = get_temp_dir();
		if(wp_is_writable($temp_dir)){
			$dir = trailingslashit($temp_dir).$path.'/';
			if(!is_dir($dir)) @mkdir($dir, 0777, true);
			if(is_dir($dir) && wp_is_writable($dir)) return $dir;
		}
		
		$upload_dir = wp_upload_dir();
		$dir		= $upload_dir['basedir'].'/'.$path.'/';
		if(!is_dir($dir)) @mkdir($dir, 0777, true);

		return $dir;
	}
	
	
	/**
	 * retrieve the image id from the given image url
	 */
	public function get_image_id_by_url($image_url){
		if($image_url === '') return false;

		$attachment_id = attachment_url_to_postid($image_url);
		
		return (is_null($attachment_id) || $attachment_id === 0) ? false : $attachment_id; //fix for B-5855627275
	}
	
	/**
	 * retrieve the image id from the given image filename/basename
	 * @since: 6.1.5
	 */
	public function get_image_id_by_basename($basename){
		global $wpdb;
		
		$var = $wpdb->get_var($wpdb->prepare("SELECT `post_id` FROM `".$wpdb->postmeta."` WHERE `meta_value` LIKE %s LIMIT 0,1", '%/'.$basename));
		
		return ($var) ? $var : false;
	}
	
	/**
	 * get image url from image path.
	 */
	public function get_image_url_from_path($path){
		if(empty($path) || substr($path, -1) === '/' || substr($path, -1) === '\\') return ''; //check if the path ends with /, if yes its not a correct image path
		
		//protect from absolute url
		$lower		= strtolower($path);
		$base_url	= $this->get_base_url();
		$return		= (strpos($lower, 'http://') !== false || strpos($lower, 'https://') !== false || strpos($lower, 'www.') === 0) ? $path : $base_url.$path;
		
		return ($return !== $base_url) ? $return : '';
	}
	
	/**
	 * Check if Path is a Valid Image File
	 **/
	public function check_valid_image($url){
		if(empty($url)) return false;

		$ext		= strtolower(pathinfo($url, PATHINFO_EXTENSION));
		$img_exts	= array('gif', 'jpg', 'jpeg', 'png');

		return (in_array($ext, $img_exts)) ? $url : false;
	}
	
	/**
	 * get the upload URL of images
	 */
	public static function get_base_url(){
		return (is_multisite() == false) ? content_url().'/' : wp_upload_dir()['baseurl'].'/';
	}
	
	/**
	 * strip slashes recursive
	 * @since: 5.0
	 * before: RevSliderBase::stripslashes_deep()
	 */
	public static function stripslashes_deep($value){
		if(empty($value)) return $value;
		
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
	 * get post types with categories for client side.
	 */
	public function get_post_types_with_categories_for_client(){
		$c = 0;
		$ret = array();
		$post_types = $this->get_post_types_with_taxonomies();
		foreach($post_types as $name => $tax){
			$cat = array();
			if(empty($tax)){
				$ret[$name] = $cat;
				continue;
			}
			
			foreach($tax as $tax_name => $tax_title){
				$cats = $this->get_categories_assoc($tax_name);
				if(empty($cats)) continue;

				$c++;
				$cat['option_disabled_'.$c] = '---- '. $tax_title .' ----';
				foreach($cats as $catID => $catTitle){
					$cat[$tax_name.'_'.$catID] = $catTitle;
				}
			}
			
			$ret[$name] = $cat;
		}

		return $ret;
	}
	
	
	/**
	 * get post types array with taxomonies
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
	 */
	public static function get_post_type_title($post_type){
		$obj_type = get_post_type_object($post_type);
		
		return (empty($obj_type)) ? ($post_type) : $obj_type->labels->singular_name;
	}
	
	
	/**
	 * get post type taxomonies
	 */
	public function get_post_type_taxonomies($post_type){
		$tax = get_object_taxonomies(array('post_type' => $post_type), 'objects');
		
		if(empty($tax)) return array();

		$names	= array();
		foreach($tax as $obj_tax){
			if($post_type === 'product' && !in_array($obj_tax->name, array('product_cat', 'product_tag'))) continue;
			$names[$obj_tax->name] = $obj_tax->labels->name;
		}
		
		return $names;
	}
	
	
	/**
	 * get post categories list assoc - id / title
	 */
	public function get_categories_assoc($taxonomy = 'category'){
		$categories	= array();
		if(strpos($taxonomy, ',') !== false){
			$taxes = explode(',', $taxonomy);
			foreach($taxes as $tax){
				$cats		= $this->get_categories_assoc($tax);
				$categories	= array_merge($categories, $cats);
			}
		}else{
			$args = array('taxonomy' => $taxonomy, 'number' => 10000);
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
	 * check if file is in zip
	 * @since: 5.0
	 */
	public function check_file_in_zip($d_path, $image, $alias, &$alreadyImported, $add_path = false){
		global $wp_filesystem;
		
		$image = (is_array($image)) ? $this->get_val($image, 'url') : $image;
		if(trim($image) === '' || strpos($image, 'http') !== false) return $image; //http -> externam image, do not change

		$strip	= false;
		$zimage	= $wp_filesystem->exists($d_path.'images/'.$image);
		if(!$zimage){
			$zimage	= $wp_filesystem->exists(str_replace('//', '/', $d_path.'images/'.$image));
			$strip	= true;
		}
		
		if($zimage !== false){
			if(!isset($alreadyImported['images/'.$image])){
				//check if we are object folder, if yes, do not import into media library but add it to the object folder
				$uimg = ($strip == true) ? str_replace('//', '/', 'images/'.$image) : $image; //pclzip
				
				if(strpos($uimg, 'revslider/objects/') === 0){ //we are from the object library, copy the image to the objects folder if false
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
			$updir = wp_upload_dir()['baseurl'];
			if(strpos($image, $updir) === false) $image = str_replace('uploads/uploads/', 'uploads/', $updir . '/' . $image);
		}
		
		return $image;
	}
	
	/**
	 * Import the Media as it is
	 **/
	public function import_media_raw($name, $id, $bitmap){
		if(intval($id) === 0) return __('Invalid id given', 'revslider');
		
		$path = $this->get_temp_path('rstemp');
		
		if(preg_match('/^data:image\/(\w+);base64,/', $bitmap, $type)){
			$data = substr($bitmap, strpos($bitmap, ',') + 1);
			$type = strtolower($type[1]); // jpg, png, gif

			if(!in_array($type, array('jpg', 'jpeg', 'gif', 'png'))) return __('Image has an invalid type', 'revslider');
			
			if(strpos($name, '.') !== false) $name = explode('.', $name)[0];

			$name .= '_'.$id.'.'.$type;
			$name = preg_replace("/[^a-zA-Z0-9\-\.\_]/", '', $name);
			
			$data = base64_decode(str_replace(' ', '+', $data));

			if($data === false) return __('Image has an invalid type', 'revslider');
		}else{
			return __('Image has invalid data', 'revslider');
		}
		
		if(file_put_contents($path.$name, $data) === false) return __('Image could not be saved', 'revslider');

		return $this->import_media($path.$name , 'video-media/');
	}
	
	
	/**
	 * Import media from url
	 * @param string $file_url URL of the existing file from the original site
	 * @param int $folder_name The slidername will be used as folder name in import
	 * @return boolean array() on success, false on failure
	 */
	public function import_media($file_url, $folder_name){
		global $SR_GLOBALS;
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		
		$ul_dir	 = wp_upload_dir();
		$art_dir = 'revslider/';
		$return	 = false;
		$filename = basename($file_url); //rename the file... alternatively, you could explode on "/" and keep the original file name
		$s_dir	= str_replace('//', '/', $art_dir.$folder_name.$filename);
		$_s_dir	= false;

		//if the directory doesn't exist, create it	
		if(!file_exists($ul_dir['basedir'].'/'.$art_dir)) mkdir($ul_dir['basedir'].'/'.$art_dir);
		if(!file_exists($ul_dir['basedir'].'/'.$art_dir.$folder_name)) mkdir($ul_dir['basedir'].'/'.$art_dir.$folder_name);
		
		if(@fclose(@fopen($file_url, 'r'))){ //make sure the file actually exists
			$path_info = pathinfo($file_url);
			if(!isset($path_info['extension'])) return $return;
			if(in_array(strtolower($path_info['extension']), $SR_GLOBALS['bad_extensions'])) return $return;

			$save_dir	= $ul_dir['basedir'].'/'.$s_dir;
			$_atc_id	= $this->get_image_id_by_url($s_dir);
			$atc_id		= ($_atc_id === false || $_atc_id === NULL) ? $this->get_image_id_by_basename($filename) : $_atc_id;
			
			if($_atc_id !== $atc_id && $atc_id !== false && $atc_id !== NULL){ //&& $_atc_id !== false && $_atc_id !== NULL
				//the image was found through get_image_id_by_basename(), so we have to get the new save_dir for comparison of md5
				$_save_dir = get_attached_file($atc_id);
				
				if($_save_dir !== false && !empty($_save_dir)){
					if(md5_file($_save_dir) === md5_file($file_url)){
						$save_dir = $_save_dir;
						$atc_id	= $atc_id;
						$s_dir	= str_replace($ul_dir['basedir'].'/', '', $save_dir);
						$_s_dir	= $s_dir;
					}
				}
			}
			
			
			/**
			 * check if the files have matching md5, if not change the filename
			 * change save_dir so that the file is not
			 **/
			if($atc_id !== false && $atc_id !== NULL){
				if(!is_file($save_dir) || md5_file($file_url) !== md5_file($save_dir)){
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
					
					//we have a new $filename here, so use that one now
					$s_dir = str_replace('//', '/', $art_dir.$folder_name.$filename);
					$_s_dir = false;
				}

				//check if the file really exists in the filesystem, if not reset and redownload
				WP_Filesystem();
				global $wp_filesystem;
				if(!$wp_filesystem->exists($ul_dir['basedir'].'/'.$s_dir)) $atc_id = false;
			}
			
			if($atc_id == false || $atc_id == NULL){
				@copy($file_url, $save_dir);
				
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
					'post_mime_type' => $this->get_val($file_info, 'mime'),
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
				if($attach_data = @wp_generate_attachment_metadata($attach_id, $save_dir)){
					@wp_update_attachment_metadata($attach_id, $attach_data);
				}
			}else{
				$attach_id = $atc_id;
			}
			
			if($_s_dir !== false){
				$s_dir = (!is_multisite()) ? 'uploads/'.$_s_dir : $_s_dir;
				$s_dir = str_replace('//', '/', $s_dir);
			}else{
				$art_dir = (!is_multisite()) ? 'uploads/'.$art_dir : $art_dir;
				$s_dir = str_replace('//', '/', $art_dir.$folder_name.$filename);
			}
			
			$return	 = array('id' => $attach_id, 'path' => $s_dir);
		}
		
		return $return;
	}
	
	
	/**
	 * temporary remove image sizes so that only the needed thumb will be created
	 * @since: 6.0
	 **/
	public static function temporary_remove_sizes($sizes, $meta = false){
		return (!empty($sizes) && isset($sizes['thumbnail'])) ? array('thumbnail' => $sizes['thumbnail']) : $sizes;
	}
	
	
	/**
	 * get contents of the css table
	 */
	public function get_captions_content($handle = false){
		$css = RevSliderGlobals::instance()->get('RevSliderCssParser');
		$this->fill_css();
		
		return $css->db_array_to_array($this->css, $handle);
	}
	
	
	/**
	 * get wp-content path
	 */
	public function get_upload_path(){
		if(is_multisite()){
			global $wpdb;
			return (!defined('BLOGUPLOADDIR')) ? ABSPATH . 'wp-content/uploads/sites/' . $wpdb->blogid : BLOGUPLOADDIR;
		}
		
		return (!empty(WP_CONTENT_DIR)) ? WP_CONTENT_DIR . '/' : ABSPATH . 'wp-content/uploads/';
	}
	
	/**
	 * get contents of the static css file
	 */
	public function get_static_css(){
		return get_option('revslider-static-css', '');
	}
	
	/**
	 * get contents of the static css file
	 */
	public function update_static_css($css){
		$css = str_replace(array("\'", '\"', '\\\\'),array("'", '"', '\\'), trim($css));
		update_option('revslider-static-css', $css);
		return $css;
	}
	
	/**
	 * print html font import
	 * @before: RevSliderOperations::printCleanFontImport()
	 */
	public function print_clean_font_import_v7(){
		global $SR_GLOBALS;

		$gs		= $this->get_global_settings();
		$fdl	= $this->get_val($gs, 'fontdownload', 'off');
		$ret	= '';
		$tcf	= '';
		$tcf2	= '';
		$font_first = true;
		$fonts	= array();

		if(!empty($SR_GLOBALS['fonts']['queue'])){
			foreach($SR_GLOBALS['fonts']['queue'] as $f_n => $f_s){
				if(!isset($f_s['url'])) continue; //if url is not set, continue
				
				if(isset($f_s['load']) && $f_s['load'] === true){ //only load if we are true
					$ret .=  RS_T3.'<link href="' . esc_html($f_s['url']) . '" rel="stylesheet" property="stylesheet" media="all" type="text/css" />'."\n";
				}
				if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n])) $SR_GLOBALS['fonts']['loaded'][$f_n] = array();
				$SR_GLOBALS['fonts']['loaded'][$f_n] = array('url' => $this->get_val($f_s, 'url'));
			}
		}

		if($fdl === 'disable') return $ret;

		if(!empty($SR_GLOBALS['fonts']['queue'])){
			foreach($SR_GLOBALS['fonts']['queue'] as $f_n => $f_s){
				if(!is_bool($f_s)) continue;
				$loaded = false;
				switch($f_n){
					case 'Materialicons';
						$ret .= RS_T3.'<link href="' . RS_PLUGIN_URL_CLEAN . 'public/css/fonts/material/material-icons.css" rel="stylesheet" property="stylesheet" media="all" type="text/css" />'."\n";
						$loaded = array('url' => RS_PLUGIN_URL_CLEAN . 'public/css/fonts/material/material-icons.css', 'icon' => true, 'family' => 'Materialicons');
					break;
					case 'FontAwesome';
						$ret .= RS_T3.'<link href="' . RS_PLUGIN_URL_CLEAN . 'public/css/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" property="stylesheet" media="all" type="text/css" />'."\n";
						$loaded = array('url' => RS_PLUGIN_URL_CLEAN . 'public/css/fonts/font-awesome/css/font-awesome.css', 'icon' => true, 'family' => 'FontAwesome');
					break;
					case 'PeIcon';
						$ret .= RS_T3.'<link href="' . RS_PLUGIN_URL_CLEAN . 'public/css/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet" property="stylesheet" media="all" type="text/css" />'."\n";
						$loaded = array('url' => RS_PLUGIN_URL_CLEAN . 'public/css/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css', 'icon' => true, 'family' => 'Pe-icon-7-stroke');
					break;
						case 'RevIcon';
						$ret .= RS_T3.'<link href="' . RS_PLUGIN_URL_CLEAN . 'public/css/fonts/revicons/css/revicons.css" rel="stylesheet" property="stylesheet" media="all" type="text/css" />'."\n";
						$loaded = array('url' => RS_PLUGIN_URL_CLEAN . 'public/css/fonts/revicons/css/revicons.css', 'icon' => true, 'family' => 'revicons');
					break;
				}
				if($loaded === false) continue;

				if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n])) $SR_GLOBALS['fonts']['loaded'][$f_n] = $loaded;
			}
		}

		if(!empty($SR_GLOBALS['fonts']['queue'])){
			$font_types = array('normal', 'italic');
			
			foreach($SR_GLOBALS['fonts']['queue'] as $f_n => $f_s){
				if(empty($f_n)) continue;
				if(isset($f_s['url']) && !empty($f_s['url'])) continue; //ignore custom
			
				$_variants	= $this->get_val($f_s, 'variants', array('normal' => array(), 'italic' => array()));
				$_subsets	= $this->get_val($f_s, 'subsets', array());
				if(!empty($_variants['normal']) || !empty($_variants['italic']) || !empty($_subsets)){
					if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n])) $SR_GLOBALS['fonts']['loaded'][$f_n] = array();
					if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n]['variants'])) $SR_GLOBALS['fonts']['loaded'][$f_n]['variants'] = array();
					if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n]['variants']['normal'])) $SR_GLOBALS['fonts']['loaded'][$f_n]['variants']['normal'] = array();
					if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n]['variants']['italic'])) $SR_GLOBALS['fonts']['loaded'][$f_n]['variants']['italic'] = array();
					if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n]['subsets'])) $SR_GLOBALS['fonts']['loaded'][$f_n]['subsets'] = array();
					
					if(strpos($f_n, 'href=') === false){
						$t_tcf = '';
						
						if($font_first == false) $t_tcf .= '&family=';
						$t_tcf .= preg_replace('/[^-0-9a-zA-Z+]/', '', str_replace(' ', '+', $f_n)).':';

						if(!empty($_variants['normal']) || !empty($_variants['italic'])){
							$mgfirst = true;
							$italic = false;
							if(!empty($f_s['variants']['italic'])){
								$t_tcf .= 'ital,';
								$italic = true;
							}
							$t_tcf .= 'wght@';

							$weights = array();
							foreach($font_types as $ft){
								if(!isset($f_s['variants'][$ft])) continue;
								$weights[$ft] = array();
								foreach($f_s['variants'][$ft] as $variant){
									if(in_array($variant, $SR_GLOBALS['fonts']['loaded'][$f_n]['variants'][$ft], true)) continue;
									$SR_GLOBALS['fonts']['loaded'][$f_n]['variants'][$ft][] = $variant;
									//if($variant === 'italic') continue;
									
									$weights[$ft][] = $variant;
								}
							}
							if(empty($weights)) continue;
							
							$i = 0;
							foreach($weights as $weight_values){
								if(empty($weight_values)) continue;

								asort($weight_values); //sort as we need to start from low to high

								foreach($weight_values as $weight){
									if(!$mgfirst) $t_tcf .= ';';

									$t_tcf .= ($italic === true) ? $i.','.$weight : $weight;
									$mgfirst = false;
								}
								$i++;
							}
							
							//we did not add any variants, so dont add the font
							if($mgfirst === true) continue;
						}
						
						$fonts[$f_n] = $t_tcf; //we do not want to add the subsets
						
						if($fdl === 'preload'){
							/*if(!empty($_subsets)){
								var_dump($_subsets);
								$mgfirst = true;
								foreach($_subsets as $ssk => $subset){
									var_dump($subset);
									if(is_array($subset)) continue;

									if(in_array($subset, $SR_GLOBALS['fonts']['loaded'][$f_n]['subsets'], true)) continue;
									
									$SR_GLOBALS['fonts']['loaded'][$f_n]['subsets'][] = $subset;
									
									if($mgfirst) $t_tcf .= urlencode('&subset=');
									if(!$mgfirst) $t_tcf .= urlencode(',');
									$t_tcf .= urlencode($subset);
									$mgfirst = false;
								}
							}*/
						}

						$tcf .= $t_tcf;
					}else{
						$tcf2 .= html_entity_decode(stripslashes($f_n));
						
						$fonts[$f_n] = $tcf2;
					}
					$font_first = false;
				}
			}
		}

		if($fdl === 'preload'){
			$ret .= $this->preload_fonts($fonts);
		}else{
			$url = $this->modify_fonts_url('https://fonts.googleapis.com/css2?family=');
			$ret .= ($tcf !== '') ?  RS_T3.'<link href="'.$url.$tcf.'&display=swap" rel="stylesheet" property="stylesheet" media="all" type="text/css" >'."\n" : '';
			$ret .= ($tcf2 !== '') ?  RS_T3.html_entity_decode(stripslashes($tcf2)) : '';
		}

		return apply_filters('revslider_printCleanFontImport', $ret);
	}
	
	/**
	 * print html font import
	 * @before: RevSliderOperations::printCleanFontImport()
	 */
	public function print_clean_font_import(){
		global $SR_GLOBALS;
		
		$font_first	= true;
		$ret	= '';
		$tcf	= '';
		$tcf2	= '';
		$fonts	= array();
		
		$gs = $this->get_global_settings();
		$fdl = $this->get_val($gs, 'fontdownload', 'off');

		if(!empty($SR_GLOBALS['fonts']['queue'])){
			foreach($SR_GLOBALS['fonts']['queue'] as $f_n => $f_s){
				if(!isset($f_s['url'])) continue; //if url is not set, continue
				if(isset($f_s['load']) && $f_s['load'] === true){ //only load if we are true
					$ret .= '<link href="' . esc_html($f_s['url']) . '" rel="stylesheet" property="stylesheet" media="all" type="text/css" >'."\n";
				}
			}
		}
		
		if($fdl === 'disable') return $ret;
		
		if(!empty($SR_GLOBALS['fonts']['queue'])){
			foreach($SR_GLOBALS['fonts']['queue'] as $f_n => $f_s){
				if(empty($f_n)) continue;
				if(isset($f_s['url']) && !empty($f_s['url'])) continue; //ignore custom
			
				$_variants = $this->get_val($f_s, 'variants', array());
				$_subsets = $this->get_val($f_s, 'subsets', array());
				if(!empty($_variants) || !empty($_subsets)){
					if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n])) $SR_GLOBALS['fonts']['loaded'][$f_n] = array();
					if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n]['variants'])) $SR_GLOBALS['fonts']['loaded'][$f_n]['variants'] = array();
					if(!isset($SR_GLOBALS['fonts']['loaded'][$f_n]['subsets'])) $SR_GLOBALS['fonts']['loaded'][$f_n]['subsets'] = array();
					
					if(strpos($f_n, 'href=') === false){
						$t_tcf = '';
						
						if($font_first == false) $t_tcf .= '%7C'; //'|';
						$t_tcf .= urlencode($f_n).':';
						
						if(!empty($_variants)){
							$mgfirst = true;
							foreach($f_s['variants'] as $variant){
								if(in_array($variant, $SR_GLOBALS['fonts']['loaded'][$f_n]['variants'], true)) continue;
								
								$SR_GLOBALS['fonts']['loaded'][$f_n]['variants'][] = $variant;
								
								if(!$mgfirst) $t_tcf .= urlencode(',');
								$t_tcf .= urlencode($variant);
								$mgfirst = false;
							} 
							
							//we did not add any variants, so dont add the font
							if($mgfirst === true) continue;
						}
						
						$fonts[$f_n] = $t_tcf; //we do not want to add the subsets
						
						if(!empty($_subsets)){
							$mgfirst = true;
							foreach($f_s['subsets'] as $ssk => $ssv){
								if(in_array($ssv, $SR_GLOBALS['fonts']['loaded'][$f_n]['subsets'], true)) continue;
								
								$SR_GLOBALS['fonts']['loaded'][$f_n]['subsets'][] = $ssv;
								
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
		
		if($fdl === 'preload'){
			$ret .= $this->preload_fonts($fonts);
		}else{
			$url = $this->modify_fonts_url('https://fonts.googleapis.com/css?family=');
			$ret .= ($tcf !== '') ? '<link href="'.$url.$tcf.'&display=swap" rel="stylesheet" property="stylesheet" media="all" type="text/css" >'."\n" : '';
			$ret .= ($tcf2 !== '') ? html_entity_decode(stripslashes($tcf2)) : '';
		}
		
		return apply_filters('revslider_printCleanFontImport', $ret);
	}

	/**
	 * preloading fonts and return style for it
	 **/
	public function preload_fonts($fonts, $style = true, $all = false){
		$ret = '';
		
		if(empty($fonts)) return $ret;
	
		if(!function_exists('download_url')) require_once ABSPATH . 'wp-admin/includes/file.php';
		$allowed_mime_types = array('ttf'  => 'font/ttf', 'woff' => 'font/woff', 'woff2' => 'font/woff2', 'otf'  => 'font/otf');
		$upload_dir	= wp_upload_dir();
		$base_dir	= $upload_dir['basedir'];
		$base_url	= $this->remove_http($upload_dir['baseurl']);
		$tp_google_ts = get_option('tp_google_font', 0);
		$types		= array(
			//--- original
			'ttf'	=> array('user-agent' => ''),
			'woff'	=> array('accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8', 'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.10240'),
			'woff2'	=> array('accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8', 'user-agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:73.0) Gecko/20100101 Firefox/73.0'),
			//--- original end
			/*--- alternative
			//'ttf'	=> array('user-agent' => 'Mozilla/5.0 (Unknown; Linux x86_64) AppleWebKit/538.1 (KHTML, like Gecko) Safari/538.1 Daum/4.1'),
			//'woff'	=> array('user-agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0'),
			//'woff2'	=> array('user-agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0'),
			//'eot'	=> array('user-agent' => 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)'),
			//'svg'	=> array('user-agent' => 'Mozilla/4.0 (iPad; CPU OS 4_0_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/4.1 Mobile/9A405 Safari/7534.48.3'),
			//--- alternative 2 end */
		);
		$fonts_css	= get_option('tp_font_css', array());
		if(!is_array($fonts_css)) $fonts_css = array();
		$load = 'ttf';

		if($all === false){
			$_browser	= $this->get_browser();
			$version	= $this->get_val($_browser, 'version', '0');
			$browser	= $this->get_val($_browser, 'name', '');
			//Chrome 6+ , Firefox 3.6+ IE9+, Safari 5.1+  -> WOFF
			//Chrome 26+, Operae23+, Firefox 39+ -> Woff2
			switch(strtolower($browser)){
				case 'mozilla firefox':
					if(version_compare($version, '3.6', '>=')) $load = 'woff';
					if(version_compare($version, '39', '>=')) $load = 'woff2';
				break;
				case 'edge':
					$load = 'woff2';
				break;
				case 'google chrome':
					if(version_compare($version, '6', '>=')) $load = 'woff';
					if(version_compare($version, '26', '>=')) $load = 'woff2';
				break;
				case 'apple safari':
					if(version_compare($version, '5.1', '>=')) $load = 'woff';
				break;
				case 'opera':
					if(version_compare($version, '23', '>=')) $load = 'woff';
				break;
				case 'internet explorer':
					if(version_compare($version, '9', '>=')) $load = 'woff';
				break;
			}
		}

		foreach($fonts as $key => $font){
			//check if we downloaded the font already
			$font		= str_replace(array('&family=', '%7C'), '', $font);
			
			if(strpos($key, ':') !== false){
				$key = explode(':', $key);
				$key = $key[0];
			}
			$font_name	= preg_replace('/[^-a-z0-9 ]+/i', '', $key);
			$font_name	= strtolower(str_replace(' ', '-', esc_attr($font_name)));
			$f_raw		= explode(':', $font);
			$weights	= array('400');
			$font_loaded = array();
			if(!empty($f_raw) && is_array($f_raw) && isset($f_raw[1])){
				//check if we are css2 or css format, if css, we need to modify $font to css2
				if(strpos($f_raw[1], ',') !== false && strpos($f_raw[1], ';') === false || intval($f_raw[1]) > 0){
					$f_raw[1]	= str_replace(array('%2C', 'wght', '@0,', ';0,', '@', '&family='), array(',', '', '', ',', '', ''), $f_raw[1]);
					$font = $f_raw[0].':';
					$weights = explode(',', $f_raw[1]);
					$collection = array('normal' => array(), 'italic' => array());
					foreach($weights ?? [] as $wk => $weight){
						$weight = strtolower($weight);
						if(strpos($weight, 'ital') !== false){
							$weight = str_replace(array('ital', 'italic'), '', $weight);
							if(intval($weight) === 0) $weight = 400;
							$collection['italic'][$weight] = $weight;
						}else{
							$collection['normal'][$weight] = $weight;
						}
					}

					if(!empty($collection['normal']) || !empty($collection['italic'])){
						$mgfirst = true;
						$italic = false;
						if(!empty($collection['italic'])){
							$font .= 'ital,';
							$italic = true;
						}
						$font .= 'wght@';

						$i = 0;
						$cycles = array('normal', 'italic');
						
						foreach($cycles as $cycle){
							$weight_values = $collection[$cycle];
							//var_dump($weight_values);
							if(empty($weight_values)) continue;

							asort($weight_values); //sort as we need to start from low to high

							foreach($weight_values as $weight){
								if(!$mgfirst) $font .= ';';

								$font .= ($italic === true) ? $i.','.$weight : $weight;
								$mgfirst = false;
							}
							$i++;
						}
					}
				}else{ //no /css2 process here as we seem to be /css
					$f_raw[1]	= str_replace(array('%2C', 'wght', '@0,', ';0,', '@', ';', '&family='), array(',', '', '', ',', '', ',', ''), $f_raw[1]);
					$weights	= explode(',', $f_raw[1]);
					foreach($weights ?? [] as $wk => $weight){
						if($weight === 'ital' || $weight === 'italic'){
							$weights[$wk] = 'italic';
							continue;
						}
						$weights[$wk] = intval($weight);
						if($weights[$wk] < 100) unset($weights[$wk]);
					}
				}
				if(empty($weights)) $weights = array('400');
				$weights = array_unique($weights);
			}
			
			foreach($types as $ftype => $options){
				if($load !== $ftype && $all === false) continue;
				$f_download = false;
				foreach($weights as $weight){
					$font_style = 'normal';
					if(intval($weight) === 0){
						$font_style	= preg_replace('/[0-9]+/', '', $weight);
						$weight	= preg_replace('/[a-zA-Z]+/', '', $weight);
						if(intval($weight) < 100) $weight = '400';
					}

					$_css = $this->get_val($fonts_css, array($font_name, $ftype, $weight, $font_style), false);
					if(!empty($_css) && is_array($_css)){
						foreach($_css as $uc => $fw){
							if(empty($fw) || !is_array($fw)) continue;
							
							foreach($fw as $_fw => $font_css){
								$start = strpos($font_css, '###BASE###');
								if($start === false) continue;
								$end = strpos($font_css, ')', $start + 10);
								$file_raw = substr($font_css, $start + 10, $end - ($start + 10));

								if(!is_file($base_dir.'/themepunch/gfonts/'. $file_raw) || filemtime($base_dir.'/themepunch/gfonts/'. $file_raw) < $tp_google_ts){
									$f_download = true;
									break;
								}
							}
						}
					}else{
						$f_download = true;
					}
				}

				if($f_download){
					if(!is_dir($base_dir.'/themepunch/')) mkdir($base_dir.'/themepunch/');
					if(!is_dir($base_dir.'/themepunch/gfonts/')) mkdir($base_dir.'/themepunch/gfonts/');
					if(!is_dir($base_dir.'/themepunch/gfonts/'.$font_name)) mkdir($base_dir.'/themepunch/gfonts/'.$font_name);

					$content = wp_safe_remote_get('https://fonts.googleapis.com/css2?family='.$font, $options);
					$body	 = $this->get_val($content, 'body', '');
					$body	 = explode('}', $body);

					if(!empty($body)){
						foreach($body as $b){
							if(preg_match("/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/", $b, $found_fonts)){
								$found_font	= rtrim($found_fonts[0], ')');
								$filename	= basename($found_font);
								$file_type	= wp_check_filetype($filename, $allowed_mime_types);
								if($this->get_val($file_type, 'ext', false) === false || $this->get_val($file_type, 'type', false) === false) continue;
								$found_fw	= (preg_match("/(?<=font-weight:)(.*)(?=;)/", $b, $found_fw)) ? trim($found_fw[0]) : '400';
								$found_fs	= (preg_match("/(?<=font-style:)(.*)(?=;)/", $b, $found_fs)) ? trim($found_fs[0]) : 'normal';
								$found_ur	= (preg_match("/(?<=\/\*)(.*)(?=\*\/)/", $b, $found_ur)) ? trim($found_ur[0]) : '';

								$found_ur	= (empty($found_ur)) ? 'all' : $found_ur;
								$found_fs	= ($found_fs !== 'normal') ? 'italic' : $found_fs;
								$found_fw	= (empty($found_fw)) ? '400' : $found_fw;
								$file		= $base_dir.'/themepunch/gfonts/'. $font_name . '/' . $filename;
								$_file		= '###BASE###'. $font_name . '/' . $filename;
								if(!in_array($filename, $font_loaded)){
									$tmp = download_url($found_font, 4);
									if(!is_wp_error($tmp)){
										if(!is_dir(dirname($file))) @mkdir(dirname($file));
										copy($tmp, $file);
										@unlink($tmp);
									}
									
									$font_loaded[] = $filename;
								}

								if(strpos($b, 'font-display') === false) $b .= '  font-display: swap;'."\n";
								
								if(!isset($fonts_css[$font_name]))									$fonts_css[$font_name] = array();
								if(!isset($fonts_css[$font_name][$ftype]))							$fonts_css[$font_name][$ftype] = array();
								if(!isset($fonts_css[$font_name][$ftype][$found_fw]))				$fonts_css[$font_name][$ftype][$found_fw] = array();
								if(!isset($fonts_css[$font_name][$ftype][$found_fw][$found_fs]))	$fonts_css[$font_name][$ftype][$found_fw][$found_fs] = array();
								$fonts_css[$font_name][$ftype][$found_fw][$found_fs][$found_ur]	= str_replace($found_font, $_file, $b . '}');
							}
						}
					}
				}

				if(!empty($weights) && is_array($weights)){
					if($style === true)	$ret .= '<style class="sr7-inline-css">';
					$format = ($ftype !== 'ttf') ? $ftype : 'truetype';
					foreach($weights as $weight){
						$font_style = 'normal';
						if(intval($weight) === 0){
							$font_style	= preg_replace('/[0-9]+/', '', $weight);
							$weight	= preg_replace('/[a-zA-Z]+/', '', $weight);
							if(intval($weight) < 100) $weight = '400';
						}
						//$_style	 = (strpos($weight, 'italic') !== false) ? 'italic' : 'normal';
						//$_weight = str_replace('italic', '', $weight);
						//$_weight = (empty(trim($_weight))) ? '400' : $_weight;
						$_css = $this->get_val($fonts_css, array($font_name, $ftype, $weight), false);
						if(!empty($_css) && is_array($_css)){
							foreach($_css as $uc => $fw){
								if(empty($fw) || !is_array($fw)) continue;
								
								foreach($fw as $_fw => $font_css){
									$ret .= str_replace('###BASE###', $base_url.'/themepunch/gfonts/', $font_css);
								}
							}
						}else{
							if(!isset($fonts_css[$font_name]))									$fonts_css[$font_name] = array();
							if(!isset($fonts_css[$font_name][$ftype]))							$fonts_css[$font_name][$ftype] = array();
							if(!isset($fonts_css[$font_name][$ftype][$weight]))					$fonts_css[$font_name][$ftype][$weight] = array();
							if(!isset($fonts_css[$font_name][$ftype][$weight][$font_style]))	$fonts_css[$font_name][$ftype][$weight][$font_style] = array();
							$fonts_css[$font_name][$ftype][$weight][$font_style]['all']	= '/* '.$weight.' does not exist  */';
						}
					}
					if($style === true)	$ret .= '</style>';
				}
			}
		}

		update_option('tp_font_css', $fonts_css);

		return $ret;
	}

	/**
	 * get the client browser with version
	 **/
	public function get_browser(){
		$u_agent	= $this->get_val($_SERVER, 'HTTP_USER_AGENT');
		$bname		= 'Unknown';
		$platform	= 'Unknown';
		$version	= '';
		$ub			= '';

		// get platform
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} elseif (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}

		// get name of useragent
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
			$bname = 'Internet Explorer';
			$ub = 'MSIE';
		} elseif(preg_match('/Firefox/i',$u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub = 'Firefox';
		} elseif(preg_match('/OPR/i',$u_agent))	{
			$bname = 'Opera';
			$ub = 'Opera';
		} elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edg/i',$u_agent)) {
			$bname = 'Google Chrome';
			$ub = 'Chrome';
		} elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edg/i',$u_agent)) {
			$bname = 'Apple Safari';
			$ub = 'Safari';
		} elseif(preg_match('/Netscape/i',$u_agent)) {
			$bname = 'Netscape';
			$ub = 'Netscape';
		} elseif(preg_match('/Edg/i',$u_agent)) {
			$bname = 'Edge';
			$ub = 'Edg';
		} elseif(preg_match('/Trident/i',$u_agent)) {
			$bname = 'Internet Explorer';
			$ub = 'MSIE';
		}

		// get version
		$known		= array('Version', $ub, 'other');
		$pattern	= '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)){ /* */ }
		// see how many we have
		$i			= count($matches['browser']);
		$version	= $this->get_val($matches, array('version', 0));
		if ($i != 1) {
			//we will have two since we are not using the 'other' argument yet
			//see if the version is before or after the name
			$version = (strripos($u_agent, 'Version') < strripos($u_agent,$ub)) ? $version : $this->get_val($matches, array('version', 1));
		}

		// check if we have a number
		if ($version == null || $version == '') $version = '0';

		return array(
			'name'		=> $bname,
			'version'	=> $version,
			'platform'	=> $platform
		);
    }

	/**
	 * get a collection of all used fonts, either in a grid or from the whole plugin
	 **/
	public function collect_used_fonts($save = true, $fetch_all = true, $page = 1){
		$used_fonts = get_option('tp-google-fonts-collect', array());
		$global_fonts = array();
		$more = false;
		$sr = new RevSliderSlider();
		$sl = new RevSliderSlide();

		//get all slider, init them and get subsets and get_used_fonts
		$page = intval($page);
		if($page <= 0) $page = 1;

		$sliders = $sr->get_sliders(false, $page);
		if(!empty($sliders)){
			foreach($sliders as $slider){
				$gfsub	= $slider->get_param('subsets', array());
				$gf		= $slider->get_used_fonts(false);
				if(!empty($gf)){
					foreach($gf as $handle => $data){
						if(!isset($global_fonts[$handle])) $global_fonts[$handle] = array();

						$variants = $this->get_val($data, 'variants', array());
						if(!empty($variants) && is_array($variants)){
							foreach($variants as $variant => $true){
								if(!in_array($variant, $global_fonts[$handle])) $global_fonts[$handle][] = $variant;
							}
						}
					}
				}
			}
			if(count($sliders) >= 50) $more = true;
		}

		if(!empty($global_fonts)){
			foreach($global_fonts as $handle => $variants){
				$url = $handle;
				if(!empty($variants) && is_array($variants)){
					sort($variants);
					$url .= ':'.implode(',', $variants);
				}
				if(!isset($used_fonts[$handle]))			$used_fonts[$handle] = array();
				if(!in_array($url, $used_fonts[$handle]))	$used_fonts[$handle][] = $url;
			}
		}
		
		if($fetch_all === true){
			if(class_exists('ThemePunch_Fonts') && method_exists('ThemePunch_Fonts', 'collect_used_fonts')){
				$esg_fonts = new ThemePunch_Fonts();
				$return = $esg_fonts->collect_used_fonts(false, false, $page);
				$fonts = $this->get_val($return, 'fonts', array());
				$_more = $this->get_val($return, 'more', false);
				if($_more === true) $more = true;
				//merge esg and revslider

				if(!empty($fonts)){
					foreach($fonts as $handle => $urls){
						if(empty($urls) || !is_array($urls)) continue;
						if (!isset($used_fonts[$handle]) ) $used_fonts[$handle] = array();
						if (!in_array($handle, $used_fonts[$handle])) {
							foreach($urls as $url){
								if(!in_array($url, $used_fonts[$handle])) $used_fonts[$handle][] = $url;
							}
						}
					}
				}
			}
		}

		$used_fonts = apply_filters('punchfonts_collect_fonts', $used_fonts);
		if($save === true) update_option('tp-google-fonts-collect', $used_fonts);

		return array('fonts' => $used_fonts, 'more' => $more);
	}


	public function download_collected_fonts($handle){
		if (empty($handle)) return;
		if (!is_array($handle)) $handle = (array)$handle;

		$collected	= get_option('tp-google-fonts-collect', array());

		foreach ($handle as $_handle) {
			if (!isset($collected[$_handle])) continue;

			$load = array();
			foreach($collected[$_handle] as $h){
				$load[$h] = $h;
			}

			$this->preload_fonts($load, false, true);
		}
	}
	

	/**
	 * Change FontURL to new URL (added for chinese support since google is blocked there)
	 * @since: 5.0
	 * @before: RevSliderFront::modify_punch_url()
	 */
	public function modify_fonts_url($url, $remove = true){
		$gs = $this->get_global_settings();
		$df = $this->get_val($gs, 'fonturl', '');
		$df = ($df !== '') ? $df : $url;

		return ($remove) ? $this->remove_http($df) : $df;
	}
	
	/**
	 * convert date to the date format that the user chose.
	 * @before: RevSliderFunctionsWP::convertPostDate();
	 */
	public function convert_post_date($date, $with_time = false){
		if(empty($date)) return $date;

		return ($with_time) ? date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($date)) : date_i18n(get_option('date_format'), strtotime($date));
	}
	
	
	/**
	 * return biggest value of object depending on which devices are enabled
	 * @since: 5.0
	 **/
	public function get_biggest_device_setting($obj, $enabled_devices, $default = '########'){
		$dv = $this->get_val($obj, array('d', 'v')); 
		if($this->get_val($enabled_devices, 'd') === true && $dv != '') return $dv;
		if($default !== '########') return $default;
		$nv = $this->get_val($obj, array('n', 'v'));
		if($this->get_val($enabled_devices, 'n') === true && $nv != '') return $nv;
		$tv = $this->get_val($obj, array('t', 'v'));
		if($this->get_val($enabled_devices, 't') === true && $tv != '') return $tv;
		$mv = $this->get_val($obj, array('m', 'v'));
		if($this->get_val($enabled_devices, 'm') === true && $mv != '') return $mv;
		
		return '';
	}

	/**
	 * return biggest value of object depending on which devices are enabled
	 * @since: 5.0
	 **/
	public function get_biggest_device_setting_v7($obj, $enabled_devices, $default = '########'){
		$devices = array('ld', 'd', 'n', 't', 'm');
		foreach($devices as $key => $device){
			if($this->get_val($enabled_devices, $device) === true && !in_array($obj[$key], array('', '#a'))) return $obj[$key];
		}

		return ($default !== '########') ? $default : $obj[1];
	}

	/**
	 * return biggest value of object depending on which devices are enabled
	 * @since: 5.0
	 **/
	public function get_biggest_size_setting_v7($obj, $enabled_devices, $default = '########'){
		$devices = array('ld', 'd', 'n', 't', 'm');
		$biggest = false;

		foreach($devices as $key => $device){
			if($this->get_val($enabled_devices, $device) === true && !in_array($obj[$key], array('', '#a'))) if($biggest === false || intval($obj[$key]) > $biggest) $biggest = $obj[$key];
		}

		return ($biggest === false && $default !== '########') ? $default : intval($biggest);
	}
	
	
	/**
	 * normalize object with device informations depending on what is enabled for the Slider
	 * @since: 5.0
	 **/
	public function normalize_device_settings($obj, $enabled_devices, $return = 'obj', $default = array(), $set_to_if = array(), $use = ','){ //array -> from -> to
		/*d n t m*/
		$obj			= $this->fill_device_settings($obj);
		$_def			= (!empty($default)) ? reset($default) : '########';
		$inherit_size	= $this->get_biggest_device_setting($obj, $enabled_devices, $_def);
		
		if(!empty($set_to_if)){
			foreach($obj as $device => $key){
				foreach($set_to_if as $from => $to){
					if(trim($this->get_val($obj, array($device, 'v'))) == $from) $obj[$device]['v'] = $to;
				}
			}
		}

		$device_types = array('d', 'n', 't', 'm');
		foreach($device_types as $device){
			if($enabled_devices[$device] === true){
				$value = $this->get_val($obj, [$device, 'v'], '');
				if($value === ''){
					$obj[$device]['v'] = ($_def !== '########') ? $_def : $inherit_size;
				}else{
					$inherit_size = $value;
				}
			}else{
				$obj[$device]['v'] = $inherit_size;
			}
		}
	
		switch ($return) {
			case 'obj':
				return array(
					'd' => $obj['d']['v'],
					'n' => $obj['n']['v'],
					't' => $obj['t']['v'],
					'm' => $obj['m']['v']
				);
			case 'html-array':
				$html_array = ($obj['d']['v'] === $obj['n']['v'] && $obj['d']['v'] === $obj['m']['v'] && $obj['d']['v'] === $obj['t']['v']) ? $obj['d']['v'] : implode($use, array_column($obj, 'v'));

				return (!empty($default) && in_array($html_array, $default)) ? '' : $html_array;
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
			return $obj;
		}
		
		$_obj = array();
		foreach($push as $p){
			$_obj[$p] = (!isset($obj[$p])) ? array() : $obj[$p];
			if(!isset($_obj[$p]['v'])){
				$_obj[$p]['v'] = '';
				$_obj[$p]['u'] = '';
			}
		}
		
		return $_obj;
	}

	/**
	 * get the values for the given transition
	 **/
	public function get_slide_transition_values($transition, $base_transitions = array()){
		if(empty($base_transitions)) $base_transitions = $this->get_base_transitions();
		foreach($base_transitions as $t){
			if(!is_array($t)) continue;
			foreach($t as $_t){
				if(!is_array($_t)) continue;
				foreach($_t as $name => $values){
					if($name !== $transition) continue;
					
					return $values;
				}
			}
		}
		return array();
	}
	
	
	/**
	 * get a random slide transition for the given main and grp
	 **/
	public function get_random_slide_transition($main, $grp, $base_transitions = array()){
		if(empty($base_transitions)) $base_transitions = $this->get_base_transitions();
		
		if(!is_array($grp) && !empty($grp)) $grp = explode(',', $grp);
		if($grp === '') $grp = array();
		
		$items = array();
		foreach($base_transitions as $m => $bt){
			if(!is_string($m) || $m === 'random' || $m === 'custom' || ($main !== 'all' && $main !== $m)) continue;
			foreach($bt as $g => $_bt){
				if(is_array($_bt) && $g !== 'icon' && (empty($grp) || in_array($g, $grp))){
					foreach($_bt as $e => $__bt){
						$items[] = $e;
					}
				}
			}
		}
		
		$num = (!empty($items)) ? array_rand($items, 1) : false;
		return ($num !== false) ? $items[$num] : '';
	}
	
	
	/**
	 * set the tp_google_font to current date, so that it will be redownloaded
	 * @before: RevSliderOperations::deleteGoogleFonts();
	 */
	public function delete_google_fonts(){
		update_option('tp_google_font', time());
		update_option('tp_font_css', array());
		update_option('tp-google-fonts-collect', array());
	}
	
	
	/**
	 * Remove http:// and https://
	 * @since: 6.0.0
	 **/
	public function remove_http($url, $special = 'auto'){
		switch($special){
			case 'http':
				$url = str_replace('https://', 'http://', $url);
				if(strpos($url, 'http://') === false) $url = 'http://'.$url;
			break;
			case 'https':
				$url = str_replace('http://', 'https://', $url);
				if(strpos($url, 'https://') === false) $url = 'https://'.$url;
			break;
			case 'keep': //do nothing
			break;
			case 'auto':
			default:
				$url = str_replace(array('http://', 'https://'), '//' , $url);
			break;
		}
		return $url;
	}

	/**
	 * set the memory limit to at least 256MB if possible
	 * @since: 6.1.6
	 **/
	public static function set_memory_limit(){
		wp_raise_memory_limit('revslider');
	}
	
	
	/**
	 * Check if page is edited in Gutenberg
	 */
	public function _is_gutenberg_page(){
		if(isset($_GET['action']) && $_GET['action'] == 'elementor') return false; // Elementor Page Edit
		if(isset($_GET['vc_action']) && $_GET['vc_action'] == 'vc_inline') return false; // WP Bakery Front Edit
		if(function_exists('is_gutenberg_page') && is_gutenberg_page()) return true; // Gutenberg Edit with WP < 5
		$current_screen = get_current_screen();
		if(!empty($current_screen) && method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor()) return true; //Gutenberg Edit with WP >= 5
		
		return false;
	}
	
	
	
	/**
	 * get custom transitions
	 **/
	public function get_custom_slidetransitions(){
		$custom = get_option('revslider_template_slidetransitions', array());
		
		return apply_filters('rs_get_custom_slidetransitions', $custom);
	}
	
	
	/**
	 * get custom transitions
	 **/
	public function save_custom_slidetransitions($template){
		$custom = $this->get_custom_slidetransitions();
		
		//empty custom templates?
		if(empty($custom)){
			$custom = array();
			$new_id = 1;
		}else{
			$id = $this->get_val($template, 'id', 0);
			//custom templates exist
			$new_id = ($id > 0) ? $id : max(array_keys($custom)) + 1;
		}
		
		//update or insert template
		$custom[$new_id]['title']	= $template['obj']['title'];
		$custom[$new_id]['preset']	= $template['obj']['preset'];
		//return the ID the template was saved with
		return (update_option('revslider_template_slidetransitions', $custom)) ? $new_id : false;
	}
	
	
	/**
	 * get custom transitions
	 **/
	public function delete_custom_slidetransitions($template){
		//load templates array
		$custom = $this->get_custom_slidetransitions();
		
		$id = intval($this->get_val($template, 'id', 0));
		//custom template exist
		if($id > 0 && isset($custom[$id])){
			//delete given ID
			unset($custom[$id]);
			//save the resulting templates array again
			if(update_option('revslider_template_slidetransitions', $custom)) return true;	
		}
		
		return false;
	}
	/**
	 * push the matieral icons css into the global variable
	 **/
	public function add_material_icons(){
		global $SR_GLOBALS;
		if($this->get_val($SR_GLOBALS, array('icon_sets', 'Materialicons', 'css'), false) !== false) return '';

		$gs = $this->get_global_settings();

		if($this->get_val($gs, 'fontdownload', 'off') === 'off'){
			$font_face = "@font-face {
  font-family: 'Material Icons';
  font-style: normal;
  font-weight: 400;  
  src: url(//fonts.gstatic.com/s/materialicons/v41/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.woff2) format('woff2');
}";
		}else{
			$font_face = "@font-face {
font-family: 'Material Icons';
font-style: normal;
font-weight: 400;  

src: local('Material Icons'),
local('MaterialIcons-Regular'),
  url(".RS_PLUGIN_URL_CLEAN."sr6/assets/fonts/material/MaterialIcons-Regular.woff2) format('woff2'),
  url(".RS_PLUGIN_URL_CLEAN."sr6/assets/fonts/material/MaterialIcons-Regular.woff) format('woff'),  
url(".RS_PLUGIN_URL_CLEAN."sr6/assets/fonts/material/MaterialIcons-Regular.ttf) format('truetype');
}";
		}

		$this->set_val($SR_GLOBALS, array('icon_sets', 'Materialicons', 'css'), "/* 
ICON SET 
*/
".$font_face."

rs-module .material-icons {
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
}");
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
	 * this will return the exact alias of the rev_slider modules on given posts/pages
	 **/
	public function get_shortcode_from_page($ids){
		$_shortcodes = array();
		$ids		 = (!is_array($ids)) ? (array)$ids : $ids;

		foreach($ids as $id){
			$post = get_post($id);
			$sc = array();
			if(is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'rev_slider') || has_shortcode($post->post_content, 'sr7'))){
				preg_match_all('/\[sr7.*alias=.(.*)"\]/', $post->post_content, $shortcodes);
				preg_match_all('/\[rev_slider.*alias=.(.*)"\]/', $post->post_content, $shortcodesold);
				if(isset($shortcodes[1]) && $shortcodes[1] !== '') $sc = $shortcodes[1];
				if(isset($shortcodesold[1]) && $shortcodesold[1] !== '') $sc = array_merge($sc, $shortcodesold[1]);
				
				if(!empty($sc)){
					foreach($sc as $k => $s){
						if(strpos($s, '"') !== false) $s = $this->get_val(explode('"', $s), 0);
						if(!in_array($s, $_shortcodes)) $_shortcodes[] = $s;
					}
				}
			}
		}
		
		return $_shortcodes;
	}

	/**
	 * open and checks a zip file for filetypes
	 **/
	public function check_bad_files($zip_file, $extensions_allowed = false){
		global $SR_GLOBALS;
		if(class_exists('ZipArchive')){
			$zip = new ZipArchive;
			$success = $zip->open($zip_file);
			
			if($success !== true) $this->throw_error(__("Can't open zip file", 'revslider'));

			for($i = 0; $i < $zip->numFiles; $i++){
				$path_info = pathinfo($zip->getNameIndex($i));
				if(!isset($path_info['extension'])) continue;
			
				$pi = strtolower($path_info['extension']);
				if($extensions_allowed !== false){
					if(!in_array($pi, $extensions_allowed)) $this->throw_error(__("zip file contains illegal files", 'revslider'));
				}else{
					if(in_array($pi, $SR_GLOBALS['bad_extensions'])) $this->throw_error(__("zip file contains illegal files", 'revslider'));
				}
			}
		}else{ //fallback to pclzip
			require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
			
			$pclzip = new PclZip($zip_file);
			
			$content = $pclzip->listContent();
			if(is_array($content) && !empty($content)){
				foreach($content as $file){
					if(!isset($file['filename'])) continue;

					$path_info = pathinfo($file['filename']);
					if(!isset($path_info['extension'])) continue;

					$pi = strtolower($path_info['extension']);
					if($extensions_allowed !== false){
						if(!in_array($pi, $extensions_allowed)) $this->throw_error(__("zip file contains illegal files", 'revslider'));
					}else{
						if(in_array($pi, $SR_GLOBALS['bad_extensions'])) $this->throw_error(__("zip file contains illegal files", 'revslider'));
					}
				}
			}
		}
	}
	
	/**
	 * generate missing attachement metadata for images
	 * @since: 6.0
	 **/
	public function generate_attachment_metadata(){
		$rs_meta_create = get_option('rs_image_meta_todo', array());
		
		if(!empty($rs_meta_create)){
			foreach($rs_meta_create as $attach_id => $save_dir){
				unset($rs_meta_create[$attach_id]);
				update_option('rs_image_meta_todo', $rs_meta_create);

				if($attach_data = @wp_generate_attachment_metadata($attach_id, $save_dir)){
					@wp_update_attachment_metadata($attach_id, $attach_data);
				}
			}
		}
	}
	
	/**
	 * set the font clean for import
	 * @before: RevSliderOperations::setCleanFontImport()
	 */
	public function set_clean_font_import($font, $class = '', $url = '', $variants = array(), $subsets = array()){
		global $SR_GLOBALS;
		
		if(!isset($SR_GLOBALS['fonts'])) $SR_GLOBALS['fonts'] = array('queue' => array(), 'loaded' => array()); //if this is called without revslider.php beeing loaded
		
		if(!empty($variants) || !empty($subsets)){
			if(!isset($SR_GLOBALS['fonts']['queue'][$font])) $SR_GLOBALS['fonts']['queue'][$font] = array();
			if(!isset($SR_GLOBALS['fonts']['queue'][$font]['variants'])) $SR_GLOBALS['fonts']['queue'][$font]['variants'] = array();
			if(!isset($SR_GLOBALS['fonts']['queue'][$font]['subsets'])) $SR_GLOBALS['fonts']['queue'][$font]['subsets'] = array();
			
			if(!empty($variants)){
				foreach($variants as $k => $v){
					//check if the variant is already in loaded
					if(!in_array($v, $SR_GLOBALS['fonts']['queue'][$font]['variants'], true)){
						$SR_GLOBALS['fonts']['queue'][$font]['variants'][] = $v;
					}else{ //already included somewhere, so do not call it anymore
						unset($variants[$k]);
					}
				}
			}
			if(!empty($subsets)){
				foreach($subsets as $k => $v){
					if(!in_array($v, $SR_GLOBALS['fonts']['queue'][$font]['subsets'], true)){
						$SR_GLOBALS['fonts']['queue'][$font]['subsets'][] = $v;
					}else{ //already included somewhere, so do not call it anymore
						unset($subsets[$k]);
					}
				}
			}
			if($url !== ''){
				$SR_GLOBALS['fonts']['queue'][$font]['url'] = $url;
			}
		}
	}

	
	/**
	 * get categories list, copy the code from default wp functions
	 * @before: RevSliderFunctionsWP::getCategoriesHtmlList();
	 */
	public function get_categories_html($cat_ids, $tax = null, $post_id = '', $full = false){
		global $wp_rewrite;

		if(!empty($post_id) && $full === false) return get_the_category_list(', ', null, $post_id);
		
		$categories	= ($full === true && !empty($cat_ids)) ? $cat_ids :  $this->get_categories_by_id($cat_ids, $tax);
		$errors		= $this->get_val($categories, 'errors');
		$list		= array();
		$err		= '';
		$rel 		= (is_object($wp_rewrite) && $wp_rewrite->using_permalinks()) ? 'rel="category tag"' : 'rel="category"';
		
		if(!empty($errors)){
			foreach($errors as $error){
				$err .= implode(',', $error);
			}
			$this->throw_error(__('retrieving categories error: '.esc_html($err)));
		}
		
		foreach($categories as $category){
			$link = get_category_link($this->get_val($category, 'term_id'));
			$name = $this->get_val($category, 'name');

			$list[] = (!empty($link)) ? '<a href="' . esc_url($link) . '" title="' . esc_attr(sprintf(__('View all posts in %s', 'revslider'), $name)) .'" '. $rel .'>'. $name .'</a>' : $name;
		}

		return (!empty($list)) ? implode(', ', $list) : '';
	}

	/**
	 * get text intro, limit by number of words
	 * @before: RevSliderFunctionsWP::getTextIntro();
	 */
	public function get_text_intro($text, $limit){
		$limit++;
		$array = explode(' ', $text, $limit);
		
		if(count($array) >= $limit){
			array_pop($array);
			$intro = implode(' ', $array);
			$intro = trim($intro);
			$intro .= (!empty($intro)) ? '...' : '';
		}else{
			$intro = $text;
		}
		
		return preg_replace('`\[[^\]]*\]`', '', $intro);
	}
	
	/**
	 * get text intro, limit by number of words
	 * @before: RevSliderFunctionsWP::getTextIntro();
	 */
	public function get_text_intro_chars($text, $limit){
		$intro = substr($text, 0, $limit);
		return preg_replace('`\[[^\]]*\]`', '', $intro);
	}

	/**
	 * convert assoc array to array
	 */
	public static function assoc_to_array($assoc){
		return array_values($assoc ?? []);
	}

	/**
	 * filter non-allowed chars for html classes / IDs
	 * 
	 * @param array|string $classes
	 * @return array|string
	 */
	public function filter_class_name($classes)
	{
		$single = false;
		if(!is_array($classes)) {
			$classes = [$classes];
			$single = true;
		}

		$classes = array_map(function($className) {
			return preg_replace('/[^a-zA-Z \d_-]/', '', $className);
		}, $classes);

		return $single ? $classes[0] : $classes;
	}

	public function truncate_v7(){
		global $wpdb;
		$wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . RevSliderFront::TABLE_SLIDER."7");
		$wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . RevSliderFront::TABLE_SLIDES."7");
		$this->reset_v7_slide_id_map();
		$this->reset_v7_migration_failed_map();
		$upd = new RevSliderPluginUpdate();
		$upd->move_folder();
		//$wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES."7");
	}

	
	/**
	 * get a map of slide ids for v7 slides
	 * we need this in the process to migrate v7 slides
	 * as we merge normal and static slides here
	 **/
	public function get_v7_slider_map($v6_slider_id = false, $v6_slide_id = false){
		$slide_map 	= get_option('sliderrevolution-v7-slide-map', array());
		$update		= false;

		if(empty($slide_map)) $update = true;
		//if($v6_slider_id !== false && intval($v6_slider_id) === 0) return;
		if($v6_slider_id !== false && !isset($slide_map[$v6_slider_id])) $update = true;
		if($v6_slide_id !== false){
			if($this->get_v7_slide_map($v6_slide_id) === false) $update = true;
		}

		if($update === true) $slide_map = $this->update_v7_slide_id_map();

		if($v6_slider_id === false && $v6_slide_id === false) return $slide_map;
		if(empty($slide_map)) return false;

		if($v6_slider_id !== false){
			return (!isset($slide_map[$v6_slider_id])) ? false : $slide_map[$v6_slider_id];
		}else{
			$v7_slide_id = $this->get_v7_slide_map($v6_slide_id);
			if($v7_slide_id !== false) return $v7_slide_id;
		}

		return false;
	}

	/**
	 * retrieves the v7 slide id by a v6 slide id from the slide map
	 **/
	public function get_v7_slide_map($v6_slide_id){
		$slide_map 	= get_option('sliderrevolution-v7-slide-map', array());
		if(empty($slide_map)) return false;

		$_type = (strpos($v6_slide_id, 'static_') !== false) ? 's' : 'n';
		$v6_slide_id = str_replace('static_', '', $v6_slide_id);
		foreach($slide_map as $v6_sid => $type){
			foreach($type as $t => $v){
				if($t !== $_type) continue;
				if(isset($v[$v6_slide_id])) return $v[$v6_slide_id];
			}
		}

		return false;
	}

	/**
	 * this will remove a v6 slider in total or a v6 slide id from the map
	 **/
	public function remove_v7_slider_from_map($v6_slider_id = false, $v6_slide_id = false){
		$slide_map = get_option('sliderrevolution-v7-slide-map', array());
		if(empty($slide_map)) return true;

		if($v6_slider_id !== false){
			if(!isset($slide_map[$v6_slider_id])) return true;

			unset($slide_map[$v6_slider_id]);
			update_option('sliderrevolution-v7-slide-map', $slide_map);

			return true;
		}else{
			$_type = (strpos('static_', $v6_slide_id) !== false) ? 's' : 'n';
			$v6_slide_id = str_replace('static_', '', $v6_slide_id);
			foreach($slide_map as $v6_sid => $type){
				foreach($type as $t => $v){
					if($t !== $_type) continue;
					if(!isset($v[$v6_slide_id])) continue;

					unset($slide_map[$v6_sid][$_type][$v6_slide_id]);
					update_option('sliderrevolution-v7-slide-map', $slide_map);

					return true;
				}
			}
		}

		return false;
	}

	/**
	 * reset the slide map, by deleting all entries in it
	 **/
	public function reset_v7_slide_id_map(){
		$slide_map = array();
		update_option('sliderrevolution-v7-slide-map', $slide_map);
	}

	/**
	 * get the migration failed map
	 **/
	public function get_v7_migration_failed_map(){
		return get_option('sliderrevolution-v7-migration-failed-map', array());
	}
	
	/**
	 * create/update the map of slide ids for v7 slides
	 **/
	public function update_v7_migration_failed_map($sid, $text){
		$sid = intval($sid);
		if($sid === 0) return;

		$mig_failed = $this->get_v7_migration_failed_map();
		$mig_failed[$sid] = substr($text, 0, 300);

		update_option('sliderrevolution-v7-migration-failed-map', $mig_failed);
	}

	/**
	 * reset the migration failed map, by deleting all entries in it
	 **/
	public function reset_v7_migration_failed_map(){
		$failed_map = array();
		update_option('sliderrevolution-v7-migration-failed-map', $failed_map);
	}

	/**
	 * create/update the map of slide ids for v7 slides
	 **/
	public function update_v7_slide_id_map(){
		global $wpdb;

		$slide_map = get_option('sliderrevolution-v7-slide-map', array());
		
		$v6 = array();
		$v6[] = array('static' => false, 'slides' => $wpdb->get_results("SELECT `id`, `slider_id` FROM ".$wpdb->prefix . RevSliderFront::TABLE_SLIDES." ORDER BY id, slider_id, slide_order ASC", ARRAY_A));
		if(empty($v6[0]['slides'])) return $slide_map;
		$v6[] = array('static' => true, 'slides' => $wpdb->get_results("SELECT `id`, `slider_id` FROM ".$wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES." ORDER BY id, slider_id ASC", ARRAY_A));

		//$v7 = $wpdb->get_results("SELECT `id`, `slider_id`, `slide_order` FROM ".$wpdb->prefix . RevSliderFront::TABLE_SLIDES."7 ORDER BY id, slider_id, slide_order ASC", ARRAY_A);
		//$all_v7_static_slides	= $wpdb->get_results($wpdb->prepare("SELECT `id`, `slider_id` FROM ".$wpdb->prefix . RevSliderFront::TABLE_STATIC_SLIDES."7 ORDER BY id, slider_id ASC"), ARRAY_A);

		if(empty($slide_map)){
			$this->truncate_v7();
			$result = $wpdb->get_row("SHOW TABLE STATUS LIKE '".$wpdb->prefix . RevSliderFront::TABLE_SLIDES."7'");
			$v7_next_increment = intval($this->get_val($result, 'Auto_increment', 1));
		}else{
			$v7_next_increment = 0;
			foreach($slide_map as $sid => $slides){
				foreach($slides as $slide){
					if(empty($slide)) continue;
					foreach($slide as $v7id){
						if($v7id > $v7_next_increment) $v7_next_increment = $v7id;
					}
				}
			}
			$v7_next_increment++;
		}

		foreach($v6 as $v6_slides){
			foreach($v6_slides['slides'] as $v6_slide){
				$found = false;
				//search if $v6_slide['id'] exists in oid already
				if(!empty($slide_map)){
					foreach($slide_map as $map){
						foreach($map as $type => $slides){
							if(empty($slides)) continue;
							if(!isset($slides[$v6_slide['id']])) continue;
							if($v6_slides['static'] === true && $type !== 's') continue;
							if($v6_slides['static'] === false && $type !== 'n') continue;
							$found = true;
							break;
						}
						if($found === true) break;
					}
				}
				if($found !== false) continue; //already registered
				
				if(!isset($slide_map[$v6_slide['slider_id']])) $slide_map[$v6_slide['slider_id']] = array('s' => array(), 'n' => array());

				$k = ($v6_slides['static'] === true) ? 's' : 'n';
				$slide_map[$v6_slide['slider_id']][$k][$v6_slide['id']] = $v7_next_increment;

				$v7_next_increment++;
			}
		}
		
		//create/update a mapping of v7
		update_option('sliderrevolution-v7-slide-map', $slide_map);

		return $slide_map;
	}

	public function add_deprecation_message($old_func, $new_func){
		global $SR_GLOBALS;

		if(isset($SR_GLOBALS['deprecated'][$old_func])) return;
		//_deprecated_function($old_func, '7.0', $new_func);
		$SR_GLOBALS['deprecated'][$old_func] = $new_func;
	}
	
	/**
	 * Add Meta Generator Tag in FrontEnd
	 * @since: 5.4.3
	 * @before: add_setREVStartSize()
		//NOT COMPRESSED VERSION
		function setREVStartSize(e){	
			//window.requestAnimationFrame(function() {	
				window.RSIW = window.RSIW===undefined ? window.innerWidth : window.RSIW;	
				window.RSIH = window.RSIH===undefined ? window.innerHeight : window.RSIH;	
				try {								
					var pw = document.getElementById(e.c).parentNode.offsetWidth,
						newh;
					pw = pw===0 || isNaN(pw) || (e.l=="fullwidth" || e.layout=="fullwidth") ? window.RSIW : pw;
					e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
					e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
					e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
					e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
					e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
					e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
					e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);
					if(e.layout==="fullscreen" || e.l==="fullscreen")
						newh = Math.max(e.mh,window.RSIH);
					else{					
						e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
						for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];
						e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
						e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
						for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];
											
						var nl = new Array(e.rl.length),
							ix = 0,
							sl;
						e.tabw = e.tabhide>=pw ? 0 : e.tabw;
						e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
						e.tabh = e.tabhide>=pw ? 0 : e.tabh;
						e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;
						for (var i in e.rl) nl[i] = e.rl[i]<window.RSIW ? 0 : e.rl[i];
						sl = nl[0];									
						for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}
						var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);
						newh =  (e.gh[ix] * m) + (e.tabh + e.thumbh);
					}				
					var el = document.getElementById(e.c);
					if (el!==null && el) el.style.height = newh+"px";
					el = document.getElementById(e.c+"_wrapper");
					if (el!==null && el) el.style.height = newh+"px";
				} catch(e){
					console.log("Failure at Presize of Slider:" + e)
				}
			//}
		  };
	 */
	public static function js_set_start_size(){
		global $revslider_rev_start_size_loaded;
		if($revslider_rev_start_size_loaded === true) return false;
		
		$script = '<script>';
		$script .= 'function setREVStartSize(e){
			//window.requestAnimationFrame(function() {
				window.RSIW = window.RSIW===undefined ? window.innerWidth : window.RSIW;
				window.RSIH = window.RSIH===undefined ? window.innerHeight : window.RSIH;
				try {
					var pw = document.getElementById(e.c).parentNode.offsetWidth,
						newh;
					pw = pw===0 || isNaN(pw) || (e.l=="fullwidth" || e.layout=="fullwidth") ? window.RSIW : pw;
					e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
					e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
					e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
					e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
					e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
					e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
					e.mh = e.mh===undefined || e.mh=="" || e.mh==="auto" ? 0 : parseInt(e.mh,0);
					if(e.layout==="fullscreen" || e.l==="fullscreen")
						newh = Math.max(e.mh,window.RSIH);
					else{
						e.gw = Array.isArray(e.gw) ? e.gw : [e.gw];
						for (var i in e.rl) if (e.gw[i]===undefined || e.gw[i]===0) e.gw[i] = e.gw[i-1];
						e.gh = e.el===undefined || e.el==="" || (Array.isArray(e.el) && e.el.length==0)? e.gh : e.el;
						e.gh = Array.isArray(e.gh) ? e.gh : [e.gh];
						for (var i in e.rl) if (e.gh[i]===undefined || e.gh[i]===0) e.gh[i] = e.gh[i-1];
											
						var nl = new Array(e.rl.length),
							ix = 0,
							sl;
						e.tabw = e.tabhide>=pw ? 0 : e.tabw;
						e.thumbw = e.thumbhide>=pw ? 0 : e.thumbw;
						e.tabh = e.tabhide>=pw ? 0 : e.tabh;
						e.thumbh = e.thumbhide>=pw ? 0 : e.thumbh;
						for (var i in e.rl) nl[i] = e.rl[i]<window.RSIW ? 0 : e.rl[i];
						sl = nl[0];
						for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}
						var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);
						newh =  (e.gh[ix] * m) + (e.tabh + e.thumbh);
					}
					var el = document.getElementById(e.c);
					if (el!==null && el) el.style.height = newh+"px";
					el = document.getElementById(e.c+"_wrapper");
					if (el!==null && el) {
						el.style.height = newh+"px";
						el.style.display = "block";
					}
				} catch(e){
					console.log("Failure at Presize of Slider:" + e)
				}
			//});
		  };';
		$script .= '</script>' . "\n";
		echo apply_filters('revslider_add_setREVStartSize', $script);
		
		$revslider_rev_start_size_loaded = true;
	}

	public function set_html_id_v7($html_id, $check_for_duplication){
		global $SR_GLOBALS;

		if($check_for_duplication){ //check if it already exists, if yes change it and add attribute for console output
			$ids = $this->get_val($SR_GLOBALS, array('collections', 'ids'));
			if(in_array($html_id, $ids, true)){
				$i = 0;
				do{$i++; }while(in_array($html_id.'_'.$i, $ids, true));
				$html_id .= '_'.$i;
			}
		}
		if(!in_array($html_id, $SR_GLOBALS['collections']['ids'])) $SR_GLOBALS['collections']['ids'][] = $html_id;

		return $html_id;
	}
}
