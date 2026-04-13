<?php
/**
 * Helper functions for the theme
 *
 * @package Organio
 */

/**
 * Get Post List 
*/
if(!function_exists('organio_list_post')){
    function organio_list_post($post_type = 'post', $default = false){
        $post_list = array();
        $posts = get_posts(array('post_type' => $post_type,'posts_per_page' => '-1'));
        foreach($posts as $post){
            $post_list[$post->ID] = $post->post_title;
        }
        return $post_list;
    }
}

/**
 * Get theme option based on its id.
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function organio_get_opt( $opt_id, $default = false ) {
	$opt_name = organio_get_opt_name();
	if ( empty( $opt_name ) ) {
		return $default;
	}

	global ${$opt_name};
	if ( ! isset( ${$opt_name} ) || ! isset( ${$opt_name}[ $opt_id ] ) ) {
		$options = get_option( $opt_name );
	} else {
		$options = ${$opt_name};
	}
	if ( ! isset( $options ) || ! isset( $options[ $opt_id ] ) || $options[ $opt_id ] === '' ) {
		return $default;
	}
	if ( is_array( $options[ $opt_id ] ) && is_array( $default ) ) {
		foreach ( $options[ $opt_id ] as $key => $value ) {
			if ( isset( $default[ $key ] ) && $value === '' ) {
				$options[ $opt_id ][ $key ] = $default[ $key ];
			}
		}
	}

	return $options[ $opt_id ];
}

/**
 * Get theme option based on its id.
 *
 * @param  string $opt_id Required. the option id.
 * @param  mixed $default Optional. Default if the option is not found or not yet saved.
 *                         If not set, false will be used
 *
 * @return mixed
 */
function organio_get_page_opt( $opt_id, $default = false ) {
	$page_opt_name = organio_get_page_opt_name();
	if ( empty( $page_opt_name ) ) {
		return $default;
	}
	$id = get_the_ID();
	if ( ! is_archive() && is_home() ) {
		if ( ! is_front_page() ) {
			$page_for_posts = get_option( 'page_for_posts' );
			$id             = $page_for_posts;
		}
	}

	// Get page option for Shop Page
    if(class_exists('WooCommerce') && is_shop()){
        $id = get_option( 'woocommerce_shop_page_id' );
    }

	return $options = ! empty($id) ? get_post_meta( intval( $id ), $opt_id, true ) : $default;
}

/**
 *
 * Get post format values.
 *
 * @param $post_format_key
 * @param bool $default
 *
 * @return bool|mixed
 */
function organio_get_post_format_value( $post_format_key, $default = false ) {
	global $post;

	return $value = ! empty( $post->ID ) ? get_post_meta( $post->ID, $post_format_key, true ) : $default;
}


/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function organio_get_opt_name_default(){
	return apply_filters( 'organio_opt_name', 'ct_theme_options' );
}

function organio_get_opt_name() {
	if(isset($_POST['opt_name']) && !empty($_POST['opt_name'])){
		return $_POST['opt_name'];
	}
	$opt_name = organio_get_opt_name_default();
	if(defined('ICL_LANGUAGE_CODE')){
		if(ICL_LANGUAGE_CODE != 'all' && !empty(ICL_LANGUAGE_CODE)){
			$opt_name = $opt_name.'_'.ICL_LANGUAGE_CODE;
		}
	}
	return $opt_name;
}

/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function organio_get_page_opt_name() {
	return apply_filters( 'organio_page_opt_name', 'ct_page_options' );
}

/**
 * Get opt_name for Redux Framework options instance args and for
 * getting option value.
 *
 * @return string
 */
function organio_get_post_opt_name() {
	return apply_filters( 'organio_post_opt_name', 'organio_post_options' );
}

/**
 * Get page title and description.
 *
 * @return array Contains 'title'
 */
