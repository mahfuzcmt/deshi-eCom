<?php
$default_settings = [
    'date' => '2030/10/10',
    'ct_day' => '',
    'ct_hour' => '',
    'ct_minute' => '',
    'ct_second' => '',
    'title' => '',
    'sub_title' => '',
    'image' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings); 
$month = esc_html__('Month', 'organio');
$months = esc_html__('Months', 'organio');
$day = esc_html__('Day', 'organio');
$days = esc_html__('Days', 'organio');
$hour = esc_html__('Hour', 'organio');
$hours = esc_html__('Hours', 'organio');
$minute = esc_html__('Minute', 'organio');
$minutes = esc_html__('Minutes', 'organio');
$second = esc_html__('Second', 'organio');
$seconds = esc_html__('Seconds', 'organio');
?>
<div class="ct-countdown-banner1">
	<div class="item--inner">
        <?php if(!empty($image['id'])) { 
            $img = ct_get_image_by_size( array(
                'attach_id'  => $image['id'],
                'thumb_size' => 'full',
            ));
            $thumbnail = $img['thumbnail']; 
            ?>
            <div class="item--image">
                <?php echo wp_kses_post($thumbnail); ?>
            </div>
        <?php } ?>
        <div class="item--subtitle">
            <?php echo esc_attr($sub_title); ?>
        </div>
        <h4 class="item--title">    
            <?php echo esc_attr($title); ?>
        </h4>
		<div class="ct-countdown ct-countdown-layout2 <?php echo esc_attr($settings['ct_animate']); ?> <?php echo esc_attr($ct_day.' '.$ct_hour.' '.$ct_minute.' '.$ct_second); ?>" 
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
	</div>
</div>