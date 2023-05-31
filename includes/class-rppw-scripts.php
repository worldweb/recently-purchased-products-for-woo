<?php if ( ! defined( 'ABSPATH' ) ) { die; } // If this file is called directly, abort.

/**
 * The public specific Scripts Class of the plugin.
 *
 * @link       https://www.worldwebtechnology.com/
 * @since      1.0.0
 *
 * @package    Recently Purchased Products For Woo
 * @subpackage Recently Purchased Products For Woo/includes
 * @author     World Web Technology <biz@worldwebtechnology.com>
 */
if ( !class_exists( 'RPPW_Scripts' ) ) {
	
	class RPPW_Scripts {


		/**
	     * Initialize the class and set its properties.
	     *
	     * @since      1.0.0
	     * @package    Recently Purchased Products For Woo
	     * @subpackage Recently Purchased Products For Woo/includes
	     * @author     World Web Technology <biz@worldwebtechnology.com>
	     */
		public function __construct() {
		
		}


		/**
		 * Add Scripts for Frontend page
		 * 
		 * @since      1.0.2
		 * @package    Recently Purchased Products For Woo
	     * @subpackage Recently Purchased Products For Woo/includes
		 * @author     World Web Technology <biz@worldwebtechnology.com>
		 * 
		 */
		public function rppw_frontend_scripts() {
	
			//Style			
			wp_register_style( 'rppw-slick-style', RPPW_INC_URL . '/assets/css/slick.css', array(), RPPW_VERSION );
			wp_register_style( 'rppw-css', RPPW_INC_URL . '/assets/css/rppw-style.css', array(), RPPW_VERSION );

			//script
			wp_register_script('rppw-slick-script', RPPW_INC_URL . '/assets/js/slick.min.js', array('jquery'), RPPW_VERSION, true);
			wp_register_script('rppw-public-script', RPPW_INC_URL . '/assets/js/rppw-public.js', array('jquery'), RPPW_VERSION, true);	
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
						
			add_action( 'wp_enqueue_scripts', array( $this, 'rppw_frontend_scripts' ) );
		}
	}
}