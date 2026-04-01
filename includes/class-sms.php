<?php
/**
 * SMS notification handling via Falcon Communication Ltd.
 *
 * API: https://sms.falconcommunicationltd.com/sms/v1/send-non-masking-sms
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_SMS {

    const API_URL = 'https://sms.falconcommunicationltd.com/sms/v1/send-non-masking-sms';

    public static function init() {
        if (!get_option('tot_sms_enabled', 0)) {
            return;
        }

        // Hook into every possible order creation event
        add_action('woocommerce_checkout_order_processed', array(__CLASS__, 'on_thankyou'), 10, 1);
        add_action('woocommerce_thankyou', array(__CLASS__, 'on_thankyou'), 10, 1);
        add_action('woocommerce_order_status_changed', array(__CLASS__, 'on_status_change'), 10, 3);
        add_action('woocommerce_new_order', array(__CLASS__, 'on_thankyou'), 99, 1);
        add_action('woocommerce_checkout_order_created', array(__CLASS__, 'on_order_created'), 99, 1);

        // Admin: test SMS button
        add_action('wp_ajax_tot_test_sms', array(__CLASS__, 'ajax_test_sms'));
    }

    /**
     * Handle order ID based hooks.
     */
    public static function on_thankyou($order_id) {
        $order = wc_get_order($order_id);
        if ($order) {
            self::maybe_send_sms($order);
        }
    }

    /**
     * Handle order object based hook (woocommerce_checkout_order_created).
     */
    public static function on_order_created($order) {
        if ($order) {
            self::maybe_send_sms($order);
        }
    }

    /**
     * Handle status change — send on first status transition.
     */
    public static function on_status_change($order_id, $old_status, $new_status) {
        $order = wc_get_order($order_id);
        if ($order) {
            self::maybe_send_sms($order);
        }
    }

    /**
     * Send SMS if conditions are met.
     */
    private static $sent_orders = array();

    private static function maybe_send_sms($order) {
        $order_id = $order->get_id();

        // Prevent duplicate within same request
        if (in_array($order_id, self::$sent_orders)) {
            return;
        }

        // Log to a custom file (works even with WP_DEBUG off)
        $log_file = WP_CONTENT_DIR . '/tot-sms-debug.log';

        // Prevent duplicate SMS across requests
        if ($order->get_meta('_tot_sms_sent')) {
            file_put_contents($log_file, date('Y-m-d H:i:s') . " Order #{$order_id}: Already sent, skipping.\n", FILE_APPEND);
            return;
        }

        // Skip SMS if customer has email and setting is enabled
        if (get_option('tot_sms_skip_if_email', 0) && $order->get_billing_email()) {
            file_put_contents($log_file, date('Y-m-d H:i:s') . " Order #{$order_id}: Has email, skip enabled.\n", FILE_APPEND);
            return;
        }

        $phone = $order->get_billing_phone();
        $name  = $order->get_billing_first_name();
        $total = $order->get_total();

        if (!$phone) {
            file_put_contents($log_file, date('Y-m-d H:i:s') . " Order #{$order_id}: No phone number.\n", FILE_APPEND);
            return;
        }

        // Mark as sent immediately to prevent duplicate in same request
        self::$sent_orders[] = $order_id;

        file_put_contents($log_file, date('Y-m-d H:i:s') . " Order #{$order_id}: Sending SMS to {$phone} for {$name}.\n", FILE_APPEND);

        $phone = self::format_bd_phone($phone);
        $support_phone = get_option('tot_support_phone', '01875906277');

        $message = sprintf(
            'The Thai Origins: Hi %s! Order #%s confirmed. Total: Tk %s. We will call you for verification soon. Thanks! %s',
            $name,
            $order->get_id(),
            $total,
            $support_phone
        );

        $result = self::send_sms($phone, $message);

        $log_file = WP_CONTENT_DIR . '/tot-sms-debug.log';
        file_put_contents($log_file, date('Y-m-d H:i:s') . " Order #{$order_id}: SMS result=" . var_export($result, true) . "\n", FILE_APPEND);

        if ($result) {
            $order->update_meta_data('_tot_sms_sent', time());
            $order->save();
        }
    }

    /**
     * Format phone number to BD local format (01XXXXXXXXX).
     */
    private static function format_bd_phone($phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 3) === '880') {
            $phone = '0' . substr($phone, 3);
        } elseif (substr($phone, 0, 2) === '88') {
            $phone = '0' . substr($phone, 2);
        }

        if (substr($phone, 0, 1) !== '0') {
            $phone = '0' . $phone;
        }

        return $phone;
    }

    /**
     * Send SMS via Falcon Communication Ltd API.
     */
    public static function send_sms($phone, $message) {
        $bearer_token = get_option('tot_sms_bearer_token', '');

        if (empty($bearer_token)) {
            return false;
        }

        $body = array(
            'message'        => $message,
            'mobile_number'  => $phone,
            'message_type'   => 'Notification',
            'service_type'   => 'cold',
            'operator'       => '',
            'language'       => 'en',
        );

        $response = wp_remote_post(self::API_URL, array(
            'timeout' => 15,
            'headers' => array(
                'Authorization' => 'Bearer ' . $bearer_token,
                'Content-Type'  => 'application/json',
            ),
            'body' => wp_json_encode($body),
        ));

        if (is_wp_error($response)) {
            return false;
        }

        $response_code = wp_remote_retrieve_response_code($response);

        if ($response_code < 200 || $response_code >= 300) {
            return false;
        }

        return true;
    }

    /**
     * AJAX handler: send a test SMS from admin settings page.
     */
    public static function ajax_test_sms() {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        if (empty($phone)) {
            wp_send_json_error('No phone number provided');
        }

        $phone = self::format_bd_phone($phone);
        $token = get_option('tot_sms_bearer_token', '');

        if (empty($token)) {
            wp_send_json_error('Bearer token is empty. Please save your token first.');
        }

        $message = 'The Thai Origins: This is a test SMS. If you received this, SMS is working!';

        $body = array(
            'message'        => $message,
            'mobile_number'  => $phone,
            'message_type'   => 'Notification',
            'service_type'   => 'cold',
            'operator'       => '',
            'language'       => 'en',
        );

        $response = wp_remote_post(self::API_URL, array(
            'timeout' => 15,
            'headers' => array(
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json',
            ),
            'body' => wp_json_encode($body),
        ));

        if (is_wp_error($response)) {
            wp_send_json_error('Connection error: ' . $response->get_error_message());
        }

        $code = wp_remote_retrieve_response_code($response);
        $resp_body = wp_remote_retrieve_body($response);

        if ($code >= 200 && $code < 300) {
            wp_send_json_success('SMS sent! (HTTP ' . $code . ') Response: ' . $resp_body);
        } else {
            wp_send_json_error('API error (HTTP ' . $code . '): ' . $resp_body);
        }
    }
}
