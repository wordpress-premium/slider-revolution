<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderFront extends RevSliderFrontGlobal {

	public function __construct(){
		parent::__construct();
		add_action('wp_enqueue_scripts', array('RevSliderFront', 'add_actions'));
		add_filter('wp_img_tag_add_loading_attr', array('RevSliderFront', 'check_lazy_loading'), 99, 3);
	}
	
	/**
	 * Add all actions that the frontend needs here
	 **/
	public static function add_actions(){
		global $SR_GLOBALS;

		$func	 = RevSliderGlobals::instance()->get('RevSliderFunctions');
		$rs_ver	 = apply_filters('revslider_remove_version', RS_REVISION);
		$global	 = $func->get_global_settings();
		$inc_global = $func->_truefalse($func->get_val($global, 'allinclude', true));
		
		$inc_footer = $func->_truefalse($func->get_val($global, array('script', 'footer'), true));
		$widget	 = is_active_widget(false, false, 'rev-slider-widget', true);
		
		$load = false;
		$load = apply_filters('revslider_include_libraries', $load);
		$load = ($SR_GLOBALS['preview_mode'] === true) ? true : $load;
		$load = ($inc_global === true) ? true : $load;
		$load = (self::has_shortcode('rev_slider') === true || self::has_shortcode('sr7') === true) ? true : $load;
		$load = ($widget !== false) ? true : $load;
		
		if($inc_global === false){
			$output = new RevSliderOutput();
			$output->set_add_to($func->get_val($global, 'includeids', ''));
			$add_to = $output->check_add_to(true);
			$load	= ($add_to === true) ? true : $load;
		}

		if($load === false) return false;
		
		wp_enqueue_script(array('jquery'));
		
		/**
		 * dequeue tp-tools to make sure that always the latest is loaded
		 **/
		global $wp_scripts;
		if(version_compare($func->get_val($wp_scripts, array('registered', 'tp-tools', 'ver'), '1.0'), RS_TP_TOOLS, '<')){
			wp_deregister_script('tp-tools');
			wp_dequeue_script('tp-tools');
		}
		
		wp_enqueue_script('tp-tools', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/rbtools.min.js', array('jquery'), RS_TP_TOOLS, $inc_footer);
		
		if(!file_exists(RS_PLUGIN_PATH.'sr6/assets/js/rs6.min.js')){
			wp_enqueue_script('revmin', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.main.js', array('jquery'), $rs_ver, $inc_footer);
			//if on, load all libraries instead of dynamically loading them
			wp_enqueue_script('revmin-actions', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.actions.js', array('jquery'), $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-carousel', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.carousel.js', array('jquery'), $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-layeranimation', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.layeranimation.js', array('jquery'), $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-navigation', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.navigation.js', array('jquery'), $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-panzoom', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.panzoom.js', array('jquery'), $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-parallax', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.parallax.js', array('jquery'), $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-slideanims', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.slideanims.js', array('jquery'), $rs_ver, $inc_footer);		
			wp_enqueue_script('revmin-video', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/dev/rs6.video.js', array('jquery'), $rs_ver, $inc_footer);
		}else{
			wp_enqueue_script('revmin', RS_PLUGIN_URL_CLEAN . 'sr6/assets/js/rs6.min.js', array('tp-tools', 'jquery'), $rs_ver, $inc_footer);
		}
		
		add_action('wp_head', array('RevSliderFront', 'add_meta_generator'));
		add_action('wp_head', array('RevSliderFunctions', 'js_set_start_size'), 99);
		add_action('admin_head', array('RevSliderFunctions', 'js_set_start_size'), 99);
		add_action('wp_footer', array('RevSliderFront', 'add_inline_css'), 10);
		add_action('wp_footer', array('RevSliderFront', 'load_icon_fonts'), 11);
		add_action('wp_footer', array('RevSliderFront', 'load_google_fonts'));
		add_action('wp_footer', array('RevSliderFront', 'add_waiting_script'), 1);
		add_action('wp_print_footer_scripts', array('RevSliderFront', 'add_inline_js'), 100);

		//defer JS Loading
		if($func->_truefalse($func->get_val($global, array('script', 'defer'), true)) === true){
			add_filter('script_loader_tag', array('RevSliderFront', 'add_defer_forscript'), 11, 2);
		}

		//Async JS Loading
		if($func->_truefalse($func->get_val($global, array('script', 'async'), true)) === true){
			add_filter('script_loader_tag', array('RevSliderFront', 'add_async_forscript'), 11, 2);
		}
	}
	
	/**
	 * add css to the footer
	 **/
	public static function add_inline_css(){
		global $wp_version, $SR_GLOBALS; //$rs_revicons;
		$css	 = RevSliderGlobals::instance()->get('RevSliderCssParser');
		$rs_ver	 = apply_filters('revslider_remove_version', RS_REVISION);
		/**
		 * Fix for WordPress versions below 3.7
		 **/
		$style_pre = ($wp_version < 3.7) ? '<style id="rs-plugin-settings-inline-css">' : '';
		$style_post = ($wp_version < 3.7) ? '</style>' : '';
		$custom_css = $css->get_static_css();
		$custom_css = $css->compress_css($custom_css);
		
		if(!empty($SR_GLOBALS['collections']['css'])){
			$custom_css .= RS_T2;
			$custom_css .= implode("\n".RS_T2, $SR_GLOBALS['collections']['css']);
		}
		
		$custom_css = (trim($custom_css) == '') ? '#rs-demo-id {}' : $custom_css;

		if(strpos($custom_css, 'revicon') !== false){
			if(!isset($SR_GLOBALS['icon_sets']['RevIcon'])) $SR_GLOBALS['icon_sets']['RevIcon'] = array('css' => false, 'parsed' => false);
			$SR_GLOBALS['icon_sets']['RevIcon']['css'] = true;
			//$rs_revicons = true;
		}
		
		wp_enqueue_style('rs-plugin-settings', RS_PLUGIN_URL_CLEAN . 'sr6/assets/css/rs6.css', array(), $rs_ver);
		wp_add_inline_style('rs-plugin-settings', $style_pre . $custom_css . $style_post);
	}
	
	/**
	 * add all the JavaScript from the Sliders to the footer
	 **/
	public static function add_inline_js(){
		global $SR_GLOBALS;
		
		if(empty($SR_GLOBALS['collections']['js'])) return true;
		if(empty($SR_GLOBALS['collections']['js']['revapi'])) return true;

		echo '<script id="rs-initialisation-scripts">'."\n";
		echo RS_T2.'var	tpj = jQuery;'."\n\n";
		echo RS_T2.'var	'.implode(',', $SR_GLOBALS['collections']['js']['revapi']) . ';'."\n";
		if(!empty($SR_GLOBALS['collections']['js']['js'])){
			echo "\n" . implode("\n", $SR_GLOBALS['collections']['js']['js']);
		}
		if(!empty($SR_GLOBALS['collections']['js']['minimal'])){
			echo "\n" . $SR_GLOBALS['collections']['js']['minimal'];
		}
		
		echo RS_T.'</script>'."\n";
		
	}

	/**
	 * Load Used Icon Fonts
	 * @since: 5.0
	 */
	public static function load_icon_fonts(){
		global $SR_GLOBALS;
		$func		= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$global		= $func->get_global_settings();
		$ignore_fa	= $func->_truefalse($func->get_val($global, 'fontawesomedisable', false));
		$fa			= $func->get_val($SR_GLOBALS, array('icon_sets', 'FontAwesome', 'css'), false);
		$fai		= $func->get_val($SR_GLOBALS, array('icon_sets', 'FontAwesomeIcon', 'css'), false);
		
		echo ($func->get_val($SR_GLOBALS, array('icon_sets', 'RevIcon', 'css'), false) === true) ? RS_T3.'<link rel="preload" as="font" id="rs-icon-set-revicon-woff" href="' . RS_PLUGIN_URL_CLEAN . 'sr6/assets/fonts/revicons/revicons.woff?5510888" type="font/woff" crossorigin="anonymous" media="all" />'."\n" : '';
		if($ignore_fa === false && $fa === true || $fai === true){
			echo RS_T3.'<link rel="preload" as="font" id="rs-icon-set-fa-icon-woff" type="font/woff2" crossorigin="anonymous" href="' . RS_PLUGIN_URL_CLEAN . 'sr6/assets/fonts/font-awesome/fonts/fontawesome-webfont.woff2?v=4.7.0" media="all" />'."\n";
			echo RS_T3.'<link rel="stylesheet" property="stylesheet" id="rs-icon-set-fa-icon-css" href="' . RS_PLUGIN_URL_CLEAN . 'sr6/assets/fonts/font-awesome/css/font-awesome.css" type="text/css" media="all" />'."\n";
		}

		echo ($func->get_val($SR_GLOBALS, array('icon_sets', 'PeIcon', 'css'), false)) ? RS_T3.'<link rel="stylesheet" property="stylesheet" id="rs-icon-set-pe-7s-css" href="' . RS_PLUGIN_URL_CLEAN . 'sr6/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" type="text/css" media="all" />'."\n" : '';
	}
	
	
	/**
	 * Load Used Google Fonts
	 * add google fonts of all sliders found on the page
	 * @since: 6.0
	 */
	public static function load_google_fonts(){ 
		$func	= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$fonts	= $func->print_clean_font_import();
		if(!empty($fonts)){
			echo $fonts."\n";
		}
	}
	
	/**
	 * add the scripts that needs to be waited on
	 * @since: 6.4.12
	 **/
	public static function add_waiting_script(){
		$func	= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$dev	= (!file_exists(RS_PLUGIN_PATH.'sr6/assets/js/rs6.min.js')) ? true : false;
		$global	= $func->get_global_settings();
		$wait	= array();
		$wait	= apply_filters('revslider_modify_waiting_scripts', $wait);
		?>

		<script>
			window.RS_MODULES = window.RS_MODULES || {};
			window.RS_MODULES.modules = window.RS_MODULES.modules || {};
			window.RS_MODULES.waiting = window.RS_MODULES.waiting || [];
			window.RS_MODULES.defered = <?php echo ($func->_truefalse($func->get_val($global, array('script', 'defer'), true)) === true) ? 'true' : 'false'; ?>;
			<?php if (!empty($wait)) {?> 			
			window.RS_MODULES.waiting = window.RS_MODULES.waiting.concat([ <?php echo '"'. implode('","', $wait) . '"'; ?>]);
			<?php }; ?>window.RS_MODULES.moduleWaiting = window.RS_MODULES.moduleWaiting || {};
			window.RS_MODULES.type = '<?php echo ($dev) ? "developer" : "compiled"; ?>';
		</script>
		<?php
	}
	
	/**
	 * check that loading="lazy" is not written in slider HTML
	 **/
	public static function check_lazy_loading($value, $image, $context){
		return (strpos($image, 'tp-rs-img') !== false) ? false : $value;
	}

	/**
	 * adds async loading
	 * @since: 5.0
	 * @updated: 6.4.12
	 */
	public static function add_defer_forscript($tag, $handle){
		if(strpos($tag, 'rs6') === false && strpos($tag, 'rbtools.min.js') === false && strpos($tag, 'revolution.addon.') === false && strpos($tag, 'sr6/assets/js/libs/') === false && (strpos($tag, 'liquideffect') === false && strpos($tag, 'pixi.min.js') === false) && strpos($tag, 'rslottie-js') === false){
			return $tag;
		}elseif(is_admin()){
			return $tag;
		}else{
			return str_replace(' id=', ' defer id=', $tag);
		}
	}

	/**
	 * adds async loading
	 * @since: 5.0
	 * @updated: 6.4.12
	 */
	public static function add_async_forscript($tag, $handle){
		if(strpos($tag, 'rs6') === false && strpos($tag, 'rbtools.min.js') === false && strpos($tag, 'revolution.addon.') === false && strpos($tag, 'sr6/assets/js/libs/') === false && (strpos($tag, 'liquideffect') === false && strpos($tag, 'pixi.min.js') === false) && strpos($tag, 'rslottie-js') === false){
			return $tag;
		}elseif(is_admin()){
			return $tag;
		}else{
			return str_replace(' id=', ' async id=', $tag);
		}
	}
	
}