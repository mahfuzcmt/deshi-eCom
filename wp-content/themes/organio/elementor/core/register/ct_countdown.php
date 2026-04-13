<?php
ct_add_custom_widget(
    array(
        'name' => 'ct_countdown',
        'title' => esc_html__('Case Countdown', 'organio' ),
        'icon' => 'eicon-countdown',
        'categories' => array( Case_Theme_Core::CT_CATEGORY_NAME ),
        'scripts' => array(
            'ct-countdown',
        ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'countdown_section',
                    'label' => esc_html__('Content', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Layout', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                '1' => 'Layout 1',
                                '2' => 'Layout 2',
                            ],
                            'default' => '1',
                        ),
                        array(
                            'name' => 'date',
                            'label' => esc_html__('Date', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'description' => esc_html__('Set date count down (Date format: yy/mm/dd)', 'organio'),
                        ),
                        array(
                            'name' => 'ct_day',
                            'label' => esc_html__('Day', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'show-day' => 'True',
                                'hide' => 'False',
                            ],
                            'default' => 'show-day',
                        ),
                        array(
                            'name' => 'ct_hour',
                            'label' => esc_html__('Hour', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'show-hour' => 'True',
                                'hide' => 'False',
                            ],
                            'default' => 'show-hour',
                        ),
                        array(
                            'name' => 'ct_minute',
                            'label' => esc_html__('Minute', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'show-minute' => 'True',
                                'hide' => 'False',
                            ],
                            'default' => 'show-minute',
                        ),
                        array(
                            'name' => 'ct_second',
                            'label' => esc_html__('Second', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'show-second' => 'True',
                                'hide' => 'False',
                            ],
                            'default' => 'show-second',
                        ),
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'style1' => 'Style 1',
                                'style2' => 'Style 2',
                                'style3' => 'Style 3',
                                'style4' => 'Style 4',
                                'style5' => 'Style 5',
                            ],
                            'default' => 'style1',
                            'condition' => [
                                'layout' => ['1'],
                            ],
                        ),
                        array(
                          'name' => 'align',
                            'label' => esc_html__( 'Alignment', 'organio' ),
                            'type' => \Elementor\Controls_Manager::CHOOSE,
                            'control_type' => 'responsive',
                            'options' => [
                                'flex-start' => [
                                    'title' => esc_html__( 'Left', 'organio' ),
                                    'icon' => 'eicon-text-align-left',
                                ],
                                'center' => [
                                    'title' => esc_html__( 'Center', 'organio' ),
                                    'icon' => 'eicon-text-align-center',
                                ],
                                'flex-end' => [
                                    'title' => esc_html__( 'Right', 'organio' ),
                                    'icon' => 'eicon-text-align-right',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ct-countdown-layout1' => 'justify-content: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'image',
                            'label' => esc_html__('Image', 'organio' ),
                            'type' => \Elementor\Controls_Manager::MEDIA,
                            'condition' => [
                                'layout' => ['2'],
                            ],
                        ),
                        array(
                            'name' => 'title',
                            'label' => esc_html__('Title', 'organio'),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'label_block' => true,
                            'condition' => [
                                'layout' => ['2'],
                            ],
                        ),
                        array(
                            'name' => 'sub_title',
                            'label' => esc_html__('Sub Title', 'organio'),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'condition' => [
                                'layout' => ['2'],
                            ],
                        ),
                        array(
                            'name' => 'title_color',
                            'label' => esc_html__('Title Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-countdown-banner1 .item--title' => 'color: {{VALUE}};',
                            ],
                            'condition' => [
                                'layout' => ['2'],
                            ],
                        ),
                        array(
                            'name' => 'title_typography',
                            'label' => esc_html__('Title Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-countdown-banner1 .item--title',
                            'condition' => [
                                'layout' => ['2'],
                            ],
                        ),
                        array(
                            'name' => 'subtitle_color',
                            'label' => esc_html__('Sub Title Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-countdown-banner1 .item--subtitle' => 'color: {{VALUE}};',
                            ],
                            'condition' => [
                                'layout' => ['2'],
                            ],
                        ),
                        array(
                            'name' => 'subtitle_typography',
                            'label' => esc_html__('Sub Title Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-countdown-banner1 .item--subtitle',
                            'condition' => [
                                'layout' => ['2'],
                            ],
                        ),
                        array(
                            'name' => 'countdown_text_typography',
                            'label' => esc_html__('Countdown Text Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-countdown .countdown-period',
                        ),
                        array(
                            'name' => 'countdown_number_typography',
                            'label' => esc_html__('Countdown Number Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-countdown .countdown-amount span',
                        ),
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