function organio_get_page_titles() {
	$title = '';
	$product_title = organio_get_opt( 'product_title', false );
	// Default titles
	if ( ! is_archive() ) {
		// Posts page view
		if ( is_home() ) {
			// Only available if posts page is set.
			if ( ! is_front_page() && $page_for_posts = get_option( 'page_for_posts' ) ) {
				$title = get_post_meta( $page_for_posts, 'custom_title', true );
				if ( empty( $title ) ) {
					$title = get_the_title( $page_for_posts );
				}
			}
			if ( is_front_page() ) {
				$title = esc_html__( 'Blog', 'organio' );
			}
		} // Single page view
        elseif ( is_page() ) {
			$title = get_post_meta( get_the_ID(), 'custom_title', true );
			if ( ! $title ) {
				$title = get_the_title();
			}
		} elseif ( is_404() ) {
			$title = esc_html__( '404', 'organio' );
		} elseif ( is_search() ) {
			$title = esc_html__( 'Search results', 'organio' );
		} elseif(is_singular('product') && $product_title == true) {
			$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
		} else {
			$title = get_post_meta( get_the_ID(), 'custom_title', true );
			if ( ! $title ) {
				$title = get_the_title();
			}
		}
	} else {
		$title = get_the_archive_title();
		if( (class_exists( 'WooCommerce' ) && is_shop()) ) {
			$title = get_post_meta( wc_get_page_id('shop'), 'custom_title', true );
			if(!$title) {
				$title = get_the_title( get_option( 'woocommerce_shop_page_id' ) );
			}
		}
	}

	return array(
		'title' => $title,
	);
}

add_filter( 'get_the_archive_title', 'organio_archive_title_remove_label' );
function organio_archive_title_remove_label( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = get_the_author();
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_home() ) {
		$title = single_post_title( '', false );
	}

	return $title;
}

/**
 * Generates an excerpt from the post content with custom length.
 * Default length is 55 words, same as default the_excerpt()
 *
 * The excerpt words amount will be 55 words and if the amount is greater than
 * that, then the string '&hellip;' will be appended to the excerpt. If the string
 * is less than 55 words, then the content will be returned as it is.
 *
 * @param int $length Optional. Custom excerpt length, default to 55.
 * @param int|WP_Post $post Optional. You will need to provide post id or post object if used outside loops.
 *
 * @return string           The excerpt with custom length.
 */
function organio_get_the_excerpt( $length = 55, $post = null ) {
	$post = get_post( $post );

	if ( empty( $post ) || 0 >= $length ) {
		return '';
	}

	if ( post_password_required( $post ) ) {
		return esc_html__( 'Post password required.', 'organio' );
	}

	$content = apply_filters( 'the_content', strip_shortcodes( $post->post_content ) );
	$content = str_replace( ']]>', ']]&gt;', $content );

	$excerpt_more = apply_filters( 'organio_excerpt_more', '&hellip;' );
	$excerpt      = wp_trim_words( $content, $length, $excerpt_more );

	return $excerpt;
}


/**
 * Check if provided color string is valid color.
 * Only supports 'transparent', HEX, RGB, RGBA.
 *
 * @param  string $color
 *
 * @return boolean
 */
function organio_is_valid_color( $color ) {
	$color = preg_replace( "/\s+/m", '', $color );

	if ( $color === 'transparent' ) {
		return true;
	}

	if ( '' == $color ) {
		return false;
	}

	// Hex format
	if ( preg_match( "/(?:^#[a-fA-F0-9]{6}$)|(?:^#[a-fA-F0-9]{3}$)/", $color ) ) {
		return true;
	}

	// rgb or rgba format
	if ( preg_match( "/(?:^rgba\(\d+\,\d+\,\d+\,(?:\d*(?:\.\d+)?)\)$)|(?:^rgb\(\d+\,\d+\,\d+\)$)/", $color ) ) {
		preg_match_all( "/\d+\.*\d*/", $color, $matches );
		if ( empty( $matches ) || empty( $matches[0] ) ) {
			return false;
		}

		$red   = empty( $matches[0][0] ) ? $matches[0][0] : 0;
		$green = empty( $matches[0][1] ) ? $matches[0][1] : 0;
		$blue  = empty( $matches[0][2] ) ? $matches[0][2] : 0;
		$alpha = empty( $matches[0][3] ) ? $matches[0][3] : 1;

		if ( $red < 0 || $red > 255 || $green < 0 || $green > 255 || $blue < 0 || $blue > 255 || $alpha < 0 || $alpha > 1.0 ) {
			return false;
		}
	} else {
		return false;
	}

	return true;
}

