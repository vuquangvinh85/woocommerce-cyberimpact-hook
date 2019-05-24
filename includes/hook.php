<?php
	
	/**
	 * WooCommerce CyberImpact Hook
	 *
	 * @package woocih
	 * @version 1.0
	 */
	 
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}
	
	add_action( 'woocommerce_checkout_order_processed', 'CyberImpactSync',  10, 1  );
	function CyberImpactSync() {
		
		// Setting informations
		$woocihToken = get_option( 'woocih_api_key' );
		$woocihFrID = get_option( 'woocih_french_id' );
		$woocihEnID = get_option( 'woocih_english_id' );

		// New User?
		// We'll submit the form for new users only
	    $customer_orders = get_posts( array(
		    'numberposts' => -1,
		    'meta_key'    => '_customer_user',
		    'meta_value'  => get_current_user_id(),
		    'post_type'   => wc_get_order_types(),
		    'post_status' => array_keys( wc_get_order_statuses() ),
		) );
		
	    // Count number of orders
	    $count = count( $customer_orders );

	    if ( $count > 1 ) {
			// Do nothing
	    } else {
		    // Connect to newsletter
		    $user_info = wp_get_current_user();
			$email = $user_info->user_email;
			$firstname = $user_info->first_name;
			$lastname = $user_info->last_name;
			$language = $user_info->woocih_language;
			$NewsletterSub = $user_info->woocih_newsletter;

			// Lookup the list we shoold had the user
			if( $language == 'fr_ca' && $NewsletterSub != '') { // FR
				$group = $woocihFrID;
			} else if( $language == 'en_ca' && $NewsletterSub != '') { // EN
				$group = $woocihEnID;
			}

			$headers = array();
			$headers[] = 'Authorization: Bearer ' . $woocihToken;

			//API Url
			$url = 'https://apiv4.cyberimpact.com/members/optins';

			//Initiate cURL.
			$ch = curl_init($url);

			$jsonData = array(
			    'email' 	=> $email,
			    'firstname' => $firstname,
			    'lastname' 	=> $lastname,
			    'language' 	=> $language,
			    'groups' 	=> $group,
			);

			//Tell cURL that we want to send a POST request.
			curl_setopt($ch, CURLOPT_POST, 1);

			//Attach our encoded JSON string to the POST fields.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

			//Set the content type to application/json
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

			// Set the Header Auth
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			//Execute the request
			$result = curl_exec($ch);
	    }

	}

?>