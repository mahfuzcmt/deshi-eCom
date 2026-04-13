<?php
$widget->add_render_attribute( 'selected_icon', 'class' );
$has_icon = ! empty( $settings['selected_icon'] );
if ( $has_icon ) {
    $widget->add_render_attribute( 'i', 'class', $settings['selected_icon'] );
    $widget->add_render_attribute( 'i', 'aria-hidden', 'true' );
}
$is_new = \Elementor\Icons_Manager::is_migration_allowed();
?>
<div class="ct-phone-call1 <?php echo esc_attr($settings['ct_animate']); ?>" data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay']); ?>ms">
    <div class="item--inner">
        <?php if ( $has_icon ) : ?>
            <div class="item--icon">
                <?php if($is_new):
                    \Elementor\Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                    else: ?>
                    <i <?php ct_print_html($widget->get_render_attribute_string( 'i' )); ?>></i>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="item--meta">
            <a href="<?php echo esc_attr($settings['phone_link']); ?>" class="item--number">
                <?php echo esc_attr($settings['phone_number']); ?>
            </a>
            <label class="item--label"><?php echo esc_attr($settings['phone_label']); ?></label>
        </div>
    </div>
</div>