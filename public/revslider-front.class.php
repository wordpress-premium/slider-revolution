<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2019 ThemePunch
 */

if(!defined('ABSPATH')) exit();

class RevSliderFront extends RevSliderFunctions {

	const TABLE_SLIDER			 = 'revslider_sliders';
	const TABLE_SLIDES			 = 'revslider_slides';
	const TABLE_STATIC_SLIDES	 = 'revslider_static_slides';
	const TABLE_CSS				 = 'revslider_css';
	const TABLE_LAYER_ANIMATIONS = 'revslider_layer_animations';
	const TABLE_NAVIGATIONS		 = 'revslider_navigations';
	const TABLE_SETTINGS		 = 'revslider_settings'; //existed prior 5.0 and still needed for updating from 4.x to any version after 5.x
	const CURRENT_TABLE_VERSION	 = '1.0.8';

	const YOUTUBE_ARGUMENTS		 = 'hd=1&amp;wmode=opaque&amp;showinfo=0&amp;rel=0';
	const VIMEO_ARGUMENTS		 = 'title=0&amp;byline=0&amp;portrait=0&amp;api=1';

	public function __construct(){		
		add_action('wp_enqueue_scripts', array('RevSliderFront', 'add_actions'));
	}
	
	
	/**
	 * START: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * old version of add_admin_bar();
	 **/
	public static function putAdminBarMenus(){
		return RevSliderFront::add_admin_bar();
	}
	
	/**
	 * END: DEPRECATED FUNCTIONS THAT ARE IN HERE FOR OLD ADDONS TO WORK PROPERLY
	 **/
	 
