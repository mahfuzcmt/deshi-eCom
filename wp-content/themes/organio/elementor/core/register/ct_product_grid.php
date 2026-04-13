<?php
// Post term options
$post_term_options = ct_get_grid_term_options('product');

// Register Post Grid Widget
ct_add_custom_widget(
    array(
        'name' => 'ct_product_grid',
        'title' => esc_html__('Case Products Grid', 'organio' ),
        'icon' => 'eicon-cart-medium',
        'categories' => array( Case_Theme_Core::CT_CATEGORY_NAME ),
        'scripts' => [
            'imagesloaded',
            'isotope',
            'ct-post-masonry-widget-js',
            'ct-post-grid-widget-js',
        ],
        'params' => array(
            'sections' => array(
                array(
                    'name' => 'layout_section',
                    'label' => esc_html__('Layout', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_LAYOUT,
                    'controls' => array(
                        array(
                            'name' => 'layout',
                            'label' => esc_html__('Templates', 'organio' ),
                            'type' => Case_Theme_Core::LAYOUT_CONTROL,
                            'default' => '1',
                            'options' => [
                                '1' => [
                                    'label' => esc_html__('Layout 1', 'organio' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/ct_product_grid/layout-image/layout1.jpg'
                                ],
                                '2' => [
                                    'label' => esc_html__('Layout 2', 'organio' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/ct_product_grid/layout-image/layout2.jpg'
                                ],
                                '3' => [
                                    'label' => esc_html__('Layout 3', 'organio' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/ct_product_grid/layout-image/layout3.jpg'
                                ],
                                '4' => [
                                    'label' => esc_html__('Layout 4', 'organio' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/ct_product_grid/layout-image/layout4.jpg'
                                ],
                                '5' => [
                                    'label' => esc_html__('Layout 5', 'organio' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/ct_product_grid/layout-image/layout5.jpg'
                                ],
                                '6' => [
                                    'label' => esc_html__('Layout 6', 'organio' ),
                                    'image' => get_template_directory_uri() . '/elementor/templates/widgets/ct_product_grid/layout-image/layout6.jpg'
                                ],
                            ],
                        ),
                    ),
                ),
                
                array(
                    'name' => 'source_section',
                    'label' => esc_html__('Source', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'source',
                            'label' => esc_html__('Select Categories', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT2,
                            'multiple' => true,
                            'options' => $post_term_options,
                        ),
                        array(
                            'name' => 'orderby',
                            'label' => esc_html__('Order By', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'date',
                            'options' => [
                                'date' => esc_html__('Date', 'organio' ),
                                'ID' => esc_html__('ID', 'organio' ),
                                'author' => esc_html__('Author', 'organio' ),
                                'title' => esc_html__('Title', 'organio' ),
                                'rand' => esc_html__('Random', 'organio' ),
                            ],
                        ),
                        array(
                            'name' => 'order',
                            'label' => esc_html__('Sort Order', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'desc',
                            'options' => [
                                'desc' => esc_html__('Descending', 'organio' ),
                                'asc' => esc_html__('Ascending', 'organio' ),
                            ],
                        ),
                        array(
                            'name' => 'limit',
                            'label' => esc_html__('Total items', 'organio' ),
                            'type' => \Elementor\Controls_Manager::NUMBER,
                            'default' => '6',
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
                array(
                    'name' => 'grid_section',
                    'label' => esc_html__('Grid Settings', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'controls' => array(
                        array(
                            'name' => 'show_quantity',
                            'label' => esc_html__('Show Quantity', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'no',
                            'options' => [
                                'no' => 'No',
                                'yes' => 'Yes',
                            ],
                            'condition' => [
                                'layout' => ['3','4'],
                            ],
                        ),
                        array(
                            'name' => 'show_rating_rate',
                            'label' => esc_html__('Show Rating Rate', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'yes',
                            'options' => [
                                'no' => 'No',
                                'yes' => 'Yes',
                            ],
                            'condition' => [
                                'layout' => '4',
                            ],
                        ),
                        array(
                            'name' => 'img_size',
                            'label' => esc_html__('Image Size', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'description' => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Default: 370x300 (Width x Height)).',
                        ),
                        array(
                            'name' => 'filter',
                            'label' => esc_html__('Filter on Masonry', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'false',
                            'options' => [
                                'true' => esc_html__('Enable', 'organio' ),
                                'false' => esc_html__('Disable', 'organio' ),
                            ],
                        ),
                        array(
                            'name' => 'filter_default_title',
                            'label' => esc_html__('Filter Default Title', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'default' => esc_html__('All', 'organio' ),
                            'condition' => [
                                'filter' => 'true',
                            ],
                        ),

                        array(
                            'name' => 'filter_icon',
                            'label' => esc_html__('Filter All Icon', 'organio' ),
                            'type' => \Elementor\Controls_Manager::ICONS,
                            'fa4compatibility' => 'icon',
                            'condition' => [
                                'filter' => 'true',
                                'layout' => '6',
                            ],
                        ),

                        array(
                            'name' => 'filter_alignment',
                            'label' => esc_html__('Filter Alignment', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'center',
                            'options' => [
                                'center' => esc_html__('Center', 'organio' ),
                                'left' => esc_html__('Left', 'organio' ),
                                'right' => esc_html__('Right', 'organio' ),
                            ],
                            'condition' => [
                                'filter' => 'true',
                            ],
                        ),
                        array(
                            'name' => 'filter_style',
                            'label' => esc_html__('Filter Style', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'filter-style1',
                            'options' => [
                                'filter-style1' => esc_html__('Style 1', 'organio' ),
                                'filter-style2' => esc_html__('Style 2', 'organio' ),
                                'filter-style3' => esc_html__('Style 3', 'organio' ),
                                'filter-style4' => esc_html__('Style 4', 'organio' ),
                            ],
                        ),
                        array(
                            'name' => 'pagination_type',
                            'label' => esc_html__('Pagination Type', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'false',
                            'options' => [
                                'pagination' => esc_html__('Pagination', 'organio' ),
                                'loadmore' => esc_html__('Loadmore', 'organio' ),
                                'false' => esc_html__('Disable', 'organio' ),
                            ],
                        ),
                        array(
                            'name' => 'col_xs',
                            'label' => esc_html__('Columns XS Devices', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '1',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'col_sm',
                            'label' => esc_html__('Columns SM Devices', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '2',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'col_md',
                            'label' => esc_html__('Columns MD Devices', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '3',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'col_lg',
                            'label' => esc_html__('Columns LG Devices', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '4',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'col_xl',
                            'label' => esc_html__('Columns XL Devices', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => '4',
                            'options' => [
                                '1' => '1',
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',
                                '6' => '6',
                            ],
                        ),
                        array(
                            'name' => 'grid_masonry',
                            'label' => esc_html__('Grid Masonry', 'organio'),
                            'type' => \Elementor\Controls_Manager::REPEATER,
                            'condition' => [
                                'layout' => ['1'],
                            ],
                            'controls' => array(
                                array(
                                    'name' => 'col_xs_m',
                                    'label' => esc_html__('Columns XS Devices', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '1',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'col_sm_m',
                                    'label' => esc_html__('Columns SM Devices', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '2',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'col_md_m',
                                    'label' => esc_html__('Columns MD Devices', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '3',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'col_lg_m',
                                    'label' => esc_html__('Columns LG Devices', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '4',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'col_xl_m',
                                    'label' => esc_html__('Columns XL Devices', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::SELECT,
                                    'default' => '4',
                                    'options' => [
                                        '1' => '1',
                                        '2' => '2',
                                        '3' => '3',
                                        '4' => '4',
                                        '6' => '6',
                                    ],
                                ),
                                array(
                                    'name' => 'img_size_m',
                                    'label' => esc_html__('Image Size', 'organio' ),
                                    'type' => \Elementor\Controls_Manager::TEXT,
                                    'description' => 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Default: 370x300 (Width x Height)).',
                                ),
                            ),
                        ),
                    ),
                ),
                array(
                    'name' => 'style_section_l5',
                    'label' => esc_html__('Style', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'condition' => [
                        'layout' => '5',
                    ],
                    'controls' => array(
                        array(
                            'name' => 'style_l5',
                            'label' => esc_html__('Style', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SELECT,
                            'default' => 'style1',
                            'options' => [
                                'style1' => esc_html__('Style 1', 'organio' ),
                                'style2' => esc_html__('Style 2', 'organio' ),
                            ],
                        ),
                        array(
                            'name' => 'button_bg_color',
                            'label' => esc_html__('Button Background Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .btn.btn-circle-plus::before' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'style_l5' => 'style2',
                            ],
                        ),
                        array(
                            'name' => 'button_bg_color_hover',
                            'label' => esc_html__('Button Background Color Hover', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .btn.btn-circle-plus:hover:before' => 'background-color: {{VALUE}};',
                            ],
                            'condition' => [
                                'style_l5' => 'style2',
                            ],
                        ),
                        array(
                            'name' => 'btn_readmore',
                            'label' => esc_html__('Button Readmore Text', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                            'condition' => [
                                'style_l5' => 'style2',
                            ],
                        ),
                    ),
                ),
                array(
                    'name' => 'product_banner',
                    'label' => esc_html__('Product Banner', 'organio' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'condition' => [
                        'layout' => '5',
                        'style_l5' => 'style2',
                    ],
                    'controls' => array(
                        array(
                            'name' => 'sub_title',
                            'label' => esc_html__('Sub Title', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'subtitle_color',
                            'label' => esc_html__('Sub Title Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-product-banner1 .item--subtitle' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'subtitle_typography',
                            'label' => esc_html__('Sub Title Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-product-banner1 .item--subtitle',
                        ),
                        array(
                            'name' => 'title',
                            'label' => esc_html__('Title', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'title_color',
                            'label' => esc_html__('Title Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-product-banner1 .item--title' => 'color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'title_typography',
                            'label' => esc_html__('Title Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-product-banner1 .item--title',
                        ),
                        array(
                            'name' => 'btn_text',
                            'label' => esc_html__('Button Text', 'organio' ),
                            'type' => \Elementor\Controls_Manager::TEXT,
                        ),
                        array(
                            'name' => 'btn_link',
                            'label' => esc_html__('Button Link', 'organio'),
                            'type' => \Elementor\Controls_Manager::URL,
                        ),
                        array(
                            'name' => 'sbutton_bg_color',
                            'label' => esc_html__('Button Background Color', 'organio' ),
                            'type' => \Elementor\Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .ct-product-banner1 .item--button .btn' => 'background-color: {{VALUE}};',
                            ],
                        ),
                        array(
                            'name' => 'button_typography',
                            'label' => esc_html__('Button Typography', 'organio' ),
                            'type' => \Elementor\Group_Control_Typography::get_type(),
                            'control_type' => 'group',
                            'selector' => '{{WRAPPER}} .ct-product-banner1 .item--button .btn',
                        ),
                        array(
                            'name' => 'image',
                            'label' => esc_html__( 'Image', 'organio' ),
                            'type' => \Elementor\Controls_Manager::MEDIA,
                        ),
                        array(
                            'name' => 'image_max_width',
                            'label' => esc_html__('Image Max Width', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ct-product-banner1 .item--image' => 'max-width: {{SIZE}}{{UNIT}} !important;',
                            ],
                        ),
                        array(
                            'name' => 'image_left_position',
                            'label' => esc_html__('Image Left Position', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ct-product-banner1 .item--image' => 'left: {{SIZE}}{{UNIT}} !important;',
                            ],
                        ),
                        array(
                            'name' => 'image_right_position',
                            'label' => esc_html__('Image Right Position', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ct-product-banner1 .item--image' => 'right: {{SIZE}}{{UNIT}} !important;',
                            ],
                        ),
                        array(
                            'name' => 'image_bottom_position',
                            'label' => esc_html__('Image Bottom Position', 'organio' ),
                            'type' => \Elementor\Controls_Manager::SLIDER,
                            'control_type' => 'responsive',
                            'size_units' => [ 'px' ],
                            'range' => [
                                'px' => [
                                    'min' => 0,
                                    'max' => 1000,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .ct-product-banner1 .item--image.animated' => 'bottom: {{SIZE}}{{UNIT}} !important;',
                            ],
                        ),
                        array(
                            'name' => 'box_padding',
                            'label' => esc_html__('Box Padding', 'organio' ),
                            'type' => \Elementor\Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px' ],
                            'selectors' => [
                                '{{WRAPPER}} .ct-product-banner1 .item--inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'control_type' => 'responsive',
                        ),
                    ),
                ),
            ),
        ),
    ),
    get_template_directory() . '/elementor/core/widgets/'
);