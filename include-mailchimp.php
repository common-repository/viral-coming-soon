<?php

global $viral_coming_soon;

/**
 Include Mailchimp API Files
 **/
// API Code must be set & Email Provider has to be Mailchimp
if ( ! empty( $viral_coming_soon['mailchimp-api-key'] ) && $viral_coming_soon['email-marketing-provider'] == 'mailchimp' ) {
  require_once plugin_dir_path( __FILE__ ) . 'admin/api/mailchimp/MailChimp.php';
  $VCS_MailChimp = new VCS_MailChimp($viral_coming_soon['mailchimp-api-key']);
}

/**
 Mailchimp API Ping
 **/
if ( ! function_exists( 'viral_coming_soon_mailchimp_ping' ) ) {
    function viral_coming_soon_mailchimp_ping() {
        
        global $viral_coming_soon;
        
        require_once plugin_dir_path( __FILE__ ) . 'admin/api/mailchimp/MailChimp.php';
        $VCS_MailChimp = new VCS_MailChimp($viral_coming_soon['mailchimp-api-key']);
        
        $result = $VCS_MailChimp->call( 'helper/ping' );
        if ( $result !== false ) {
            if ( isset( $result['msg'] ) && $result['msg'] === "Everything's Chimpy!" ) {
                return true;
            } elseif ( isset( $result['status'] ) && $result['status'] === "error" ) {
                return false;
            }
        } else {
            return false;
        }

    }
}

/**
 Mailchimp API Status Callback Function (Custom Field)
 **/