	/**
	 * Add all actions that the frontend needs here
	 **/
	public static function add_actions(){
		global $wp_version, $revslider_is_preview_mode;

		$func		= new RevSliderFunctions();
		$css		= new RevSliderCssParser();
		$rs_ver		= apply_filters('revslider_remove_version', RS_REVISION);
		$global		= $func->get_global_settings();
		$inc_global = $func->_truefalse($func->get_val($global, 'allinclude', true));
		$inc_footer = $func->_truefalse($func->get_val($global, array('script', 'footer'), false));
		$waitfor	= array('jquery');
		$widget		= is_active_widget(false, false, 'rev-slider-widget', true);
		
		$load		= false;
		$load		= apply_filters('revslider_include_libraries', $load);
		$load		= ($revslider_is_preview_mode === true) ? true : $load;
		$load		= ($inc_global === true) ? true : $load;
		$load		= ($func->has_shortcode('rev_slider') === true) ? true : $load;
		$load		= ($widget !== false) ? true : $load;
		
		if($inc_global === false){
			$output = new RevSliderOutput();
			$output->set_add_to($func->get_val($global, 'includeids', ''));
			$add_to = $output->check_add_to(true);
			$load	= ($add_to === true) ? true : $load;
		}

		if($load === false) return false;
		
		wp_enqueue_style('rs-plugin-settings', RS_PLUGIN_URL . 'public/assets/css/rs6.css', array(), $rs_ver);

		/**
		 * Fix for WordPress versions below 3.7
		 **/
		$style_pre = ($wp_version < 3.7) ? '<style type="text/css">' : '';
		$style_post = ($wp_version < 3.7) ? '</style>' : '';
		$custom_css = $func->get_static_css();
		$custom_css = $css->compress_css($custom_css);

		if(trim($custom_css) == ''){
			$custom_css = '#rs-demo-id {}';
		}

		wp_add_inline_style('rs-plugin-settings', $style_pre . $custom_css . $style_post);

		wp_enqueue_script(array('jquery'));

		/**
		 * removed in 6.0
		 * if($func->get_val($global, 'enable_logs', 'off') == 'on'){
		 * 	wp_enqueue_script('enable-logs', RS_PLUGIN_URL . 'public/assets/js/jquery.themepunch.enablelog.js', $waitfor, $rs_ver);
		 * 	$waitfor[] = 'enable-logs';
		 * }
		 **/
		 
		/**
		 * dequeue tp-tools to make sure that always the latest is loaded
		 **/
		global $wp_scripts;
		if(version_compare($func->get_val($wp_scripts, array('registered', 'tp-tools', 'ver'), '1.0'), RS_TP_TOOLS, '<')){
			wp_deregister_script('tp-tools');
			wp_dequeue_script('tp-tools');
		}
		
		wp_enqueue_script('tp-tools', RS_PLUGIN_URL . 'public/assets/js/revolution.tools.min.js', $waitfor, RS_TP_TOOLS, $inc_footer);
		
		if(!file_exists(RS_PLUGIN_PATH.'public/assets/js/rs6.min.js')){
			wp_enqueue_script('revmin', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.main.js', 'tp-tools', $rs_ver, $inc_footer);
			//if on, load all libraries instead of dynamically loading them
			wp_enqueue_script('revmin-actions', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.actions.js', 'tp-tools', $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-carousel', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.carousel.js', 'tp-tools', $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-layeranimation', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.layeranimation.js', 'tp-tools', $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-navigation', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.navigation.js', 'tp-tools', $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-panzoom', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.panzoom.js', 'tp-tools', $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-parallax', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.parallax.js', 'tp-tools', $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-slideanims', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.slideanims.js', 'tp-tools', $rs_ver, $inc_footer);
			wp_enqueue_script('revmin-video', RS_PLUGIN_URL . 'public/assets/js/dev/rs6.video.js', 'tp-tools', $rs_ver, $inc_footer);
		}else{
			wp_enqueue_script('revmin', RS_PLUGIN_URL . 'public/assets/js/rs6.min.js', 'tp-tools', $rs_ver, $inc_footer);
		}
		
		add_action('wp_head', array('RevSliderFront', 'add_meta_generator'));
		add_action('wp_head', array('RevSliderFront', 'js_set_start_size'), 99);
		add_action('admin_head', array('RevSliderFront', 'js_set_start_size'), 99);
		add_action('wp_footer', array('RevSliderFront', 'load_icon_fonts'));
		add_action('wp_footer', array('RevSliderFront', 'load_google_fonts'));

		//Async JS Loading
		if($func->_truefalse($func->get_val($global, array('script', 'defer'), false)) === true){
			add_filter('clean_url', array('RevSliderFront', 'add_defer_forscript'), 11, 1);
		}

		add_action('wp_before_admin_bar_render', array('RevSliderFront', 'add_admin_menu_nodes'));
		add_action('wp_footer', array('RevSliderFront', 'add_admin_bar'), 99);
	}
	
	
	/**
	 * Add Meta Generator Tag in FrontEnd
	 * @since: 5.0
	 */
	public static function add_meta_generator(){
		echo apply_filters('revslider_meta_generator', '<meta name="generator" content="Powered by Slider Revolution ' . RS_REVISION . ' - responsive, Mobile-Friendly Slider Plugin for WordPress with comfortable drag and drop interface." />' . "\n");
	}

	/**
	 * Load Used Icon Fonts
	 * @since: 5.0
	 */
	public static function load_icon_fonts(){
		global $fa_var, $fa_icon_var, $pe_7s_var;
		$func	= new RevSliderFunctions();
		$global	= $func->get_global_settings();
		$ignore_fa = $func->_truefalse($func->get_val($global, 'fontawesomedisable', false));
		
		if($ignore_fa === false && ($fa_icon_var == true || $fa_var == true)){
			echo "<link rel='stylesheet' property='stylesheet' id='rs-icon-set-fa-icon-css' href='" . RS_PLUGIN_URL . "public/assets/fonts/font-awesome/css/font-awesome.css' type='text/css' media='all' />\n";
		}

		if($pe_7s_var){
			echo "<link rel='stylesheet' property='stylesheet' id='rs-icon-set-pe-7s-css' href='" . RS_PLUGIN_URL . "public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css' type='text/css' media='all' />\n";
		}
	}
	
	
	/**
	 * Load Used Google Fonts
	 * add google fonts of all sliders found on the page
	 * @since: 6.0
	 */
	public static function load_google_fonts(){ 
		$func	= new RevSliderFunctions();
		$fonts	= $func->print_clean_font_import();
		if(!empty($fonts)){
			echo $fonts."\n";
		}
	}
	

	/**
	 * add admin menu points in ToolBar Top
	 * @since: 5.0.5
	 * @before: putAdminBarMenus()
	 */
	public static function add_admin_bar(){
		if(!is_super_admin() || !is_admin_bar_showing()){
			return;
		}

		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				if(jQuery('#wp-admin-bar-revslider-default').length > 0 && jQuery('rs-module-wrap').length > 0){
					var aliases = new Array();
					jQuery('rs-module-wrap').each(function(){
						aliases.push(jQuery(this).data('alias'));
					});
					
					if(aliases.length > 0){
						jQuery('#wp-admin-bar-revslider-default li').each(function(){
							var li = jQuery(this),
								t = jQuery.trim(li.find('.ab-item .rs-label').data('alias')); //text()
							
							if(jQuery.inArray(t,aliases)!=-1){
							}else{
								li.remove();
							}
						});
					}
				}else{
					jQuery('#wp-admin-bar-revslider').remove();
				}
			});
		</script>
		<?php
}

