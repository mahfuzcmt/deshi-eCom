<?php
$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
if ( is_array( $menus ) && ! empty( $menus ) ) {
    foreach ( $menus as $single_menu ) {
        if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
            $custom_menus[ $single_menu->slug ] = $single_menu->name;
        }
    }
} else {
    $custom_menus = '';
}
ct_add_custom_widget(
    array(
        'name' => 'ct_navigation_menu',
        'title' => esc_html__('Case Navigation', 'organio'),
        'icon' => 'eicon-menu-bar',
        'categories' => array(Case_Theme_Core::CT_CATEGORY_NAME),
        'scripts' => array(),
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'source_section',
                    'label' => esc_html__('Source Settings', 'organio'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'menu',
                            'label' => esc_html__('Select Menu', 'organio'),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => $custom_menus,
                        ),
                        array(
                            'name' => 'style',
                            'label' => esc_html__('Style', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'options' => [
                                'default' => 'Default',
                                'style1' => 'Style 1 (Light)',
                                'style2' => 'Style 2 (Dark)',
                                'style3' => 'Style 3 (Main Menu)',
                                'style4' => 'Style 4 (Light)',
                            ],
                            'default' => 'default',
                        ),
                        array(
                            'name' => 'link_color',
                            'label' => esc_html__('Link Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-navigation-menu1.style1 a' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .ct-navigation-menu1.style1 a span::before' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'style' => ['style1'],
                            ],
                        ),
                        array(
                            'name' => 'link_color_hover',
                            'label' => esc_html__('Link Color Hover', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-navigation-menu1.style1 a:hover' => 'color: {{VALUE}};',
                                '{{WRAPPER}} .ct-navigation-menu1.style1 a:hover span::before' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'style' => ['style1'],
                            ],
                        ),
                        array(
                            'name' => 'link_typography',
                            'label' => esc_html__('Link Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-navigation-menu1 li a',
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);