if ( ! function_exists ( 'viral_coming_soon_mailchimp_api_connected' ) ) {
    function viral_coming_soon_mailchimp_api_connected() {
        
        global $viral_coming_soon;
        
        if ( empty( $viral_coming_soon['mailchimp-api-key'] ) ) {
            echo "<p style='color:red'>Please enter your Mailchimp API Key first</p>";
        } elseif ( ! empty( $viral_coming_soon['mailchimp-api-key'] ) && $viral_coming_soon['email-marketing-provider'] != 'mailchimp' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'mailchimp_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'mailchimp' || $viral_coming_soon['email-marketing-provider'] == 'mailchimp' ) {
            $ping = viral_coming_soon_mailchimp_ping();
            if ( $ping ) {
                echo "<p style='color:green'>You are successfully connected.</p>";
                update_option( 'mailchimp_api_status',true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please re-enter your Mailchimp API Key.</p>";
                update_option( 'mailchimp_api_status',false );
            }
        }

    }
}

/**
 Mailchimp API Lists Callback Function (Custom Field)
 **/
if ( ! function_exists( 'viral_coming_soon_mailchimp_lists' ) ) {
    function viral_coming_soon_mailchimp_lists() {

        global $viral_coming_soon;
        
        function viral_coming_soon_mailchimp_get_lists() {

            global $viral_coming_soon;
            global $VCS_MailChimp;

            $lists = $VCS_MailChimp->call( 'lists/list' );
            
            if ( isset( $lists['total'] ) == 0) {
                echo "You currently have no lists in your account.<br />Please <a href='https://admin.mailchimp.com/lists/new-list/' title='Create a new list' target='_blank'>go to Mailchimp and create a new list</a>.";
            } else {
                echo "<select name='viral_coming_soon[mailchimp-lists]'>";
                foreach ( $lists['data'] as $list ) {
                ?>
                <option value="<?php echo $list['id']; ?>" <?php if( ! empty( $viral_coming_soon['mailchimp-lists'] ) && $viral_coming_soon['mailchimp-lists'] == $list['id']) { echo "selected='selected'"; } ?>><?php echo $list['name']; ?></option>
                <?php
                }
                echo '</select>';            
            }

        }
        
        if ( empty( $viral_coming_soon['mailchimp-api-key'] ) ) {
            echo "<p style='color:red'>Please enter your Mailchimp API Key first.</p>";
        } elseif ( ! empty( $viral_coming_soon['mailchimp-api-key'] ) && $viral_coming_soon['email-marketing-provider'] != 'mailchimp' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'mailchimp_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'mailchimp' || $viral_coming_soon['email-marketing-provider'] == 'mailchimp' ) {
            $ping = viral_coming_soon_mailchimp_ping();
            if ( $ping ) {
                viral_coming_soon_mailchimp_get_lists();
                update_option( 'mailchimp_api_status',true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please re-enter your Mailchimp API Key.</p>";
                update_option( 'mailchimp_api_status',false );
            }
        }

    }
}

/**
 Check Mailchimp Merge Tags when saving Growbox Options and change Mailchimp Settings if needed
 **/
if ( ! function_exists( 'viral_coming_soon_mailchimp_first_name' ) ) {
    function viral_coming_soon_mailchimp_first_name ( $options, $changed_values ) {

        global $viral_coming_soon;
        global $VCS_MailChimp;

        // Just do this if First Name Option changed upon save
        if ( array_key_exists( 'fname', $changed_values ) || array_key_exists( 'fname-required', $changed_values ) ) {
        
            if ( isset( $viral_coming_soon['mailchimp-lists'] ) ) {
                
                $list_id = $viral_coming_soon['mailchimp-lists'];
                $fields = $VCS_MailChimp->call( 'lists/merge-vars', array( 'id' => array( $list_id ) ) );

                // Check for errors
                if ( $fields['error_count'] != 1 ) {
                    // Check if the First Name Field exists and if it exists if it is required
                    foreach( $fields['data']['0']['merge_vars'] as $field ) {
                        if ( $field['tag'] == 'FNAME' ) {
                            if ( $field['req'] ) {
                                $mc_fname_exists = true;
                                $mc_fname_required = true;
                                break;
                            } else {
                                $mc_fname_exists = true;
                                $mc_fname_required = false;
                                break;
                            }
                        } else {
                            $mc_fname_exists = false;
                            $mc_fname_required = false;
                        }
                    }

                    // Set Mailchimp Required to false
                    if ( $mc_fname_exists && $mc_fname_required && !$viral_coming_soon['fname'] ) {
                        $VCS_MailChimp->call( 'lists/merge-var-update', array(
                            'id'        => $list_id,
                            'tag'       => 'FNAME',
                            'options'   => array(
                                'req'   => 0,
                            )
                        ) );
                    }
                    // Create Mailchimp FNAME Field and set as Required
                    elseif ( ! $mc_fname_exists && $viral_coming_soon['fname-required'] && $viral_coming_soon['fname'] ) {
                        $VCS_MailChimp->call( 'lists/merge-var-add', array(
                            'id'        => $list_id,
                            'tag'       => 'FNAME',
                            'name'          => $viral_coming_soon['fname-placeholder'],
                            'options'   => array(
                                'field_type'    => 'text',
                                'req'                   => 1,
                                'order'             => 5,
                            )
                        ) );
                    }
                    // Create Mailchimp FNAME Field
                    elseif ( ! $mc_fname_exists && ! $viral_coming_soon['fname-required'] && $viral_coming_soon['fname'] ) {
                        $VCS_MailChimp->call( 'lists/merge-var-add', array(
                            'id'        => $list_id,
                            'tag'       => 'FNAME',
                            'name'          => $viral_coming_soon['fname-placeholder'],
                            'options'   => array(
                                'field_type'    => 'text',
                                'req'                   => 0,
                                'order'             => 5,
                            )
                        ) );
                    }
                    // Set Mailchimp Required to false
                    elseif ( $mc_fname_required && ! $viral_coming_soon['fname-required'] ) {
                        $VCS_MailChimp->call( 'lists/merge-var-update', array(
                            'id'        => $list_id,
                            'tag'       => 'FNAME',
                            'options'   => array(
                                'req'   => 0,
                            )
                        ) );
                    }
                    // Set Mailchimp Required to true
                    elseif ( ! $mc_fname_required && $viral_coming_soon['fname-required'] ) {
                        $VCS_MailChimp->call( 'lists/merge-var-update', array(
                            'id'        => $list_id,
                            'tag'       => 'FNAME',
                            'options'   => array(
                                'req'   => 1,
                            )
                        ) );
                    }
                } 
            }
        }
    }
    // Just do this if Mailchimp is connected && Email Marketing Provider set to Mailchimp
    if ( get_option( 'mailchimp_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'mailchimp' ) {
        add_action( "redux/options/viral_coming_soon/saved", "viral_coming_soon_mailchimp_first_name", 10, 2 );
    }
}

/**
 Send Optin Form Values to Mailchimp
 **/
if ( ! function_exists( 'viral_coming_soon_mailchimp_signup' ) ) {
    function viral_coming_soon_mailchimp_signup() {
        global $VCS_MailChimp;
        global $viral_coming_soon;

        if ( isset( $viral_coming_soon['mailchimp-lists'] ) ) {
            
            $list_id = $viral_coming_soon['mailchimp-lists'];

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

                if ( isset( $_POST['FIRSTNAME']) ) {
                    $FNAME   = sanitize_text_field( $_POST["FIRSTNAME"] );
                }
                if ( isset( $_POST['EMAIL']) ) {
                    $EMAIL   = sanitize_email( $_POST["EMAIL"] );
                }

                // Set Array with Subscriber Info for Mailchimp
                $subscriber = array(
                    'id'                =>  $list_id,
                    'email'             =>  array( 'email'=>$EMAIL ),
                    'optin_ip'          =>  $_SERVER['REMOTE_ADDR'],
                    'optin_time'        =>  date( 'Y-m-d H:i:s' ),
                    'double_optin'      =>  $viral_coming_soon['mailchimp-double-optin'],
                    'update_existing'   =>  true,
                    'replace_interests' =>  false,
                );

                if ( isset ( $_POST['FIRSTNAME'] ) ) {
                    $subscriber['merge_vars'] = array( 'FNAME'=>$FNAME );
                }

                // Check if Email already exists inside Mailchimp
                $memberinfo = $VCS_MailChimp->call( 'lists/member-info', array(
                    'id'        => $list_id,
                    'emails'    => array(
                        array ( 'email' => $EMAIL ),
                    ),
                ) );

                // Email already exists inside Mailchimp
                if ( $memberinfo['success_count'] ) {
                    // Check if Double Optin is enabled and Email Adress is not yet confirmed
                    if ( $memberinfo['data']['0']['status'] == 'pending' && $viral_coming_soon['mailchimp-double-optin'] ) {
                        // -- Info: You still need to confirm your email address
                        // Resend Confirmation Email
                        $subscribe = $VCS_MailChimp->call( 'lists/subscribe', $subscriber );
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_confirmation );
                        exit;
                    } 
                    // Check if Double Optin is disabled and Email Adress is not yet confirmed
                    elseif ( $memberinfo['data']['0']['status'] == 'pending' && !$viral_coming_soon['mailchimp-double-optin'] ) {
                        // Show Thank you Page
                        // -- Info: Thank you! You have been subscribed.
                        // Subscribe Email to list
                        $subscribe = $VCS_MailChimp->call( 'lists/subscribe', $subscriber );
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    }
                    // Check if is already subscribed
                    elseif ( $memberinfo['data']['0']['status'] == 'subscribed' ) {
                        // -- Info: Yay, you are already subscribed!
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    }
                    // Check if has been unsubscribed before
                    elseif ( $memberinfo['data']['0']['status'] == 'unsubscribed' ) {
                        $subscribe = $VCS_MailChimp->call( 'lists/subscribe', $subscriber );
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    }
                } else {
                    // If the Email doesn't exist subscribe Email to list
                    $subscribe = $VCS_MailChimp->call( 'lists/subscribe', $subscriber );
                    // If something is wrong, show the Error
                    if ( @$subscribe['status'] == 'error' ) {
                        echo $subscribe['error'];
                    }
                    // If Double Optin is Enabled show Confirmation Page
                    elseif ( $viral_coming_soon['mailchimp-double-optin'] ) {
                        // -- Info: Please confirm your Email Address.
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_confirmation );
                        exit;
                    } else {
                    // If Double Optin is disabled, show Thank you Page
                        // -- Info: Thank you! You have been subscribed.
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    }
                }
            }
        }
    }
    // Just do this if Mailchimp is connected && Email Marketing Provider set to Mailchimp
    if ( get_option( 'mailchimp_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'mailchimp' ) {
        add_action( 'wp_loaded', 'viral_coming_soon_mailchimp_signup' );
    }
}