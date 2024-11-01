<?php
global $viral_coming_soon;

/**
 If successfully connected to VCS_AWeber create a new AWeberAPI Object to use everywhere
 **/
if ( ! function_exists( 'viral_coming_soon_aweber_connect' ) ) {
    function viral_coming_soon_aweber_connect() {

        require_once plugin_dir_path( __FILE__ ) . 'admin/api/aweber/aweber_api.php';

        $aweber_consumer_key    = get_option( 'aweber_consumer_key' );
        $aweber_consumer_secret = get_option( 'aweber_consumer_secret' );
        $aweber_access_token    = get_option( 'aweber_access_token' );
        $aweber_access_secret   = get_option( 'aweber_access_secret' );

        global $VCS_AWeber;

        // Connect with the Auth Information
        try {
            $VCS_AWeberAPI = new VCS_AWeberAPI( $aweber_consumer_key, $aweber_consumer_secret );
            $VCS_AWeber = $VCS_AWeberAPI->getAccount( $aweber_access_token , $aweber_access_secret );
            update_option( 'aweber_api_status',true );
        } catch( AWeberAPIException $exc ) {
            update_option( 'aweber_api_status',false );
        }

    }
    // Include this if AWeber is set
    if ( $viral_coming_soon['email-marketing-provider'] == 'aweber' ) {
      add_action( 'wp_loaded', 'viral_coming_soon_aweber_connect' );
    }
}

/**
 AWeber API Ping
 **/
if ( ! function_exists( 'viral_coming_soon_aweber_ping' ) ) {
    function viral_coming_soon_aweber_ping() {

        require_once plugin_dir_path( __FILE__ ) . 'admin/api/aweber/aweber_api.php';

        $aweber_consumer_key    = get_option( 'aweber_consumer_key' );
        $aweber_consumer_secret = get_option( 'aweber_consumer_secret' );
        $aweber_access_token    = get_option( 'aweber_access_token' );
        $aweber_access_secret   = get_option( 'aweber_access_secret' );

        try {
            $VCS_AWeberAPI = new VCS_AWeberAPI($aweber_consumer_key, $aweber_consumer_secret);
            $VCS_AWeber = $VCS_AWeberAPI->getAccount($aweber_access_token, $aweber_access_secret);
            return true;
        } catch ( VCS_AWeberAPIException $exc ) {
            return false;
        }
    
    }
}
        
/**
 AWeber API Status Callback Function (Custom Field)
 **/
