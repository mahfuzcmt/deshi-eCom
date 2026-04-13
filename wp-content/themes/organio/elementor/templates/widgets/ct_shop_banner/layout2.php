<?php
$default_settings = [
    'title_label' => '',
    'label_style' => '',
    'label_position' => '',
    'title_text' => '',
    'description_text' => '',
    'btn_text' => '',
    'btn_link' => '',
    'btn_style' => '',
    'fixed_image' => '',
    'animate_image' => '',
    'box_bg_image' => '',
    'ct_animate_title' => '',
    'ct_animate_delay_title' => '',
    'ct_animate_desc' => '',
    'ct_animate_delay_desc' => '',
    'ct_animate_btn' => '',
    'ct_animate_delay_btn' => '',
    'ct_animate' => '',
    'ct_animate_delay' => '',
    'ct_animate_label' => '',
    'ct_animate_delay_label' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings); 
if ( ! empty( $btn_link['url'] ) ) {
    $widget->add_render_attribute( 'button', 'href', $btn_link['url'] );

    if ( $btn_link['is_external'] ) {
        $widget->add_render_attribute( 'button', 'target', '_blank' );
    }

    if ( $btn_link['nofollow'] ) {
        $widget->add_render_attribute( 'button', 'rel', 'nofollow' );
    }
}
?>
<div class="ct-shop-banner ct-shop-banner2 bg-image <?php echo esc_attr($ct_animate); ?>" data-wow-delay="<?php echo esc_attr($ct_animate_delay); ?>ms" <?php if(!empty($box_bg_image['url'])) : ?>style="background-image: url(<?php echo esc_url($box_bg_image['url']); ?>);"<?php endif; ?>>
    <?php if(!empty($animate_image['id'])) : ?>
        <div class="item--image-animate wow">
            <?php $img_animate  = ct_get_image_by_size( array(
                    'attach_id'  => $animate_image['id'],
                    'thumb_size' => 'full',
                ) );
                $thumbnail_animate    = $img_animate['thumbnail'];
            echo ct_print_html($thumbnail_animate); ?>
        </div>
    <?php endif; ?>
    <div class="item--holder">
        <?php if(!empty($title_label)) : ?>
            <div class="item--title-label <?php echo esc_attr($label_position.' '.$label_style.' '.$ct_animate_label); ?>" data-wow-delay="<?php echo esc_attr($ct_animate_delay_label); ?>ms">
                <label><?php echo esc_attr($title_label); ?></label>
            </div>
        <?php endif; ?>
        <h4 class="item--title <?php echo esc_attr($ct_animate_title); ?>" data-wow-delay="<?php echo esc_attr($ct_animate_delay_title); ?>ms">
            <?php echo ct_print_html($title_text); ?>
        </h4>
        <div class="item--description <?php echo esc_attr($ct_animate_desc); ?>" data-wow-delay="<?php echo esc_attr($ct_animate_delay_desc); ?>ms"><?php echo ct_print_html($description_text); ?></div>
        <?php if ( ! empty( $btn_text ) ) { ?>
            <a class="btn item--button-<?php echo esc_attr($btn_style); ?> <?php echo esc_attr($ct_animate_btn); ?>" data-wow-delay="<?php echo esc_attr($ct_animate_delay_btn); ?>ms" <?php ct_print_html($widget->get_render_attribute_string( 'button' )); ?>>
                <?php echo esc_attr($btn_text); ?>
                <?php if($btn_style == 'btn-plus' || $btn_style == 'btn-plus-circle') { ?>
                    <i class="slider-icon-plus"></i>
                    <i class="slider-icon-plus hover"></i>
                <?php } else { ?>
                    <i class="flaticon-next"></i>
                <?php } ?>
            </a>
        <?php } ?>
    </div>
</div>