	/**
	 * add admin nodes
	 * @since: 5.0.5
	 */
	public static function add_admin_menu_nodes(){
		if(!is_super_admin() || !is_admin_bar_showing()){
			return;
		}

		self::_add_node('<span class="rs-label">Slider Revolution</span>', false, admin_url('admin.php?page=revslider'), array('class' => 'revslider-menu'), 'revslider'); //<span class="wp-menu-image dashicons-before dashicons-update"></span>

		//add all nodes of all Slider
		$sl = new RevSliderSlider();
		$sliders = $sl->get_slider_for_admin_menu();

		if(!empty($sliders)){
			foreach ($sliders as $id => $slider){
				self::_add_node('<span class="rs-label" data-alias="' . esc_attr($slider['alias']) . '">' . esc_html($slider['title']) . '</span>', 'revslider', admin_url('admin.php?page=revslider&view=slide&id=slider-'.$id), array('class' => 'revslider-sub-menu'), esc_attr($slider['alias'])); //<span class="wp-menu-image dashicons-before dashicons-update"></span>
			}
		}
	}

	/**
	 * add admin node
	 * @since: 5.0.5
	 */
	public static function _add_node($title, $parent = false, $href = '', $custom_meta = array(), $id = ''){
		if(!is_super_admin() || !is_admin_bar_showing()){
			return;
		}

		$id = ($id == '') ? strtolower(str_replace(' ', '-', $title)) : $id;
		
		//links from the current host will open in the current window
		$meta = (strpos($href, site_url()) !== false) ? array() : array('target' => '_blank'); //external links open in new tab/window
		$meta = array_merge($meta, $custom_meta);
		
		global $wp_admin_bar;
		$wp_admin_bar->add_node(array('parent'=> $parent, 'id' => $id, 'title' => $title, 'href' => $href, 'meta' => $meta));
	}

	/**
	 * adds async loading
	 * @since: 5.0
	 */
	public static function add_defer_forscript($url){
		if(strpos($url, 'rs6.min.js') === false && strpos($url, 'revolution.tools.min.js') === false){
			return $url;
		} elseif(is_admin()){
			return $url;
		}else{
			return $url . "' defer='defer";
		}
	}
	
	/**
	 * Add functionality to gutenberg, elementar, visual composer and so on
	 **/
	public static function add_post_editor(){
		/**
		 * Page Editor Extensions
		 **/
		if(function_exists('is_user_logged_in') && is_user_logged_in()){
			//only include gutenberg for production
			if(is_admin() && defined('ABSPATH')){
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				if(function_exists('is_plugin_active') && !is_plugin_active('revslider-gutenberg/plugin.php')){
					require_once(RS_PLUGIN_PATH . 'admin/includes/shortcode_generator/gutenberg/gutenberg-block.php');
					new RevSliderGutenberg('gutenberg/');
				}
			}
			
			require_once(RS_PLUGIN_PATH . 'admin/includes/shortcode_generator/shortcode_generator.class.php');
			
			//Shortcode Wizard Includes
			add_action('vc_before_init', array('RevSliderShortcodeWizard', 'visual_composer_include')); //VC functionality
			add_action('admin_enqueue_scripts', array('RevSliderShortcodeWizard', 'enqueue_scripts'));
			
			//Elementor Functionality
			require_once(RS_PLUGIN_PATH . 'admin/includes/shortcode_generator/elementor/elementor.class.php');
			add_action('init', array('RevSliderElementor', 'init'));
		}
	}

