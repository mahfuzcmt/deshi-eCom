<?php
$default_settings = [
    'col_xl' => '4',
    'col_lg' => '4',
    'col_md' => '3',
    'col_sm' => '2',
    'col_xs' => '1',
    'image_fixed' => '1',
    'content_list' => '',
    'thumbnail_size' => '',
    'thumbnail_custom_dimension' => '',
    'ct_animate' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings);
$col_xl = 12 / intval($col_xl);
$col_lg = 12 / intval($col_lg);
$col_md = 12 / intval($col_md);
$col_sm = 12 / intval($col_sm);
$col_xs = 12 / intval($col_xs);
$grid_sizer = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
$item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
if($thumbnail_size != 'custom'){
    $img_size = $thumbnail_size;
}
elseif(!empty($thumbnail_custom_dimension['width']) && !empty($thumbnail_custom_dimension['height'])){
    $img_size = $thumbnail_custom_dimension['width'] . 'x' . $thumbnail_custom_dimension['height'];
}
else {
    $img_size = '176x176';
}
?>
<?php if(isset($content_list) && !empty($content_list) && count($content_list)): ?>
    <div class="ct-grid ct-team ct-team-grid1">
        <div class="ct-grid-inner ct-grid-masonry row animate-time" data-gutter="7">
            <?php foreach ($content_list as $key => $value):
    			$title = isset($value['title']) ? $value['title'] : '';
                $position = isset($value['position']) ? $value['position'] : '';
                $description = isset($value['description']) ? $value['description'] : '';
    			$image = isset($value['image']) ? $value['image'] : '';
    			$img = ct_get_image_by_size( array(
                    'attach_id'  => $image['id'],
                    'thumb_size' => $img_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                $social = isset($value['social']) ? $value['social'] : '';
            	?>
                <div class="<?php echo esc_attr($item_class); ?>">
                    <div class="item--inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                    	<?php if(!empty($image)) { ?>
                            <div class="item--image">
                                <?php echo wp_kses_post($thumbnail); ?>
                            </div>
                        <?php } ?>
                        <div class="item--holder">
                            <div class="item--meta">
                                <h3 class="item--title">    
                                    <?php echo ct_print_html($title); ?>
                                </h3>
                                <div class="item--position"><?php echo ct_print_html($position); ?></div>
                                <?php if(!empty($image_fixed['id'])) : ?>
                                    <div class="item--image-fixed">
                                        <?php $img_fixed  = ct_get_image_by_size( array(
                                                'attach_id'  => $image_fixed['id'],
                                                'thumb_size' => 'full',
                                            ) );
                                            $thumbnail_fixed    = $img_fixed['thumbnail'];
                                        echo ct_print_html($thumbnail_fixed);
                                        echo ct_print_html($thumbnail_fixed); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="item--description"><?php echo ct_print_html($description); ?></div>
                            <div class="item--social">
                                <?php if(!empty($social)):
                                    $team_social = json_decode($social, true); ?>
                                    <?php foreach ($team_social as $value): ?>
                                        <a href="<?php echo esc_url($value['url']); ?>"><i class="<?php echo esc_attr($value['icon']); ?>"></i></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                   </div>
                </div>
            <?php endforeach; ?>
            <div class="grid-sizer <?php echo esc_attr($grid_sizer); ?>"></div>
        </div>
    </div>
<?php endif; ?>
