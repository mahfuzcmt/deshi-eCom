<?php
if ( ! class_exists( 'ReduxFrameworkInstances' ) ) {
	return;
}

if(!function_exists('organio_hex_to_rgba')){
    function organio_hex_to_rgba($hex,$opacity = 1) {
        $hex = str_replace("#",null, $hex);
        $color = array();
        if(strlen($hex) == 3) {
            $color['r'] = hexdec(substr($hex,0,1).substr($hex,0,1));
            $color['g'] = hexdec(substr($hex,1,1).substr($hex,1,1));
            $color['b'] = hexdec(substr($hex,2,1).substr($hex,2,1));
            $color['a'] = $opacity;
        }
        else if(strlen($hex) == 6) {
            $color['r'] = hexdec(substr($hex, 0, 2));
            $color['g'] = hexdec(substr($hex, 2, 2));
            $color['b'] = hexdec(substr($hex, 4, 2));
            $color['a'] = $opacity;
        }
        $color = "rgba(".implode(', ', $color).")";
        return $color;
    }
}

class CSS_Generator {
	/**
     * scssc class instance
     *
     * @access protected
     * @var scssc
     */
    protected $scssc = null;

    /**
     * ReduxFramework class instance
     *
     * @access protected
     * @var ReduxFramework
     */
    protected $redux = null;

    /**
     * Debug mode is turn on or not
     *
     * @access protected
     * @var boolean
     */
    protected $dev_mode = true;

    /**
     * opt_name of ReduxFramework
     *
     * @access protected
     * @var string
     */
    protected $opt_name = '';

	/**
	 * Constructor
	 */

