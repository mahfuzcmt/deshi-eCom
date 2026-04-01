<?php
/**
 * Checkout field customizations.
 *
 * - Simplified fields: Name, Phone, District (64), Area/Thana (AJAX), Address, Email, Order Note
 * - Delivery area auto-detected from district (Dhaka = Inside, others = Outside)
 * - No radio buttons — read-only delivery info shown based on city selection
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_Checkout {

    public static function init() {
        // Customize checkout fields
        add_filter('woocommerce_checkout_fields', array(__CLASS__, 'customize_checkout_fields'), 20);
        add_filter('woocommerce_default_address_fields', array(__CLASS__, 'customize_address_fields'), 20);

        // Save delivery area to session based on city
        add_action('woocommerce_checkout_update_order_review', array(__CLASS__, 'save_delivery_area_session'));

        // Save delivery area to order
        add_action('woocommerce_checkout_create_order', array(__CLASS__, 'save_delivery_area_to_order'), 20, 2);

        // Validate
        add_action('woocommerce_checkout_process', array(__CLASS__, 'validate_checkout'));

        // Display delivery area in admin
        add_action('woocommerce_admin_order_data_after_billing_address', array(__CLASS__, 'display_delivery_area_admin'), 10, 1);

        // Display delivery area in emails
        add_action('woocommerce_email_after_order_table', array(__CLASS__, 'display_delivery_area_email'), 20, 4);

        // AJAX: load thanas for selected district
        add_action('wp_ajax_tot_get_thanas', array(__CLASS__, 'ajax_get_thanas'));
        add_action('wp_ajax_nopriv_tot_get_thanas', array(__CLASS__, 'ajax_get_thanas'));

        // Delivery info display on checkout (read-only, before payment)
        add_action('woocommerce_review_order_before_payment', array(__CLASS__, 'delivery_info_display'));

        // Register delivery badge as checkout fragment so AJAX updates refresh it
        add_filter('woocommerce_update_order_review_fragments', array(__CLASS__, 'delivery_info_fragment'));

        // JS for city change → update area + delivery area
        add_action('wp_footer', array(__CLASS__, 'checkout_scripts'));
    }

    /**
     * Simplify and reorder checkout fields.
     */
    public static function customize_checkout_fields($fields) {
        // Remove unnecessary billing fields
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_state']);
        unset($fields['billing']['billing_postcode']);
        unset($fields['billing']['billing_last_name']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['billing_address_2']);

        // Force country to BD (hidden) so WooCommerce JS doesn't break
        $fields['billing']['billing_country'] = array(
            'type'     => 'hidden',
            'default'  => 'BD',
            'required' => true,
            'class'    => array('tot-hidden-country'),
            'priority' => 1,
        );

        // Full Name
        if (isset($fields['billing']['billing_first_name'])) {
            $fields['billing']['billing_first_name']['label'] = __('Full Name', 'deshi-ecom');
            $fields['billing']['billing_first_name']['placeholder'] = __('Your full name', 'deshi-ecom');
            $fields['billing']['billing_first_name']['class'] = array('form-row-first');
            $fields['billing']['billing_first_name']['priority'] = 10;
        }

        // Phone
        if (isset($fields['billing']['billing_phone'])) {
            $fields['billing']['billing_phone']['class'] = array('form-row-last');
            $fields['billing']['billing_phone']['priority'] = 20;
            $fields['billing']['billing_phone']['required'] = true;
            $fields['billing']['billing_phone']['placeholder'] = __('01XXXXXXXXX', 'deshi-ecom');
        }

        // Get saved values for logged-in users
        $saved_district = '';
        $saved_thana = '';
        if (is_user_logged_in()) {
            $customer_id = get_current_user_id();
            $saved_district = get_user_meta($customer_id, 'billing_district', true);
            $saved_thana = get_user_meta($customer_id, 'billing_thana', true);
        }

        // District — custom field (not billing_city to avoid WC JS interference)
        $fields['billing']['billing_district'] = array(
            'type'     => 'select',
            'label'    => __('District', 'deshi-ecom'),
            'required' => true,
            'class'    => array('form-row-first', 'tot-district-field'),
            'priority' => 30,
            'options'  => self::get_district_options(),
            'default'  => $saved_district,
            'custom_attributes' => array('data-saved-thana' => $saved_thana),
        );

        // Area / Thana — custom field (populated via AJAX)
        $fields['billing']['billing_thana'] = array(
            'type'     => 'select',
            'label'    => __('Area / Thana', 'deshi-ecom'),
            'required' => false,
            'class'    => array('form-row-last', 'tot-thana-field'),
            'priority' => 40,
            'options'  => array('' => __('Select District first', 'deshi-ecom')),
            'default'  => $saved_thana,
        );

        // Full Address
        if (isset($fields['billing']['billing_address_1'])) {
            $fields['billing']['billing_address_1']['label'] = __('Full Address', 'deshi-ecom');
            $fields['billing']['billing_address_1']['placeholder'] = __('House, Road, Area details', 'deshi-ecom');
            $fields['billing']['billing_address_1']['class'] = array('form-row-wide');
            $fields['billing']['billing_address_1']['priority'] = 50;
        }

        // Email (optional)
        if (isset($fields['billing']['billing_email'])) {
            $fields['billing']['billing_email']['required'] = false;
            $fields['billing']['billing_email']['class'] = array('form-row-wide');
            $fields['billing']['billing_email']['priority'] = 60;
            $fields['billing']['billing_email']['placeholder'] = __('Email (optional)', 'deshi-ecom');
        }

        // Order notes
        if (isset($fields['order']['order_comments'])) {
            $fields['order']['order_comments']['placeholder'] = __('Special instructions for your order (optional)', 'deshi-ecom');
        }

        // Hidden field for delivery_area (auto-set by JS based on district)
        $fields['billing']['delivery_area'] = array(
            'type'     => 'hidden',
            'label'    => '',
            'required' => false,
            'class'    => array('tot-delivery-area-hidden'),
            'priority' => 55,
            'default'  => '',
        );

        return $fields;
    }

    /**
     * Customize default WooCommerce address fields.
     */
    public static function customize_address_fields($fields) {
        unset($fields['company']);
        unset($fields['state']);
        unset($fields['postcode']);
        unset($fields['last_name']);
        unset($fields['city']);
        unset($fields['address_2']);
        return $fields;
    }

    /**
     * Save delivery area to WC session based on selected city.
     */
    public static function save_delivery_area_session($posted_data) {
        parse_str($posted_data, $output);

        $delivery_area = '';

        // Auto-detect from district
        if (isset($output['billing_district'])) {
            $district = sanitize_text_field($output['billing_district']);
            $delivery_area = ($district === 'dhaka') ? 'inside' : 'outside';
        }

        // Also accept explicit hidden field
        if (isset($output['delivery_area']) && !empty($output['delivery_area'])) {
            $delivery_area = sanitize_text_field($output['delivery_area']);
        }

        if ($delivery_area) {
            WC()->session->set('delivery_area', $delivery_area);
        }
    }

    /**
     * Save delivery area to order meta.
     */
    public static function save_delivery_area_to_order($order, $data) {
        // Determine from district if not in session
        $delivery_area = WC()->session->get('delivery_area');

        if (!$delivery_area && isset($_POST['billing_district'])) {
            $district = sanitize_text_field($_POST['billing_district']);
            $delivery_area = ($district === 'dhaka') ? 'inside' : 'outside';
        }

        if ($delivery_area) {
            $order->update_meta_data('delivery_area', $delivery_area);
        }

        // Save district and thana as order meta
        if (isset($_POST['billing_district'])) {
            $order->update_meta_data('billing_district', sanitize_text_field($_POST['billing_district']));
            // Also set billing_city for WooCommerce compatibility
            $order->set_billing_city(sanitize_text_field($_POST['billing_district']));
        }
        if (isset($_POST['billing_thana'])) {
            $order->update_meta_data('billing_thana', sanitize_text_field($_POST['billing_thana']));
            // Also set address_2 for WooCommerce compatibility
            $order->set_billing_address_2(sanitize_text_field($_POST['billing_thana']));
        }
    }

    /**
     * Validate checkout fields.
     */
    public static function validate_checkout() {
        if (empty($_POST['billing_district'])) {
            wc_add_notice(__('Please select a District.', 'deshi-ecom'), 'error');
        }
    }

    /**
     * Display delivery area on admin order page.
     */
    public static function display_delivery_area_admin($order) {
        $area = $order->get_meta('delivery_area');
        if ($area) {
            $label = $area === 'inside' ? __('Inside Dhaka', 'deshi-ecom') : __('Outside Dhaka', 'deshi-ecom');
            echo '<p><strong>' . esc_html__('Delivery Area:', 'deshi-ecom') . '</strong> ' . esc_html($label) . '</p>';
        }
    }

    /**
     * Display delivery area in order emails.
     */
    public static function display_delivery_area_email($order, $sent_to_admin, $plain_text, $email) {
        $area = $order->get_meta('delivery_area');
        if ($area) {
            $label = $area === 'inside' ? __('Inside Dhaka', 'deshi-ecom') : __('Outside Dhaka', 'deshi-ecom');
            if ($plain_text) {
                echo "\nDelivery Area: " . $label . "\n";
            } else {
                echo '<p><strong>' . esc_html__('Delivery Area:', 'deshi-ecom') . '</strong> ' . esc_html($label) . '</p>';
            }
        }
    }

    /**
     * AJAX handler: return thanas for a given district.
     */
    public static function ajax_get_thanas() {
        $district = isset($_POST['district']) ? sanitize_text_field($_POST['district']) : '';

        if (empty($district)) {
            wp_send_json_error();
        }

        require_once TOT_PLUGIN_DIR . 'includes/data-bangladesh.php';
        $data = tot_get_bangladesh_data();

        if (!isset($data[$district])) {
            wp_send_json_error();
        }

        $thanas = $data[$district]['thanas'];
        asort($thanas);
        wp_send_json_success($thanas);
    }

    /**
     * Show delivery info (read-only) before payment section.
     */
    public static function delivery_info_display() {
        $inside_fee  = (int) get_option('tot_inside_dhaka_fee', 80);
        $outside_fee = (int) get_option('tot_outside_dhaka_fee', 150);
        $delivery_area = WC()->session->get('delivery_area');
        ?>
        <div class="tot-delivery-info" id="tot-delivery-info">
            <?php if ($delivery_area === 'inside') : ?>
                <div class="tot-delivery-badge tot-delivery-inside">
                    <span class="tot-delivery-label"><?php esc_html_e('Delivery Inside Dhaka', 'deshi-ecom'); ?></span>
                    <span class="tot-delivery-fee">৳<?php echo esc_html($inside_fee); ?></span>
                </div>
                <p class="tot-delivery-time"><?php esc_html_e('Estimated delivery: 2-3 business days', 'deshi-ecom'); ?></p>
            <?php elseif ($delivery_area === 'outside') : ?>
                <div class="tot-delivery-badge tot-delivery-outside">
                    <span class="tot-delivery-label"><?php esc_html_e('Delivery Outside Dhaka', 'deshi-ecom'); ?></span>
                    <span class="tot-delivery-fee">৳<?php echo esc_html($outside_fee); ?></span>
                </div>
                <p class="tot-delivery-time"><?php esc_html_e('Estimated delivery: 3-5 business days', 'deshi-ecom'); ?></p>
            <?php else : ?>
                <div class="tot-delivery-badge tot-delivery-pending">
                    <span class="tot-delivery-label"><?php esc_html_e('Select a district to see delivery charge', 'deshi-ecom'); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Register delivery info badge as a WC checkout fragment.
     */
    public static function delivery_info_fragment($fragments) {
        ob_start();
        self::delivery_info_display();
        $fragments['#tot-delivery-info'] = ob_get_clean();
        return $fragments;
    }

    /**
     * Checkout page scripts: district → thana AJAX, auto delivery area.
     */
    public static function checkout_scripts() {
        if (!is_checkout()) {
            return;
        }

        $inside_fee  = (int) get_option('tot_inside_dhaka_fee', 80);
        $outside_fee = (int) get_option('tot_outside_dhaka_fee', 150);
        ?>
        <script>
        jQuery(function($){
            var insideFee = <?php echo $inside_fee; ?>;
            var outsideFee = <?php echo $outside_fee; ?>;

            // Fix: Destroy NiceSelect on our custom fields (Organio theme applies it to all selects)
            function totFixSelects() {
                var $district = $('#billing_district');
                var $thana = $('#billing_thana');

                // Destroy NiceSelect if applied
                if ($.fn.niceSelect) {
                    $district.niceSelect('destroy');
                    $thana.niceSelect('destroy');
                }

                // Remove any disabled/readonly attributes
                $district.prop('disabled', false).prop('readonly', false).removeAttr('disabled').removeAttr('readonly');
                $thana.prop('disabled', false).prop('readonly', false).removeAttr('disabled').removeAttr('readonly');

                // Remove NiceSelect wrapper leftovers if any
                $district.closest('.nice-select').length && $district.unwrap();
                $thana.closest('.nice-select').length && $thana.unwrap();
                $district.show();
                $thana.show();
            }

            // Run immediately + after checkout updates
            setTimeout(totFixSelects, 100);
            setTimeout(totFixSelects, 500);
            $(document.body).on('updated_checkout', function() {
                setTimeout(totFixSelects, 100);
            });

            // Update delivery info badge in DOM
            function totUpdateDeliveryBadge(area) {
                var $info = $('#tot-delivery-info');
                if (!$info.length) return;

                if (area === 'inside') {
                    $info.html(
                        '<div class="tot-delivery-badge tot-delivery-inside">' +
                            '<span class="tot-delivery-label"><?php echo esc_js(__('Delivery Inside Dhaka', 'deshi-ecom')); ?></span>' +
                            '<span class="tot-delivery-fee">৳' + insideFee + '</span>' +
                        '</div>' +
                        '<p class="tot-delivery-time"><?php echo esc_js(__('Estimated delivery: 2-3 business days', 'deshi-ecom')); ?></p>'
                    );
                } else if (area === 'outside') {
                    $info.html(
                        '<div class="tot-delivery-badge tot-delivery-outside">' +
                            '<span class="tot-delivery-label"><?php echo esc_js(__('Delivery Outside Dhaka', 'deshi-ecom')); ?></span>' +
                            '<span class="tot-delivery-fee">৳' + outsideFee + '</span>' +
                        '</div>' +
                        '<p class="tot-delivery-time"><?php echo esc_js(__('Estimated delivery: 3-5 business days', 'deshi-ecom')); ?></p>'
                    );
                } else {
                    $info.html(
                        '<div class="tot-delivery-badge tot-delivery-pending">' +
                            '<span class="tot-delivery-label"><?php echo esc_js(__('Select a district to see delivery charge', 'deshi-ecom')); ?></span>' +
                        '</div>'
                    );
                }
            }

            // Load thanas for a given district
            function totLoadThanas(district, selectedThana) {
                var $thanaSelect = $('#billing_thana, select[name="billing_thana"]');
                var $deliveryHidden = $('input[name="delivery_area"]');

                if (!district) {
                    $thanaSelect.html('<option value=""><?php echo esc_js(__('Select District first', 'deshi-ecom')); ?></option>');
                    $deliveryHidden.val('');
                    totUpdateDeliveryBadge('');
                    return;
                }

                // Set delivery area: Dhaka = inside, others = outside
                var area = (district === 'dhaka') ? 'inside' : 'outside';
                $deliveryHidden.val(area);
                totUpdateDeliveryBadge(area);

                // Load thanas via AJAX
                $thanaSelect.html('<option value=""><?php echo esc_js(__('Loading...', 'deshi-ecom')); ?></option>');

                $.ajax({
                    url: tot_vars.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'tot_get_thanas',
                        district: district
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            var options = '<option value=""><?php echo esc_js(__('Select Area / Thana', 'deshi-ecom')); ?></option>';
                            $.each(response.data, function(slug, name) {
                                var selected = (selectedThana && slug === selectedThana) ? ' selected' : '';
                                options += '<option value="' + slug + '"' + selected + '>' + name + '</option>';
                            });
                            $thanaSelect.html(options);
                        } else {
                            $thanaSelect.html('<option value=""><?php echo esc_js(__('No areas found', 'deshi-ecom')); ?></option>');
                        }
                    },
                    error: function() {
                        $thanaSelect.html('<option value=""><?php echo esc_js(__('Error loading areas', 'deshi-ecom')); ?></option>');
                    }
                });
            }

            // District change → load thanas + set delivery area
            $('form.checkout').on('change', '#billing_district, select[name="billing_district"]', function(){
                totLoadThanas($(this).val(), '');
                $('body').trigger('update_checkout');
            });

            // On page load: if district is pre-selected, load its thanas
            function totInitDistrict() {
                var $district = $('#billing_district, select[name="billing_district"]');
                var districtVal = $district.val();
                if (districtVal) {
                    var savedThana = $district.data('saved-thana') || '';
                    totLoadThanas(districtVal, savedThana);
                    $('body').trigger('update_checkout');
                }
            }

            setTimeout(totInitDistrict, 300);
            $(document.body).on('updated_checkout', function() {
                setTimeout(totFixSelects, 100);
            });
        });
        </script>
        <?php
    }

    /**
     * Get all 64 districts as select options.
     */
    private static function get_district_options() {
        require_once TOT_PLUGIN_DIR . 'includes/data-bangladesh.php';
        $data = tot_get_bangladesh_data();

        $districts = array();
        foreach ($data as $slug => $district) {
            $districts[$slug] = $district['label'];
        }
        asort($districts);

        $options = array('' => __('Select District', 'deshi-ecom'));
        foreach ($districts as $slug => $label) {
            $options[$slug] = $label;
        }

        return $options;
    }
}
