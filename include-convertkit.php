<?php

global $viral_coming_soon;

/**
 * Include Convertkit API Files
 **/
if ( ! empty( $viral_coming_soon['convertkit-api-code'] ) && $viral_coming_soon['email-marketing-provider'] == 'convertkit' ) :
    require_once plugin_dir_path( __FILE__ ) . 'admin/api/convertkit/vendor/autoload.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/api/convertkit/ConvertKit.php';
    $ConvertKit = new VCS_ConvertKit( $viral_coming_soon['convertkit-api-code'] );
endif;

/**
 * Campaign Monitor API Ping
 **/
if ( ! function_exists( 'convertkit_ping' ) ) :
    function convertkit_ping() {

        global $viral_coming_soon;
        global $ConvertKit;

        $result = $ConvertKit->request('/v3/forms', 'get');
        
        if ( ! isset( $result->forms ) ) {
            $error = json_decode( $result, true );
            if ( isset( $error['error'] ) ) {
                return false;
            }
        } else {
            return true;
        }

    }
endif;

/**
 * ConvertKit API Status Callback Function (Custom Field)
 **/
if ( ! function_exists( 'convertkit_api_connected' ) ) :
    function convertkit_api_connected( $args = null ) {
        
        global $viral_coming_soon;

        echo "<fieldset id='viral-coming-soon-{$args['id']}' class='redux-field-container redux-field'>";

        if ( empty( $viral_coming_soon['convertkit-api-code'] ) ) {
            echo "<p style='color:red'>Please enter your ConvertKit API Key first.</p>";
        } elseif ( ! empty( $viral_coming_soon['convertkit-api-code'] ) && $viral_coming_soon['email-marketing-provider'] != 'convertkit' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'convertkit_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'convertkit' || $viral_coming_soon['email-marketing-provider'] == 'convertkit' ) {
            $ping = convertkit_ping();
            if ( $ping ) {
                echo "<p style='color:green'>You are successfully connected.</p>";
                update_option( 'convertkit_api_status', true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please check your ConvertKit API Key.";
                update_option( 'convertkit_api_status', false );
            }
        }

        echo "</fieldset>";

    }
endif;

/**
 * ConvertKit Forms Callback Function (Custom Field)
 * Used inside the Admin Panel and Custom Meta Boxes
 * Redux passes the option arguments to the callback function so we can check the option ID
 * @var $args               string      Redux Option Element Arguments
 * @var $custom_meta_value  string      Only used in Custom Meta Boxes to pass saved form ID
 * @var $custom_meta_name   string      Only used in Custom Meta Boxes to pass Custom Meta Field Name
 **/
if ( ! function_exists( 'convertkit_forms' ) ) :
    function convertkit_forms( $args = null, $custom_meta_value = null, $custom_meta_name = null ) {

        global $viral_coming_soon;

        echo "<fieldset id='viral-coming-soon-{$args['id']}' class='redux-field-container redux-field'>";

        if ( empty( $viral_coming_soon['convertkit-api-code'] ) ) {
            echo "<p style='color:red'>Please enter your ConvertKit API Key first</p>";
        } elseif ( ! empty( $viral_coming_soon['convertkit-api-code'] ) && $viral_coming_soon['email-marketing-provider'] != 'convertkit' ) {
            echo "<p style='color:red'>Please save your options first.</p>";
        } elseif ( get_option( 'convertkit_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'convertkit' || $viral_coming_soon['email-marketing-provider'] == 'convertkit' ) {
            $ping = convertkit_ping();
            if ( $ping ) {
                if ( ! empty( $custom_meta_name ) ) {
                    convertkit_get_forms($args['id'], $custom_meta_value, $custom_meta_name );
                } else {
                    convertkit_get_forms($args['id']);
                }
                if ( isset( $args['desc'] ) ) {
                    echo '<p>' . $args['desc'] . '</p>';
                }
                update_option( 'convertkit_api_status', true );
            } else {
                echo "<p style='color:red'>Something is wrong. Please check your ConvertKit API Key</p>";
                update_option( 'convertkit_api_status', false );
            }
        }

        echo "</fieldset>";

    }
endif;

/**
 * Get Forms from Convertkit
 * @var $option                string      Redux Option Name
 * @var $custom_meta_value     string      Only used in Custom Meta Boxes to pass saved form ID
 * @var $custom_meta_name      string      Only used in Custom Meta Boxes to pass Custom Meta Field Name
 **/
if ( ! function_exists( 'convertkit_get_forms' ) ) :
    function convertkit_get_forms( $option = 'convertkit-forms', $custom_meta_value = null, $custom_meta_name = null ) {

        global $viral_coming_soon;
        global $ConvertKit;

        $result = $ConvertKit->request('/v3/forms', 'get');

        if ( isset( $result->forms ) && ! empty ( $result->forms ) ) {

            if ( ! empty ( $custom_meta_name ) ) {
                echo "<select name='$custom_meta_name'>";
            } else {
                echo "<select name='viral_coming_soon[$option]'>";
            }

            if ( $option != 'convertkit-forms' ) {

                if ( ! empty( $custom_meta_name ) ) {
                    ?>
                    <option value="" <?php if( ! empty( $custom_meta_value ) && $custom_meta_value == '' ) { echo "selected='selected'"; } ?>>[default]</option>
                    <?php 

                    ?>

                    <?php
                } else {
                    ?>
                    <option value="" <?php if( ! empty( $viral_coming_soon[ $option ] ) && $viral_coming_soon[ $option ] == '') { echo "selected='selected'"; } ?>>[default]</option>
                    <?php            
                }
            }
            
            foreach ( $result->forms as $form ) {

                if ( ! empty( $custom_meta_name ) ) {
                    ?>
                    <option value="<?php echo $form->id; ?>" <?php if ( ! empty( $custom_meta_value ) && $custom_meta_value == $form->id ) { echo "selected='selected'"; } ?>><?php echo 'ID: ' . $form->id . ' | ' . $form->name; ?></option>
                    <?php
                } else {
                    ?>
                    <option value="<?php echo $form->id; ?>" <?php if( ! empty( $viral_coming_soon[ $option ] ) && $viral_coming_soon[ $option ] == $form->id ) { echo "selected='selected'"; } ?>><?php echo 'ID: ' . $form->id . ' | ' . $form->name; ?></option>
                    <?php 
                }

            }

            echo "</select>";
        } else {
            echo "<p>You have no forms inside ConvertKit. Please create some first. <a href='https://app.convertkit.com/landing_pages' title='ConvertKit Forms' target='_blank'>Click here to create some forms inside ConvertKit</a></p>";
        }
    }
endif;

/**
 * Send Optin Form Values to ConvertKit
 **/
if ( ! function_exists( 'growbox_convertkit_signup' ) ) :
    function growbox_convertkit_signup() {

        global $viral_coming_soon;
        global $ConvertKit;

        if ( isset( $viral_coming_soon['convertkit-forms'] ) ) {

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

                if ( isset( $_POST['FORM'] ) ) {
                    $FORM   = sanitize_text_field( $_POST['FORM'] );
                } else{
                    $FORM   = $viral_coming_soon['convertkit-forms'];
                }

                $subscriber = array (
                    'email'  => $EMAIL,
                );

                if ( isset( $_POST['FIRSTNAME'] ) ) {
                    $subscriber['first_name'] = $FNAME;
                }

                $response = $ConvertKit->request("/v3/forms/$FORM/subscribe", "post", $subscriber);

                if ( $response->subscription->state == 'active' ) {
                    // If is subscribed
                    if ( viral_coming_soon_is_gmail($EMAIL) ) {
                        $redirect_confirmation .= '&gmail=1';
                        $redirect_thankyou     .= '&gmail=1';
                    }
                    wp_redirect( $redirect . $redirect_thankyou );
                    exit;
                } elseif ( $response->subscription->state == 'inactive' ) {
                    // if is pending
                    if ( viral_coming_soon_is_gmail($EMAIL) ) {
                        $redirect_confirmation .= '&gmail=1';
                        $redirect_thankyou     .= '&gmail=1';
                    }
                    wp_redirect( $redirect . $redirect_confirmation );
                    exit;
                } else {
                }

            }
        }
    }
    if ( get_option( 'convertkit_api_status' ) && $viral_coming_soon['email-marketing-provider'] == 'convertkit' ) {
        add_action( 'wp_loaded', 'growbox_convertkit_signup' );
    }
endif;