/**
 * Minify css
 *
 * @param  string $css
 *
 * @return string
 */
function organio_css_minifier( $css ) {
	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );
	// Remove spaces before and after comment
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );
	// Remove comment blocks, everything between /* and */, unless
	// preserved with /*! ... */ or /** ... */
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );
	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );
	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );
	// Remove space before , ; { } ( ) >
	$css = preg_replace( '/ (,|;|\{|}|\(|\)|>)/', '$1', $css );
	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
	// Converts all zeros value into short-hand
	$css = preg_replace( '/0 0 0 0/', '0', $css );
	// Shortern 6-character hex color codes to 3-character where possible
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}

/**
 * Header Tracking Code to wp_head hook.
 */
function organio_header_code() {
	$site_header_code = organio_get_opt( 'site_header_code' );
	if ( $site_header_code !== '' ) {
		print wp_kses( $site_header_code, wp_kses_allowed_html() );
	}
}

add_action( 'wp_head', 'organio_header_code' );

/**
 * Footer Tracking Code to wp_footer hook.
 */
function organio_footer_code() {
	$site_footer_code = organio_get_opt( 'site_footer_code' );
	if ( $site_footer_code !== '' ) {
		print wp_kses( $site_footer_code, wp_kses_allowed_html() );
	}
}

add_action( 'wp_footer', 'organio_footer_code' );

/**
 * Custom Comment List
 */
function organio_comment_list( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
	?>
    <<?php echo ''.$tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
		    <div class="comment-inner">
		        <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, 90); ?>
		        <div class="comment-content">
		            <h4 class="comment-title">
		            	<?php printf( '%s', get_comment_author_link() ); ?>
		            </h4>
		            <div class="comment-meta">
		            	<span class="comment-date">
	                        <?php echo get_comment_date().' - '.get_comment_time(); ?>
	                    </span>
		            </div>
		            <div class="comment-text"><?php comment_text(); ?></div>
		            <div class="comment-reply">
						<?php comment_reply_link( array_merge( $args, array(
							'add_below' => $add_below,
							'depth'     => $depth,
							'max_depth' => $args['max_depth']
						) ) ); ?>
		            </div>
		        </div>
		    </div>
		<?php if ( 'div' != $args['style'] ) : ?>
        </div>
	<?php endif;
}

function organio_comment_reply_text( $link ) {
$link = str_replace( 'Reply', ''.esc_attr__('Reply', 'organio').'', $link );
return $link;
}
add_filter( 'comment_reply_link', 'organio_comment_reply_text' );

/**
 * Add field subtitle to post.
 */
function organio_add_subtitle_field() {
	global $post;

	$screen = get_current_screen();

	if ( in_array( $screen->id, array( 'acm-post' ) ) ) {

		$value = get_post_meta( $post->ID, 'post_subtitle', true );

		echo '<div class="subtitle"><input type="text" name="post_subtitle" value="' . esc_attr( $value ) . '" id="subtitle" placeholder = "' . esc_attr__( 'Subtitle', 'organio' ) . '" style="width: 100%;margin-top: 4px;"></div>';
	}
}

add_action( 'edit_form_after_title', 'organio_add_subtitle_field' );

/**
 * Save custom theme meta
 */
function organio_save_meta_boxes( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_subtitle'] ) ) {
		update_post_meta( $post_id, 'post_subtitle', $_POST['post_subtitle'] );
	}
}

add_action( 'save_post', 'organio_save_meta_boxes' );


