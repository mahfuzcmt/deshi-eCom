<?php
/**
 * Frontend customizations.
 *
 * - WhatsApp floating button
 * - Search bar typing animation
 * - Account name in header (instead of icon)
 * - Product grid equal heights
 * - Review moderation enforcement
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_Frontend {

    public static function init() {
        // WhatsApp floating button
        if (get_option('tot_whatsapp_enabled', 1)) {
            add_action('wp_footer', array(__CLASS__, 'whatsapp_button'));
        }

        // Show user name next to account icon in header
        add_action('wp_footer', array(__CLASS__, 'show_account_name_script'));

        // Enforce review moderation
        add_filter('pre_comment_approved', array(__CLASS__, 'moderate_reviews'), 10, 2);

        // Add search animation data attribute
        if (get_option('tot_search_animation_enabled', 1)) {
            add_action('wp_footer', array(__CLASS__, 'search_animation_init'));
        }

        // "Select the variant" label on variable products
        add_action('woocommerce_before_variations_form', array(__CLASS__, 'variant_select_label'));
    }

    /**
     * Render floating WhatsApp button.
     */
    public static function whatsapp_button() {
        $url = get_option('tot_whatsapp_url', 'https://wa.me/message/7GWAUHQZ3RV6G1');
        ?>
        <a href="<?php echo esc_url($url); ?>"
           class="tot-whatsapp-btn"
           target="_blank"
           rel="noopener noreferrer"
           aria-label="<?php esc_attr_e('Chat with Us on WhatsApp', 'deshi-ecom'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="#fff">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            <span><?php esc_html_e('Chat with Us', 'deshi-ecom'); ?></span>
        </a>
        <?php
    }

    /**
     * Inject user name next to the account icon in the Organio theme header.
     */
    public static function show_account_name_script() {
        if (!is_user_logged_in()) {
            return;
        }

        $user = wp_get_current_user();
        $name = $user->display_name ?: $user->first_name;

        if (empty($name)) {
            return;
        }

        $name_js = esc_js($name);
        $account_url = '';
        if (class_exists('WooCommerce')) {
            $account_url = esc_url(wc_get_page_permalink('myaccount'));
        }
        ?>
        <script>
        jQuery(function($){
            var $userBtn = $('.h-btn-user, .h-btn-icon-user');
            if ($userBtn.length) {
                $userBtn.each(function(){
                    if (!$(this).find('.tot-account-name').length) {
                        $(this).append('<span class="tot-account-name"><?php echo $name_js; ?></span>');
                    }
                });
            }
        });
        </script>
        <?php
    }

    /**
     * Force all product reviews (WooCommerce comments) to require manual approval.
     */
    public static function moderate_reviews($approved, $commentdata) {
        if (isset($commentdata['comment_type']) && $commentdata['comment_type'] === 'review') {
            return 0; // Hold for moderation
        }

        // Also catch WooCommerce reviews on product post type
        if (isset($commentdata['comment_post_ID'])) {
            $post_type = get_post_type($commentdata['comment_post_ID']);
            if ($post_type === 'product') {
                return 0; // Hold for moderation
            }
        }

        return $approved;
    }

    /**
     * Show "Select the variant" label above variation swatches.
     */
    public static function variant_select_label() {
        global $product;
        if ($product && $product->is_type('variable')) {
            echo '<p style="margin:0 0 5px;font-size:14px;font-weight:600;color:#555;">' . esc_html__('Select the variant', 'deshi-ecom') . '</p>';
        }
    }

    /**
     * Initialize search bar typing animation via JS.
     */
    public static function search_animation_init() {
        ?>
        <script>
        jQuery(function($){
            if (typeof tot_vars !== 'undefined' && tot_vars.search_texts && tot_vars.search_texts.length > 0) {
                var searchInputs = $('input[type="search"], input[name="s"], .search-field, input[placeholder*="Search"]');
                if (searchInputs.length > 0) {
                    searchInputs.each(function(){
                        $(this).attr('data-tot-animate', '1');
                    });
                }
            }
        });
        </script>
        <?php
    }
}
