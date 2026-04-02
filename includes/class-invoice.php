<?php
/**
 * Invoice download/print functionality.
 *
 * Adds "Download Invoice" and "Print Invoice" buttons on the
 * My Account > View Order page.
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_Invoice {

    public static function init() {
        if (!get_option('tot_invoice_enabled', 1)) {
            return;
        }

        // Add invoice buttons on order view page
        add_action('woocommerce_order_details_after_order_table', array(__CLASS__, 'invoice_buttons'), 10, 1);

        // Handle invoice download/print endpoint
        add_action('init', array(__CLASS__, 'register_endpoint'));
        add_action('template_redirect', array(__CLASS__, 'handle_invoice_request'));
    }

    /**
     * Register query var for invoice endpoint.
     */
    public static function register_endpoint() {
        add_rewrite_endpoint('tot-invoice', EP_ROOT);
    }

    /**
     * Show Download/Print Invoice buttons.
     */
    public static function invoice_buttons($order) {
        $order_id = $order->get_id();
        $nonce = wp_create_nonce('tot_invoice_' . $order_id);
        $invoice_url = add_query_arg(array(
            'tot-invoice' => $order_id,
            '_wpnonce'    => $nonce,
        ), home_url('/'));

        echo '<div class="tot-invoice-actions" style="margin:20px 0;">';
        echo '<a href="' . esc_url($invoice_url . '&action=print') . '" class="button tot-invoice-print" target="_blank">';
        echo esc_html__('Print Invoice', 'deshi-ecom');
        echo '</a> ';
        echo '<a href="' . esc_url($invoice_url . '&action=download') . '" class="button tot-invoice-download" target="_blank">';
        echo esc_html__('Download Invoice', 'deshi-ecom');
        echo '</a>';
        echo '</div>';
    }

    /**
     * Handle invoice request (print/download).
     */
    public static function handle_invoice_request() {
        if (!isset($_GET['tot-invoice']) || !isset($_GET['_wpnonce'])) {
            return;
        }

        $order_id = absint($_GET['tot-invoice']);
        if (!wp_verify_nonce(sanitize_text_field($_GET['_wpnonce']), 'tot_invoice_' . $order_id)) {
            wp_die(__('Invalid request.', 'deshi-ecom'));
        }

        $order = wc_get_order($order_id);
        if (!$order) {
            wp_die(__('Order not found.', 'deshi-ecom'));
        }

        // Verify the current user owns this order
        if ($order->get_customer_id() !== get_current_user_id() && !current_user_can('manage_woocommerce')) {
            wp_die(__('You do not have permission to view this invoice.', 'deshi-ecom'));
        }

        $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : 'print';

        self::render_invoice($order, $action);
        exit;
    }

    /**
     * Render printable invoice HTML.
     */
    private static function render_invoice($order, $action = 'print') {
        $order_id      = $order->get_id();
        $order_date    = $order->get_date_created()->date_i18n('F j, Y');
        $name          = $order->get_billing_first_name() . ' ' . $order->get_billing_last_name();
        $phone         = $order->get_billing_phone();
        $email         = $order->get_billing_email();
        $address       = $order->get_billing_address_1();
        $city          = $order->get_billing_city();
        $delivery_area = $order->get_meta('delivery_area');
        $area_labels   = array('inside' => 'Inside Dhaka', 'suburban' => 'Dhaka Suburban', 'outside' => 'Outside Dhaka');
        $area_label    = isset($area_labels[$delivery_area]) ? $area_labels[$delivery_area] : '';
        $payment        = $order->get_payment_method_title();
        $payment_method = $order->get_payment_method();
        $transaction_id = $order->get_transaction_id();
        // Fallback: fetch from ShurjoPay table if WooCommerce doesn't have it
        if (!$transaction_id && $payment_method === 'wc_shurjopay') {
            global $wpdb;
            $transaction_id = $wpdb->get_var($wpdb->prepare(
                "SELECT bank_trx_id FROM {$wpdb->prefix}sp_orders WHERE order_id = %s AND bank_trx_id IS NOT NULL AND bank_trx_id != '' LIMIT 1",
                $order_id
            ));
        }
        $date_paid      = $order->get_date_paid();
        $is_paid        = $order->is_paid();
        $support_phone  = get_option('tot_support_phone', '01875906277');
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Invoice #<?php echo esc_html($order_id); ?> - The Thai Origins</title>
            <style>
                body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 30px; color: #333; }
                .invoice-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #3bb77e; padding-bottom: 20px; margin-bottom: 20px; }
                .invoice-header h1 { color: #3bb77e; margin: 0; font-size: 28px; }
                .invoice-header .order-info { text-align: right; }
                .invoice-header .order-info p { margin: 3px 0; }
                .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
                .detail-box { background: #f9f9f9; padding: 15px; border-radius: 8px; }
                .detail-box h3 { margin: 0 0 10px; color: #3bb77e; font-size: 14px; text-transform: uppercase; }
                .detail-box p { margin: 3px 0; font-size: 14px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th { background: #3bb77e; color: #fff; padding: 10px; text-align: left; }
                td { padding: 10px; border-bottom: 1px solid #e0e0e0; }
                .totals { text-align: right; }
                .totals td { font-weight: bold; }
                .total-row td { font-size: 18px; color: #3bb77e; border-top: 2px solid #3bb77e; }
                .footer { text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; color: #999; font-size: 12px; }
                @media print {
                    .no-print { display: none !important; }
                    body { padding: 0; }
                }
            </style>
        </head>
        <body>
            <div class="no-print" style="text-align:center;margin-bottom:20px;">
                <button onclick="window.print()" style="background:#3bb77e;color:#fff;border:none;padding:10px 30px;border-radius:6px;cursor:pointer;font-size:16px;">Print Invoice</button>
                <button onclick="totDownloadPdf()" style="background:#555;color:#fff;border:none;padding:10px 30px;border-radius:6px;cursor:pointer;font-size:16px;margin-left:10px;">Download PDF</button>
            </div>

            <div class="invoice-header">
                <div>
                    <?php
                    $logo_url = '';
                    $custom_logo_id = get_theme_mod('custom_logo');
                    if ($custom_logo_id) {
                        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'medium');
                    }
                    if (!$logo_url) {
                        $logo_url = get_template_directory_uri() . '/assets/images/logo-dark.png';
                    }
                    ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="The Thai Origins" style="max-height:100px;width:auto;margin-bottom:5px;">
                    <p style="color:#999;font-style:italic;margin:0;">From the Origins of Thailand</p>
                </div>
                <div class="order-info">
                    <p><strong>INVOICE</strong></p>
                    <p>Order #<?php echo esc_html($order_id); ?></p>
                    <p><?php echo esc_html($order_date); ?></p>
                    <p>Status: <?php echo esc_html(ucfirst($order->get_status())); ?></p>
                </div>
            </div>

            <div class="details-grid" style="grid-template-columns:1fr 1fr 1fr;">
                <div class="detail-box">
                    <h3>Customer Details</h3>
                    <p><strong><?php echo esc_html($name); ?></strong></p>
                    <p>Phone: <?php echo esc_html($phone); ?></p>
                    <?php if ($email) : ?><p>Email: <?php echo esc_html($email); ?></p><?php endif; ?>
                </div>
                <div class="detail-box">
                    <h3>Delivery Details</h3>
                    <p><?php echo esc_html($address); ?></p>
                    <p><?php echo esc_html($city); ?></p>
                    <?php if ($area_label) : ?><p>Area: <?php echo esc_html($area_label); ?></p><?php endif; ?>
                </div>
                <div class="detail-box">
                    <h3>Payment Details</h3>
                    <p>Method: <?php echo esc_html(wp_strip_all_tags($payment)); ?></p>
                    <p>Status: <?php
                        if ($payment_method === 'cod') {
                            echo '<span style="color:#e67e22;font-weight:600;">Pay on Delivery</span>';
                        } elseif ($is_paid) {
                            echo '<span style="color:#2e7d32;font-weight:600;">Paid</span>';
                        } else {
                            echo '<span style="color:#e53935;font-weight:600;">Unpaid</span>';
                        }
                    ?></p>
                    <?php if ($transaction_id) : ?><p>Transaction ID: <?php echo esc_html($transaction_id); ?></p><?php endif; ?>
                    <?php if ($date_paid) : ?><p>Paid on: <?php echo esc_html($date_paid->date_i18n('F j, Y g:i A')); ?></p><?php endif; ?>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align:right;">Unit Price</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order->get_items() as $item) :
                        $qty = $item->get_quantity();
                        $line_subtotal = $item->get_subtotal();
                        $unit_price = $qty > 0 ? $line_subtotal / $qty : 0;
                    ?>
                    <tr>
                        <td><?php echo esc_html($item->get_name()); ?></td>
                        <td style="text-align:right;">৳<?php echo esc_html(number_format($unit_price, 0)); ?></td>
                        <td style="text-align:center;"><?php echo esc_html($qty); ?></td>
                        <td style="text-align:right;">৳<?php echo esc_html(number_format($line_subtotal, 0)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table class="totals">
                <tr>
                    <td>Subtotal:</td>
                    <td>৳<?php echo esc_html(number_format($order->get_subtotal(), 0)); ?></td>
                </tr>
                <?php if ($order->get_total_discount() > 0) : ?>
                <tr style="color:#e53935;">
                    <td>Discount:</td>
                    <td>-৳<?php echo esc_html(number_format($order->get_total_discount(), 0)); ?></td>
                </tr>
                <?php endif; ?>
                <?php foreach ($order->get_fees() as $fee) : ?>
                <tr>
                    <td><?php echo esc_html($fee->get_name()); ?>:</td>
                    <td>৳<?php echo esc_html(number_format($fee->get_total(), 0)); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if ((float) $order->get_shipping_total() > 0) : ?>
                <tr>
                    <td>Shipping:</td>
                    <td>৳<?php echo esc_html(number_format($order->get_shipping_total(), 0)); ?></td>
                </tr>
                <?php endif; ?>
                <tr class="total-row">
                    <td>Total:</td>
                    <td>৳<?php echo esc_html(number_format($order->get_total(), 0)); ?></td>
                </tr>
            </table>

            <div class="footer">
                <p><strong>The Thai Origins</strong> | 100% Authentic | Made in Thailand</p>
                <p>Support: +880 <?php echo esc_html($support_phone); ?></p>
                <p>Thank you for your order!</p>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.2/html2pdf.bundle.min.js"></script>
            <script>
                function totDownloadPdf() {
                    var el = document.body.cloneNode(true);
                    // Remove no-print elements from the clone
                    el.querySelectorAll('.no-print').forEach(function(n) { n.remove(); });
                    html2pdf().set({
                        margin:       10,
                        filename:     'invoice-<?php echo esc_js($order_id); ?>.pdf',
                        image:        { type: 'jpeg', quality: 0.98 },
                        html2canvas:  { scale: 2, useCORS: true },
                        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
                    }).from(el).save();
                }
                <?php if ($action === 'download') : ?>
                window.addEventListener('DOMContentLoaded', function() { totDownloadPdf(); });
                <?php endif; ?>
            </script>
        </body>
        </html>
        <?php
    }
}
