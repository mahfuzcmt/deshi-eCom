<?php
/**
 * Template part for displaying default header layout
 */
$custom_header = organio_get_page_opt( 'custom_header', false );
$sticky_on = organio_get_opt( 'sticky_on', false );
$sticky_header_type = organio_get_opt( 'sticky_header_type', 'scroll-to-bottom' );
$sticky_header_type_page = organio_get_page_opt( 'sticky_header_type_page', 'themeoption' );
if(isset($sticky_header_type_page) && !empty($sticky_header_type_page) && $sticky_header_type_page !== 'themeoption') {
    $sticky_header_type = $sticky_header_type_page;
}
$user_icon = organio_get_opt( 'user_icon', false );
$wishlist_icon = organio_get_opt( 'wishlist_icon', false );
$cart_icon = organio_get_opt( 'cart_icon', false );
$h_address_label = organio_get_opt( 'h_address_label' );
$h_address = organio_get_opt( 'h_address' );
$h_address_link = organio_get_opt( 'h_address_link' );
$h_phone_label = organio_get_opt( 'h_phone_label' );
$h_phone = organio_get_opt( 'h_phone' );
$h_phone_link = organio_get_opt( 'h_phone_link' );

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

$logo_mobile = organio_get_opt( 'logo_mobile', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );
$btn_custom_text = organio_get_page_opt( 'btn_custom_text' );
if($custom_header && !empty($btn_custom_text)) {
    $h_btn_text = $btn_custom_text;
}
?>
<header id="ct-masthead">
    <div id="ct-header-wrap" class="ct-header-layout10 <?php if($sticky_on == 1) { echo 'is-sticky '; echo esc_attr($sticky_header_type); } ?>" data-offset-sticky="200">
         <div id="ct-header-middle">
            <div class="container">
                <div class="row">
                    <div class="ct-header-branding">
                        <div class="ct-header-branding-inner">
                            <?php get_template_part( 'template-parts/header-branding' ); ?>
                        </div>
                    </div>
                    <div class="ct-header-info">
                        <?php if(!empty($h_phone_label) || !empty($h_phone_link) || !empty($h_phone)) : ?>
                            <div class="ct-header-info-item">
                                <div class="ct-header-icon">
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
                                <div class="ct-header-meta">
                                    <a href="tel:<?php echo esc_attr($h_phone_link); ?>"><?php echo esc_attr($h_phone); ?></a>
                                    <label><?php echo esc_attr($h_phone_label); ?></label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty($h_address_label) || !empty($h_address_link) || !empty($h_address)) : ?>
                            <div class="ct-header-info-item">
                                <div class="ct-header-icon">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <path d="M503.401,228.884l-43.253-39.411V58.79c0-8.315-6.741-15.057-15.057-15.057H340.976c-8.315,0-15.057,6.741-15.057,15.057
                                                v8.374l-52.236-47.597c-10.083-9.189-25.288-9.188-35.367-0.001L8.598,228.885c-8.076,7.36-10.745,18.7-6.799,28.889
                                                c3.947,10.189,13.557,16.772,24.484,16.772h36.689v209.721c0,8.315,6.741,15.057,15.057,15.057h125.913
                                                c8.315,0,15.057-6.741,15.057-15.057V356.931H293v127.337c0,8.315,6.741,15.057,15.057,15.057h125.908
                                                c8.315,0,15.057-6.741,15.056-15.057V274.547h36.697c10.926,0,20.537-6.584,24.484-16.772
                                                C514.147,247.585,511.479,236.245,503.401,228.884z M433.965,244.433c-8.315,0-15.057,6.741-15.057,15.057v209.721h-95.793
                                                V341.874c0-8.315-6.742-15.057-15.057-15.057H203.942c-8.315,0-15.057,6.741-15.057,15.057v127.337h-95.8V259.49
                                                c0-8.315-6.741-15.057-15.057-15.057H36.245l219.756-200.24l74.836,68.191c4.408,4.016,10.771,5.051,16.224,2.644
                                                c5.454-2.41,8.973-7.812,8.973-13.774V73.847h74.002v122.276c0,4.237,1.784,8.276,4.916,11.13l40.803,37.18H433.965z"/>
                                        </g>
                                    </svg>
                                </div>
                                <div class="ct-header-meta">
                                    <a href="<?php echo esc_url($h_address_link); ?>"><?php echo esc_attr($h_address); ?></a>
                                    <label><?php echo esc_attr($h_address_label); ?></label>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="ct-header-right">
                        <?php if(!empty($h_btn_text)) : ?>
                            <div class="ct-header-button">
                                <a class="btn btn-gradient" href="<?php echo esc_url($h_btn_link_temp); ?>"><?php echo esc_attr($h_btn_text); ?></a>
                            </div>
                        <?php endif; ?>
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
                        <div class="ct-header-shop-icons">
                            <?php if($wishlist_icon && class_exists('WPCleverWoosw')) : ?>
                                <div class="icon-item">
                                    <a class="ct-woosw-btn" href="<?php echo esc_url( WPCleverWoosw::get_url() ); ?>"></a>
                                    <i class="flaticon-wishlist"></i>
                                    <span class="wishlist-count">
                                        <?php echo WPcleverWoosw::get_count(); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <?php if(class_exists('Woocommerce') && $cart_icon) : ?>
                                <div class="icon-item h-btn-cart">
                                    <i class="flaticon-add-to-cart"></i>
                                    <span class="widget_cart_counter"><?php echo sprintf (_n( '%d', '%d', WC()->cart->cart_contents_count, 'organio' ), WC()->cart->cart_contents_count ); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if(function_exists('up_get_template_part') && $user_icon) : ?>
                                <div class="icon-item h-btn-user">
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