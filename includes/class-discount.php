<?php
/**
 * Online payment discount.
 *
 * Applies a percentage discount when customer selects an online
 * payment method (not Cash on Delivery).
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_Discount {

    public static function init() {
        if (!get_option('tot_online_discount_enabled', 1)) {
            return;
        }

        // Apply discount based on payment method
        add_action('woocommerce_cart_calculate_fees', array(__CLASS__, 'apply_online_payment_discount'));

        // Save chosen payment method to session
        add_action('woocommerce_checkout_update_order_review', array(__CLASS__, 'save_payment_method_session'));

        // Add discount label to payment methods
        add_filter('woocommerce_gateway_title', array(__CLASS__, 'add_discount_label'), 10, 2);

        // JS to update checkout on payment method change
        add_action('wp_footer', array(__CLASS__, 'payment_method_script'));
    }

    /**
     * Apply online payment discount to cart.
     */
    public static function apply_online_payment_discount($cart) {
        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }

        $chosen_method = WC()->session->get('chosen_payment_method');
        if (!$chosen_method || $chosen_method === 'cod') {
            return;
        }

        $discount_percent = (int) get_option('tot_online_payment_discount', 5);
        if ($discount_percent <= 0) {
            return;
        }

        $subtotal = $cart->get_subtotal();
        $discount = ($subtotal * $discount_percent) / 100;

        if ($discount > 0) {
            $cart->add_fee(
                sprintf(__('Online Payment Discount (%d%%)', 'deshi-ecom'), $discount_percent),
                -$discount,
                false
            );
        }
    }

    /**
     * Save chosen payment method to session when checkout is updated.
     */
    public static function save_payment_method_session($posted_data) {
        parse_str($posted_data, $output);
        if (isset($output['payment_method'])) {
            WC()->session->set('chosen_payment_method', sanitize_text_field($output['payment_method']));
        }
    }

    /**
     * Add discount percentage label next to online payment gateways.
     */
    public static function add_discount_label($title, $id) {
        if ($id === 'cod') {
            return $title;
        }

        $discount_percent = (int) get_option('tot_online_payment_discount', 5);
        if ($discount_percent <= 0) {
            return $title;
        }

        // Avoid duplicate labels
        if (strpos($title, 'discount') !== false) {
            return $title;
        }

        return $title . sprintf(' <span class="tot-discount-badge">(%d%% discount)</span>', $discount_percent);
    }

    /**
     * JS to trigger checkout update when payment method changes.
     */
    public static function payment_method_script() {
        if (!is_checkout()) {
            return;
        }
        ?>
        <script>
        jQuery(function($){
            $('form.checkout').on('change', 'input[name="payment_method"]', function(){
                $('body').trigger('update_checkout');
            });
        });
        </script>
        <?php
    }
}
