<?php
// Register Accordion Widget
ct_add_custom_widget(
    array(
        'name' => 'ct_accordion',
        'title' => esc_html__('Case Accordion', 'organio' ),
        'icon' => 'eicon-accordion',
        'categories' => array( Case_Theme_Core::CT_CATEGORY_NAME ),
        'scripts' => array(
            'ct-accordion-widget-js'
        ),
        'params' => array(
            'sections' => array(

                array(
                    'name' => 'source_section',
                    'label' => esc_html__('Source Settings', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Layout', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                '1' => 'Layout 1',
                                '2' => 'Layout 2',
                                '3' => 'Layout 3',
                            ],
                            'default' => '1',
                        ),
                        array(
                            'name' => 'active_section',
                            'label' => esc_html__('Active section', 'organio' ),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'separator' => 'after',
                            'default' => '1',
                        ),
                        array(
                            'name' => 'ct_accordion',
                            'label' => esc_html__('Accordion Items', 'organio' ),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'controls' => array(
                                array(
                                    'name' => 'ac_title',
                                    'label' => esc_html__('Title', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                ),
                                array(
                                    'name' => 'ac_content',
                                    'label' => esc_html__('Content', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::TEXTAREA,
                                    'rows' => 10,
                                ),
                            ),
                            'title_field' => '{{{ ac_title }}}',
                            'separator' => 'after',
                        ),
                        array(
                            'name' => 'title_typography',
                            'label' => esc_html__('Title Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-accordion .ct-accordion-item .ct-ac-title',
                        ),
                        array(
                            'name' => 'desc_typography',
                            'label' => esc_html__('Content Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-accordion .ct-accordion-item .ct-ac-content',
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