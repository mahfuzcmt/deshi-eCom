<?php
/**
 * Template part for displaying site branding
 */

$logo_dark = organio_get_opt( 'logo', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );
$logo_light = organio_get_opt( 'logo_light', array( 'url' => get_template_directory_uri().'/assets/images/logo-light.png', 'id' => '' ) );
$logo_mobile = organio_get_opt( 'logo_mobile', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );

$custom_header = organio_get_page_opt('custom_header');
$p_logo_dark = organio_get_page_opt('p_logo_dark');
$p_logo_light = organio_get_page_opt('p_logo_light');
$p_logo_mobile = organio_get_page_opt('p_logo_mobile');

if($custom_header && !empty($p_logo_dark['url'])) {
    $logo_dark['url'] = $p_logo_dark['url'];
}

if ($logo_dark['url']) {
    printf(
        '<a class="logo-dark" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name' ) ),
        esc_url( $logo_dark['url'] )
    );
}

if($custom_header && !empty($p_logo_light['url'])) {
    $logo_light['url'] = $p_logo_light['url'];
}

if ($logo_light['url']) {
    printf(
        '<a class="logo-light" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name' ) ),
        esc_url( $logo_light['url'] )
    );
}

if($custom_header && !empty($p_logo_mobile['url'])) {
    $logo_mobile['url'] = $p_logo_mobile['url'];
}

if ($logo_mobile['url']) {
    printf(
        '<a class="logo-mobile" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name' ) ),
        esc_url( $logo_mobile['url'] )
    );
}