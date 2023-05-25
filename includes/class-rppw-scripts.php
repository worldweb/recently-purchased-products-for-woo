<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Scripts Class
 *
 * @package Recently Purchased Products For Woo
 * @since 1.0
 */
if ( !class_exists( 'RPPW_Scripts' ) ) {
	
	class RPPW_Scripts {
		
		function __construct() {}		
		
		/**
		 * Scripts for frontend
		 * 
		 * @package Recently Purchased Products For Woo
		 * @since 1.0
		 */
		public function rppw_frontend_scripts() {
			
			wp_register_style( 'rppw-css', RPPW_INC_URL . '/assets/css/rppw-style.css', array(), RPPW_VERSION );
		}
		
		public function add_hooks() {
						
			add_action( 'wp_enqueue_scripts', array( $this, 'rppw_frontend_scripts' ) );
		}
	}
}