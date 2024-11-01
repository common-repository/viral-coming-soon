<?php
/*
Plugin Name: Viral Coming Soon Page by Growtheme
Plugin URI: http://www.driveblogtraffic.com/
Description: Turn visitors into readers before publishing a single post. Build your audience from scratch in no time. Easy to set up. Premium code. For ever free.
Author: Jascha Brinkmann
Author URI: http://driveblogtraffic.com/
Version: 1.1.15
Text Domain: viral_coming_soon
Domain Path: /languages
*/

require_once(ABSPATH . 'wp-includes/pluggable.php');

/**
 Make plugin available for translation.
 **/
if ( ! function_exists( 'viral_coming_soon_load_textdomain' ) ) {
  function viral_coming_soon_load_textdomain() {
    $test = load_plugin_textdomain( 'viral_coming_soon', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
  }
  add_action( 'plugins_loaded', 'viral_coming_soon_load_textdomain', 10 );
}

// Include the Redux Framework Admin Panel
function include_redux_config(){
    require plugin_dir_path( __FILE__ ) . 'admin/admin-init.php';
}
add_action('plugins_loaded', 'include_redux_config', 20);

// Update Old Option Variable to new one
if ( get_option('growtheme_cs') && ! get_option('viral_coming_soon_updated') ) {
   $growtheme_cs = get_option('growtheme_cs');
   update_option('viral_coming_soon', $growtheme_cs);
   update_option('viral_coming_soon_updated', true);
}

// GET Global Variable
global $viral_coming_soon;
$viral_coming_soon = get_option ('viral_coming_soon');

global $opt_name;
$opt_name = 'viral_coming_soon';

/**
 Include Email Marketing Providers
 **/
require_once plugin_dir_path( __FILE__ ) . '/include-mailchimp.php';
require_once plugin_dir_path( __FILE__ ) . '/include-aweber.php';
require_once plugin_dir_path( __FILE__ ) . '/include-campaignmonitor.php';
require_once plugin_dir_path( __FILE__ ) . '/include-getresponse.php';
require_once plugin_dir_path( __FILE__ ) . '/include-convertkit.php';
require_once plugin_dir_path( __FILE__ ) . '/include-custom-html.php';

/**
 Create Signup Form
 **/
if ( ! function_exists( 'viral_coming_soon_optin_form' ) ) {
  function viral_coming_soon_optin_form( $cta = '' ) {
    
    global $viral_coming_soon;

    if ( isset( $viral_coming_soon['email-marketing-provider'] ) ) {
      $service = $viral_coming_soon['email-marketing-provider'];
    }

    ob_start();

    echo '<form action="'. esc_url( $_SERVER['REQUEST_URI'] ) .'" method="post" class="form" required>';
    
    // If First Name is enabled
    if ( isset( $viral_coming_soon['fname'] ) && $viral_coming_soon['fname'] ) {
        $classes = "name";
        $required = "";

        if ( $viral_coming_soon['fname-required'] ) {
            // Show First Name as required
            $classes .= " required";
            $required = "required";
        }

        if ( $service == 'custom-html' ) {
            $firstname_input_name = get_option('custom_html_name_input');
            $firstname_input_name = $firstname_input_name['name'];
        } else {
            $firstname_input_name = 'FIRSTNAME';
        }

        echo "<input type='text' placeholder='{$viral_coming_soon['fname-placeholder']}' value='' name='$firstname_input_name' class='$classes' $required/>";
    }

    if ( $service == 'custom-html' ) { 
        foreach ( get_option('custom_html_hidden_inputs') as $hidden_input ) {
            echo $hidden_input . "\n";
        }
    }

    if ( $service == 'custom-html' ) {
        $email_input_name = get_option('custom_html_email_input');
        $email_input_name = $email_input_name['name'];
    } else {
        $email_input_name = 'EMAIL';
    }    

    // WP Nonce
    wp_nonce_field( 'viral_coming_soon_form_submit', 'vcs_nonce', false, true );

    // Honeypot
    echo '<span><input type="text" name="name"></span>';
    
    // Show Email Field
    echo "<input type='email' placeholder='{$viral_coming_soon['email-placeholder']}' value='' name='$email_input_name' class='required email' required />";
    
    if ( isset( $cta ) && ! empty( $cta ) ) {
      // Instance CTA
      echo '<button type="submit" name="subscribe"><i class="fa fa-send"></i> ' . $viral_coming_soon['page-popup-cta'] . '</button>';
    } else {
      // Default CTA
      echo '<button type="submit" name="subscribe"><i class="fa fa-send"></i> Subscribe</button>';
    }
    
    echo '</form>';
    
    $output = ob_get_clean();
    
    return $output;
  }
}

/**
 Checks if $_SERVER['REMOTE_ADDR'] is an IPv4
 **/
if ( ! function_exists( 'viral_coming_soon_ipv4_check' ) ) {
  function viral_coming_soon_ipv4_check() {
    if( ! filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
      return false;
    } else {
      return true;
    }
  }
}

/**
 * Enqueue scripts and styles used in the theme
 */
function viral_coming_soon_enque_styles() {

    // Get all other Styles and dequeue on plugin internal pages
    global $wp_styles;
    foreach( $wp_styles->queue as $style_handle ) :
      if ( $style_handle != 'admin-bar' ) {
        wp_dequeue_style($style_handle);
      }
    endforeach;

    global $wp_scripts;
    foreach( $wp_scripts->queue as $scripts_handle ) :
      if ( $scripts_handle != 'admin-bar' || $scripts_handle != 'jquery' ) {
        wp_dequeue_script($scripts_handle);
      }
    endforeach;

    // Remove Growtheme Header Style output
    remove_action( 'wp_head', 'growtheme_custom_styles_scripts' );

    wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'viral_coming_soon_foundation', plugin_dir_url( __FILE__ ) . 'theme/css/foundation.min.css' );
    wp_enqueue_style( 'viral_coming_soon_flipclock', plugin_dir_url( __FILE__ ) . 'theme/css/flipclock.css' );
    wp_enqueue_style( 'viral_coming_soon_ouibounce', plugin_dir_url( __FILE__ ) . 'theme/css/ouibounce.min.css' );
    wp_enqueue_style( 'viral_coming_soon_theme', plugin_dir_url( __FILE__ ) . 'theme/css/theme.css' );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'viral_coming_soon_modernizr', plugin_dir_url( __FILE__ ) . 'theme/js/vendor/modernizr.js' );
    wp_enqueue_script( 'viral_coming_soon_foundation', plugin_dir_url( __FILE__ ) . 'theme/js/foundation.min.js' );
    wp_enqueue_script( 'viral_coming_soon_flipclock', plugin_dir_url( __FILE__ ) . 'theme/js/flipclock.min.js' );
    wp_enqueue_script( 'viral_coming_soon_ouibounce', plugin_dir_url( __FILE__ ) . 'theme/js/ouibounce.min.js' );
    wp_enqueue_script( 'viral_coming_soon_background_check', plugin_dir_url( __FILE__ ) . 'theme/js/background-check.min.js' );
}

