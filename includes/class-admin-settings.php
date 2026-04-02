<?php
/**
 * Admin Settings Page for Deshi eCom.
 *
 * @package DeshiEcom
 */

defined('ABSPATH') || exit;

class TOT_Admin_Settings {

    public static function init() {
        add_action('admin_menu', array(__CLASS__, 'add_menu'));
        add_action('admin_init', array(__CLASS__, 'register_settings'));
    }

    public static function add_menu() {
        add_menu_page(
            'Deshi eCom',
            'Deshi eCom',
            'manage_options',
            'deshi-ecom',
            array(__CLASS__, 'settings_page'),
            'dashicons-store',
            58
        );
    }

    public static function register_settings() {
        // Delivery
        register_setting('tot_settings', 'tot_inside_dhaka_fee', array('type' => 'number', 'sanitize_callback' => 'absint'));
        register_setting('tot_settings', 'tot_outside_dhaka_fee', array('type' => 'number', 'sanitize_callback' => 'absint'));
        register_setting('tot_settings', 'tot_dhaka_suburban_fee', array('type' => 'number', 'sanitize_callback' => 'absint'));
        register_setting('tot_settings', 'tot_dhaka_suburban_thanas', array(
            'type' => 'array',
            'sanitize_callback' => array(__CLASS__, 'sanitize_suburban_thanas'),
        ));

        // SMS (Falcon Communication Ltd)
        register_setting('tot_settings', 'tot_sms_bearer_token', array('type' => 'string', 'sanitize_callback' => 'sanitize_text_field'));
        register_setting('tot_settings', 'tot_sms_enabled', array('type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean'));
        register_setting('tot_settings', 'tot_sms_skip_if_email', array('type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean'));

        // WhatsApp
        register_setting('tot_settings', 'tot_whatsapp_url', array('type' => 'string', 'sanitize_callback' => 'esc_url_raw'));
        register_setting('tot_settings', 'tot_whatsapp_enabled', array('type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean'));

        // Support
        register_setting('tot_settings', 'tot_support_phone', array('type' => 'string', 'sanitize_callback' => 'sanitize_text_field'));

        // Online payment discount
        register_setting('tot_settings', 'tot_online_payment_discount', array('type' => 'number', 'sanitize_callback' => 'absint'));
        register_setting('tot_settings', 'tot_online_discount_enabled', array('type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean'));

        // Search animation
        register_setting('tot_settings', 'tot_search_animation_texts', array('type' => 'string', 'sanitize_callback' => 'sanitize_textarea_field'));
        register_setting('tot_settings', 'tot_search_animation_enabled', array('type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean'));

        // Invoice
        register_setting('tot_settings', 'tot_invoice_enabled', array('type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean'));

        // Email
        register_setting('tot_settings', 'tot_custom_emails_enabled', array('type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean'));
        register_setting('tot_settings', 'tot_followup_email_days', array('type' => 'number', 'sanitize_callback' => 'absint'));
        register_setting('tot_settings', 'tot_facebook_review_url', array('type' => 'string', 'sanitize_callback' => 'esc_url_raw'));
    }

    public static function settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1>Deshi eCom Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('tot_settings'); ?>

                <h2 class="nav-tab-wrapper">
                    <a href="#delivery" class="nav-tab nav-tab-active" onclick="totSwitchTab(event,'delivery')">Delivery</a>
                    <a href="#sms" class="nav-tab" onclick="totSwitchTab(event,'sms')">SMS</a>
                    <a href="#whatsapp" class="nav-tab" onclick="totSwitchTab(event,'whatsapp')">WhatsApp</a>
                    <a href="#discount" class="nav-tab" onclick="totSwitchTab(event,'discount')">Payment Discount</a>
                    <a href="#search" class="nav-tab" onclick="totSwitchTab(event,'search')">Search Animation</a>
                    <a href="#invoice" class="nav-tab" onclick="totSwitchTab(event,'invoice')">Invoice</a>
                    <a href="#emails" class="nav-tab" onclick="totSwitchTab(event,'emails')">Emails</a>
                </h2>

