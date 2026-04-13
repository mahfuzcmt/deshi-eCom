<?php
$default_settings = [
    'date' => '2030/10/10',
    'ct_day' => '',
    'ct_hour' => '',
    'ct_minute' => '',
    'ct_second' => '',
    'style' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings); 
$month = esc_html__('Month', 'organio');
$months = esc_html__('Months', 'organio');
$day = esc_html__('Day', 'organio');
$days = esc_html__('Days', 'organio');
if($style == 'style1' || $style == 'style4' || $style == 'style5') {
	$hour = esc_html__('Hour', 'organio');
	$hours = esc_html__('Hours', 'organio');
	$minute = esc_html__('Minute', 'organio');
	$minutes = esc_html__('Minutes', 'organio');
	$second = esc_html__('Second', 'organio');
	$seconds = esc_html__('Seconds', 'organio');
} else {
	$hour = esc_html__('Hour', 'organio');
	$hours = esc_html__('Hour', 'organio');
	$minute = esc_html__('Min', 'organio');
	$minutes = esc_html__('Min', 'organio');
	$second = esc_html__('Sec', 'organio');
	$seconds = esc_html__('Sec', 'organio');
}
?>
<div class="ct-countdown ct-countdown-layout1 <?php echo esc_attr($settings['ct_animate']); ?> <?php echo esc_attr($style.' '.$ct_day.' '.$ct_hour.' '.$ct_minute.' '.$ct_second); ?>" 
	data-month="<?php echo esc_attr($month) ?>"
	data-months="<?php echo esc_attr($months) ?>"
	data-day="<?php echo esc_attr($day) ?>"
	data-days="<?php echo esc_attr($days) ?>"
	data-hour="<?php echo esc_attr($hour) ?>"
	data-hours="<?php echo esc_attr($hours) ?>"
	data-minute="<?php echo esc_attr($minute) ?>"
	data-minutes="<?php echo esc_attr($minutes) ?>"
	data-second="<?php echo esc_attr($second) ?>"
	data-seconds="<?php echo esc_attr($seconds) ?>" data-wow-delay="<?php echo esc_attr($settings['ct_animate_delay']); ?>ms">
	<div class="ct-countdown-inner" data-count-down="<?php echo esc_attr($date);?>"></div>
</div>