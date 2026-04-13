<?php
$elementor_templates = get_posts([
    'post_type' => 'elementor_library',
    'numberposts' => -1,
    'post_status' => 'publish',
]);
$elementor_templates_opt = [
    '' => esc_html__( 'Select Template', 'organio' ),
];
if($elementor_templates){
    foreach ($elementor_templates as $template) {
        $elementor_templates_opt[$template->ID] = $template->post_title;
    }
}
$contact_forms = '';
if(class_exists('WPCF7')) {
    $cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');

    $contact_forms = array();
    if ($cf7) {
        foreach ($cf7 as $cform) {
            $contact_forms[$cform->ID] = $cform->post_title;
        }
    } else {
        $contact_forms[esc_html__('No contact forms found', 'organio')] = 0;
    }
}
// Register Tabs Widget
ct_add_custom_widget(
    array(
        'name' => 'ct_tabs',
        'title' => esc_html__( 'Case Tabs', 'organio' ),
        'icon' => 'eicon-tabs',
        'categories' => array( Case_Theme_Core::CT_CATEGORY_NAME ),
        'scripts' => [
          'ct-tabs-widget-js',
        ],
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'section_tabs',
                    'label' => esc_html__( 'Tabs', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'active_tab',
                            'label' => esc_html__( 'Active Tab', 'organio' ),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'default' => 1,
                            'separator' => 'after',
                        ),
                        array(
                            'name' => 'tabs',
                            'label' => esc_html__( 'Tabs Items', 'organio' ),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'controls' => array(
                                array(
                                    'name' => 'ct_icon',
                                    'label' => esc_html__('Icon', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::ICONS,
                                    'fa4compatibility' => 'icon',
                                ),
                                array(
                                    'name' => 'tab_title',
                                    'label' => esc_html__( 'Title', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'default' => esc_html__( 'Tab Title', 'organio' ),
                                    'placeholder' => esc_html__( 'Tab Title', 'organio' ),
                                    'label_block' => true,
                                ),
                                array(
                                    'name' => 'content_type',
                                    'label' => esc_html__( 'Content Type', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => 'text_editor',
                                    'options' => [
                                        'text_editor' => esc_html__( 'Text Editor', 'organio' ),
                                        'template' => esc_html__( 'Template', 'organio' ),
                                    ],
                                ),
                                array(
                                    'name' => 'tab_content',
                                    'label' => esc_html__( 'Content', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::WYSIWYG,
                                    'default' => esc_html__( 'Tab Content', 'organio' ),
                                    'placeholder' => esc_html__( 'Tab Content', 'organio' ),
                                    'show_label' => false,
                                    'condition' => [
                                        'content_type' => 'text_editor'
                                    ],
                                ),
                                array(
                                    'name' => 'tab_content_template',
                                    'label' => esc_html__( 'Template', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '',
                                    'options' => $elementor_templates_opt,
                                    'condition' => [
                                        'content_type' => 'template'
                                    ],
                                ),
                                array(
                                    'name' => 'form_id',
                                    'label' => esc_html__('Select Contact Form 7', 'organio'),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'options' => $contact_forms,
                                    'condition' => [
                                        'content_type' => 'form'
                                    ],
                                ),
                            ),
                            'title_field' => '{{{ tab_title }}}',
                        ),
                        array(
                            'name' => 'tab_type',
                            'label' => esc_html__('Type', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'horizontal' => 'Horizontal',
                            ],
                            'default' => 'horizontal',
                            'condition' => [
                                'layout' => 'n'
                            ],
                        ),
                        array(
                            'name' => 'tab_style',
                            'label' => esc_html__('Style', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'style1' => 'Style 1',
                                'style2' => 'Style 2',
                            ],
                            'default' => 'style1',
                            'condition' => [
                                'tab_type' => 'horizontal'
                            ],
                        ),
                        array(
                            'name' => 'title_color',
                            'label' => esc_html__('Title Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-tabs .ct-tabs-title .ct-tab-title' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'title_active_color',
                            'label' => esc_html__('Title Active Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-tabs .ct-tabs-title .ct-tab-title.active' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'box_title_color',
                            'label' => esc_html__('Title Box Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-tabs .ct-tabs-title .ct-tab-title' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'tab_style' => 'style1'
                            ],
                        ),
                        array(
                            'name' => 'box_title_color_hover',
                            'label' => esc_html__('Title Box Color - Hover/Active', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-tabs--horizontal1 .ct-tabs-title .ct-tab-title:hover, {{WRAPPER}} .ct-tabs--horizontal1 .ct-tabs-title .ct-tab-title.active' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'tab_style' => 'style1'
                            ],
                        ),
                        array(
                            'name' => 'content_color',
                            'label' => esc_html__('Content Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-tabs .ct-tabs-content .ct-tab-content' => 'color: {{VALUE}};',
                            ],
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);