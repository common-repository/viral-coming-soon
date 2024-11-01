<?php

global $viral_coming_soon;

/**
 Include GetResponse API Files
 **/
if ( ! empty( $viral_coming_soon['getresponse-api-code'] ) && $viral_coming_soon['email-marketing-provider'] == 'getresponse' ) {
    require_once plugin_dir_path( __FILE__ ) . 'admin/api/getresponse/GetResponseAPI.class.php';
    $VCS_GetResponse = new VCS_GetResponse($viral_coming_soon['getresponse-api-code']);
}

/**
 GetResponse API Ping
 **/
if ( ! function_exists( 'viral_coming_soon_getresponse_ping' ) ) {
    function viral_coming_soon_getresponse_ping() {

        global $viral_coming_soon;

        require_once plugin_dir_path( __FILE__ ) . 'admin/api/getresponse/GetResponseAPI.class.php';
        $VCS_GetResponse = new VCS_GetResponse($viral_coming_soon['getresponse-api-code']);

        if ( $VCS_GetResponse->ping() == 'pong' ) {
            return true;
        } else {
            return false;
        }

    }
}

/**
 GetResponse API Status Callback Function
 **/
if ( ! function_exists( 'viral_coming_soon_getresponse_api_connected' ) ) {
    function viral_coming_soon_getresponse_api_connected() {
      
        global $viral_coming_soon;

        if ( empty($viral_coming_soon['getresponse-api-code']) ) {
            echo "<p style='color:red'>Please enter your GetResponse API Key first.</p>";
        } elseif ( ! empty( $viral_coming_soon['getresponse-api-code'] ) && $viral_coming_soon['email-marketing-provider'] != 'getresponse' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'getresponse_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'getresponse' || $viral_coming_soon['email-marketing-provider'] == 'getresponse' ) {
            $ping = viral_coming_soon_getresponse_ping();
            if ($ping) {
                echo "<p style='color:green'>You are successfully connected.</p>";
                update_option( 'getresponse_api_status', true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please re-enter your GetResponse API Key.</p>";
                update_option( 'getresponse_api_status', false );
            }
        }

    }
}
/**
 GetResponse Campaigns Callback Function
 **/
if ( !function_exists('viral_coming_soon_getresponse_campaigns') ) {
    function viral_coming_soon_getresponse_campaigns() {
        
        global $viral_coming_soon;
        
        function getresponse_get_lists() {

            global $viral_coming_soon;
            global $VCS_GetResponse;

            $campaigns = $VCS_GetResponse->getCampaigns();

            if ( ! empty($campaigns) ) {
              echo '<select name="viral_coming_soon[getresponse-campaigns]">';
              foreach ( $campaigns as $key => $campaign) {
                ?>
                <option value="<?php echo $key; ?>" <?php if( !empty($viral_coming_soon['getresponse-campaigns']) && $viral_coming_soon['getresponse-campaigns'] == $key) { echo 'selected="selected"'; } ?>><?php echo $campaign->name; ?></option>
                <?php
              }
              echo "</select>";
            } else {
              echo "<p style='color:red'>Something is wrong. Please re-enter your GetResponse API Key.</p>";
            }

        }

        if ( empty( $viral_coming_soon['getresponse-api-code'] ) ) {
            echo "<p style='color:red'>Please enter your GetResponse API Key first</p>";
        } elseif ( ! empty( $viral_coming_soon['getresponse-api-code'] ) && $viral_coming_soon['email-marketing-provider'] != 'getresponse' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'getresponse_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'getresponse' || $viral_coming_soon['email-marketing-provider'] == 'getresponse' ) {
            $ping = viral_coming_soon_getresponse_ping();
            if ($ping) {
                getresponse_get_lists();
                update_option('getresponse_api_status', true);
            } else {
                echo "<p style='color:red'>Something is wrong. Please re-enter your GetResponse API Key.</p>";
                update_option('getresponse_api_status', false);
            }
        }

    }
}

/**
 Send Optin Form Values to GetResponse
 **/
if ( ! function_exists( 'viral_coming_soon_getresponse_signup' ) ) {
    function viral_coming_soon_getresponse_signup() {
        
        global $viral_coming_soon;
        global $VCS_GetResponse;

        if ( isset( $viral_coming_soon['getresponse-campaigns'] ) ) {

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
                
            if ( isset( $_POST['FIRSTNAME'] ) ) {
                $FNAME   = sanitize_text_field( $_POST["FIRSTNAME"] );
            }
            if ( isset( $_POST['EMAIL'] ) ) {
                $EMAIL   = sanitize_email( $_POST["EMAIL"] );
            }
            $campaign_id  = $viral_coming_soon['getresponse-campaigns'];
            $email        = $EMAIL;

            if ( isset( $_POST['FIRSTNAME'] ) && ! empty( $_POST['FIRSTNAME'] ) ) {
                $name = $_POST['FIRSTNAME'];
            } else {
                $name = NULL;
            }

            // Check if Double Optin is enabled or disabled (Setting not changeable via the API)
            $campaign = $VCS_GetResponse->getCampaignByID( $campaign_id );

            if ( $campaign->$campaign_id->optin == 'single') {
                $double_optin = false;
            } else {
                $double_optin = true;
            }

            // Add Subscriber to GetResponse
            $subscribe = $VCS_GetResponse->addContact( $campaign_id, $name, $email );

            if ( @$subscribe->queued != 1 ) {
                // Email already exists
                if ( $double_optin ) {
                    if ( $subscribe->message == "Contact already queued for target campaign" ) {
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_confirmation );
                        exit;
                    } elseif( $subscribe->message == "Contact already added to target campaign" ) {
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    }
                } else {
                    if ( $subscribe->message == "Contact already queued for target campaign" ) {
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_confirmation );
                        exit;
                    } elseif( $subscribe->message == "Contact already added to target campaign" ) {
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    }
                }
            } elseif ( $subscribe->queued == 1 ) {
                // Email is new
                if ( $double_optin ) {
                    // If Double Optin is Enabled show Confirmation Page
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
                echo "Something went wrong.";
            }
          }
        }
    }
    if ( get_option( 'getresponse_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'getresponse' ) {
        add_action( 'wp_loaded', 'viral_coming_soon_getresponse_signup' );
    }
}