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

$nav = $widget->get_setting('nav');
$arrows = $widget->get_setting('arrows_nav');
$dots = $widget->get_setting('dots');
$pause_on_hover = $widget->get_setting('pause_on_hover');
$autoplay = $widget->get_setting('autoplay');
$autoplay_speed = $widget->get_setting('autoplay_speed', '5000');
$infinite = $widget->get_setting('infinite_nav');
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
    'data-centerMode' => 'true',
    'data-dir' => $carousel_dir,
] );
?>
<?php if(isset($settings['testimonial']) && !empty($settings['testimonial']) && count($settings['testimonial'])): ?>
    <div class="ct-testimonial ct-testimonial-carousel3 ct-slick-slider" <?php if($settings['drap']) : ?>data-cursor-label="<?php echo esc_html('DRAG', 'itfirm'); ?>"<?php endif; ?>>
        <div <?php ct_print_html($widget->get_render_attribute_string( 'inner' )); ?>>
            
            <div class="ct-testimonial-primary">
                <div <?php ct_print_html($widget->get_render_attribute_string( 'carousel' )); ?>>
                    <?php foreach ($settings['testimonial'] as $value) : 
                        $description = isset($value['description']) ? $value['description'] : '';
                        ?>
                        <div class="slick-slide">
                            <div class="item--inner <?php echo esc_attr($settings['ct_animate']); ?>">
                                <div class="item--description"><?php echo esc_html($description); ?></div>
                           </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="ct-testimonial-line"><i class="caseicon-quote-bottom"></i></div>
            <div class="ct-slick-nav" data-nav="<?php echo esc_attr($nav); ?>" data-dir="<?php echo esc_attr($carousel_dir); ?>" data-arrows="<?php echo esc_attr($arrows); ?>" data-infinite="<?php echo esc_attr($infinite); ?>">
                <?php foreach ($settings['testimonial'] as $value_nav) : 
                    $img = ct_get_image_by_size( array(
                        'attach_id'  => $value_nav['image']['id'],
                        'thumb_size' => '60x60',
                    ));
                    $thumbnail = $img['thumbnail'];
                    $title = isset($value_nav['title']) ? $value_nav['title'] : '';
                    $position = isset($value_nav['position']) ? $value_nav['position'] : '';
                    if(!empty($value_nav['image']['id'])) { ?>
                        <div class="slick-slide">
                            <div class="item--image">
                                <?php echo wp_kses_post($thumbnail); ?>
                            </div>
                            <div class="item--meta">
                                <h3 class="item--title">    
                                    <?php echo esc_attr($title); ?>
                                </h3>
                                <div class="item--position"><?php echo esc_attr($position); ?></div>
                            </div>
                        </div>
                    <?php } ?>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
<?php endif; ?>
