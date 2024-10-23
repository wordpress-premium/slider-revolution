<?php
/**
 * @author    ThemePunch <info@themepunch.com>
 * @link      https://www.themepunch.com/
 * @copyright 2024 ThemePunch
 */
 
if(!defined('ABSPATH')) exit();

class RevSliderWooCommerce extends RevSliderFunctions {
	
	const META_SKU	 = '_sku'; //can be 'instock' or 'outofstock'
	const META_STOCK = '_stock'; //can be 'instock' or 'outofstock'
	
	/**
	 * return true / false if the woo commerce exists
	 * @before RevSliderWooCommerce::isWooCommerceExists();
	 */
	public static function woo_exists(){
		return (class_exists('Woocommerce')) ? true : false;
	}
	
	
	/**
	 * compare wc current version to given version
	 */
	public static function version_check($version = '1.0') {
		if(self::woo_exists()){
			global $woocommerce;
			if(version_compare($woocommerce->version, $version, '>=')){
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 * get wc post types
	 */
	public static function getCustomPostTypes(){
		$arr = array(
			'product'			=> __('Product', 'revslider'),
			'product_variation'	=> __('Product Variation', 'revslider')
		);
		
		return $arr;
	}
	
	
	/**
	 * get price query
	 * @before: RevSliderWooCommerce::getPriceQuery()
	 */
	private static function get_price_query($from, $to, $meta_tag){
		$from	= (empty($from)) ? 0 : $from;
		$to		= (empty($to)) ? 9999999999 : $to;
		$query	= array(
			'key'		=> $meta_tag,
			'value'		=> array($from, $to),
			'type'		=> 'numeric',
			'compare'	=> 'BETWEEN'
		);
		
		return $query;
	}
	
	
	/**
	 * check if in pricerange
	 */
	private static function check_price_range($from, $to, $check){
		$from	= (empty($from)) ? 0 : $from;
		$to		= (empty($to)) ? 9999999999 : $to;
		
		return ($check > $from && $check < $to) ? true : false;
	}
	
	
	/**
	 * get meta query for filtering woocommerce posts.
	 * before: RevSliderWooCommerce::getMetaQuery();
	 * @6.5.23: removed _regular_price and _sale_price here, will be later checked under filter_products_by_price() to add the children
	 */
	public static function get_meta_query($args){
		$f			= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$query		= array();
		$meta_query	= array();
		$tax_query	= array();
		
		if($f->get_val($args, array('source', 'woo', 'inStockOnly')) == true){
			$meta_query[] = array(
				'key' => '_stock_status',
				'value' => 'instock',
				'compare' => '='
			);
		}
		
		if($f->get_val($args, array('source', 'woo', 'featuredOnly')) == true){
			$tax_query[] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
			);
		}

		$tax_query['relation'] = 'AND';
		$tax_query[] = array(
			'taxonomy' => 'product_visibility',
			'field'    => 'name',
			'terms'    => 'exclude-from-catalog',
			'operator' => 'NOT IN',
		);
		
		if(!empty($meta_query))	$query['meta_query'] = $meta_query;
		if(!empty($tax_query))	$query['tax_query'] = $tax_query;
		
		return $query;
	}


	/**
	 * filter posts by sales prices, also check for child products
	 * @since: 6.5.23
	 */
	public static function filter_products_by_price($posts, $args){
		if(empty($posts)) return $posts;

		$f					= RevSliderGlobals::instance()->get('RevSliderFunctions');
		$is_30				= RevSliderWooCommerce::version_check('3.0');
		$reg_price_from		= $f->get_val($args, array('source', 'woo', 'regPriceFrom'));
		$reg_price_to		= $f->get_val($args, array('source', 'woo', 'regPriceTo'));
		$sale_price_from	= $f->get_val($args, array('source', 'woo', 'salePriceFrom'));
		$sale_price_to		= $f->get_val($args, array('source', 'woo', 'salePriceTo'));
		$post_types			= $f->get_val($args, array('source', 'woo', 'types'), 'any');

		$meta_query = array();
		//get regular price array
		if(!empty($reg_price_from) || !empty($reg_price_to)){
			$meta_query[] = self::get_price_query($reg_price_from, $reg_price_to, '_regular_price');
		}
		
		//get sale price array
		if(!empty($sale_price_from) || !empty($sale_price_to)){
			$meta_query[] = self::get_price_query($sale_price_from, $sale_price_to, '_sale_price');
		}

		$_good_posts = array();
		foreach($posts as $key => $post){
			$product_id = $f->get_val($post, 'ID'); // ID of parent product
			$product    = ($is_30) ? wc_get_product($product_id) : get_product($product_id);

			if($product === false){
				$_good_posts[] = $post;
				unset($posts[$key]);
				continue;
			}
			
			//check if current post is okay with _regular_price and _sale_price
			if(!empty($reg_price_from) || !empty($reg_price_to) || !empty($sale_price_from) || !empty($sale_price_to)){
				$meta			= get_post_meta($product_id);
				$in_reg_range	= false;
				$in_sale_range	= false;
				if(!empty($reg_price_from) || !empty($reg_price_to)){
					$in_reg_range	= self::check_price_range($reg_price_from, $reg_price_to, $f->get_val($meta, '_regular_price'));
				}
				if(!empty($sale_price_from) || !empty($sale_price_to)){
					$in_sale_range	= self::check_price_range($sale_price_from, $sale_price_to, $f->get_val($meta, '_sale_price'));
				}

				if($in_reg_range || $in_sale_range){
					$_good_posts[] = $post;
					continue;
				}else{
					unset($posts[$key]);
				}
			}
			
			if(!empty($meta_query)){
				$my_posts	= new WP_Query(
					array(
						'post_parent'	=> $product_id, // ID of a page, post, or custom type
						'post_type'		=> $post_types,
						'meta_query'	=> $meta_query
					)
				);
				$_posts		= $my_posts->posts;
				if(!empty($_posts)){
					foreach($_posts as $child_post){
						$_good_posts[] = $child_post;
					}
				}
			}else{
				$_good_posts[] = $post;
			}
		}

		return $_good_posts;
	}
	
	
	/**
	 * get sortby function including standart wp sortby array
	 */
	public static function getArrSortBy(){
		
		$sort_by = array(
			'meta_num__regular_price'	=> __('Regular Price', 'revslider'),
			'meta_num__sale_price'		=> __('Sale Price', 'revslider'),
			'meta_num_total_sales'		=> __('Number Of Sales', 'revslider'),
			//'meta__featured'			=> __('Featured Products', 'revslider'),
			'meta__sku'					=> __('SKU', 'revslider'),
			'meta_num_stock'			=> __('Stock Quantity', 'revslider')
		);
		
		return $sort_by;
	}

	/**
	 * since WooCommerce 3.0 this function is deprecated as it could lead to performance issues
	 * this is a 1to1 copy of the named function without the deprecation message
	 **/
	public static function get_total_stock($product){
		if ( sizeof( $product->get_children() ) > 0 ) {
			$total_stock = max( 0, $product->get_stock_quantity() );

			foreach ( $product->get_children() as $child_id ) {
				if ( 'yes' === get_post_meta( $child_id, '_manage_stock', true ) ) {
					$stock = get_post_meta( $child_id, '_stock', true );
					$total_stock += max( 0, wc_stock_amount( $stock ) );
				}
			}
		} else {
			$total_stock = $product->get_stock_quantity();
		}
		
		return wc_stock_amount( $total_stock );
	}

	public static function get_wc_data($post_id, $text = ''){
		global $SR_GLOBALS;
		$is_30 = RevSliderWooCommerce::version_check('3.0');
		$product = ($is_30) ? wc_get_product($post_id) : get_product($post_id);

		if($product === false) return false;

		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');

		$wc_stock		= ($is_30) ? RevSliderWooCommerce::get_total_stock($product) : $product->get_total_stock();
		$wc_rating		= ($is_30) ? wc_get_rating_html($product->get_average_rating()) : $product->get_rating_html();
		$wc_categories	= ($is_30) ? wc_get_product_category_list($product->get_id(), ',') : $product->get_categories(',');
		$wc_tags		= ($is_30) ? wc_get_product_tag_list($product->get_id()) : $product->get_tags();
		$wc_add_to_cart_button = '';
		$wc_star_rating = ($SR_GLOBALS['front_version'] === 7) ? '<div class="sr-starring">' : '<div class="rs-starring">';
		preg_match_all('#<strong class="rating">.*?</span>#', $wc_rating, $match);
		if(!empty($match) && isset($match[0]) && isset($match[0][0])){
			$wc_star_rating .= str_replace($match[0][0], '', $wc_rating);
			$wc_star_rating = str_replace("Rated ","",$wc_star_rating);
		}
		$wc_star_rating .= '</div>';
		
		if(strpos($text, 'wc_add_to_cart_button') !== false){
			$pr_id			= ($is_30) ? $product->get_id() : $product->id;
			$pr_type		= ($is_30) ? $product->get_type() : $product->product_type;
			$suffix			= defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
			$ajax_cart_en	= get_option('woocommerce_enable_ajax_add_to_cart') == 'yes' ? true : false;
			$assets_path	= $f->remove_http(WC()->plugin_url()) . '/assets/';
			
			if($ajax_cart_en){
				wp_enqueue_script( 'wc-add-to-cart', $assets_path.'js/frontend/'.'add-to-cart'.$suffix.'.js', array('jquery'), WC_VERSION, true);
				
				global $wc_is_localized;
				if($wc_is_localized === false){ //load it only one time
					wp_localize_script('wc-add-to-cart', 'wc_add_to_cart_params', apply_filters('wc_add_to_cart_params', array(
						'ajax_url'			=> WC()->ajax_url(),
						'ajax_loader_url'	=> apply_filters('woocommerce_ajax_loader_url', $assets_path . 'images/ajax-loader@2x.gif'),
						'i18n_view_cart'	=> esc_attr__('View Cart', 'woocommerce'),
						'cart_url'			=> get_permalink(wc_get_page_id('cart')),
						'is_cart'			=> is_cart(),
						'cart_redirect_after_add' => get_option('woocommerce_cart_redirect_after_add')
					)));
					$wc_is_localized = true;
				}
			}
			
			$wc_add_to_cart_button = apply_filters(
				'woocommerce_loop_add_to_cart_link',
				sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
					esc_url($product->add_to_cart_url()),
					esc_attr($pr_id),
					esc_attr($product->get_sku()),
					$product->is_purchasable() ? 'add_to_cart_button' : '',
					esc_attr($pr_type),
					esc_html($product->add_to_cart_text())
				),
				$product
			);
		}
		
		return array(
			'wc_full_price'		=> $product->get_price_html(),
			'wc_price'			=> wc_price($product->get_price()),
			'wc_price_no_cur'	=> $product->get_price(),
			'wc_stock'			=> $wc_stock,
			'wc_rating'			=> $wc_rating,
			'wc_star_rating'	=> $wc_star_rating,
			'wc_categories'		=> $wc_categories,
			'wc_add_to_cart'	=> $product->add_to_cart_url(),
			'wc_add_to_cart_button'	=> $wc_add_to_cart_button,
			'wc_sku'			=> $product->get_sku(),
			'wc_stock_quantity'	=> $product->get_stock_quantity(),
			'wc_rating_count'	=> $product->get_rating_count(),
			'wc_review_count'	=> $product->get_review_count(),
			'wc_tags'			=> $wc_tags,
		);
	}

	/**
	 * modify layer text, to replace all meta
	 */
	public static function add_wc_layer($text, $post_id, $slide){
		if(RevSliderWooCommerce::woo_exists() === false) return $text;

		$data = RevSliderWooCommerce::get_wc_data($post_id, $text);
		if($data === false) return $text;
		
		foreach($data ?? [] as $tag => $value){
			$value = (empty($value)) ? '' : $value; //fix is null issue
			$text = str_replace(array('%'.$tag.'%', '{{'.$tag.'}}'), $value, $text);
		}
		
		return $text;
	}

	public static function add_wc_layer_v7($post_data, $data, $metas, $slider){
		if(RevSliderWooCommerce::woo_exists() === false) return $post_data;
		$f = RevSliderGlobals::instance()->get('RevSliderFunctions');

		foreach($post_data ?? [] as $key => $post){
			$content = $f->get_val($post, array('content', 'content'));
			$data = RevSliderWooCommerce::get_wc_data($f->get_val($post, 'id'), $content);
			if($data === false) continue;

			//modify excerpt if empty to be filled with content
			if(!isset($post['excerpt']) || trim($post['excerpt']) === ''){
				$post['excerpt'] = str_replace(array('<br/>', '<br />'), '', strip_tags($content, '<b><br><i><strong><small>'));
			}

			$post_data[$key] = array_merge($post, $data);
		}

		return $post_data;
	}
	
}	//end of the class

add_filter('sr_modify_layer_text', array('RevSliderWooCommerce', 'add_wc_layer'), 10, 3);
add_filter('sr_streamline_post_data_post', array('RevSliderWooCommerce', 'add_wc_layer_v7'), 10, 4);