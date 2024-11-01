<?php

global $viral_coming_soon;

/**
 Include Campaign Monitor API Files
 **/
if ( ! empty( $viral_coming_soon['campaignmonitor-api-code'] ) && $viral_coming_soon['email-marketing-provider'] == 'campaignmonitor' ) {  
    require_once plugin_dir_path( __FILE__ ) . 'admin/api/campaignmonitor/csrest_general.php';
    $VCS_CampaignMonitor = new VCS_CS_REST_General( $viral_coming_soon['campaignmonitor-api-code'] );
}

/**
 Campaign Monitor API Ping
 **/
if ( ! function_exists( 'viral_coming_soon_campaignmonitor_ping' ) ) {
    function viral_coming_soon_campaignmonitor_ping() {

        global $viral_coming_soon;

        require_once plugin_dir_path( __FILE__ ) . 'admin/api/campaignmonitor/csrest_general.php';
        $wrap = new VCS_CS_REST_General($viral_coming_soon['campaignmonitor-api-code']);

        $result = $wrap->get_clients();

        if ( $result->was_successful() ) {
            return true;
        } else {
            return false;
        }

    }
}
/**
Campaign Monitor API Status Callback Function (Custom Field)
**/
if ( ! function_exists( 'viral_coming_soon_campaignmonitor_api_connected' ) ) {
    function viral_coming_soon_campaignmonitor_api_connected() {
        
        global $viral_coming_soon;

        if ( empty( $viral_coming_soon['campaignmonitor-api-code'] ) ) {
            echo "<p style='color:red'>Please enter your Campaign Monitor API Key first.</p>";
        } elseif ( ! empty( $viral_coming_soon['campaignmonitor-api-code'] ) && $viral_coming_soon['email-marketing-provider'] != 'campaignmonitor' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'campaignmonitor_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'campaignmonitor' || $viral_coming_soon['email-marketing-provider'] == 'campaignmonitor' ) {
            $ping = viral_coming_soon_campaignmonitor_ping();
            if ( $ping ) {
                echo "<p style='color:green'>You are successfully connected.</p>";
                update_option( 'campaignmonitor_api_status', true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please check your Campaign Monitor API Key.'";
                update_option( 'campaignmonitor_api_status', false );
            }
        }

    }
}
/**
Campaign Monitor Lists Callback Function (Custom Field)
**/
if ( ! function_exists( 'viral_coming_soon_campaignmonitor_lists' ) ) {
    function viral_coming_soon_campaignmonitor_lists() {

        global $viral_coming_soon;
        
        function campaignmonitor_get_lists() {

            global $viral_coming_soon;
            global $VCS_CampaignMonitor;

            $result = $VCS_CampaignMonitor->get_clients();

            if ( $result->was_successful() ) {
                if ( empty( $result->response ) ) {
                    echo "You have no clients and no lists inside Campaign Monitor. Please create some first.<br /><a href='https://login.createsend.com/l#' title='Campaign Monitor' target='_blank'>Click here to go to Campaign Monitor</a>";
                } else {
                    $i = 0;
                    $client_count = count($result->response);
                    
                    foreach ( $result->response as $client ) {
                        // Do this for each Client inside Campaign Monitor
                        require_once plugin_dir_path( __FILE__ ) . 'admin/api/campaignmonitor/csrest_clients.php';
                        $VCS_CampaignMonitor_Clients = new VCS_CS_REST_Clients( $client->ClientID, $viral_coming_soon['campaignmonitor-api-code'] );
                        $lists = $VCS_CampaignMonitor_Clients->get_lists();
                        if ( $lists->was_successful() ) {
                            // Does the client have a list?
                            if ( empty( $lists->response ) ) {
                                // Is this the only client?
                                if ( $client_count < 1 ) {
                                    echo "You have no list inside Campaign Monitor. Please create some first.";
                                } else {
                                    // This Client has no list but maybe the other one or are we done?
                                    if ( $i == $client_count - 1 ) {
                                        echo "You have no list inside Campaign Monitor. Please create some first.";
                                    }
                                }
                            }
                            // Client has a list
                            else {
                                foreach ( $lists->response as $list ) {
                                    
                                    // Save List in an array
                                    $list_options[] = array( $list->ListID, $list->Name, $client->Name );
                                }
                            }
                        } else {
                            if ( $lists->response->Code == 102 ) {
                                echo "Please create first a Client inside Campaign Monitor.";
                            } else {
                                echo "Failed with code $lists->http_status_code";
                            }
                        }
                        $i++;
                    }
                    if ( ! empty( $list_options ) ) {
                        echo "<select name='viral_coming_soon[campaignmonitor-lists]'>";
                        foreach ($list_options as $list_option) {
                            ?>
                            
                            <option value="<?php echo $list_option[0]; ?>" <?php if( !empty( $viral_coming_soon['campaignmonitor-lists'] ) && $viral_coming_soon['campaignmonitor-lists'] == $list_option[0]) { echo "selected='selected'"; } ?>><?php echo $list_option[1]; echo " ($list_option[2])"; ?></option>
                            
                            <?php
                        }
                        echo "</select>";
                    }
                }
            }
        }
        if ( empty( $viral_coming_soon['campaignmonitor-api-code'] ) ) {
            echo "<p style='color:red'>Please enter your Campaign Monitor API Key first</p>";
        } elseif ( ! empty( $viral_coming_soon['campaignmonitor-api-code'] ) && $viral_coming_soon['email-marketing-provider'] != 'campaignmonitor' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'campaignmonitor_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'campaignmonitor' || $viral_coming_soon['email-marketing-provider'] == 'campaignmonitor' ) {
            $ping = viral_coming_soon_campaignmonitor_ping();
            if ( $ping ) {
                campaignmonitor_get_lists();
                update_option( 'campaignmonitor_api_status', true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please check your Campaign Monitor API Key</p>";
                update_option( 'campaignmonitor_api_status', false );
            }
        }
    }
}

/**
 Updates List to Single or Confirmed Optin when saved
 **/
if ( ! function_exists( 'viral_coming_soon_campaignmonitor_double_optin' ) ) {
    function viral_coming_soon_campaignmonitor_double_optin ( $options, $changed_values ) {

        global $viral_coming_soon;

        // If Double Optin Settings have changed and is connected to Campaign Monitor
        if ( array_key_exists('campaignmonitor-double-optin', $changed_values) && isset( $viral_coming_soon['campaignmonitor-api-status'] ) && $viral_coming_soon['campaignmonitor-api-status'] ) {

            require_once plugin_dir_path( __FILE__ ) . 'admin/api/campaignmonitor/csrest_lists.php';
            $viral_coming_soon_campaignmonitor_lists = new VCS_CS_REST_Lists($viral_coming_soon['campaignmonitor-lists'], $viral_coming_soon['campaignmonitor-api-code']);
            $result = $viral_coming_soon_campaignmonitor_lists->get();

            if ( $result->was_successful() ) {
                // Check Campaign Monitor Settings 
                // Save List Title in variable
                $list_title = $result->response->Title;
                
                if ( $result->response->ConfirmedOptIn) {
                    // Confirmed Optin is enabled in Campaign Monitor
                    if ( !$viral_coming_soon['campaignmonitor-double-optin'] ) {
                        // Update Campaign Monitor Settings if Confirmed Optin is disabled in Growbox Options
                        $result = $viral_coming_soon_campaignmonitor_lists->update(array(
                            'Title'             => $list_title,
                            'ConfirmedOptIn'    => false,
                        ));
                    }
                } else {
                    // Single Optin is enabled in Campaign Monitor
                    if ( $viral_coming_soon['campaignmonitor-double-optin']) {
                        // Update Campaign Monitor Settings if Confirmed Optin is enabled in Growbox Options
                        $result = $viral_coming_soon_campaignmonitor_lists->update(array(
                            'Title'             => $list_title,
                            'ConfirmedOptIn'    => true,
                        ));
                    }
                }
            }
        }
    }
    if ( get_option( 'campaignmonitor_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'campaignmonitor' ) {
        add_action( "redux/options/viral_coming_soon/saved", "viral_coming_soon_campaignmonitor_double_optin", 10, 2 );
    }
}

/**
 Send Optin Form Values to Campaign Monitor
 **/
if ( ! function_exists( 'viral_coming_soon_campaignmonitor_signup' ) ) {
    function viral_coming_soon_campaignmonitor_signup() {

        global $VCS_CampaignMonitor;
        global $viral_coming_soon;

        if ( isset( $viral_coming_soon['campaignmonitor-lists'] ) ) {

            $redirect_confirmation = '?confirm=1';
            $redirect_thankyou = '?thankyou=1';

            $redirect = esc_url( home_url( '/' ) );
            
            // Check if the Form is submitted
            if ( isset( $_POST['subscribe'] ) ) {

                // Honeypot
                if ( isset( $_POST['name'] ) && ! empty( $_POST['name'] ) )
                    die();

                // Verify WP Nonce
                if ( ! isset( $_POST['vcs_nonce'] ) || ! wp_verify_nonce( $_POST['vcs_nonce'], 'viral_coming_soon_form_submit' ) )
                    die();
                
                require_once plugin_dir_path( __FILE__ ) . 'admin/api/campaignmonitor/csrest_subscribers.php';

                if ( isset( $_POST['FIRSTNAME'] ) ) {
                    $FNAME   = sanitize_text_field( $_POST["FIRSTNAME"] );
                }
                if ( isset( $_POST['EMAIL'] ) ) {
                    $EMAIL   = sanitize_email( $_POST["EMAIL"] );
                }

                $subscriber = array (
                    'EmailAddress'  => $EMAIL,
                    'Resubscribe'   => true,
                    'Date'          => date('Y-m-d H:i:s'),
                );

                if ( isset( $_POST['FIRSTNAME'] ) ) {
                    $subscriber['Name'] = $FNAME;
                }

                $VCS_CampaignMonitor_Subscribers = new VCS_CS_REST_Subscribers( $viral_coming_soon['campaignmonitor-lists'], $viral_coming_soon['campaignmonitor-api-code'] );

                // Check if Subscriber already exists first
                $get = $VCS_CampaignMonitor_Subscribers->get( $EMAIL, $subscriber );

                if ( $get->was_successful() ) {
                    // Check if Double Optin is enabled and Email Adress is not yet confirmed
                    if ( $get->response->State == 'Unconfirmed' && $viral_coming_soon['campaignmonitor-double-optin'] ) {
                        // -- Info: You still need to confirm your email address
                        // Resend Confirmation Email
                        $subscribe = $VCS_CampaignMonitor_Subscribers->update($EMAIL, $subscriber);
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_confirmation );
                        exit;
                    } 
                    // Check if Double Optin is disabled and Email Adress is not yet confirmed
                    elseif ( $get->response->State == 'Unconfirmed' && !$viral_coming_soon['campaignmonitor-double-optin'] ) {
                        // Show Thank you Page
                        // -- Info: Thank you! You have been subscribed.
                        // Subscribe Email to list
                        $subscribe = $VCS_CampaignMonitor_Subscribers->add($subscriber);
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    }
                    // Check if is already subscribed
                    elseif ( $get->response->State == 'Active' ) {
                        // -- Info: Yay, you are already subscribed!
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    }
                } else {
                    // If the Email doesn't exist subscribe Email to list
                    $result = $VCS_CampaignMonitor_Subscribers->add( $subscriber );

                    if ( $result->was_successful() ) {
                        // If Double Optin is Enabled show Confirmation Page
                        if ( $viral_coming_soon['campaignmonitor-double-optin'] ) {
                            // -- Info: Please confirm your Email Address.
                            if ( viral_coming_soon_is_gmail($EMAIL) ) {
                                $redirect_confirmation .= '&gmail=1';
                                $redirect_thankyou     .= '&gmail=1';
                            }
                            wp_redirect( $redirect . $redirect_confirmation );
                            exit;
                        } else {
                        // If Double Optin is disabled, show Thank you Page
                            // -- Info: Thank you! You have been subscribed.
                            if ( viral_coming_soon_is_gmail($EMAIL) ) {
                                $redirect_confirmation .= '&gmail=1';
                                $redirect_thankyou     .= '&gmail=1';
                            }
                            wp_redirect( $redirect . $redirect_thankyou );
                            exit;
                        }
                    } else {
                        echo "Failed with code $result->http_status_code.<br /><pre>";
                        var_dump( $result->response );
                        echo "</pre>";
                    }

                }

            }
        }
    }
    if ( get_option( 'campaignmonitor_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'campaignmonitor' ) {
        add_action( 'wp_loaded', 'viral_coming_soon_campaignmonitor_signup' );
    }
}

/**
 Check Campaign Monitor Merge Tags when saving Growbox Options and change Campaign Monitor Settings if needed
 **/
/*
if (!function_exists('campaignmonitor_first_name')) :
function campaignmonitor_first_name ( $options, $changed_values ) {

    global $viral_coming_soon;

    // If First Name Settings have changed
    if ( array_key_exists('campaignmonitor-fname', $changed_values) || array_key_exists('campaignmonitor-fname-required', $changed_values) ) {

        // If is connected to Campaign Monitor
        if ( isset( $viral_coming_soon['campaignmonitor-api-status'] ) && $viral_coming_soon['campaignmonitor-api-status'] ) {

            require_once plugin_dir_path( __FILE__ ) . 'admin/api-campaignmonitor/csrest_lists.php';
            $viral_coming_soon_campaignmonitor_lists = new VCS_CS_REST_Lists($viral_coming_soon['campaignmonitor-lists'], $viral_coming_soon['campaignmonitor-api-code']);
            $result = $viral_coming_soon_campaignmonitor_lists->get_custom_fields();

            if ( $result->was_successful() ) {
                // Check if First Name is required or not required inside Campaign Monitor
                var_dump($result->response);
            }

        }

    }
}
if ( isset($viral_coming_soon['campaignmonitor-api-code']) && !empty($viral_coming_soon['campaignmonitor-api-code']) ) {
    add_action ("redux/options/viral_coming_soon/saved", "campaignmonitor_first_name", 10, 2);
}
endif;
*/