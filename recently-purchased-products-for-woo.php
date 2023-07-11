<?php
/**
 * Plugin Name: Recently Purchased Products For Woo
 * Plugin URI: https://wordpress.org/plugins/recently-purchased-products-for-woo
 * Description: Display Recently Purchased Products For Woocommerce using Widget and Shortcode
 * Version: 1.0.3
 * Author: World Web Technology
 * Author URI: http://www.worldwebtechnology.com
 * Text Domain: recently-purchased-products-for-woo
 * Domain Path: languages
 * 
 * WC tested up to: 7.7.1
 * Tested up to: 6.2.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) || ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Basic plugin definitions 
 * 
 * @package Recently Purchased Products For Woo
 * @since 1.0
 */

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if( !defined( 'RPPW_VERSION' ) ) {
	define( 'RPPW_VERSION', '1.0.3' ); // Plugin Version
}

if( !defined( 'RPPW_DIR' ) ) {
  define( 'RPPW_DIR', dirname( __FILE__ ) ); // Plugin dir
}

if( !defined( 'RPPW_URL' ) ) {
  define( 'RPPW_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}

if( !defined( 'RPPW_INC_DIR' ) ) {
  define( 'RPPW_INC_DIR', RPPW_DIR.'/includes' ); // Plugin include dir
}

if( !defined( 'RPPW_INC_URL' ) ) {
  define( 'RPPW_INC_URL', RPPW_URL.'includes' ); // Plugin include url
}

if( !defined( 'RPPW_ADMIN_DIR' ) ) {
  define( 'RPPW_ADMIN_DIR', RPPW_INC_DIR.'/admin' ); // Plugin admin dir
}

if( !defined( 'RPPW_PLUGIN_BASENAME' ) ) {
	define( 'RPPW_PLUGIN_BASENAME', basename( RPPW_DIR ) ); //Plugin base name
}

if( !defined( 'RPPW_PREFIX' ) ) {
  define('RPPW_PREFIX', 'rppw'); // Plugin Prefix
}

if( !defined( 'RPPW_VAR_PREFIX' ) ) {
  define('RPPW_VAR_PREFIX', '_rppw_'); // Variable Prefix
}

if( !defined( 'NO_IMAGE_PNG' ) ) {
  define('NO_IMAGE_PNG', 'no-image.png'); // Default image
}


/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 * 
 * @since      1.0.0
 * @package    Recently Purchased Products For Woo
 * @author     World Web Technology <biz@worldwebtechnology.com>
 * 
 */
function rppw_load_text_domain() {
	
	// Set filter for plugin's languages directory
	$rppw_lang_dir	= dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$rppw_lang_dir	= apply_filters( 'rppw_languages_directory', $rppw_lang_dir );
	
	// Traditional WordPress plugin locale filter
	$locale	= apply_filters( 'plugin_locale',  get_locale(), 'recently-purchased-products-for-woo' );
	$mofile	= sprintf( '%1$s-%2$s.mo', 'recently-purchased-products-for-woo', $locale );
	
	// Setup paths to current locale file
	$mofile_local	= $rppw_lang_dir . $mofile;
	$mofile_global	= WP_LANG_DIR . '/' . RPPW_PLUGIN_BASENAME . '/' . $mofile;
	
	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/recently-purchased-products-for-woo folder
		load_textdomain( 'recently-purchased-products-for-woo', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) { // Look in local /wp-content/plugins/recently-purchased-products-for-woo/languages/ folder
		load_textdomain( 'recently-purchased-products-for-woo', $mofile_local );
	} else { // Load the default language files
		load_plugin_textdomain( 'recently-purchased-products-for-woo', false, $rppw_lang_dir );
	}
}


/**
 * Prints an error that the system requirements weren't met.
 * 
 * @since      1.0.0
 * @package    Recently Purchased Products For Woo
 * @author     World Web Technology <biz@worldwebtechnology.com>
 * 
 */
if( !function_exists( 'rppw_woocommerce_required_error' ) ) {
	
	function rppw_woocommerce_required_error() {
		
		echo '<div class="notice notice-error">
				<p>'. sprintf( esc_html__( 'Recently Purchased Products requires %WooCommerce% plugin to be active.', 'recently-purchased-products-for-woo' ), '<strong>', '</strong>') . '</p>
			</div>';
	}
}


/**
 * Load plugin after dependent plugin is loaded successfully
 * 
 * @since      1.0.0
 * @package    Recently Purchased Products For Woo
 * @author     World Web Technology <biz@worldwebtechnology.com>
 * 
 */
function rppw_plugin_loaded() {
	
	//check Woocommerce is activated or not
	if( class_exists( 'Woocommerce' ) ) {
		
		// load first plugin text domain
		rppw_load_text_domain();

		// Delclare global variable to make it customizable without making changes in plugin
		global $rppw_admin, $rppw_public, $rppw_scripts;

		include_once( RPPW_INC_DIR.'/class-rppw-admin.php' );
		$rppw_admin = new RPPW_Admin();
		$rppw_admin->add_hooks();
		

		include_once( RPPW_INC_DIR.'/class-rppw-public.php' );
		$rppw_public = new RPPW_Public();
		$rppw_public->add_hooks();

		/* 
		* Widget Script and Style Class 
		*/
		include_once( RPPW_INC_DIR.'/class-rppw-scripts.php' );
		$rppw_scripts = new RPPW_Scripts();
		$rppw_scripts->add_hooks();

		/* 
		* Widget class
		*/
		include_once( RPPW_INC_DIR.'/widget/class-rppw-widget.php' );	

	} else {
		add_action( 'admin_notices', 'rppw_woocommerce_required_error' );
	}
}
//add action to load plugin
add_action( 'plugins_loaded', 'rppw_plugin_loaded' );


/**
 * Add custom links on the Plugin page
 * 
 * @since      1.0.2
 * @package    Recently Purchased Products For Woo
 * @author     World Web Technology <biz@worldwebtechnology.com>
 * 
 */
function rppw_add_action_links( $actions ) {
    
  	$custom_actions[] = '<a href="https://www.worldwebtechnology.com/our-portfolio/" target="_blank">'. __('More by World Web Technology','	recently-purchased-products-for-woo') . '</a>';
    
  	return array_merge( $actions, $custom_actions );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'rppw_add_action_links' );