add_filter( 'ct_extra_post_types', 'organio_add_posttype' );
function organio_add_posttype( $postypes ) {
	$portfolio_slug = organio_get_opt( 'portfolio_slug', 'portfolio' );
	$portfolio_name = organio_get_opt( 'portfolio_name', esc_html__('Portfolio', 'organio') );
	$postypes['portfolio'] = array(
		'status' => true,
		'item_name'  => $portfolio_name,
		'items_name' => $portfolio_name,
		'args'       => array(
			'rewrite'             => array(
                'slug'       => $portfolio_slug,
 		 	),
		),
	);

	$service_slug = organio_get_opt( 'service_slug', 'service' );
	$service_name = organio_get_opt( 'service_name', esc_html__('Services', 'organio') );
	$postypes['service'] = array(
		'status'     => true,
		'item_name'  => $service_name,
		'items_name' => $service_name,
		'args'       => array(
			'menu_icon'          => 'dashicons-hammer',
			'supports'           => array(
				'title',
				'thumbnail',
				'editor',
			),
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'             => array(
                'slug'       => $service_slug
 		 	),
		),
		'labels'     => array()
	);

	$postypes['footer'] = array(
		'status'     => true,
		'item_name'  => esc_html__( 'Footer Builder', 'organio' ),
		'items_name' => esc_html__( 'Footer Builder', 'organio' ),
		'args'       => array(
			'menu_icon'          => 'dashicons-editor-insertmore',
			'supports'           => array(
				'title',
				'editor',
			),
			'public'             => true,
			'publicly_queryable' => true,
		),
		'labels'     => array()
	);

	return $postypes;
}

add_filter( 'ct_extra_taxonomies', 'organio_add_tax' );
function organio_add_tax( $taxonomies ) {

	$portfolio_category_slug = organio_get_opt( 'portfolio_category_slug', 'portfolio-category' );
	$portfolio_category_name = organio_get_opt( 'portfolio_category_name', esc_html__('Portfolio Categories', 'organio') );
	$taxonomies['portfolio-category'] = array(
		'status'     => true,
		'post_type'  => array( 'portfolio' ),
		'taxonomy'   => $portfolio_category_name,
		'taxonomies' => $portfolio_category_name,
		'args'       => array(
			'rewrite'             => array(
                'slug'       => $portfolio_category_slug
 		 	),
		),
		'labels'     => array()
	);

	$service_category_slug = organio_get_opt( 'service_category_slug', 'service-category' );
	$service_category_name = organio_get_opt( 'service_category_name', esc_html__('Service Categories', 'organio') );
	$taxonomies['service-category'] = array(
		'status'     => true,
		'post_type'  => array( 'service' ),
		'taxonomy' => $service_category_name,
		'taxorganiomy'   => $service_category_name,
		'taxonomies' => $service_category_name,
		'args'       => array(
			'rewrite'             => array(
                'slug'       => $service_category_slug
 		 	),
		),
		'labels'     => array()
	);
	
	return $taxonomies;
}

add_filter( 'ct_enable_megamenu', 'organio_enable_megamenu' );
function organio_enable_megamenu() {
	return true;
}
add_filter( 'ct_enable_onepage', 'organio_enable_onepage' );
function organio_enable_onepage() {
	return true;
}

/* Add default pagram Carousel */
function organio_get_param_carousel( $atts ) {
	$default  = array(
		'col_xs'           => '1',
		'col_sm'           => '2',
		'col_md'           => '3',
		'col_lg'           => '4',
		'col_xl'           => '4',
		'col_xxl'           => '4',
		'margin'           => '30',
		'loop'             => 'false',
		'autoplay'         => 'false',
		'autoplay_timeout' => '5000',
		'smart_speed'      => '250',
		'center'           => 'false',
		'stage_padding'    => '0',
		'arrows'           => 'false',
		'bullets'          => 'false',
	);
	$new_data = array_merge( $default, $atts );
	extract( $new_data );
	$carousel      = array(
		'data-item-xs' => $col_xs,
		'data-item-sm' => $col_sm,
		'data-item-md' => $col_md,
		'data-item-lg' => $col_lg,
		'data-item-xl' => $col_xl,
		'data-item-xxl' => $col_xxl,

		'data-margin'          => $margin,
		'data-loop'            => $loop,
		'data-autoplay'        => $autoplay,
		'data-autoplaytimeout' => $autoplay_timeout,
		'data-smartspeed'      => $smart_speed,
		'data-center'          => $center,
		'data-arrows'          => $arrows,
		'data-bullets'         => $bullets,
		'data-stagepadding'    => $stage_padding,
		'data-rtl'             => is_rtl() ? 'true' : 'false',
	);
	$carousel_data = '';
	foreach ( $carousel as $key => $value ) {
		if ( isset( $value ) ) {
			$carousel_data .= $key . '=' . $value . ' ';
		}
	}
	$new_data['carousel_data'] = $carousel_data;

	return $new_data;
}

