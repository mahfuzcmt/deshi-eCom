<?php
if(!function_exists('organio_configs')){
    function organio_configs($value){
         
        $configs = [
            'theme_colors' => [
                'primary'   => [
                    'title' => esc_html__('Primary', 'organio').' ('.organio_get_opt('primary_color', '#76a713').')', 
                    'value' => organio_get_opt('primary_color', '#76a713')
                ],
                'secondary'   => [
                    'title' => esc_html__('Secondary', 'organio').' ('.organio_get_opt('secondary_color', '#191919').')', 
                    'value' => organio_get_opt('secondary_color', '#191919')
                ],
                'third'   => [
                    'title' => esc_html__('Third', 'organio').' ('.organio_get_opt('third_color', '#ff4b16').')', 
                    'value' => organio_get_opt('third_color', '#ff4b16')
                ],
                'dark'   => [
                    'title' => esc_html__('Dark', 'organio').' ('.organio_get_opt('dark_color', '#191919').')', 
                    'value' => organio_get_opt('dark_color', '#191919')
                ]
            ],
            'link' => [
                'color' => organio_get_opt('link_color', ['regular' => '#76a713'])['regular'],
                'color-hover'   => organio_get_opt('link_color', ['hover' => '#880c0c'])['hover'],
                'color-active'  => organio_get_opt('link_color', ['active' => '#880c0c'])['active'],
            ],
            'gradient' => [
                'color-from' => organio_get_opt('gradient_color', ['from' => '#fb5850'])['from'],
                'color-to' => organio_get_opt('gradient_color', ['to' => '#ffa200'])['to'],
            ],
               
        ];
        return $configs[$value];
    }
}
if(!function_exists('organio_inline_styles')) {
    function organio_inline_styles() {  
        
        $theme_colors      = organio_configs('theme_colors');
        $link_color        = organio_configs('link');
        $gradient_color        = organio_configs('gradient');
        ob_start();
        echo ':root{';
            
            foreach ($theme_colors as $color => $value) {
                printf('--%1$s-color: %2$s;', str_replace('#', '',$color),  $value['value']);
            }
            foreach ($theme_colors as $color => $value) {
                printf('--%1$s-color-rgb: %2$s;', str_replace('#', '',$color),  organio_hex_rgb($value['value']));
            }
            foreach ($link_color as $color => $value) {
                printf('--link-%1$s: %2$s;', $color, $value);
            } 
            foreach ($gradient_color as $color => $value) {
                printf('--gradient-%1$s: %2$s;', $color, $value);
            }
            foreach ($gradient_color as $color => $value) {
                printf('--gradient-%1$s-rgb: %2$s;', $color, organio_hex_rgb($value));
            }
        echo '}';

        return ob_get_clean();
         
    }
}
 