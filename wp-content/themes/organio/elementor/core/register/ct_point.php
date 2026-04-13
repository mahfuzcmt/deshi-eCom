<?php
// Register Point Widget
ct_add_custom_widget(
    array(
        'name' => 'ct_point',
        'title' => esc_html__('Case Point', 'organio' ),
        'icon' => 'eicon-cursor-move',
        'categories' => array( Case_Theme_Core::CT_CATEGORY_NAME ),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'content_section',
                    'label' => esc_html__('Source Settings', 'organio'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'box_height',
                            'label' => esc_html__('Box Height', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 3000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ct-point' => 'height: {{SIZE}}{{UNIT}};',
                            ],
                        ),
                        array(
                            'name' => 'item_list',
                            'label' => esc_html__('Items', 'organio'),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'default' => [],
                            'controls' => array(
                                array(
                                    'name' => 'point_icon',
                                    'label' => esc_html__('Point Icon', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::ICONS,
                                    'fa4compatibility' => 'icon',
                                ),
                                array(
                                    'name' => 'title',
                                    'label' => esc_html__('Title', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                ),
                                array(
                                    'name' => 'desc',
                                    'label' => esc_html__('Description', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                                    'rows' => 10,
                                    'show_label' => false,
                                ),
                                array(
                                    'name' => 'top_positioon',
                                    'label' => esc_html__('Top Position', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SLIDER,
                                    'size_units' => [ '%' ],
                                    'default' => [
                                        'size' => 0,
                                    ],
                                    'range' => [
                                        '%' => [
                                            'min' => 0,
                                            'max' => 100,
                                        ],
                                    ],
                                ),
                                array(
                                    'name' => 'left_positioon',
                                    'label' => esc_html__('Left Position', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SLIDER,
                                    'size_units' => [ '%' ],
                                    'default' => [
                                        'size' => 0,
                                    ],
                                    'range' => [
                                        '%' => [
                                            'min' => 0,
                                            'max' => 100,
                                        ],
                                    ],
                                ),
                                array(
                                    'name' => 'sm_md_pos',
                                    'label' => esc_html__('Content Position: Screen < 1199px', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'options' => [
                                        'md-left' => 'Left',
                                        'md-right' => 'Right',
                                    ],
                                    'default' => 'md-left',
                                ),
                            ),
                        ),
                        array(
                            'name' => 'ct_animate',
                            'label' => esc_html__('Case Animate', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => organio_animate(),
                            'default' => '',
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);