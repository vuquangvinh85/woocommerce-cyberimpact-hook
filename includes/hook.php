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
			
			//Added to transfer postal code, address, type of membership. Use var_export(get_user_meta($user_info->id),true) to get the variable names
			//Address related information is obtained when payment is made => they are billing address information.
            $postalCode = $user_info->billing_postcode;
            $address = $user_info->billing_address_1 ." " .$user_info->billing_address_2;
            $city = $user_info->billing_city;
            $province = $user_info->billing_state;
            
            //Type of membership is not tracked in WordPress. It is currently sought based on payment amount (35 -> Individual, 600 -> Organization, 15 -> Student/Senior). This payment amount is currently the only usable info in $customer_order to identify type of membership. It is noted that if a customer add more than 1 item to their order, the Type of membership will default to "Unknown".
            $typeOfMembership = "Unknown";
            if ($customer_orders[0]->_order_total == '35.00') {$typeOfMembership = "Individual";}
            else if ($customer_orders[0]->_order_total == '600.00') {$typeOfMembership = "Organization";}
            else if ($customer_orders[0]->_order_total == '15.00') {$typeOfMembership = "Student/Senior";}
            
            //address (including $address, $city, $province) and type of membership are declared as custom fields in Cyber Impact. Their corresponding field index (used as keys here) can be seen in Cyber Impact => settings => custom field tab => Get placeholder => Custom field tab. The number in [] is their field index.
            $customFields = array(
                '6'     => $address,
                '7'     => $city,
                '8'     => $province,
                '11'    => $typeOfMembership
            );
			
			// Lookup the list we shoold had the user
			if( $language == 'fr_ca' && $NewsletterSub != '') { // FR
				$group = $woocihFrID;
			} else if( $language == 'en_ca' && $NewsletterSub != '') { // EN
				$group = $woocihEnID;
			}

            
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
			    //Added to transfer postal code, address, type of membership
			    'postalCode'=> $postalCode,
			    'customFields' => $customFields,
			    
			    //For experiments: print meta fields of user and post to "Memo" Field in CyberImpact
			    //'note'      => var_export(get_user_meta($user_info->id),true),
			    //'note'      => var_export(get_post_meta($customer_orders[0]->ID),true),
			    //'note'      => var_export($customer_orders[0]->_order_total,true),
			);
            
            //Encode $jsonData
            $encodedjsonData = json_encode($jsonData);
            
			//Tell cURL that we want to send a POST request.
			curl_setopt($ch, CURLOPT_POST, 1);

			//Attach our encoded JSON string to the POST fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedjsonData);

            //Set the content type to application/json and API token authorization
			$headers = array(
			    'Content-Type: application/json',
			    'Authorization: Bearer ' . $woocihToken,
			);
			
			// Set the Header
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			//Execute the request
			$result = curl_exec($ch);
	    }

	}

?>