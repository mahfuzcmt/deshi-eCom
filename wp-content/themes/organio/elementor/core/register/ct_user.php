<?php
// Register Icon Box Widget
ct_add_custom_widget(
    array(
        'name' => 'ct_user',
        'title' => esc_html__('Case User', 'organio' ),
        'icon' => 'eicon-user-circle-o',
        'categories' => array( Case_Theme_Core::CT_CATEGORY_NAME ),
        'scripts' => array(),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'user_type',
                            'label' => esc_html__('User Type', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'sign-in' => 'Sign In',
                                'sign-up' => 'Sign Up',
                            ],
                            'default' => 'sign-in',
                        ),
                        array(
                            'name' => 'title',
                            'label' => esc_html__('Title', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                        ),
                        array(
                            'name' => 'btn_label',
                            'label' => esc_html__('Button Label', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'btn_text',
                            'label' => esc_html__('Button Text', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'btn_link',
                            'label' => esc_html__('Button Link', 'organio' ),
                            'type' => \Elementor\Controls_Manager::URL,
                        ),
                        array(
                            'name' => 'footer_text',
                            'label' => esc_html__('Footer Text', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'footer_link',
                            'label' => esc_html__('Footer Link', 'organio' ),
                            'type' => \Elementor\Controls_Manager::URL,
                        ),
                        array(
                            'name' => 'footer_link_color',
                            'label' => esc_html__('Footer Link Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-user .ct-user-footer a' => 'color: {{VALUE}};',
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