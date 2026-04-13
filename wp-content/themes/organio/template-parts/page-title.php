<?php
$titles = organio_get_page_titles();

$pagetitle = organio_get_opt( 'pagetitle', 'show' );

$curve_display = organio_get_page_opt( 'curve_display', 'show');
$custom_pagetitle = organio_get_page_opt( 'custom_pagetitle', 'themeoption');
if($custom_pagetitle != 'themeoption' && $custom_pagetitle != '') {
    $pagetitle = $custom_pagetitle;
}

$sub_title = organio_get_page_opt( 'sub_title' );
$sub_title_position = organio_get_page_opt( 'sub_title_position', 'bottom-title' );
ob_start();
if ( $titles['title'] )
{
    printf( '<h1 class="page-title">%s</h1>', wp_kses_post($titles['title']) );
}
$titles_html = ob_get_clean();
$ptitle_breadcrumb_on = organio_get_opt( 'ptitle_breadcrumb_on', 'show' );
if(is_404()) {
    return true;
}
if($pagetitle == 'show') : ?>
    <div id="pagetitle" class="page-title bg-image <?php if($custom_pagetitle && $curve_display == 'hide' ) { echo 'curve-hide'; } ?>">
        <div class="container">
            <div class="page-title-inner">
                <div class="page-title-holder">
                    <?php if(!empty($sub_title)) : ?>
                        <h6 class="page-sub-title"><?php echo esc_attr($sub_title); ?></h6>
                    <?php endif; ?>
                    <?php printf( '%s', wp_kses_post($titles_html)); ?>
                </div>

                <?php if($ptitle_breadcrumb_on == 'show') : ?>
                    <?php organio_breadcrumb(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>