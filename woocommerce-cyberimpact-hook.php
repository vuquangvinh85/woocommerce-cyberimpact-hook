<?php
/**
* Plugin Name: WooCommerce Cyberimpact Hook
* Plugin URI: https://marcandre.ca/woocih
* Description: Add the Cyberimpact Newsletter Optins Option in your WooCommerce Checkout.
* Version: 1.1
* Author: Marc-André Lavigne
* Author URI: https://marcandre.ca
* License: GPLv2 or later
**/
global $woocihVersion;
$woocihVersion = '1.1';

global $woocihName;
$woocihName = plugins_url() . '/' . dirname( plugin_basename( __FILE__ ) );

include_once( 'includes/register.php' );
include_once( 'includes/settings.php' );
include_once( 'includes/hook.php' );
include_once( 'includes/fields.php' );
?>