                <!-- Delivery Tab -->
                <div id="tot-tab-delivery" class="tot-tab-content">
                    <table class="form-table">
                        <tr>
                            <th>Inside Dhaka Fee (&#2547;)</th>
                            <td><input type="number" name="tot_inside_dhaka_fee" value="<?php echo esc_attr(get_option('tot_inside_dhaka_fee', 80)); ?>" min="0" /></td>
                        </tr>
                        <tr>
                            <th>Outside Dhaka Fee (&#2547;)</th>
                            <td><input type="number" name="tot_outside_dhaka_fee" value="<?php echo esc_attr(get_option('tot_outside_dhaka_fee', 150)); ?>" min="0" /></td>
                        </tr>
                        <tr>
                            <th>Dhaka Suburban Fee (&#2547;)</th>
                            <td>
                                <input type="number" name="tot_dhaka_suburban_fee" value="<?php echo esc_attr(get_option('tot_dhaka_suburban_fee', 150)); ?>" min="0" />
                                <p class="description">Delivery fee for excluded Dhaka thanas listed below.</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Dhaka Suburban Thanas</th>
                            <td>
                                <?php
                                    require_once TOT_PLUGIN_DIR . 'includes/data-bangladesh.php';
                                    $bd_data = tot_get_bangladesh_data();
                                    $dhaka_thanas = isset($bd_data['dhaka']['thanas']) ? $bd_data['dhaka']['thanas'] : array();
                                    asort($dhaka_thanas);
                                    $selected = get_option('tot_dhaka_suburban_thanas', array('savar', 'keraniganj', 'dohar', 'nawabganj_dhk'));
                                    if (!is_array($selected)) {
                                        $selected = array_filter(array_map('trim', explode("\n", $selected)));
                                    }
                                ?>
                                <select name="tot_dhaka_suburban_thanas[]" multiple="multiple" style="min-width:350px;min-height:200px;">
                                    <?php foreach ($dhaka_thanas as $slug => $label) : ?>
                                        <option value="<?php echo esc_attr($slug); ?>" <?php echo in_array($slug, $selected) ? 'selected' : ''; ?>><?php echo esc_html($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description">Hold <strong>Ctrl</strong> (or <strong>Cmd</strong> on Mac) to select multiple thanas. These Dhaka thanas will be charged the suburban fee.</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Support Phone</th>
                            <td><input type="text" name="tot_support_phone" value="<?php echo esc_attr(get_option('tot_support_phone', '01875906277')); ?>" /></td>
                        </tr>
                    </table>
                </div>

                <!-- SMS Tab -->
                <div id="tot-tab-sms" class="tot-tab-content" style="display:none;">
                    <table class="form-table">
                        <tr>
                            <th>Enable SMS Notifications</th>
                            <td><input type="checkbox" name="tot_sms_enabled" value="1" <?php checked(get_option('tot_sms_enabled', 0)); ?> /></td>
                        </tr>
                        <tr>
                            <th>Bearer Token (Falcon Communication)</th>
                            <td>
                                <textarea name="tot_sms_bearer_token" rows="3" class="large-text code"><?php echo esc_textarea(get_option('tot_sms_bearer_token', '')); ?></textarea>
                                <p class="description">JWT Bearer Token from Falcon Communication Ltd. API: <code>sms.falconcommunicationltd.com</code></p>
                            </td>
                        </tr>
                        <tr>
                            <th>Skip SMS if Email Available</th>
                            <td>
                                <input type="checkbox" name="tot_sms_skip_if_email" value="1" <?php checked(get_option('tot_sms_skip_if_email', 0)); ?> />
                                <p class="description">Do not send SMS if the customer has an email address (they will receive an email invoice instead).</p>
                            </td>
                        </tr>
                        <tr>
                            <th>Test SMS</th>
                            <td>
                                <input type="text" id="tot-test-phone" placeholder="01XXXXXXXXX" style="width:200px;" />
                                <button type="button" id="tot-test-sms-btn" class="button button-secondary">Send Test SMS</button>
                                <span id="tot-test-sms-result" style="margin-left:10px;"></span>
                                <p class="description">Enter a phone number and click to test your SMS configuration.</p>
                                <script>
                                document.getElementById('tot-test-sms-btn').addEventListener('click', function(){
                                    var phone = document.getElementById('tot-test-phone').value;
                                    var result = document.getElementById('tot-test-sms-result');
                                    if (!phone) { result.innerHTML = '<span style="color:red;">Enter a phone number</span>'; return; }
                                    result.innerHTML = 'Sending...';
                                    var data = new FormData();
                                    data.append('action', 'tot_test_sms');
                                    data.append('phone', phone);
                                    fetch(ajaxurl, { method: 'POST', body: data })
                                        .then(function(r){ return r.json(); })
                                        .then(function(r){
                                            if (r.success) {
                                                result.innerHTML = '<span style="color:green;">' + r.data + '</span>';
                                            } else {
                                                result.innerHTML = '<span style="color:red;">' + r.data + '</span>';
                                            }
                                        })
                                        .catch(function(e){ result.innerHTML = '<span style="color:red;">Error: ' + e.message + '</span>'; });
                                });
                                </script>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- WhatsApp Tab -->
                <div id="tot-tab-whatsapp" class="tot-tab-content" style="display:none;">
                    <table class="form-table">
                        <tr>
                            <th>Enable WhatsApp Button</th>
                            <td><input type="checkbox" name="tot_whatsapp_enabled" value="1" <?php checked(get_option('tot_whatsapp_enabled', 1)); ?> /></td>
                        </tr>
                        <tr>
                            <th>WhatsApp URL</th>
                            <td><input type="url" name="tot_whatsapp_url" value="<?php echo esc_attr(get_option('tot_whatsapp_url', 'https://wa.me/message/7GWAUHQZ3RV6G1')); ?>" class="regular-text" /></td>
                        </tr>
                    </table>
                </div>

                <!-- Discount Tab -->
                <div id="tot-tab-discount" class="tot-tab-content" style="display:none;">
                    <table class="form-table">
                        <tr>
                            <th>Enable Online Payment Discount</th>
                            <td><input type="checkbox" name="tot_online_discount_enabled" value="1" <?php checked(get_option('tot_online_discount_enabled', 1)); ?> /></td>
                        </tr>
                        <tr>
                            <th>Discount Percentage (%)</th>
                            <td><input type="number" name="tot_online_payment_discount" value="<?php echo esc_attr(get_option('tot_online_payment_discount', 5)); ?>" min="0" max="100" /></td>
                        </tr>
                    </table>
                </div>

                <!-- Search Animation Tab -->
                <div id="tot-tab-search" class="tot-tab-content" style="display:none;">
                    <table class="form-table">
                        <tr>
                            <th>Enable Search Animation</th>
                            <td><input type="checkbox" name="tot_search_animation_enabled" value="1" <?php checked(get_option('tot_search_animation_enabled', 1)); ?> /></td>
                        </tr>
                        <tr>
                            <th>Animation Texts (one per line)</th>
                            <td><textarea name="tot_search_animation_texts" rows="6" class="large-text"><?php echo esc_textarea(get_option('tot_search_animation_texts', "Search Products...\nHappy Noz Kids Formula\nAuthentic Thai Wellness\nFree delivery inside Dhaka!")); ?></textarea>
                            <p class="description">Enter one placeholder text per line. They will cycle as a typing animation.</p></td>
                        </tr>
                    </table>
                </div>

                <!-- Invoice Tab -->
                <div id="tot-tab-invoice" class="tot-tab-content" style="display:none;">
                    <table class="form-table">
                        <tr>
                            <th>Enable Invoice Download</th>
                            <td><input type="checkbox" name="tot_invoice_enabled" value="1" <?php checked(get_option('tot_invoice_enabled', 1)); ?> /></td>
                        </tr>
                    </table>
                </div>

                <!-- Emails Tab -->
                <div id="tot-tab-emails" class="tot-tab-content" style="display:none;">
                    <table class="form-table">
                        <tr>
                            <th>Enable Custom Email Templates</th>
                            <td><input type="checkbox" name="tot_custom_emails_enabled" value="1" <?php checked(get_option('tot_custom_emails_enabled', 1)); ?> /></td>
                        </tr>
                        <tr>
                            <th>Follow-up Email After (days)</th>
                            <td><input type="number" name="tot_followup_email_days" value="<?php echo esc_attr(get_option('tot_followup_email_days', 7)); ?>" min="1" max="30" />
                            <p class="description">Days after order completion to send the "Care &amp; Quality" follow-up email.</p></td>
                        </tr>
                        <tr>
                            <th>Facebook Review Page URL</th>
                            <td><input type="url" name="tot_facebook_review_url" value="<?php echo esc_attr(get_option('tot_facebook_review_url', '')); ?>" class="regular-text" /></td>
                        </tr>
                    </table>
                </div>

                <?php submit_button(); ?>
            </form>
        </div>

        <script>
        function totSwitchTab(e, tab) {
            e.preventDefault();
            document.querySelectorAll('.tot-tab-content').forEach(function(el){ el.style.display='none'; });
            document.querySelectorAll('.nav-tab').forEach(function(el){ el.classList.remove('nav-tab-active'); });
            document.getElementById('tot-tab-'+tab).style.display='block';
            e.target.classList.add('nav-tab-active');
        }
        </script>
        <?php
    }

    /**
     * Sanitize suburban thanas array.
     */
    public static function sanitize_suburban_thanas($input) {
        if (!is_array($input)) {
            return array();
        }
        return array_map('sanitize_text_field', $input);
    }
}
