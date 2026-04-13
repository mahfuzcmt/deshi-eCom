<?php
ct_add_custom_widget(
    array(
        'name' => 'ct_portfolio_details',
        'title' => esc_html__('Case Portdolio Details', 'organio'),
        'icon' => 'eicon-library-upload',
        'categories' => array(Case_Theme_Core::CT_CATEGORY_NAME),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_content',
                    'label' => esc_html__('Content', 'organio'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'wg_title',
                            'label' => esc_html__('Widget Title', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'portfolio_content',
                            'label' => esc_html__('Content', 'organio'),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'controls' => array(
                                array(
                                    'name' => 'label',
                                    'label' => esc_html__('Label', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'label_block' => true,
                                ),
                                array(
                                    'name' => 'content',
                                    'label' => esc_html__('Content', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                ),
                            ),
                            'title_field' => '{{{ label }}}',
                        ),
                        array(
                            'name' => 'value_label',
                            'label' => esc_html__('Value Label', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'value_text',
                            'label' => esc_html__('Value Text', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);