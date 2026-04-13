<?php
/**
 * Plugin Name: Deshi eCom
 * Plugin URI: https://webinnovation.com.bd
 * Description: All-in-one WooCommerce customizations — checkout fields, delivery area, SMS, emails, invoices, WhatsApp button, online payment discount, and more.
 * Version: 1.0.0
 * Author: Web Innovation
 * Author URI: https://webinnovation.com.bd
 * Text Domain: deshi-ecom
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 9.0
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

define('TOT_VERSION', '1.0.0');
define('TOT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TOT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TOT_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Check if WooCommerce is active before loading.
 */
function tot_check_woocommerce() {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p><strong>Deshi eCom</strong> requires WooCommerce to be installed and active.</p></div>';
        });
        return false;
    }
    return true;
}

/**
 * Initialize the plugin after all plugins are loaded.
 */
function tot_init() {
    if (!tot_check_woocommerce()) {
        return;
    }

    // Admin settings
    require_once TOT_PLUGIN_DIR . 'includes/class-admin-settings.php';

    // Feature modules
    require_once TOT_PLUGIN_DIR . 'includes/class-checkout.php';
    require_once TOT_PLUGIN_DIR . 'includes/class-shipping.php';
    require_once TOT_PLUGIN_DIR . 'includes/class-sms.php';
    require_once TOT_PLUGIN_DIR . 'includes/class-emails.php';
    require_once TOT_PLUGIN_DIR . 'includes/class-cart.php';
    require_once TOT_PLUGIN_DIR . 'includes/class-invoice.php';
    require_once TOT_PLUGIN_DIR . 'includes/class-discount.php';
    require_once TOT_PLUGIN_DIR . 'includes/class-frontend.php';

    // Initialize all modules
    TOT_Admin_Settings::init();
    TOT_Checkout::init();
    TOT_Shipping::init();
    TOT_SMS::init();
    TOT_Emails::init();
    TOT_Cart::init();
    TOT_Invoice::init();
    TOT_Discount::init();
    TOT_Frontend::init();
}
add_action('plugins_loaded', 'tot_init');

/**
 * Set COD orders to "Processing" instead of "Pending payment".
 */
add_filter('woocommerce_cod_process_payment_order_status', function() {
    return 'processing';
});

/**
 * Set paid orders to "Processing" instead of "Completed".
 * Orders should only be marked "Completed" after delivery.
 */
add_filter('woocommerce_payment_complete_order_status', function($status, $order_id) {
    return 'processing';
}, 10, 2);

/**
 * Enqueue frontend assets.
 */
function tot_enqueue_assets() {
    if (!class_exists('WooCommerce')) {
        return;
    }

    wp_enqueue_style(
        'deshi-ecom',
        TOT_PLUGIN_URL . 'assets/css/frontend.css',
        array(),
        TOT_VERSION
    );

    wp_enqueue_script(
        'deshi-ecom',
        TOT_PLUGIN_URL . 'assets/js/frontend.js',
        array('jquery'),
        TOT_VERSION,
        true
    );

    wp_localize_script('deshi-ecom', 'tot_vars', array(
        'ajax_url'    => admin_url('admin-ajax.php'),
        'whatsapp_url' => get_option('tot_whatsapp_url', 'https://wa.me/message/7GWAUHQZ3RV6G1'),
        'search_texts' => array_filter(array_map('trim', explode("\n", get_option('tot_search_animation_texts', "Search Products...\nHappy Noz Kids Formula\nAuthentic Thai Wellness\nFree delivery inside Dhaka!")))),
    ));
}
add_action('wp_enqueue_scripts', 'tot_enqueue_assets');

/**
 * Override strikethrough price color (must come after theme inline styles).
 */
function tot_price_del_override() {
    echo '<style>
    .woocommerce .price del,
    .woocommerce .price del .amount,
    .woocommerce .price del .woocommerce-Price-amount {
        color: #999 !important;
    }
    </style>' . "\n";
}
add_action('wp_head', 'tot_price_del_override', 999);

/**
 * Plugin activation.
 */
function tot_activate() {
    // Set default options
    if (get_option('tot_inside_dhaka_fee') === false) {
        update_option('tot_inside_dhaka_fee', 80);
    }
    if (get_option('tot_outside_dhaka_fee') === false) {
        update_option('tot_outside_dhaka_fee', 150);
    }
    if (get_option('tot_whatsapp_url') === false) {
        update_option('tot_whatsapp_url', 'https://wa.me/message/7GWAUHQZ3RV6G1');
    }
    if (get_option('tot_support_phone') === false) {
        update_option('tot_support_phone', '01875906277');
    }
    if (get_option('tot_online_payment_discount') === false) {
        update_option('tot_online_payment_discount', 5);
    }
    if (get_option('tot_sms_bearer_token') === false) {
        update_option('tot_sms_bearer_token', '');
    }
    if (get_option('tot_search_animation_texts') === false) {
        update_option('tot_search_animation_texts', "Search Products...\nHappy Noz Kids Formula\nAuthentic Thai Wellness\nFree delivery inside Dhaka!");
    }

    // Enforce review moderation
    update_option('comment_moderation', 1);
}
register_activation_hook(__FILE__, 'tot_activate');

/**
 * Declare HPOS compatibility.
 */
add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});