/* Show/hide Case Carousel */
add_filter( 'enable_ct_carousel', 'organio_enable_ct_carousel' );
function organio_enable_ct_carousel() {
	return false;
}

/*
 * Set post views count using post meta
 */
function organio_set_post_views( $postID ) {
	$countKey = 'post_views_count';
	$count    = get_post_meta( $postID, $countKey, true );
	if ( $count == '' ) {
		$count = 0;
		delete_post_meta( $postID, $countKey );
		add_post_meta( $postID, $countKey, '0' );
	} else {
		$count ++;
		update_post_meta( $postID, $countKey, $count );
	}
}

/* Create Demo Data */
add_filter('ct_ie_export_mode', 'organio_enable_export_mode');
function organio_enable_export_mode()
{
    return false;
}
/* Dashboard Theme */
add_filter('ct_documentation_link',function(){
     return 'http://casethemes.net/docs/organio/';
});
add_filter('ct_video_tutorial_link',function(){
     return 'https://www.youtube.com/watch?v=zU6l_dQUi_k';
});

add_action( 'elementor/editor/before_enqueue_scripts', function() {
    wp_enqueue_style( 'organio-elementor-custom-editor', get_template_directory_uri() . '/assets/css/elementor-custom-editor.css', array(), '1.0.0' );
} );

