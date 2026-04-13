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
$h_topbar = organio_get_opt( 'h_topbar', 'show' );
$wellcome = organio_get_opt( 'wellcome' );
$h_phone_label = organio_get_opt( 'h_phone_label' );
$h_phone = organio_get_opt( 'h_phone' );
$language_switch = organio_get_opt( 'language_switch', false );
$h_phone_link = organio_get_opt( 'h_phone_link' );
$logo_mobile = organio_get_opt( 'logo_mobile', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );
?>
<header id="ct-masthead">
    <div id="ct-header-wrap" class="ct-header-layout2 fixed-height <?php if($sticky_on == 1) { echo 'is-sticky '; echo esc_attr($sticky_header_type); } ?>" data-offset-sticky="100">
        <?php if($h_topbar == 'show') : ?>
            <div id="ct-header-top" class="ct-header-top2">
                <div class="container">
                    <div class="row">
                        <?php if(!empty($wellcome)) : ?>
                            <div class="ct-topbar-wellcome">
                                <?php echo wp_kses_post($wellcome); ?>
                            </div>
                        <?php endif; ?>
                        <div class="ct-topbar-right">
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
                                                    <a href="#" class="js-wpml-ls-item-toggle wpml-ls-item-toggle"><img class="wpml-ls-flag" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/flag/en.png'); ?>" alt="en" title="English"><span class="wpml-ls-native"><?php echo esc_html__('English', 'organio'); ?></span></a>
                                                    <ul class="wpml-ls-sub-menu">
                                                        <li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-fr">
                                                            <a href="#" class="wpml-ls-link"><img class="wpml-ls-flag" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/flag/fr.png'); ?>" alt="fr" title="France"><span class="wpml-ls-native"><?php echo esc_html__('France', 'organio'); ?></span></a>
                                                        </li>
                                                        <li class="wpml-ls-slot-shortcode_actions wpml-ls-item wpml-ls-item-de wpml-ls-last-item">
                                                            <a href="#" class="wpml-ls-link"><img class="wpml-ls-flag" src="<?php echo esc_url(get_template_directory_uri().'/assets/images/flag/ru.png'); ?>" alt="ue" title="Russia"><span class="wpml-ls-native"><?php echo esc_html__('Russia', 'organio'); ?></span></a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php endif; ?>
                            <?php if ( has_nav_menu( 'menu-topbar' ) ) {
                                $attr_menu = array(
                                    'theme_location' => 'menu-topbar',
                                    'container'  => '',
                                    'menu_id'    => 'ct-menu-topbar',
                                    'menu_class' => 'ct-main-menu children-arrow ct-menu-topbar clearfix',
                                    'link_before'     => '</span><span>',
                                    'link_after'      => '</span>',
                                    'depth'       => '1',
                                    'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                );
                                wp_nav_menu( $attr_menu );
                            } ?>
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
                    <?php organio_get_product_search(); ?>
                    <?php if(!empty($h_phone_label) || !empty($h_phone_link) || !empty($h_phone)) : ?>
                        <div class="ct-header-phone">
                            <div class="ct-header-phone-icon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <path d="M256,0C131.935,0,31,100.935,31,225c0,13.749,0,120.108,0,122c0,24.813,20.187,45,45,45h17.58
                                            c6.192,17.458,22.865,30,42.42,30c24.813,0,45-20.187,45-45V255c0-24.813-20.187-45-45-45c-19.555,0-36.228,12.542-42.42,30H76
                                            c-5.259,0-10.305,0.915-15,2.58V225c0-107.523,87.477-195,195-195s195,87.477,195,195v17.58c-4.695-1.665-9.741-2.58-15-2.58
                                            h-17.58c-6.192-17.458-22.865-30-42.42-30c-24.813,0-45,20.187-45,45v122c0,24.813,20.187,45,45,45
                                            c4.541,0,8.925-0.682,13.061-1.939C383.45,438.523,366.272,452,346,452h-47.58c-6.192-17.458-22.865-30-42.42-30
                                            c-24.813,0-45,20.187-45,45s20.187,45,45,45c19.555,0,36.228-12.542,42.42-30H346c41.355,0,75-33.645,75-75v-15h15
                                            c24.813,0,45-20.187,45-45c0-1.864,0-108.262,0-122C481,100.935,380.065,0,256,0z M121,255c0-8.271,6.729-15,15-15s15,6.729,15,15
                                            v122c0,8.271-6.729,15-15,15s-15-6.729-15-15V255z M76,270h15v92H76c-8.271,0-15-6.729-15-15v-62C61,276.729,67.729,270,76,270z
                                             M256,482c-8.271,0-15-6.729-15-15s6.729-15,15-15s15,6.729,15,15S264.271,482,256,482z M391,377c0,8.271-6.729,15-15,15
                                            s-15-6.729-15-15V255c0-8.271,6.729-15,15-15s15,6.729,15,15V377z M451,347c0,8.271-6.729,15-15,15h-15v-92h15
                                            c8.271,0,15,6.729,15,15V347z"/>
                                    </g>
                                </svg>
                            </div>
                            <div class="ct-header-phone-meta">
                                <label><?php echo esc_attr($h_phone_label); ?></label>
                                <a href="tel:<?php echo esc_attr($h_phone_link); ?>"><?php echo esc_attr($h_phone); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
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
                        <div class="ct-menu-shop">
                            <?php if ( has_nav_menu( 'menu-shop' ) ) {
                                $attr_menu = array(
                                    'theme_location' => 'menu-shop',
                                    'container'  => '',
                                    'menu_id'    => 'ct-menu-shop',
                                    'menu_class' => 'ct-main-menu children-arrow ct-menu-shop clearfix',
                                    'link_before'     => '<span class="ct-icon-menu"><i></i></span><span>',
                                    'link_after'      => '</span>',
                                    'depth'       => '3',
                                    'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                                );
                                wp_nav_menu( $attr_menu );
                            } ?>
                        </div>
                        <nav class="ct-main-navigation">
                            <div class="ct-main-navigation-inner">
                                <?php if ($logo_mobile['url']) { ?>
                                    <div class="ct-logo-mobile">
                                        <a href="<?php esc_url( esc_url( home_url( '/' ) ) ); ?>" title="<?php esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo_mobile['url'] ); ?>" alt="<?php esc_attr( get_bloginfo( 'name' ) ); ?>"/></a>
                                    </div>
                                <?php } ?>
                                <?php organio_header_mobile_search(); ?>
                                <?php get_template_part( 'template-parts/header-menu' ); ?>
                            </div>
                        </nav>
                        <?php if(class_exists('Woocommerce') && $cart_icon) : ?>
                            <div class="header-right-item h-btn-cart">
                                <i class="caseicon-shopping-cart"></i>
                                <?php echo esc_html__('Cart', 'organio').':'; ?>
                                <span class="widget_cart_counter_header"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count, 'organio' ), WC()->cart->cart_contents_count ); ?> - <span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span></span>
                            </div>
                        <?php endif; ?>
                    </div>
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