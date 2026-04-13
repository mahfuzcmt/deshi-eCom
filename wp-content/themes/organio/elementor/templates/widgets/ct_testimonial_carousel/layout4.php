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
    'class' => 'ct-slick-carousel',
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
    'data-vertical' => 'true',
] );
?>
<?php if(isset($settings['testimonial']) && !empty($settings['testimonial']) && count($settings['testimonial'])): ?>
    <div class="ct-testimonial ct-testimonial-carousel4 ct-slick-slider ct-dots-style3" <?php if($settings['drap']) : ?>data-cursor-label="<?php echo esc_html('DRAG', 'itfirm'); ?>"<?php endif; ?>>
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
                                        'thumb_size' => '100x100',
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
                                <svg version="1.1"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <path d="M392,77c-66.168,0-120,53.832-120,120c0,31.641,12.208,61.497,34.374,84.069c21.458,21.851,49.904,34.501,80.375,35.812
                                            c0.144,1.904,0.251,4.528,0.251,8.119c0,14.712-11.188,59.665-18.241,84.544L361.542,435h87.584l5.867-9.453
                                            C457.32,421.797,512,332.148,512,197C512,130.832,458.168,77,392,77z M426.189,395h-12.13C419.806,372.416,427,340.959,427,325
                                            c0-12.664-0.94-22.838-5.531-31.33c-4.089-7.564-12.641-16.573-30.183-16.669l-0.873-0.022C347.176,276.141,312,240.263,312,197
                                            c0-44.112,35.888-80,80-80s80,35.888,80,80C472,296.32,439.164,369.834,426.189,395z"/>
                                    </g>
                                </svg>
                           </div>
                        </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>