<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderSliderExportHtml extends RevSliderSliderExport {
	public $path_fonts		= 'fonts/';
	public $path_css		= 'public/css/';
	public $path_js			= 'public/js/';
	public $path_assets		= 'assets';
	public $path_assets_raw	= 'assets';
	public $path_assets_vid	= 'assets';
	public $path_assets_raw_vid	= 'assets';
	public $json			= '';
	public $slider;
	public $html_id;
	
	public function __construct(){
		parent::__construct();
	}


	public function export_slider_html($slider_id){
		if($slider_id == 'empty_output'){
			echo __('Wrong request!', 'revslider');
			exit;
		}

		$this->create_export_zip();

		global $SR_GLOBALS;
		$SR_GLOBALS['use_table_version'] = 7;

		$this->slider = new RevSliderSlider();
		$this->slider->init_by_id($slider_id);

		if($this->slider->v7 === false){
			echo __('Not yet migrated to V7!', 'revslider');
			exit;
		}

		if($this->slider->get_param('prem', false) === true && $this->_truefalse(get_option('revslider-valid', 'false')) === false){
			echo __('Wrong request!', 'revslider');
			exit;
		}

		$this->slider = apply_filters('revslider_doing_html_export', $this->slider, $slider_id, $this);

		$this->slider_title	= $this->slider->get_title();
		$this->slider_alias	= $this->slider->get_alias();
		$this->layouttype	= $this->slider->get_param('layouttype');
		$this->slider_output = new RevSlider7Output();

		ob_start();
		$this->slider_output->set_slider_id($slider_id);
		$this->slider_output->set_markup_export(true);
		$this->slider_output->add_slider_base();
		$this->slider_html = ob_get_contents();
		ob_clean();
		ob_end_clean();
		
		ob_start();
		$this->write_header_html();
		$head = ob_get_contents();
		ob_clean();
		ob_end_clean();

		ob_start();
		$this->write_footer_html();
		$footer = ob_get_contents();
		ob_clean();
		ob_end_clean();

		ob_start();
		$this->slider_output->add_js();
		$additions = ob_get_contents();
		ob_clean();
		ob_end_clean();

		$this->slider_html = $head . "\n" . $this->slider_html . "\n" . $additions . "\n" . $footer;
		
		$this->add_json_to_html();
		$this->replace_export_html_urls();
		$this->remove_json_from_html();
		$this->add_export_json_to_zip();
		$this->add_export_html_to_zip();
		$this->push_zip_to_client();
		$this->delete_export_zip();
		exit;
	}

	/**
	 * create Header HTML for HTML export
	 **/
	public function write_header_html(){
		global $SR_GLOBALS;
		$global = $this->get_global_settings();
		//JSON needs to be added here
		?>
<!DOCTYPE html>
<html lang="en-US" class="no-js">
	<head>	
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>SR7 - EXPORT</title>

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
		<link rel='stylesheet' id='sr7css-css' href='<?php echo $this->path_css; ?>sr7.css' media='all' />

		<script src="<?php echo $this->path_js; ?>libs/tptools.js" id="_tpt-js" async></script>
		<script src="<?php echo $this->path_js; ?>sr7.js" id="sr7-js" async></script>
		<script src="<?php echo $this->path_js; ?>page.js" id="sr7-page-js" async></script>

		<?php
		//JSON is not created, so manually add it to the RevSliderFront instance
		$sid		= $this->slider->get_id();
		$slider_id	= $this->slider->get_param('id', '');
		$this->html_id	= (trim($slider_id) !== '') ? $slider_id : 'SR7_'.$sid.'_'.$SR_GLOBALS['serial'];

		$sr_front = RevSliderGlobals::instance()->get('RevSliderFront');
		
		$data = $this->slider->get_full_slider_JSON();
		$data = apply_filters('sr_load_slider_json', $data, $this);
		$this->json = json_encode($data);

		echo $sr_front->js_add_header_scripts();
		
		do_action('revslider_export_html_write_header', $this);
		?>
	</head>
	
	<body><?php
	}

	/**
	 * create Footer HTML for HTML export
	 **/
	public function write_footer_html(){
		global $SR_GLOBALS;
		if(!empty($SR_GLOBALS['collections']['css'])){
			$custom_css = implode("\n".RS_T2, $SR_GLOBALS['collections']['css']);
			$css = RevSliderGlobals::instance()->get('RevSliderCssParser');
			echo '<style>';
			echo $css->compress_css($custom_css);
			echo '</style>'."\n";
		}

		do_action('revslider_export_html_write_footer', $this);
		?>
		</body>
	</html>
		<?php
	}

	/**
	 * JSON needs tobe added as only slider_html will be checked for images and so on.
	 * After that image and so on process, remove it again
	 */
	public function add_json_to_html(){
		$this->slider_html .= '<!-- TEMPJSON -->'.$this->json.'<!-- /TEMPJSON -->';
	}

	public function remove_json_from_html(){
		$json		= substr($this->slider_html, strpos($this->slider_html, '<!-- TEMPJSON -->'), strpos($this->slider_html, '<!-- /TEMPJSON -->') + 18 - strpos($this->slider_html, '<!-- TEMPJSON -->'))."\n";
		$json		= str_replace(array('<!-- TEMPJSON -->', '<!-- /TEMPJSON -->'), '', $json);
		$starthtml	= substr($this->slider_html, 0, strpos($this->slider_html, '<!-- TEMPJSON -->'));
		$endhtml	= substr($this->slider_html, strpos($this->slider_html, '<!-- /TEMPJSON -->') + 18);
		$this->slider_html = $starthtml.$endhtml; //remove from html markup
		$this->json = $json;
	}

	/**
	 * replace the URLs in the HTML to local URLs for exporting, this will also push the files into the zip file
	 **/
	public function replace_export_html_urls(){
		$added				= array();
		$replace			= array();
		$upload_dir			= $this->get_upload_path();
		$upload_dir_multi	= wp_upload_dir();
		$cont_url			= $this->get_val($upload_dir_multi, 'baseurl');
		$cont_url_no_www	= str_replace('www.', '', $cont_url);
		$upload_dir_multi	= $this->get_val($upload_dir_multi, 'basedir').'/';
		
		//remove header path
		$urls = array(
			admin_url('admin-ajax.php'),
			get_rest_url(),
			str_replace(array("\n", "\r"), '', RS_PLUGIN_URL),
			str_replace(array("\n", "\r"), '', WP_PLUGIN_URL)."/"
		);
		
		foreach($urls as $url){
			$this->slider_html = str_replace("'".$url."'", "''", $this->slider_html);
		}

		$search = array($cont_url, $cont_url_no_www, RS_PLUGIN_URL);
		if(defined('WHITEBOARD_PLUGIN_URL')){
			$search[] = WHITEBOARD_PLUGIN_URL;
		}

		$search	= apply_filters('revslider_html_export_replace_urls', $search);
		$replace = apply_filters('revslider_html_export_path_replace_urls', $replace);
		
		foreach($search ?? [] as $s){
			$found = array();
			$_s = array(
				$s,
				str_replace(array('http:', 'https:'), '', $s),
				str_replace('/', '\\\/', $s),
			);
			//$s = str_replace(array('http:', 'https:'), '', $s);
			foreach($_s as $pattern){
				$pattern = str_replace('/', '\/', $pattern);  // Escapes slashes
				//preg_match_all("/(\"|')".$pattern."\S*(\"|')/", $this->slider_html, $_files);
				preg_match_all("/(\"|')".$pattern."[^\"'\s]*?(\"|')/", $this->slider_html, $_files);
				if(empty($_files) || !isset($_files[0]) || empty($_files[0])) continue;
				foreach($_files[0] ?? [] as $_file){
					if(in_array($_file, $found)) continue;
					$found[] = $_file;
				}
			}
    		
			if(empty($found)) continue;

			//go through all files, check for existance and add to the zip file
			foreach($found ?? [] as $_file){
				$o		= $_file;
				$_file	= str_replace(array('"', "'", str_replace('/', '\/', $s)), '', $_file);
				$_file	= str_replace($_s, '', $_file);
				$_file	= str_replace('\/', '/', $_file);
				
				//check if video or image
				preg_match('/.*?.(?:jpg|jpeg|gif|png|svg)/i', $_file, $match); //image
				preg_match('/.*?.(?:ogv|webm|mp4|mp3)/i', $_file, $match2); //video
				
				$f = false;
				if(!empty($match) && isset($match[0]) && !empty($match[0])){
					$use_path		= $this->path_assets;
					$use_path_raw	= $this->path_assets_raw;
					$f = true;
				}
				if(!empty($match2) && isset($match2[0]) && !empty($match2[0])){
					$use_path		= $this->path_assets_vid;
					$use_path_raw	= $this->path_assets_raw_vid;
					$f = true;
				}
				
				if($f == false){ //no file, just a location. So change the location accordingly by removing base
					$this->slider_html = str_replace($o, '"'.$this->path_js.'"', $this->slider_html);
					continue; //no correct file, nothing to add
				}
				if(isset($added[$_file])) continue;
				
				$add	 = '';
				$__file	 = '';
				$repl_to = explode('/', $_file);
				$repl_to = end($repl_to);
				$remove	 = false;
				
				if(is_file($upload_dir.$_file)){
					$this->add_file_to_zip($upload_dir.$_file, $use_path_raw);
					$remove = true;
				}elseif(is_file($upload_dir_multi.$_file)){
					$this->add_file_to_zip($upload_dir_multi.$_file, $use_path_raw);
					$remove = true;
				}elseif(is_file(RS_PLUGIN_PATH.$_file)){
					//we need to be special with internal files
					$__file = basename($_file);
					$this->add_file_to_zip($use_path_raw.'/'.$__file, $use_path_raw);
					$remove = true;
					$add = '/';
				}else{
					if(defined('WHITEBOARD_PLUGIN_PATH') && is_file(WHITEBOARD_PLUGIN_PATH.$_file)){
						//we need to be special with svg files
						$__file = basename($_file);
						$this->add_file_to_zip(WHITEBOARD_PLUGIN_PATH.$__file, $use_path_raw);
						$remove = true;
						$add = '/';
					}
					foreach($replace ?? [] as $_path){
						if(!is_file($_path.$_file)) continue;
						//we need to be special with svg files
						$mf = str_replace('//', '/', $_path.$_file);
						$__file = basename($_file);
						$this->add_file_to_zip($_path.$__file, $use_path_raw);
						$remove = true;
						$add = '/';
					}
				}

				if($remove !== true) continue; //replace file with new path

				$added[$_file] = true; //set as added
				if($add !== '') $_file = $__file; //set the different path here
				$re	= (strpos($o, "'") !== false) ? "'" : '"';

				$o	= str_replace('\/', '/', $o);
				$o	= $this->remove_http(str_replace($re, '', $o));
				$to = $re.$use_path.'/'.$repl_to.$re;
				$_o	= str_replace('/', '\/', $o);
				$_to = $re.$use_path.'\/'.$repl_to.$re;

				$this->slider_html = str_replace(array($re.$o.$re, $re.'http:'.$o.$re, $re.'https:'.$o.$re), $to, $this->slider_html);
				$this->slider_html = str_replace(array($re.$_o.$re, $re.'http:'.$_o.$re, $re.'https:'.$_o.$re), $_to, $this->slider_html);
			}
		}

		$css_files	= array(
			'sr7.css',
			'sr7.btns.css',
			'sr7.filters.css',
			'sr7.lp.css',
			'sr7.media.css',
			'sr7.nav.css',
			'sr7.nav.css',
			'fonts/font-awesome/css/font-awesome.css',
			'fonts/font-awesome/fonts/FontAwesome.otf',	
			'fonts/font-awesome/fonts/fontawesome-webfont.eot',
			'fonts/font-awesome/fonts/fontawesome-webfont.svg',
			'fonts/font-awesome/fonts/fontawesome-webfont.ttf',
			'fonts/font-awesome/fonts/fontawesome-webfont.woff',
			'fonts/font-awesome/fonts/fontawesome-webfont.woff2',
			'fonts/material/codepoints',
			'fonts/material/codepoints.json',
			'fonts/material/codepoints.scss',
			'fonts/material/material-icons.css',
			'fonts/material/MaterialIcons-Regular.eot',
			'fonts/material/MaterialIcons-Regular.ijmap.txt',
			'fonts/material/MaterialIcons-Regular.svg',
			'fonts/material/MaterialIcons-Regular.ttf',
			'fonts/material/MaterialIcons-Regular.woff',
			'fonts/material/MaterialIcons-Regular.woff2',
			'fonts/pe-icon-7-stroke/css/helper.css',	
			'fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
			'fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.eot',
			'fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.svg',
			'fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.ttf',
			'fonts/pe-icon-7-stroke/fonts/Pe-icon-7-stroke.woff',
			'fonts/revicons/css/revicons.css',
			'fonts/revicons/fonts/revicons.eot',
			'fonts/revicons/fonts/revicons.svg',
			'fonts/revicons/fonts/revicons.ttf',
			'fonts/revicons/fonts/revicons.woff',
			'fonts/revicons/fonts/revicons.woff',
			'preloaders/t0.css',
			'preloaders/t1.css',
			'preloaders/t2.css',
			'preloaders/t3.css',
			'preloaders/t4.css',
			'preloaders/t5.css',
			'preloaders/t6.css',
			'preloaders/t7.css',
			'preloaders/t8.css',
			'preloaders/t9.css',
			'preloaders/t10.css',
			'preloaders/t11.css',
			'preloaders/t12.css',
			'preloaders/t13.css',
			'preloaders/t14.css',
			'preloaders/t15.css',
		);
		$js_files	= array(
			'animate.js',
			'canvas.js',
			'carousel.js',
			'defaults.js',
			'draw.js',
			'layer.js',
			'media.js',
			//'migration.js',
			'modifiers.js',
			'module.js',
			'navigation.js',
			'page.js',
			'save.js',
			'slide.js',
			'sr7.js',
			'srtools.js',
			'libs/three.js',
			'libs/tpgsap.js',
			'libs/tptools.js',
			'libs/webgl.js',
		);
	
		foreach($js_files ?? [] as $js_file){
			if(!file_exists(RS_PLUGIN_PATH.'public/js/'.$js_file)) continue;
			
			if(!$this->usepcl){
				$this->zip->addFile(RS_PLUGIN_PATH.'public/js/'.$js_file, $this->path_js.$js_file);
			}else{
				$this->pclzip->add(RS_PLUGIN_PATH.'public/js/'.$js_file, PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'assets/js/', PCLZIP_OPT_ADD_PATH, $this->path_js);
			}
		}

		foreach($css_files ?? [] as $css_file){
			if(!file_exists(RS_PLUGIN_PATH.'public/css/'.$css_file)) continue;

			if(!$this->usepcl){
				$this->zip->addFile(RS_PLUGIN_PATH.'public/css/'.$css_file, $this->path_css.$css_file);
			}else{
				$this->pclzip->add(RS_PLUGIN_PATH.'public/css/'.$css_file, PCLZIP_OPT_REMOVE_PATH, RS_PLUGIN_PATH.'assets/css/', PCLZIP_OPT_ADD_PATH, $this->path_css);
			}
		}

		$this->slider_html = apply_filters('revslider_export_html_file_inclusion', $this->slider_html, $this);
		
		$notice_text = __('Using this data is only allowed with a valid licence of the WordPress Slider Revolution Plugin, which can be found at: https://www.themepunch.com/links/slider_revolution_wordpress_regular_license', 'revslider');
		
		if(!$this->usepcl){
			$this->zip->addFromString('NOTICE.txt', $notice_text); //add slider settings
		}else{
			$this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => 'NOTICE.txt', PCLZIP_ATT_FILE_CONTENT => $notice_text)));
		}
	}

	public function add_export_json_to_zip(){
		if(!$this->usepcl){
			$this->zip->addFromString("assets/".$this->html_id.".json", $this->json); //add slider settings
		}else{
			$this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => "assets/".$this->html_id.".json", PCLZIP_ATT_FILE_CONTENT => $this->json)));
		}
	}

	/**
	 * Add the export HTML file to the zip file
	 **/
	public function add_export_html_to_zip(){
		if(!$this->usepcl){
			$this->zip->addFromString('index.html', $this->slider_html); //add slider settings
			$this->zip->close();
		}else{
			$this->pclzip->add(array(array(PCLZIP_ATT_FILE_NAME => 'index.html', PCLZIP_ATT_FILE_CONTENT => $this->slider_html)));
		}
	}

	public function add_file_to_zip($file, $path){
		$file_name = explode('/', $file);
		$file_name = end($file_name);
		$file = str_replace('//', '/', $file);
		if(!$this->usepcl){
			$this->zip->addFile($file, $path.'/'.$file_name);
		}else{
			$this->pclzip->add($file, PCLZIP_OPT_REMOVE_PATH, str_replace(basename($file), '', $file), PCLZIP_OPT_ADD_PATH, $path.'/');
		}
	}
}