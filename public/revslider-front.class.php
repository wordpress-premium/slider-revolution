<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderFront extends RevSliderFrontGlobal {

	public $v6_slider = false;

	public function __construct(){
		parent::__construct();
		add_action('wp_enqueue_scripts', array($this, 'add_actions'));
	}

	/**
	 * Add all actions that the frontend needs here
	 **/
	public function add_scripts(){
		global $wp_scripts;
		if(version_compare($this->get_val($wp_scripts, array('registered', 'tp-tools', 'ver'), '1.0'), RS_TP_TOOLS, '<')){
			wp_deregister_script('tp-tools');
			wp_dequeue_script('tp-tools');
		}
		wp_enqueue_script('tp-tools', RS_PLUGIN_URL_CLEAN . 'public/js/libs/tptools.js', '', RS_REVISION, ['strategy' => 'async']);
		wp_enqueue_script('sr7', RS_PLUGIN_URL_CLEAN . 'public/js/sr7.js', '', RS_REVISION, ['strategy' => 'async']);			
		wp_enqueue_style('sr7css', RS_PLUGIN_URL_CLEAN . 'public/css/sr7.css', '', RS_REVISION);
		
		//check if a v6 slider is on the page, if yes then load the migration JS
		if($this->v6_slider) wp_enqueue_script('sr7migration', RS_PLUGIN_URL_CLEAN . 'public/js/migration.js', '', RS_REVISION, ['strategy' => 'async']);
		do_action('sr_front_add_scripts', $this);
	}

	/**
	 * Add custom HTML to the style tags
	 **/
	public function add_html_to_style_tags($html, $handle) {
		// Check if it's the stylesheet you want to modify
		if ($handle !== 'sr7pagecsslp') return $html;

		$html = str_replace("rel='stylesheet'", "rel='preload'", $html);		
		$html = str_replace('/>', 'as="style" fetchpriority="low" onload="this.rel=\'stylesheet\'" />', $html);
		$html = str_replace("rel='stylesheet'", "rel='preload'", $html);
		$html = str_replace('/>', 'as="style" fetchpriority="high" onload="this.rel=\'stylesheet\'" />', $html);

		return $html;
	}
	  
	public function add_actions(){
		global $SR_GLOBALS;

		$global	 	= $this->get_global_settings();
		$inc_global	= $this->_truefalse($this->get_val($global, 'allinclude', true));		
		$inc_footer = $this->_truefalse($this->get_val($global, array('script', 'footer'), true));
		$widget	 	= is_active_widget(false, false, 'rev-slider-widget', true);
		
		$load = false;
		$load = apply_filters('revslider_include_libraries', $load);
		$load = ($SR_GLOBALS['preview_mode'] === true) ? true : $load;
		$load = ($inc_global === true) ? true : $load;
		$load = (self::has_shortcode('rev_slider') === true || self::has_shortcode('sr7') === true) ? true : $load;
		$load = ($widget !== false) ? true : $load;
		
		if($inc_global === false){
			$output = new RevSliderOutput();
			$output->set_add_to($this->get_val($global, 'includeids', ''));
			$add_to = $output->check_add_to(true);
			$load	= ($add_to === true) ? true : $load;
		}
		
		if($load === false) return false;

		$this->add_scripts();
		add_action('wp_head', array($this, 'js_add_header_scripts'), 99);
		add_action('wp_head', array($this, 'load_header_fonts'));
		add_filter('style_loader_tag', array($this, 'add_html_to_style_tags'), 10, 2);
		add_action('wp_footer', array($this, 'load_google_fonts'));
		add_action('wp_footer', array($this, 'add_deprecation_warnings'));
		add_action('wp_head', array('RevSliderFront', 'add_meta_generator'));
	}

	public function js_add_header_scripts(){
		global $SR_GLOBALS;
		if($SR_GLOBALS['header_js'] === true) return false;

		$global = $this->get_global_settings();

		$breakpoints = array();
		$breakpoints[] = intval($this->get_val($global, array('size', 'desktop'), '1240'));
		$breakpoints[] = intval($this->get_val($global, array('size', 'notebook'), '1024'));
		$breakpoints[] = intval($this->get_val($global, array('size', 'tablet'), '778'));
		$breakpoints[] = intval($this->get_val($global, array('size', 'mobile'), '480'));

		$libs	 = array();
		$css	 = array();
		$modules = array('module','page','slide','layer','draw','animate','srtools','canvas','defaults','carousel','navigation','media','modifiers');
		$devMode = 'true';
		if($SR_GLOBALS['markup_export'] === false) $modules[] = 'migration';

		if(file_exists(RS_PLUGIN_PATH . 'public/js/libs/three.js'))		$libs[] = "'THREE'"; else $devMode = 'false';
		if(file_exists(RS_PLUGIN_PATH . 'public/js/libs/webgl.js'))		$libs[] = "'WEBGL'";
		if(file_exists(RS_PLUGIN_PATH . 'public/js/libs/tpgsap.js'))	$libs[] = "'tpgsap'";
		if(file_exists(RS_PLUGIN_PATH . 'public/css/sr7.lp.css'))		$css[] = "'csslp'";
		if(file_exists(RS_PLUGIN_PATH . 'public/css/sr7.btns.css'))		$css[] = "'cssbtns'";
		if(file_exists(RS_PLUGIN_PATH . 'public/css/sr7.filters.css'))	$css[] = "'cssfilters'";
		if(file_exists(RS_PLUGIN_PATH . 'public/css/sr7.nav.css'))		$css[] = "'cssnav'";
		if(file_exists(RS_PLUGIN_PATH . 'public/css/sr7.media.css'))	$css[] = "'cssmedia'";
		
		$script = '<script>' . "\n";
		$script .= "	window._tpt			??= {};" . "\n";
		$script .= "	window.SR7			??= {};" . "\n";
		$script .= "	_tpt.R				??= {};" . "\n";
		$script .= "	_tpt.R.fonts		??= {};" . "\n";
		$script .= "	_tpt.R.fonts.customFonts??= {};" . "\n";
		$script .= "	SR7.devMode			=  ".$devMode.";" . "\n";
		$script .= "	SR7.F 				??= {};" . "\n";
		$script .= "	SR7.G				??= {};" . "\n";
		$script .= "	SR7.LIB				??= {};" . "\n";
		$script .= "	SR7.E				??= {};" . "\n";
		$script .= "	SR7.E.gAddons		??= {};" . "\n";
		$script .= "	SR7.E.php 			??= {};" . "\n";
		$script .= "	SR7.E.nonce			= '". wp_create_nonce('RevSlider_Front') ."';" . "\n";
		$script .= "	SR7.E.ajaxurl		= '". admin_url('admin-ajax.php') ."';" . "\n";
		$script .= "	SR7.E.resturl		= '". get_rest_url() ."';" . "\n";
		$script .= "	SR7.E.slug_path		= '". str_replace(array("\n", "\r"), '', RS_PLUGIN_SLUG_PATH) ."';" . "\n";
		$script .= "	SR7.E.slug			= '". str_replace(array("\n", "\r"), '', RS_PLUGIN_SLUG) ."';" . "\n";
		$script .= "	SR7.E.plugin_url	= '". str_replace(array("\n", "\r"), '', RS_PLUGIN_URL) ."';" . "\n";
		$script .= "	SR7.E.wp_plugin_url = '". str_replace(array("\n", "\r"), '', WP_PLUGIN_URL) . "/" ."';" . "\n";
		$script .= "	SR7.E.revision		= '". RS_REVISION ."';" . "\n";
		$script .= "	SR7.E.fontBaseUrl	= '". $this->modify_fonts_url('https://fonts.googleapis.com/css2?family=') ."';" . "\n";
		$script .= "	SR7.G.breakPoints 	= [".implode(',', $breakpoints)."];" . "\n";
		$script .= "	SR7.E.modules 		= ['".implode("','", $modules)."'];" . "\n";
		if(!empty($libs))	$script .= '	SR7.E.libs 			= [' . implode(',', $libs) . '];' . "\n";
		if(!empty($css))	$script .= '	SR7.E.css 			= [' . implode(',', $css) . '];' . "\n";
		$script .= "	SR7.E.resources		= {};" . "\n";

		$script = apply_filters('revslider_js_add_header_scripts_js', $script);
		
		// Add Page Handler Inline Script
		if($this->get_val($global, array('getTec', 'core'), 'MIX') !== 'REST' || $SR_GLOBALS['markup_export'] === true){
			$script .= '	SR7.JSON			??= {};' ."\n";
		}
		if($SR_GLOBALS['markup_export'] === false) $script .= (file_get_contents(RS_PLUGIN_PATH . 'public/js/page.js'));

		$script .= '</script>' . "\n";
		echo apply_filters('revslider_js_add_header_scripts', $script);
		
		$SR_GLOBALS['header_js'] = true;
	}

	public function load_v7_slider(){
		global $SR_GLOBALS, $post;
		
		$used_slider	= [];
		$forced_slides	= [];
		$id				= (isset($post->ID)) ? $post->ID : '';
		//$all_shortcodes	= $this->get_shortcode_from_page($id);
		//$all_shortcodes = array_unique(array_merge($all_shortcodes, $SR_GLOBALS['sliders']));
		$all_shortcodes = $SR_GLOBALS['sliders'];
		$script			= '';

		if(empty($all_shortcodes)) return $script;

		$table_temp = $SR_GLOBALS['use_table_version'];
		$SR_GLOBALS['use_table_version'] = ($SR_GLOBALS['front_version'] === 6) ? 6 : 7;

		$serial		= $SR_GLOBALS['serial'];
		$collection	= $SR_GLOBALS['collections']['ids'];
		$SR_GLOBALS['collections']['ids'] = array();
		if($SR_GLOBALS['serial'] > 0){
			$SR_GLOBALS['serial'] = 0;
		}
		$global		= $this->get_global_settings();
		$mode		= $this->get_val($global, array('getTec', 'core'), 'MIX');
		$start_ver	= $SR_GLOBALS['use_table_version'];
		foreach($all_shortcodes ?? [] as $alias){
			$SR_GLOBALS['use_table_version'] = $start_ver;
			$slider	= new RevSliderSlider();
			if(!$slider->check_alias($alias)){
				//check in v6/v7 database depending on where we are currently
				$SR_GLOBALS['use_table_version'] = ($SR_GLOBALS['use_table_version'] === 6) ? 7 : 6;
				if(!$slider->check_alias($alias)) continue;
			}
			
			$slider->init_by_alias($alias, false);
			if($slider->inited === false) continue;
			
			if($SR_GLOBALS['use_table_version'] === 6) $this->v6_slider = true;

			$dl = $slider->get_param('deepLinks', []);
			foreach($dl ?? [] as $slide_id){
				if(!in_array($slide_id, $forced_slides)) $forced_slides[] = $slide_id;
			}
			
			$used_slider[] = $slider;
		}

		foreach($used_slider ?? [] as $slider){
			$SR_GLOBALS['serial']++;
			$sid		= $slider->get_id();
			$slider_id	= $slider->get_param('id', '');
			$html_id	= (trim($slider_id) !== '') ? $slider_id : 'SR7_'.$sid.'_'.$SR_GLOBALS['serial'];
			$html_id	= $this->set_html_id_v7($html_id, true);
			$full		= ($slider->v7 === false || ($slider->v7 === true && ($slider->get_param('fixed', false) !== false || in_array($slider->get_param('type', ''), array('scene', 'hero', 'carousel'))))) ? true : false;
			if($mode === 'MIX' && $SR_GLOBALS['serial'] > 2) $full = false; //we only print $forced_slides from now on
			$full		= ($slider->is_stream_post()) ? true : $full; //check if we are stream/post, these need to always write all layers (B-7235530610)

			if($SR_GLOBALS['markup_export'] === true){
				$script .= "	SR7.JSON['".$html_id."'] = 'assets/".$html_id.".json';"."\n";
			}else{
				$data	= $slider->get_full_slider_JSON(false, $full, array(), $forced_slides);
				$data	= apply_filters('sr_load_slider_json', $data, $this);

				if($mode === 'MIX' && $SR_GLOBALS['serial'] > 2 && !empty($forced_slides)){ //we check if slides are in the forced_slides list, if not then we ignore
					$print = false;
					foreach($data['slides'] ?? [] as $slide){
						if(!in_array($this->get_val($slide, 'id'), $forced_slides)) continue;
						$print = true;
						break;
					}
					if($print === false) continue; //do not pront any information about the slider
				}

				//load dom data directly
				$script .= "	SR7.JSON['".$html_id."'] = ".json_encode($data).";"."\n";
			}

			if($mode === 'MIX' && $SR_GLOBALS['serial'] >= 2 && empty($forced_slides)) break;
		}
		$SR_GLOBALS['collections']['ids'] = $collection; //reset html ids here, so that they are later on empty when the page is parsed
		$SR_GLOBALS['serial'] = $serial; //reset back to what it was before
		$SR_GLOBALS['use_table_version'] = $table_temp;

		return $script;
	}

	/**
	 * print in header
	 **/
	public function load_header_fonts(){
		$global = $this->get_global_settings();
		if($this->get_val($global, 'fontdownload', 'off') === 'disable') return;

		echo '<link rel="preconnect" href="https://fonts.googleapis.com">'."\n";
		echo '<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>'."\n";
	}

	/**
	 * Load Used Google Fonts
	 * add google fonts of all sliders found on the page
	 * @since: 6.0
	 */
	public function load_google_fonts(){
		$fonts	= $this->print_clean_font_import_v7();
		
		if(empty($fonts)) return;

		echo "\n".$fonts."\n";

		global $SR_GLOBALS;
		if(empty($SR_GLOBALS['fonts']['loaded']) && empty($SR_GLOBALS['fonts']['custom'])) return;
	
		$domFonts = array();
		echo '<script>'."\n";
		$branches = array('loaded', 'custom');
		foreach($branches as $branch){
			foreach($SR_GLOBALS['fonts'][$branch] ?? [] as $handle => $values){
				$handle = preg_replace('/[^-0-9a-zA-Z+]/', '', str_replace(' ', '+', $handle));
				if(isset($values['url'])){
					echo "_tpt.R.fonts.customFonts['". $handle ."'] = ". json_encode($values) .";"."\n";
				}else{
					$domFonts[$handle] = array(
						'normal'	=> $this->get_val($values, array('variants', 'normal'), array()),
						'italic'	=> $this->get_val($values, array('variants', 'italic'), array())
					);
				}
			}
		}

		if(!empty($domFonts)){
			echo "_tpt.R.fonts.domFonts = ". json_encode($domFonts) .";"."\n";
		}
		echo '</script>'."\n";
	}

	/**
	 * adds deprecation warnings of functions that will cease to exist in v7
	 */
	public function add_deprecation_warnings(){
		global $SR_GLOBALS;
		if(empty($SR_GLOBALS['deprecated'])) return;

		echo '<script>';
		echo 'SR7.E.php.warnings	= '.json_encode($SR_GLOBALS['deprecated']).';';
		echo '</script>'."\n";

	}

	
}
