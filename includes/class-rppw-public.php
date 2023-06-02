<?php if ( ! defined( 'ABSPATH' ) ) { die; } // If this file is called directly, abort.

/**
 * The public specific Class of the plugin.
 *
 * @link       https://www.worldwebtechnology.com/
 * @since      1.0.0
 *
 * @package    Recently Purchased Products For Woo
 * @subpackage Recently Purchased Products For Woo/includes
 * @author     World Web Technology <biz@worldwebtechnology.com>
 */
if( !class_exists('RPPW_Public') ) {
	
	class RPPW_Public {


		/**
	     * Initialize the class and set its properties.
	     *
	     * @since      1.0.0
	     * @package    Recently Purchased Products For Woo
	     * @subpackage Recently Purchased Products For Woo/includes
	     * @author     World Web Technology <biz@worldwebtechnology.com>
	     */
		function __construct() {

		}


		/**
	     * Add Helper function to Get Recently Purchased Products
	     *
	     * @since      1.0.0
	     * @package    Recently Purchased Products For Woo
	     * @subpackage Recently Purchased Products For Woo/includes
	     * @author     World Web Technology <biz@worldwebtechnology.com>
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
	     * Add Callback function for the Grid/List Shortcode
	     *
	     * @since      1.0.0
	     * @package    Recently Purchased Products For Woo
	     * @subpackage Recently Purchased Products For Woo/includes
	     * @author     World Web Technology <biz@worldwebtechnology.com>
	     */
		public function rppw_get_recent_purchased_products( $atts, $content ){
			
			extract( shortcode_atts( array(
					'title' => '',
					'limit' => 5,
					'order' => 'DESC',
					'img' => 'Show',
					'img_size' => '100',
					'img_type' => '',
					'date' => 'Show',
					'price' => 'Show',
					'category' => 'Show',
					'cart' => '',
					'rating' => '',
					'view' => 'list',
					'grid_cols'=> '4',
					'customer_info' => 'show',
			), $atts ) );


			$out = '<div class="main_recently_purchased_products_for_woo">';
				if( !empty( $title ) ){
					//Hheading Text
					$out .= '<div class="rppw_order_title">' . $title . '</div>';
				}
				
				$orders_list = $this->get_recently_order( $limit, $order );
				wp_enqueue_style( 'rppw-css' );
				
				$columns = $col_class = '';

				if( strtolower($view) == 'grid'){
					$columns =  (int) $grid_cols;
				}	

				if(!empty($columns) ){
					$col_class = ' grid_cols_'.$columns;
				}

				$out .= '<ul class="recently_purchased_products_for_woo ' . $view . $col_class . '">';
				
				if( !empty( $orders_list ) && is_array( $orders_list ) ) {
					
					$product_cat_name = '';

					foreach ( $orders_list as $k => $order ) {
						
						setup_postdata( $order );

						$wc_order = wc_get_order( $order->ID );
						$wc_date = date( get_option( 'date_format' ), strtotime( $wc_order->get_date_created() ) );
						
						$customer_fname = $wc_order->get_billing_first_name();
						$customer_lname = $wc_order->get_billing_last_name();							
						$complete_date  = $wc_order->get_date_completed();
						$customer_ID = $wc_order->get_user_id();
						$customer_image = get_avatar( $customer_ID, $img_size, '', $customer_fname );

						$user_id = $wc_order->get_user_id();
						$products = $wc_order->get_items();
						$product_ids = array();						

						foreach( $products as $key => $product ){
							
							$variation_id = ( !empty( $product->get_variation_id() ) ? $product->get_variation_id() : '' );
							$product_ids[] = array( 'product_id' => $product->get_product_id(), 'variation_id' => $variation_id );
						}

						$product_ids = array_map("unserialize", array_unique(array_map("serialize", $product_ids)));

						$item_id = $product_ids[0]['product_id'];

						$terms = get_the_terms( $item_id, 'product_cat' );

						if( !empty($terms) ){

							foreach ($terms as $term) {

							    $product_cat_id = $term->term_id;
							    $product_cat_name = $term->name;
							    break;
							}
						}	
						
						$product = wc_get_product( $item_id );
						$url = get_permalink( $item_id );
						
						if( !empty( $product ) ){
							
							$out .=  '<li>';

							if( !empty( $img ) && strcmp( strtolower($img) , 'show' ) >= 0 ) {
								// Image Block
								if( strtolower($img_type) == 'avatar'){
									//User Avatar
									$out .= '<div class="rppw_product_img rppw_image_box"><a href="' . $url . '">' . $customer_image . '</a></div>';

								} else {
									// Product Image
									if( isset( $product_ids[0]['variation_id'] ) && !empty( $product_ids[0]['variation_id'] ) ){
										
										$variation = new WC_Product_Variation( $product_ids[0]['variation_id'] );
										
										$image = wp_get_attachment_image( $variation->get_image_id(), array( $img_size, $img_size ), '', array('class' => 'alignleft') );
										$out .= '<div class="rppw_product_img rppw_image_box"><a href="' . $url . '">' . $image . '</a></div>';
										
									} else {
										
										$image = get_the_post_thumbnail( $item_id, array( $img_size, $img_size ), array('class' => 'alignleft') );
										$out .= '<div class="rppw_product_img rppw_image_box"><a href="' . $url . '">' . $image . '</a></div>';
									}
								}
							}

							$out .= '<div class="rppw_product_info_box">';

							if( !empty( $product_cat_name ) && strcmp( strtolower($category) , 'show' ) >= 0 ) {

								$cat_url = get_term_link( $product_cat_id, 'product_cat' );
								// Product Category
								$out .= '<div class="rppw_product_category">';
								$out .= '<span class="product-cat">'. esc_html( 'Cat ', 'recently-purchased-products-for-woo' )  .'</span>';
								$out .= '<a href="' . $cat_url . '">' . $product_cat_name . '</a>';
								$out .= '</div>';
							}

							// Product Title
							$out .= '<div class="rppw_product_title"><a href="' . $url . '">' . $product->get_title() . '</a></div>';
							
							if( !empty( $customer_info ) && strcmp( strtolower($customer_info) , 'show' ) >= 0 ) {
								//Product Purchase By
								$out .= '<div class="rppw_product_customer_info">';
								$out .= '<span class="product-customer-info">'. esc_html( ' Purchased By ', 'recently-purchased-products-for-woo' ) . $customer_fname ." ". $customer_lname . '</span>';
								$out .= esc_html( ' for ', 'recently-purchased-products-for-woo' );
								$out .= '</div>';
							}
							
							if( !empty( $price ) && strcmp( $price , 'Show' ) >= 0 ){
								//Product Price
								$wc_price = $product->get_price_html();
								$out .= '<span class="rppw_product_price price">' . $wc_price . '</span>';
							}							

							if( !empty( $date ) && strcmp( $date , 'Show' ) >= 0 ){
								//Product Purchase date
								$out .= '<span class="rppw_product_date">' ." On ". $wc_date . '</span>';
							}

							if( !empty( $rating ) && strcmp( strtolower($rating) , 'show' ) >= 0 ){
								$rating  = $product->get_average_rating();
								$count   = $product->get_rating_count();

								//Product Ratings
								$out .= '<div class="rppw_product_ratings">';
								$out .= wc_get_rating_html( $rating, $count );
								$out .= '</div>';
							}

							if( !empty( $cart ) && strcmp( strtolower($cart) , 'show' ) >= 0 ){
								//Product Add to cart Button
								$out .= '<span class="rppw_product_cart_button">'. do_shortcode('[add_to_cart id="'.$product->get_id().'" style="border:0 solid #ccc; padding: 0px;" show_price="false" quantity="1"]') .'</span>';
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
	     * Add Callback function for the Slider Shortcode
	     *
	     * @since      1.0.2
	     * @package    Recently Purchased Products For Woo
	     * @subpackage Recently Purchased Products For Woo/includes
	     * @author     World Web Technology <biz@worldwebtechnology.com>
	     */
		public function rppw_get_recently_purchased_products_slider( $atts ){
			
			extract( shortcode_atts( array(
					'title' => '',
					'limit' => 5,
					'category' => 'Show',
					'cart' => '',
					'rating' => '',
					'order' => 'DESC',
					'img' => 'Show',
					'img_size' => '',
					'img_type' => '',
					'customer_info' => 'show',
					'date' => 'Show',
					'price' => 'Show',
					'slidestoshow' => '1',
					'slidestoscroll' => '1',
					'autoplay' => 'true',
					'dots' => 'true',
					'arrow' => 'true',
					'infinite' => 'true',					
			), $atts ) );

			ob_start();

			$out = '<div class="main_recently_purchased_products_for_woo rpp_slider_wrap">';
				if( !empty( $title ) ){
					$out .= '<div class="rppw_order_title">' . $title . '</div>';
				}
				
				$orders_list = $this->get_recently_order( $limit, $order );

				//Load plugin custom CSS file
				wp_enqueue_style( 'rppw-slick-style' );

				if( ! wp_style_is( 'rppw-css' ) ){	
					//Load plugin custom CSS file
					wp_enqueue_style( 'rppw-css' );
				}

				//Load plugin JS file				
				wp_enqueue_script( 'rppw-slick-script' );
				

				$out .= '<div class="recently_purchased_products_for_woo rpp_slider_box" id="qas_slider">';
				
				if( !empty( $orders_list ) && is_array( $orders_list ) ) {
					
					$product_cat_name = '';

					foreach ( $orders_list as $k => $order ) {
						
						setup_postdata( $order );

						$wc_order = wc_get_order( $order->ID );
						$wc_date = date( get_option( 'date_format' ), strtotime( $wc_order->get_date_created() ) );
						
						$customer_fname = $wc_order->get_billing_first_name();
						$customer_lname = $wc_order->get_billing_last_name();							
						$complete_date  = $wc_order->get_date_completed();
						$customer_ID    = $wc_order->get_user_id();
						$customer_image = get_avatar( $customer_ID, $img_size, '', $customer_fname );

						$user_id = $wc_order->get_user_id();
						$products = $wc_order->get_items();
						$product_ids = array();

						foreach( $products as $key => $product ){
							
							$variation_id = ( !empty( $product->get_variation_id() ) ? $product->get_variation_id() : '' );
							$product_ids[] = array( 'product_id' => $product->get_product_id(), 'variation_id' => $variation_id );
						}

						$product_ids = array_map("unserialize", array_unique(array_map("serialize", $product_ids)));

						$item_id = $product_ids[0]['product_id'];

						$terms = get_the_terms( $item_id, 'product_cat' );

						if( !empty($terms) ){

							foreach ($terms as $term) {

							    $product_cat_id = $term->term_id;
							    $product_cat_name = $term->name;
							    break;
							}
						}	
						
						$product = wc_get_product( $item_id );
						$url = get_permalink( $item_id );
						
						if( !empty( $product ) ){
							
							$out .=  '<div class="slider-item">';
							//Product Image
							if( !empty( $img ) && strcmp( strtolower($img) , 'show' ) >= 0 ) {
									
								if( strtolower($img_type) == 'avatar'){
									//User avatar
									$out .= '<div class="rppw_product_img rppw_image_box"><a href="' . $url . '">' . $customer_image . '</a></div>';

								} else {
									// Product Image
									if( isset( $product_ids[0]['variation_id'] ) && !empty( $product_ids[0]['variation_id'] ) ){
										//Variation image
										$variation = new WC_Product_Variation( $product_ids[0]['variation_id'] );
										
										$image = wp_get_attachment_image( $variation->get_image_id(), array( $img_size, $img_size ), '', array('class' => 'alignleft') );
										$out .= '<div class="rppw_product_img rppw_image_box"><a href="' . $url . '">' . $image . '</a></div>';
										
									} else {
										
										$image = get_the_post_thumbnail( $item_id, array( $img_size, $img_size ), array('class' => 'alignleft') );
										$out .= '<div class="rppw_product_img rppw_image_box"><a href="' . $url . '">' . $image . '</a></div>';
									}
								}
							}

							$out .= '<div class="rppw_product_info_data">';

							if( !empty( $product_cat_name ) && strcmp( strtolower($category) , 'show' ) >= 0 ) {

								$cat_url = get_term_link( $product_cat_id, 'product_cat' );
								// Product Category
								$out .= '<div class="rppw_product_category">';
								$out .= '<span class="product-cat">'. esc_html( 'Cat ', 'recently-purchased-products-for-woo' )  .'</span>';
								$out .= '<a href="' . $cat_url . '">' . $product_cat_name . '</a>';
								$out .= '</div>';
							}

							$out .= '<div class="rppw_product_title"><a href="' . $url . '">' . $product->get_title() . '</a></div>';

							if( !empty( $customer_info ) && strcmp( strtolower($customer_info) , 'show' ) >= 0 ) {
								// Product Purchase By
								$out .= '<div class="rppw_product_customer_info">';
								$out .= '<span class="product-customer-info">'. esc_html( ' Purchased By ', 'recently-purchased-products-for-woo' ) . $customer_fname ." ". $customer_lname . '</span>';
								$out .= esc_html( ' for ', 'recently-purchased-products-for-woo' );
								$out .= '</div>';
							}

							if( !empty( $price ) && strcmp( $price , 'Show' ) >= 0 ){
								
								$wc_price = $product->get_price_html();
								// Product Price
								$out .= '<div class="rppw_product_price_box">';
								$out .= '<span class="rppw_product_price price">' . $wc_price . '</span>';
								$out .= '</div>';

							}							

							if( !empty( $date ) && strcmp( $date , 'Show' ) >= 0 ){
								// Product Purchase Date
								$out .= '<div class="rppw_product_date_box">';
								$out .= '<span class="rppw_product_date">' ." On ". $wc_date . '</span>';
								$out .= '</div>';
							}

							if( !empty( $rating ) && strcmp( strtolower($rating) , 'show' ) >= 0 ){
								// Product Ratings
								$rating  = $product->get_average_rating();
								$count   = $product->get_rating_count();

								$out .= '<div class="rppw_product_ratings">';
								$out .= wc_get_rating_html( $rating, $count );
								$out .= '</div>';
							}

							if( !empty( $cart ) && strcmp( strtolower($cart) , 'show' ) >= 0 ){
								// Product Add to cart Button
								$out .= '<div class="rppw_product_cart_btn">';
								$out .= '<span class="rppw_product_cart_button">'. do_shortcode('[add_to_cart id="'.$product->get_id().'" style="border:0 solid #ccc; padding: 0px;" show_price="false" quantity="1"]') .'</span>';
								$out .= '</div>';
							}

							$out .= '</div>';
							$out .= '</div>';
						}
					}
					wp_reset_postdata();
					?>
					<script type="text/javascript">
					jQuery(document).ready(function () {
						if(jQuery('.rpp_slider_box').length){
							jQuery('.rpp_slider_box').slick({
							    arrow: <?php echo $arrow; ?>,
								dots: <?php echo $dots; ?>,
								dotsClass:'slick-dots',
								speed: 500,
								infinite: <?php echo $infinite; ?>,
    							autoplay: <?php echo $autoplay; ?>,
    							autoplaySpeed: 3000,
    							slidesToShow: <?php echo $slidestoshow; ?>,
    							slidesToScroll: <?php echo $slidestoscroll; ?>,
							});
						}
					});
				</script>
				<?php

				}else{
					$out .= '<div><span class="rppw_no_order"><strong>' . esc_html( 'There are no recent purchases.', 'recently-purchased-products-for-woo' ) . '</strong></span></div>';
				}
				$out .= '</div>';
			$out .= '</div>';
			$out .= ob_get_clean();
			
			return $out;
		}


		/**
	     * Add Actions/Hooks
	     *
	     * @since      1.0.0
	     * @package    Recently Purchased Products For Woo
	     * @subpackage Recently Purchased Products For Woo/includes
	     * @author     World Web Technology <biz@worldwebtechnology.com>
	     */
		public function add_hooks() {
			
			// Grid View Shortcode
			add_shortcode( 'recently_purchased_products', array( $this, 'rppw_get_recent_purchased_products' ) );

			// Slider View Shortcode
			add_shortcode( 'recently_purchased_products_slider', array( $this, 'rppw_get_recently_purchased_products_slider' ) );
		}
	}
}