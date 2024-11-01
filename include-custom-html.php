<?php 

global $viral_coming_soon;

// Creates the Optin Form Values and saves them to the database
if ( ! function_exists('create_custom_html_form') ) :
    function create_custom_html_form() {

        global $viral_coming_soon;

        // Get the HTML Signup Form Code
        $html = $viral_coming_soon['custom-html-code'];

        // Create a new DOMDocument to get the Attribute Values
        $dom = new DOMDocument();

        if ( ! empty( $html ) && $dom->loadHTML( $html ) ) {
          
            // Get all HTML Forms 
            $forms = $dom->getElementsByTagName('form');

            $i = 0;
            foreach ($forms as $form) {
              
                // Save Form Attributes to variables
                $form_action = $form->getAttribute('action');

                if ( ! empty( $form_action ) ) 
                    update_option( 'custom_html_form_action', $form_action );

                // Check the HTML for input Elements
                $inputs = $dom->getElementsByTagName('input');
                
                foreach ($inputs as $input) {

                    // Save Input Attributes to variables
                    $input_name         = $input->getAttribute('name');
                    $input_value        = $input->getAttribute('value');
                    $input_type         = $input->getAttribute('type');
                    
                    if ( $input_type == 'hidden' ) {
                        // Add hidden inputs to array
                        $hidden_input[] = "<input type='hidden' name='$input_name' value='$input_value' />";
                    } elseif ( preg_match( '/name/i', $input_name ) && empty ( $name_input ) ) {
                        // Create input name array
                        $name_input['type']     = $input_type;
                        $name_input['name']     = $input_name;
                        $name_input['value']    = $input_value;
                    } elseif ( preg_match( '/email/i', $input_name ) && empty ( $email_input ) ) {
                        // Create input email array
                        $email_input['type']     = $input_type;
                        $email_input['name']     = $input_name;
                        $email_input['value']    = $input_value;
                    }
                }

                if ( ! empty( $hidden_input ) ) 
                    update_option( 'custom_html_hidden_inputs', $hidden_input );
                
                if ( ! empty( $name_input ) ) 
                    update_option( 'custom_html_name_input', $name_input );

                if ( ! empty( $email_input ) ) 
                    update_option( 'custom_html_email_input', $email_input );

                if ( ! empty( $normal_inputs ) ) 
                    update_option( 'custom_html_normal_inputs', $normal_inputs );

                if ( ! empty( $form_action ) && ! empty( $email_input ) ) {
                    return true;
                } else {
                    return false;
                }

                // Just do this once for the first form inside the HTML Code
                if (++$i > 0) {
                    break;
                }

            }
        }

    }
endif;

if ( ! function_exists( 'growbox_custom_html_signup' ) ) :
    function growbox_custom_html_signup() {

        global $viral_coming_soon;

        if ( isset( $viral_coming_soon['custom-html-code'] ) ) {

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

                $request = wp_remote_post( get_option('custom_html_form_action'), array(
                    'method' => 'POST',
                    'body' => $_POST,
                ));

                var_dump($request);

                if ( ! $viral_coming_soon['custom-html-double-optin'] ) {
                    if ( viral_coming_soon_is_gmail($EMAIL) ) {
                        $redirect_confirmation .= '&gmail=1';
                        $redirect_thankyou     .= '&gmail=1';
                    }
                    //wp_redirect( $redirect . $redirect_thankyou );
                    //exit;
                } else {
                    if ( viral_coming_soon_is_gmail($EMAIL) ) {
                        $redirect_confirmation .= '&gmail=1';
                        $redirect_thankyou     .= '&gmail=1';
                    }
                    //wp_redirect( $redirect . $redirect_confirmation );
                    //exit;
                }

            }
        }
    }
    if ( $viral_coming_soon['email-marketing-provider'] == 'custom-html' ) {
        add_action( 'wp_loaded', 'growbox_custom_html_signup' );
    }
endif;