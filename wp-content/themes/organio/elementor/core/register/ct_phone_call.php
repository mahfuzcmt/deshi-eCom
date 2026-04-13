<?php
// Register Icon Box Widget
ct_add_custom_widget(
    array(
        'name' => 'ct_phone_call',
        'title' => esc_html__('Case Phone Call', 'organio' ),
        'icon' => 'eicon-headphones',
        'categories' => array( Case_Theme_Core::CT_CATEGORY_NAME ),
        'scripts' => array(

        ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'selected_icon',
                            'label' => esc_html__('Icon', 'organio' ),
                            'type' => \Elementor\Controls_Manager::ICONS,
                            'fa4compatibility' => 'icon',
                        ),
                        array(
                            'name' => 'phone_number',
                            'label' => esc_html__('Phone Number', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'phone_link',
                            'label' => esc_html__('Phone Link', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'phone_label',
                            'label' => esc_html__('Phone Label', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                    ),
                ),
                array(
                    'name' => 'section_style',
                    'label' => esc_html__('Style', 'organio'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'phone_number_color',
                            'label' => esc_html__('Phone Number Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-phone-call1 .item--meta a' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'number_typography',
                            'label' => esc_html__('Number Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-phone-call1 .item--meta a',
                        ),
                        array(
                            'name' => 'phone_label_color',
                            'label' => esc_html__('Phone Label Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-phone-call1 .item--meta label' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'label_typography',
                            'label' => esc_html__('Label Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-phone-call1 .item--meta label',
                        ),
                        array(
                            'name' => 'phone_icon_color',
                            'label' => esc_html__('Phone Icon Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-phone-call1 .item--icon' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'phone_icon_box_color',
                            'label' => esc_html__('Phone Icon Box Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-phone-call1 .item--icon' => 'background-color: {{VALUE}};',
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'section_animate',
                    'label' => esc_html__('Animate', 'organio'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'ct_animate',
                            'label' => esc_html__('Case Animate', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => organio_animate(),
                            'default' => '',
                        ),
                        array(
                            'name' => 'ct_animate_delay',
                            'label' => esc_html__('Animate Delay', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => '0',
                            'description' => 'Enter number. Default 0ms',
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);