/**
 Show the Coming Soon Page
 If is not admin panel, plugin is activated and hide for admins is set to false
 Or if is not admin panel, plugin is activated, hide for admins is set to true and current user is not admin
 Or if current user is admin, is not admin panel and preview is enabled (plugin disabled)
**/
if ( ! is_admin() && $viral_coming_soon['activated'] && ! $viral_coming_soon['hide-for-admins'] || ! is_admin() && $viral_coming_soon['activated'] && $viral_coming_soon['hide-for-admins'] && ! current_user_can( 'manage_options' ) || ! is_admin() && ! $viral_coming_soon['activated'] && current_user_can( 'manage_options' ) && $viral_coming_soon['preview']) {
    add_action( 'template_include', 'viral_coming_soon_index', 100 );
    if ( ! function_exists('viral_coming_soon_index') ) {
        function viral_coming_soon_index($template) {

            global $viral_coming_soon;

            $show_on_front = get_option( 'show_on_front' );
            $page_on_front = get_option( 'page_on_front' );
            $page_for_posts = get_option( 'page_for_posts' );

            if (
                strtotime( $viral_coming_soon['countdown-time'] ) <= time()
                && $viral_coming_soon['countdown']
                && ! empty( $viral_coming_soon['countdown-time'] ) )
            { // If Countdown is enabled and finished show wordpress page
                return $template;
            } elseif ( ! empty( $_GET['confirm'] ) ) { // Show Confirmation Page
                viral_coming_soon_shortcodes();
                add_action( 'wp_enqueue_scripts', 'viral_coming_soon_enque_styles', 2000 );
                require_once dirname( __FILE__ ) . '/theme/confirmation.php';
            } elseif ( ! empty( $_GET['thankyou'] ) ) { // Show Thank You Page
                viral_coming_soon_shortcodes();
                add_action( 'wp_enqueue_scripts', 'viral_coming_soon_enque_styles', 2000 );
                require_once dirname( __FILE__ ) . '/theme/thankyou.php';
            } elseif ( is_front_page() && $viral_coming_soon['page-type'] == '1' ) { // Show Front Page
                viral_coming_soon_shortcodes();
                add_action( 'wp_enqueue_scripts', 'viral_coming_soon_enque_styles', 2000 );
                require_once dirname( __FILE__ ) . '/theme/index.php';
            } elseif ( ! is_front_page() && $viral_coming_soon['page-type'] == '1' && $show_on_front == 'page' && empty( $page_on_front ) ) {
                viral_coming_soon_shortcodes();
                add_action( 'wp_enqueue_scripts', 'viral_coming_soon_enque_styles', 2000 );
                require_once dirname( __FILE__ ) . '/theme/index.php';
            } elseif ( $viral_coming_soon['page-type'] == '1' && $viral_coming_soon['forward-all-traffic'] ) { // Show Front Page
                wp_redirect( get_home_url() );
                exit;
            } elseif ( $viral_coming_soon['page-type'] == '0' && is_page( $viral_coming_soon['page-type-url'] ) ) { // Show specific page
                viral_coming_soon_shortcodes();
                add_action( 'wp_enqueue_scripts', 'viral_coming_soon_enque_styles', 2000 );
                require_once dirname( __FILE__ ) . '/theme/index.php';
            } else {
                return $template;
            }

        }
    }
}

