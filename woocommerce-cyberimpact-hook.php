<?php
/**
* Plugin Name: WooCommerce Cyberimpact Hook
* Plugin URI: https://marcandre.ca/woocih
* Description: Add the Cyberimpact Newsletter Optins Option in your WooCommerce Checkout.
* Version: 1.0
* Author: Marc-André Lavigne
* Author URI: https://marcandre.ca
* Text Domain: woocih
* Domain Path: /languages/
* License: GPLv2 or later
**/

// Plugin Version
global $woocihVersion;
$woocihVersion = '1.0';

// Plugin Directory Path
global $woocihName;
$woocihName = plugins_url() . '/' . dirname( plugin_basename( __FILE__ ) );

// Includes
include_once( 'includes/register.php' );
include_once( 'includes/settings.php' );
include_once( 'includes/hook.php' );
include_once( 'includes/fields.php' );

// Localisation
load_plugin_textdomain('woocih', false, basename( dirname( __FILE__ ) ) . '/languages');

?>