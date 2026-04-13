<?php
/**
 * Register metabox for posts based on Redux Framework. Supported methods:
 *     isset_args( $post_type )
 *     set_args( $post_type, $redux_args, $metabox_args )
 *     add_section( $post_type, $sections )
 * Each post type can contains only one metabox. Pease note that each field id
 * leads by an underscore sign ( _ ) in order to not show that into Custom Field
 * Metabox from WordPress core feature.
 *
 * @param  CT_Post_Metabox $metabox
 */

/**
 * Get list menu.
 * @return array
 */
function organio_get_nav_menu(){

    $menus = array(
        '' => esc_html__('Default', 'organio')
    );

    $obj_menus = wp_get_nav_menus();

    foreach ($obj_menus as $obj_menu){
        $menus[$obj_menu->term_id] = $obj_menu->name;
    }

    return $menus;
}

add_action( 'ct_post_metabox_register', 'organio_page_options_register' );

function organio_page_options_register( $metabox ) {

	if ( ! $metabox->isset_args( 'post' ) ) {
		$metabox->set_args( 'post', array(
			'opt_name'            => 'post_option',
			'display_name'        => esc_html__( 'Post Settings', 'organio' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'product' ) ) {
		$metabox->set_args( 'product', array(
			'opt_name'            => 'product_option',
			'display_name'        => esc_html__( 'Product Settings', 'organio' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'page' ) ) {
		$metabox->set_args( 'page', array(
			'opt_name'            => organio_get_page_opt_name(),
			'display_name'        => esc_html__( 'Page Settings', 'organio' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'ct_pf_audio' ) ) {
		$metabox->set_args( 'ct_pf_audio', array(
			'opt_name'     => 'post_format_audio',
			'display_name' => esc_html__( 'Audio', 'organio' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'ct_pf_link' ) ) {
		$metabox->set_args( 'ct_pf_link', array(
			'opt_name'     => 'post_format_link',
			'display_name' => esc_html__( 'Link', 'organio' )
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'ct_pf_quote' ) ) {
		$metabox->set_args( 'ct_pf_quote', array(
			'opt_name'     => 'post_format_quote',
			'display_name' => esc_html__( 'Quote', 'organio' )
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'ct_pf_video' ) ) {
		$metabox->set_args( 'ct_pf_video', array(
			'opt_name'     => 'post_format_video',
			'display_name' => esc_html__( 'Video', 'organio' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'ct_pf_gallery' ) ) {
		$metabox->set_args( 'ct_pf_gallery', array(
			'opt_name'     => 'post_format_gallery',
			'display_name' => esc_html__( 'Gallery', 'organio' ),
			'class'        => 'fully-expanded',
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	/* Extra Post Type */

	if ( ! $metabox->isset_args( 'service' ) ) {
		$metabox->set_args( 'service', array(
			'opt_name'            => 'service_option',
			'display_name'        => esc_html__( 'Service Settings', 'organio' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	if ( ! $metabox->isset_args( 'portfolio' ) ) {
		$metabox->set_args( 'portfolio', array(
			'opt_name'            => 'portfolio_option',
			'display_name'        => esc_html__( 'Portfolio Settings', 'organio' ),
			'show_options_object' => false,
		), array(
			'context'  => 'advanced',
			'priority' => 'default'
		) );
	}

	/**
	 * Config post meta options
	 *
	 */
	$metabox->add_section( 'post', array(
		'title'  => esc_html__( 'Post Settings', 'organio' ),
		'icon'   => 'el el-refresh',
		'fields' => array(
			array(
				'id'             => 'post_content_padding',
				'type'           => 'spacing',
				'output'         => array( '.single-post #content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'organio' ),
				'subtitle'     => esc_html__( 'Content site paddings.', 'organio' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'organio' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
			array(
				'id'      => 'show_sidebar_post',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Sidebar', 'organio' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'sidebar_post_pos',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Sidebar Position', 'organio' ),
				'options'      => array(
					'left'  => esc_html__('Left', 'organio'),
	                'right' => esc_html__('Right', 'organio'),
	                'none'  => esc_html__('Disabled', 'organio')
				),
				'default'      => 'right',
				'required'     => array( 0 => 'show_sidebar_post', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
		)
	) );

	/**
	 * Config page meta options
	 *
	 */
	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Header', 'organio' ),
		'desc'   => esc_html__( 'Header settings for the page.', 'organio' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
				'id'      => 'custom_header',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Layout', 'organio' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'header_layout',
				'type'         => 'image_select',
				'title'        => esc_html__( 'Layout', 'organio' ),
				'subtitle'     => esc_html__( 'Select a layout for header.', 'organio' ),
				'options'      => array(
					'0' => get_template_directory_uri() . '/assets/images/header-layout/h0.jpg',
					'1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
					'2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
					'3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
					'4' => get_template_directory_uri() . '/assets/images/header-layout/h4.jpg',
					'5' => get_template_directory_uri() . '/assets/images/header-layout/h5.jpg',
					'6' => get_template_directory_uri() . '/assets/images/header-layout/h6.jpg',
					'7' => get_template_directory_uri() . '/assets/images/header-layout/h7.jpg',
					'8' => get_template_directory_uri() . '/assets/images/header-layout/h8.jpg',
					'9' => get_template_directory_uri() . '/assets/images/header-layout/h9.jpg',
					'10' => get_template_directory_uri() . '/assets/images/header-layout/h10.jpg',
					'11' => get_template_directory_uri() . '/assets/images/header-layout/h11.jpg',
				),
				'default'      => organio_get_option_of_theme_options( 'header_layout' ),
				'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
			),
			array(
	            'id'       => 'sticky_header_type_page',
	            'type'     => 'button_set',
	            'title'    => esc_html__('Sticky Header Type', 'organio'),
	            'options'  => array(
	                'themeoption'  => esc_html__('Theme Option', 'organio'),
	                'scroll-to-bottom'  => esc_html__('Scroll To Bottom', 'organio'),
	                'scroll-to-top'  => esc_html__('Scroll To Top', 'organio'),
	            ),
	            'default'  => 'themeoption',
	        ),
	        array(
	            'id'       => 'icon_has_children',
	            'type'     => 'button_set',
	            'title'    => esc_html__('Icon Has Children', 'organio'),
	            'options'  => array(
	            	'themeoption'  => esc_html__('Theme Option', 'organio'),
	                'plus'  => esc_html__('Plus', 'organio'),
	                'arrow'  => esc_html__('Arrow', 'organio')
	            ),
	            'default'  => 'themeoption',
	        ),
	        array(
	            'id'       => 'p_menu_category_display',
	            'type'     => 'button_set',
	            'title'    => esc_html__('Menu Product Categories Display', 'organio'),
	            'options'  => array(
	            	'themeoption'  => esc_html__('Theme Option', 'organio'),
	                'always'  => esc_html__('Always', 'organio'),
                'hover'  => esc_html__('Hover', 'organio'),
	            ),
	            'default'  => 'themeoption',
	            'subtitle' => esc_html__('Apply header layout 3.', 'organio'),
	        ),
	        array(
	            'id' => 'btn_custom_text',
	            'type' => 'text',
	            'title' => esc_html__('Button Custom Text', 'organio'),
	            'default' => '',
	            'desc' => esc_html__('Applicable to a few header layouts.', 'organio'),
	            'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
	        ),
			array(
	            'title' => esc_html__('Logo', 'organio'),
	            'type'  => 'section',
	            'id' => 'logo_page',
	            'indent' => true,
	            'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
	        ),
			array(
	            'id'       => 'p_logo_dark',
	            'type'     => 'media',
	            'title'    => esc_html__('Custom Logo Dark', 'organio'),
	            'default' => '',
	            'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
	        ),
	        array(
	            'id'       => 'p_logo_light',
	            'type'     => 'media',
	            'title'    => esc_html__('Custom Logo Light', 'organio'),
	            'default' => '',
	            'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
	        ),
	        array(
	            'id'       => 'p_logo_mobile',
	            'type'     => 'media',
	            'title'    => esc_html__('Custom Logo Tablet & Mobile', 'organio'),
	            'default' => '',
	            'required'     => array( 0 => 'custom_header', 1 => 'equals', 2 => '1' ),
				'force_output' => true
	        ),
	        array(
	            'title' => esc_html__('Main Menu', 'organio'),
	            'type'  => 'section',
	            'id' => 'main_menu_page',
	            'indent' => true
	        ),
	        array(
                'id'       => 'h_custom_menu',
                'type'     => 'select',
                'title'    => esc_html__( 'Custom Menu', 'organio' ),
                'subtitle' => esc_html__( 'Custom menu for current page.', 'organio' ),
                'options'  => organio_get_nav_menu(),
                'default' => '',
            ),
		)
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Page Title', 'organio' ),
		'icon'   => 'el el-indent-left',
		'fields' => array(
			array(
				'id'           => 'custom_pagetitle',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Page Title', 'organio' ),
				'options'      => array(
					'themeoption'  => esc_html__( 'Theme Option', 'organio' ),
					'show'  => esc_html__( 'Custom', 'organio' ),
					'hide'  => esc_html__( 'Hide', 'organio' ),
				),
				'default'      => 'themeoption',
			),
			array(
				'id'           => 'custom_title',
				'type'         => 'textarea',
				'title'        => esc_html__( 'Title', 'organio' ),
				'subtitle'     => esc_html__( 'Use custom title for this page. The default title will be used on document title.', 'organio' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => 'show' ),
				'force_output' => true
			),
			array(
	            'id'       => 'ptitle_bg',
	            'type'     => 'background',
	            'background-color'     => true,
	            'background-repeat'     => false,
	            'background-size'     => false,
	            'background-attachment'     => false,
	            'background-position'     => false,
	            'transparent'     => false,
	            'title'    => esc_html__('Background', 'organio'),
	            'subtitle' => esc_html__('Page title background image.', 'organio'),
	            'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => 'show' ),
				'force_output' => true
	        ),
	        array(
				'id'       => 'ptitle_bg_overlay',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color Overlay', 'organio' ),
				'subtitle' => esc_html__( 'Page title background color overlay.', 'organio' ),
				'output'   => array( 'background-color' => 'body #pagetitle:before' ),
				'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => 'show' ),
				'force_output' => true
			),
	        array(
	            'id'             => 'ptitle_padding',
	            'type'           => 'spacing',
	            'output'         => array('.site #pagetitle.page-title'),
	            'right'   => false,
	            'left'    => false,
	            'mode'           => 'padding',
	            'units'          => array('px'),
	            'units_extended' => 'false',
	            'title'          => esc_html__('Page Title Padding', 'organio'),
	            'default'            => array(
	                'padding-top'   => '',
	                'padding-bottom'   => '',
	                'units'          => 'px',
	            ),
	            'required'     => array( 0 => 'custom_pagetitle', 1 => '=', 2 => 'show' ),
				'force_output' => true
	        ),
		)
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Content', 'organio' ),
		'desc'   => esc_html__( 'Settings for content area.', 'organio' ),
		'icon'   => 'el-icon-pencil',
		'fields' => array(
	        array(
				'id'           => 'loading_page',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Loading', 'organio' ),
				'options'      => array(
					'themeoption'  => esc_html__( 'Theme Option', 'organio' ),
					'custom' => esc_html__( 'Cuttom', 'organio' ),
				),
				'default'      => 'themeoption',
			),
			array(
	            'id'       => 'loading_type',
	            'type'     => 'select',
	            'title'    => esc_html__('Loading Type', 'organio'),
	            'options'  => array(
	                'style1'  => esc_html__('Style 1', 'organio'),
	                'style2'  => esc_html__('Style 2', 'organio'),
	                'style3'  => esc_html__('Style 3', 'organio'),
	                'style4'  => esc_html__('Style 4', 'organio'),
	                'style5'  => esc_html__('Style 5', 'organio'),
	                'style6'  => esc_html__('Style 6', 'organio'),
	                'style7'  => esc_html__('Style 7', 'organio'),
	                'style8'  => esc_html__('Style 8', 'organio'),
	                'style9'  => esc_html__('Style 9', 'organio'),
	                'style10'  => esc_html__('Style 10', 'organio'),
	                'style11'  => esc_html__('Style 11', 'organio'),
	                'style12'  => esc_html__('Style 12', 'organio'),
	            ),
	            'default'  => 'style1',
	            'required'     => array( 0 => 'loading_page', 1 => '=', 2 => 'custom' ),
				'force_output' => true
	        ),
			array(
				'id'       => 'content_bg_color',
				'type'     => 'color_rgba',
				'title'    => esc_html__( 'Background Color', 'organio' ),
				'subtitle' => esc_html__( 'Content background color.', 'organio' ),
				'output'   => array( 'background-color' => 'body .site-content' )
			),
			array(
				'id'             => 'content_padding',
				'type'           => 'spacing',
				'output'         => array( '#content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'organio' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'organio' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
			array(
				'id'      => 'show_sidebar_page',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show Sidebar', 'organio' ),
				'default' => false,
				'indent'  => true
			),
			array(
				'id'           => 'sidebar_page_pos',
				'type'         => 'button_set',
				'title'        => esc_html__( 'Sidebar Position', 'organio' ),
				'options'      => array(
					'left'  => esc_html__( 'Left', 'organio' ),
					'right' => esc_html__( 'Right', 'organio' ),
				),
				'default'      => 'right',
				'required'     => array( 0 => 'show_sidebar_page', 1 => '=', 2 => '1' ),
				'force_output' => true
			),
		)
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Footer', 'organio' ),
		'desc'   => esc_html__( 'Settings for footer area.', 'organio' ),
		'icon'   => 'el el-website',
		'fields' => array(
			array(
				'id'      => 'custom_footer',
				'type'    => 'switch',
				'title'   => esc_html__( 'Custom Layout', 'organio' ),
				'default' => false,
				'indent'  => true
			),
	        array(
	            'id'          => 'footer_layout_custom',
	            'type'        => 'select',
	            'title'       => esc_html__('Layout', 'organio'),
	            'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.','organio'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=footer' ) ) . '">','</a>'),
	            'options'     =>organio_list_post('footer'),
	            'default'     => '',
	            'required' => array( 0 => 'custom_footer', 1 => 'equals', 2 => '1' ),
	            'force_output' => true
	        ),
	        array(
	            'id'       => 'footer_bg_color',
	            'type'     => 'color_rgba',
	            'title'    => esc_html__( 'Background Color', 'organio' ),
	            'subtitle' => esc_html__( 'Page title background color overlay.', 'organio' ),
	            'output'   => array( 'background-color' => '.site-footer-custom' ),
	            'force_output' => true,
	        ),
	    )
	) );

	$metabox->add_section( 'page', array(
		'title'  => esc_html__( 'Colors', 'organio' ),
		'icon'   => 'el-icon-file-edit',
		'fields' => array(
			array(
	            'id'          => 'p_primary_color',
	            'type'        => 'color',
	            'title'       => esc_html__('Primary Color', 'organio'),
	            'transparent' => false,
	            'default'     => ''
	        ),
	        array(
	            'id'          => 'p_third_color',
	            'type'        => 'color',
	            'title'       => esc_html__('Third Color', 'organio'),
	            'transparent' => false,
	            'default'     => ''
	        ),
	        array(
	            'id'          => 'p_gradient_color',
	            'type'        => 'color_gradient',
	            'title'       => esc_html__('Gradient Color', 'organio'),
	            'transparent' => false,
	            'default'  => array(
	                'from' => '',
	                'to'   => '', 
	            ),
	        ),
		)
	) );

	/**
	 * Config post format meta options
	 *
	 */

	$metabox->add_section( 'ct_pf_video', array(
		'title'  => esc_html__( 'Video', 'organio' ),
		'fields' => array(
			array(
				'id'    => 'post-video-url',
				'type'  => 'text',
				'title' => esc_html__( 'Video URL', 'organio' ),
				'desc'  => esc_html__( 'YouTube or Vimeo video URL', 'organio' )
			),

			array(
				'id'    => 'post-video-file',
				'type'  => 'editor',
				'title' => esc_html__( 'Video Upload', 'organio' ),
				'desc'  => esc_html__( 'Upload video file', 'organio' )
			),

			array(
				'id'    => 'post-video-html',
				'type'  => 'textarea',
				'title' => esc_html__( 'Embadded video', 'organio' ),
				'desc'  => esc_html__( 'Use this option when the video does not come from YouTube or Vimeo', 'organio' )
			)
		)
	) );

	$metabox->add_section( 'ct_pf_gallery', array(
		'title'  => esc_html__( 'Gallery', 'organio' ),
		'fields' => array(
			array(
				'id'       => 'post-gallery-lightbox',
				'type'     => 'switch',
				'title'    => esc_html__( 'Lightbox?', 'organio' ),
				'subtitle' => esc_html__( 'Enable lightbox for gallery images.', 'organio' ),
				'default'  => true
			),
			array(
				'id'       => 'post-gallery-images',
				'type'     => 'gallery',
				'title'    => esc_html__( 'Gallery Images ', 'organio' ),
				'subtitle' => esc_html__( 'Upload images or add from media library.', 'organio' )
			)
		)
	) );

	$metabox->add_section( 'ct_pf_audio', array(
		'title'  => esc_html__( 'Audio', 'organio' ),
		'fields' => array(
			array(
				'id'          => 'post-audio-url',
				'type'        => 'text',
				'title'       => esc_html__( 'Audio URL', 'organio' ),
				'description' => esc_html__( 'Audio file URL in format: mp3, ogg, wav.', 'organio' ),
				'validate'    => 'url',
				'msg'         => 'Url error!'
			)
		)
	) );

	$metabox->add_section( 'ct_pf_link', array(
		'title'  => esc_html__( 'Link', 'organio' ),
		'fields' => array(
			array(
				'id'       => 'post-link-url',
				'type'     => 'text',
				'title'    => esc_html__( 'URL', 'organio' ),
				'validate' => 'url',
				'msg'      => 'Url error!'
			)
		)
	) );

	$metabox->add_section( 'ct_pf_quote', array(
		'title'  => esc_html__( 'Quote', 'organio' ),
		'fields' => array(
			array(
				'id'    => 'post-quote-cite',
				'type'  => 'text',
				'title' => esc_html__( 'Cite', 'organio' )
			)
		)
	) );

	/**
	 * Config service meta options
	 *
	 */
	$metabox->add_section( 'service', array(
		'title'  => esc_html__( 'General', 'organio' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
	            'id'       => 'icon_type',
	            'type'     => 'button_set',
	            'title'    => esc_html__('Icon Type', 'organio'),
	            'options'  => array(
	                'icon'  => esc_html__('Icon', 'organio'),
	                'image'  => esc_html__('Image', 'organio'),
	            ),
	            'default'  => 'icon'
	        ),
			array(
	            'id'       => 'service_icon',
	            'type'     => 'ct_iconpicker',
	            'title'    => esc_html__('Icon', 'organio'),
	            'required' => array( 0 => 'icon_type', 1 => 'equals', 2 => 'icon' ),
            	'force_output' => true
	        ),
	        array(
	            'id'       => 'service_icon_img',
	            'type'     => 'media',
	            'title'    => esc_html__('Icon Image', 'organio'),
	            'default' => '',
	            'required' => array( 0 => 'icon_type', 1 => 'equals', 2 => 'image' ),
            	'force_output' => true
	        ),
			array(
				'id'       => 'service_except',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Excerpt', 'organio' ),
				'validate' => 'no_html'
			),
			array(
				'id'             => 'service_content_padding',
				'type'           => 'spacing',
				'output'         => array( '.single-service #content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'organio' ),
				'subtitle'     => esc_html__( 'Content site paddings.', 'organio' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'organio' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
		)
	) );

	/**
	 * Config portfolio meta options
	 *
	 */
	$metabox->add_section( 'portfolio', array(
		'title'  => esc_html__( 'General', 'organio' ),
		'icon'   => 'el-icon-website',
		'fields' => array(
			array(
	            'id'       => 'icon_type',
	            'type'     => 'button_set',
	            'title'    => esc_html__('Icon Type', 'organio'),
	            'options'  => array(
	                'icon'  => esc_html__('Icon', 'organio'),
	                'image'  => esc_html__('Image', 'organio'),
	            ),
	            'default'  => 'icon'
	        ),
			array(
	            'id'       => 'portfolio_icon',
	            'type'     => 'ct_iconpicker',
	            'title'    => esc_html__('Icon', 'organio'),
	            'required' => array( 0 => 'icon_type', 1 => 'equals', 2 => 'icon' ),
            	'force_output' => true
	        ),
	        array(
	            'id'       => 'portfolio_icon_img',
	            'type'     => 'media',
	            'title'    => esc_html__('Icon Image', 'organio'),
	            'default' => '',
	            'required' => array( 0 => 'icon_type', 1 => 'equals', 2 => 'image' ),
            	'force_output' => true
	        ),
			array(
				'id'       => 'portfolio_except',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Excerpt', 'organio' ),
				'validate' => 'no_html'
			),
			array(
				'id'             => 'portfolio_content_padding',
				'type'           => 'spacing',
				'output'         => array( '.single-portfolio #content' ),
				'right'          => false,
				'left'           => false,
				'mode'           => 'padding',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Content Padding', 'organio' ),
				'subtitle'     => esc_html__( 'Content site paddings.', 'organio' ),
				'desc'           => esc_html__( 'Default: Theme Option.', 'organio' ),
				'default'        => array(
					'padding-top'    => '',
					'padding-bottom' => '',
					'units'          => 'px',
				)
			),
		)
	) );


	/**
     * Config product meta options
     *
     */
    $metabox->add_section('product', array(
        'title'  => esc_html__('Product Settings', 'organio'),
        'icon'   => 'el el-briefcase',
        'fields' => array(
		    array(
	            'id'      => 'product_date',
	            'type'    => 'text',
	            'title'   => esc_html__('Countdown', 'organio'),
	            'default' => '',
	            'description' => esc_html__('Set date count down (Date format: yy/mm/dd)', 'organio'),
	        ),
            array(
	            'id'          => 'line_color',
	            'type'        => 'color_rgba',
	            'title'       => esc_html__('Line Color', 'organio'),
	            'transparent' => false,
	            'default'     => ''
	        ),
        )
    ));

}

function organio_get_option_of_theme_options( $key, $default = '' ) {
	if ( empty( $key ) ) {
		return '';
	}
	$options = get_option( organio_get_opt_name(), array() );
	$value   = isset( $options[ $key ] ) ? $options[ $key ] : $default;

	return $value;
}