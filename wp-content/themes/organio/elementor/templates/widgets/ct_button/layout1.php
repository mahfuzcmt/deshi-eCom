<?php
$widget->add_render_attribute( 'wrapper', 'class', 'ct-button-wrapper ct-button-layout1' );

if ( ! empty( $settings['link']['url'] ) ) {
    $widget->add_render_attribute( 'button', 'href', $settings['link']['url'] );

    if ( $settings['link']['is_external'] ) {
        $widget->add_render_attribute( 'button', 'target', '_blank' );
    }

    if ( $settings['link']['nofollow'] ) {
        $widget->add_render_attribute( 'button', 'rel', 'nofollow' );
    }
}

$widget->add_render_attribute( 'button', 'class', 'btn '.$settings['style'].' '.$settings['ct_animate'].' icon-ps-'.$settings['icon_align'].' ' );

if ( ! empty( $settings['button_css_id'] ) ) {
    $widget->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
}

$is_new = \Elementor\Icons_Manager::is_migration_allowed();
$html_id = ct_get_element_id($settings);

?>
<div id="<?php echo esc_attr($html_id); ?>" <?php ct_print_html($widget->get_render_attribute_string( 'wrapper' )); ?>>
    <div class="ct-inline-css"  data-css="
        <?php if( !empty($settings['btn_bg_color']) && !empty($settings['btn_bg_color_gradient']) ) : ?>
            #<?php echo esc_attr($html_id) ?>.ct-button-wrapper .btn {
                background-image: -webkit-gradient(linear, left top, left bottom, from(<?php echo esc_attr($settings['btn_bg_color']); ?>), to(<?php echo esc_attr($settings['btn_bg_color_gradient']); ?>)) !important;
                background-image: -webkit-linear-gradient(left, <?php echo esc_attr($settings['btn_bg_color']); ?>, <?php echo esc_attr($settings['btn_bg_color_gradient']); ?>) !important;
                background-image: -moz-linear-gradient(left, <?php echo esc_attr($settings['btn_bg_color']); ?>, <?php echo esc_attr($settings['btn_bg_color_gradient']); ?>) !important;
                background-image: -ms-linear-gradient(left, <?php echo esc_attr($settings['btn_bg_color']); ?>, <?php echo esc_attr($settings['btn_bg_color_gradient']); ?>) !important;
                background-image: -o-linear-gradient(left, <?php echo esc_attr($settings['btn_bg_color']); ?>, <?php echo esc_attr($settings['btn_bg_color_gradient']); ?>) !important;
                background-image: linear-gradient(left, <?php echo esc_attr($settings['btn_bg_color']); ?>, <?php echo esc_attr($settings['btn_bg_color_gradient']); ?>) !important;
                filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='<?php echo esc_attr($settings['btn_bg_color']); ?>', endColorStr='<?php echo esc_attr($settings['btn_bg_color_gradient']); ?>') !important;
                background-color: transparent !important;
            }
        <?php endif; ?>">
    </div>

    <?php if(!empty($settings['btn_icon'])) : ?>
        <span class="ct-icon-active"></span>
    <?php endif; ?>
    <a <?php ct_print_html($widget->get_render_attribute_string( 'button' )); ?> data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay']); ?>ms">
        <?php
        $widget->add_render_attribute( [
			'icon-align' => [
				'class' => [
					'ct-button-icon',
					'ct-align-icon-' . $settings['icon_align'],
				],
			],
			'text' => [
				'class' => 'ct-button-text',
			],
		] );

		$widget->add_inline_editing_attributes( 'text', 'none' ); ?>
        <?php if ( $is_new ): ?>
            <span <?php ct_print_html($widget->get_render_attribute_string( 'icon-align' )); ?>>
                <?php \Elementor\Icons_Manager::render_icon( $settings['btn_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </span>
        <?php elseif(!empty($settings['btn_icon'])): ?>
            <span <?php ct_print_html($widget->get_render_attribute_string( 'icon-align' )); ?>>
                <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
            </span>
        <?php endif; ?>
        <span <?php ct_print_html($widget->get_render_attribute_string( 'text' )); ?>><?php echo esc_html($settings['text']); ?></span>
    </a>
</div>