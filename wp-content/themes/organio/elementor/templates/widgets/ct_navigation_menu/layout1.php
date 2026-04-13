<?php
$default_settings = [
    'menu' => '',
    'style' => '',
];
$settings = array_merge($default_settings, $settings);
extract($settings);
$html_id = ct_get_element_id($settings); 
if(!empty($menu)) : ?>
    <?php if($style == 'default' || $style == 'style1' || $style == 'style2' || $style == 'style4') : ?>
        <div id="<?php echo esc_attr($html_id); ?>" class="ct-navigation-menu1 <?php echo esc_attr($style); ?>">
            <?php wp_nav_menu(array(
                'fallback_cb' => '',
                'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                'link_before'     => '<span>',
                'link_after'      => '</span>',
                'depth'       => '1',
                'menu'        => wp_get_nav_menu_object($menu))
            ); ?>
        </div>
    <?php endif; ?>
    <?php if($style == 'style3') : ?>
        <div id="<?php echo esc_attr($html_id); ?>" class="ct-navigation-menu1 <?php echo esc_attr($style); ?>">
            <?php wp_nav_menu(array(
                'menu_id'    => 'ct-main-menu',
                'menu_class' => 'ct-main-menu clearfix',
                'link_before'     => '<span>',
                'link_after'      => '</span><span class="menu-line"></span><span class="menu-icon-plus"></span>',
                'walker'         => class_exists( 'EFramework_Mega_Menu_Walker' ) ? new EFramework_Mega_Menu_Walker : '',
                'menu'        => wp_get_nav_menu_object($menu))
            ); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>