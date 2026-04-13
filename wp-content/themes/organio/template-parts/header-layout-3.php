<?php
/**
 * Template part for displaying default header layout
 */
$menu_category_display = organio_get_opt( 'menu_category_display', 'always' );
$p_menu_category_display = organio_get_page_opt( 'p_menu_category_display', 'themeoption' );
if(isset($p_menu_category_display) && $p_menu_category_display !== 'themeoption') {
    $menu_category_display = $p_menu_category_display;
}
$sticky_on = organio_get_opt( 'sticky_on', false );
$sticky_header_type = organio_get_opt( 'sticky_header_type', 'scroll-to-bottom' );
$sticky_header_type_page = organio_get_page_opt( 'sticky_header_type_page', 'themeoption' );
if(isset($sticky_header_type_page) && !empty($sticky_header_type_page) && $sticky_header_type_page !== 'themeoption') {
    $sticky_header_type = $sticky_header_type_page;
}
$wishlist_icon = organio_get_opt( 'wishlist_icon', false );
$compare_icon = organio_get_opt( 'compare_icon', false );
$cart_icon = organio_get_opt( 'cart_icon', false );
$h_topbar = organio_get_opt( 'h_topbar', 'show' );
$short_text = organio_get_opt( 'short_text' );
$wellcome = organio_get_opt( 'wellcome' );
$login_text = organio_get_opt( 'login_text' );
$login_link = organio_get_opt( 'login_link' );
$register_text = organio_get_opt( 'register_text' );
$register_link = organio_get_opt( 'register_link' );
$language_switch = organio_get_opt( 'language_switch', false );
$user_icon = organio_get_opt( 'user_icon', false );
$logo_mobile = organio_get_opt( 'logo_mobile', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );
?>
<header id="ct-masthead">
    <div id="ct-header-wrap" class="ct-header-layout3 <?php if($sticky_on == 1) { echo 'is-sticky '; echo esc_attr($sticky_header_type); } ?>" data-offset-sticky="100">
        <?php if(!empty($short_text)) : ?>
            <div class="ct-topbar-shorttext">
                <div class="container">
                    <?php echo wp_kses_post($short_text); ?>
                    <i class="ct-icon-close"></i>
                </div>
            </div>
        <?php endif; ?>
        <?php if($h_topbar == 'show') : ?>
            <div id="ct-header-top" class="ct-header-top3">
                <div class="container">
                    <div class="row">
                        <?php if(!empty($wellcome)) : ?>
                            <div class="ct-topbar-wellcome">
                                <?php echo wp_kses_post($wellcome); ?>
                            </div>
                        <?php endif; ?>
                        <div class="ct-topbar-right">
                            <?php if ( has_nav_menu( 'menu-topbar2' ) ) {
                                $attr_menu = array(
                                    'theme_location' => 'menu-topbar2',
                                    'container'  => '',
                                    'menu_id'    => 'ct-menu-topbar2',
                                    'menu_class' => 'ct-menu-topbar2 clearfix',
                                    'link_before'     => '</span><span>',
                                    'link_after'      => '</span>',
                                    'depth'       => '1',
                                    'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                );
                                wp_nav_menu( $attr_menu );
                            } ?>
                            <div class="ct-topbar-social">
                                <?php organio_social_header(); ?>
                            </div>
                            <?php if($language_switch) : ?>
                                <?php if(class_exists('SitePress')) { ?>
                                    <div class="site-header-lang">
                                        <?php do_action('wpml_add_language_selector'); ?>
                                    </div>
                                <?php } else { 
                                    wp_enqueue_style('wpml-style', get_template_directory_uri() . '/assets/css/style-lang.css', array(), '1.0.0');
                                    ?>
                                    <div class="site-header-lang custom">
                                        <div class="wpml-ls-statics-shortcode_actions wpml-ls wpml-ls-legacy-dropdown js-wpml-ls-legacy-dropdown">
                                            <ul>
                                                <li tabindex="0" class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-en wpml-ls-current-language wpml-ls-first-item wpml-ls-item-legacy-dropdown">
                                                    <a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle"><span class="wpml-ls-native"><?php echo esc_html__('English', 'organio'); ?></span></a>
                                                    <ul class="wpml-ls-sub-menu">
                                                        <li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-fr">
                                                            <a href="#" class="wpml-ls-link"><span class="wpml-ls-native"><?php echo esc_html__('France', 'organio'); ?></span></a>
                                                        </li>
                                                        <li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-de wpml-ls-last-item">
                                                            <a href="#" class="wpml-ls-link"><span class="wpml-ls-native"><?php echo esc_html__('Russia', 'organio'); ?></span></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
         <div id="ct-header-middle">
            <div class="container">
                <div class="row">
                    <div class="ct-header-branding">
                        <div class="ct-header-branding-inner">
                            <?php get_template_part( 'template-parts/header-branding' ); ?>
                        </div>
                    </div>
                    <?php organio_get_product_search_h3(); ?>
                    <div class="ct-header-right">
                        <div class="ct-header-user">
                            <?php if(!is_user_logged_in()) : ?>
                                <?php if(!empty($login_text)) { ?>
                                    <a href="<?php echo esc_url(get_permalink($login_link)); ?>"><?php echo esc_attr($login_text); ?></a> 
                                <?php } else { ?>
                                    <a href="<?php echo esc_url(get_permalink($login_link)); ?>"><?php echo esc_html__('Login', 'organio'); ?></a>
                                <?php } ?>

                                <?php if(!empty($register_text)) { ?>
                                    / <a href="<?php echo esc_url(get_permalink($register_link)); ?>"><?php echo esc_attr($register_text); ?></a>
                                <?php } else { ?>
                                    / <a href="<?php echo esc_url(get_permalink($register_link)); ?>"><?php echo esc_html__('Register', 'organio'); ?></a>
                                <?php } ?>
                            <?php endif; ?>

                            <?php if(is_user_logged_in()) : ?>
                                <div class="h-btn-icon-user h-btn-user">
                                    <i class="flaticon-user"></i>
                                    <ul class="ct-user-account">
                                        <?php if(class_exists('WooCommerce') ) :
                                            $my_ac = get_option( 'woocommerce_myaccount_page_id' ); 
                                            ?>
                                            <li><a href="<?php echo esc_url(get_permalink($my_ac)); ?>"><?php echo esc_html__('My Account', 'organio'); ?></a></li>
                                        <?php endif; ?>
                                        <li><a href="<?php echo esc_url(wp_logout_url()); ?>"><?php echo esc_html__('Log Out', 'organio'); ?></a></li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="ct-header-shop-icons">
                            <?php if($wishlist_icon && class_exists('WPCleverWoosw')) : ?>
                                <div class="icon-item">
                                    <a class="ct-woosw-btn" href="<?php echo esc_url( WPCleverWoosw::get_url() ); ?>"></a>
                                    <i class="caseicon-heart-alt"></i>
                                    <span class="wishlist-count">
                                        <?php echo WPcleverWoosw::get_count(); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <?php if($compare_icon && class_exists('WPCleverWoosc')) : ?>
                                <div class="icon-item">
                                    <span class="woosc-btn wooscp-btn"></span>
                                    <i class="caseicon-random"></i>
                                </div>
                            <?php endif; ?>
                            <?php if(class_exists('Woocommerce') && $cart_icon) : ?>
                                <div class="icon-item h-btn-cart">
                                    <i class="caseicon-shopping-cart-alt"></i>
                                    <span class="widget_cart_counter"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count, 'organio' ), WC()->cart->cart_contents_count ); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="ct-header" class="ct-header-main">
            <div class="container">
                <div class="row">
                    <div class="ct-header-branding">
                        <div class="ct-header-branding-inner">
                            <?php get_template_part( 'template-parts/header-branding' ); ?>
                        </div>
                    </div>
                    <div class="ct-header-navigation">
                        <?php if ( has_nav_menu( 'menu-shop' ) ) { ?>
                            <div class="ct-menu-shop show-<?php echo esc_attr($menu_category_display); ?>">
                                <?php $attr_menu = array(
                                    'theme_location' => 'menu-shop',
                                    'container'  => '',
                                    'menu_id'    => 'ct-menu-shop',
                                    'menu_class' => 'ct-main-menu children-arrow ct-menu-shop clearfix',
                                    'link_before'     => '<span class="ct-icon-menu-lg"><i></i></span><span>',
                                    'link_after'      => '</span>',
                                    'depth'       => '3',
                                    'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                );
                                wp_nav_menu( $attr_menu ); ?>
                            </div>
                        <?php } ?>
                        <nav class="ct-main-navigation">
                            <div class="ct-main-navigation-inner">
                                <?php if ($logo_mobile['url']) { ?>
                                    <div class="ct-logo-mobile">
                                        <a href="<?php esc_url( esc_url( home_url( '/' ) ) ); ?>" title="<?php esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo_mobile['url'] ); ?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>"/></a>
                                    </div>
                                <?php } ?>
                                <?php organio_header_mobile_search(); ?>
                                <?php get_template_part( 'template-parts/header-menu' ); ?>
                                <?php if ( has_nav_menu( 'secondary' ) ) {
                                    $attr_menu = array(
                                        'theme_location' => 'secondary',
                                        'menu_class' => 'ct-menu-secondary clearfix',
                                        'depth'       => '1',
                                        'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                    );
                                    wp_nav_menu( $attr_menu );
                                } ?>
                            </div>
                        </nav>
                    </div>
                    <div class="ct-menu-overlay"></div>
                </div>
            </div>
            <div id="ct-menu-mobile">
                <?php if(function_exists('up_get_template_part') && $user_icon) : ?>
                    <div class="ct-mobile-meta-item h-btn-user">
                        <i class="flaticon-user"></i>
                        <?php if(is_user_logged_in()) : ?>
                                <ul class="ct-user-account">
                                <?php if(class_exists('WooCommerce') ) :
                                    $my_ac = get_option( 'woocommerce_myaccount_page_id' ); 
                                    ?>
                                    <li><a href="<?php echo esc_url(get_permalink($my_ac)); ?>"><?php echo esc_html__('My Account', 'organio'); ?></a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo esc_url(wp_logout_url()); ?>"><?php echo esc_html__('Log Out', 'organio'); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(class_exists('Woocommerce') && $cart_icon) : ?>
                    <div class="ct-mobile-meta-item btn-nav-cart">
                        <i class="caseicon-shopping-cart-alt"></i>
                    </div>
                <?php endif; ?>
                <div class="ct-mobile-meta-item btn-nav-mobile open-menu">
                    <span></span>
                </div>
            </div>
        </div>

    </div>
</header>