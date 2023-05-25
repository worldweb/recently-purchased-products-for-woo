<?php 

/// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 *
 * Manage Widget Class
 *
 * @package Recently Purchased Products For Woo
 * @since 1.0
 */
if( !class_exists( 'RPPW_Create_Widget' ) ) {
	
	class RPPW_Create_Widget extends WP_Widget {
		
		// class constructor
		public function __construct(){
			
			$widget_ops = array(
				'classname' => 'widget_text', 
				'description' => esc_html__( 'Displays Recently Purchased Products For Woocommerce', 'recently-purchased-products-for-woo' )
			);	
			parent::__construct( 'rppw-widget', esc_html__( 'Recently Purchased Products For Woocommerce ', 'recently-purchased-products-for-woo' ), $widget_ops);			
		}
		
		/**
		 * Widget From HTML
		 *
		 * @package Recently Purchased Products For Woo
		 * @since 1.0
		 */
		public function form( $instance ){ 
		
			$title = ( isset( $instance['title'] ) && !empty( $instance['title'] ) ? ( $instance['title'] ): '' );
			$num_of_order = ( isset( $instance['num_of_order'] ) && !empty( $instance['num_of_order'] ) ? ( $instance['num_of_order'] ): '' );
			$order = ( isset( $instance['order'] ) && !empty( $instance['order'] ) ? ( $instance['order'] ): '' );
			
			$img = ( isset( $instance['img'] ) && !empty( $instance['img'] ) ? ( $instance['img'] ): '' );
			$img_size = ( isset( $instance['img_size'] ) && !empty( $instance['img_size'] ) ? ( $instance['img_size'] ): '' );
			
			$date = ( isset( $instance['date'] ) && !empty( $instance['date'] ) ? ( $instance['date'] ): '' );
			$price = ( isset( $instance['price'] ) && !empty( $instance['price'] ) ? ( $instance['price'] ): '' ); ?>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'recently-purchased-products-for-woo' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'img' ); ?>"><?php esc_html_e( 'Image:', 'recently-purchased-products-for-woo' ); ?></label> 
				<select id="<?php echo $this->get_field_id( 'img' ); ?>" name="<?php echo $this->get_field_name( 'img' ); ?>" class="widefat" style="width:100%;">
					<option value="Show"<?php selected( $img, 'Show' ); ?>><?php esc_html_e( 'Show', 'recently-purchased-products-for-woo' ); ?></option>
					<option value="Hide"<?php selected( $img, 'Hide' ); ?>><?php esc_html_e( 'Hide', 'recently-purchased-products-for-woo' ); ?></option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'img_size' ); ?>"><?php esc_html_e( 'Image Size:', 'recently-purchased-products-for-woo' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'img_size' ); ?>" name="<?php echo $this->get_field_name( 'img_size' ); ?>" type="number" value="<?php echo esc_attr( $img_size ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'num_of_order' ); ?>"><?php esc_html_e( 'Number of products to show:', 'recently-purchased-products-for-woo' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'num_of_order' ); ?>" name="<?php echo $this->get_field_name( 'num_of_order' ); ?>" type="number" value="<?php echo esc_attr( $num_of_order ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php esc_html_e( 'Date:', 'recently-purchased-products-for-woo' ); ?></label> 
				<select id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" class="widefat" style="width:100%;">
					<option value="Show"<?php selected( $date, 'Show' ); ?>><?php esc_html_e( 'Show', 'recently-purchased-products-for-woo' ); ?></option>
					<option value="Hide"<?php selected( $date, 'Hide' ); ?>><?php esc_html_e( 'Hide', 'recently-purchased-products-for-woo' ); ?></option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'price' ); ?>"><?php esc_html_e( 'Price:', 'recently-purchased-products-for-woo' ); ?></label> 
				<select id="<?php echo $this->get_field_id( 'price' ); ?>" name="<?php echo $this->get_field_name( 'price' ); ?>" class="widefat" style="width:100%;">
					<option value="Show"<?php selected( $price, 'Show' ); ?>><?php esc_html_e( 'Show', 'recently-purchased-products-for-woo' ); ?></option>
					<option value="Hide"<?php selected( $price, 'Hide' ); ?>><?php esc_html_e( 'Hide', 'recently-purchased-products-for-woo' ); ?></option>
				</select>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php esc_html_e( 'Order:', 'recently-purchased-products-for-woo' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:100%;">
					<option value="DESC"<?php selected( $order, 'DESC' ); ?>><?php esc_html_e( 'DESC', 'recently-purchased-products-for-woo' ); ?></option>
					<option value="ASC"<?php selected( $order, 'ASC' ); ?>><?php esc_html_e( 'ASC', 'recently-purchased-products-for-woo' ); ?></option>
				</select>
			</p>
			
			<?php
		}
		
		/**
		 * Update Widget From Data in DB
		 *
		 * @package Recently Purchased Products For Woo
		 * @since 1.0
		 */
		public function update( $new_instance, $old_instance ){
			
			$instance = $old_instance;
			$instance['title'] = ( isset( $new_instance['title'] ) && !empty( $new_instance['title'] ) ? ( $new_instance['title'] ) : '' );
			
			$instance['num_of_order'] = ( isset($new_instance['num_of_order'] ) && !empty( $new_instance['num_of_order'] ) ? ( $new_instance['num_of_order'] ) : '' );
			$instance['order'] = ( isset( $new_instance['order'] ) && !empty( $new_instance['order'] ) ? ( $new_instance['order'] ) : '' );
			
			$instance['img'] = ( isset( $new_instance['img'] ) && !empty( $new_instance['img'] ) ? ( $new_instance['img'] ) : '' );
			$instance['img_size'] = ( isset( $new_instance['img_size'] ) && !empty( $new_instance['img_size'] ) ? ( $new_instance['img_size'] ) : '' );
			
			$instance['date'] = ( isset( $new_instance['date'] ) && !empty( $new_instance['date'] ) ? ( $new_instance['date'] ) : '' );
			$instance['price'] = ( isset( $new_instance['price'] ) && !empty( $new_instance['price'] ) ? ( $new_instance['price'] ) : '' );
			
			return $instance;
		}
		
		/**
		 * Display Data in front site sidebar
		 *
		 * @package Recently Purchased Products For Woo
		 * @since 1.0
		 */
		public function widget( $args, $instance ){
			
			global $rppw_public;

			extract( $args );
			$title = apply_filters( 'widget_title', ( empty($instance['title'] ) ? '' : $instance['title'] ) );
			
			$num_of_order = ( isset( $instance['num_of_order'] ) && !empty( $instance['num_of_order'] ) ? $instance['num_of_order'] : '' );
			$order = ( isset( $instance['order'] ) && !empty( $instance['order'] ) ? $instance['order'] : '' );
			
			$img_view = ( isset( $instance['img'] ) && !empty( $instance['img'] ) ? $instance['img'] : '' );
			$img_size = ( isset( $instance['img_size'] ) && !empty( $instance['img_size'] ) ? $instance['img_size'] : '' );
			
			$date_view = ( isset( $instance['date'] ) && !empty( $instance['date'] ) ? $instance['date'] : '' );
			$price_view = ( isset( $instance['price'] ) && !empty( $instance['price'] ) ? $instance['price'] : '' );
			
			echo $before_widget;
			
			if( !empty( $title ) ){
				echo $before_title . $title . $after_title;
			}

			wp_enqueue_style( 'rppw-css' );

			$orders_list = $rppw_public->get_recently_order( $num_of_order, $order );			
			
			$out = '<ul class="recently_purchased_products_for_woo">';
			
			if( !empty( $orders_list ) && is_array( $orders_list ) ) {
				
				foreach ( $orders_list as $k => $order ) {
					
					setup_postdata( $order );
					$wc_order = wc_get_order( $order->ID );
 					$date = date( get_option( 'date_format' ), strtotime( $wc_order->get_date_created() ) );
					
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
						if( !empty( $img_view ) && strcmp( $img_view , 'Show' ) >= 0 ){
							
							if( isset( $product_ids[0]['variation_id'] ) && !empty( $product_ids[0]['variation_id'] ) ){
								
								$variation = new WC_Product_Variation( $product_ids[0]['variation_id'] );
								
								$image = wp_get_attachment_image( $variation->get_image_id(), array( $img_size, $img_size ), '', array('class' => 'alignleft') );
								$out .= '<div class="rppw_product_img"><a href="'.$url.'">'.$image.'</a></div>';
								
							}else {
								
								$image = get_the_post_thumbnail( $item_id, array( $img_size, $img_size ), array('class' => 'alignleft') );
								$out .= '<div class="rppw_product_img"><a href="'.$url.'">'.$image.'</a></div>';
							}
						}
						
						$out .= '<div class="rppw_product_title"><a href="'.$url.'">'.$product->get_title().'</a>';
						
						if( !empty( $price_view ) && strcmp( $price_view , 'Show' ) >= 0 ){
							
							$price = $product->get_price_html();
							$out .= '<span class="rppw_product_price price">'.$price.'</span>';
						}
						if( !empty( $date_view ) && strcmp( $date_view , 'Show' ) >= 0 ){
						
							$out .= '<span class="rppw_product_date">'.$date.'</span>';
						}
						$out .= '</div></li>';
					}
				}
				wp_reset_postdata();
			} else {
				$out .= '<li><span class="rppw_no_order">' . esc_html__( 'There are no recent purchases.', 'recently-purchased-products-for-woo' ) . '</span></div>';
			}
			$out .= '</ul>';
			
			echo $out;
			echo $after_widget;
		}			
	}	
}

if( !function_exists( 'rppw_register_widget' ) ) {

	function rppw_register_widget() {		
		register_widget( 'RPPW_Create_Widget' );
	}
	add_action( 'widgets_init', 'rppw_register_widget' );
}