/**
 * Removes other shortcodes to avoid conflicts on viral coming soon internal pages
 **/
if ( ! function_exists('viral_coming_soon_shortcodes' ) ) :
    function viral_coming_soon_shortcodes() {

        $shortcodes = array(
            'counter',
            'gmail',
            'like',
            'download',
            'share'
        );

        foreach ( $shortcodes as $shortcode ) {
            if( viral_coming_soon_shortcode_exists( $shortcode ) ) {
                remove_shortcode( $shortcode );
                add_shortcode( $shortcode, 'viral_coming_soon_' . $shortcode );
            } else {
                add_shortcode( $shortcode, 'viral_coming_soon_' . $shortcode );
            }
        }

    }
endif;

/**
 Upload Leadbribe Callback Field
**/
if ( ! function_exists('viral_coming_soon_upload_leadbribe') ) {
  function viral_coming_soon_upload_leadbribe() {
    global $viral_coming_soon;
    ?>
      <p>
        <input type="text" name="viral_coming_soon[leadbribe]" id="leadbribe" value="<?php if ( isset( $viral_coming_soon['leadbribe'] ) ) echo $viral_coming_soon['leadbribe']; ?>" />
        <input type="button" id="leadbribe-button" class="button" value="<?php _e( 'Choose or Upload a Leadmagnet', 'viral_coming_soon' )?>" />
      </p>
    <?php
  }
}

/**
 Enqueue Attachment Scripts when appropiate
 **/
if ( ! function_exists( 'viral_coming_soon_leadbribe_image_enqueue' ) ) {
  function viral_coming_soon_leadbribe_image_enqueue() {
      
      wp_enqueue_media();
   
      // Registers and enqueues the required javascript.
      wp_register_script( 'leadbribe', plugin_dir_url( __FILE__ ) . 'admin/js/leadbribe.js', array( 'jquery' ) );
      wp_localize_script( 'leadbribe', 'meta_attachment',
          array(
              'title' => __( 'Choose or Upload a Leadmagnet', 'viral_coming_soon' ),
              'button' => __( 'Use this Leadmagnet', 'viral_coming_soon' ),
          )
      );
      wp_enqueue_script( 'leadbribe' );

  }

  add_action( 'admin_enqueue_scripts', 'viral_coming_soon_leadbribe_image_enqueue' );
}

/**
 Shortcodes
 **/
require_once plugin_dir_path( __FILE__ ) . 'shortcodes.php';


/**
 * Detect Gmail Adresses
 *
 * Thanks to takien.com
 * @see       http://takien.com/blog/2012/01/21/prevent-spammer-to-register-using-the-same-gmail-email-duplicate-user-accounts/
 *
 * @param     string $email Email to strip
 * @return    return stripped email
 */
if ( ! function_exists('viral_coming_soon_is_gmail') ) {
  function viral_coming_soon_is_gmail( $email ) {
    // Detect if email string matches gmail or googlemail usign preg_match() regex
    if ( preg_match( '/gmail|googlemail/i', $email ) ) {
      return true;
    } else {
      return false;
    }
  }
}