<?php
	
	/**
	 * WooCommerce CyberImpact Hook Custom Fields
	 *
	 * @package woocih
	 * @version 1.1
	 */
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}
	
	
	/**
	* Add Custom Fields to WooCommerce Billing Form
	*/
	add_filter( 'woocommerce_checkout_fields' , 'woocih_override_checkout_fields' );
	function woocih_override_checkout_fields( $fields ) {
		
		// Cyberimpact API Token
		$woocihToken = get_option( 'woocih_api_key' );
		
		// Display Settings
		$woocihMandatory = get_option( 'woocih_mandatory' );
		$woocihCheckbox = get_option( 'woocih_checkbox_label' );
		
		if($woocihCheckbox == '' ) {
			$woocihCheckbox = __('I want to subscribe to the newsletter', 'woocih');
		}
		
		// Create Newsletter Checkbox
		if ($woocihToken != '') {
			$fields['billing']['woocih_newsletter'] = array(
				'type'		=> 'checkbox',
				'label'     => $woocihCheckbox,
				'required'  => $woocihMandatory,
				'class'     => array('form-row-other'),
				'options' 	=> array(
					'Oui' 	=> __('Yes', 'woocih'),
				)
			);
		}
		
		// Create woocih_language Field
		$fields['billing']['woocih_language'] = array(
		    'class'     => array('woocih-current-woocih_language'),
		    'required'  => false,
		);
		return $fields;
	}
	
	
	/**
	 * Save Custom Fields to User Meta after Checkout
	 */
	add_action( 'woocommerce_checkout_update_user_meta', 'woocih_woocommerce_checkout_update_user_meta', 10, 2 );
	function woocih_woocommerce_checkout_update_user_meta( $customer_id, $posted ) {
	    if (isset($posted['woocih_newsletter'])) {
	        $woocihnewsletter = sanitize_text_field( $posted['woocih_newsletter'] );
	        update_user_meta( $customer_id, 'woocih_newsletter', $woocihnewsletter);
	    }
	    if (isset($posted['woocih_language'])) {
	        $woocihlanguage = sanitize_text_field( $posted['woocih_language'] );
	        update_user_meta( $customer_id, 'woocih_language', $woocihlanguage);
	    }
	}
	
	
	/**
	 * Display custom fields in User's profile
	 */
	add_action( 'show_user_profile', 'woocih_user_profile_fields' );
	add_action( 'edit_user_profile', 'woocih_user_profile_fields' );
	function woocih_user_profile_fields( $user ) { ?>
		<h3><?php _e('Email Preferences', 'woocih'); ?></h3>
		<table class="form-table">
			<tr>
		        	<th>
					<label for="woocih_newsletter"><?php _e('Newsletter Subscription', 'woocih'); ?></label>
				</th>
		        	<td>
			        	<?php $news1 = esc_attr( get_the_author_meta( 'woocih_newsletter', $user->ID ) ); ?>
		        		<input type="checkbox" name="woocih_newsletter" id="woocih_newsletter" value="<?php echo $news1 ?>" <?php if( $news1 == 1) { echo 'checked'; } ?> /><br />
		    		</td>
		    	</tr>
		    	<tr>
		        	<th>
			        	<label for="woocih_language"><?php _e('Language Preference', 'woocih'); ?></label>
			    	</th>
		        	<td>
		        		<input type="text" name="woocih_language" id="woocih_language" value="<?php echo esc_attr( get_the_author_meta( 'woocih_language', $user->ID ) ); ?>" /><br />
		        	</td>
		    	</tr>
		</table>
	<?php }
		
		
	/**
	 * Manually Save Custom Fields to User Meta in WP Admin
	 */
	add_action( 'personal_options_update', 'woocih_save_user_profile_fields' );
	add_action( 'edit_user_profile_update', 'woocih_save_user_profile_fields' );
	function woocih_save_user_profile_fields( $user_id ) {
	    if ( !current_user_can( 'edit_user', $user_id ) ) { 
	        return false; 
	    }
	    update_user_meta( $user_id, 'woocih_newsletter', $_POST['woocih_newsletter'] );
	    update_user_meta( $user_id, 'woocih_language', $_POST['woocih_language'] );
	}

	
	/**
	 * Display Newsletter and woocih_language Columns in user listing
	 */
	add_filter( 'manage_users_columns', 'woocih_add_user_columns' );
	function woocih_add_user_columns($column) {
	    $column['woocih_newsletter'] = __('Newsletter Sub.', 'woocih');
	    $column['woocih_language'] = __('Lang.', 'woocih');

	    return $column;
	}
	
	
	/**
	 * Feed Newsletter and woocih_language data to Columns
	 */
	add_filter( 'manage_users_custom_column', 'woocih_add_user_column_data', 10, 3 );
	function woocih_add_user_column_data( $val, $column_name, $user_id ) {
	    $user = get_userdata($user_id);

	    switch ($column_name) {
	        case 'woocih_newsletter' :
	        	if ($user->woocih_newsletter == 1){
				return "✓";
			}
	        break;
	        case 'woocih_language' :
	        	if ($user->woocih_language == "fr_ca"){
				return "FR";
			} else if ($user->woocih_language == "en_ca"){
				return "EN";
			}
	        break;
	        default:
	    }
	    return;
	}
?>
