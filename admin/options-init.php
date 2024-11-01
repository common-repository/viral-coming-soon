<?php 
    /**
     * ReduxFramework Growbox Config File
     * For full documentation, please visit: https://docs.reduxframework.com
     **/

    if ( !class_exists( 'Redux' ) ) {
        return;
    }

    $opt_name = "viral_coming_soon";

    $blog_url = get_bloginfo('url');

    $theme = wp_get_theme();

    /**
     * ---> SET ARGUMENTS
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     **/

    $args = array(
        // GENERAL
        'opt_name'              => 'viral_coming_soon',
        'display_name'          => $theme->get('Name'),
        'display_version'       => $theme->get('Version'),
        'menu_type'             => 'menu',
        'menu_title'            => __('Coming Soon','viral_coming_soon'),
        'page_title'            => __('Coming Soon','viral_coming_soon'),
        'google_api_key'        => 'AIzaSyBlSzEiPQfNJCjBDmZ8l5CxGBAd5anXUmc',
        'google_update_weekly'  => false,
        'async_typography'      => true,
        'admin_bar'             => true,
        'admin_bar_icon'        => 'dashicons-admin-generic',
        'admin_bar_priority'    => 50,
        'dev_mode'              => false,
        'update_notice'         => false,
        'customizer'            => false,
        'page_priority'         => '61',
        'page_parent'           => 'themes.php',
        'page_permissions'      => 'manage_options',
        'menu_icon'             => 'dashicons-admin-generic',
        'last_tab'              => '',
        'page_icon'             => 'dashicons-admin-generic',
        'page_slug'             => 'viral_coming_soon_options',
        'save_defaults'         => true,
        'default_show'          => false,
        'default_mark'          => '',
        'show_import_export'    => true,
        'transient_time'        => '3600',
        'output'                => false,
        'output_tag'            => true,
        'use_cdn'               => true,
        'compiler'              => true,
        'network_sites'         => true,
        'hide_reset'            => true,
        'ajax_save'             => false,
        'disable_tracking'      => true,

        // HINTS
        'hints'     => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'         => 'light',
                'shadow'        => false,
                'rounded'       => true,
                'style'         => '',
            ),
            'tip_position'  => array(
                'my'            => 'top left',
                'at'            => 'bottom right',
            ),
            'tip_effect'    => array(
                'show'          => array(
                    'effect'        => 'slide',
                    'duration'      => '500',
                    'event'         => 'mouseover',
                ),
                'hide'      => array(
                    'effect'        => 'slide',
                    'duration'      => '500',
                    'event'         => 'click mouseleave',
                ),
            ),
        ),
    );

    // ADMIN BAR LINKS
    /*
    $args['admin_bar_links'][] = array (
        'id'    => 'growtheme-docs',
        'href'  => 'http://docs.growtheme.com',
        'title' => __('Documentation', 'viral_coming_soon'),
    );

    $args['admin_bar_links'][] = array (
        'id'    => 'growtheme-support',
        'href'  => 'http://support.growtheme.com',
        'title' => __('Premium Support', 'viral_coming_soon'),
    );
    */

    // SOCIAL ICONS
    $args['share_icons'][] = array (
        'url'   => 'https://www.facebook.com/growtheme',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook',
    );

    $args['share_icons'][] = array (
        'url'   => 'http://twitter.com/growtheme',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter',
    );

    // PANEL INTRO & FOOTER TEXT
    $args['intro_text']     = '<p>' . __('<strong>Thank you for using our Coming Soon Plugin!</strong> If you encounter any problems feel free to write to <a href="mailto:support@growtheme.com">support@growtheme.com</a>.<br />If you like the plugin, please leave us a <a href="https://wordpress.org/support/view/plugin-reviews/viral-coming-soon?filter=5#postform" target="_blank">★★★★★ star rating on Wordpress.org</a>. This helps us a lot to spread the word!', 'viral_coming_soon') . '</p>';
    $args['footer_text']    = '<p>' . __('If you have downloaded this plugin without having joined our free email course, make sure you get the lessons that will help you to get your first 1000 subscribers: <a href="http://driveblogtraffic.com/">Get your first lesson here</a>', 'viral_coming_soon') . '</p>';

    Redux::setArgs( $opt_name, $args );

    /**
    GENERAL SETTINGS
    **/
    Redux::setSection( $opt_name, array(
        'title'     => __('General', 'viral_coming_soon'),
        'desc'      => __('Here you can set the general settings of the Coming Soon Plugin. For example if you want to enable or disable the Coming Soon Page, show or hide a First Name Field, use a different Email Field Placeholder, show the Sign Up Form in a Popup or connect your Twitter Account.', 'viral_coming_soon'),
        'icon'      => 'el el-cog',
        'fields'    => array(
            array(
                'id'       => 'powered',
                'type'     => 'switch',
                'title'    => __('Spread the word? ♥', 'viral_coming_soon'),
                'desc' => __("<span style='line-height:1.5; color:green'>This premium plugin is completely free, but still receives continues updates and support. <strong>Over 90% of our free users, spread the word by setting this option to &quot;Yes&quot;.</strong> This will only display a small credit link at the bottom of the plugin, helping your visitors to find and make use of the same plugin.</span>", 'viral_coming_soon'),
                'on'       => __('Yes','viral_coming_soon'),
                'off'      => __('No','viral_coming_soon'),
                'default'  => 0,
            ),
            array(
                'id'       => 'activated',
                'type'     => 'switch',
                'title'    => __('Plugin Status', 'viral_coming_soon'),
                'desc' => __('Do you want to enable the Coming Soon Page for all Blog visitors?', 'viral_coming_soon'),
                'on'       => __('Enabled','viral_coming_soon'),
                'off'      => __('Disabled','viral_coming_soon'),
                'default'  => 0,
            ),
            array(
                'id'       => 'preview',
                'type'     => 'switch',
                'title'    => __('Preview Mode', 'viral_coming_soon'),
                'desc' => __('When enabled you can preview your the page when logged in as an admin user', 'viral_coming_soon'),
                'on'       => __('Enabled','viral_coming_soon'),
                'off'      => __('Disabled','viral_coming_soon'),
                'default'  => 1,
                'required' => array(
                    array( 'activated', '=', 0 ),
                ),
            ),
            array(
                'id'       => 'hide-for-admins',
                'type'     => 'switch',
                'title'    => __('Hide for Admins?', 'viral_coming_soon'),
                'desc' => __('If you want to work on your blog, while showing to visitors the coming soon page set this option to "Hide"', 'viral_coming_soon'),
                'on'       => __('Hide','viral_coming_soon'),
                'off'      => __('Show','viral_coming_soon'),
                'default'  => 0,
                'required' => array(
                    array( 'activated', '=', 1 ),
                ),
            ),
            array(
                'id'       => 'page-type',
                'type'     => 'switch',
                'title'    => __('Use as Homepage', 'viral_coming_soon'),
                'desc' => __('Do you want to show the Coming Soon Page as your Blog Homepage or do you prefer a Landingpage?', 'viral_coming_soon'),
                'on'       => __('Show as Homepage','viral_coming_soon'),
                'off'      => __('Show as Landingpage','viral_coming_soon'),
                'default'  => 1,
            ),
            array(
                'id'       => 'forward-all-traffic',
                'type'     => 'switch',
                'title'    => __('Forward all traffic?', 'viral_coming_soon'),
                'desc'     => __('Enable this if you wan\'t to forward all your subpages to the coming soon page. You shouldn\'t use this if you have a lot of existing content that is already ranking well on Google. Please make sure as well that you select "hide" for admins to be able to work on your Blog beind the scenes.', 'viral_coming_soon'),
                'on'       => __('Enable','viral_coming_soon'),
                'off'      => __('Disable','viral_coming_soon'),
                'default'  => 0,
                'required' => array(
                    array( 'activated', '=', 1 ),
                    array( 'page-type', '=', 1 ),
                ),
            ),
            array(
                'id'       => 'page-type-url',
                'type'     => 'select',
                'data'     => 'page',
                'title'    => __('On which page do you want to show the coming soon page?', 'viral_coming_soon'),
                'desc' => __('Choose one of your wordpress pages to replace with the coming soon page', 'viral_coming_soon'),
                'required' => array( 'page-type', '=', 0 ),
            ),            
            array(
                'id'       => 'email-placeholder',
                'type'     => 'text',
                'title'    => 'Email Field Placeholder',
                'desc' => 'What should be the placeholder for your Email Field?<br /><em>E.g.: "Your Email"</em>',
                'default'  => 'Your Email',
            ),
            array(
                'id'       => 'fname',
                'type'     => 'switch',
                'title'    => __('Show First Name Field', 'viral_coming_soon'),
                'desc' => __('Do you want to ask for the first name of the user?', 'viral_coming_soon'),
                'on'       => __('Show','viral_coming_soon'),
                'off'      => __('Hide','viral_coming_soon'),
                'default'  => 1,
            ),
            array(
                'id'       => 'fname-placeholder',
                'type'     => 'text',
                'title'    => __('Name Field Placeholder', 'viral_coming_soon'),
                'desc' => __('What should be the placeholder for your Namefield?<br /><em>E.g.: "Your First Name"</em>', 'viral_coming_soon'),
                'default'  => __('Your First Name', 'viral_coming_soon'),
                'required' => array( 'fname', '=', 1 ),
            ),
            array(
                'id'       => 'fname-required',
                'type'     => 'switch',
                'title'    => __('Should the Name Field be required?', 'viral_coming_soon'),
                'desc' => __("If the visitor doesn't fill in the Firstname an error is displayed", 'viral_coming_soon'),
                'on'       => __('Required','viral_coming_soon'),
                'off'      => __('Optional','viral_coming_soon'),
                'default'  => 1,
                'required' => array( 'fname', '=', 1 ),
            ),
            array(
                'id'       => 'custom_analytics',
                'type'     => 'ace_editor',
                'title'    => __('Custom Javascript', 'viral_coming_soon'),
                'desc'     => __('Copy & Paste your custom javascript code here. For Example: Google Analytics or Facebook Tracking Pixel Code', 'viral_coming_soon'),
                'mode'     => 'html',
            ),
            array(
                'id'       => 'custom_styles',
                'type'     => 'ace_editor',
                'title'    => __('Custom CSS', 'viral_coming_soon'),
                'desc'     => __('Write here any custom CSS you want to add.', 'viral_coming_soon'),
                'mode'     => 'css',
            ),
        ),
    ) );

    /**
    EMAIL MARKETING PROVIDER SETTINGS
    **/
    Redux::setSection( $opt_name,array(
        'title'     => __('Email Optin', 'viral_coming_soon'),
        'desc'      => __('Connect your favorite Email Provider to the Coming Soon Plugin.<br />We currently support <strong>Mailchimp</strong>, <strong>AWeber</strong>, <strong>CampaignMonitor</strong> and <strong>GetResponse</strong>.', 'viral_coming_soon'),
        'icon'      => 'el el-envelope',
        'fields'    => array(
            array(
                'id'        => 'email-marketing-provider',
                'type'      => 'button_set',
                'title'     => __('Choose your Email Service', 'viral_coming_soon'),
                'options'   => array (
                    'mailchimp'         => 'Mailchimp',
                    'aweber'            => 'AWeber',
                    'campaignmonitor'   => 'Campaign Monitor',
                    'getresponse'       => 'GetResponse',
                    'convertkit'        => 'ConvertKit',
                    'custom-html'       => 'Custom HTML',
                ),
            ),
            /**
            MAILCHIMP SETTINGS
            **/
            array(
                'id'        => 'mailchimp-start',
                'type'      => 'section',
                'indent'    => true,
                'required'  => array ( 'email-marketing-provider', '=', 'mailchimp' ),
            ),
            array(
                'id'        => 'mailchimp-api-key',
                'type'      => 'text',
                'title'     => __('Mailchimp API Key', 'viral_coming_soon'),
                'subtitle'  => __('Copy & Paste your API Key here', 'viral_coming_soon'),
                'desc'      => __('<p><em>Click on the link, login to your MailChimp Account.</em></p><p><em>Then create a new API Key and copy it into this field.</em></p><p><a href="https://admin.mailchimp.com/account/api/" title="Mailchimp API Key" target="_blank">Click here to get your Mailchimp API Key</a></p>', 'viral_coming_soon'),
                'compiler'  => true,
                'required'  => array ( 'email-marketing-provider', '=', 'mailchimp' ),
            ),
            array(
                'id'        => 'mailchimp-api-connected',
                'type'      => 'callback',
                'title'     => __('Mailchimp API Status', 'viral_coming_soon'),
                'callback'  => 'viral_coming_soon_mailchimp_api_connected',
                'required'  => array ( 'email-marketing-provider', '=', 'mailchimp' ),
            ),
            array(
                'id'        => 'mailchimp-lists',
                'type'      => 'callback',
                'title'     => __('Which List do you want to use?', 'viral_coming_soon'),
                'subtitle'  => __('Choose one of your Mailchimp Lists', 'viral_coming_soon'),
                'callback'  => 'viral_coming_soon_mailchimp_lists',
                'required'  => array ( 'email-marketing-provider', '=', 'mailchimp' ),
            ),
            array(
                'id'        => 'mailchimp-double-optin',
                'type'      => 'switch',
                'title'     => __('Use Double Optin?', 'viral_coming_soon'),
                'subtitle'  => __('Should Visitors first need to confirm their email-adress before being subscribed?<br /><em style="color:green">Recommended</em>', 'viral_coming_soon'),
                'on'        => __('Double Optin','viral_coming_soon'),
                'off'       => __('Single Optin','viral_coming_soon'),
                'required'  => array ( 'email-marketing-provider', '=', 'mailchimp' ),
            ),
            array(
                'id'        => 'mailchimp-end',
                'type'      => 'section',
                'indent'    => false,
                'required'  => array ( 'email-marketing-provider', '=', 'mailchimp' ),
            ),
            /**
            AWEBER SETTINGS
            **/
            array(
                'id'        => 'aweber-start',
                'type'      => 'section',
                'indent'    => true,
                'required'  => array ( 'email-marketing-provider', '=', 'aweber' ),
            ),
            array(
                'id'        => 'aweber-auth-code',
                'type'      => 'text',
                'title'     => __('AWeber Authorization Code', 'viral_coming_soon'),
                'subtitle'  => __('Copy & Paste your Authorization Code here', 'viral_coming_soon'),
                'desc'      => __('<p><em>Click on the link and login to your AWeber Account.</em></p><p><em>Then copy the Authorization Code into this field</em></p><p><a href="https://auth.aweber.com/1.0/oauth/authorize_app/f38e902d" title="Aweber Auth Code" target="_blank">Click here to get your AWeber Authorization Code</a></p>', 'viral_coming_soon'),
                'compiler'  => true,
                'required'  => array ( 'email-marketing-provider', '=', 'aweber' ),
            ),
            array(
                'id'        => 'aweber-api-connected',
                'type'      => 'callback',
                'title'     => __('AWeber API Status', 'viral_coming_soon'),
                'callback'  => 'viral_coming_soon_aweber_api_connected',
                'default'   => 0,
                'required'  => array ( 'email-marketing-provider', '=', 'aweber' ),
            ),
            array(
                'id'        => 'aweber-lists',
                'type'      => 'callback',
                'title'     => __('Which List do you want to use?', 'viral_coming_soon'),
                'subtitle'  => __('Choose one of your Aweber Lists', 'viral_coming_soon'),
                'callback'  => 'viral_coming_soon_aweber_lists',
                'required'  => array ( 'email-marketing-provider', '=', 'aweber' ),
            ),
            array(
                'id'        => 'aweber-end',
                'type'      => 'section',
                'indent'    => false,
                'required'  => array ( 'email-marketing-provider', '=', 'aweber' ),
            ),
            /**
            CAMPAIGN MONITOR SETTINGS
            **/
            array(
                'id'        => 'campaignmonitor-start',
                'type'      => 'section',
                'indent'    => true,
                'required'  => array ( 'email-marketing-provider', '=', 'campaignmonitor' ),
            ),
            array(
                'id'        => 'campaignmonitor-api-code',
                'type'      => 'text',
                'title'     => __('Campaign Monitor API Key', 'viral_coming_soon'),
                'subtitle'  => __('Copy & Paste your API Key here', 'viral_coming_soon'),
                'desc'      => __('<p><em>Click on the link and login to your Campaign Monitor Account.</em></p><p><em>Next go to your "Account Settings"-Page and click on "Show API Key".</em></p><p><em>Copy the code into this field and save the settings</em></p><p><a href="https://login.createsend.com/l#" title="Campaign Monitor API Key" target="_blank">Click here to get your Campaign Monitor API Key</a></p>', 'viral_coming_soon'),
                'compiler'  => true,
                'required'  => array ( 'email-marketing-provider', '=', 'campaignmonitor' ),
            ),
            array(
                'id'        => 'campaignmonitor-api-connected',
                'type'      => 'callback',
                'title'     => __('Campaign Monitor API Status', 'viral_coming_soon'),
                'callback'  => 'viral_coming_soon_campaignmonitor_api_connected',
                'default'   => 0,
                'required'  => array ( 'email-marketing-provider', '=', 'campaignmonitor' ),
            ),
            array(
                'id'        => 'campaignmonitor-lists',
                'type'      => 'callback',
                'title'     => __('Which List do you want to use?', 'viral_coming_soon'),
                'subtitle'  => __('Choose one of your Campaign Monitor Lists', 'viral_coming_soon'),
                'callback'  => 'viral_coming_soon_campaignmonitor_lists',
                'required'  => array ( 'email-marketing-provider', '=', 'campaignmonitor' ),
            ),
            array(
                'id'       => 'campaignmonitor-double-optin',
                'type'     => 'switch',
                'title'    => __('Use Double Optin?', 'viral_coming_soon'),
                'subtitle' => __('Should Visitors first need to confirm their email-adress before being subscribed?<br /><em style="color:green">Recommended</em>', 'viral_coming_soon'),
                'on'       => __('Double Optin','viral_coming_soon'),
                'off'      => __('Single Optin','viral_coming_soon'),
                'required'  => array ( 'email-marketing-provider', '=', 'campaignmonitor' ),
            ),
            array(
                'id'        => 'campaignmonitor-end',
                'type'      => 'section',
                'indent'    => false,
                'required'  => array ( 'email-marketing-provider', '=', 'campaignmonitor' ),
            ),
            /**
            GET RESPONSE SETTINGS
            **/
            array(
                'id'        => 'getresponse-start',
                'type'      => 'section',
                'indent'    => true,
                'required'  => array ( 'email-marketing-provider', '=', 'getresponse' ),
            ),
            array(
                'id'        => 'getresponse-api-code',
                'type'      => 'text',
                'title'     => __('GetResponse API Key', 'viral_coming_soon'),
                'subtitle'  => __('Copy & Paste your API Key here', 'viral_coming_soon'),
                'desc'      => __('<p><em>Click on the link and login to your GetResponse Account.</em></p><p><em>Then copy the API Key into this field</em></p><p><a href="https://app.getresponse.com/account.html#api" title="GetResponse API Key" target="_blank">Click here to get your GetResponse API Key</a></p>', 'viral_coming_soon'),
                'compiler'  => true,
                'required'  => array ( 'email-marketing-provider', '=', 'getresponse' ),
            ),
            array(
                'id'        => 'getresponse-api-connected',
                'type'      => 'callback',
                'title'     => __('GetResponse API Status', 'viral_coming_soon'),
                'callback'  => 'viral_coming_soon_getresponse_api_connected',
                'default'   => 0,
                'required'  => array ( 'email-marketing-provider', '=', 'getresponse' ),
            ),
            array(
                'id'        => 'getresponse-campaigns',
                'type'      => 'callback',
                'title'     => __('Which Campaign do you want to use?', 'viral_coming_soon'),
                'subtitle'  => __('Choose one of your GetResponse Campaigns', 'viral_coming_soon'),
                'callback'  => 'viral_coming_soon_getresponse_campaigns',
                'required'  => array ( 'email-marketing-provider', '=', 'getresponse' ),
            ),
            array(
                'id'        => 'getresponse-end',
                'type'      => 'section',
                'indent'    => false,
                'required'  => array ( 'email-marketing-provider', '=', 'getresponse' ),
            ),
            /**
             * CONVERTKIT SETTINGS
             **/
            array(
                'id'        => 'convertkit-start',
                'type'      => 'section',
                'indent'    => true,
                'required'  => array ( 'email-marketing-provider', '=', 'convertkit' ),
            ),
            array(
                'id'        => 'convertkit-api-code',
                'type'      => 'text',
                'title'     => __('ConvertKit API Key', 'growbox'),
                'subtitle'  => __('Copy & Paste your API Key here', 'growbox'),
                'desc'      => __('<p><em>Click on the link and login to your ConvertKit Account.</em></p><p><em>Next go to your "Account"-Page and copy the "API Key".</em></p><p><em>Paste the code into this field and save the settings</em></p><p><a href="https://app.convertkit.com/account/edit" title="ConvertKit API Key" target="_blank">Click here to get your ConvertKit API Key</a></p>', 'growbox'),
                'compiler'  => true,
                'required'  => array ( 'email-marketing-provider', '=', 'convertkit' ),
            ),
            array(
                'id'        => 'convertkit-api-connected',
                'type'      => 'callback',
                'title'     => __('ConvertKit API Status', 'growbox'),
                'callback'  => 'convertkit_api_connected',
                'default'   => 0,
                'required'  => array ( 'email-marketing-provider', '=', 'convertkit' ),
            ),
            array(
                'id'        => 'convertkit-forms',
                'type'      => 'callback',
                'title'     => __('Which default Form do you want to use?', 'growbox'),
                'subtitle'  => __('Choose the default form to use if no other form is specified', 'growbox'),
                'desc'      => __('<p>You can choose specific forms for each optin form at the bottom of each individual settings page. <a href="https://docs.growtheme.com/v1/email-provider-settings/connect-to-convertkit/#convertkit-forms">Read more</a></p><br />'),
                'callback'  => 'convertkit_forms',
                'required'  => array ( 'email-marketing-provider', '=', 'convertkit' ),
            ),
            array(
                'id'       => 'convertkit-info',
                'type'     => 'info',
                'style'    => 'info',
                'title'    => 'Convertkit Double Optin:',
                'desc'     => __("You can change your ConvertKit Double Optin Settings individual for each form inside your ConvertKit Account. <a href='https://docs.growtheme.com/v1/email-provider-settings/connect-to-convertkit/#convertkit-single-or-double-optin'>Read more</a>", 'growbox'),
                'required'  => array ( 'email-marketing-provider', '=', 'convertkit' ),
            ),
            array(
                'id'        => 'convertkit-end',
                'type'      => 'section',
                'indent'    => false,
                'required'  => array ( 'email-marketing-provider', '=', 'convertkit' ),
            ),
            /**
             * CUSTOM HTML
             **/
            array(
                'id'        => 'custom-html-code',
                'type'      => 'textarea',
                'rows'      => 20,
                'title'     => __('Your Custom HTML Form Code', 'growbox'),
                'subtitle'  => __('Copy & Paste your Custom HTML Form Code here to include other Email Service Provider that currently are not supported natively.', 'growbox'),
                'compiler'  => true,
                'validate'  => 'html_custom',
                'allowed_html'  => array(
                    'input' => array(
                        'type'  => array(),
                        'name'  => array(),
                        'value' => array(),
                        'id'    => array(),
                        'class' => array(),
                        'type'  => array(),
                        'placeholder'   => array(),
                    ),
                    'form'  => array(
                        'method'    => array(),
                        'action'    => array(),
                        'type'  => array(),
                        'name'  => array(),
                        'value' => array(),
                        'id'    => array(),
                        'class' => array(),
                        'type'  => array(),
                        'placeholder'   => array(),
                    ),
                    'button'=> array(
                        'method'    => array(),
                        'action'    => array(),
                        'type'  => array(),
                        'name'  => array(),
                        'value' => array(),
                        'id'    => array(),
                        'class' => array(),
                        'type'  => array(),
                        'placeholder'   => array(),
                    ),
                ),
                'required'  => array ( 'email-marketing-provider', '=', 'custom-html' ),
            ),
            array(
                'id'        => 'custom-html-double-optin',
                'type'      => 'switch',
                'title'     => __('Do you use a Double Optin Process?', 'growbox'),
                'subtitle'  => __('This Setting influences if subscribers should be redirected to the Confirmation or Thank You Page.', 'growbox'),
                'on'        => __('Confirmation Page','growbox'),
                'off'       => __('Thank You Page','growbox'),
                'desc'      => __('<p><strong>Please note:</strong> As you are using a Custom HTML Form Integration, changing this setting will not affect the settings of your Email Service Provider. <a href="https://docs.growtheme.com/v1/email-provider-settings/connect-with-custom-html/#connect-with-custom-html" title="Documentation" target="_blank">Read more</a>','growbox'),
                'required'  => array ( 'email-marketing-provider', '=', 'custom-html' ),
            ),
        ),
    ) );

    /**
    STYLING SETTINGS
    **/            
    Redux::setSection( $opt_name, array(
        'title'     => __('Styling', 'viral_coming_soon'),
        'desc'      => __('Upload a Logo, Background Image and choose your basic colors.', 'viral_coming_soon'),
        'icon'      => 'el el-brush',
        'fields'    => array(
            array(
                'id'    => 'logo',
                'type'  => 'media',
                'title' => __('Upload a Logo','viral_coming_soon'),
            ),
            array(
                'id'            => 'logo-color',
                'type'          => 'color',
                'title'         => __('Logo Text Color', 'viral_coming_soon'),
                'desc'          => __('You can specify a custom Logo text color if you don\'t upload a Logo', 'viral_coming_soon'),
                'default'       => '#cccccc',
                'validate'      => 'color',
                'transparent'   => false,
            ),
            array(
                'id'        => 'box-background',
                'type'      => 'color_rgba',
                'title'     => __('Box Background Color', 'viral_coming_soon'),
                'desc'  => __('Choose the Background Color and Transparency of the Text Box<br /><em>Default: rgba( 255, 255, 255, 1)</em>', 'viral_coming_soon'),
                'default'   => array (
                    'color' => '#FFFFFF',
                    'alpha' => 1,
                ),
                'options'       => array(
                    'show_input'                => true,
                    'show_initial'              => false,
                    'show_alpha'                => true,
                    'show_palette'              => false,
                    'show_palette_only'         => false,
                    'show_selection_palette'    => false,
                    'max_palette_size'          => 10,
                    'allow_empty'               => true,
                    'clickout_fires_change'     => false,
                    'choose_text'               => 'Choose',
                    'cancel_text'               => 'Cancel',
                    'show_buttons'              => true,
                    'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Box Background Color and Transparency'
                ),
            ),
            array(
                'id'       => 'background',
                'type'     => 'background',
                'title'    => 'Page Background:',
                'desc'  =>  __('At least 1200x800 px in size', 'viral_coming_soon'),
                'transparent'   => false,
                'background-size'   => false,
                'background-attachment' => false,
                'background-position'     => false,
                'background-repeat'     => false,
                'default'  => array(
                    'background-color' => '#eceef1',
                ),
            ),
            array(
                'id'        => 'background-overlay-color',
                'type'      => 'color_rgba',
                'title'     => __('Background Overlay Color', 'viral_coming_soon'),
                'desc'  => __('Choose the Background Overlay Color and Transparency<br /><em>Default: rgba( 0, 0, 0, 0.8)</em>', 'viral_coming_soon'),
                'default'   => array (
                    'color' => '#000000',
                    'alpha' => 0.8,
                ),
                'options'       => array(
                    'show_input'                => true,
                    'show_initial'              => false,
                    'show_alpha'                => true,
                    'show_palette'              => false,
                    'show_palette_only'         => false,
                    'show_selection_palette'    => false,
                    'max_palette_size'          => 10,
                    'allow_empty'               => true,
                    'clickout_fires_change'     => false,
                    'choose_text'               => 'Choose',
                    'cancel_text'               => 'Cancel',
                    'show_buttons'              => true,
                    'use_extended_classes'      => true,
                    'palette'                   => null,  // show default
                    'input_text'                => 'Select Background Color and Transparency'
                ),
            ),
            array(
                'id'            => 'text-color',
                'type'          => 'color',
                'title'         => __('Box Text Color', 'viral_coming_soon'),
                'desc'          => __('The color of the main box text', 'viral_coming_soon'),
                'default'       => '#27292b',
                'validate'      => 'color',
                'transparent'   => false,
            ),
            array(
                'id'            => 'small-text-color',
                'type'          => 'color',
                'title'         => __('Small Link Text Color', 'viral_coming_soon'),
                'desc'          => __('The color of the small link below the Call To Action Button', 'viral_coming_soon'),
                'default'       => '#adadad',
                'validate'      => 'color',
                'transparent'   => false,
            ),
            array(
                'id'            => 'cta-color',
                'type'          => 'color',
                'title'         => __('Call To Action Color', 'viral_coming_soon'),
                'desc'      => __('Carefully used to emphazize important Call to Actions<br /><em>Default: #d52c40</em>', 'viral_coming_soon'),
                'default'       => '#d52c40',
                'validate'      => 'color',
                'transparent'   => false,
            ),
        ),
    ) );

    Redux::setSection( $opt_name, array(
        'type' => 'divide',
    ) );

    /**
    COMING SOON PAGE SETTINGS
    **/
    Redux::setSection( $opt_name, array(
        'title'     => __('Coming Soon Page', 'viral_coming_soon'),
        'desc'      => __('Set the settings for your Coming Soon Page', 'viral_coming_soon'),
        'icon'      => 'el el-star-alt',
        'fields'    => array(
            array(
                'id'       => 'page-headline',
                'type'     => 'text',
                'title'    => __('Page Headline', 'viral_coming_soon'),
                'desc'     => __('This should be your main benefit statement', 'viral_coming_soon'),
                'default'  => __('Ready to go, High Quality, Premium Resources for Webdesigners and Creative Folks Weekly Completely for Free!', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'page-text',
                'type'     => 'textarea',
                'title'    => __('Page Text', 'viral_coming_soon'),
                'desc'     => __('The text should explain that the blog is still not launched yet but that people can sign up for your prelaunch list', 'viral_coming_soon'),
                'default'  => __('We are currently still in beta mode.
Click the link below to join thousands of designers that will get advanced notice once we launch.', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'page-cta-text',
                'type'     => 'text',
                'title'    => __('Call To Action Text', 'viral_coming_soon'),
                'desc'     => __('The text of your Call to Action Button', 'viral_coming_soon'),
                'default'  => __('Get Early Notification »', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'page-small-link',
                'type'     => 'text',
                'title'    => __('Small Link below Button', 'viral_coming_soon'),
                'desc'     => __('This is a second call to action, below the button shown as a simple link. It should say clearly what the user can do after clicking on the link', 'viral_coming_soon'),
                'default'  => __('Yes! I Want on The Early Bird Notification List', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'page-popup-headline',
                'type'     => 'text',
                'title'    => __('Optin Form Popup Headline', 'viral_coming_soon'),
                'desc' => __('The Headline of the Optin Form Popup', 'viral_coming_soon'),
                'default'  => __('Get On The Early Bird Notification List', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'page-popup-cta',
                'type'     => 'text',
                'title'    => __('Optin Form Popup Subscribe Button', 'viral_coming_soon'),
                'desc' => __('The Text of the Call to Action (Subscribe) Button inside the Popup', 'viral_coming_soon'),
                'default'  => __('Get on the List!', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'page-popup-small',
                'type'     => 'text',
                'title'    => __('Optin Form Popup Small Text', 'viral_coming_soon'),
                'desc' => __('The small text inside your Popup, shown below the optin form', 'viral_coming_soon'),
                'default'  => __('100% Privacy. We will never spam you.', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'countdown',
                'type'     => 'switch',
                'title'    => __('Show Countdown', 'viral_coming_soon'),
                'desc' => __('Do you want to show a countdown?', 'viral_coming_soon'),
                'on'       => __('Show','viral_coming_soon'),
                'off'      => __('Hide','viral_coming_soon'),
                'default'  => 0,
            ),
            array(
                'id'       => 'countdown-time',
                'type'     => 'date',
                'title'    => __('When do you want to launch your blog?', 'viral_coming_soon'),
                'desc' => __('Choose a date in the future. <br /><em>Important: Once you reach the date the plugin will be automatically deactivated.</em>', 'viral_coming_soon'),
                'required' => array( 'countdown', '=', 1 ),
            ),
        ),
    ) );

    /**
    EXIT INTENT POPUP SETTINGS
    **/
    Redux::setSection( $opt_name, array(
        'title'     => __('Exit Intent Popup', 'viral_coming_soon'),
        'desc'      => __('Configure your Exit Intent Popup. It shows up if a visitor tries to abandon the page, without having joined your prelaunch list. The copy of the popup should make a reference to your leadbribe, that subscribers get after joining.', 'viral_coming_soon'),
        'icon'      => 'el el-repeat',
        'fields'    => array(   
            array(
                'id'       => 'leadbribe',
                'type'     => 'callback',
                'title'    => __('Upload your Leadmagnet', 'viral_coming_soon'),
                'callback' => 'viral_coming_soon_upload_leadbribe',
            ),
            array(
                'id'       => 'exit-intent',
                'type'     => 'switch',
                'title'    => __('Enable Exit Intent Popup?', 'viral_coming_soon'),
                'desc' => __('Do you want to show a popup if the visitor intents to leave the page without subscribing?', 'viral_coming_soon'),
                'on'       => __('Enable','viral_coming_soon'),
                'off'      => __('Disable','viral_coming_soon'),
                'default'  => 1,
            ),
            array(
                'id'       => 'exit-intent-headline',
                'type'     => 'text',
                'title'    => __('Popup Headline', 'viral_coming_soon'),
                'desc' => __('The Headline of the Exit Intent Popup', 'viral_coming_soon'),
                'default'  => __('Hold on! If you join the Early Bird List today, you will get an extremly useful, High Quality Icon Set right into your inbox for free!', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'exit-intent-text',
                'type'     => 'editor',
                'title'    => __('Popup Text', 'viral_coming_soon'),
                'desc' => __('The Text of the Exit Intent Popup', 'viral_coming_soon'),
                'default'  => __('Pixel perfect | Easy to use | 3 Sizes black and white | PNG, AI, SVGs & Icon Font included | Free for personal & commercial use', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'exit-intent-yes-text',
                'type'     => 'text',
                'title'    => __('YES Button Text', 'viral_coming_soon'),
                'subtitle' => __('What should say the "Yes" Button', 'viral_coming_soon'),
                'desc'     => __('When visitors click on this button they will be asked for their email', 'viral_coming_soon'),
                'default'  => __('I want my free Icon Set now', 'viral_coming_soon'),

            ),
            array(
                'id'       => 'exit-intent-no-text',
                'type'     => 'text',
                'title'    => __('NO Button Text', 'viral_coming_soon'),
                'subtitle' => __('What should say the "No" Button', 'viral_coming_soon'),
                'desc'     => __('This button will close the Exit Intent Popup', 'viral_coming_soon'),
                'default'  => __('I will create it on my own', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'exit-intent-cta',
                'type'     => 'text',
                'title'    => __('Exit Intent Popup Call To Action Text', 'viral_coming_soon'),
                'desc' => __('The Text of the Submit Call to Action Button inside the Popup', 'viral_coming_soon'),
                'default'  => __('Get on the List!', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'exit-intent-form-headline',
                'type'     => 'text',
                'title'    => __('Optin Form Headline', 'viral_coming_soon'),
                'desc' => __('The headline of the Optin Form', 'viral_coming_soon'),
                'default'  => __('Where should I send you the free Icon Set?', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'exit-intent-small',
                'type'     => 'text',
                'title'    => __('Popup Small Text', 'viral_coming_soon'),
                'desc' => __('The small text inside your Popup', 'viral_coming_soon'),
                'default'  => __('100% Privacy. We will never spam you.', 'viral_coming_soon'),
            ),
        ),
    ) );

    /**
    CONFIRMATION PAGE SETTINGS
    **/
    Redux::setSection( $opt_name, array(
        'title'     => __('Confirmation Page', 'viral_coming_soon'),
        'desc'      => __('If you use a Double Optin Process with your Email Provider, you have to configure this page.', 'viral_coming_soon'),
        'icon'      => 'el el-file',
        'fields'    => array(
            array(
                'id'       => 'confirmation-headline',
                'type'     => 'text',
                'title'    => __('Headline', 'viral_coming_soon'),
                'default'  => __('Hold on! One more thing to do.', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'confirmation-text',
                'type'     => 'editor',
                'title'    => __('Text', 'viral_coming_soon'),
                'subtitle' => __('Explain what the user has to do in order to subscribe.', 'viral_coming_soon'),
                'default'  => __('<p>Thank you for your interest. There is just one last step! Please check your inbox right now and <strong>click the confirmation link that we just sent you.</strong></p><p>[gmail]</p><p>Its just a safety procedure to make sure no one has hijacked your email address and it will only take you a moment.</p><p><strong>Dont wait. 80% of people who confirm do so in the first 5 minutes.</strong></p><p>[counter]</p><p>If you dont do this right now, you wont be notified when we publish an update.</p><p><em>Note: If you dont receive the e-mail in 5 minutes, please check your spam folder. To avoid filtering our emails, please add us to your address book.</p>', 'viral_coming_soon'),
                'desc'     => __('You can include two shortcodes.<br />Insert a 5 minute counter: <input type="text" value="[counter]" readonly="readonly" onClick="this.select();"><br />Insert a direct Link for Gmail Users: <input type="text" value="[gmail]" readonly="readonly" onClick="this.select();">','viral_coming_soon'),
            ),
            array(
                'id'       => 'gmail-link',
                'type'     => 'switch',
                'title'    => __('Show Gmail Link', 'viral_coming_soon'),
                'desc' => __('Do you want to show a link that gives Gmail Users an opportunity to go directly to your confirmation email?<br /><em>(Make sure to set correctly your from email below)</em>', 'viral_coming_soon'),
                'on'       => __('Show','viral_coming_soon'),
                'off'      => __('Hide','viral_coming_soon'),
                'default'  => 0,
            ),
            array(
                'id'       => 'gmail-from',
                'type'     => 'text',
                'title'    => __('Your From Email', 'viral_coming_soon'),
                'desc'     => __('Which Email do you use to send the confirmation emails from?', 'viral_coming_soon'),
                'required' => array( 'gmail-link', '=', 1 ),
            ),
        ),
    ) );

    /**
    THANK YOU PAGE SETTINGS
    **/
    Redux::setSection( $opt_name, array(
        'title'     => __('Thank You Page', 'viral_coming_soon'),
        'desc'      => __("Configure the settings of your Thank you page.", 'viral_coming_soon'),
        'icon'      => 'el el-gift',
        'fields'    => array(
            array(
                'id'       => 'thank-you-info',
                'type'     => 'info',
                'style'    => 'warning',
                'title'    => 'Please note:',
                'desc'     => __("You have to update the settings of your Email Service Provider to actually use this page. Just set this URL inside the Admin Panel or Dashboard of your Email Service Provider as your &quot;Thank You&quot; Page: $blog_url/?thankyou=1", 'viral_coming_soon'),
            ),
            array(
                'id'       => 'thank-you-headline',
                'type'     => 'text',
                'title'    => __('Page Headline', 'viral_coming_soon'),
                'default'  => __('Thank you! You are now on the list.', 'viral_coming_soon'),
            ),
            array(
                'id'       => 'thank-you-text',
                'type'     => 'editor',
                'title'    => __('Page Text', 'viral_coming_soon'),
                'subtitle' => __('Thank the user for subscribing.<br /><br />Be sure to include the [download] shortcode as well, so users that opted in for the leadbribe can actually download it.', 'viral_coming_soon'),
                'default'  => __("<p>You will be notified as soon as we launch. In the meantime you will be updated about high quality ressources we post elsewhere on the web.</p><p>We would love to put a face to every name on our Early Birds List.
                <strong>So just press the like button below.</strong></p><p>[like]</p><p><strong>To give you a special thank you and as promised, you can download a huge, high quality Icon Set right now, using the download button below.</strong></p><p>[download]</p><h3>Share this with your friends</h3><p>Now that you got your Icon Set, why not tell your friends about this great opportunity? Who couldn't use a great resource, helping them to save time, money and effort with their projects?</p><p>[share]</p>", 'viral_coming_soon'),
                'desc'     => __('You can include three shortcodes.<br />Insert a like button or box: <input onClick="this.select();" type="text" value="[like]" readonly="readonly"><br />Insert a download link for your leadbribe: <input onClick="this.select();" type="text" value="[download]" readonly="readonly"><br />Insert share buttons for facebook and twitter: <input type="text" onClick="this.select();" value="[share]" readonly="readonly">','viral_coming_soon'),
            ),
            array(
                'id'        => 'facebook-type',
                'type'      => 'switch',
                'title'     => __('Choose Facebook Like Style', 'viral_coming_soon'),
                'desc'      => __('Do you want to show a Facebook Like Button or the Facebook Page Plugin <em>(Page Box with Like Button)</em>', 'viral_coming_soon'),
                'on'       => __('Like Button','viral_coming_soon'),
                'off'      => __('Like Box','viral_coming_soon'),
                'default'  => 0,

            ),
            array(
                'id'        => 'facebook-url',
                'type'      => 'text',
                'title'     => __('Your Facebook Page', 'viral_coming_soon'),
                'desc'      => __('Copy & Paste here the URL to your facebook page', 'viral_coming_soon'),
            ),
            array(
                'id'        => 'twitter-username',
                'type'      => 'text',
                'title'     => __('Your Twitter Username', 'viral_coming_soon'),
                'desc'      => __('This will be used to notify you about tweets', 'viral_coming_soon'),
            ),   
            array(
                'id'       => 'click-to-tweet',
                'type'     => 'textarea',
                'title'    => __('Click to Tweet', 'viral_coming_soon'),
                'desc' => __('The text of the tweet to share your landingpage and the leadbribe', 'viral_coming_soon'),
                'default'  => __('Hold on! One more thing to do.', 'viral_coming_soon'),
            ),
        ),

    ) );

    Redux::setSection( $opt_name, array(
        'type' => 'divide',
    ) );

    add_action('redux/loaded', 'viral_coming_soon_remove_demo');

    /**
    Remove Redux Demo
    **/
    if ( ! function_exists( 'viral_coming_soon_remove_demo' ) ) {
        function viral_coming_soon_remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

    require plugin_dir_path( __FILE__ ) . 'api-compiler.php';

