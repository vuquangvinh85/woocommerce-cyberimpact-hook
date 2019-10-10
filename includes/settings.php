<?php
/**
 * WooCommerce CyberImpact Hook Settings
 *
 * @package woocih
 * @version 1.1
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
	register_setting( 'woocih-settings-group', 'woocih_mandatory' );
	register_setting( 'woocih-settings-group', 'woocih_french_id' );
	register_setting( 'woocih-settings-group', 'woocih_english_id' );
	register_setting( 'woocih-settings-group', 'woocih_checkbox_label' );
	
	// Tab #2
}


// Create Setting Page
function woocih_settings_page() {
?>
<style>
	.woocih-tabs hr {
		margin: 2em 0 3em;
	}
	.woocih-tabs th {
		position: relative;
	}
	.woocih__abouticon {
		width: 16px;
		display: inline-block;
		position: absolute;
		right: 15px;
		top: 50%;
		transform: translateY(-50%);
	}
	.woocih__abouttooltip {
		visibility: hidden;
		width: 135%;
		background-color: #555;
		color: #fff;
		text-align: center;
		padding: 10px 12px;
		border-radius: 6px;
		position: absolute;
		z-index: 1;
		bottom: -90%;
		left: 0;
		opacity: 0;
		-webkit-transition: opacity .3s;
		transition: opacity .3s;
		font-size: 12px;
	}
	.woocih__abouttooltip a {
		color: #25b7d3;
	}
	.woocih__abouttooltip:after {
		content: "";
		position: absolute;
		bottom: 100%;
		left: 50%;
		margin-left: -5px;
		border-width: 5px;
		border-style: solid;
		border-color: transparent transparent #555 transparent;
	}
	.woocih__about:hover .woocih__abouttooltip {
	    visibility: visible;
	    opacity: 1;
	}
</style>
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
			    <p><?php _e('Supporting optin API only. This field is mandatory.', 'woocih'); ?></p>
			    <table class="form-table">
			        <tr valign="top">
			        	<th scope="row" class="woocih__about"><?php _e('Cyberimpact API Token', 'woocih'); ?> <img class="woocih__abouticon" src="<?php echo $GLOBALS['woocihName']; ?>/includes/assets/img/question.svg" /><span class="woocih__abouttooltip"><?php _e('Refer to <a target="_blank" rel="noopener noreferrer" href="http://faq.cyberimpact.com/articles/21/api?l=en_ca">Cyberimpact official documentation</a> to learn how to get your API Token.', 'woocih'); ?></span></th>
						<td><input type="text" name="woocih_api_key" value="<?php echo esc_attr( get_option('woocih_api_key') ); ?>" /></td>
			        </tr>
			    </table>
			    <hr />
			    <h3><?php _e('Display Settings', 'woocih'); ?></h3>
			    <table class="form-table">
			        <tr valign="top">
			        	<th scope="row" class="woocih__about"><?php _e('Make Subscription Mandatory', 'woocih'); ?> <img class="woocih__abouticon" src="<?php echo $GLOBALS['woocihName']; ?>/includes/assets/img/question.svg" /><span class="woocih__abouttooltip"><?php _e('Might not be legal to make the newsletter subscription mandatory. You might want to validate your local laws before making the field mandatory.', 'woocih'); ?></span></th>
						<td><input type="checkbox" name="woocih_mandatory"  value="1" <?php echo checked( 1, get_option('woocih_mandatory'), false ); ?> /></td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><?php _e('Checkbox Label Text', 'woocih'); ?></th>
						<td><input type="text" name="woocih_checkbox_label" value="<?php echo esc_attr( get_option('woocih_checkbox_label') ); ?>" /></td>
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
			<p><b><?php _e('This plugin is not developed by or affiliated with Cyberimpact. It’s a plugin that has been built to fill a need that I had.', 'woocih'); ?></b></p>
			<p><?php _e('The plugin currently support only one french and one english mailing list. The hook connect to the optin API only. Please lookup the /includes/hook.php file if you need any other functionalities.', 'woocih'); ?></p>
			<p><?php _e('For more info, lookout my personal website <a href="https://marcandre.ca/woocih" target="_blank" rel="noopener noreferrer">here</a>.', 'woocih'); ?></p>
		</div>
	</div>
</div>
<?php } ?>