if(class_exists( 'Case_Theme_Core' )){
	if(!function_exists( 'organio_add_icons_to_ct_iconpicker_field' )){
		add_filter( 'redux_ct_iconpicker_field/get_icons', 'organio_add_icons_to_ct_iconpicker_field' );
		function organio_add_icons_to_ct_iconpicker_field($icons){
			$custom_icons = [
				'Flaticon' => array(
                    array('flaticon-add-to-cart' => 'flaticon-add-to-cart'),
					array('flaticon-arrow' => 'flaticon-arrow'),
					array('flaticon-award' => 'flaticon-award'),
					array('flaticon-bread' => 'flaticon-bread'),
					array('flaticon-broccoli' => 'flaticon-broccoli'),
					array('flaticon-cancel' => 'flaticon-cancel'),
					array('flaticon-cardboard' => 'flaticon-cardboard'),
					array('flaticon-carrot' => 'flaticon-carrot'),
					array('flaticon-cart-1' => 'flaticon-cart-1'),
					array('flaticon-cart' => 'flaticon-cart'),
					array('flaticon-check' => 'flaticon-check'),
					array('flaticon-checked' => 'flaticon-checked'),
					array('flaticon-cherry' => 'flaticon-cherry'),
					array('flaticon-chicken-leg' => 'flaticon-chicken-leg'),
					array('flaticon-coconut' => 'flaticon-coconut'),
					array('flaticon-compare' => 'flaticon-compare'),
					array('flaticon-contact' => 'flaticon-contact'),
					array('flaticon-credit-card' => 'flaticon-credit-card'),
					array('flaticon-crown' => 'flaticon-crown'),
					array('flaticon-dairy-products' => 'flaticon-dairy-products'),
					array('flaticon-delivery' => 'flaticon-delivery'),
					array('flaticon-email' => 'flaticon-email'),
					array('flaticon-facebook' => 'flaticon-facebook'),
					array('flaticon-fish' => 'flaticon-fish'),
					array('flaticon-fruits' => 'flaticon-fruits'),
					array('flaticon-grid' => 'flaticon-grid'),
					array('flaticon-grocery' => 'flaticon-grocery'),
					array('flaticon-headphones' => 'flaticon-headphones'),
					array('flaticon-instagram' => 'flaticon-instagram'),
					array('flaticon-leaf-1' => 'flaticon-leaf-1'),
					array('flaticon-leaf-2' => 'flaticon-leaf-2'),
					array('flaticon-leaf' => 'flaticon-leaf'),
					array('flaticon-link' => 'flaticon-link'),
					array('flaticon-location-pin' => 'flaticon-location-pin'),
					array('flaticon-lorry' => 'flaticon-lorry'),
					array('flaticon-love' => 'flaticon-love'),
					array('flaticon-map' => 'flaticon-map'),
					array('flaticon-menu' => 'flaticon-menu'),
					array('flaticon-money-back-guarantee' => 'flaticon-money-back-guarantee'),
					array('flaticon-next' => 'flaticon-next'),
					array('flaticon-orange-juice' => 'flaticon-orange-juice'),
					array('flaticon-pay' => 'flaticon-pay'),
					array('flaticon-phone-call' => 'flaticon-phone-call'),
					array('flaticon-pinterest' => 'flaticon-pinterest')
                ),
			];
			$icons = array_merge($custom_icons, $icons);
			return $icons;
		}
	}

	if(!function_exists("organio_add_icons_to_megamenu")){
		add_filter("ct_mega_menu/get_icons", "organio_add_icons_to_megamenu");
		function organio_add_icons_to_megamenu($icons){
			$custom_icons = [
				'Flaticon' => array(
                    array('flaticon-add-to-cart' => 'flaticon-add-to-cart'),
					array('flaticon-arrow' => 'flaticon-arrow'),
					array('flaticon-award' => 'flaticon-award'),
					array('flaticon-bread' => 'flaticon-bread'),
					array('flaticon-broccoli' => 'flaticon-broccoli'),
					array('flaticon-cancel' => 'flaticon-cancel'),
					array('flaticon-cardboard' => 'flaticon-cardboard'),
					array('flaticon-carrot' => 'flaticon-carrot'),
					array('flaticon-cart-1' => 'flaticon-cart-1'),
					array('flaticon-cart' => 'flaticon-cart'),
					array('flaticon-check' => 'flaticon-check'),
					array('flaticon-checked' => 'flaticon-checked'),
					array('flaticon-cherry' => 'flaticon-cherry'),
					array('flaticon-chicken-leg' => 'flaticon-chicken-leg'),
					array('flaticon-coconut' => 'flaticon-coconut'),
					array('flaticon-compare' => 'flaticon-compare'),
					array('flaticon-contact' => 'flaticon-contact'),
					array('flaticon-credit-card' => 'flaticon-credit-card'),
					array('flaticon-crown' => 'flaticon-crown'),
					array('flaticon-dairy-products' => 'flaticon-dairy-products'),
					array('flaticon-delivery' => 'flaticon-delivery'),
					array('flaticon-email' => 'flaticon-email'),
					array('flaticon-facebook' => 'flaticon-facebook'),
					array('flaticon-fish' => 'flaticon-fish'),
					array('flaticon-fruits' => 'flaticon-fruits'),
					array('flaticon-grid' => 'flaticon-grid'),
					array('flaticon-grocery' => 'flaticon-grocery'),
					array('flaticon-headphones' => 'flaticon-headphones'),
					array('flaticon-instagram' => 'flaticon-instagram'),
					array('flaticon-leaf-1' => 'flaticon-leaf-1'),
					array('flaticon-leaf-2' => 'flaticon-leaf-2'),
					array('flaticon-leaf' => 'flaticon-leaf'),
					array('flaticon-link' => 'flaticon-link'),
					array('flaticon-location-pin' => 'flaticon-location-pin'),
					array('flaticon-lorry' => 'flaticon-lorry'),
					array('flaticon-love' => 'flaticon-love'),
					array('flaticon-map' => 'flaticon-map'),
					array('flaticon-menu' => 'flaticon-menu'),
					array('flaticon-money-back-guarantee' => 'flaticon-money-back-guarantee'),
					array('flaticon-next' => 'flaticon-next'),
					array('flaticon-orange-juice' => 'flaticon-orange-juice'),
					array('flaticon-pay' => 'flaticon-pay'),
					array('flaticon-phone-call' => 'flaticon-phone-call'),
					array('flaticon-pinterest' => 'flaticon-pinterest')
                ),
			];
			$icons = array_merge($custom_icons, $icons);
			return $icons;
		}
	}
}

