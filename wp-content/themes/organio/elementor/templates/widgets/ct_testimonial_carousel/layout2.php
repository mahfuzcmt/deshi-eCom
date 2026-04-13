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
?>
<?php if(isset($settings['testimonial']) && !empty($settings['testimonial']) && count($settings['testimonial'])): ?>
    <div class="ct-testimonial-wrap-l2">
        <?php if($settings['style_l2'] == 'style2') : ?>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 508.044 508.044" style="enable-background:new 0 0 508.044 508.044;" xml:space="preserve">
                <g>
                    <path d="M507.93,155.673c0-0.055,0.006-0.11,0.006-0.165c0-66.793-54.145-120.938-120.938-120.938S266.061,88.714,266.061,155.508
                        c0,66.794,54.15,120.938,120.938,120.938c13.727,0,26.867-2.393,39.162-6.609c-27.209,156.09-148.93,256.752-36.096,173.905
                        C515.182,351.874,508.07,159.198,507.93,155.673z"/>
                    <path d="M120.938,276.445c13.727,0,26.867-2.393,39.168-6.609c-27.216,156.09-148.937,256.752-36.102,173.905
                        c125.117-91.867,118.006-284.543,117.865-288.068c0-0.055,0.006-0.11,0.006-0.165c0-66.793-54.144-120.938-120.937-120.938
                        C54.144,34.57,0,88.714,0,155.508C0,222.302,54.15,276.445,120.938,276.445z"/>
                </g>        
            </svg>
        <?php endif; ?>
        <div class="ct-testimonial ct-testimonial-carousel2 <?php echo esc_attr($settings['style_l2']); ?> ct-arrow-<?php echo esc_attr($settings['arrow_style']); ?> ct-slick-slider" <?php if($settings['drap']) : ?>data-cursor-label="<?php echo esc_html('DRAG', 'itfirm'); ?>"<?php endif; ?>>
            <div <?php ct_print_html($widget->get_render_attribute_string( 'inner' )); ?>>
                <div <?php ct_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                    <?php foreach ($settings['testimonial'] as $value): 
                        $title = isset($value['title']) ? $value['title'] : '';
                        $position = isset($value['position']) ? $value['position'] : '';
                        $description = isset($value['description']) ? $value['description'] : '';
                        $image = isset($value['image']) ? $value['image'] : '';
                        ?>
                            <div class="slick-slide">
                                <div class="item--inner <?php echo esc_attr($settings['ct_animate']); ?>">
                                    <?php if(!empty($image['id'])) { 
                                        $img = ct_get_image_by_size( array(
                                            'attach_id'  => $image['id'],
                                            'thumb_size' => '86x86',
                                        ));
                                        $thumbnail = $img['thumbnail']; 
                                        ?>
                                        <div class="item--image">
                                            <?php echo wp_kses_post($thumbnail); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="item--meta">
                                        <div class="item--description <?php echo esc_attr($settings['ct_animate_d']); ?>" data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay_d']); ?>ms"><?php echo ct_print_html($description); ?></div>
                                        <h3 class="item--title <?php echo esc_attr($settings['ct_animate_t']); ?>" data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay_t']); ?>ms">    
                                            <?php echo esc_attr($title); ?>
                                        </h3>
                                        <div class="item--position <?php echo esc_attr($settings['ct_animate_p']); ?>" data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay_p']); ?>ms"><?php echo esc_attr($position); ?></div>
                                    </div>
                               </div>
                            </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>