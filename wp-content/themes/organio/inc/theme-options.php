<?php
add_action('after_setup_theme', 'casethemes_setup_option', 1);
function casethemes_setup_option(){
    if (!class_exists('ReduxFramework')) {
        return;
    }
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
    }

    $opt_name = organio_get_opt_name();
    $theme = wp_get_theme();

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get('Name'),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get('Version'),
        // Version that appears at the top of your panel
        'menu_type'            => class_exists('Case_Theme_Core') ? 'submenu' : '',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__('Theme Options', 'organio'),
        'page_title'           => esc_html__('Theme Options', 'organio'),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-admin-generic',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => true,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
        'show_options_object' => false,
        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => class_exists('Case_Theme_Core') ? $theme->get('TextDomain') : '',
        // For a full list of options, visit: //codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'theme-options',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        ),
        'templates_path'       => get_template_directory() . '/inc/templates/redux/'
    );

    Redux::SetArgs($opt_name, $args);

    /*--------------------------------------------------------------
    # General
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('General', 'organio'),
        'icon'   => 'el-icon-home',
        'fields' => array(
            array(
                'id'       => 'favicon',
                'type'     => 'media',
                'title'    => esc_html__('Favicon', 'organio'),
                'default' => '',
                'url' => false
            ),
            array(
                'id'       => 'dev_mode',
                'type'     => 'switch',
                'title'    => esc_html__('Dev Mode (not recommended)', 'organio'),
                'description' => 'Scss generate css',
                'default'  => false
            ),
            array(
                'id'       => 'mouse_move_animation',
                'type'     => 'switch',
                'title'    => esc_html__('Mouse Move Animation', 'organio'),
                'default'  => false
            ),
            array(
                'title' => esc_html__('Page Loading', 'organio'),
                'type'  => 'section',
                'id' => 'page_lading',
                'indent' => true
            ),
            array(
                'id'       => 'show_page_loading',
                'type'     => 'switch',
                'title'    => esc_html__('Enable Page Loading', 'organio'),
                'subtitle' => esc_html__('Enable page loading effect when you load site.', 'organio'),
                'default'  => false
            ),
            array(
                'id'       => 'loading_type',
                'type'     => 'select',
                'title'    => esc_html__('Loading Style', 'organio'),
                'options'  => array(
                    'style-image'  => esc_html__('Image', 'organio'),
                    'style1'  => esc_html__('Style 1', 'organio'),
                    'style2'  => esc_html__('Style 2', 'organio'),
                    'style3'  => esc_html__('Style 3', 'organio'),
                    'style4'  => esc_html__('Style 4', 'organio'),
                    'style5'  => esc_html__('Style 5', 'organio'),
                    'style6'  => esc_html__('Style 6', 'organio'),
                    'style7'  => esc_html__('Style 7', 'organio'),
                    'style8'  => esc_html__('Style 8', 'organio'),
                    'style9'  => esc_html__('Style 9', 'organio'),
                    'style10'  => esc_html__('Style 10', 'organio'),
                    'style11'  => esc_html__('Style 11', 'organio'),
                    'style12'  => esc_html__('Style 12', 'organio'),
                    'style13'  => esc_html__('Style 13', 'organio'),
                ),
                'default'  => 'style1',
                'required' => array( 0 => 'show_page_loading', 1 => 'equals', 2 => '1' ),
                'force_output' => true
            ),
            array(
                'id'       => 'logo_loader',
                'type'     => 'media',
                'title'    => esc_html__('Logo Loader', 'organio'),
                'default' => '',
                'required' => array( 0 => 'loading_type', 1 => 'equals', 2 => 'style-image' ),
                'force_output' => true,
                'url' => false
            ),
        )
    ));

    /*--------------------------------------------------------------
    # Header
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Header', 'organio'),
        'icon'   => 'el el-indent-left',
        'fields' => array(
            array(
                'id'       => 'header_layout',
                'type'     => 'image_select',
                'title'    => esc_html__('Layout', 'organio'),
                'subtitle' => esc_html__('Select a layout for header.', 'organio'),
                'options'  => array(
                    '1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
                    '2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
                    '3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
                    '4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
                    '5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
                    '6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
                    '7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
                    '8' => get_template_directory_uri() . '/assets/images/header-layout/h8.jpg',
                    '9' => get_template_directory_uri() . '/assets/images/header-layout/h9.jpg',
                    '10' => get_template_directory_uri() . '/assets/images/header-layout/h10.jpg',
                    '11' => get_template_directory_uri() . '/assets/images/header-layout/h11.jpg',
                ),
                'default'  => 'df'
            ),
            array(
                'id'          => 'header_bg_color',
                'type'        => 'color',
                'title'       => esc_html__('Header Main Background Color', 'organio'),
                'transparent' => false,
                'default'     => ''
            ),
            array(
                'id'       => 'sticky_on',
                'type'     => 'switch',
                'title'    => esc_html__('Sticky Header', 'organio'),
                'subtitle' => esc_html__('Header will be sticked when applicable.', 'organio'),
                'default'  => false
            ),

            array(
                'id'       => 'sticky_header_type',
                'type'     => 'button_set',
                'title'    => esc_html__('Sticky Header Type', 'organio'),
                'options'  => array(
                    'scroll-to-bottom'  => esc_html__('Scroll To Bottom', 'organio'),
                    'scroll-to-top'  => esc_html__('Scroll To Top', 'organio'),
                ),
                'default'  => 'scroll-to-bottom',
                'required' => array( 0 => 'sticky_on', 1 => 'equals', 2 => '1' ),
                'force_output' => true
            ),

            array(
                'id'       => 'search_icon',
                'type'     => 'switch',
                'title'    => esc_html__('Search Icon Header', 'organio'),
                'default'  => false,
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id'       => 'search_form_product',
                'type'     => 'switch',
                'title'    => esc_html__('Search Form Product', 'organio'),
                'default'  => true,
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),

            array(
                'id'       => 'cart_icon',
                'type'     => 'switch',
                'title'    => esc_html__('Cart Icon Header', 'organio'),
                'default'  => false,
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id'       => 'wishlist_icon',
                'type'     => 'switch',
                'title'    => esc_html__('Wishlist Icon Header', 'organio'),
                'default'  => false,
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id'       => 'compare_icon',
                'type'     => 'switch',
                'title'    => esc_html__('Compare Icon Header', 'organio'),
                'default'  => false,
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id'       => 'language_switch',
                'type'     => 'switch',
                'title'    => esc_html__('Language Switch', 'organio'),
                'default'  => false,
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id' => 'login_text',
                'type' => 'text',
                'title' => esc_html__('Login', 'organio'),
                'default' => 'Login',
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id'    => 'login_link',
                'type'  => 'select',
                'title' => esc_html__( 'Login Link', 'organio' ), 
                'data'  => 'page',
                'args'  => array(
                    'post_type'      => 'page',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ),
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id' => 'register_text',
                'type' => 'text',
                'title' => esc_html__('Register', 'organio'),
                'default' => 'Register',
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id'    => 'register_link',
                'type'  => 'select',
                'title' => esc_html__( 'Register Link', 'organio' ), 
                'data'  => 'page',
                'args'  => array(
                    'post_type'      => 'page',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ),
                'subtitle' => esc_html__('Will display in some header layouts.', 'organio'),
            ),
            array(
                'id'       => 'user_icon',
                'type'     => 'switch',
                'title'    => esc_html__('User Icon Header', 'organio'),
                'default'  => false,
                'subtitle' => esc_html__('Apply header layout 7.', 'organio'),
            ),
            array(
                'id'       => 'menu_category_display',
                'type'     => 'button_set',
                'title'    => esc_html__('Menu Product Categories Display', 'organio'),
                'options'  => array(
                    'always'  => esc_html__('Always', 'organio'),
                    'hover'  => esc_html__('Hover', 'organio'),
                ),
                'default'  => 'always',
                'subtitle' => esc_html__('Apply header layout 3.', 'organio'),
            ),
        )
    ));

    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Top Bar', 'organio'),
        'icon'       => 'el el-credit-card',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'h_topbar',
                'type'     => 'button_set',
                'title'    => esc_html__('Topbar', 'organio'),
                'options'  => array(
                    'show'  => esc_html__('Show', 'organio'),
                    'hide'  => esc_html__('Hide', 'organio')
                ),
                'default'  => 'show',
            ),
            array(
                'id'          => 'topbar_bg_color',
                'type'        => 'color',
                'title'       => esc_html__('Topbar Background Color', 'organio'),
                'transparent' => false,
                'default'     => ''
            ),
            array(
                'id' => 'short_text',
                'type' => 'text',
                'title' => esc_html__('Short Text', 'organio'),
                'default' => '',
                'desc'           => esc_html__('Apply header layout 3.', 'organio'),
            ),
            array(
                'id' => 'wellcome',
                'type' => 'text',
                'title' => esc_html__('Wellcome', 'organio'),
                'default' => '',
            ),
            array(
                'id' => 'h_phone_label',
                'type' => 'text',
                'title' => esc_html__('Phone Number Label', 'organio'),
                'default' => '',
                'desc' => esc_html__('Applicable to a few header layouts.', 'organio'),
            ),
            array(
                'id' => 'h_phone',
                'type' => 'text',
                'title' => esc_html__('Phone Number', 'organio'),
                'default' => '',
                'desc' => esc_html__('Applicable to a few header layouts.', 'organio'),
            ),
            array(
                'id' => 'h_phone_link',
                'type' => 'text',
                'title' => esc_html__('Phone Link', 'organio'),
                'default' => '',
                'desc' => esc_html__('Applicable to a few header layouts.', 'organio'),
            ),
            array(
                'id' => 'h_address_label',
                'type' => 'text',
                'title' => esc_html__('Address Label', 'organio'),
                'default' => '',
                'desc' => esc_html__('Applicable to a few header layouts.', 'organio'),
            ),
            array(
                'id' => 'h_address',
                'type' => 'text',
                'title' => esc_html__('Address', 'organio'),
                'default' => '',
                'desc' => esc_html__('Applicable to a few header layouts.', 'organio'),
            ),
            array(
                'id' => 'h_address_link',
                'type' => 'text',
                'title' => esc_html__('Address Link', 'organio'),
                'default' => '',
                'desc' => esc_html__('Applicable to a few header layouts.', 'organio'),
            ),
            array(
                'id' => 'h_btn_text',
                'type' => 'text',
                'title' => esc_html__('Button Text', 'organio'),
                'default' => '',
            ),
            array(
                'id'       => 'h_btn_link_type',
                'type'     => 'button_set',
                'title'    => esc_html__('Button Link Type', 'organio'),
                'options'  => array(
                    'page-link'  => esc_html__('Page Link', 'organio'),
                    'external-link'  => esc_html__('External Link', 'organio')
                ),
                'default'  => 'page-link',
            ),
            array(
                'id'    => 'h_btn_link',
                'type'  => 'select',
                'title' => esc_html__( 'Button Page Link', 'organio' ), 
                'data'  => 'page',
                'args'  => array(
                    'post_type'      => 'page',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ),
                'required' => array( 0 => 'h_btn_link_type', 1 => 'equals', 2 => 'page-link' ),
                'force_output' => true
            ),
            array(
                'id'      => 'h_btn_external_link',
                'type'    => 'text',
                'title'   => esc_html__('Button External Link', 'organio'),
                'default' => '#',
                'required' => array( 0 => 'h_btn_link_type', 1 => 'equals', 2 => 'external-link' ),
                'force_output' => true
            ),

            array(
                'title' => esc_html__('Social', 'organio'),
                'type'  => 'section',
                'id' => 'header_social',
                'indent' => true,
            ),

            array(
                'id'      => 'h_social_facebook_url',
                'type'    => 'text',
                'title'   => esc_html__('Facebook URL', 'organio'),
                'default' => '#',
            ),
            array(
                'id'      => 'h_social_twitter_url',
                'type'    => 'text',
                'title'   => esc_html__('Twitter URL', 'organio'),
                'default' => '#',
            ),
            array(
                'id'      => 'h_social_dribbble_url',
                'type'    => 'text',
                'title'   => esc_html__('Dribbble URL', 'organio'),
                'default' => '#',
            ),
            array(
                'id'      => 'h_social_behance_url',
                'type'    => 'text',
                'title'   => esc_html__('Behance URL', 'organio'),
                'default' => '#',
            ),
            array(
                'id'      => 'h_social_inkedin_url',
                'type'    => 'text',
                'title'   => esc_html__('Linkedin URL', 'organio'),
                'default' => '',
            ),
            array(
                'id'      => 'h_social_instagram_url',
                'type'    => 'text',
                'title'   => esc_html__('Instagram URL', 'organio'),
                'default' => '',
            ),
            array(
                'id'      => 'h_social_skype_url',
                'type'    => 'text',
                'title'   => esc_html__('Skype URL', 'organio'),
                'default' => '',
            ),
            array(
                'id'      => 'h_social_pinterest_url',
                'type'    => 'text',
                'title'   => esc_html__('Pinterest URL', 'organio'),
                'default' => '',
            ),
            array(
                'id'      => 'h_social_vimeo_url',
                'type'    => 'text',
                'title'   => esc_html__('Vimeo URL', 'organio'),
                'default' => '',
            ),
            array(
                'id'      => 'h_social_youtube_url',
                'type'    => 'text',
                'title'   => esc_html__('Youtube URL', 'organio'),
                'default' => '',
            ),
            array(
                'id'      => 'h_social_yelp_url',
                'type'    => 'text',
                'title'   => esc_html__('Yelp URL', 'organio'),
                'default' => '',
            ),
            array(
                'id'      => 'h_social_tumblr_url',
                'type'    => 'text',
                'title'   => esc_html__('Tumblr URL', 'organio'),
                'default' => '',
            ),
            array(
                'id'      => 'h_social_tripadvisor_url',
                'type'    => 'text',
                'title'   => esc_html__('Tripadvisor URL', 'organio'),
                'default' => '',
            ),
        )
    ));

    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Logo', 'organio'),
        'icon'       => 'el el-picture',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'logo',
                'type'     => 'media',
                'title'    => esc_html__('Logo Dark', 'organio'),
                 'default' => array(
                    'url'=>get_template_directory_uri().'/assets/images/logo-dark.png'
                ),
                'url' => false
            ),
            array(
                'id'       => 'logo_light',
                'type'     => 'media',
                'title'    => esc_html__('Logo Light', 'organio'),
                'default' => array(
                    'url'=>get_template_directory_uri().'/assets/images/logo-light.png'
                ),
                'url' => false
            ),
            array(
                'id'       => 'logo_mobile',
                'type'     => 'media',
                'title'    => esc_html__('Logo Tablet & Mobile', 'organio'),
                 'default' => array(
                    'url'=>get_template_directory_uri().'/assets/images/logo-mobile.png'
                ),
                'url' => false
            ),
            array(
                'id'       => 'logo_maxh',
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Max Height', 'organio'),
                'subtitle' => esc_html__('Enter number.', 'organio'),
                'width'    => false,
                'unit'     => 'px'
            ),
            array(
                'id'       => 'logo_maxh_sticky',
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Max Height Sticky', 'organio'),
                'subtitle' => esc_html__('Enter number.', 'organio'),
                'width'    => false,
                'unit'     => 'px'
            ),
            array(
                'id'       => 'logo_maxh_sm',
                'type'     => 'dimensions',
                'title'    => esc_html__('Logo Max Height for Tablet & Mobile', 'organio'),
                'subtitle' => esc_html__('Enter number.', 'organio'),
                'width'    => false,
                'unit'     => 'px'
            ),
        )
    ));

    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Navigation', 'organio'),
        'icon'       => 'el el-lines',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'          => 'font_menu',
                'type'        => 'typography',
                'title'       => esc_html__('Custom Google Font', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'font-style'  => false,
                'font-weight'  => true,
                'text-align'  => false,
                'font-size'  => false,
                'line-height'  => false,
                'color'  => false,
                'output'      => array('.ct-main-menu > li > a, body .ct-main-menu .sub-menu li a'),
                'units'       => 'px',
            ),
            array(
                'title' => esc_html__('Main Menu', 'organio'),
                'type'  => 'section',
                'id' => 'main_menu',
                'indent' => true
            ),
            array(
                'id'       => 'icon_has_children',
                'type'     => 'button_set',
                'title'    => esc_html__('Icon Has Children', 'organio'),
                'options'  => array(
                    'plus'  => esc_html__('Plus', 'organio'),
                    'arrow'  => esc_html__('Arrow', 'organio')
                ),
                'default'  => 'arrow',
            ),
            array(
                'id'      => 'main_menu_color',
                'type'    => 'link_color',
                'title'   => esc_html__('Item Color', 'organio'),
                'default' => array(
                    'regular' => '',
                    'hover'   => '',
                    'active'   => '',
                ),
            ),
            array(
                'id'          => 'menu_icon_color',
                'type'        => 'color',
                'title'       => esc_html__('Icon Color', 'organio'),
                'transparent' => false,
            ),
            array(
                'title' => esc_html__('Sticky Menu', 'organio'),
                'type'  => 'section',
                'id' => 'sticky_menu',
                'indent' => true
            ),
            array(
                'id'      => 'sticky_menu_color',
                'type'    => 'link_color',
                'title'   => esc_html__('Item Color', 'organio'),
                'default' => array(
                    'regular' => '',
                    'hover'   => '',
                    'active'   => '',
                ),
            ),
            array(
                'title' => esc_html__('Sub Menu', 'organio'),
                'type'  => 'section',
                'id' => 'sub_menu',
                'indent' => true
            ),
            array(
                'id'      => 'sub_menu_color',
                'type'    => 'link_color',
                'title'   => esc_html__('Item Color', 'organio'),
                'default' => array(
                    'regular' => '',
                    'hover'   => '',
                    'active'   => '',
                ),
            ),
        )
    ));

    /*--------------------------------------------------------------
    # Page Title area
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Page Title', 'organio'),
        'icon'   => 'el-icon-map-marker',
        'fields' => array(

            array(
                'id'           => 'pagetitle',
                'type'         => 'button_set',
                'title'        => esc_html__( 'Page Title', 'organio' ),
                'options'      => array(
                    'show'  => esc_html__( 'Show', 'organio' ),
                    'hide'  => esc_html__( 'Hide', 'organio' ),
                ),
                'default'      => 'show',
            ),

            array(
                'id'          => 'pagetitle_color',
                'type'        => 'color',
                'title'       => esc_html__('Page Title Color', 'organio'),
                'transparent' => false,
                'default'     => '',
                'output'         => array('#pagetitle .page-title'),
                'required' => array( 0 => 'pagetitle', 1 => 'equals', 2 => 'show' ),
                'force_output' => true
            ),

            array(
                'id'       => 'ptitle_bg',
                'type'     => 'background',
                'title'    => esc_html__('Background', 'organio'),
                'subtitle' => esc_html__('Page title background.', 'organio'),
                'output'   => array('body #pagetitle'),
                'required' => array( 0 => 'pagetitle', 1 => 'equals', 2 => 'show' ),
                'force_output' => true,
                'background-image' => true,
                'background-color' => false,
                'background-position' => false,
                'background-repeat' => false,
                'background-size' => false,
                'background-attachment' => false,
                'transparent' => false,
            ),
            array(
                'id'       => 'ptitle_bg_overlay',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Background Color Overlay', 'organio' ),
                'subtitle' => esc_html__( 'Page title background color overlay.', 'organio' ),
                'output'   => array( 'background-color' => '#pagetitle:before' ),
                'required' => array( 0 => 'pagetitle', 1 => 'equals', 2 => 'show' ),
                'force_output' => true,
            ),
            array(
                'id'             => 'page_title_padding',
                'type'           => 'spacing',
                'output'         => array('body #pagetitle'),
                'right'   => false,
                'left'    => false,
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Page Title Space Top/Bottom', 'organio'),
                'default'            => array(
                    'padding-top'   => '',
                    'padding-bottom'   => '',
                    'units'          => 'px',
                ),
                'required' => array( 0 => 'pagetitle', 1 => 'equals', 2 => 'show' ),
                'force_output' => true
            ),
            array(
                'id'       => 'ptitle_breadcrumb_on',
                'type'     => 'button_set',
                'title'    => esc_html__('Breadcrumb', 'organio'),
                'options'  => array(
                    'show'  => esc_html__('Show', 'organio'),
                    'hidden'  => esc_html__('Hidden', 'organio'),
                ),
                'default'  => 'show',
                'required' => array( 0 => 'pagetitle', 1 => 'equals', 2 => 'show' ),
                'force_output' => true
            ),
            array(
                'id'          => 'breadcrumb_color',
                'type'        => 'color',
                'title'       => esc_html__('Breadcrumb Color', 'organio'),
                'transparent' => false,
                'default'     => '',
                'output'         => array('.ct-breadcrumb, .ct-breadcrumb li a:after'),
                'required' => array( 0 => 'pagetitle', 1 => 'equals', 2 => 'show' ),
                'force_output' => true
            ),
        )
    ));

    /*--------------------------------------------------------------
    # WordPress default content
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title' => esc_html__('Content', 'organio'),
        'icon'  => 'el-icon-pencil',
        'fields'     => array(
            array(
                'id'       => 'content_bg',
                'type'     => 'background',
                'title'    => esc_html__('Background', 'organio'),
                'subtitle' => esc_html__('Content background.', 'organio'),
                'output'   => array( 'background-color' => '.site-content' ),
                'force_output' => true,
                'background-image' => true,
                'background-color' => true,
                'background-position' => true,
                'background-repeat' => true,
                'background-size' => true,
                'background-attachment' => true,
                'transparent' => false,
                'default'  => ''
            ),
            array(
                'id'             => 'content_padding',
                'type'           => 'spacing',
                'output'         => array('#content'),
                'right'   => false,
                'left'    => false,
                'mode'           => 'padding',
                'units'          => array('px'),
                'units_extended' => 'false',
                'title'          => esc_html__('Content Padding', 'organio'),
                'desc'           => esc_html__('Default: Top-95px, Bottom-70px', 'organio'),
                'default'            => array(
                    'padding-top'   => '',
                    'padding-bottom'   => '',
                    'units'          => 'px',
                )
            ),
            array(
                'id'      => 'search_field_placeholder',
                'type'    => 'text',
                'title'   => esc_html__('Search Form - Text Placeholder', 'organio'),
                'default' => '',
                'desc'           => esc_html__('Default: Search', 'organio'),
            ),
        )
    ));


    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Blog Default', 'organio'),
        'icon'       => 'el-icon-list',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'archive_sidebar_pos',
                'type'     => 'button_set',
                'title'    => esc_html__('Sidebar Position', 'organio'),
                'subtitle' => esc_html__('Select a sidebar position for blog home, archive, search...', 'organio'),
                'options'  => array(
                    'left'  => esc_html__('Left', 'organio'),
                    'right' => esc_html__('Right', 'organio'),
                    'none'  => esc_html__('Disabled', 'organio')
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'archive_date_on',
                'title'    => esc_html__('Date', 'organio'),
                'subtitle' => esc_html__('Show date posted on each post.', 'organio'),
                'type'     => 'switch',
                'default'  => true,
            ),
            array(
                'id'       => 'archive_categories_on',
                'title'    => esc_html__('Categories', 'organio'),
                'subtitle' => esc_html__('Show category names on each post.', 'organio'),
                'type'     => 'switch',
                'default'  => true,
            ),
            array(
                'id'       => 'archive_author_on',
                'title'    => esc_html__('Author', 'organio'),
                'subtitle' => esc_html__('Show author names on each post.', 'organio'),
                'type'     => 'switch',
                'default'  => true,
            ),
            array(
                'id'      => 'archive_readmore_text',
                'type'    => 'text',
                'title'   => esc_html__('Read More Text', 'organio'),
                'default' => '',
            ),
        )
    ));

    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Single Post', 'organio'),
        'icon'       => 'el-icon-file-edit',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'post_sidebar_pos',
                'type'     => 'button_set',
                'title'    => esc_html__('Sidebar Position', 'organio'),
                'subtitle' => esc_html__('Select a sidebar position', 'organio'),
                'options'  => array(
                    'left'  => esc_html__('Left', 'organio'),
                    'right' => esc_html__('Right', 'organio'),
                    'none'  => esc_html__('Disabled', 'organio')
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'post_date_on',
                'title'    => esc_html__('Date', 'organio'),
                'subtitle' => esc_html__('Show date on single post.', 'organio'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_author_on',
                'title'    => esc_html__('Author', 'organio'),
                'subtitle' => esc_html__('Show author name on single post.', 'organio'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_categories_on',
                'title'    => esc_html__('Categories', 'organio'),
                'subtitle' => esc_html__('Show category names on single post.', 'organio'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_tags_on',
                'title'    => esc_html__('Tags', 'organio'),
                'subtitle' => esc_html__('Show tag names on single post.', 'organio'),
                'type'     => 'switch',
                'default'  => true
            ),
            array(
                'id'       => 'post_navigation_on',
                'title'    => esc_html__('Navigation', 'organio'),
                'subtitle' => esc_html__('Show navigation on single post.', 'organio'),
                'type'     => 'switch',
                'default'  => false,
            ),
            array(
                'id'       => 'post_social_share_on',
                'title'    => esc_html__('Social Share', 'organio'),
                'subtitle' => esc_html__('Show social share on single post.', 'organio'),
                'type'     => 'switch',
                'default'  => false,
            ),
        )
    ));

    /*--------------------------------------------------------------
    # Shop
    --------------------------------------------------------------*/
    if(class_exists('Woocommerce')) {
        Redux::setSection($opt_name, array(
            'title'  => esc_html__('Shop', 'organio'),
            'icon'   => 'el el-shopping-cart',
            'fields' => array(
                array(
                    'id'       => 'cart_sidebar',
                    'type'     => 'switch',
                    'title'    => esc_html__('Cart Sidebar', 'organio'),
                    'subtitle' => esc_html__('Displayed when the product is added to the cart.', 'organio'),
                    'default'  => true
                ),
                array(
                    'title' => esc_html__('Products', 'organio'),
                    'type'  => 'section',
                    'id' => 'shop_products',
                    'indent' => true,
                ),
                array(
                    'id'       => 'shop_layout',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Layout', 'organio'),
                    'options'  => array(
                        'grid'  => esc_html__('Grid', 'organio'),
                        'list'  => esc_html__('List', 'organio'),
                    ),
                    'default'  => 'grid'
                ),
                array(
                    'id'       => 'shop_grid_style',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Grid Style', 'organio'),
                    'options'  => array(
                        'style-1'  => esc_html__('Style 1', 'organio'),
                        'style-2'  => esc_html__('Style 2', 'organio'),
                    ),
                    'default'  => 'style-1',
                    'required' => array( 0 => 'shop_layout', 1 => 'equals', 2 => 'grid' ),
                    'force_output' => true
                ),
                array(
                    'id'       => 'sidebar_shop',
                    'type'     => 'button_set',
                    'title'    => esc_html__('Sidebar Position', 'organio'),
                    'subtitle' => esc_html__('Select a sidebar position for archive shop.', 'organio'),
                    'options'  => array(
                        'left'  => esc_html__('Left', 'organio'),
                        'right' => esc_html__('Right', 'organio'),
                        'none'  => esc_html__('Disabled', 'organio')
                    ),
                    'default'  => 'right'
                ),
                array(
                    'title' => esc_html__('Products displayed per page', 'organio'),
                    'id' => 'product_per_page',
                    'type' => 'slider',
                    'subtitle' => esc_html__('Number product to show', 'organio'),
                    'default' => 12,
                    'min'  => 4,
                    'step' => 1,
                    'max' => 50,
                    'display_value' => 'text'
                ),

                array(
                    'id'       => 'quantity_products',
                    'type'     => 'switch',
                    'title'    => esc_html__('Quantity Products', 'organio'),
                    'default'  => false
                ),

                array(
                    'id'       => 'product_description',
                    'type'     => 'switch',
                    'title'    => esc_html__('Product Description', 'organio'),
                    'default'  => false,
                    'required' => array( 0 => 'shop_layout', 1 => 'equals', 2 => 'grid' ),
                    'force_output' => true
                ),

                array(
                    'title' => esc_html__('Single Product', 'organio'),
                    'type'  => 'section',
                    'id' => 'shop_single',
                    'indent' => true,
                ),
                array(
                    'id'       => 'product_title',
                    'type'     => 'switch',
                    'title'    => esc_html__('Product Title', 'organio'),
                    'default'  => false
                ),
                array(
                    'id'       => 'product_social_share',
                    'type'     => 'switch',
                    'title'    => esc_html__('Social Share', 'organio'),
                    'default'  => false
                ),
            )
        ));
    }

    /*--------------------------------------------------------------
    # Footer
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Footer', 'organio'),
        'icon'   => 'el el-website',
        'fields' => array(
            array(
                'id'          => 'footer_layout_custom',
                'type'        => 'select',
                'title'       => esc_html__('Layout', 'organio'),
                'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.','organio'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=footer' ) ) . '">','</a>'),
                'options'     =>organio_list_post('footer'),
                'default'     => '',
            ),
            array(
                'id'       => 'back_totop_on',
                'type'     => 'switch',
                'title'    => esc_html__('Back to Top Button', 'organio'),
                'subtitle' => esc_html__('Show back to top button when scrolled down.', 'organio'),
                'default'  => false,
            ),
            array(
                'id'       => 'fixed_footer',
                'type'     => 'switch',
                'title'    => esc_html__('Fixed Footer', 'organio'),
                'default'  => false,
            ),
        )
    ));

    /* 404 Page /--------------------------------------------------------- */
    Redux::setSection($opt_name, array(
        'title'  => esc_html__('404 Page', 'organio'),
        'icon'   => 'el-cog-alt el',
        'fields' => array(
            array(
                'id'       => 'page_404',
                'type'     => 'button_set',
                'title'    => esc_html__('Select 404 Page', 'organio'),
                'options'  => array(
                    'default'  => esc_html__('Default', 'organio'),
                    'custom'  => esc_html__('Custom', 'organio'),
                ),
                'default'  => 'default'
            ),
            array(
                'id'          => 'page_custom_404',
                'type'        => 'select',
                'title'       => esc_html__('Page', 'organio'),
                'options'     => organio_list_post('page'),
                'default'     => '',
                'required' => array( 0 => 'page_404', 1 => 'equals', 2 => 'custom' ),
                'force_output' => true
            ),
        ),
    ));

    /*--------------------------------------------------------------
    # Colors
    --------------------------------------------------------------*/

    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Colors', 'organio'),
        'icon'   => 'el-icon-file-edit',
        'fields' => array(
            array(
                'id'          => 'primary_color',
                'type'        => 'color',
                'title'       => esc_html__('Primary Color', 'organio'),
                'transparent' => false,
                'default'     => '#76a713'
            ),
            array(
                'id'          => 'secondary_color',
                'type'        => 'color',
                'title'       => esc_html__('Secondary Color', 'organio'),
                'transparent' => false,
                'default'     => '#191919'
            ),
            array(
                'id'          => 'third_color',
                'type'        => 'color',
                'title'       => esc_html__('Third Color', 'organio'),
                'transparent' => false,
                'default'     => '#ff4b16'
            ),
            array(
                'id'      => 'link_color',
                'type'    => 'link_color',
                'title'   => esc_html__('Link Colors', 'organio'),
                'default' => array(
                    'regular' => '#76a713',
                    'hover'   => '#880c0c',
                    'active'  => '#880c0c'
                ),
                'output'  => array('a')
            ),
            array(
                'id'          => 'dark_color',
                'type'        => 'color',
                'title'       => esc_html__('Dark Color', 'organio'),
                'transparent' => false,
                'default'     => '#191919'
            ),
            array(
                'id'          => 'gradient_color',
                'type'        => 'color_gradient',
                'title'       => esc_html__('Gradient Color', 'organio'),
                'transparent' => false,
                'default'  => array(
                    'from' => '#fb5850',
                    'to'   => '#ffa200', 
                ),
            ),
        )
    ));

    /*--------------------------------------------------------------
    # Typography
    --------------------------------------------------------------*/
    $custom_font_selectors_1 = Redux::get_option($opt_name, 'custom_font_selectors_1');
    $custom_font_selectors_1 = !empty($custom_font_selectors_1) ? explode(',', $custom_font_selectors_1) : array();
    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Typography', 'organio'),
        'icon'   => 'el-icon-text-width',
        'fields' => array(
            array(
                'id'       => 'body_default_font',
                'type'     => 'select',
                'title'    => esc_html__('Body Default Font', 'organio'),
                'options'  => array(
                    'Barlow'  => esc_html__('Default', 'organio'),
                    'Google-Font'  => esc_html__('Google Font', 'organio'),
                ),
                'default'  => 'Barlow',
            ),
            array(
                'id'          => 'font_main',
                'type'        => 'typography',
                'title'       => esc_html__('Body Google Font', 'organio'),
                'subtitle'    => esc_html__('This will be the default font of your website.', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'line-height'  => true,
                'font-size'  => true,
                'text-align'  => false,
                'output'      => array('body'),
                'units'       => 'px',
                'required' => array( 0 => 'body_default_font', 1 => 'equals', 2 => 'Google-Font' ),
                'force_output' => true
            ),
            array(
                'id'       => 'heading_default_font',
                'type'     => 'select',
                'title'    => esc_html__('Heading Default Font', 'organio'),
                'options'  => array(
                    'Lora'  => esc_html__('Default', 'organio'),
                    'Google-Font'  => esc_html__('Google Font', 'organio'),
                ),
                'default'  => 'Lora',
            ),
            array(
                'id'          => 'font_h1',
                'type'        => 'typography',
                'title'       => esc_html__('H1', 'organio'),
                'subtitle'    => esc_html__('This will be the default font for all H1 tags of your website.', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'output'      => array('h1', '.h1', '.text-heading'),
                'units'       => 'px',
                'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
                'force_output' => true
            ),
            array(
                'id'          => 'font_h2',
                'type'        => 'typography',
                'title'       => esc_html__('H2', 'organio'),
                'subtitle'    => esc_html__('This will be the default font for all H2 tags of your website.', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'output'      => array('h2', '.h2'),
                'units'       => 'px',
                'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
                'force_output' => true
            ),
            array(
                'id'          => 'font_h3',
                'type'        => 'typography',
                'title'       => esc_html__('H3', 'organio'),
                'subtitle'    => esc_html__('This will be the default font for all H3 tags of your website.', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'output'      => array('h3', '.h3'),
                'units'       => 'px',
                'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
                'force_output' => true
            ),
            array(
                'id'          => 'font_h4',
                'type'        => 'typography',
                'title'       => esc_html__('H4', 'organio'),
                'subtitle'    => esc_html__('This will be the default font for all H4 tags of your website.', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'output'      => array('h4', '.h4'),
                'units'       => 'px',
                'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
                'force_output' => true
            ),
            array(
                'id'          => 'font_h5',
                'type'        => 'typography',
                'title'       => esc_html__('H5', 'organio'),
                'subtitle'    => esc_html__('This will be the default font for all H5 tags of your website.', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'output'      => array('h5', '.h5'),
                'units'       => 'px',
                'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
                'force_output' => true
            ),
            array(
                'id'          => 'font_h6',
                'type'        => 'typography',
                'title'       => esc_html__('H6', 'organio'),
                'subtitle'    => esc_html__('This will be the default font for all H6 tags of your website.', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'output'      => array('h6', '.h6'),
                'units'       => 'px',
                'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
                'force_output' => true
            ),
        )
    ));

    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Fonts Selectors', 'organio'),
        'icon'       => 'el el-fontsize',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'          => 'custom_font_1',
                'type'        => 'typography',
                'title'       => esc_html__('Custom Font', 'organio'),
                'subtitle'    => esc_html__('This will be the font that applies to the class selector.', 'organio'),
                'google'      => true,
                'font-backup' => true,
                'all_styles'  => true,
                'text-align'  => false,
                'output'      => $custom_font_selectors_1,
                'units'       => 'px',

            ),
            array(
                'id'       => 'custom_font_selectors_1',
                'type'     => 'textarea',
                'title'    => esc_html__('CSS Selectors', 'organio'),
                'subtitle' => esc_html__('Add class selectors to apply above font.', 'organio'),
                'validate' => 'no_html'
            )
        )
    ));

    Redux::setSection($opt_name, array(
        'title'      => esc_html__('Extra Post Type', 'organio'),
        'icon'       => 'el el-briefcase',
        'fields'     => array(
            array(
                'title' => esc_html__('Portfolio', 'organio'),
                'type'  => 'section',
                'id' => 'post_portfolio',
                'indent' => true,
            ),
            array(
                'id'      => 'portfolio_slug',
                'type'    => 'text',
                'title'   => esc_html__('Portfolio Slug', 'organio'),
                'default' => '',
                'desc'     => 'Default: portfolio',
            ),
            array(
                'id'      => 'portfolio_name',
                'type'    => 'text',
                'title'   => esc_html__('Portfolio Name', 'organio'),
                'default' => '',
                'desc'     => 'Default: Portfolio',
            ),
            array(
                'id'      => 'portfolio_category_slug',
                'type'    => 'text',
                'title'   => esc_html__('Portfolio Category Slug', 'organio'),
                'default' => '',
                'desc'     => 'Default: portfolio-category',
            ),
            array(
                'id'      => 'portfolio_category_name',
                'type'    => 'text',
                'title'   => esc_html__('Portfolio Category Name', 'organio'),
                'default' => '',
                'desc'     => 'Default: Portfolio Categories',
            ),
            array(
                'id'    => 'archive_portfolio_link',
                'type'  => 'select',
                'title' => esc_html__( 'Custom Archive Page Link', 'organio' ), 
                'data'  => 'page',
                'args'  => array(
                    'post_type'      => 'page',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ),
            ),
            
            array(
                'title' => esc_html__('Service', 'organio'),
                'type'  => 'section',
                'id' => 'post_service',
                'indent' => true,
            ),
            array(
                'id'      => 'service_slug',
                'type'    => 'text',
                'title'   => esc_html__('Service Slug', 'organio'),
                'default' => '',
                'desc'     => 'Default: service',
            ),
            array(
                'id'      => 'service_name',
                'type'    => 'text',
                'title'   => esc_html__('Service Name', 'organio'),
                'default' => '',
                'desc'     => 'Default: Service',
            ),
            array(
                'id'      => 'service_category_slug',
                'type'    => 'text',
                'title'   => esc_html__('Service Category Slug', 'organio'),
                'default' => '',
                'desc'     => 'Default: service-category',
            ),
            array(
                'id'      => 'service_category_name',
                'type'    => 'text',
                'title'   => esc_html__('Service Category Name', 'organio'),
                'default' => '',
                'desc'     => 'Default: Service Categories',
            ),
            array(
                'id'    => 'archive_service_link',
                'type'  => 'select',
                'title' => esc_html__( 'Custom Archive Page Link', 'organio' ), 
                'data'  => 'page',
                'args'  => array(
                    'post_type'      => 'page',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ),
            ),
        )
    ));

    /* Custom Code /--------------------------------------------------------- */
    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Custom Code', 'organio'),
        'icon'   => 'el-icon-edit',
        'fields' => array(

            array(
                'id'       => 'site_header_code',
                'type'     => 'textarea',
                'theme'    => 'chrome',
                'title'    => esc_html__('Header Custom Codes', 'organio'),
                'subtitle' => esc_html__('It will insert the code to wp_head hook.', 'organio'),
            ),
            array(
                'id'       => 'site_footer_code',
                'type'     => 'textarea',
                'theme'    => 'chrome',
                'title'    => esc_html__('Footer Custom Codes', 'organio'),
                'subtitle' => esc_html__('It will insert the code to wp_footer hook.', 'organio'),
            ),

        ),
    ));

    /* Custom CSS /--------------------------------------------------------- */
    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Custom CSS', 'organio'),
        'icon'   => 'el-icon-adjust-alt',
        'fields' => array(

            array(
                'id'   => 'customcss',
                'type' => 'info',
                'desc' => esc_html__('Custom CSS', 'organio')
            ),

            array(
                'id'       => 'site_css',
                'type'     => 'ace_editor',
                'title'    => esc_html__('CSS Code', 'organio'),
                'subtitle' => esc_html__('Advanced CSS Options. You can paste your custom CSS Code here.', 'organio'),
                'mode'     => 'css',
                'validate' => 'css',
                'theme'    => 'chrome',
                'default'  => ""
            ),

        ),
    ));
}