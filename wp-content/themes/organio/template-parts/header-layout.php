<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = organio_get_opt( 'sticky_on', false );
$sticky_header_type = organio_get_opt( 'sticky_header_type', 'scroll-to-bottom' );
$sticky_header_type_page = organio_get_page_opt( 'sticky_header_type_page', 'themeoption' );
if(isset($sticky_header_type_page) && !empty($sticky_header_type_page) && $sticky_header_type_page !== 'themeoption') {
    $sticky_header_type = $sticky_header_type_page;
}
$cart_icon = organio_get_opt( 'cart_icon', false );
$search_icon = organio_get_opt( 'search_icon', false );
$wishlist_icon = organio_get_opt( 'wishlist_icon', false );
$h_custom_menu_left = organio_get_page_opt( 'h_custom_menu_left' );
$h_custom_menu_right = organio_get_page_opt( 'h_custom_menu_right' );
$h_topbar = organio_get_opt( 'h_topbar', 'show' );
$wellcome = organio_get_opt( 'wellcome', '' );
$icon_has_children = organio_get_opt('icon_has_children', 'arrow');
$logo_mobile = organio_get_opt( 'logo_mobile', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );
?>
<header id="ct-masthead">
    <div id="ct-header-wrap" class="ct-header-layout1 item-menu-style1 fixed-height <?php if ( !(has_nav_menu( 'menu-left' )) && !(has_nav_menu( 'menu-right' )) ) { echo 'ct-header-reset'; } ?> <?php if($sticky_on == 1) { echo 'is-sticky '; echo esc_attr($sticky_header_type); } ?>" data-offset-sticky="100">
        <?php if($h_topbar == 'show') : ?>
            <div id="ct-header-top" class="ct-header-top1">
                <div class="container">
                    <div class="row">
                        <?php if(!empty($wellcome)) : ?>
                            <div class="ct-topbar-wellcome">
                                <?php echo wp_kses_post($wellcome); ?>
                            </div>
                        <?php endif; ?>
                        <div class="ct-topbar-cart">
                            <?php if(class_exists('Woocommerce') && $cart_icon) : ?>
                                <div class="header-right-item h-btn-cart">
                                    <i class="caseicon-shopping-cart"></i>
                                    <?php echo esc_html__('Cart', 'organio').':'; ?>
                                    <span class="widget_cart_counter_header"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count, 'organio' ), WC()->cart->cart_contents_count ); ?> - <span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div id="ct-header" class="ct-header-main">
            <div class="container">
                <div class="row">
                    <?php if ( has_nav_menu( 'menu-left' ) ) { ?>
                        <div class="ct-header-navigation ct-header-navigation-left">
                            <nav class="ct-main-navigation">
                                <div class="ct-main-navigation-inner">
                                    <?php
                                        $attr_menu = array(
                                            'theme_location' => 'menu-left',
                                            'container'  => '',
                                            'menu_id'    => 'ct-main-menu-left',
                                            'menu_class' => 'ct-main-menu children-'.$icon_has_children.' clearfix',
                                            'link_before'     => '<span>',
                                            'link_after'      => '</span>',
                                            'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                        );
                                        if(isset($h_custom_menu_left) && !empty($h_custom_menu_left)) {
                                            $attr_menu['menu'] = $h_custom_menu_left;
                                        }
                                        wp_nav_menu( $attr_menu );
                                    ?>
                                </div>
                            </nav>
                        </div>
                    <?php } ?>
                    <div class="ct-header-branding">
                        <div class="ct-header-branding-inner">
                            <?php get_template_part( 'template-parts/header-branding' ); ?>
                        </div>
                    </div>
                    <?php if ( has_nav_menu( 'menu-right' ) ) { ?>
                        <div class="ct-header-navigation ct-header-navigation-right">
                            <nav class="ct-main-navigation">
                                <div class="ct-main-navigation-inner">
                                    <?php if ($logo_mobile['url']) { ?>
                                        <div class="ct-logo-mobile">
                                            <a href="<?php esc_url( esc_url( home_url( '/' ) ) ); ?>" title="<?php esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo_mobile['url'] ); ?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>"/></a>
                                        </div>
                                    <?php } ?>
                                    <?php organio_header_mobile_search(); ?>
                                    <?php if ( has_nav_menu( 'menu-left' ) ) {
                                        $attr_menu = array(
                                            'theme_location' => 'menu-left',
                                            'container'  => '',
                                            'menu_id'    => 'ct-main-menu-left-mobile',
                                            'menu_class' => 'ct-main-menu children-'.$icon_has_children.' clearfix',
                                            'link_before'     => '<span>',
                                            'link_after'      => '</span>',
                                            'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                        );
                                        if(isset($h_custom_menu_left) && !empty($h_custom_menu_left)) {
                                            $attr_menu['menu'] = $h_custom_menu_left;
                                        }
                                        wp_nav_menu( $attr_menu );
                                    } 
                                    $attr_menu = array(
                                        'theme_location' => 'menu-right',
                                        'container'  => '',
                                        'menu_id'    => 'ct-main-menu-right',
                                        'menu_class' => 'ct-main-menu children-'.$icon_has_children.' clearfix',
                                        'link_before'     => '<span>',
                                        'link_after'      => '</span>',
                                        'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                    );
                                    if(isset($h_custom_menu_right) && !empty($h_custom_menu_right)) {
                                        $attr_menu['menu'] = $h_custom_menu_right;
                                    }
                                    wp_nav_menu( $attr_menu );
                                    ?>
                                </div>
                            </nav>
                            <div class="ct-header-meta">
                                <?php if($search_icon) : ?>
                                    <div class="header-right-item h-btn-search"><i class="caseicon-search"></i></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ( !(has_nav_menu( 'menu-left' )) && !(has_nav_menu( 'menu-right' )) ) { ?>
                        <div class="ct-header-navigation">
                            <nav class="ct-main-navigation">
                                <div class="ct-main-navigation-inner">
                                    <?php if ($logo_mobile['url']) { ?>
                                        <div class="ct-logo-mobile">
                                            <a href="<?php esc_url( esc_url( home_url( '/' ) ) ); ?>" title="<?php esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo_mobile['url'] ); ?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>"/></a>
                                        </div>
                                    <?php } ?>
                                    <?php get_template_part( 'template-parts/header-menu' ); ?>
                                </div>
                            </nav>
                            <div class="ct-header-right">
                                <div class="ct-header-icons">
                                    <?php if($wishlist_icon && class_exists('WPCleverWoosw')) : ?>
                                        <div class="icon-item">
                                            <a class="ct-woosw-btn" href="<?php echo esc_url( WPCleverWoosw::get_url() ); ?>">
                                                <i class="flaticon-love"></i>
                                                <span class="wishlist-count">
                                                    <?php echo WPcleverWoosw::get_count(); ?>
                                                </span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($search_icon) : ?>
                                        <div class="icon-item h-btn-search"><i class="flaticon-search"></i></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="ct-menu-overlay"></div>
                </div>
            </div>
            <div id="ct-menu-mobile">
                <?php if(class_exists('Woocommerce') && $cart_icon) : ?>
                    <div class="ct-mobile-meta-item btn-nav-cart">
                        <i class="caseicon-shopping-cart"></i>
                    </div>
                <?php endif; ?>
                <div class="ct-mobile-meta-item btn-nav-mobile open-menu">
                    <span></span>
                </div>
            </div>
        </div>

    </div>
</header>