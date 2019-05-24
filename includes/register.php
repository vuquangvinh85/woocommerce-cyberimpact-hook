<?php
/**
 * WooCommerce CyberImpact Hook register styles, scripts and Custom post
 *
 * @package woocih
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue admin styles and scripts
 *
 * @return void
 */
add_action( 'admin_enqueue_scripts', 'woocih_admin_assets' );
function woocih_admin_assets() {
	
	// Admin Styles
	wp_enqueue_style( 'woocih-admin-styles', $GLOBALS['woocihName'] . '/includes/assets/css/admin.css', array(), $GLOBALS['woocihVersion'], true);
	
	// Admin Script
	wp_enqueue_script('woocih-admin-script', $GLOBALS['woocihName'] . '/includes/assets/js/admin.js', array( 'jquery' ), $GLOBALS['woocihVersion'], true );
}


/**
 * Enqueue front-end scripts and styles
 *
 * @return void
 */

add_action('wp_enqueue_scripts', 'woocih_front_assets');
function woocih_front_assets() {
	$vars = array(
		'site_url'      => home_url(),
		'template_url'  => get_template_directory_uri(),
		'site_title'    => get_bloginfo( 'name' ),
	    'pluginsUrl' 	=> $GLOBALS['pluginName'],
	);
	
	// Front-end Style
    wp_register_style( 'woocih-front-style', $GLOBALS['woocihName'] . '/includes/assets/css/front.css', array(), $GLOBALS['woocihVersion'], true);
    wp_enqueue_style( 'woocih-front-style' );
    
    // Front-end Script
    wp_enqueue_script('woocih-front-script', $GLOBALS['woocihName'] . '/includes/assets/js/front.js', array( 'jquery' ), $GLOBALS['woocihVersion'], true );
	wp_localize_script('woocih-front-script', 'woocihFront', $vars);
}