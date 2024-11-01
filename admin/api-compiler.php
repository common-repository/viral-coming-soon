<?php

    global $opt_name;
    $opt_name = "viral_coming_soon";

    if ( ! function_exists( 'reset_connection' ) ) {
        function reset_connection( $options, $changed_values ) {

            global $opt_name;
            $opt_name = "viral_coming_soon";

            // Check if Email Marketing Provider Settings have changed
            if ( array_key_exists( 'email-marketing-provider', $changed_values ) ) {

                if ( $changed_values['email-marketing-provider'] == 'mailchimp' ) {
                    delete_option('mailchimp_api_status');
                } elseif ( $changed_values['email-marketing-provider'] == 'aweber' ) {
                    delete_option('aweber_api_status');
                    delete_option('aweber_consumer_key');
                    delete_option('aweber_consumer_secret');
                    delete_option('aweber_access_token');
                    delete_option('aweber_access_secret');
                } elseif ( $changed_values['email-marketing-provider'] == 'campaignmonitor' ) {
                    delete_option('campaignmonitor_api_status');
                } elseif ( $changed_values['email-marketing-provider'] == 'getresponse' ) {
                    delete_option('getresponse_api_status');
                }
            }
        }
    }

    add_action ("redux/options/viral_coming_soon/saved", "reset_connection", 10, 2);

    add_filter ('redux/options/' . $opt_name . '/compiler', 'api_compiler', 10, 3);

    /**
    Show Success or Error Notices in Admin Menu
    **/
    if ( ! function_exists( 'viral_coming_soon_admin_notice' ) ) {
        function viral_coming_soon_admin_notice( $type, $message ) {
            echo "<div class='$type'><p>$message</p></div>";
        }
    }

    /**
    Connect to Email Service Providers
    **/
    if (!function_exists('api_compiler')) {
        function api_compiler ( $options, $css, $changed_values ) {

            global $viral_coming_soon;

            /**
             * Connect to Mailchimp
             **/

            // Check if API Key has been entered or changed
            if ( array_key_exists('mailchimp-api-key', $changed_values) ) {

                // Try to connect to Mailchimp
                $ping = viral_coming_soon_mailchimp_ping();

                if ($ping) {

                    // If successfull set mailchimp-api-status to true
                    update_option('mailchimp_api_status',true);

                    // Show success message
                    $type = 'updated';
                    $message = __('You are successfully connected to Mailchimp', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                } else {

                    // Else set mailchimp-api-status to false
                    update_option('mailchimp_api_status',false);

                    // Show error message
                    $type = 'error';
                    $message = __('Something is wrong, please check your Mailchimp API Key.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                }
            }

            /**
             * Connect to AWeber
             **/

            // Check if AWeber Auth Code has been entered or changed
            if ( array_key_exists('aweber-auth-code', $changed_values) ) {

                // Try to connect with AWeber
                try {

                    require_once plugin_dir_path( __FILE__ ) . 'api/aweber/aweber_api.php';
                    
                    $auth = AWeberAPI::getDataFromAweberID(trim($viral_coming_soon['aweber-auth-code']));
                    list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = $auth;

                    if ( !empty($auth) ) {

                        // If successfull set mailchimp-api-status to true
                        update_option('aweber_api_status',true);
                        
                        // Save AWeber Credentials to Database
                        update_option('aweber_consumer_key',$auth[0]);
                        update_option('aweber_consumer_secret',$auth[1]);
                        update_option('aweber_access_token',$auth[2]);
                        update_option('aweber_access_secret',$auth[3]);
                        
                        // Show success message
                        $type = 'updated';
                        $message = __('You are successfully connected to Aweber.', 'growbox');
                        $notice = viral_coming_soon_admin_notice($type, $message);
                        add_action ('admin_notices', $notice);
                    
                    } else {
                        
                        // Else set aweber-api-status to false
                        update_option('aweber_api_status',false);
                        
                        // Show error message
                        $type = 'error';
                        $message = __('Please enter a valid AWeber Authorization Code.', 'growbox');
                        $notice = viral_coming_soon_admin_notice($type, $message);
                        add_action ('admin_notices', $notice);
                    
                    }

                } catch  (AWeberAPIException $exc) {

                    // Catch errors and set aweber-api-status to false
                    update_option('aweber_api_status',false);
                    
                    // Show error message
                    $type = 'error';
                    $message = __('Something is wrong, please <a href="https://auth.aweber.com/1.0/oauth/authorize_app/f38e902d" target="_blank">click here</a> to get a new AWeber Authorization Code.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                }
            }

            /**
             * Connect to Campaign Monitor
             **/

            // Check if Campaign Monitor API Key has been entered or changed
            if ( array_key_exists('campaignmonitor-api-code', $changed_values) ) {

                // Try to connect to Campaign Monitor
                $ping = viral_coming_soon_campaignmonitor_ping();

                if ($ping) {

                    // If successfull set campaignmonitor-api-status to true
                    update_option('campaignmonitor_api_status',true);
                    
                    // Show success message
                    $type = 'updated';
                    $message = __('You are successfully connected to Campaign Monitor.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                } else {

                    // Else set campaignmonitor-api-status to false
                    update_option('campaignmonitor_api_status',false); 

                    // Show error message
                    $type = 'error';
                    $message = __('Failed with code ' . $error . ', please re-enter your Campaignmonitor API Key.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                }
            }

            /**
             * Connect to GetResponse
             **/

            // Check if GetResponse API Key has been entered or changed
            if ( array_key_exists('getresponse-api-code', $changed_values) ) {

                // Try to connect to GetResponse
                $ping = viral_coming_soon_getresponse_ping();

                if ($ping) {

                    // If successfull set getresponse-api-status to true
                    update_option('getresponse_api_status',true);
                    
                    // Show success message
                    $type = 'updated';
                    $message = __('You are successfully connected to GetResponse.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                } else {

                    // Else set getresponse-api-status to false
                    update_option('getresponse_api_status',false);     

                    // Show error message
                    $type = 'error';
                    $message = __('Something is wrong. Please re-enter your GetResponse API Key.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                }
            }

            /**
             * Connect to ConvertKit
             **/

            // Check if ConvertKit API Key has been entered or changed
            if ( array_key_exists('convertkit-api-code', $changed_values) ) {

                // Try to connect to GetResponse
                $ping = convertkit_ping();

                if ($ping) {

                    // If successfull set getresponse-api-status to true
                    update_option('convertkit_api_status',true);
                    
                    // Show success message
                    $type = 'updated';
                    $message = __('You are successfully connected to ConvertKit.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                } else {

                    // Else set getresponse-api-status to false
                    update_option('convertkit_api_status',false);     

                    // Show error message
                    $type = 'error';
                    $message = __('Something is wrong. Please re-enter your ConvertKit API Key.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);

                }

            }

            /**
             * Save Custom HTMl Form Values and Fields
             **/

            // Check if Custom HTML Form Code has been entered or changed
            if ( array_key_exists('custom-html-code', $changed_values) ) {

                $response = create_custom_html_form();

                if ( $response ) {
                    $type = 'updated';
                    $message = __('We could connect with your Email Service Provider through the Custom HTML Code. Please test if your forms work right, as this setting is still experimental.', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);
                } else {
                    // Show error message
                    $type = 'error';
                    $message = __('Something is wrong with your Custom HTML Code. If you continue to encounter problems, please write directly to <a href="mailto:support@growtheme.com" target="_blank">support@growtheme.com</a>', 'growbox');
                    $notice = viral_coming_soon_admin_notice($type, $message);
                    add_action ('admin_notices', $notice);
                }

            }
        }
    }