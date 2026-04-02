<?php
/**
 * Shipping / Delivery fee handling.
 *
 * Disables WooCommerce native shipping and applies delivery fee
 * based on the selected delivery area (Inside/Outside Dhaka).
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_Shipping {

    public static function init() {
        // Disable WooCommerce shipping
        add_filter('woocommerce_cart_needs_shipping', '__return_false');
        add_filter('woocommerce_cart_needs_shipping_address', '__return_false');

        // Add delivery fee based on session
        add_action('woocommerce_cart_calculate_fees', array(__CLASS__, 'add_delivery_fee'));
    }

    /**
     * Add delivery fee as a cart fee based on selected delivery area.
     */
    public static function add_delivery_fee($cart) {
        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }

        $delivery_area = WC()->session->get('delivery_area');
        if (!$delivery_area) {
            return;
        }

        $inside_fee   = (int) get_option('tot_inside_dhaka_fee', 80);
        $outside_fee  = (int) get_option('tot_outside_dhaka_fee', 150);
        $suburban_fee  = (int) get_option('tot_dhaka_suburban_fee', 150);

        if ($delivery_area === 'inside') {
            $cart->add_fee(__('Delivery Charge', 'deshi-ecom'), $inside_fee, true, '');
        } elseif ($delivery_area === 'suburban') {
            $cart->add_fee(__('Delivery Charge', 'deshi-ecom'), $suburban_fee, true, '');
        } elseif ($delivery_area === 'outside') {
            $cart->add_fee(__('Delivery Charge', 'deshi-ecom'), $outside_fee, true, '');
        }
    }
}
