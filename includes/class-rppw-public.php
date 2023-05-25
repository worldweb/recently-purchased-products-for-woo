<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Class
 *
 * Manage Admin Panel Class
 *
 * @package Recently Purchased Products For Woo
 * @since 1.0
 */
if( !class_exists('RPPW_Public') ) {
	
	class RPPW_Public {

		// class constructor
		function __construct() {
		}		
		
		/**
		 * Get Recently Purchased Products
		 *
		 * @package Recently Purchased Products For Woo
		 * @since 1.0
		 */
		public function get_recently_order( $limit = 5, $order = 'DESC' ){
						
			$args = array(
				'post_type' => wc_get_order_types(),
				'post_status' => array( 'wc-completed', 'wc-processing' ),
				'posts_per_page' => $limit,
				'orderby' => 'ID',
				'order' => $order,
			);
			
			$orders_list = get_posts( $args );			
			return $orders_list;
		}
		
		/**
		 * Adding Function for Shortcode
		 *
		 * @package Recently Purchased Products For Woo
		 * @since 1.0
		 */
		public function rppw_get_recent_purchased_products( $atts, $content ){
			
			extract( shortcode_atts( array(
					'title' => '',
					'limit' => 5,
					'order' => 'DESC',
					'img' => 'Show',
					'img_size' => '',
					'date' => 'Show',
					'price' => 'Show',
					'view' => 'list'
			), $atts ) );
			
			$out = '<div class="main_recently_purchased_products_for_woo">';
				if( !empty( $title ) ){
					$out .= '<div class="rppw_order_title">' . $title . '</div>';
				}
				
				$orders_list = $this->get_recently_order( $limit, $order );
				wp_enqueue_style( 'rppw-css' );
				
				$out .= '<ul class="recently_purchased_products_for_woo ' . $view . '">';
				
				if( !empty( $orders_list ) && is_array( $orders_list ) ) {
					
					foreach ( $orders_list as $k => $order ) {
						
						setup_postdata( $order );
						$wc_order = wc_get_order( $order->ID );
						$wc_date = date( get_option( 'date_format' ), strtotime( $wc_order->get_date_created() ) );
						
						$user_id = $wc_order->get_user_id();
						$products = $wc_order->get_items();
						$product_ids = array();
						foreach( $products as $key => $product ){
							
							$variation_id = ( !empty( $product->get_variation_id() ) ? $product->get_variation_id() : '' );
							$product_ids[] = array( 'product_id' => $product->get_product_id(), 'variation_id' => $variation_id );
						}
						
						$product_ids = array_map("unserialize", array_unique(array_map("serialize", $product_ids)));
						$item_id = $product_ids[0]['product_id'];
						
						$product = wc_get_product( $item_id );
						$url = get_permalink( $item_id );
						
						if( !empty( $product ) ){
							
							$out .=  '<li>';
							if( !empty( $img ) && strcmp( $img , 'Show' ) >= 0 ) {
								
								if( isset( $product_ids[0]['variation_id'] ) && !empty( $product_ids[0]['variation_id'] ) ){
									
									$variation = new WC_Product_Variation( $product_ids[0]['variation_id'] );
									
									$image = wp_get_attachment_image( $variation->get_image_id(), array( $img_size, $img_size ), '', array('class' => 'alignleft') );
									$out .= '<div class="rppw_product_img"><a href="' . $url . '">' . $image . '</a></div>';
									
								} else {
									
									$image = get_the_post_thumbnail( $item_id, array( $img_size, $img_size ), array('class' => 'alignleft') );
									$out .= '<div class="rppw_product_img"><a href="' . $url . '">' . $image . '</a></div>';
								}
							}
							
							$out .= '<div class="rppw_product_title"><a href="' . $url . '">' . $product->get_title() . '</a>';
							
							if( !empty( $price ) && strcmp( $price , 'Show' ) >= 0 ){
								
								$wc_price = $product->get_price_html();
								$out .= '<span class="rppw_product_price price">' . $wc_price . '</span>';
							}
							if( !empty( $date ) && strcmp( $date , 'Show' ) >= 0 ){
							
								$out .= '<span class="rppw_product_date">' . $wc_date . '</span>';
							}
							
							$out .= '</div></li>';
						}
					}
					wp_reset_postdata();
					
				}else{
					$out .= '<li><span class="rppw_no_order"><strong>' . esc_html( 'There are no recent purchases.', 'recently-purchased-products-for-woo' ) . '</strong></span></div>';
				}
				$out .= '</ul>';
			$out .= '</div>';
			
			return $out;
		}

		/**
		 * Adding Hooks
		 *
		 * @package Recently Purchased Products For Woo
		 * @since 1.0
		 */
		public function add_hooks() {
			
			add_shortcode( 'recently_purchased_products', array( $this, 'rppw_get_recent_purchased_products' ) );
		}
	}
}