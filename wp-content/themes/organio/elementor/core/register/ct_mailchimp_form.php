<?php
ct_add_custom_widget(
    array(
        'name' => 'ct_mailchimp_form',
        'title' => esc_html__('Case Mailchimp Form', 'organio'),
        'icon' => 'eicon-email-field',
        'categories' => array(Case_Theme_Core::CT_CATEGORY_NAME),
        'scripts' => array(),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'source_section',
                    'label' => esc_html__('Color Settings', 'organio'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'controls' => array(
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'style1' => 'Style 1',
                                'style2' => 'Style 2',
                                'style3' => 'Style 3',
                            ],
                            'default' => 'style1',
                        ),
                        array(
                            'name' => 'title',
                            'label' => esc_html__('Title', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'condition' => [
                                'style' => ['style2','style3'],
                            ],
                        ),
                        array(
                            'name' => 'title_typography',
                            'label' => esc_html__('Title Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-mailchimp1 .ct-mailchimp-meta .wg-title',
                            'condition' => [
                                'style' => ['style2','style3'],
                            ],
                        ),

                        array(
                            'name' => 'description_text',
                            'label' => esc_html__('Description', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXTAREA,
                            'placeholder' => esc_html__('Enter your description', 'organio' ),
                            'rows' => 10,
                            'show_label' => false,
                            'condition' => [
                                'style' => ['style3'],
                            ],
                        ),

                        array(
                            'name' => 'box_image_left',
                            'label' => esc_html__( 'Box Image Left', 'organio' ),
                            'type' => \Elementor\Controls_Manager::MEDIA,
                            'condition' => [
                                'style' => ['style2'],
                            ],
                        ),
                        array(
                            'name' => 'box_image',
                            'label' => esc_html__( 'Box Background Image', 'organio' ),
                            'type' => \Elementor\Controls_Manager::MEDIA,
                            'condition' => [
                                'style' => ['style2'],
                            ],
                        ),
                        array(
                            'name' => 'box_bg_color',
                            'label' => esc_html__('Box Background Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-mailchimp1.style2' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'style' => ['style2'],
                            ],
                        ),
                        array(
                            'name' => 'input_color',
                            'label' => esc_html__('Input Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-mailchimp.ct-mailchimp1 .mc4wp-form .mc4wp-form-fields input' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'input_bg_color',
                            'label' => esc_html__('Input Background Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-mailchimp.ct-mailchimp1 .mc4wp-form .mc4wp-form-fields input' => 'background-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'input_border_color',
                            'label' => esc_html__('Input Focus Border Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-mailchimp1.style1 .mc4wp-form .mc4wp-form-fields input[type="email"], {{WRAPPER}} .ct-mailchimp1.style1 .mc4wp-form .mc4wp-form-fields input[type="text"]' => 'border-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'input_focus_border_color',
                            'label' => esc_html__('Input Focus Border Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-mailchimp1.style1 .mc4wp-form .mc4wp-form-fields input[type="email"]:focus, {{WRAPPER}} .ct-mailchimp1.style1 .mc4wp-form .mc4wp-form-fields input[type="text"]:focus' => 'border-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'button_icon_color',
                            'label' => esc_html__('Button Icon Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-mailchimp1.style1 .mc4wp-form .mc4wp-form-fields::after' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'button_bg_color',
                            'label' => esc_html__('Button Background Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-mailchimp.ct-mailchimp1 .mc4wp-form .mc4wp-form-fields:before' => 'background: {{VALUE}};',
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);