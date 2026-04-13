<?php
$widget->add_render_attribute( 'inner', [
    'class' => 'ct-carousel-inner',
] );

$col_xs = $widget->get_setting('col_xs', '');
$col_sm = $widget->get_setting('col_sm', '');
$col_md = $widget->get_setting('col_md', '');
$col_lg = $widget->get_setting('col_lg', '');
$col_xl = $widget->get_setting('col_xl', '');
$slides_to_scroll = $widget->get_setting('slides_to_scroll', '');

$arrows = $widget->get_setting('arrows');
$dots = $widget->get_setting('dots');
$pause_on_hover = $widget->get_setting('pause_on_hover');
$autoplay = $widget->get_setting('autoplay', '');
$autoplay_speed = $widget->get_setting('autoplay_speed', '5000');
$infinite = $widget->get_setting('infinite');
$speed = $widget->get_setting('speed', '500');
if (is_rtl()) {
    $carousel_dir = 'true';
} else {
    $carousel_dir = 'false';
}
$widget->add_render_attribute( 'carousel', [
    'class' => 'ct-slick-carousel slick-shadow',
    'data-arrows' => $arrows,
    'data-dots' => $dots,
    'data-pauseOnHover' => $pause_on_hover,
    'data-autoplay' => $autoplay,
    'data-autoplaySpeed' => $autoplay_speed,
    'data-infinite' => $infinite,
    'data-speed' => $speed,
    'data-colxs' => $col_xs,
    'data-colsm' => $col_sm,
    'data-colmd' => $col_md,
    'data-collg' => $col_lg,
    'data-colxl' => $col_xl,
    'data-dir' => $carousel_dir,
    'data-slidesToScroll' => $slides_to_scroll,
] );
$html_id = ct_get_element_id($settings);
?>
<?php if(isset($settings['infobox']) && !empty($settings['infobox']) && count($settings['infobox'])): ?>
    <div class="ct-infobox ct-infobox-carousel1 ct-slick-slider ct-arrow-middle">
        <div <?php ct_print_html($widget->get_render_attribute_string( 'inner' )); ?>>
            <div <?php ct_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                <?php foreach ($settings['infobox'] as $key => $value): 
                    $title = isset($value['title']) ? $value['title'] : '';
                    $first_letter = isset($value['first_letter']) ? $value['first_letter'] : '';
                    $description = isset($value['description']) ? $value['description'] : '';
                    $image = isset($value['image']) ? $value['image'] : '';
                    $btn_text = isset($value['btn_text']) ? $value['btn_text'] : '';
                    $main_color = isset($value['main_color']) ? $value['main_color'] : '';
                    $link_key = $widget->get_repeater_setting_key( 'title', 'value', $key );
                    if ( ! empty( $value['btn_link']['url'] ) ) {
                        $widget->add_render_attribute( $link_key, 'href', $value['btn_link']['url'] );

                        if ( $value['btn_link']['is_external'] ) {
                            $widget->add_render_attribute( $link_key, 'target', '_blank' );
                        }

                        if ( $value['btn_link']['nofollow'] ) {
                            $widget->add_render_attribute( $link_key, 'rel', 'nofollow' );
                        }
                    }
                    $link_attributes = $widget->get_render_attribute_string( $link_key );
                    ?>
                        <div class="slick-slide">
                            <div id="<?php echo esc_attr($html_id); ?>-<?php echo esc_attr($key); ?>" class="item--inner <?php echo esc_attr($settings['ct_animate']); ?>" <?php if(!empty($main_color)) : ?>style="border-color: <?php echo esc_attr($main_color); ?>;"<?php endif; ?>>
                                <?php if(!empty($main_color)) : ?>
                                    <div class="ct-inline-css"  data-css="
                                        .ct-infobox-carousel1 #<?php echo esc_attr($html_id) ?>-<?php echo esc_attr($key); ?>.item--inner:hover .item--firstletter {
                                            color: <?php echo esc_attr($main_color); ?>;
                                        }
                                        .ct-infobox-carousel1 #<?php echo esc_attr($html_id) ?>-<?php echo esc_attr($key); ?>.item--inner .btn-icon-animate::before {
                                            background-color: <?php echo esc_attr($main_color); ?>;
                                        }">
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($image['id'])) { 
                                    $img = ct_get_image_by_size( array(
                                        'attach_id'  => $image['id'],
                                        'thumb_size' => 'full',
                                    ));
                                    $thumbnail = $img['thumbnail']; 
                                    ?>
                                    <div class="item--image">
                                        <?php  if(!empty($first_letter)) : ?>
                                            <div class="item--firstletter"><?php echo esc_attr($first_letter); ?></div>
                                        <?php endif; ?>
                                        <?php echo wp_kses_post($thumbnail); ?>
                                    </div>
                                <?php } ?>
                                <div class="item--meta">
                                    <h4 class="item--title <?php echo esc_attr($settings['ct_animate_t']); ?>" data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay_t']); ?>ms">    
                                        <?php echo esc_attr($title); ?>
                                    </h4>
                                    <div class="item--description <?php echo esc_attr($settings['ct_animate_d']); ?>" data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay_d']); ?>ms"><?php echo ct_print_html($description); ?></div>
                                    <?php if(!empty($btn_text)) : ?>
                                        <div class="item--readmore">
                                            <a class="btn-icon-animate" <?php echo implode( ' ', [ $link_attributes ] ); ?>>
                                                <i class="ct-icon-frist flaticon-next"></i>
                                                <?php echo esc_attr($btn_text); ?>
                                                <i class="ct-icon-last flaticon-next"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                           </div>
                        </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>