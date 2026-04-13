<?php
$default_settings = [
    'style' => '',
    'class' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings); ?>
<div class="ct-nav-carousel <?php echo esc_attr($style); ?> <?php echo esc_attr($class); ?>">
    <div class="nav-prev"><i class="caseicon-long-arrow-right-three"></i></div>
    <div class="nav-next"><i class="caseicon-long-arrow-right-three"></i></div>
</div>