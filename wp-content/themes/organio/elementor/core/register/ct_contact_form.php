<?php

// Register Contact Form 7 Widget
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


    ct_add_custom_widget(
        array(
            'name' => 'ct_contact_form',
            'title' => esc_html__('Case Contact Form', 'organio'),
            'icon' => 'eicon-form-horizontal',
            'categories' => array(Case_Theme_Core::CT_CATEGORY_NAME),
            'scripts' => array(
                'jquery-ui-slider',
            ),
            'params' => array(
                'sections' => array(
                    array(
                        'name' => 'source_section',
                        'label' => esc_html__('Source Settings', 'organio'),
                        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                        'controls' => array(
                            array(
                                'name' => 'form_id',
                                'label' => esc_html__('Select Form', 'organio'),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'options' => $contact_forms,
                            ),
                            array(
                                'name' => 'sub_title',
                                'label' => esc_html__('Sub Title', 'organio' ),
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'condition' => [
                                    'style' => ['n'],
                                ],
                            ),
                            array(
                                'name' => 'title',
                                'label' => esc_html__('Title', 'organio' ),
                                'type' => \Elementor\Controls_Manager::TEXT,
                                'label_block' => true,
                                'condition' => [
                                    'style' => ['n'],
                                ],
                            ),
                            array(
                                'name' => 'description',
                                'label' => esc_html__('Description', 'organio' ),
                                'type' => \Elementor\Controls_Manager::TEXTAREA,
                                'rows' => 10,
                                'show_label' => false,
                                'condition' => [
                                    'style' => ['n'],
                                ],
                            ),
                            array(
                                'name' => 'style',
                                'label' => esc_html__('Style', 'organio' ),
                                'type' => \Elementor\Controls_Manager::SELECT,
                                'options' => [
                                    'style1' => 'Style 1',
                                    'style2' => 'Style 2',
                                ],
                                'default' => 'style1',
                            ),
                            array(
                                'name' => 'title_color',
                                'label' => esc_html__('Title Color', 'organio' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .ct-contact-form .ct-contact-meta h3' => 'color: {{VALUE}};',
                                ],
                                'condition' => [
                                    'style' => ['n'],
                                ],
                            ),
                            array(
                                'name' => 'title_typography',
                                'label' => esc_html__('Title Typography', 'organio' ),
                                'type' => \Elementor\Group_Control_Typography::get_type(),
                                'control_type' => 'group',
                                'selector' => '{{WRAPPER}} .ct-contact-form .ct-contact-meta h3',
                                'condition' => [
                                    'style' => ['n'],
                                ],
                            ),
                            array(
                                'name' => 'desc_color',
                                'label' => esc_html__('Description Color', 'organio' ),
                                'type' => \Elementor\Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .ct-contact-form .ct-contact-meta p' => 'color: {{VALUE}};',
                                ],
                                'condition' => [
                                    'style' => ['n'],
                                ],
                            ),
                            array(
                                'name' => 'desc_typography',
                                'label' => esc_html__('Description Typography', 'organio' ),
                                'type' => \Elementor\Group_Control_Typography::get_type(),
                                'control_type' => 'group',
                                'selector' => '{{WRAPPER}} .ct-contact-form .ct-contact-meta p',
                                'condition' => [
                                    'style' => ['n'],
                                ],
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
}