	/**
	 * Add Meta Generator Tag in FrontEnd
	 * @since: 5.4.3
	 * @before: add_setREVStartSize()
		//NOT COMPRESSED VERSION
		function setREVStartSize(e){			
			try {								
				var pw = document.getElementById(e.c).parentNode.offsetWidth,
					newh;
				pw = pw===0 || isNaN(pw) ? window.innerWidth : pw;
				e.tabw = e.tabw===undefined ? 0 : parseInt(e.tabw);
				e.thumbw = e.thumbw===undefined ? 0 : parseInt(e.thumbw);
				e.tabh = e.tabh===undefined ? 0 : parseInt(e.tabh);
				e.thumbh = e.thumbh===undefined ? 0 : parseInt(e.thumbh);
				e.tabhide = e.tabhide===undefined ? 0 : parseInt(e.tabhide);
				e.thumbhide = e.thumbhide===undefined ? 0 : parseInt(e.thumbhide);
				e.mh = e.mh===undefined || e.mh=="" ? 0 : e.mh;								
				if(e.layout==="fullscreen" || e.l==="fullscreen")						
					newh = Math.max(e.mh,window.innerHeight);
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
					for (var i in e.rl) nl[i] = e.rl[i]<window.innerWidth ? 0 : e.rl[i];
					sl = nl[0];									
					for (var i in nl) if (sl>nl[i] && nl[i]>0) { sl = nl[i]; ix=i;}															
					var m = pw>(e.gw[ix]+e.tabw+e.thumbw) ? 1 : (pw-(e.tabw+e.thumbw)) / (e.gw[ix]);					
					newh =  (e.gh[ix] * m) + (e.tabh + e.thumbh);
				}				
				if(window.rs_init_css===undefined) window.rs_init_css = document.head.appendChild(document.createElement("style"));					
				document.getElementById(e.c).height = newh;
				window.rs_init_css.innerHTML += "#"+e.c+"_wrapper { height: "+newh+"px }";				
			} catch(e){
				console.log("Failure at Presize of Slider:" + e)
			}					   
		  }
	 */
	public static function js_set_start_size(){
		$script = '<script type="text/javascript">';		
		$script .= 'function setREVStartSize(a){try{var b,c=document.getElementById(a.c).parentNode.offsetWidth;if(c=0===c||isNaN(c)?window.innerWidth:c,a.tabw=void 0===a.tabw?0:parseInt(a.tabw),a.thumbw=void 0===a.thumbw?0:parseInt(a.thumbw),a.tabh=void 0===a.tabh?0:parseInt(a.tabh),a.thumbh=void 0===a.thumbh?0:parseInt(a.thumbh),a.tabhide=void 0===a.tabhide?0:parseInt(a.tabhide),a.thumbhide=void 0===a.thumbhide?0:parseInt(a.thumbhide),a.mh=void 0===a.mh||""==a.mh?0:a.mh,"fullscreen"===a.layout||"fullscreen"===a.l)b=Math.max(a.mh,window.innerHeight);else{for(var d in a.gw=Array.isArray(a.gw)?a.gw:[a.gw],a.rl)(void 0===a.gw[d]||0===a.gw[d])&&(a.gw[d]=a.gw[d-1]);for(var d in a.gh=void 0===a.el||""===a.el||Array.isArray(a.el)&&0==a.el.length?a.gh:a.el,a.gh=Array.isArray(a.gh)?a.gh:[a.gh],a.rl)(void 0===a.gh[d]||0===a.gh[d])&&(a.gh[d]=a.gh[d-1]);var e,f=Array(a.rl.length),g=0;for(var d in a.tabw=a.tabhide>=c?0:a.tabw,a.thumbw=a.thumbhide>=c?0:a.thumbw,a.tabh=a.tabhide>=c?0:a.tabh,a.thumbh=a.thumbhide>=c?0:a.thumbh,a.rl)f[d]=a.rl[d]<window.innerWidth?0:a.rl[d];for(var d in e=f[0],f)e>f[d]&&0<f[d]&&(e=f[d],g=d);var h=c>a.gw[g]+a.tabw+a.thumbw?1:(c-(a.tabw+a.thumbw))/a.gw[g];b=a.gh[g]*h+(a.tabh+a.thumbh)}void 0===window.rs_init_css&&(window.rs_init_css=document.head.appendChild(document.createElement("style"))),document.getElementById(a.c).height=b,window.rs_init_css.innerHTML+="#"+a.c+"_wrapper { height: "+b+"px }"}catch(a){console.log("Failure at Presize of Slider:"+a)}};';
		$script .= '</script>' . "\n";
		echo apply_filters('revslider_add_setREVStartSize', $script);
	}
	
	/**
	 * sets the post saving value to true, so that the output echo will not be done
	 **/
	public static function set_post_saving(){
		global $revslider_save_post;
		$revslider_save_post = true;
	}

