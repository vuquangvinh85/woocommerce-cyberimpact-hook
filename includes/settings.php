<?php
/**
 * SWooCommerce CyberImpact Hook Settings
 *
 * @package woocih
 * @version 0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}




// Create custom plugin settings menu
add_action('admin_menu', 'woocih_create_menu');
function woocih_create_menu() {
	//create new top-level menu
	add_menu_page('Cyberimpact', 'Cyberimpact', 'administrator', __FILE__, 'woocih_settings_page' , plugins_url('/assets/img/icon.png', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'register_woocih_settings' );
}


// register fields in WP Options (wp-admin/options.php)
function register_woocih_settings() {
	
	// Tab #1
	register_setting( 'woocih-settings-group', 'woocih_api_key' );
	register_setting( 'woocih-settings-group', 'woocih_french_id' );
	register_setting( 'woocih-settings-group', 'woocih_english_id' );
	
	// Tab #2
}


// Create Setting Page
function woocih_settings_page() {
?>
<div class="wrap">
	<h1><?php _e('WooCommerce Cyberimpact Hook Settings', 'woocih'); ?></h1>

	<div class="woocih-tabs-nav nav-tab-wrapper">
		<div id="tab1" class="nav-tab nav-tab-active">
			<?php _e('Settings', 'woocih'); ?>
		</div>
		<div id="tab2" class="nav-tab">
			<?php _e('About', 'woocih'); ?>
		</div>
	</div>
	<div class="woocih-tabs">
		<div class="tab tab1">
			<form method="post" action="options.php">
			    <?php settings_fields( 'woocih-settings-group' ); ?>
			    <?php do_settings_sections( 'woocih-settings-group' ); ?>
			    <h3><?php _e('API Settings', 'woocih'); ?></h3>
			    <p><?php _e('Supporting optin API only.', 'woocih'); ?></p>
			    <table class="form-table">
			        <tr valign="top">
			        	<th scope="row"><?php _e('Cyberimpact API Token', 'woocih'); ?></th>
						<td><input type="text" name="woocih_api_key" value="<?php echo esc_attr( get_option('woocih_api_key') ); ?>" /></td>
			        </tr>
			    </table>
			    <hr />
			    <h3><?php _e('Mailing List Settings', 'woocih'); ?></h3>
			    <p><?php _e('Enter your mailing list ID. Leave empty to disable the list.', 'woocih'); ?></p>
			    <table class="form-table">
			        <tr valign="top">
			        	<th scope="row"><?php _e('Mailing List ID (French)', 'woocih'); ?></th>
						<td><input type="number" name="woocih_french_id" value="<?php echo esc_attr( get_option('woocih_french_id') ); ?>" /></td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><?php _e('Mailing List ID (English)', 'woocih'); ?></th>
						<td><input type="number" name="woocih_english_id" value="<?php echo esc_attr( get_option('woocih_english_id') ); ?>" /></td>
			        </tr>
			    </table>
			    <?php submit_button(); ?>
			</form>
		</div>
		<div class="tab tab2" style="display: none;">
			<p><b>This plugin is not developed by or affiliated with Cyberimpact. It’s a plugin that has been built to fill a need that I had.</b></p>
			<p>The plugin currently support only one french and one mailing list. The hook connect to the optin API only. Please lookup the /includes/hook.php file if you need any other functionalities.</p>
			<p>For more info, lookout my personal website <a href="https://marcandre.ca/woocih">here</a>.</p>
			<p>Cheers!</p>
		</div>
	</div>
</div>
<?php } ?>