<?php
$default_settings = [
    'selected_icon' => '',
    'sub_title' => '',
    'title' => '',
    'ct_animate' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings);

$has_icon = ! empty( $selected_icon );
if ( $has_icon ) {
    $widget->add_render_attribute( 'i', 'class', $selected_icon );
    $widget->add_render_attribute( 'i', 'aria-hidden', 'true' );
}
$is_new = \Elementor\Icons_Manager::is_migration_allowed();

?>
<div class="ct-info-box ct-info-box1 <?php echo esc_attr($ct_animate); ?>" data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay']); ?>ms">
	<div class="ct-infobox-inner">
        <?php if ( $has_icon ) : ?>
            <div class="item--icon icon-psb">
                <?php if($is_new):
                    \Elementor\Icons_Manager::render_icon( $selected_icon, [ 'aria-hidden' => 'true' ] );
                    else: ?>
                    <i <?php ct_print_html($widget->get_render_attribute_string( 'i' )); ?>></i>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="item--meta">
    		<div class="item--subtitle el-empty"><?php echo ct_print_html($sub_title); ?></div>
    		<h5 class="item--title el-empty"><?php echo ct_print_html($title); ?></h5>
        </div>
	</div>
</div>