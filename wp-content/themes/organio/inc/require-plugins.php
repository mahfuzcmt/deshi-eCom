<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
get_template_part( 'inc/libs/class-tgm-plugin-activation' );

add_action( 'tgmpa_register', 'organio_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
*/
function organio_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        /* Case Plugin */
        array(
            'name'               => esc_html__('* Redux Framework', 'organio'),
            'slug'               => 'redux-framework',
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Elementor', 'organio'),
            'slug'               => 'elementor',
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Case Theme Core', 'organio'),
            'slug'               => 'case-theme-core',
            'source'             => esc_url('http://demo.casethemes.net/plugins/elementor/case-theme-core.zip'),
            'required'           => true,
        ),
        
        array(
            'name'               => esc_html__('Case Theme Import', 'organio'),
            'slug'               => 'case-theme-import',
            'source'             => esc_url('http://demo.casethemes.net/plugins/elementor/case-theme-import.zip'),
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Case Theme User', 'organio'),
            'slug'               => 'case-theme-user',
            'source'             => esc_url('http://demo.casethemes.net/plugins/elementor/case-theme-user.zip'),
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Revolution Slider', 'organio'),
            'slug'               => 'revslider',
            'source'             => esc_url('http://demo.casethemes.net/plugins/revslider.zip'),
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Contact Form 7', 'organio'),
            'slug'               => 'contact-form-7',
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Mailchimp', 'organio'),
            'slug'               => 'mailchimp-for-wp',
            'required'           => true,
        ),  

        array(
            'name'               => esc_html__('Instagram Feed', 'organio'),
            'slug'               => 'instagram-feed',
            'required'           => true,
        ),
        array(
            'name'               => esc_html__('WooCommerce', 'organio'),
            'slug'               => "woocommerce",
            'required'           => true,
        ),

        array(
            'name'               => esc_html__('Quick View for WooCommerce', 'organio'),
            'slug'               => "woo-smart-quick-view",
            'required'           => false,
        ),

        array(
            'name'               => esc_html__('Wishlist for WooCommerce', 'organio'),
            'slug'               => "woo-smart-wishlist",
            'required'           => false,
        ),

        array(
            'name'               => esc_html__('Compare for WooCommerce', 'organio'),
            'slug'               => "woo-smart-compare",
            'required'           => false,
        ),

        array(
            'name'               => esc_html__('AJAX Add to Cart for WooCommerce', 'organio'),
            'slug'               => "wpc-ajax-add-to-cart",
            'required'           => false,
        ),

        array(
            'name'               => esc_html__('WooCommerce Variation Swatches', 'organio'),
            'slug'               => "woo-variation-swatches",
            'required'           => false,
        ),
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
    */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.

    );

    tgmpa( $plugins, $config );

}