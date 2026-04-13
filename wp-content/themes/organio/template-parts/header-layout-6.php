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
$login_text = organio_get_opt( 'login_text' );
$login_link = organio_get_opt( 'login_link' );
$register_text = organio_get_opt( 'register_text' );
$register_link = organio_get_opt( 'register_link' );

$user_icon = organio_get_opt( 'user_icon', false );

$cart_icon = organio_get_opt( 'cart_icon', false );
$search_icon = organio_get_opt( 'search_icon', false );
$wishlist_icon = organio_get_opt( 'wishlist_icon', false );

$logo_mobile = organio_get_opt( 'logo_mobile', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );
?>
<header id="ct-masthead">
    <div id="ct-header-wrap" class="ct-header-layout5 ct-header-custom-layout6 <?php if($sticky_on == 1) { echo 'is-sticky '; echo esc_attr($sticky_header_type); } ?>" data-offset-sticky="100">
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
                            </div>
                        <?php endif; ?>
                        <div class="ct-topbar-social">
                            <?php organio_social_header(); ?>
                        </div>
                        <?php if(!empty($login_text) || !empty($register_text)) : ?>
                            <div class="ct-topbar-right ct-topbar-user">
                                <?php if(!is_user_logged_in()) : ?>
                                    <?php if(!empty($login_text)) { ?>
                                        <a href="<?php echo esc_url(get_permalink($login_link)); ?>"><?php echo esc_attr($login_text); ?></a> 
                                    <?php } else { ?>
                                        <a href="<?php echo esc_url(get_permalink($login_link)); ?>"><?php echo esc_html__('Login', 'organio'); ?></a>
                                    <?php } ?>

                                    <?php if(!empty($register_text)) { ?>
                                        <a href="<?php echo esc_url(get_permalink($register_link)); ?>"><?php echo esc_attr($register_text); ?></a>
                                    <?php } else { ?>
                                        <a href="<?php echo esc_url(get_permalink($register_link)); ?>"><?php echo esc_html__('Register', 'organio'); ?></a>
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