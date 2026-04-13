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

$h_topbar = organio_get_opt( 'h_topbar', 'show' );
$wellcome = organio_get_opt( 'wellcome' );
$h_phone = organio_get_opt( 'h_phone' );
$h_phone_link = organio_get_opt( 'h_phone_link' );
$h_address = organio_get_opt( 'h_address' );
$h_address_link = organio_get_opt( 'h_address_link' );

$h_btn_link_temp = '';
$h_btn_text = organio_get_opt( 'h_btn_text' );
$h_btn_link_type = organio_get_opt( 'h_btn_link_type', 'page-link' );
$h_btn_link = organio_get_opt( 'h_btn_link' );
$h_btn_external_link = organio_get_opt( 'h_btn_external_link' );
if($h_btn_link_type == 'page-link') {
    $h_btn_link_temp = get_permalink($h_btn_link);
} else {
    $h_btn_link_temp = $h_btn_external_link;
}

$cart_icon = organio_get_opt( 'cart_icon', false );
$search_icon = organio_get_opt( 'search_icon', false );
$wishlist_icon = organio_get_opt( 'wishlist_icon', false );

$logo_mobile = organio_get_opt( 'logo_mobile', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );
?>
<header id="ct-masthead">
    <div id="ct-header-wrap" class="ct-header-layout5 <?php if($sticky_on == 1) { echo 'is-sticky '; echo esc_attr($sticky_header_type); } ?>" data-offset-sticky="100">
        <?php if($h_topbar == 'show') : ?>
            <div id="ct-header-top" class="ct-header-top4">
                <div class="container">
                    <div class="row">
                        <?php if(!empty($wellcome)) : ?>
                            <div class="ct-topbar-left">
                                <?php if(!empty($wellcome)) : ?>
                                    <div class="ct-topbar-item">
                                        <?php echo wp_kses_post($wellcome); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($h_phone)) : ?>
                                    <div class="ct-topbar-item">
                                        <a href="tel:<?php echo esc_attr($h_phone_link); ?>"><i class="flaticon-contact"></i><?php echo wp_kses_post($h_phone); ?></a>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($h_address)) : ?>
                                    <div class="ct-topbar-item">
                                        <a href="<?php echo esc_url($h_address_link); ?>"><i class="flaticon-location-pin"></i><?php echo wp_kses_post($h_address); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($h_btn_text)) : ?>
                            <div class="ct-topbar-right">
                                <div class="ct-topbar-button">
                                    <a class="btn btn-third-dot" href="<?php echo esc_url($h_btn_link_temp); ?>"><?php echo esc_attr($h_btn_text); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div id="ct-header" class="ct-header-main">
            <div class="container">
                <div class="row">
                    <div class="ct-header-branding">
                        <div class="ct-header-branding-inner">
                            <?php get_template_part( 'template-parts/header-branding' ); ?>
                        </div>
                    </div>
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
                                <?php if(class_exists('Woocommerce') && $cart_icon) : ?>
                                    <div class="icon-item h-btn-cart">
                                        <i class="flaticon-cart-1"></i>
                                        <span class="widget_cart_counter"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count, 'organio' ), WC()->cart->cart_contents_count ); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if($search_icon) : ?>
                                    <div class="icon-item h-btn-search"><i class="flaticon-search"></i></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="ct-menu-overlay"></div>
                </div>
            </div>
            <div id="ct-menu-mobile">
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