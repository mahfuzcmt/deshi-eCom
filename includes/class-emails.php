<?php
/**
 * Custom WooCommerce email templates.
 *
 * - Professional order confirmation email
 * - "Care & Quality" follow-up email (sent X days after order completion)
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_Emails {

    public static function init() {
        if (!get_option('tot_custom_emails_enabled', 1)) {
            return;
        }

        // Override order confirmation email content
        add_action('woocommerce_email_order_details', array(__CLASS__, 'custom_order_confirmation'), 5, 4);
        add_filter('woocommerce_email_subject_new_order', array(__CLASS__, 'custom_order_subject'), 10, 2);
        add_filter('woocommerce_email_subject_customer_processing_order', array(__CLASS__, 'custom_processing_subject'), 10, 2);

        // Add custom email header/footer branding
        add_action('woocommerce_email_header', array(__CLASS__, 'email_header_branding'), 5, 2);
        add_action('woocommerce_email_footer', array(__CLASS__, 'email_footer_branding'), 5);

        // Schedule follow-up email on order completion
        add_action('woocommerce_order_status_completed', array(__CLASS__, 'schedule_followup_email'));

        // Hook for scheduled follow-up
        add_action('tot_send_followup_email', array(__CLASS__, 'send_followup_email'), 10, 1);
    }

    /**
     * Custom subject for admin new order email.
     */
    public static function custom_order_subject($subject, $order) {
        return sprintf(
            'New Order #%s from %s - ৳%s',
            $order->get_order_number(),
            $order->get_billing_first_name(),
            $order->get_total()
        );
    }

    /**
     * Custom subject for customer processing order email.
     */
    public static function custom_processing_subject($subject, $order) {
        return sprintf(
            "Order Confirmed! \xF0\x9F\x87\xB9\xF0\x9F\x87\xAD Your OriginThai Journey Begins Order #%s",
            $order->get_order_number()
        );
    }

    /**
     * Add branding content after email header.
     */
    public static function email_header_branding($email_heading, $email = null) {
        // Only modify customer-facing emails
        if ($email && isset($email->id) && strpos($email->id, 'customer_') === false) {
            return;
        }
        echo '<p style="text-align:center;color:#3bb77e;font-style:italic;margin:0 0 10px;">From the Origins of Thailand</p>';
    }

    /**
     * Add branded footer.
     */
    public static function email_footer_branding() {
        $phone = get_option('tot_support_phone', '01875906277');
        ?>
        <div style="text-align:center;padding:20px 0 10px;border-top:1px solid #e0e0e0;margin-top:20px;">
            <p style="color:#666;font-size:13px;margin:5px 0;">
                Stay Healthy,<br>
                <strong>The Thai Origins Team</strong><br>
                <em>100% Authentic | Made in Thailand</em>
            </p>
            <p style="color:#999;font-size:12px;margin:5px 0;">
                Questions? Call us at <a href="tel:+880<?php echo esc_attr($phone); ?>" style="color:#3bb77e;">+880 <?php echo esc_html($phone); ?></a>
            </p>
        </div>
        <?php
    }

    /**
     * Custom order confirmation content injected before default order details.
     */
    public static function custom_order_confirmation($order, $sent_to_admin, $plain_text, $email) {
        // Only for customer processing order email
        if (!$email || $email->id !== 'customer_processing_order') {
            return;
        }

        $name  = $order->get_billing_first_name();
        $area  = $order->get_meta('delivery_area');

        if ($plain_text) {
            echo "Dear {$name},\n\n";
            echo "Sawasdee! Thank you for choosing The Thai Origins.\n";
            echo "We've received your order and our team is already working to get your authentic Thai wellness products ready for shipment.\n\n";
            echo "What happens next?\n";
            echo "1. Verification: Our team may give you a quick call to verify your delivery address.\n";
            echo "2. Dispatch: Once verified, your package will be handed over to our delivery partner.\n";
            if ($area === 'inside') {
                echo "3. Delivery: Expect your package within 2-3 days (Inside Dhaka).\n\n";
            } else {
                echo "3. Delivery: Expect your package within 3-5 days (Outside Dhaka).\n\n";
            }
        } else {
            ?>
            <div style="margin-bottom:20px;">
                <p>Dear <?php echo esc_html( $order->get_billing_first_name() . ' ' . $order->get_billing_last_name() ); ?>,</p>
                <p>Sawasdee! &#x1F64F; Thank you for choosing <strong>The Thai Origins</strong>.</p>
                <p>We've received your order and our team is already working to get your authentic Thai wellness products ready for shipment.</p>

                <h3 style="color:#3bb77e;margin-top:20px;">Order Summary</h3>
                <table cellspacing="0" cellpadding="8" style="width:100%;border-collapse:collapse;margin-bottom:15px;">
                    <tr>
                        <td style="font-weight:bold;width:40%;vertical-align:top;">Order Number:</td>
                        <td>#<?php echo esc_html( $order->get_order_number() ); ?></td>
                    </tr>
                    <tr style="background-color:#f9f9f9;">
                        <td style="font-weight:bold;vertical-align:top;">Items:</td>
                        <td>
                            <?php foreach ( $order->get_items() as $item ) : ?>
                                <?php echo esc_html( $item->get_name() ); ?> x <?php echo esc_html( $item->get_quantity() ); ?><br>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;vertical-align:top;">Total Amount:</td>
                        <td style="font-weight:bold;color:#3bb77e;">&#x09F3; <?php echo wp_kses_post( $order->get_total() ); ?></td>
                    </tr>
                    <tr style="background-color:#f9f9f9;">
                        <td style="font-weight:bold;vertical-align:top;">Payment Method:</td>
                        <td><?php echo esc_html( $order->get_payment_method_title() ); ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold;vertical-align:top;">Payment Status:</td>
                        <td><?php
                            if ($order->get_payment_method() === 'cod') {
                                echo '<span style="color:#e67e22;font-weight:600;">Pay on Delivery</span>';
                            } elseif ($order->is_paid()) {
                                echo '<span style="color:#2e7d32;font-weight:600;">Paid</span>';
                            } else {
                                echo '<span style="color:#e53935;font-weight:600;">Unpaid</span>';
                            }
                        ?></td>
                    </tr>
                    <?php
                        $txn_id = $order->get_transaction_id();
                        if (!$txn_id && $order->get_payment_method() === 'wc_shurjopay') {
                            global $wpdb;
                            $txn_id = $wpdb->get_var($wpdb->prepare(
                                "SELECT bank_trx_id FROM {$wpdb->prefix}sp_orders WHERE order_id = %s AND bank_trx_id IS NOT NULL AND bank_trx_id != '' LIMIT 1",
                                $order->get_id()
                            ));
                        }
                    ?>
                    <?php if ( $txn_id ) : ?>
                    <tr style="background-color:#f9f9f9;">
                        <td style="font-weight:bold;vertical-align:top;">Transaction ID:</td>
                        <td><?php echo esc_html( $txn_id ); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ( $order->get_date_paid() ) : ?>
                    <tr>
                        <td style="font-weight:bold;vertical-align:top;">Paid on:</td>
                        <td><?php echo esc_html( $order->get_date_paid()->date_i18n('F j, Y g:i A') ); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>

                <h3 style="color:#3bb77e;margin-top:20px;">What happens next?</h3>
                <ol style="line-height:1.8;">
                    <li><strong>Verification:</strong> Our team may give you a quick call to verify your delivery address.</li>
                    <li><strong>Dispatch:</strong> Once verified, your package will be handed over to our delivery partner.</li>
                    <li><strong>Delivery:</strong> Expect your package within <strong>2-3 days</strong> (Inside Dhaka) or <strong>3-5 days</strong> (Outside Dhaka).</li>
                </ol>

                <p style="margin-top:15px;">If you have any questions, feel free to reply to this email or call us at <strong>+880 1875 906277</strong>.</p>
            </div>
            <?php
        }
    }

    /**
     * Schedule follow-up email when order is marked complete.
     */
    public static function schedule_followup_email($order_id) {
        $days = (int) get_option('tot_followup_email_days', 7);
        $timestamp = time() + ($days * DAY_IN_SECONDS);

        if (!wp_next_scheduled('tot_send_followup_email', array($order_id))) {
            wp_schedule_single_event($timestamp, 'tot_send_followup_email', array($order_id));
        }
    }

    /**
     * Send the "Care & Quality" follow-up email.
     */
    public static function send_followup_email($order_id) {
        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }

        $email = $order->get_billing_email();
        if (!$email) {
            return;
        }

        $name    = $order->get_billing_first_name();
        $items   = $order->get_items();
        $product_name = '';
        foreach ($items as $item) {
            $product_name = $item->get_name();
            break;
        }

        $facebook_url = get_option('tot_facebook_review_url', '');
        $site_url     = home_url('/');
        $phone        = get_option('tot_support_phone', '01875906277');

        $subject = "How is your little one feeling? \xF0\x9F\x92\x9A (Quick question from The Thai Origins)";

        $body = self::get_followup_email_html($name, $product_name, $facebook_url, $site_url, $phone);

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: The Thai Origins <' . get_option('admin_email') . '>',
        );

        wp_mail($email, $subject, $body, $headers);
    }

    /**
     * Generate follow-up email HTML.
     */
    private static function get_followup_email_html($name, $product_name, $facebook_url, $site_url, $phone) {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head><meta charset="UTF-8"></head>
        <body style="font-family:Arial,sans-serif;line-height:1.6;color:#333;max-width:600px;margin:0 auto;padding:20px;">
            <div style="text-align:center;margin-bottom:20px;">
                <h2 style="color:#3bb77e;">The Thai Origins</h2>
                <p style="color:#999;font-style:italic;">From the Origins of Thailand</p>
            </div>

            <p>Dear <?php echo esc_html($name); ?>,</p>

            <p>Sawasdee (Hello)! &#x1F64F; It's been about a week since your <strong>The Thai Origins</strong> package arrived. We hope you (or your little one) are enjoying the authentic relief of <?php echo esc_html($product_name); ?>.</p>

            <p>At <strong>The Thai Origins</strong>, we only import the best from Thailand because we care about your family's wellness. Could you take <strong>30 seconds</strong> to tell us how your experience was?</p>

            <div style="text-align:center;margin:30px 0;">
                <?php if ($facebook_url) : ?>
                <a href="<?php echo esc_url($facebook_url); ?>" style="display:inline-block;background:#1877F2;color:#fff;padding:12px 24px;border-radius:6px;text-decoration:none;margin:5px;">Leave a Review on Facebook</a>
                <?php endif; ?>
                <a href="<?php echo esc_url($site_url); ?>" style="display:inline-block;background:#3bb77e;color:#fff;padding:12px 24px;border-radius:6px;text-decoration:none;margin:5px;">Rate us on our Website</a>
            </div>

            <p>Your feedback helps other Mamas and families in Bangladesh find authentic Thai wellness solutions.</p>

            <div style="text-align:center;padding:20px 0;border-top:1px solid #e0e0e0;margin-top:30px;">
                <p style="color:#666;margin:5px 0;">
                    Stay Healthy,<br>
                    <strong>The Thai Origins Team</strong><br>
                    <em>100% Authentic | Made in Thailand</em>
                </p>
                <p style="color:#999;font-size:12px;">
                    Questions? Call us at <a href="tel:+880<?php echo esc_attr($phone); ?>" style="color:#3bb77e;">+880 <?php echo esc_html($phone); ?></a>
                </p>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}