if ( ! function_exists( 'viral_coming_soon_aweber_api_connected' ) ) {
    function viral_coming_soon_aweber_api_connected() {
        
        global $viral_coming_soon;

        if ( empty( $viral_coming_soon['aweber-auth-code'] ) ) {
            echo "<p style='color:red'>Please enter your Aweber Authorization Code first.</p>";
        } elseif ( ! empty( $viral_coming_soon['aweber-auth-code'] ) && $viral_coming_soon['email-marketing-provider'] != 'aweber' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'aweber_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'aweber' || $viral_coming_soon['email-marketing-provider'] == 'aweber' ) {
            $ping = viral_coming_soon_aweber_ping();
            if ( $ping ) {
                echo "<p style='color:green'>You are successfully connected.</p>";
                update_option( 'aweber_api_status',true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please get a new AWeber AUthorization Code and enter it above.</p>";
                update_option( 'aweber_api_status',false );
            }
        }

    }
}

/**
 AWeber Lists Callback Function (Custom Field)
 **/
if ( ! function_exists( 'viral_coming_soon_aweber_lists' ) ) {
    function viral_coming_soon_aweber_lists() {

        global $viral_coming_soon;

        function aweber_get_lists() {
            
            global $viral_coming_soon;

            require_once plugin_dir_path( __FILE__ ) . 'admin/api/aweber/aweber_api.php';

            $aweber_consumer_key    = get_option( 'aweber_consumer_key' );
            $aweber_consumer_secret = get_option( 'aweber_consumer_secret' );
            $aweber_access_token    = get_option( 'aweber_access_token' );
            $aweber_access_secret   = get_option( 'aweber_access_secret' );

            try {
                
                $VCS_AWeberAPI = new VCS_AWeberAPI($aweber_consumer_key, $aweber_consumer_secret);
                $VCS_AWeber = $VCS_AWeberAPI->getAccount($aweber_access_token, $aweber_access_secret);

                $lists = $VCS_AWeber->lists;
                
                echo '<select name="viral_coming_soon[aweber-lists]">';
                foreach ( $lists->data['entries'] as $list ) {
                    ?>
                    <option value="<?php echo $list['id']; ?>" <?php if( !empty($viral_coming_soon['aweber-lists']) && $viral_coming_soon['aweber-lists'] == $list['id']) { echo 'selected="selected"'; } ?>><?php echo $list['name']; ?></option>
                    <?php
                }
                echo '</select>';
            
            } catch ( VCS_AWeberAPIException $exc ) {
                echo "<p style='color:red'>$exc->type. Please get a new Authorization Code.</p>";
            }

        }

        if ( empty( $viral_coming_soon['aweber-auth-code'] ) ) {
            echo "<p style='color:red'>Please enter your AWeber Authorization Code first.</p>";
        } elseif ( ! empty( $viral_coming_soon['aweber-auth-code'] ) && $viral_coming_soon['email-marketing-provider'] != 'aweber' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'aweber_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'aweber' || $viral_coming_soon['email-marketing-provider'] == 'aweber' ) {
            $ping = viral_coming_soon_aweber_ping();
            if ( $ping ) {
                aweber_get_lists();
                update_option( 'aweber_api_status',true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please get a new AWeber Authorization Code and enter it above.</p>";
                update_option( 'aweber_api_status',false );
            
            }
        }

    }
}

/**
 Send Optin Form Values to AWeber
 **/
if ( ! function_exists( 'viral_coming_soon_aweber_signup' ) ) {
    function viral_coming_soon_aweber_signup() {

        global $VCS_AWeber;
        global $viral_coming_soon;

        if ( isset( $viral_coming_soon['aweber-lists'] ) ) {

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

                if ( viral_coming_soon_ipv4_check() ) {
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                } else {
                    $ip_address = '';
                }

                try {
                    $account  = $VCS_AWeber->id;
                    $list_id  = $viral_coming_soon['aweber-lists'];
                    $listURL  = "/accounts/{$account}/lists/{$list_id}";

                    $list     = $VCS_AWeber->loadFromURL( $listURL );

                    $params   = array (
                      'email'         => $EMAIL,
                      'ip_address'    => $ip_adress,
                      'subscribed_at' => date('YYYY-MM-DD HH:MM:SS'),
                      'name'          => $FNAME,
                    );

                    if ( isset ( $_POST['FIRSTNAME'] ) ) {
                        $params   = array (
                          'email'         => $EMAIL,
                          'ip_address'    => $ip_adress,
                          'subscribed_at' => date('YYYY-MM-DD HH:MM:SS'),
                          'name'          => $FNAME,
                        );
                    } else {
                        $params   = array (
                          'email'         => $EMAIL,
                          'ip_address'    => $ip_adress,
                          'subscribed_at' => date('YYYY-MM-DD HH:MM:SS'),
                        );
                    }

                    $subscribers      = $list->subscribers;
                    $new_subscribers  = $subscribers->create( $params );

                    if ( viral_coming_soon_is_gmail($EMAIL) ) {
                        $redirect_confirmation .= '&gmail=1';
                        $redirect_thankyou     .= '&gmail=1';
                    }
                    wp_redirect( $redirect . $redirect_confirmation );
                    exit;

                  } catch ( VCS_AWeberAPIException $exc ) {

                    if ( $exc->message == "email: Subscriber already subscribed and has not confirmed." ) {
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_confirmation );
                        exit;
                    } elseif ( $exc->message == "email: Subscriber already subscribed." ) {
                        if ( viral_coming_soon_is_gmail($EMAIL) ) {
                            $redirect_confirmation .= '&gmail=1';
                            $redirect_thankyou     .= '&gmail=1';
                        }
                        wp_redirect( $redirect . $redirect_thankyou );
                        exit;
                    } else {
                        print "$exc->type, $exc->message, $exc->documentation_url";
                    }
                  }

            }
        }
    }
    if ( get_option( 'aweber_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'aweber' ) {
        add_action( 'wp_loaded', 'viral_coming_soon_aweber_signup' );
    }
}