	function __construct() {
		$this->opt_name = organio_get_opt_name();
		if ( empty( $this->opt_name ) ) {
			return;
		}
		$this->dev_mode = organio_get_opt( 'dev_mode', '0' ) === '1' ? true : false;
		add_filter( 'ct_scssc_on', '__return_true' );
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 20 );
	}

	/**
	 * init hook - 10
	 */
	function init() {
		if ( ! class_exists( 'scssc' ) ) {
			return;
		}

		$this->redux = ReduxFrameworkInstances::get_instance( $this->opt_name );

		if ( empty( $this->redux ) || ! $this->redux instanceof ReduxFramework ) {
			return;
		}
		add_action( 'wp', array( $this, 'generate_with_dev_mode' ) );
		add_action( "redux/options/{$this->opt_name}/saved", function () {
			$this->generate_file_options();
		} );
	}

	function generate_with_dev_mode() {
		if ( $this->dev_mode === true ) {
			$this->generate_file_options();
			$this->generate_file();
		}
	}

	function generate_file_options() {
		$scss_dir = get_template_directory() . '/assets/scss/';
        $this->scssc = new scssc();
        $this->scssc->setImportPaths( $scss_dir );
        $_options = $scss_dir . 'variables.scss';
        $this->scssc->setFormatter( 'scss_formatter' );
        $this->redux->filesystem->execute( 'put_contents', $_options, array(
            'content' => preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $this->options_output() )
        ) );
	}

	/**
	 * Generate options and css files
	 */
	function generate_file() {
		$scss_dir = get_template_directory() . '/assets/scss/';
		$css_dir  = get_template_directory() . '/assets/css/';

		$this->scssc = new scssc();
		$this->scssc->setImportPaths( $scss_dir );

		$css_file = $css_dir . 'theme.css';

		$this->scssc->setFormatter( 'scss_formatter' );
		$this->redux->filesystem->execute( 'put_contents', $css_file, array(
			'content' => preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $this->scssc->compile( '@import "theme.scss"' ) )
		) );
	}

	protected function print_scss_opt_colors($variable,$param){
        if(is_array($variable)){
            $k = [];
            $v = [];
            foreach ($variable as $key => $value) {
                $k[] = str_replace('-', '_', $key);
                $v[] = 'var(--'.str_replace(['#',' '], [''],$key).'-color)';
            }
            if($param === 'key'){
                return implode(',', $k);
            }else{
                return implode(',', $v);
            }
            
        } else {
            return $variable;
        }
    }

	/**
	 * Output options to _variables.scss
	 *
	 * @access protected
	 * @return string
	 */
	protected function options_output() {
		$theme_colors                    = organio_configs('theme_colors');
        $links                           = organio_configs('link');
        $gradients                           = organio_configs('gradient');
		ob_start();

		printf('$organio_theme_colors_key:(%s);',$this->print_scss_opt_colors($theme_colors,'key'));
        printf('$organio_theme_colors_val:(%s);',$this->print_scss_opt_colors($theme_colors,'val'));
        // color rgb only
        foreach ($theme_colors as $key => $value) {
            printf('$%1$s_color_hex: %2$s;', str_replace('-', '_', $key), $value['value']); 
        }
        // color
        foreach ($theme_colors as $key => $value) {
            printf('$%1$s_color: %2$s;', str_replace('-', '_', $key), 'var(--'.str_replace(['#',' '], [''],$key).'-color)' );
        }

        // color rgb only
        foreach ($theme_colors as $key => $value) {
            printf('$%1$s_color_hex: %2$s;', str_replace('-', '_', $key), $value['value']); 
        }
        // color
        foreach ($theme_colors as $key => $value) {
            printf('$%1$s_color: %2$s;', str_replace('-', '_', $key), 'var(--'.str_replace(['#',' '], [''],$key).'-color)' );
        }
         
        // link color
        foreach ($links as $key => $value) {
            printf('$link_%1$s: %2$s;', str_replace('-', '_', $key), 'var(--link-'.$key.')');
        }

        // gradient color
        foreach ($gradients as $key => $value) {
            printf('$gradient_%1$s: %2$s;', str_replace('-', '_', $key), 'var(--gradient-'.$key.')');
        }

        // gradient color hex
        /* Gradient Color Main */
        $gradient_color_hex = organio_get_opt( 'gradient_color' );
        if ( !empty($gradient_color_hex['from']) && isset($gradient_color_hex['from']) ) {
            printf( '$gradient_from_hex: %s;', esc_attr( $gradient_color_hex['from'] ) );
        } else {
            echo '$gradient_from_hex: #8d4cfa;';
        }
        if ( !empty($gradient_color_hex['to']) && isset($gradient_color_hex['to']) ) {
            printf( '$gradient_to_hex: %s;', esc_attr( $gradient_color_hex['to'] ) );
        } else {
            echo '$gradient_to_hex: #5f6ffb;';
        }

		/* Font */
		$body_default_font = organio_get_opt( 'body_default_font', 'Roboto' );
		if ( isset( $body_default_font ) ) {
			echo '
                $body_default_font: ' . esc_attr( $body_default_font ) . ';
            ';
		}

		$heading_default_font = organio_get_opt( 'heading_default_font', 'Libre-Caslon-Text' );
		if ( isset( $heading_default_font ) ) {
			echo '
                $heading_default_font: ' . esc_attr( $heading_default_font ) . ';
            ';
		}

		return ob_get_clean();
	}

	/**
	 * Hooked wp_enqueue_scripts - 20
	 * Make sure that the handle is enqueued from earlier wp_enqueue_scripts hook.
	 */
	function enqueue() {
		$css = $this->inline_css();
		if ( ! empty( $css ) ) {
			wp_add_inline_style( 'organio-theme', $css );
		}
	}

	/**
	 * Generate inline css based on theme options
	 */
	protected function inline_css() {
		ob_start();

		/* Logo */
		$logo_maxh = organio_get_opt( 'logo_maxh' );
		$logo_maxh_sticky = organio_get_opt( 'logo_maxh_sticky' );

		if ( ! empty( $logo_maxh['height'] ) && $logo_maxh['height'] != 'px' ) {
			printf( '#ct-header-wrap .ct-header-branding a img { max-height: %s !important; }', esc_attr( $logo_maxh['height'] ) );
		} 
		if ( ! empty( $logo_maxh_sticky['height'] ) && $logo_maxh_sticky['height'] != 'px' ) {
			printf( '#ct-header-wrap #ct-header.h-fixed .ct-header-branding a img { max-height: %s !important; }', esc_attr( $logo_maxh_sticky['height'] ) );
		}

		?>
        @media screen and (max-width: 1199px) {
		<?php
			$logo_maxh_sm = organio_get_opt( 'logo_maxh_sm' );
			if ( ! empty( $logo_maxh_sm['height'] ) && $logo_maxh_sm['height'] != 'px' ) {
				printf( '#ct-header-wrap .ct-header-branding a img { max-height: %s !important; }', esc_attr( $logo_maxh_sm['height'] ) );
			} ?>
        }
        <?php /* End Logo */

		/* Menu */ ?>
		@media screen and (min-width: 1200px) {
		<?php  
			$topbar_bg_color = organio_get_opt( 'topbar_bg_color' );
			$header_bg_color = organio_get_opt( 'header_bg_color' );
			if ( ! empty( $topbar_bg_color ) ) {
				printf( '#ct-header-top { background-color: %s !important; }', esc_attr( $topbar_bg_color ) );
			}

			if ( ! empty( $header_bg_color ) ) {
				printf( '#ct-header-wrap #ct-header, #ct-header-wrap #ct-header .ct-header-navigation-bg, #ct-header-wrap.ct-header-layout7 #ct-header:not(.h-fixed) .ct-header-navigation { background-color: %s !important; }', esc_attr( $header_bg_color ) );
				printf( '#ct-header-wrap.ct-header-layout3 #ct-header { background-color: transparent !important; }', esc_attr( $header_bg_color ) );

				printf( '#ct-header-wrap.ct-header-layout3 #ct-header.h-fixed { background-color: %s !important; }', esc_attr( $header_bg_color ) );
				printf( '#ct-header-wrap.ct-header-layout3 #ct-header.h-fixed .ct-header-navigation-bg { background-color: transparent !important; }', esc_attr( $header_bg_color ) );
			}

			$main_menu_color = organio_get_opt( 'main_menu_color' );
			if ( ! empty( $main_menu_color['regular'] ) ) {
				printf( '.ct-main-menu > li > a { color: %s !important; }', esc_attr( $main_menu_color['regular'] ) );
			}
			if ( ! empty( $main_menu_color['hover'] ) ) {
				printf( '.ct-main-menu > li > a:hover { color: %s !important; }', esc_attr( $main_menu_color['hover'] ) );
			}
			if ( ! empty( $main_menu_color['active'] ) ) {
				printf( '.ct-main-menu > li.current_page_item > a, .ct-main-menu > li.current-menu-item > a, .ct-main-menu > li.current_page_ancestor > a, .ct-main-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr( $main_menu_color['active'] ) );
			}
			$sticky_menu_color = organio_get_opt( 'sticky_menu_color' );
			if ( ! empty( $sticky_menu_color['regular'] ) ) {
				printf( '#ct-header.h-fixed .ct-main-menu > li > a { color: %s !important; }', esc_attr( $sticky_menu_color['regular'] ) );
			}
			if ( ! empty( $sticky_menu_color['hover'] ) ) {
				printf( '#ct-header.h-fixed .ct-main-menu > li > a:hover { color: %s !important; }', esc_attr( $sticky_menu_color['hover'] ) );
			}
			if ( ! empty( $sticky_menu_color['active'] ) ) {
				printf( '#ct-header.h-fixed .ct-main-menu > li.current_page_item > a, #ct-header.h-fixed .ct-main-menu > li.current-menu-item > a, #ct-header.h-fixed .ct-main-menu > li.current_page_ancestor > a, #ct-header.h-fixed .ct-main-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr( $sticky_menu_color['active'] ) );
			}
			$sub_menu_color = organio_get_opt( 'sub_menu_color' );
			if ( ! empty( $sub_menu_color['regular'] ) ) {
				printf( '#ct-header .ct-main-menu .sub-menu > li > a { color: %s !important; }', esc_attr( $sub_menu_color['regular'] ) );
			}
			if ( ! empty( $sub_menu_color['hover'] ) ) {
				printf( '#ct-header .ct-main-menu .sub-menu > li > a:hover { color: %s !important; }', esc_attr( $sub_menu_color['hover'] ) );
				printf( '#ct-header .ct-main-menu .sub-menu > li > a:before { background-color: %s !important; }', esc_attr( $sub_menu_color['hover'] ) );
			}
			if ( ! empty( $sub_menu_color['active'] ) ) {
				printf( '#ct-header .ct-main-menu .sub-menu > li.current_page_item > a, #ct-header .ct-main-menu .sub-menu > li.current-menu-item > a, #ct-header .ct-main-menu .sub-menu > li.current_page_ancestor > a, #ct-header .ct-main-menu .sub-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr( $sub_menu_color['active'] ) );
				printf( '#ct-header .ct-main-menu .sub-menu > li.current_page_item > a:before, #ct-header .ct-main-menu .sub-menu > li.current-menu-item > a:before, #ct-header .ct-main-menu .sub-menu > li.current_page_ancestor > a:before, #ct-header .ct-main-menu .sub-menu > li.current-menu-ancestor > a:before { background-color: %s !important; }', esc_attr( $sub_menu_color['active'] ) );
			}
			$menu_icon_color = organio_get_opt( 'menu_icon_color' );
			if ( ! empty( $menu_icon_color ) ) {
				printf( '.ct-main-menu .link-icon { color: %s !important; }', esc_attr( $menu_icon_color ) );
			}
			?>
		}
		<?php /* End Menu */

		/* Page Title */
		$ptitle_bg = organio_get_page_opt( 'ptitle_bg' );
		$custom_pagetitle = organio_get_page_opt( 'custom_pagetitle', 'themeoption' );
		if ( $custom_pagetitle == 'show' && ! empty( $ptitle_bg['background-image'] ) ) {
			echo 'body .site #pagetitle.page-title {
                background-image: url(' . esc_attr( $ptitle_bg['background-image'] ) . ');
            }';
		}
		if ( $custom_pagetitle == 'show' && ! empty( $ptitle_bg['background-color'] ) ) {
			echo 'body .site #pagetitle.page-title {
                background-color: '. esc_attr( $ptitle_bg['background-color'] ) .';
            }';
		}

		/* Preset */
		$p_primary_color = organio_get_page_opt( 'p_primary_color' );
		if ( !empty( $p_primary_color ) ) {
            echo '.ct-fancy-box-layout5 .item--icon i, .ct-main-menu .sub-menu li > a:hover, 
            .ct-main-menu .children li > a:hover, 
            .ct-main-menu .sub-menu li.current_page_item > a, 
            .ct-main-menu .children li.current_page_item > a, 
            .ct-main-menu .sub-menu li.current-menu-item > a, 
            .ct-main-menu .children li.current-menu-item > a, 
            .ct-main-menu .sub-menu li.current_page_ancestor > a, 
            .ct-main-menu .children li.current_page_ancestor > a, 
            .ct-main-menu .sub-menu li.current-menu-ancestor > a, 
            .ct-main-menu .children li.current-menu-ancestor > a,
            #ct-header-wrap.ct-header-layout2 .ct-header-phone a:hover,
            #ct-header-wrap .ct-menu-topbar.ct-main-menu > li > a:hover,
            .ct-main-menu .link-icon, .revslider-initialised .rs-layer cite,
            .ct-heading h3.item--title cite, .ct-product-grid-layout2.woocommerce .price,
            .woocommerce ins, .ct-widget-cart-sidebar .widget_shopping_cart .widget_shopping_cart_footer p.buttons .btn.btn-outline,
            .ct-widget-cart-sidebar .widget_shopping_cart .widget_shopping_cart_content ul.cart_list a.remove_from_cart_button,
            .ct-product-grid-layout2.woocommerce .price, .ct-product-carousel2.woocommerce .price,
            .ct-product-carousel3.woocommerce .price, .ct-blog-carousel-layout2 .item--title a:hover,
            .ct-blog-carousel-layout2 .item--meta li a:hover,
            .ct-blog-carousel-layout3 .item--featured .item--meta i,
            .ct-blog-carousel-layout4 .item--meta i,
            .ct-fancy-box-layout3.style7 .item--icon,
            .ct-product-carousel-reset1.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div button::before, 
            .ct-product-carousel-reset1.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div a::before,
            .ct-product-carousel-reset1.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div.woocommerce-add-to--cart a,
            .ct-product-carousel-reset1.woocommerce .woocommerce-product-inner .woocommerce-product-content .price,
            .ct-user .ct-user-form i, .elementor-widget-ct_showcase .ct-showcase .ct-showcase-title cite,
            .ct-shop-banner1 .btn.item--button-btn-line-arrow, .ct-shop-banner2 .btn.item--button-btn-line-arrow, .ct-shop-banner1 .btn.item--button-btn-line-arrow:hover, .ct-shop-banner2 .btn.item--button-btn-line-arrow:hover, 
            .ct-shop-banner1 .btn.item--button-btn-line-arrow:focus, .ct-shop-banner2 .btn.item--button-btn-line-arrow:focus, .ct-info-box1 .item--subtitle,
            .ct-tabs--horizontal1.style2 .ct-tabs-title .ct-tab-title.active, .ct-tabs--horizontal1.style2 .ct-tabs-title .ct-tab-title:hover,
            .ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-product-header .woocommerce-product-meta > div button::before, .ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-product-header .woocommerce-product-meta > div a::before {
                color: '. esc_attr( $p_primary_color ) .';
            }';
            echo '.revslider-initialised .tp-bullets.custom.horizontal .tp-bullet.selected, .ct-blog-carousel-layout5 .item--readmore, .ct-testimonial-carousel5 .item--line, .ct-header-product-search .product-search-meta button,
            .ct-main-menu .sub-menu li a::before, 
            .ct-main-menu .children li a::before,
            .ct-icon1.style2 a:hover, .ct-mailchimp1.style3, 
            .btn.btn-slider2, .btn.btn-slider2:hover, .btn.btn-slider2:focus,
            .btn.btn-slider3:hover, .btn.btn-slider3:focus,
            .ct-shop-banner2 .btn.item--button-outline:hover, 
            .ct-shop-banner2 .btn.item--button-outline:focus,
            .ct-shop-banner3 .item--link, .woocommerce .woocommerce-product-inner .woocommerce-product-meta a:hover, 
            .woocommerce .woocommerce-product-inner .woocommerce-product-meta button:hover,
            .btn, button, .button, input[type="submit"],
            .btn.btn-animate:hover, .ct-widget-cart-sidebar .widget_shopping_cart .widget_shopping_cart_footer p.buttons .btn.btn-outline::before,
            .grid-filter-wrap span i::before, .scroll-top,
            .ct-nav-carousel .nav-prev:hover, .ct-nav-carousel .nav-next:hover,
            .slick-dots li.slick-active button, .ct-team-grid2 .item--image .item--social a, .ct-team-carousel2 .item--image .item--social a,
            .btn.btn-outline:hover, .btn.btn-outline:focus, #ct-header-wrap .ct-header-top4, .btn.btn-primary-dot,
            .ct-dots-style3 .slick-dots li.slick-active button,
            .ct-product-carousel5.woocommerce .woocommerce-product-inner:hover .woocommerce-product-content .woocommerce-add-to--cart a, 
            .ct-product-carousel5.woocommerce .woocommerce-product-inner:hover .woocommerce-product-content .woocommerce-add-to--cart .button,
            .ct-product-carousel5.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div a:hover, 
            .ct-product-carousel5.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div button:hover, 
            .ct-product-carousel5.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div .button:hover, 
            .ct-product-carousel5.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div a:focus, 
            .ct-product-carousel5.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div button:focus, 
            .ct-product-carousel5.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div .button:focus,
            .ct-slick-filter .filter-item:hover, .ct-slick-filter .filter-item.active, .ct-slick-filter .filter-item:focus,
            .ct-countdown-layout1.style2 .countdown-item:nth-child(2), .ct-countdown-layout1.style2 .countdown-item:nth-child(4),
            .ct-product-carousel5.woocommerce.style2 .woocommerce-product-content .woocommerce-add-to--cart a, 
            .ct-product-carousel5.woocommerce.style2 .woocommerce-product-content .woocommerce-add-to--cart .button,
            body #ct-header-wrap.ct-header-custom-layout6 .ct-main-menu > li > a .menu-line, .ct-fancy-box-layout4 .item--title::before,
            .grid-filter-wrap.filter-style2 .filter-item:hover, .grid-filter-wrap.filter-style2 .filter-item.active,
            #ct-header-wrap.ct-header-layout8 .ct-header-phone .ct-header-phone-icon,
            #ct-header-wrap.ct-header-layout8 .ct-header-bottom .ct-header-bottom-inner,
            .ct-product-carousel-reset1.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div button:hover, 
            .ct-product-carousel-reset1.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div a:hover,
            .ct-slick-filter-layout7 .ct-slick-filter .filter-item.active, .ct-slick-filter-layout7 .ct-slick-filter .filter-item:hover,
            .ct-dots-style6 .slick-dots li.slick-active button, .grid-filter-wrap.filter-style3 .filter-item:hover, .grid-filter-wrap.filter-style3 .filter-item.active,
            .ct-shop-banner1 .btn.item--button-btn-plus-circle:hover::before, .ct-shop-banner2 .btn.item--button-btn-plus-circle:hover::before,
            .ct-tabs--horizontal1 .ct-tabs-title .ct-tab-title:hover, .ct-tabs--horizontal1 .ct-tabs-title .ct-tab-title.active, .ct-user .ct-user-form .button:hover,
            .ct-modal .ct-modal-close, .ct-icon-close:hover::before, .ct-icon-close:hover::after,
            .btn:hover, button:hover, .button:hover, input[type="submit"]:hover, .btn:focus, button:focus, .button:focus, input[type="submit"]:focus, .btn:active, 
            button:active, .button:active, input[type="submit"]:active, .btn:not([disabled]):not(.disabled).active, button:not([disabled]):not(.disabled).active, 
            .button:not([disabled]):not(.disabled).active, input[type="submit"]:not([disabled]):not(.disabled).active, .btn:not([disabled]):not(.disabled):active, 
            button:not([disabled]):not(.disabled):active, .button:not([disabled]):not(.disabled):active, input[type="submit"]:not([disabled]):not(.disabled):active,
            .ct-spinner5 > div, .btn.btn-slider5:hover, .btn.btn-slider5:focus,
            .revslider-initialised .tp-bullets.ct-bullets-two .tp-bullet.selected,
            .ct-tabs--horizontal1.style2 .ct-tabs-title .ct-tab-title::before,
            .ct-product-carousel9.woocommerce.ct-dots-style5 .slick-dots li.slick-active button,
            .ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-product-header .woocommerce-product-meta > div button:hover, 
            .ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-product-header .woocommerce-product-meta > div a:hover {
                background-color: '. esc_attr( $p_primary_color ) .';
            }';
            echo '.ct-blog-carousel-layout6 .item--date, .ct-nav-carousel.style4 .nav-prev:hover, .ct-nav-carousel.style4 .nav-next:hover,
            .ct-blog-carousel-layout6 .btn.btn-circle-plus:hover::before {
                background-color: #0a472f !important;
            }';
            echo '.ct-nav-carousel.style4 .nav-prev, .ct-nav-carousel.style4 .nav-next {
                color: #0a472f !important;
            }';
            echo '.ct-dots-style7 .slick-dots li button::before {
                border-color: #0a472f !important;
            }';
            echo '.revslider-initialised .tp-bullets.custom.vertical .tp-bullet.selected {
                background-color: '. esc_attr( $p_primary_color ) .' !important;
            }';
            echo '.ct-blog-carousel-layout5 .item--author img, .btn.btn-slider3:hover, .btn.btn-slider3:focus,
            .ct-shop-banner2 .btn.item--button-outline:hover, 
            .ct-shop-banner2 .btn.item--button-outline:focus,
            .ct-widget-cart-sidebar .widget_shopping_cart .widget_shopping_cart_footer p.buttons .btn.btn-outline,
            .ct-nav-carousel .nav-prev:hover, .ct-nav-carousel .nav-next:hover, .btn.btn-outline,
            .ct-testimonial-carousel6 .item--image img, .ct-user .ct-user-form input:focus,
            .wpcf7 form.invalid .wpcf7-response-output, .wpcf7 form.unaccepted .wpcf7-response-output,
            .btn.btn-slider5:hover, .btn.btn-slider5:focus, .revslider-initialised .tp-bullets.ct-bullets-two .tp-bullet::before,
            .revslider-initialised .tp-bullets.ct-bullets-two .tp-bullet,
            .ct-shop-banner1 .btn.item--button-btn-line-arrow, 
            .ct-shop-banner2 .btn.item--button-btn-line-arrow, 
            .ct-shop-banner1 .btn.item--button-btn-line-arrow:focus, 
            .ct-shop-banner2 .btn.item--button-btn-line-arrow:focus {
                border-color: '. esc_attr( $p_primary_color ) .';
            }';
            echo '.ct-product-grid-layout2.woocommerce .woocommerce-product-inner:hover .woocommerce-product-header svg path,
            .ct-product-carousel3.woocommerce .woocommerce-product-inner:hover .woocommerce-product-image svg path,
            .ct-product-grid-layout2.woocommerce .woocommerce-product-inner:hover .woocommerce-product-header svg path, 
            .ct-product-carousel2.woocommerce .woocommerce-product-inner:hover .woocommerce-product-header svg path,
            .ct-testimonial-wrap-l2 svg path {
                fill: '. esc_attr( $p_primary_color ) .';
            }';

            echo '.ct-fancy-box-layout3.style7 .item--icon,
            .ct-product-carousel-reset1.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div button, 
            .ct-product-carousel-reset1.woocommerce .woocommerce-product-inner .woocommerce-product-meta > div a {
                background-color: '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.1) .';
            }';

            echo '.ct-blog-carousel-layout7 .item--featured:after {	        
				background-image: -webkit-gradient(linear, left top, left bottom, from('. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.8) .' 60%), to(rgba(0, 0, 0, 0)));
				background-image: -webkit-linear-gradient(bottom, '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.8) .' 60%, rgba(0, 0, 0, 0));
				background-image: -moz-linear-gradient(bottom, '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.8) .' 60%, rgba(0, 0, 0, 0));
				background-image: -ms-linear-gradient(bottom, '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.8) .' 60%, rgba(0, 0, 0, 0));
				background-image: -o-linear-gradient(bottom, '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.8) .' 60%, rgba(0, 0, 0, 0));
				background-image: linear-gradient(bottom, '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.8) .' 60%, rgba(0, 0, 0, 0));
				filter: progid:DXImageTransform.Microsoft.gradient(startColorStr="'. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.8) .' 60%", endColorStr="rgba(0, 0, 0, 0)");
	        }';

	        echo '.ct-blog-carousel-layout7 .grid-item-inner:hover {	        
				webkit-box-shadow: 0 20px 40px '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.2) .';
				-khtml-box-shadow: 0 20px 40px '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.2) .';
				-moz-box-shadow: 0 20px 40px '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.2) .';
				-ms-box-shadow: 0 20px 40px '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.2) .';
				-o-box-shadow: 0 20px 40px '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.2) .';
				box-shadow: 0 20px 40px '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.2) .';
	        }';

	        echo '.ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-product-header .woocommerce-product-meta > div button, .ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-product-header .woocommerce-product-meta > div a {
                background-color: '. organio_hex_to_rgba(esc_attr( $p_primary_color ), 0.15) .';
            }';
	        
            ?>

            @media screen and (min-width: 1200px) { <?php
            	echo '#ct-header-wrap.ct-header-layout2 #ct-header, #ct-header-wrap.ct-header-layout7 #ct-header:not(.h-fixed) .ct-header-navigation {
	                background-color: '. esc_attr( $p_primary_color ) .';
	            }';
        	?> }

            @media screen and (max-width: 1199px) { <?php
            	
        	?> } <?php
		}

		$p_third_color = organio_get_page_opt( 'p_third_color' );
		if ( !empty( $p_third_color ) ) {
            echo '.ct-shop-banner1 .item--title-label.style2, .ct-shop-banner2 .item--title-label.style2, #ct-header-wrap.ct-header-layout7 #ct-header .ct-header-button a:hover, .btn.btn-third-dot, #ct-header-wrap.ct-header-layout5 .ct-main-menu > li > a .menu-line,
            .ct-countdown-layout1.style2 .countdown-item,
            .ct-countdown-layout1.style3 .countdown-item,
            .ct-fancy-box-layout4 .item--link .btn:hover, .ct-fancy-box-layout4 .item--link .btn:focus,
            .ct-nav-carousel.style3 .nav-prev:hover, .ct-nav-carousel.style3 .nav-next:hover, .ct-nav-carousel.style3 .nav-prev:focus, .ct-nav-carousel.style3 .nav-next:focus,
            .ct-product-grid-layout3.woocommerce .woocommerce-product-content .woocommerce-add-to--cart a,
            .ct-team-carousel3 .item--social a:hover, .ct-team-carousel3 .item--social a:focus {
                background-color: '. esc_attr( $p_third_color ) .';
            }';
            echo '.ct-product-carousel6.woocommerce .woocommerce-product-inner .woocommerce-product--price, .ct-product-carousel6.woocommerce .woocommerce-product-inner .woocommerce-product--price ins .amount, .ct-slick-filter-layout6 .ct-slick-filter .filter-item.active, .ct-slick-filter-layout6 .ct-slick-filter .filter-item:hover, .ct-dots-style5 .slick-dots li.slick-active button, .ct-video-button.style1.style-white, .ct-product-carousel5.woocommerce .woocommerce-product-inner .price ins .amount,
            .revslider-initialised .rs-layer b, .ct-heading .item--title b, .ct-product-grid-layout3.woocommerce .woocommerce-product-content .price,
            .ct-team-carousel3 .item--social a, .revslider-initialised .rs-layer cite.preset4 {
                color: '. esc_attr( $p_third_color ) .';
            }';
            echo '.ct-countdown-layout1.style4 .countdown-amount span, .ct-fancy-box-layout4 .item--link .btn:hover, .ct-fancy-box-layout4 .item--link .btn:focus,
            .ct-nav-carousel.style3 .nav-prev, .ct-nav-carousel.style3 .nav-next {
                border-color: '. esc_attr( $p_third_color ) .';
            }';
		}

		$p_gradient_color = organio_get_page_opt( 'p_gradient_color' );
		if ( !empty( $p_gradient_color['from'] ) && !empty($p_gradient_color['to']) ) {
			echo '#ct-header-wrap.ct-header-layout10 .ct-header-info .ct-header-icon, 
			#ct-header-wrap.ct-header-layout10 .ct-header-shop-icons .wishlist-count, 
			#ct-header-wrap.ct-header-layout10 .ct-header-shop-icons .widget_cart_counter,
			.ct-info-box1 .item--icon i, .ct-fancy-box-layout6 .item--icon i,
			.ct-fancy-box-layout6 .item--icon::before, .ct-blog-carousel-layout7 .item--date,
			.ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-add-to--cart .button, 
			.ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-add-to--cart .wc-forward {
	            background-image: -webkit-gradient(linear, left top, right top, from('. esc_attr( $p_gradient_color['from'] ) .'), to('. esc_attr( $p_gradient_color['to'] ) .'));
				background-image: -webkit-linear-gradient(left, '. esc_attr( $p_gradient_color['from'] ) .', '. esc_attr( $p_gradient_color['to'] ) .');
				background-image: -moz-linear-gradient(left, '. esc_attr( $p_gradient_color['from'] ) .', '. esc_attr( $p_gradient_color['to'] ) .');
				background-image: -ms-linear-gradient(left, '. esc_attr( $p_gradient_color['from'] ) .', '. esc_attr( $p_gradient_color['to'] ) .');
				background-image: -o-linear-gradient(left, '. esc_attr( $p_gradient_color['from'] ) .', '. esc_attr( $p_gradient_color['to'] ) .');
				background-image: linear-gradient(left, '. esc_attr( $p_gradient_color['from'] ) .', '. esc_attr( $p_gradient_color['to'] ) .');
				filter: progid:DXImageTransform.Microsoft.gradient(startColorStr="'. esc_attr( $p_gradient_color['from'] ) .'", endColorStr="'. esc_attr( $p_gradient_color['to'] ) .'", gradientType="1");
	        }';

	        echo '.btn-gradient, body .btn.btn-slider4 {
	            background-image: -webkit-linear-gradient(90deg, '. esc_attr( $p_gradient_color['from'] ) .' 0%, '. esc_attr( $p_gradient_color['to'] ) .' 50%, '. esc_attr( $p_gradient_color['from'] ) .');
				background-image: -moz-linear-gradient(90deg, '. esc_attr( $p_gradient_color['from'] ) .' 0%, '. esc_attr( $p_gradient_color['to'] ) .' 50%, '. esc_attr( $p_gradient_color['from'] ) .');
				background-image: -ms-linear-gradient(90deg, '. esc_attr( $p_gradient_color['from'] ) .' 0%, '. esc_attr( $p_gradient_color['to'] ) .' 50%, '. esc_attr( $p_gradient_color['from'] ) .');
				background-image: -o-linear-gradient(90deg, '. esc_attr( $p_gradient_color['from'] ) .' 0%, '. esc_attr( $p_gradient_color['to'] ) .' 50%, '. esc_attr( $p_gradient_color['from'] ) .');
				background-image: linear-gradient(90deg, '. esc_attr( $p_gradient_color['from'] ) .' 0%, '. esc_attr( $p_gradient_color['to'] ) .' 50%, '. esc_attr( $p_gradient_color['from'] ) .');
				filter: progid:DXImageTransform.Microsoft.gradient(startColorStr="'. esc_attr( $p_gradient_color['from'] ) .'", endColorStr="'. esc_attr( $p_gradient_color['to'] ) .'");
	        }';
	    }

	    /* End Preset */

		/* Custom Css */
		$custom_css = organio_get_opt( 'site_css' );
		if ( ! empty( $custom_css ) ) {
			echo esc_attr( $custom_css );
		}

		return ob_get_clean();
	}
}

new CSS_Generator();