	/**
	 * Create Tables
	 * @only_base needs to be false
	 *  it can only be true by fixing database issues
	 *  this protects that the _bkp tables are not filled after 
	 *  we are already on version 6.0
	 **/
	public static function create_tables($only_base = false){
		$table_version = get_option('revslider_table_version', '1.0.0');
		
		if(version_compare($table_version, self::CURRENT_TABLE_VERSION, '<')){
			global $wpdb;

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_SLIDER . " (
			  id int(9) NOT NULL AUTO_INCREMENT,
			  title tinytext NOT NULL,
			  alias tinytext,
			  params LONGTEXT NOT NULL,
			  settings text NULL,
			  type VARCHAR(191) NOT NULL DEFAULT '',
			  UNIQUE KEY id (id)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_SLIDES . " (
			  id int(9) NOT NULL AUTO_INCREMENT,
			  slider_id int(9) NOT NULL,
			  slide_order int not NULL,
			  params LONGTEXT NOT NULL,
			  layers LONGTEXT NOT NULL,
			  settings text NOT NULL DEFAULT '',
			  UNIQUE KEY id (id)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_STATIC_SLIDES . " (
			  id int(9) NOT NULL AUTO_INCREMENT,
			  slider_id int(9) NOT NULL,
			  params LONGTEXT NOT NULL,
			  layers LONGTEXT NOT NULL,
			  settings text NOT NULL,
			  UNIQUE KEY id (id)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_CSS . " (
			  id int(9) NOT NULL AUTO_INCREMENT,
			  handle TEXT NOT NULL,
			  settings LONGTEXT,
			  hover LONGTEXT,
			  advanced LONGTEXT,
			  params LONGTEXT NOT NULL,
			  UNIQUE KEY id (id)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_LAYER_ANIMATIONS . " (
			  id int(9) NOT NULL AUTO_INCREMENT,
			  handle TEXT NOT NULL,
			  params TEXT NOT NULL,
			  settings text NULL,
			  UNIQUE KEY id (id)
			);";
			dbDelta($sql);

			$sql = "CREATE TABLE " . $wpdb->prefix . self::TABLE_NAVIGATIONS . " (
			  id int(9) NOT NULL AUTO_INCREMENT,
			  name VARCHAR(191) NOT NULL,
			  handle VARCHAR(191) NOT NULL,
			  type VARCHAR(191) NOT NULL,
			  css LONGTEXT NOT NULL,
			  markup LONGTEXT NOT NULL,
			  settings LONGTEXT NULL,
			  UNIQUE KEY id (id)
			);";
			dbDelta($sql);

			//create CSS entries
			$result = $wpdb->get_row("SELECT COUNT( DISTINCT id ) AS NumberOfEntrys FROM " . $wpdb->prefix . self::TABLE_CSS);
			if(!empty($result) && $result->NumberOfEntrys == 0){
				$css_class = new RevSliderCssParser();
				$css_class->import_css_captions();
			}

			update_option('revslider_table_version', self::CURRENT_TABLE_VERSION);
			//$table_version = self::CURRENT_TABLE_VERSION;
		}
		
		
		/**
		 * check if table version is below 1.0.8.
		 * if yes, duplicate the tables into _bkp
		 * this way, we can revert back to v5 if any slider
		 * has issues in the v6 migration process
		 **/
		if(version_compare($table_version, '1.0.8', '<') && ($only_base === false || $only_base === '')){
			global $wpdb;
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_SLIDER."_bkp LIKE ".$wpdb->prefix . self::TABLE_SLIDER.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_SLIDER."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_SLIDER."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_SLIDER.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_SLIDES."_bkp LIKE ".$wpdb->prefix . self::TABLE_SLIDES.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_SLIDES."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_SLIDES."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_SLIDES.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_STATIC_SLIDES."_bkp LIKE ".$wpdb->prefix . self::TABLE_STATIC_SLIDES.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_STATIC_SLIDES."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_STATIC_SLIDES."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_STATIC_SLIDES.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_CSS."_bkp LIKE ".$wpdb->prefix . self::TABLE_CSS.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_CSS."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_CSS."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_CSS.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS."_bkp LIKE ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_LAYER_ANIMATIONS.";";
				$wpdb->query($sql);
			}
			
			$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix . self::TABLE_NAVIGATIONS."_bkp LIKE ".$wpdb->prefix . self::TABLE_NAVIGATIONS.";";
			dbDelta($sql);
			$result = $wpdb->get_row("SELECT EXISTS (SELECT 1 FROM ".$wpdb->prefix . self::TABLE_NAVIGATIONS."_bkp) AS `exists`;", ARRAY_A);
			if(!empty($result) && isset($result['exists']) && $result['exists'] === '0'){
				$sql = "INSERT ".$wpdb->prefix . self::TABLE_NAVIGATIONS."_bkp SELECT * FROM ".$wpdb->prefix . self::TABLE_NAVIGATIONS.";";
				$wpdb->query($sql);
			}
		}
	}
}

?>