if(!function_exists('ct_get_term_of_slick_filter')){
    function ct_get_term_of_slick_filter($post_id, $tax = array())
    {
        $term_list = array();
        foreach ($tax as $taxo) {
            $term_of_post = wp_get_post_terms($post_id, $taxo);
            foreach ($term_of_post as $term) {
                $term_list[] = 'ct-slick-filter-'.$term->slug;
            }
        }

        return implode(' ', $term_list);
    }
}

// Disable Gutenberg Editor
add_filter("use_block_editor_for_post_type", "disable_gutenberg_editor");
function disable_gutenberg_editor(){
    return false;
}

add_action( 'ct-ie-import-finish', 'organio_update_el_default_kit_option' );
function organio_update_el_default_kit_option(){
	$kit_id = organio_get_id_by_slug('default-kit', 'elementor_library'); 
	if(!empty($kit_id))
		update_option( 'elementor_active_kit', $kit_id, 'yes' );
}

/* ------Disable Lazy loading---- */
add_filter( 'wp_lazy_loading_enabled', '__return_false' );

/**
 * RGB Color
 */
function organio_hex_rgb($color) {
 
    $default = '0,0,0';
 
    //Return default if no color provided
    if(empty($color))
        return $default; 
 
    //Sanitize $color if "#" is provided 
    if ($color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    $output = implode(",",$rgb);

    //Return rgb(a) color string
    return $output;
}

/* Add Page Title Image - Product Category */
add_action( 'ct_taxonomy_meta_register', 'organio_taxonomy_product' );
function organio_taxonomy_product( $taxonomy ) {
	$product_attribute = array(
		'opt_name'     => 'product_cat',
		'display_name' => esc_html__( 'Settings', 'raworganic' ),
	);

	if ( ! $taxonomy->isset_args( 'product_cat' ) ) {
		$taxonomy->set_args( 'product_cat', $product_attribute );
	}

	$taxonomy->add_section( 'product_cat', array(
		'id'     => 'product_cat',
		'title'  => '',
		'desc'   => '',
		'fields' => array(
			array(
	            'id'       => 'ptitle_product_cat',
	            'type'     => 'background',
	            'title'    => esc_html__('Page Title Image', 'organio'),
	            'output'   => array('body #pagetitle'),
	            'background-image' => true,
	            'background-color' => false,
	            'background-position' => false,
	            'background-repeat' => false,
	            'background-size' => false,
	            'background-attachment' => false,
	            'transparent' => false,
	        ),
	        array(
	            'id'       => 'product_category_icon',
	            'type'     => 'ct_iconpicker',
	            'title'    => esc_html__('Icon', 'organio'),
	        ),
		)
	) );
}

/* Update primary color in Editor Builder */
add_action( 'elementor/preview/enqueue_styles', 'organio_add_editor_preview_style' );
function organio_add_editor_preview_style(){
    wp_add_inline_style( 'editor-preview', organio_editor_preview_inline_styles() );
}
function organio_editor_preview_inline_styles(){
    $theme_colors = organio_configs('theme_colors');
    ob_start();
        echo '.elementor-edit-area-active{';
            foreach ($theme_colors as $color => $value) {
                printf('--%1$s-color: %2$s;', str_replace('#', '',$color),  $value['value']);
            }
        echo '}';
    return ob_get_clean();
}