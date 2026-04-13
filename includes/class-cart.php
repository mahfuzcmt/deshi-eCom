<?php
/**
 * Cart page customizations.
 *
 * - Hide sidebar/product list on cart page
 * - Coupon field improvements (click-to-reveal, equal sizing)
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_Cart {

    public static function init() {
        // Remove sidebar on cart page
        add_action('wp', array(__CLASS__, 'remove_cart_sidebar'));

        // Add click-to-reveal coupon on cart (top of cart, before table)
        add_action('woocommerce_before_cart', array(__CLASS__, 'coupon_toggle_markup'));
    }

    /**
     * Remove sidebar on cart and checkout pages.
     */
    public static function remove_cart_sidebar() {
        if (is_cart() || is_checkout()) {
            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
            add_filter('body_class', function ($classes) {
                $classes[] = 'tot-no-sidebar';
                return $classes;
            });
        }
    }

    /**
     * Show click-to-reveal coupon link above the cart.
     */
    public static function coupon_toggle_markup() {
        ?>
        <div class="tot-coupon-toggle">
            <a href="#" class="tot-coupon-link" id="tot-show-coupon">
                <?php esc_html_e('Have a coupon? Click here to enter your code', 'deshi-ecom'); ?>
            </a>
            <div class="tot-coupon-form" id="tot-coupon-form" style="display:none;">
                <input type="text" name="tot_coupon_code" id="tot-coupon-code" placeholder="<?php esc_attr_e('Coupon code', 'deshi-ecom'); ?>" />
                <button type="button" class="button tot-apply-coupon" id="tot-apply-coupon"><?php esc_html_e('Apply coupon', 'deshi-ecom'); ?></button>
            </div>
        </div>
        <?php
    }
}
