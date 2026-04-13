<?php
/**
 * Custom template tags for this theme.
 *
 * @package Organio
 */

/**
 * Header layout
 **/
function organio_page_loading()
{
    $page_loading = organio_get_opt( 'show_page_loading', false );
    $loading_type = organio_get_opt( 'loading_type', 'style1');
    $logo_loader = organio_get_opt( 'logo_loader', array( 'url' => get_template_directory_uri().'/assets/images/logo-loader.gif', 'id' => '' ) );

    $loading_page = organio_get_page_opt( 'loading_page', 'themeoption');
    $loading_type_page = organio_get_page_opt( 'loading_type', 'style1');

    if($loading_page == 'custom') {
        $loading_type = $loading_type_page;
    }

    if($page_loading) { ?>
        <div id="ct-loadding" class="ct-loader <?php echo esc_attr($loading_type); ?>">
            <?php switch ( $loading_type )
            {
                case 'style-image': ?>
                    <?php if ($logo_loader['url']) { ?>
                        <div class="loading-image">
                            <?php 
                                printf(
                                    '<img src="%3$s" alt="%2$s"/>',
                                    esc_url( home_url( '/' ) ),
                                    esc_attr( get_bloginfo( 'name' ) ),
                                    esc_url( $logo_loader['url'] )
                                );
                            ?>
                        </div>
                    <?php } ?>
                <?php break;

                case 'style2': ?>
                    <div class="ct-spinner2"></div>
                    <?php break;

                case 'style3': ?>
                    <div class="ct-spinner3">
                      <div class="double-bounce1"></div>
                      <div class="double-bounce2"></div>
                    </div>
                    <?php break;

                case 'style4': ?>
                    <div class="ct-spinner4">
                      <div class="rect1"></div>
                      <div class="rect2"></div>
                      <div class="rect3"></div>
                      <div class="rect4"></div>
                      <div class="rect5"></div>
                    </div>
                    <?php break;

                case 'style5': ?>
                    <div class="ct-spinner5">
                      <div class="bounce1"></div>
                      <div class="bounce2"></div>
                      <div class="bounce3"></div>
                    </div>
                    <?php break;

                case 'style6': ?>
                    <div class="ct-cube-grid">
                      <div class="ct-cube ct-cube1"></div>
                      <div class="ct-cube ct-cube2"></div>
                      <div class="ct-cube ct-cube3"></div>
                      <div class="ct-cube ct-cube4"></div>
                      <div class="ct-cube ct-cube5"></div>
                      <div class="ct-cube ct-cube6"></div>
                      <div class="ct-cube ct-cube7"></div>
                      <div class="ct-cube ct-cube8"></div>
                      <div class="ct-cube ct-cube9"></div>
                    </div>
                    <?php break;

                case 'style7': ?>
                    <div class="ct-folding-cube">
                      <div class="ct-cube1 ct-cube"></div>
                      <div class="ct-cube2 ct-cube"></div>
                      <div class="ct-cube4 ct-cube"></div>
                      <div class="ct-cube3 ct-cube"></div>
                    </div>
                    <?php break;

                case 'style8': ?>
                    <div class="ct-loading-stairs">
                        <div class="loader-bar"></div>
                        <div class="loader-bar"></div>
                        <div class="loader-bar"></div>
                        <div class="loader-bar"></div>
                        <div class="loader-bar"></div>
                        <div class="loader-ball"></div>
                    </div>
                    <?php break;

                case 'style9': ?>
                    <div class="ct-dual-ring">
                    </div>
                    <?php break;

                case 'style10': ?>
                    <div class="ct-dot-square">
                    </div>
                    <?php break;

                case 'style11': ?>
                    <div class="loading-spinner">
                    </div>
                    <?php break;

                case 'style12': ?>
                    <div class="loading-ring">
                    </div>
                    <?php break;

                case 'style13': ?>
                    <div class="loading-infinity">
                        <div>
                            <span></span>
                        </div>
                        <div>
                            <span></span>
                        </div>
                        <div>
                            <span></span>
                        </div>
                    </div>
                    <?php break;

                default: ?>
                    <div class="loading-spin">
                        <div class="spinner">
                            <div class="right-side"><div class="bar"></div></div>
                            <div class="left-side"><div class="bar"></div></div>
                        </div>
                        <div class="spinner color-2">
                            <div class="right-side"><div class="bar"></div></div>
                            <div class="left-side"><div class="bar"></div></div>
                        </div>
                    </div>
                    <?php break;
            } ?>
        </div>
    <?php }
}

/**
 * Header layout
 **/
function organio_header_layout()
{
    if(is_singular('elementor_library')) return;
    
    $header_layout = organio_get_opt( 'header_layout', 'df' );
    $custom_header = organio_get_page_opt( 'custom_header', '0' );

    if ( $custom_header == '1' )
    {
        $page_header_layout = organio_get_page_opt('header_layout');
        $header_layout = $page_header_layout;
        if($header_layout == '0') {
            return;
        }
    }

    get_template_part( 'template-parts/header-layout', $header_layout );
}

/**
 * Page title layout
 **/
function organio_page_title_layout()
{
    get_template_part( 'template-parts/page-title', '' );
}

/**
 * Footer
 **/
function organio_footer()
{
    if(is_singular('elementor_library')) return;

    $footer_layout_custom = organio_get_opt('footer_layout_custom');
    if( !class_exists('ReduxFramework') || empty($footer_layout_custom) ) {
        get_template_part( 'template-parts/footer-layout', 'default' );
    } else {
        get_template_part( 'template-parts/footer-layout', 'custom' );
    }
}

/**
 * Set primary content class based on sidebar position
 *
 * @param  string $sidebar_pos
 * @param  string $extra_class
 */
function organio_primary_class( $sidebar_pos, $extra_class = '' )
{
    if ( class_exists( 'WooCommerce' ) && (is_product_category()) || class_exists( 'WooCommerce' ) && (is_shop()) ) :
        $sidebar_load = 'sidebar-shop';
    elseif (is_page()) :
        $sidebar_load = 'sidebar-page';
    else :
        $sidebar_load = 'sidebar-blog';
    endif;

    if ( is_active_sidebar( $sidebar_load ) ) {
        $class = array( trim( $extra_class ) );
        switch ( $sidebar_pos )
        {
            case 'left':
                $class[] = 'content-has-sidebar float-right col-xl-9 col-lg-9 col-md-12 col-sm-12';
                break;

            case 'right':
                $class[] = 'content-has-sidebar float-left col-xl-9 col-lg-9 col-md-12 col-sm-12';
                break;

            default:
                $class[] = 'content-full-width col-12';
                break;
        }

        $class = implode( ' ', array_filter( $class ) );

        if ( $class )
        {
            echo ' class="' . esc_html($class) . '"';
        }
    } else {
        echo ' class="content-area col-12"'; 
    }
}

/**
 * Set secondary content class based on sidebar position
 *
 * @param  string $sidebar_pos
 * @param  string $extra_class
 */
function organio_secondary_class( $sidebar_pos, $extra_class = '' )
{
    if ( class_exists( 'WooCommerce' ) && (is_product_category()) ) :
        $sidebar_load = 'sidebar-shop';
    elseif (is_page()) :
        $sidebar_load = 'sidebar-page';
    else :
        $sidebar_load = 'sidebar-blog';
    endif;

    if ( is_active_sidebar( $sidebar_load ) ) {
        $class = array(trim($extra_class));
        switch ($sidebar_pos) {
            case 'left':
                $class[] = 'widget-has-sidebar sidebar-fixed col-xl-3 col-lg-3 col-md-12 col-sm-12';
                break;

            case 'right':
                $class[] = 'widget-has-sidebar sidebar-fixed col-xl-3 col-lg-3 col-md-12 col-sm-12';
                break;

            default:
                break;
        }

        $class = implode(' ', array_filter($class));

        if ($class) {
            echo ' class="' . esc_html($class) . '"';
        }
    }
}


/**
 * Prints HTML for breadcrumbs.
 */
function organio_breadcrumb()
{
    if ( ! class_exists( 'CT_Breadcrumb' ) )
    {
        return;
    }

    $breadcrumb = new CT_Breadcrumb();
    $entries = $breadcrumb->get_entries();

    if ( empty( $entries ) )
    {
        return;
    }

    ob_start();

    foreach ( $entries as $entry )
    {
        $entry = wp_parse_args( $entry, array(
            'label' => '',
            'url'   => ''
        ) );

        if ( empty( $entry['label'] ) )
        {
            continue;
        }

        echo '<li>';

        if ( ! empty( $entry['url'] ) )
        {
            printf(
                '<a class="breadcrumb-entry" href="%1$s">%2$s</a>',
                esc_url( $entry['url'] ),
                esc_attr( $entry['label'] )
            );
        }
        else
        {
            printf( '<span class="breadcrumb-entry" >%s</span>', esc_html( $entry['label'] ) );
        }

        echo '</li>';
    }

    $output = ob_get_clean();

    if ( $output )
    {
        printf( '<ul class="ct-breadcrumb">%s</ul>', wp_kses_post($output));
    }
}


function organio_entry_link_pages()
{
    wp_link_pages( array(
        'before'      => '<div class="page-links">',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
    ) );
}


if ( ! function_exists( 'organio_entry_excerpt' ) ) :
    /**
     * Print post excerpt based on length.
     *
     * @param  integer $length
     */
    function organio_entry_excerpt( $length = 55 )
    {
        $ct_the_excerpt = get_the_excerpt();
        if(!empty($ct_the_excerpt)) {
            echo wp_kses_post($ct_the_excerpt);
        } else {
            echo wp_kses_post(organio_get_the_excerpt( $length ));
        }
    }
endif;


if(!function_exists('organio_ajax_paginate_links')){
    function organio_ajax_paginate_links($link){
        $parts = parse_url($link);
        if( !isset($parts['query']) ) return $link;
        parse_str($parts['query'], $query);
        if(isset($query['page']) && !empty($query['page'])){
            return '#' . $query['page'];
        }
        else{
            return '#1';
        }
    }
}

add_action( 'wp_ajax_organio_get_pagination_html', 'organio_get_pagination_html' );
add_action( 'wp_ajax_nopriv_organio_get_pagination_html', 'organio_get_pagination_html' );
if(!function_exists('organio_get_pagination_html')){
    function organio_get_pagination_html(){
        try{
            if(!isset($_POST['query_vars'])){
                throw new Exception(__('Something went wrong while requesting. Please try again!', 'organio'));
            }
            $query = new WP_Query($_POST['query_vars']);
            ob_start();
            organio_posts_pagination( $query,  true );
            $html = ob_get_clean();
            wp_send_json(
                array(
                    'status' => true,
                    'message' => esc_attr__('Load Successfully!', 'organio'),
                    'data' => array(
                        'html' => $html,
                        'query_vars' => $_POST['query_vars'],
                        'post' => $query->have_posts()
                    ),
                )
            );
        }
        catch (Exception $e){
            wp_send_json(array('status' => false, 'message' => $e->getMessage()));
        }
        die;
    }
}

/**
 * Prints posts pagination based on query
 *
 * @param  WP_Query $query     Custom query, if left blank, this will use global query ( current query )
 * @return void
 */
function organio_posts_pagination( $query = null, $ajax = false )
{
    if($ajax){
        add_filter('paginate_links', 'organio_ajax_paginate_links');
    }

    $classes = array();

    if ( empty( $query ) )
    {
        $query = $GLOBALS['wp_query'];
    }

    if ( empty( $query->max_num_pages ) || ! is_numeric( $query->max_num_pages ) || $query->max_num_pages < 2 )
    {
        return;
    }

    $paged = $query->get( 'paged', '' );

    if ( ! $paged && is_front_page() && ! is_home() )
    {
        $paged = $query->get( 'page', '' );
    }

    $paged = $paged ? intval( $paged ) : 1;

    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) )
    {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $html_prev = '<i class="caseicon-angle-arrow-left"></i>';
    $html_next = '<i class="caseicon-angle-arrow-right"></i>';
    $paginate_links_args = array(
        'base'     => $pagenum_link,
        'total'    => $query->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => $html_prev,
        'next_text' => $html_next,
    );
    if($ajax){
        $paginate_links_args['format'] = '?page=%#%';
    }
    $links = paginate_links( $paginate_links_args );
    if ( $links ):
    ?>
    <nav class="ct-posts-pagination <?php echo esc_attr($ajax?'ajax':''); ?>">
        <div class="posts-page-links">
            <?php
                printf($links);
            ?>
        </div>
    </nav>
    <?php
    endif;
}

if ( ! function_exists( 'organio_post_meta' ) ) :
    function organio_post_meta() {
        $post_category_on = organio_get_opt( 'post_category_on', true );
        $post_author_on = organio_get_opt( 'post_author_on', true );
        $post_date_on = organio_get_opt( 'post_date_on', true );
        if($post_author_on || $post_date_on || $post_category_on) : ?>
            <ul class="entry-meta ct-item-meta">
                <?php if($post_date_on) : ?>
                    <li class="item-date"><i class="caseicon-clock"></i><?php echo get_the_date(); ?></li>
                <?php endif; ?>
                <?php if($post_author_on) : ?>
                    <li class="item-author"><i class="caseicon-user-alt"></i><?php echo esc_html__('By', 'organio'); ?> <?php the_author_posts_link(); ?></li>
                <?php endif; ?>
                <?php if($post_category_on) : ?>
                    <li class="item-category"><?php the_terms( get_the_ID(), 'category', '<i class="caseicon-tags-alt"></i>', ', ', '' ); ?></li>
                <?php endif; ?>
            </ul>
        <?php endif; }
endif;

if ( ! function_exists( 'organio_archive_meta' ) ) :
    function organio_archive_meta() {
        $archive_categories_on = organio_get_opt( 'archive_categories_on', true );
        $archive_author_on = organio_get_opt( 'archive_author_on', true );
        $archive_date_on = organio_get_opt( 'archive_date_on', true );
        if($archive_author_on || $archive_categories_on || $archive_date_on) : ?>
            <ul class="entry-meta ct-item-meta">
                <?php if($archive_date_on) : ?>
                    <li class="item-date"><i class="caseicon-clock"></i><?php echo get_the_date(); ?></li>
                <?php endif; ?>
                <?php if($archive_author_on) : ?>
                    <li class="item-author"><i class="caseicon-user-alt"></i><?php echo esc_html__('By', 'organio'); ?> <?php the_author_posts_link(); ?></li>
                <?php endif; ?>
                <?php if($archive_categories_on) : ?>
                    <li class="item-category"><?php the_terms( get_the_ID(), 'category', '<i class="caseicon-tags-alt"></i>', ', ', '' ); ?></li>
                <?php endif; ?>
            </ul>
        <?php endif; }
endif;

/**
 * Prints tag list
 */
if ( ! function_exists( 'organio_entry_tagged_in' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function organio_entry_tagged_in()
    {
        $tags_list = get_the_tag_list( '<label class="label">'.esc_attr__('Tags:', 'organio'). '</label>', ' ' );
        if ( $tags_list )
        {
            echo '<div class="entry-tags">';
            printf('%2$s', '', $tags_list);
            echo '</div>';
        }
    }
endif;

/**
 * List socials share for post.
 */
function organio_socials_share_default() { 
    $img_url = '';
    if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), false)) {
        $img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), false);
    }
    ?>
    <div class="entry-social">
        <label><?php echo esc_html__('Share:', 'organio'); ?></label>
        <a class="fb-social" title="<?php echo esc_attr__('Facebook', 'organio'); ?>" target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="caseicon-facebook"></i></a>
        <a class="tw-social" title="<?php echo esc_attr__('Twitter', 'organio'); ?>" target="_blank" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>%20"><i class="caseicon-twitter"></i></a>
        <a class="pin-social" title="<?php echo esc_attr__('Pinterest', 'organio'); ?>" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_url($img_url[0]); ?>&description=<?php the_title(); ?>%20"><i class="caseicon-pinterest"></i></a>
        <a class="lin-social" title="<?php echo esc_attr__('LinkedIn', 'organio'); ?>" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>%20"><i class="caseicon-linkedin"></i></a>
    </div>
    <?php
}

/**
 * Related Post
 */
function organio_related_post()
{
    $post_related_on = organio_get_opt( 'post_related_on', false );

    if($post_related_on) {
        global $post;
        $current_id = $post->ID;
        $posttags = get_the_category($post->ID);
        if (empty($posttags)) return;

        $tags = array();

        foreach ($posttags as $tag) {

            $tags[] = $tag->term_id;
        }
        $post_number = '6';
        $query_similar = new WP_Query(array('posts_per_page' => $post_number, 'post_type' => 'post', 'post_status' => 'publish', 'category__in' => $tags));
        if (count($query_similar->posts) > 1) {
            wp_enqueue_script( 'owl-carousel' );
            wp_enqueue_script( 'organio-carousel' );
            ?>
            <div class="ct-related-post">
                <h4 class="widget-title"><?php echo esc_html__('Related Posts', 'organio'); ?></h4>
                <div class="ct-related-post-inner owl-carousel" data-item-xs="1" data-item-sm="2" data-item-md="3" data-item-lg="3" data-item-xl="3" data-item-xxl="3" data-margin="30" data-loop="false" data-autoplay="false" data-autoplaytimeout="5000" data-smartspeed="250" data-center="false" data-arrows="false" data-bullets="false" data-stagepadding="0" data-stagepaddingsm="0" data-rtl="false">
                    <?php foreach ($query_similar->posts as $post):
                        $thumbnail_url = '';
                        if (has_post_thumbnail(get_the_ID()) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) :
                            $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'organio-blog-small', false);
                        endif;
                        if ($post->ID !== $current_id) : ?>
                            <div class="grid-item">
                                <div class="grid-item-inner">
                                    <?php if (has_post_thumbnail()) { ?>
                                        <div class="item-featured">
                                            <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($thumbnail_url[0]); ?>" /></a>
                                        </div>
                                    <?php } ?>
                                    <h3 class="item-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                </div>
                            </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>
        <?php }
    }

    wp_reset_postdata();
}

/**
 * Header Search Mobile
 */
function organio_header_mobile_search()
{
    $search_field_placeholder = organio_get_opt( 'search_field_placeholder' );
    $search_icon = organio_get_opt( 'search_icon', false );
    if($search_icon) : ?>
        <div class="header-mobile-search">
            <form role="search" method="get" action="<?php echo esc_url(home_url( '/' )); ?>">
                <input type="text" placeholder="<?php if(!empty($search_field_placeholder)) { echo esc_attr( $search_field_placeholder ); } else { esc_attr_e('Search...', 'organio'); } ?>" name="s" class="search-field" />
                <button type="submit" class="search-submit"><i class="caseicon-search"></i></button>
            </form>
        </div>
<?php endif; }

/**
 * Header Search Popup
 */
function organio_search_popup()
{
    $search_icon = organio_get_opt( 'search_icon', false );
    if($search_icon) { ?>
        <div class="ct-modal ct-modal-search">
            <div class="ct-modal-close"><i class="ct-icon-close"></i></div>
            <div class="ct-modal-overlay"></div>
            <div class="ct-modal-content">
                <form role="search" method="get" class="search-form-popup" action="<?php echo esc_url(home_url( '/' )); ?>">
                    <div class="searchform-wrap">
                        <input type="text" placeholder="<?php echo esc_attr__('Enter Keywords...', 'organio'); ?>" id="search" name="s" class="search-field" />
                        <button type="submit" class="search-submit"><i class="caseicon-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    <?php }
}

/**
 * Sidebar Hidden
 */
function organio_sidebar_hidden()
{
    $hidden_sidebar_icon = organio_get_opt( 'hidden_sidebar_icon', false );
    if($hidden_sidebar_icon && is_active_sidebar('sidebar-hidden')) { ?>
        <div class="ct-hidden-sidebar-wrap">
            <div class="ct-hidden-sidebar-overlay"></div>
            <div class="ct-hidden-sidebar">
                <div class="ct-modal-close"><i class="ct-icon-close"></i></div>
                <div class="ct-hidden-sidebar-inner">
                    <div class="ct-hidden-sidebar-holder">
                        <?php dynamic_sidebar( 'sidebar-hidden' ); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}

/**
 * Cart Sidebar
 */
function organio_cart_sidebar() { 
    $cart_icon = organio_get_opt( 'cart_icon', false ); ?>
    <?php if(class_exists('Woocommerce')) : 
        global $woocommerce; ?>
        <div class="ct-widget-cart-wrap">
            <div class="ct-widget-cart-overlay"></div>
            <div class="ct-widget-cart-sidebar">
                <div class="ct-close"><i class="ct-icon-close"></i></div>
                <div class="widget_shopping_cart">
                    <div class="widget_shopping_head">
                        <div class="widget_shopping_title">
                            <?php echo esc_html__( 'Cart', 'organio' ); ?>
                        </div>
                    </div>
                    <div class="widget_shopping_cart_content">
                        <?php
                            $cart_is_empty = sizeof( $woocommerce->cart->get_cart() ) <= 0;
                        ?>
                        <ul class="cart_list product_list_widget">

                        <?php if ( ! WC()->cart->is_empty() ) : ?>

                            <?php
                                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                                    $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                    $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

                                        $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
                                        $thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
                                        $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                                        ?>
                                        <li>
                                            <?php if(!empty($thumbnail)) : ?>
                                                <div class="cart-product-image">
                                                    <a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
                                                        <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="cart-product-meta">
                                                <h3><a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>"><?php echo esc_html($product_name); ?></a></h3>
                                                <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
                                                <?php
                                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                                        '<a href="%s" class="remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><i class="caseicon-close"></i></a>',
                                                        esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                        esc_attr__( 'Remove this item', 'organio' ),
                                                        esc_attr( $product_id ),
                                                        esc_attr( $cart_item_key ),
                                                        esc_attr( $_product->get_sku() )
                                                    ), $cart_item_key );
                                                ?>
                                            </div>  
                                        </li>
                                        <?php
                                    }
                                }
                            ?>

                            <?php else : ?>

                                <li class="empty">
                                    <i class="caseicon-shopping-cart-alt"></i>
                                    <span><?php esc_html_e( 'Your cart is empty', 'organio' ); ?></span>
                                    <a class="btn btn-animate" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"><?php echo esc_html__('Browse Shop', 'organio'); ?></a>
                                </li>

                            <?php endif; ?>

                        </ul><!-- end product list -->
                    </div>
                    <?php if ( ! WC()->cart->is_empty() ) : ?>
                        <div class="widget_shopping_cart_footer">
                            <p class="total"><strong><?php esc_html_e( 'Subtotal', 'organio' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

                            <?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

                            <p class="buttons">
                                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn btn-outline btn-animate wc-forward"><?php esc_html_e( 'View Cart', 'organio' ); ?></a>
                                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-animate checkout wc-forward"><?php esc_html_e( 'Checkout', 'organio' ); ?></a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php }
/**
 * User custom fields.
 */
add_action( 'show_user_profile', 'organio_user_fields' );
add_action( 'edit_user_profile', 'organio_user_fields' );
function organio_user_fields($user){

    $user_facebook = get_user_meta($user->ID, 'user_facebook', true);
    $user_twitter = get_user_meta($user->ID, 'user_twitter', true);
    $user_linkedin = get_user_meta($user->ID, 'user_linkedin', true);
    $user_skype = get_user_meta($user->ID, 'user_skype', true);
    $user_google = get_user_meta($user->ID, 'user_google', true);
    $user_youtube = get_user_meta($user->ID, 'user_youtube', true);
    $user_vimeo = get_user_meta($user->ID, 'user_vimeo', true);
    $user_tumblr = get_user_meta($user->ID, 'user_tumblr', true);
    $user_pinterest = get_user_meta($user->ID, 'user_pinterest', true);
    $user_instagram = get_user_meta($user->ID, 'user_instagram', true);
    $user_yelp = get_user_meta($user->ID, 'user_yelp', true);

    ?>
    <h3><?php esc_html_e('Social', 'organio'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="user_facebook"><?php esc_html_e('Facebook', 'organio'); ?></label></th>
            <td>
                <input id="user_facebook" name="user_facebook" type="text" value="<?php echo esc_attr(isset($user_facebook) ? $user_facebook : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_twitter"><?php esc_html_e('Twitter', 'organio'); ?></label></th>
            <td>
                <input id="user_twitter" name="user_twitter" type="text" value="<?php echo esc_attr(isset($user_twitter) ? $user_twitter : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_linkedin"><?php esc_html_e('Linkedin', 'organio'); ?></label></th>
            <td>
                <input id="user_linkedin" name="user_linkedin" type="text" value="<?php echo esc_attr(isset($user_linkedin) ? $user_linkedin : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_skype"><?php esc_html_e('Skype', 'organio'); ?></label></th>
            <td>
                <input id="user_skype" name="user_skype" type="text" value="<?php echo esc_attr(isset($user_skype) ? $user_skype : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_google"><?php esc_html_e('Google', 'organio'); ?></label></th>
            <td>
                <input id="user_google" name="user_google" type="text" value="<?php echo esc_attr(isset($user_google) ? $user_google : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_youtube"><?php esc_html_e('Youtube', 'organio'); ?></label></th>
            <td>
                <input id="user_youtube" name="user_youtube" type="text" value="<?php echo esc_attr(isset($user_youtube) ? $user_youtube : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_vimeo"><?php esc_html_e('Vimeo', 'organio'); ?></label></th>
            <td>
                <input id="user_vimeo" name="user_vimeo" type="text" value="<?php echo esc_attr(isset($user_vimeo) ? $user_vimeo : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_tumblr"><?php esc_html_e('Tumblr', 'organio'); ?></label></th>
            <td>
                <input id="user_tumblr" name="user_tumblr" type="text" value="<?php echo esc_attr(isset($user_tumblr) ? $user_tumblr : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_pinterest"><?php esc_html_e('Pinterest', 'organio'); ?></label></th>
            <td>
                <input id="user_pinterest" name="user_pinterest" type="text" value="<?php echo esc_attr(isset($user_pinterest) ? $user_pinterest : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_instagram"><?php esc_html_e('Instagram', 'organio'); ?></label></th>
            <td>
                <input id="user_instagram" name="user_instagram" type="text" value="<?php echo esc_attr(isset($user_instagram) ? $user_instagram : ''); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="user_yelp"><?php esc_html_e('Yelp', 'organio'); ?></label></th>
            <td>
                <input id="user_yelp" name="user_yelp" type="text" value="<?php echo esc_attr(isset($user_yelp) ? $user_yelp : ''); ?>" />
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save user custom fields.
 */
add_action( 'personal_options_update', 'organio_save_user_custom_fields' );
add_action( 'edit_user_profile_update', 'organio_save_user_custom_fields' );
function organio_save_user_custom_fields( $user_id )
{
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    if(isset($_POST['user_facebook']))
        update_user_meta( $user_id, 'user_facebook', $_POST['user_facebook'] );
    if(isset($_POST['user_twitter']))
        update_user_meta( $user_id, 'user_twitter', $_POST['user_twitter'] );
    if(isset($_POST['user_linkedin']))
        update_user_meta( $user_id, 'user_linkedin', $_POST['user_linkedin'] );
    if(isset($_POST['user_skype']))
        update_user_meta( $user_id, 'user_skype', $_POST['user_skype'] );
    if(isset($_POST['user_google']))
        update_user_meta( $user_id, 'user_google', $_POST['user_google'] );
    if(isset($_POST['user_youtube']))
        update_user_meta( $user_id, 'user_youtube', $_POST['user_youtube'] );
    if(isset($_POST['user_vimeo']))
        update_user_meta( $user_id, 'user_vimeo', $_POST['user_vimeo'] );
    if(isset($_POST['user_tumblr']))
        update_user_meta( $user_id, 'user_tumblr', $_POST['user_tumblr'] );
    if(isset($_POST['user_pinterest']))
        update_user_meta( $user_id, 'user_pinterest', $_POST['user_pinterest'] );
    if(isset($_POST['user_instagram']))
        update_user_meta( $user_id, 'user_instagram', $_POST['user_instagram'] );
    if(isset($_POST['user_yelp']))
        update_user_meta( $user_id, 'user_yelp', $_POST['user_yelp'] );
}
/* Author Social */
function organio_get_user_social() {

    $user_facebook = get_user_meta(get_the_author_meta( 'ID' ), 'user_facebook', true);
    $user_twitter = get_user_meta(get_the_author_meta( 'ID' ), 'user_twitter', true);
    $user_linkedin = get_user_meta(get_the_author_meta( 'ID' ), 'user_linkedin', true);
    $user_skype = get_user_meta(get_the_author_meta( 'ID' ), 'user_skype', true);
    $user_google = get_user_meta(get_the_author_meta( 'ID' ), 'user_google', true);
    $user_youtube = get_user_meta(get_the_author_meta( 'ID' ), 'user_youtube', true);
    $user_vimeo = get_user_meta(get_the_author_meta( 'ID' ), 'user_vimeo', true);
    $user_tumblr = get_user_meta(get_the_author_meta( 'ID' ), 'user_tumblr', true);
    $user_pinterest = get_user_meta(get_the_author_meta( 'ID' ), 'user_pinterest', true);
    $user_instagram = get_user_meta(get_the_author_meta( 'ID' ), 'user_instagram', true);
    $user_yelp = get_user_meta(get_the_author_meta( 'ID' ), 'user_yelp', true);

    ?>
    <ul class="user-social">
        <?php if(!empty($user_facebook)) { ?>
            <li><a href="<?php echo esc_url($user_facebook); ?>"><i class="caseicon-facebook"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_twitter)) { ?>
            <li><a href="<?php echo esc_url($user_twitter); ?>"><i class="caseicon-twitter"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_linkedin)) { ?>
            <li><a href="<?php echo esc_url($user_linkedin); ?>"><i class="caseicon-linkedin"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_instagram)) { ?>
            <li><a href="<?php echo esc_url($user_instagram); ?>"><i class="caseicon-instagram"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_google)) { ?>
            <li><a href="<?php echo esc_url($user_google); ?>"><i class="caseicon-google-plus"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_skype)) { ?>
            <li><a href="<?php echo esc_url($user_skype); ?>"><i class="caseicon-skype"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_pinterest)) { ?>
            <li><a href="<?php echo esc_url($user_pinterest); ?>"><i class="caseicon-pinterest"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_vimeo)) { ?>
            <li><a href="<?php echo esc_url($user_vimeo); ?>"><i class="caseicon-vimeo"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_youtube)) { ?>
            <li><a href="<?php echo esc_url($user_youtube); ?>"><i class="caseicon-youtube"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_yelp)) { ?>
            <li><a href="<?php echo esc_url($user_yelp); ?>"><i class="caseicon-yelp"></i></a></li>
        <?php } ?>
        <?php if(!empty($user_tumblr)) { ?>
            <li><a href="<?php echo esc_url($user_tumblr); ?>"><i class="caseicon-tumblr"></i></a></li>
        <?php } ?>

    </ul> <?php
}

function organio_social_share_product() { ?>
    <a class="fb-social hover-effect" title="Facebook" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="zmdi zmdi-facebook"></i></a>
    <a class="tw-social hover-effect" title="Twitter" target="_blank" href="https://twitter.com/home?status=<?php the_permalink(); ?>"><i class="zmdi zmdi-twitter"></i></a>
    <a class="g-social hover-effect" title="Google Plus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="zmdi zmdi-google-plus"></i></a>
    <a class="pin-social hover-effect" title="Pinterest" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url(the_post_thumbnail_url( 'full' )); ?>&media=&description=<?php the_title(); ?>"><i class="zmdi zmdi-pinterest"></i></a>
    <?php
}

function organio_product_nav() {
    global $post;
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();
    if( !empty($next_post) || !empty($previous_post) ) { ?>
        <div class="product-previous-next">
            <?php if ( is_a( $previous_post , 'WP_Post' ) && get_the_title( $previous_post->ID ) != '') { ?>
                <a class="nav-link-prev" href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><i class="fa fa-long-arrow-left"></i></a>
            <?php } ?>
            <?php if ( is_a( $next_post , 'WP_Post' ) && get_the_title( $next_post->ID ) != '') { ?>
                <a class="nav-link-next" href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><i class="fa fa-long-arrow-right"></i></a>
            <?php } ?>
        </div>
    <?php }
}

/**
 * Social Icon
 */
function organio_social_header() {
    $social_facebook_url = organio_get_opt( 'h_social_facebook_url' );
    $social_twitter_url = organio_get_opt( 'h_social_twitter_url' );
    $social_dribbble_url = organio_get_opt( 'h_social_dribbble_url' );
    $social_behance_url = organio_get_opt( 'h_social_behance_url' );
    $social_inkedin_url = organio_get_opt( 'h_social_inkedin_url' );
    $social_instagram_url = organio_get_opt( 'h_social_instagram_url' );
    $social_google_url = organio_get_opt( 'h_social_google_url' );
    $social_skype_url = organio_get_opt( 'h_social_skype_url' );
    $social_pinterest_url = organio_get_opt( 'h_social_pinterest_url' );
    $social_vimeo_url = organio_get_opt( 'h_social_vimeo_url' );
    $social_youtube_url = organio_get_opt( 'h_social_youtube_url' );
    $social_yelp_url = organio_get_opt( 'h_social_yelp_url' );
    $social_tumblr_url = organio_get_opt( 'h_social_tumblr_url' );
    $social_tripadvisor_url = organio_get_opt( 'h_social_tripadvisor_url' );
    if(!empty($social_facebook_url) || !empty($social_dribbble_url) || !empty($social_behance_url) || !empty($social_twitter_url) || !empty($social_inkedin_url) || !empty($social_instagram_url) || !empty($social_google_url) || !empty($social_skype_url) || !empty($social_pinterest_url) || !empty($social_vimeo_url) || !empty($social_youtube_url) || !empty($social_yelp_url) || !empty($social_tumblr_url) || !empty($social_tripadvisor_url)) : ?>
        <?php
        if(!empty($social_facebook_url)) :
            echo '<a href="'.esc_url($social_facebook_url).'" target="_blank"><i class="caseicon-facebook"></i></a>';
        endif;
        if(!empty($social_twitter_url)) :
            echo '<a href="'.esc_url($social_twitter_url).'" target="_blank"><i class="caseicon-twitter"></i></a>';
        endif;
        if(!empty($social_dribbble_url)) :
            echo '<a href="'.esc_url($social_dribbble_url).'" target="_blank"><i class="caseicon-dribbble"></i></a>';
        endif;
        if(!empty($social_behance_url)) :
            echo '<a href="'.esc_url($social_behance_url).'" target="_blank"><i class="caseicon-behance"></i></a>';
        endif;
        if(!empty($social_inkedin_url)) :
            echo '<a href="'.esc_url($social_inkedin_url).'" target="_blank"><i class="caseicon-linkedin"></i></a>';
        endif;
        if(!empty($social_instagram_url)) :
            echo '<a href="'.esc_url($social_instagram_url).'" target="_blank"><i class="caseicon-instagram"></i></a>';
        endif;
        if(!empty($social_google_url)) :
            echo '<a href="'.esc_url($social_google_url).'" target="_blank"><i class="caseicon-google-plus"></i></a>';
        endif;
        if(!empty($social_skype_url)) :
            echo '<a href="'.esc_url($social_skype_url).'" target="_blank"><i class="caseicon-skype"></i></a>';
        endif;
        if(!empty($social_pinterest_url)) :
            echo '<a href="'.esc_url($social_pinterest_url).'" target="_blank"><i class="caseicon-pinterest"></i></a>';
        endif;
        if(!empty($social_vimeo_url)) :
            echo '<a href="'.esc_url($social_vimeo_url).'" target="_blank"><i class="caseicon-vimeo"></i></a>';
        endif;
        if(!empty($social_youtube_url)) :
            echo '<a href="'.esc_url($social_youtube_url).'" target="_blank"><i class="caseicon-youtube"></i></a>';
        endif;
        if(!empty($social_yelp_url)) :
            echo '<a href="'.esc_url($social_yelp_url).'" target="_blank"><i class="caseicon-yelp"></i></a>';
        endif;
        if(!empty($social_tumblr_url)) :
            echo '<a href="'.esc_url($social_tumblr_url).'" target="_blank"><i class="caseicon-tumblr"></i></a>';
        endif; 
        if(!empty($social_tripadvisor_url)) :
            echo '<a href="'.esc_url($social_tripadvisor_url).'" target="_blank"><i class="caseicon-tripadvisor"></i></a>';
        endif;
        ?>
    <?php endif; ?>
<?php }

if(!function_exists('organio_get_post_grid_layout1')){
    function organio_get_post_grid_layout1($posts = [], $settings = []){
        extract($settings);
        $images_size = '371x255';
        if(!empty($img_size)) {
            $images_size = $img_size;
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                $author = get_user_by('id', $post->post_author);
                $comment_count = get_comments_number($post->ID);
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                            <div class="item--featured image-effect-white">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="item--holder">
                            <div class="item--holder-inner">
                                <?php if($show_date == 'true' || $show_author == 'true' ) : ?>
                                    <ul class="item--meta">
                                        <?php if($show_date == 'true'): ?>
                                            <li class="item-date"><i class="caseicon-calendar"></i><?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?></li>
                                        <?php endif; ?>
                                        <?php if($show_author == 'true'): ?>
                                            <li class="item-author">
                                                <i class="caseicon-user"></i><a href="<?php echo esc_url(get_author_posts_url($post->post_author, $author->user_nicename)); ?>"><?php echo esc_html($author->display_name); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                <?php endif; ?>
                                <h3 class="item--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                                <div class="item--bottom">
                                    <?php if($show_button == 'true') : ?>
                                        <div class="item--readmore">
                                            <a class="btn-line-text" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                                <span><?php if(!empty($button_text)) {
                                                    echo esc_attr($button_text);
                                                } else {
                                                    echo esc_html__('Read more', 'organio');
                                                } ?></span>
                                                <i class="caseicon-angle-arrow-right"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($show_comment == 'true') : ?>
                                        <div class="item--comment">
                                            <i class="caseicon-comment"></i><?php if($comment_count < 10 ) { echo '0'; } ?><?php echo get_comments_number($post->ID); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_service_layout1')){
    function organio_get_service_layout1($posts = [], $settings = []){
        extract($settings);
        if (is_array($posts)):
            if(!empty($img_size)) {
                $images_size = $img_size;
            } else {
                $images_size = '370x370';
            }
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $service_except = get_post_meta($post->ID, 'service_except', true);
                $icon_type = get_post_meta($post->ID, 'icon_type', true);
                $service_icon = get_post_meta($post->ID, 'service_icon', true);
                $service_icon_img = get_post_meta($post->ID, 'service_icon_img', true);
                if(!empty($service_icon_img)) {
                    $icon_img = ct_get_image_by_size( array(
                        'attach_id'  => $service_icon_img['id'],
                        'thumb_size' => $img_size,
                    ));
                    $icon_thumbnail = $icon_img['thumbnail'];
                }
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                    <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                        <div class="grid-item-inner <?php if($key == 0) { echo 'active'; } ?> <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s"> 
                            <div class="item--featured">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                            </div>
                            <?php if($icon_type == 'icon' && !empty($service_icon)) : ?>
                                <div class="item--icon icon-psb"><i class="<?php echo esc_attr($service_icon); ?>"></i></div>
                            <?php endif; ?>
                            <?php if($icon_type == 'image' && !empty($service_icon_img)) : ?>
                                <div class="item--icon icon-psb">
                                    <?php echo wp_kses_post($icon_thumbnail); ?>
                                </div>
                            <?php endif; ?>
                            <div class="item--holder">
                                <?php if($show_title == 'true'): ?>
                                    <h3 class="item--title"><?php echo esc_attr(get_the_title($post->ID)); ?></h3>
                                <?php endif; ?>
                            </div>

                            <div class="item--holder-hover">
                                <div class="item--holder-inner">
                                    <?php if($show_title == 'true'): ?>
                                        <h3 class="item--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                                    <?php endif; ?>
                                    <?php if($show_excerpt == 'true' && !empty($service_except)): ?>
                                        <div class="item--content">
                                            <?php echo wp_trim_words( $service_except, $num_words, $more = null ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($show_button == 'true') : ?>
                                        <div class="item-readmore">
                                            <a class="btn btn-animate" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                                <span>
                                                    <?php if(!empty($button_text)) {
                                                        echo esc_attr($button_text);
                                                    } else {
                                                        echo esc_html__('Read more', 'organio');
                                                    } ?>
                                                </span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_portfolio_layout1')){
    function organio_get_portfolio_layout1($posts = [], $settings = []){
        extract($settings);
        if(!empty($img_size)) {
            $images_size = $img_size;
        } else {
            $images_size = '272x330';
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    } else {
                        $images_size = $img_size;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                    <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                        <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                            <div class="item--featured">
                                <?php echo ct_print_html($thumbnail); ?>
                            </div>
                            
                            <div class="item--holder">
                                <div class="item--meta">
                                    <?php if($show_title == 'true'): ?>
                                        <h3 class="item--title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                                    <?php endif; ?>
                                    <?php if($show_category == 'true'): ?>
                                        <div class="item--category">
                                            <?php the_terms( $post->ID, 'portfolio-category', '', ' ' ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if($show_button == 'true') : ?>
                                    <div class="item--readmore">
                                        <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            <?php endif;
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_portfolio_layout2')){
    function organio_get_portfolio_layout2($posts = [], $settings = []){
        extract($settings);
        if(!empty($img_size)) {
            $images_size = $img_size;
        } else {
            $images_size = '272x330';
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    } else {
                        $images_size = $img_size;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): 
                    $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                    ?>
                    <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                        <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                            <div class="item--featured">
                                <?php echo ct_print_html($thumbnail); ?>
                                <div class="item--lightbox"><a href="<?php echo esc_url($thumbnail_url[0]); ?>">+</a></div>
                            </div>
                        </div>
                    </div>
            <?php endif;
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_product_grid_layout1')){
    function organio_get_product_grid_layout1($posts = [], $settings = []){
        extract($settings);
        $images_size = '600x500';
        if(!empty($img_size)) {
            $images_size = $img_size;
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                $line_color = get_post_meta($post->ID, 'line_color', true);
                $product = wc_get_product( $post->ID );
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                        <div class="woocommerce-product-inner" <?php if(!empty($line_color['rgba'])) : ?>style="border-color: <?php echo esc_attr($line_color['rgba']); ?>"<?php endif; ?>>
                            <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                                <div class="woocommerce-product-header">
                                    <a class="woocommerce-product-details" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                    <div class="woocommerce-product-meta">
                                        <?php if (class_exists('WPCleverWoosc')) { ?>
                                            <div class="woocommerce-compare">
                                                <?php echo do_shortcode('[woosc id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (class_exists('WPCleverWoosw')) { ?>
                                            <div class="woocommerce-wishlist">
                                                <?php echo do_shortcode('[woosw id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (class_exists('WPCleverWoosq')) { ?>
                                            <div class="woocommerce-quick-view">
                                                <?php echo do_shortcode('[woosq id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="woocommerce-product-content">
                               <h4 class="woocommerce-product--title">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                                </h4>
                                <span class="price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                                <div class="woocommerce-product--rating">
                                    <?php 
                                        $rating  = $product->get_average_rating();
                                        $count   = $product->get_rating_count();
                                        echo wc_get_rating_html( $rating, $count );
                                    ?>
                                </div>
                                <div class="woocommerce-add-to-cart">
                                    <?php
                                    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button ajax_add_to_cart %s product_type_%s">%s</a>',
                                            esc_url( $product->add_to_cart_url() ),
                                            esc_attr( $product->get_id() ),
                                            esc_attr( $product->get_sku() ),
                                            $product->is_purchasable() ? 'add_to_cart_button' : '',
                                            esc_attr( $product->get_type() ),
                                            esc_html( $product->add_to_cart_text() )
                                        ),
                                        $product );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_product_grid_layout2')){
    function organio_get_product_grid_layout2($posts = [], $settings = []){
        extract($settings);
        $images_size = '600x500';
        if(!empty($img_size)) {
            $images_size = $img_size;
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                $line_color = get_post_meta($post->ID, 'line_color', true);
                $product = wc_get_product( $post->ID );
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                        <div class="woocommerce-product-inner" <?php if(!empty($line_color['rgba'])) : ?>style="border-color: <?php echo esc_attr($line_color['rgba']); ?>"<?php endif; ?>>
                            <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                                <div class="woocommerce-product-header">
                                    <svg data-name="Product-Shape" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 103.68 110.93"><path d="M366.06,226.05a38.51,38.51,0,0,0,4.28-4c.93-.92,1.7-2,2.54-3,.4-.51.85-1,1.2-1.54l1.09-1.62c.38-.56.76-1.12,1.12-1.69.22-.35.48-.73.73-1.19a45.27,45.27,0,0,0,2.85-5.65l-.09.43c0,.33,0,.44.19.18a20.33,20.33,0,0,0,1.71-5.9c.05-.2.11-.4.16-.6a50.26,50.26,0,0,0,1.46-15.86,24.31,24.31,0,0,0-.65-4.48c-.15-.62-.3-1.25-.46-1.9a16.92,16.92,0,0,0-.51-2c-.23-.72-.43-1.47-.66-2.22.34.37.42.09.53-.27.45.15,1.68,3.57,1.82,2.5-.22-.64-.42-1.25-.62-1.82-.09-.28-.19-.56-.28-.82s-.22-.5-.33-.74c-.43-.95-.81-1.76-1.13-2.46a15,15,0,0,0-1.6-2.81c-.72-1-1-1-1.39-.87a42.07,42.07,0,0,0-4.28-6.61,52.14,52.14,0,0,1,4.12,6.68c-.24.11-.43.29.59,2.43.44.85.66,1.54,1,2.1s.58,1,.87,1.58l.34.57a46.44,46.44,0,0,1,.83,26.46,48,48,0,0,1-3.38,8.9c0-.33,0-.42-.33,0a25.32,25.32,0,0,0-1.95,4.11c-.36.57-.76,1.13-1.15,1.69l-.47.07c.71-1,1.4-2.08,2-3.17a46.35,46.35,0,0,0-15-62.3c-.37-.25-.73-.51-1.11-.73l-1.16-.64-2.33-1.25c-1.58-.79-3.24-1.4-4.87-2.08-1.69-.5-3.36-1.08-5.08-1.45l-2.6-.51c-.43-.07-.86-.17-1.3-.23l-1.31-.13a47.57,47.57,0,0,0-20.77,2.4l-2.49,1a20.64,20.64,0,0,0-2.42,1.15c-1,.54-2.08,1.12-2.9,1.6s-1.33,1-1.31,1.09.09.18.45.06,1-.47,2.17-1l3-1.42,3.51-1.37c.83-.34,1.71-.53,2.56-.8s1.7-.53,2.58-.7l2.63-.49c.43-.08.87-.18,1.31-.23l1.33-.13-.21.24c-1.82.44,1.91,0,2.79,0s1.74.06,2.71.08a25.13,25.13,0,0,1,3,.16h0c-.11.13-1.45.14,0,.4h0l.15,0a3.47,3.47,0,0,0,.74.13c.56.11,1.23.22,2,.34s1.58.35,2.51.53c.2.11-.07.14.75.36a45.95,45.95,0,0,1,21.42,12.57,41.92,41.92,0,0,1,9.3,14.19,43.32,43.32,0,0,1,3,16.73,24.17,24.17,0,0,1-.2,3.28,25.36,25.36,0,0,1-.43,3.25c-.22,1.08-.4,2.16-.67,3.22l-.95,3.15a11.79,11.79,0,0,1-.56,1.54l-.64,1.52-.63,1.51c-.24.49-.52,1-.77,1.45s-.43.78-.64,1.18a5.81,5.81,0,0,0-.95,1.16l-1.25,1.87a7.71,7.71,0,0,1-1.11,1.25c.22-.54.47-1,.63-1.56s.27-.9.4-1.33a44,44,0,0,0,4-8.17,41.73,41.73,0,0,0,.4-26.7,42.54,42.54,0,0,0-6.43-12.42,39.94,39.94,0,0,0-10.2-9.55,40.94,40.94,0,0,0-12.72-5.65,41.48,41.48,0,0,0-13.81-1,25.71,25.71,0,0,0-5.93,1.26c-.71.22-1.37.55-2.17.84s-1.74.58-2.89,1.12c-.91.4.42.05.63.08.44,0,3.68-.79,4.09-.7-.63.29-1.84.66-3,1a11.61,11.61,0,0,0-2.48,1.13c.64-.12,1.67-.6,2.69-.88l2.64-.72c.77-.22,1.46-.27,2.05-.39a19.6,19.6,0,0,1,2.69-.35,12.66,12.66,0,0,1,1.56,0,39,39,0,0,0-8.68,1.81,1.67,1.67,0,0,0-.81.05,11.75,11.75,0,0,0-1.32.49c-.27.21-.3.28-.07.26a38.87,38.87,0,0,0-18,57.58c.26.62.54,1.23.78,1.87-.19,0-.07.5.22,1.05s.67,1.15.86,1.58c-.9-1-1.76-2.09-2.54-3.18-.19-.29-.38-.56-.56-.82a2.12,2.12,0,0,0-.25-.76,13.5,13.5,0,0,0-.79-1.71c-1-1.83-.75-.68-1-.65l-.77-1.23a21.25,21.25,0,0,1-1.1-1.92c-.34-.63-.67-1.27-1-2-.55-1.28-.85-1.41-.5.18l.71,2.43c.12.41.24.83.38,1.26s.37.86.56,1.32A27.24,27.24,0,0,0,303,215.2c.41.48.89,1.11,1.34,1.66,3.37,3.61,3.56,3.74,2.14,2.94-.47-.41-1-.9-1.57-1.43-.27-.27-.57-.53-.85-.83l-.8-.94c-.54-.64-1.09-1.28-1.61-1.91s-.94-1.3-1.38-1.87L299.06,211a11.86,11.86,0,0,0-1.33-2.25,15.77,15.77,0,0,0,1,2.12c.35.63.77,1.23,1.16,1.85.19.49.2.67-.09.34a11.05,11.05,0,0,1-.68-.92l-.53-.8c-.19-.32-.38-.69-.6-1.11l-1.32-2.66c-.38-.95-.78-1.93-1.25-2.89a25.72,25.72,0,0,0,1.87,4.52c.39.76.77,1.51,1.12,2.18s.73,1.23,1,1.71a10.9,10.9,0,0,1-1.43-2,13.53,13.53,0,0,0-1.19-1.94,23.44,23.44,0,0,0,1.4,2.79c.61,1,1.23,1.91,1.68,2.71.13.24.24.42.33.57-.07,0-.1,0-.1.14a7.12,7.12,0,0,1-.47-.6,41.91,41.91,0,0,1-2.69-4.51l-1.18-2.34-.15-.36c0-.58-.13-1.35-.21-2.05a26.58,26.58,0,0,0-.57-3.51c-.08-.34-.17-.67-.25-1s-.11-.68-.17-1c-.12-.64-.25-1.23-.38-1.72-.91-3.18-.73-.12-.66,1.64a11.36,11.36,0,0,1,0,1.24c-.19-.58-.37-1.16-.51-1.74h0a44,44,0,0,1-.9-5.21l-.26-2.63c0-.88,0-1.76,0-2.65a56,56,0,0,1,.37-5.68c.06-.7.23-1.38.32-2a32.87,32.87,0,0,1,.84-3.79s0,0,0,0a7.2,7.2,0,0,0,.85-2.11c.59-1.46,1-2.64.84-2.93a1.56,1.56,0,0,0-.17.25c.62-1.62,1.09-2.95,1.28-3.51.2-.78-.79.7-1.63,2.62a32.44,32.44,0,0,0-2.72,7.31,2,2,0,0,1-.24.46c.08-.46.14-.93.23-1.39l.34-1.38a96.53,96.53,0,0,1,4.43-11.53c-4.71,7.84-7,15.91-6.79,24.26,0,2,.33,4.09.49,6.4a43.94,43.94,0,0,0,3.32,12.19,25.51,25.51,0,0,0,1.23,2.59c.45.85.85,1.72,1.33,2.52l1.44,2.33.68,1.11c.23.36.48.69.71,1-.29-.3-.55-.52-.88-.91-.49-.63-1.48-2.09-1.19-1.44a13.93,13.93,0,0,0,.91,1.57c.42.61,1,1.22,1.4,1.76a36.25,36.25,0,0,0,2.76,3.07l1.49,1.49.76.77.84.71a41.33,41.33,0,0,0,5.43,4.16l.07.07c.28.25.63.54,1,.84s.92.56,1.46.86a13.1,13.1,0,0,0,2.69,1.28l.35.08c.72.34,1.45.67,2.19,1s1.7.76,2.59,1.05l2.68.83,1.34.41,1.38.29,2.75.55c.93.17,1.87.22,2.8.33s1.87.23,2.81.22h.88a14.4,14.4,0,0,0,1.54.26c.63,0,1.5,0,2.26.05l2.24.3c-.25.21-.37.41-1.89.63a11.73,11.73,0,0,0-3,.12c-.93.1,0,.36.78.39.35.28,1.4.4,4.06.16a31.53,31.53,0,0,0,5.41-.54,7.47,7.47,0,0,0,2.54-1.45c.19-.31.12-.53-.46-.57a7.24,7.24,0,0,0-1.29.11c-.58.07-1.31.28-2.27.36l-3.08-.22a46.74,46.74,0,0,0,19.08-6.79l2.46-1.59C364.54,227.27,365.3,226.65,366.06,226.05Zm-43.36.58h0c.39,0,0-.16-.54-.28l-.43-.06A47,47,0,0,1,314.9,223a4.34,4.34,0,0,0-1-1,17.89,17.89,0,0,1-1.95-.9,32.07,32.07,0,0,1-3-2.35c-.49-.62-1-1.45-1.8-2.55-.19-.29-.49-.74-.73-1.12l.19-.29.31.39,1.76,1.81.88.91,1,.81,1.93,1.63,2.08,1.44.14.09a40.06,40.06,0,0,0,12.2,5.39,35.58,35.58,0,0,0,4.24.79c.53.12,1.05.24,1.56.33.72.05,1.43.09,2.14.1a9.65,9.65,0,0,0,2.32-.14c1,0,2-.09,3.06-.19a38.82,38.82,0,0,0,7.39-1.46s-.05.07,0,.09.2.08.52,0a15.29,15.29,0,0,0,2-.73c.46-.22.89-.39,1.24-.6s.48-.31.69-.46a22.15,22.15,0,0,0,2.1-1.12,5.48,5.48,0,0,0,1-.36q.34-.15.75-.36l.84-.54a40.32,40.32,0,0,0,5.65-4.15c-.26.3-.5.6-.72.89l-.08.07s0,0,0,0h0l0,0-2.32,1.85-2.49,1.61c-.81.57-1.71,1-2.56,1.45a27.18,27.18,0,0,1-2.58,1.31,44.89,44.89,0,0,1-11.83,3l-1.34.15h0l-.21,0-.39,0h-2c-.67,0-1.35,0-2,0l-2-.19A35.9,35.9,0,0,1,322.7,226.63Zm19.36,5.12-.33.1h-.07a39.28,39.28,0,0,1-11,0,21.13,21.13,0,0,0-2.6-.59l-1.57-.44,2.2.39,1.12.2c.37.05.75.07,1.12.11a36.48,36.48,0,0,0,12.82-.66c1-.2,2-.45,2.94-.73A18,18,0,0,1,342.06,231.75Zm13.88-.21c-.81.39-1.71.71-2.6,1.09a24.81,24.81,0,0,1-2.69,1l-1.26.36a.22.22,0,0,1,0-.22c1.48-.45,2.94-1,4.37-1.54a6.09,6.09,0,0,0,.89-.24c.73-.28,1.64-.68,2.37-1Zm2-5.09c-.33.18-.68.35-1,.53.35-.3.72-.62,1.18-1a19.22,19.22,0,0,0,3.56-3.57,40.43,40.43,0,0,0,7.17-7.09,16.58,16.58,0,0,1-4,6.15,2.61,2.61,0,0,1-.24.23c-.82.66-1.66,1.29-2.51,1.91s-1.81,1.25-2.72,1.88Zm1.83,3.08L362,228l.82-.7c.2-.15.41-.28.62-.43a46.59,46.59,0,0,0,7.94-7.43c0,.05,0,.08,0,.14a.13.13,0,0,0,.14.13,45.39,45.39,0,0,1-4.31,4.46A50.35,50.35,0,0,1,359.76,229.53Z" transform="translate(-284.29 -136.28)"/><path d="M296.59,219c2.59,2.39,5.72,5.82,9.82,8.62a13.39,13.39,0,0,0,1.81,1.71q1,.82,2,1.62c.71.52,1.49,1,2.26,1.42a23.3,23.3,0,0,0,2.42,1.31,37.84,37.84,0,0,0,5.34,2c.94.27,1.89.58,2.85.82l3,.56c-1.55-.59-3.19-1.07-4.81-1.81l-2.5-1-2.47-1.2-1.27-.59c-.42-.2-.81-.46-1.22-.68l-2.46-1.4c-.82-.48-1.57-1.07-2.37-1.59a23.71,23.71,0,0,1-2.29-1.69,24.19,24.19,0,0,1-4.28-3.45c-.63-.64-1.25-1.25-1.82-1.91s-1-1.37-1.55-2.06a51.19,51.19,0,0,1-5-8.91c-.74-.47-1.3-1-2.27-1.74l.78,1.72c.25.54.54,1,.77,1.48.48.92.87,1.74,1.21,2.52C295.3,216.28,295.92,217.54,296.59,219Z" transform="translate(-284.29 -136.28)"/><path d="M288.08,203.27a8.28,8.28,0,0,1-.33-1.87,8.82,8.82,0,0,1,0-1.53,22.24,22.24,0,0,0,1.56,3.59c.66,1.15,1.31,2,.56-1.22-.24-1.61-.47-3.31-.76-5-.12-1.69-.36-3.36-.61-4.93-.09-1.21-.36-.69-.35.83s.1,3.07-.26,2.31c-.16-1.21-.31-2.13-.45-2.79a3.32,3.32,0,0,0-.25-1.15c-.1-.12-.2,0-.3.44a5,5,0,0,0-.15.8c0,.33,0,.73,0,1.19-.33,4.55.85,10,1.46,13.84a18.28,18.28,0,0,0,1.7,4.19c.57.46.79,0,.93-.56a15.5,15.5,0,0,0-1.38-4C288.89,206.05,288.45,204.58,288.08,203.27Z" transform="translate(-284.29 -136.28)"/><path d="M352.89,238.09c-6.75,2.49-7.88,1.7-9.21,1.42l2-.36,1-.17c.34-.08.68-.18,1-.27,1.36-.37,2.77-.7,4.13-1.15s2.63-1.08,3.84-1.68a19,19,0,0,0,3.17-2.22,43.17,43.17,0,0,1-15.61,5.41c-1.62.39-3.46.37-4.65.7-1.69.41-1.08.65-.23.88,1.2.32,1.82.48,1.19.67a24.55,24.55,0,0,1-6.17.48h0a34.29,34.29,0,0,1-4.65.69l-2-.54c-.64-.21-1.28-.47-1.91-.71,1-.16-.12-.79-.8-1.34s-.94-1,1.56-.89a37,37,0,0,1-3.93-.49l-4.08-.94L311,235.47l-2.07-1c-.69-.31-1.3-.72-1.87-1-2-1.06-2.93-1.43-2.71-1a6.33,6.33,0,0,0,1.2,1.14l1.28,1a14,14,0,0,0,1.78,1.21c2.33,1.38,3.59,2.32,4.59,2.92s1.58,1.17,2.57,1.82c5.86,2.71,12.33,4,17.44,3.37h0c2.8-.33,2.55-.81,8.29-1.34a26,26,0,0,0,12.93-3.64c.81-.36,1.85-.74,2.73-1.13a6.42,6.42,0,0,0,1.81-1.19c.22-.31-1.31.45-2.46.9C355.24,237.7,358.31,235.74,352.89,238.09Z" transform="translate(-284.29 -136.28)"/><path d="M386.82,200.25a14.26,14.26,0,0,0,.14-1.78c-.07-2.28-.82-1.49-1.5,1.36-.53,1.61-.92,3.21-1.28,4.76s-.85,3-1.17,4.51c-.17.64-.19,1.23,0,1a20.61,20.61,0,0,0,1.11-2.32l1.05-2.42C385.79,203.69,386.26,202,386.82,200.25Z" transform="translate(-284.29 -136.28)"/><path d="M387.54,199.22c-.53,3.66-.85,6.11-1.3,8.15-.2,1-.38,2-.56,3s-.56,1.92-.93,3c-.28.84-.07.76.4-.08a18.12,18.12,0,0,0,.85-1.78c.4-1.11.64-2.45,1-3.76a26,26,0,0,0,.76-3.88C388,201.39,388.1,199.48,387.54,199.22Z" transform="translate(-284.29 -136.28)"/><path d="M295.55,176c-.31,1.13-.53,2.14-.88,3.23a18.63,18.63,0,0,0-1.62,2.51,5.89,5.89,0,0,0-.78,2.57c-.1,1.38,0,2.05.22,1.62a2.94,2.94,0,0,1,.81-1,6.08,6.08,0,0,0,1-2c0,.33,0,.74-.08,1.18s0,.91,0,1.33c0,.83.12,1.46.41,1.32.2-3.64,1.51-7.46,2.28-10.38,1.17-3.28-.61-1.19.3-4.23A34.76,34.76,0,0,0,295.55,176Z" transform="translate(-284.29 -136.28)"/><path d="M306.85,157c-.84,1.06.28.43,1.77-.64a17.14,17.14,0,0,1,2.1-1.35l2.24-1.39,2.57-1.31,1.39-.71,1.53-.62a10,10,0,0,0-2.14.52c-.74.28-1.52.61-2.29.94l-1.16.5c-.37.18-.71.39-1.06.58-.69.37-1.33.71-1.9,1A9.6,9.6,0,0,0,306.85,157Z" transform="translate(-284.29 -136.28)"/><path d="M380.76,213.08a8.48,8.48,0,0,0-1.6,2.31c-.38.68-.79,1.54-1.23,2.41s-1,1.73-1.41,2.53c-.8,1.63-1.53,2.82-1.29,2.79a2.67,2.67,0,0,0,.88-.72c.37-.44.79-1,1.21-1.62a33.13,33.13,0,0,0,1.8-2.84c.47-.94.86-1.82,1.17-2.55a12.13,12.13,0,0,0,.6-1.74C381,213.24,380.91,213,380.76,213.08Z" transform="translate(-284.29 -136.28)"/><path d="M301.21,171.39c.56-1,1.08-1.75,1.35-2.31s.35-.93.26-1.09-.39.07-.79.55c-.2.24-.42.53-.66.86a6.51,6.51,0,0,0-.68,1.13c-.67,1.34-1.69,2.92-1.74,4.09a9.37,9.37,0,0,0,.92-1.22C300.28,172.85,300.74,172.17,301.21,171.39Z" transform="translate(-284.29 -136.28)"/><path d="M364.64,234.33a18.57,18.57,0,0,0-1.85,1.4c-.47.44-1,.92-.78.91a13.67,13.67,0,0,0,3-1.65c.58-.39,1.2-.75,1.76-1.18l1.68-1.32a33,33,0,0,0,3.23-2.79c-1.16.81-3.07,2-5,3.28C366.09,233.46,365.32,233.86,364.64,234.33Z" transform="translate(-284.29 -136.28)"/><path d="M310.72,233.15c-.54-.33-1.17-.66-1.76-1.1a9.5,9.5,0,0,0-2.71-1.53,6.43,6.43,0,0,0,1.59,1.59c.43.34.9.72,1.4,1.08l1.6,1c1.16.71,2.4,1.24,2.5,1.06s-.36-.62-1.17-1.17C311.77,233.79,311.27,233.48,310.72,233.15Z" transform="translate(-284.29 -136.28)"/><path d="M371.67,231.78c-2,1.27-4.42,3.22-7.35,5.1-.49.32-.79.69-1.75,1.38a14.64,14.64,0,0,0,1.95-1c1.25-.82,2.34-1.28,3.43-1.94a19.68,19.68,0,0,0,3.53-2.93C371.92,232,372,231.51,371.67,231.78Z" transform="translate(-284.29 -136.28)"/><path d="M376.13,224.68a14.29,14.29,0,0,0-2,2.34c-.68.8-1.37,1.64-2.14,2.45a4.32,4.32,0,0,1,1.47-.75,7.81,7.81,0,0,0,2.69-2.36C377.22,224.51,377.72,223.26,376.13,224.68Z" transform="translate(-284.29 -136.28)"/><path d="M371.9,229.52l-.19.18.12-.08.14-.15-.07.05Z" transform="translate(-284.29 -136.28)"/><path d="M342.62,244.86a13.39,13.39,0,0,0-3.32.62,7.86,7.86,0,0,0,3.21.2c2.82-.36,2.64-.7,3.05-.94C346.15,244.36,345,244.43,342.62,244.86Z" transform="translate(-284.29 -136.28)"/><path d="M288,163.55c.37-.51.8-1.25,1.37-2,1.37-1.92,1-1.79.9-1.93s-.73.26-2.08,2.25c-.9,1.57-1,2.19-1,2.43C287.34,164.35,287.63,164.06,288,163.55Z" transform="translate(-284.29 -136.28)"/><path d="M333.75,246.34a18.28,18.28,0,0,0-2.45.08,3.94,3.94,0,0,0-1,.19c-.24.06-.31.14,0,.25a6.62,6.62,0,0,0,2,.35,11,11,0,0,0,3.91-.47C336.37,246.55,335.59,246.38,333.75,246.34Z" transform="translate(-284.29 -136.28)"/><path d="M358.92,231.27c-.43.18-1,.44-1.57.76a18.71,18.71,0,0,0-3.08,1.89c-.12.14,0,.18.34.12a5,5,0,0,0,1.48-.61c1.61-.88,3.34-1.78,3.64-2.41C359.61,231,359.33,231.07,358.92,231.27Z" transform="translate(-284.29 -136.28)"/><path d="M370.09,234.76c-.72.45-1.4,1-2.1,1.53s-1.44,1-2.16,1.57a34.71,34.71,0,0,1-3.94,2.63c.85-.43,1.56-.76,2.13-1.08l1.39-.85,1.68-1.06a15.14,15.14,0,0,0,3.27-2.65C370.56,234.61,370.43,234.55,370.09,234.76Z" transform="translate(-284.29 -136.28)"/><path d="M284.88,204c-.22-.36-.33-.27-.59-.45a18.54,18.54,0,0,0,1.5,4.16,3.88,3.88,0,0,0,.71,1.14c.18.15.14,0-.09-1C285.73,204.76,285.31,204.65,284.88,204Z" transform="translate(-284.29 -136.28)"/><path d="M319.47,145.57a9.3,9.3,0,0,0,3.27-1.29c.21-.19-.4-.13-1.35.11a6,6,0,0,0-2.61,1.09C318.54,145.72,318.47,145.9,319.47,145.57Z" transform="translate(-284.29 -136.28)"/><path d="M295.22,192.75c.07-.36.12-.42.15-.61a35,35,0,0,0,.44-4.22c0-.24-.07-.68-.14-.54a11.7,11.7,0,0,0-.51,4A10.29,10.29,0,0,0,295.22,192.75Z" transform="translate(-284.29 -136.28)"/><path d="M383.8,202.25a7.27,7.27,0,0,0,1-3.26c.12-1.1.09-1.79-.07-1.62-.31.28-.45,1.85-.84,3.2S383.63,202.41,383.8,202.25Z" transform="translate(-284.29 -136.28)"/><path d="M376.46,162.18c.61.9,1,1.22,1.09,1.16A5.68,5.68,0,0,0,376.3,161c-.74-.91-1.22-1.32-1.19-1.08a2,2,0,0,0,.35.79C375.7,161,376,161.52,376.46,162.18Z" transform="translate(-284.29 -136.28)"/><path d="M296.77,223.84a12.09,12.09,0,0,0-1.75-2.59c-.69-.83-1.25-1.69-1.22-1.32a4.72,4.72,0,0,0,.55,1.14c.33.47.76,1,1.17,1.56C296.25,223.54,296.92,224.28,296.77,223.84Z" transform="translate(-284.29 -136.28)"/><path d="M334.12,137.59a9.57,9.57,0,0,0,3.16-.2c.27-.13-.33-.26-1.52-.3a18.49,18.49,0,0,0-2,0,5,5,0,0,0-1.21.28C332.47,137.56,333,137.55,334.12,137.59Z" transform="translate(-284.29 -136.28)"/><path d="M333.16,238.84c.12-.13-.34-.21-1.4-.31a5.29,5.29,0,0,0-2,0c-.24.1-.13.27.9.43C332.18,239.22,333,239,333.16,238.84Z" transform="translate(-284.29 -136.28)"/><path d="M299.09,225.31a4.2,4.2,0,0,0,1.13,1.5c1,1.11,1.77,1.48,1.85,1.32s-.43-.63-1.18-1.44C299.81,225.59,299.24,225.19,299.09,225.31Z" transform="translate(-284.29 -136.28)"/><path d="M289.06,170.31c-.64,1.44-.92,2.29-.68,2.11a5.92,5.92,0,0,0,.93-1.42,6.51,6.51,0,0,0,.76-2.12C290,168.47,289.61,169.14,289.06,170.31Z" transform="translate(-284.29 -136.28)"/><path d="M303.43,227.19c1.2,1,1.81,1.34,2,1.24,0-.15-.25-.54-1.06-1.23-1.26-1-1.8-1.36-1.91-1.22s0,.18.13.39A5.46,5.46,0,0,0,303.43,227.19Z" transform="translate(-284.29 -136.28)"/><path d="M308.69,154.68c.33-.24.65-.59.61-.65s-.8,0-1.94,1c-.84.69-1,1-.86,1.09A6.88,6.88,0,0,0,308.69,154.68Z" transform="translate(-284.29 -136.28)"/><path d="M302.73,235.45a9.13,9.13,0,0,0,2.14,1.59,1.74,1.74,0,0,0,.7.23,10,10,0,0,0-2.19-1.63C303,235.41,302.62,235.3,302.73,235.45Z" transform="translate(-284.29 -136.28)"/><path d="M296.23,202.93a6.77,6.77,0,0,0-.29-1.28c-.41-1.06-.61-1.91-.77-1.59a5.56,5.56,0,0,0,.23,1.38C295.8,202.57,296.12,203.26,296.23,202.93Z" transform="translate(-284.29 -136.28)"/><path d="M296.15,225.24c-.42-.35-.27.11.47.94a7.15,7.15,0,0,0,1.69,1.5c.16-.05-.2-.54-1-1.36C296.92,225.93,296.34,225.41,296.15,225.24Z" transform="translate(-284.29 -136.28)"/><path d="M376.34,216.49c-.56.88-.77,1.34-.68,1.46a3.52,3.52,0,0,0,1.24-1.47c.51-.94.66-1.44.52-1.46S376.89,215.48,376.34,216.49Z" transform="translate(-284.29 -136.28)"/><path d="M383.33,213.72c-.23.39-.5,1-.94,1.77-.74,1.39-1.21,2.4-.95,2.38a9.48,9.48,0,0,0,1.79-2.75,4.24,4.24,0,0,0,.59-1.94C383.72,213.14,383.56,213.32,383.33,213.72Z" transform="translate(-284.29 -136.28)"/><path d="M341.66,136.78a8.15,8.15,0,0,0-2.48-.49,3.91,3.91,0,0,0-1.26.12,12.23,12.23,0,0,0,2.42.38A9.61,9.61,0,0,0,341.66,136.78Z" transform="translate(-284.29 -136.28)"/><path d="M330.34,141.8a5.12,5.12,0,0,0-1.09-.08,4.21,4.21,0,0,0-1.12.31c0,.06.67,0,1.06,0A8.78,8.78,0,0,0,330.34,141.8Z" transform="translate(-284.29 -136.28)"/><path d="M376.2,227.74c-.35.64.19.14,1-.76a8.77,8.77,0,0,0,1.39-1.95,3.18,3.18,0,0,0-.71.55A13,13,0,0,0,376.2,227.74Z" transform="translate(-284.29 -136.28)"/><path d="M386.28,174.37l-.25-.9c-.08-.05-.18-.13-.24-.1l.24.85Z" transform="translate(-284.29 -136.28)"/><path d="M358.68,148.57a10,10,0,0,0,1.39.66c.32,0-.36-.46-1.24-1-.46-.21-1.18-.57-1.35-.6C357,147.57,357.77,148.07,358.68,148.57Z" transform="translate(-284.29 -136.28)"/><path d="M297.75,200.18c-.09-.87-.26-1.55-.4-1.31a3.86,3.86,0,0,0,0,1.09,4,4,0,0,0,.39,1A3.07,3.07,0,0,0,297.75,200.18Z" transform="translate(-284.29 -136.28)"/><path d="M328.5,139.74a9.52,9.52,0,0,0,2.4-.31c.14-.1-.8-.13-1-.16a4.85,4.85,0,0,0-2.12.27C327.41,139.74,327.48,139.83,328.5,139.74Z" transform="translate(-284.29 -136.28)"/><path d="M329.09,143.23l1.56-.12-.18-.19-1.48.21C328.88,143.15,329,143.24,329.09,143.23Z" transform="translate(-284.29 -136.28)"/></svg>
                                    <a class="woocommerce-product-details" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="woocommerce-product-meta">
                                <div class="woocommerce-add-to-cart">
                                    <?php
                                    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button no-animate ajax_add_to_cart %s product_type_%s">%s</a>',
                                            esc_url( $product->add_to_cart_url() ),
                                            esc_attr( $product->get_id() ),
                                            esc_attr( $product->get_sku() ),
                                            $product->is_purchasable() ? 'add_to_cart_button' : '',
                                            esc_attr( $product->get_type() ),
                                            esc_html( $product->add_to_cart_text() )
                                        ),
                                        $product );
                                    ?>
                                </div>
                                <?php if (class_exists('WPCleverWoosc')) { ?>
                                    <div class="woocommerce-compare">
                                        <?php echo do_shortcode('[woosc id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                    </div>
                                <?php } ?>
                                <?php if (class_exists('WPCleverWoosw')) { ?>
                                    <div class="woocommerce-wishlist">
                                        <?php echo do_shortcode('[woosw id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                    </div>
                                <?php } ?>
                                <?php if (class_exists('WPCleverWoosq')) { ?>
                                    <div class="woocommerce-quick-view">
                                        <?php echo do_shortcode('[woosq id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="woocommerce-product-content">
                               <h4 class="woocommerce-product--title">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                                </h4>
                                <span class="price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                                <div class="woocommerce-product--rating">
                                    <?php 
                                        $rating  = $product->get_average_rating();
                                        $count   = $product->get_rating_count();
                                        echo wc_get_rating_html( $rating, $count );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_product_grid_layout3')){
    function organio_get_product_grid_layout3($posts = [], $settings = []){
        extract($settings);
        global $product;
        $images_size = '600x500';
        if(!empty($img_size)) {
            $images_size = $img_size;
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                $product = wc_get_product( $post->ID );
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                        <div class="woocommerce-product-inner">
                            <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                                <div class="woocommerce-product-header">
                                    <a class="woocommerce-product-details" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                    <div class="woocommerce-product-meta">
                                        <?php if (class_exists('WPCleverWoosc')) { ?>
                                            <div class="woocommerce-compare">
                                                <?php echo do_shortcode('[woosc id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (class_exists('WPCleverWoosw')) { ?>
                                            <div class="woocommerce-wishlist">
                                                <?php echo do_shortcode('[woosw id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (class_exists('WPCleverWoosq')) { ?>
                                            <div class="woocommerce-quick-view">
                                                <?php echo do_shortcode('[woosq id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="woocommerce-product-content">
                               <h4 class="woocommerce-product--title">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                                </h4>
                                <span class="price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                                <div class="woocommerce-add-to--cart">
                                    <?php
                                    echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button btn btn-animate ajax_add_to_cart %s product_type_%s">%s</a>',
                                            esc_url( $product->add_to_cart_url() ),
                                            esc_attr( $product->get_id() ),
                                            esc_attr( $product->get_sku() ),
                                            $product->is_purchasable() ? 'add_to_cart_button' : '',
                                            esc_attr( $product->get_type() ),
                                            esc_html( $product->add_to_cart_text() )
                                        ),
                                        $product );
                                    ?>
                                </div>
                                <?php 
                                    if ( $show_quantity == 'yes' && ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() ) {
                                        woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_product_grid_layout4')){
    function organio_get_product_grid_layout4($posts = [], $settings = []){
        extract($settings);
        global $product;
        $images_size = '600x500';
        if(!empty($img_size)) {
            $images_size = $img_size;
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                $product = wc_get_product( $post->ID );
                $average = $product->get_average_rating();
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                        <div class="woocommerce-product-inner">
                            <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): 
                                $img_id       = get_post_thumbnail_id( $post->ID );
                                $img          = ct_get_image_by_size( array(
                                    'attach_id'  => $img_id,
                                    'thumb_size' => $img_size,
                                ) );
                                $thumbnail    = $img['thumbnail'];
                                ?>
                                <div class="woocommerce-product-header">
                                    <a class="woocommerce-product-details" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                    <?php if($show_rating_rate == 'yes') : ?>
                                        <div class="woocommerce-product-average">
                                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 406.125 406.125" style="enable-background:new 0 0 406.125 406.125;" xml:space="preserve">
                                            <path d="M260.133,155.967c-4.487,0-9.25-3.463-10.64-7.73L205.574,13.075c-1.39-4.268-3.633-4.268-5.023,0
                                                L156.64,148.237c-1.39,4.268-6.153,7.73-10.64,7.73H3.88c-4.487,0-5.186,2.138-1.553,4.78l114.971,83.521
                                                c3.633,2.642,5.454,8.242,4.064,12.51L77.452,391.932c-1.39,4.268,0.431,5.592,4.064,2.951l114.971-83.521
                                                c3.633-2.642,9.519-2.642,13.152,0l114.971,83.529c3.633,2.642,5.454,1.317,4.064-2.951l-43.911-135.154
                                                c-1.39-4.268,0.431-9.868,4.064-12.51l114.971-83.521c3.633-2.642,2.934-4.78-1.553-4.78H260.133V155.967z"/>
                                            </svg>

                                            <?php echo esc_attr($average); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="woocommerce-product-content">
                               <h4 class="woocommerce-product--title">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                                </h4>
                                <div class="price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                                <div class="woocommerce-product-meta">
                                    <div class="woocommerce-add-to--cart ct-loading-add-cart">
                                    <?php
                                        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button ajax_add_to_cart %s product_type_%s">%s</a>',
                                                esc_url( $product->add_to_cart_url() ),
                                                esc_attr( $product->get_id() ),
                                                esc_attr( $product->get_sku() ),
                                                $product->is_purchasable() ? 'add_to_cart_button' : '',
                                                esc_attr( $product->get_type() ),
                                                esc_html( $product->add_to_cart_text() )
                                            ),
                                            $product );
                                        ?>
                                    </div>
                                    <?php if (class_exists('WPCleverWoosq')) { ?>
                                            <div class="woocommerce-quick-view">
                                                <?php echo do_shortcode('[woosq id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                    <?php if (class_exists('WPCleverWoosw')) { ?>
                                        <div class="woocommerce-wishlist">
                                            <?php echo do_shortcode('[woosw id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php 
                                    if ( $show_quantity == 'yes' && ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() ) {
                                        woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_product_grid_layout5')){
    function organio_get_product_grid_layout5($posts = [], $settings = []){
        extract($settings);
        $images_size = '300x300';
        if(!empty($img_size)) {
            $images_size = $img_size;
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $filter_class_all = '';
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                $product = wc_get_product( $post->ID );
                $average = $product->get_average_rating();
                if($key == 1 && $style_l5 == 'style2') {  ?>
                    <div class="ct-product-banner1 <?php echo esc_attr($item_class); ?> ct-filter-class-added">
                        <div class="item--inner">
                            <div class="item--subtitle">
                                <?php echo esc_attr($sub_title); ?>
                            </div>
                            <h4 class="item--title">
                                <?php echo esc_attr($title); ?>
                            </h4>
                            <?php if(!empty($btn_text)) : ?>
                                <div class="item--button">
                                    <a class="btn btn-slider-animate1" href="<?php if ( ! empty( $btn_link['url'] ) ) { echo esc_url($btn_link['url']); } ?>" target="<?php echo esc_attr($btn_link['is_external']); ?>"><?php echo esc_attr($btn_text); ?><i class="flaticon flaticon-plus"></i></a>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($image['id'])) : ?>
                            <div class="item--image wow">
                                <?php $img_animate  = ct_get_image_by_size( array(
                                        'attach_id'  => $image['id'],
                                        'thumb_size' => 'full',
                                    ) );
                                    $thumbnail_animate    = $img_animate['thumbnail'];
                                echo ct_print_html($thumbnail_animate); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
                <?php } ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                        <div class="woocommerce-product-inner">
                            <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): 
                                $img_id       = get_post_thumbnail_id( $post->ID );
                                $img          = ct_get_image_by_size( array(
                                    'attach_id'  => $img_id,
                                    'thumb_size' => $img_size,
                                ) );
                                $thumbnail    = $img['thumbnail'];
                                ?>
                                <div class="woocommerce-product-header">
                                    <a class="woocommerce-product-details" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                    
                                </div>
                            <?php endif; ?>
                            <div class="woocommerce-product-content">
                               <h4 class="woocommerce-product--title">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                                </h4>
                                <div class="price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                                <?php if($style_l5 == 'style1') { ?>
                                    <div class="woocommerce-product-meta">
                                        <div class="woocommerce-add-to--cart ct-loading-add-cart">
                                        <?php
                                            echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                                sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button ajax_add_to_cart %s product_type_%s">%s</a>',
                                                    esc_url( $product->add_to_cart_url() ),
                                                    esc_attr( $product->get_id() ),
                                                    esc_attr( $product->get_sku() ),
                                                    $product->is_purchasable() ? 'add_to_cart_button' : '',
                                                    esc_attr( $product->get_type() ),
                                                    esc_html( $product->add_to_cart_text() )
                                                ),
                                                $product );
                                            ?>
                                        </div>
                                        <?php if (class_exists('WPCleverWoosq')) { ?>
                                                <div class="woocommerce-quick-view">
                                                    <?php echo do_shortcode('[woosq id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                                </div>
                                            <?php } ?>
                                        <?php if (class_exists('WPCleverWoosw')) { ?>
                                            <div class="woocommerce-wishlist">
                                                <?php echo do_shortcode('[woosw id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="woocommerce--item-readmore">
                                        <a class="btn btn-circle-plus" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                            <?php if(!empty($settings['btn_readmore'])) { 
                                                echo esc_attr($settings['btn_readmore']);
                                            } else {
                                                echo esc_html__('Shop Now', 'organio');
                                            }?>
                                            <i class="slider-icon-plus"></i>
                                            <i class="slider-icon-plus hover"></i>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_product_grid_layout6')){
    function organio_get_product_grid_layout6($posts = [], $settings = []){
        extract($settings);
        $images_size = '600x600';
        if(!empty($img_size)) {
            $images_size = $img_size;
        }
        if (is_array($posts)):
            foreach ($posts as $key => $post):
                $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
                if(isset($grid_masonry) && !empty($grid_masonry[$key]) && count($grid_masonry)) {
                    $col_xl_m = 12 / $grid_masonry[$key]['col_xl_m'];
                    $col_lg_m = 12 / $grid_masonry[$key]['col_lg_m'];
                    $col_md_m = 12 / $grid_masonry[$key]['col_md_m'];
                    $col_sm_m = 12 / $grid_masonry[$key]['col_sm_m'];
                    $col_xs_m = 12 / $grid_masonry[$key]['col_xs_m'];
                    $item_class = "grid-item col-xl-{$col_xl_m} col-lg-{$col_lg_m} col-md-{$col_md_m} col-sm-{$col_sm_m} col-{$col_xs_m}";
                    $img_size_m = $grid_masonry[$key]['img_size_m'];
                    if(!empty($img_size_m)) {
                        $images_size = $img_size_m;
                    }
                } else {
                    $images_size = $img_size;
                }
                $filter_class = ct_get_term_of_post_to_class($post->ID, array_unique($tax));
                $img_id = get_post_thumbnail_id($post->ID);
                $img = ct_get_image_by_size( array(
                    'attach_id'  => $img_id,
                    'thumb_size' => $images_size,
                    'class' => 'no-lazyload',
                ));
                $thumbnail = $img['thumbnail'];
                $line_color = get_post_meta($post->ID, 'line_color', true);
                $product = wc_get_product( $post->ID );
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner <?php echo esc_attr($ct_animate); ?>" data-wow-duration="1.2s">
                        <div class="woocommerce-product-inner" <?php if(!empty($line_color['rgba'])) : ?>style="border-color: <?php echo esc_attr($line_color['rgba']); ?>"<?php endif; ?>>
                            <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)): ?>
                                <div class="woocommerce-product-header">
                                    <a class="woocommerce-product-details" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                                    <div class="woocommerce-product-meta">
                                        <div class="woocommerce-add-to-cart">
                                            <?php
                                            echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                                sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button no-animate ajax_add_to_cart %s product_type_%s">%s</a>',
                                                    esc_url( $product->add_to_cart_url() ),
                                                    esc_attr( $product->get_id() ),
                                                    esc_attr( $product->get_sku() ),
                                                    $product->is_purchasable() ? 'add_to_cart_button' : '',
                                                    esc_attr( $product->get_type() ),
                                                    esc_html( $product->add_to_cart_text() )
                                                ),
                                                $product );
                                            ?>
                                        </div>
                                        <?php if (class_exists('WPCleverWoosc')) { ?>
                                            <div class="woocommerce-compare">
                                                <?php echo do_shortcode('[woosc id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (class_exists('WPCleverWoosw')) { ?>
                                            <div class="woocommerce-wishlist">
                                                <?php echo do_shortcode('[woosw id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                        <?php if (class_exists('WPCleverWoosq')) { ?>
                                            <div class="woocommerce-quick-view">
                                                <?php echo do_shortcode('[woosq id="'.esc_attr( $product->get_id() ).'"]'); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="woocommerce-product-content">
                               <h4 class="woocommerce-product--title">
                                    <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                                </h4>
                                <span class="price"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                                <div class="woocommerce-product--rating">
                                    <?php 
                                        $rating  = $product->get_average_rating();
                                        $count   = $product->get_rating_count();
                                        echo wc_get_rating_html( $rating, $count );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
        endif;
    }
}

if(!function_exists('organio_get_post_grid')){
    function organio_get_post_grid($posts = [], $settings = []){
        if (empty($posts) || !is_array($posts) || empty($settings) || !is_array($settings)) {
            return false;
        }
        switch ($settings['template_type']) {
            case 'post_grid_layout1':
                organio_get_post_grid_layout1($posts, $settings);
                break;

            case 'service_layout1':
                organio_get_service_layout1($posts, $settings);
                break;

            case 'portfolio_layout1':
                organio_get_portfolio_layout1($posts, $settings);
                break;

            case 'portfolio_layout2':
                organio_get_portfolio_layout2($posts, $settings);
                break;

            case 'product_grid_layout1':
                organio_get_product_grid_layout1($posts, $settings);
                break;

            case 'product_grid_layout2':
                organio_get_product_grid_layout2($posts, $settings);
                break;

            case 'product_grid_layout3':
                organio_get_product_grid_layout3($posts, $settings);
                break;

            case 'product_grid_layout4':
                organio_get_product_grid_layout4($posts, $settings);
                break;

            case 'product_grid_layout5':
                organio_get_product_grid_layout5($posts, $settings);
                break;

            case 'product_grid_layout6':
                organio_get_product_grid_layout6($posts, $settings);
                break;

            default:
                return false;
                break;
        }
    }
}

add_action( 'wp_ajax_organio_load_more_post_grid', 'organio_load_more_post_grid' );
add_action( 'wp_ajax_nopriv_organio_load_more_post_grid', 'organio_load_more_post_grid' );
if(!function_exists('organio_load_more_post_grid')){
    function organio_load_more_post_grid(){
        try{
            if(!isset($_POST['settings'])){
                throw new Exception(__('Something went wrong while requesting. Please try again!', 'organio'));
            }
            $settings = $_POST['settings'];
            set_query_var('paged', $settings['paged']);
            extract(ct_get_posts_of_grid($settings['posttype'], [
                'source' => isset($settings['source'])?$settings['source']:'',
                'orderby' => isset($settings['orderby'])?$settings['orderby']:'date',
                'order' => isset($settings['order'])?$settings['order']:'desc',
                'limit' => isset($settings['limit'])?$settings['limit']:'6',
                'post_ids' => '',
            ]));
            ob_start();
            organio_get_post_grid($posts, $settings);
            $html = ob_get_clean();
            wp_send_json(
                array(
                    'status' => true,
                    'message' => esc_attr__('Load Successfully!', 'organio'),
                    'data' => array(
                        'html' => $html,
                        'paged' => $settings['paged'],
                        'posts' => $posts,
                        'max' => $max,
                    ),
                )
            );
        }
        catch (Exception $e){
            wp_send_json(array('status' => false, 'message' => $e->getMessage()));
        }
        die;
    }
}

/**
* Display navigation to next/previous post when applicable.
*/
function organio_post_nav_default() {
    global $post;
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
    <?php
    $next_post = get_next_post();
    $previous_post = get_previous_post();

    if( !empty($next_post) || !empty($previous_post) ) { 
        ?>
        <div class="entry-navigation">
            <div class="nav-links">
                <?php if ( is_a( $previous_post , 'WP_Post' ) && get_the_title( $previous_post->ID ) != '') { 
                    $prev_img_id = get_post_thumbnail_id($previous_post->ID);
                    $prev_img_url = wp_get_attachment_image_src($prev_img_id, 'thumbnail');
                    ?>
                    <div class="nav-item nav-post-prev">
                        <a class="nav-post-label" href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><i class="caseicon-double-chevron-left"></i><?php echo esc_html__('Previous Post', 'organio'); ?></a>
                        <div class="nav-post-holder">
                            <?php if(!empty($prev_img_id)) : ?>
                                <div class="nav-post-img">
                                    <a  href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><img src="<?php echo wp_kses_post($prev_img_url[0]); ?>" /></a>
                                </div>
                            <?php endif; ?>
                            <div class="nav-post-meta">
                                <a  href="<?php echo esc_url(get_permalink( $previous_post->ID )); ?>"><?php echo get_the_title( $previous_post->ID ); ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ( is_a( $next_post , 'WP_Post' ) && get_the_title( $next_post->ID ) != '') {
                    $next_img_id = get_post_thumbnail_id($next_post->ID);
                    $next_img_url = wp_get_attachment_image_src($next_img_id, 'thumbnail');
                    ?>
                    <div class="nav-item nav-post-next">
                        <a class="nav-post-label" href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo esc_html__('Next Post', 'organio'); ?><i class="caseicon-double-chevron-right"></i></a>
                        <div class="nav-post-holder">
                            <div class="nav-post-meta">
                                <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><?php echo get_the_title( $next_post->ID ); ?></a>
                            </div>
                            <?php if(!empty($next_img_id)) : ?>
                                <div class="nav-post-img">
                                    <a href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>"><img src="<?php echo wp_kses_post($next_img_url[0]); ?>" /></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php } ?>
            </div><!-- .nav-links -->
        </div>
    <?php }
}

/**
 * Custom Widget Categories
 */
add_filter('wp_list_categories', 'organio_cat_count_span');
function organio_cat_count_span($output) {
    $dir = is_rtl() ? 'left' : 'right';
    $output = str_replace("\t", '', $output);
    $output = str_replace(")\n</li>", ')</li>', $output);
    $output = str_replace('</a> (', '<span class="count '.$dir.'">', $output);
    $output = str_replace(")</li>", "</span></a></li>", $output);
    $output = str_replace("\n<ul", "</span></a>\n<ul", $output);
    return $output;
}


/**
 * Custom Widget Archive
 */
add_filter('get_archives_link', 'organio_archive_count_span');
function organio_archive_count_span($links) {
    $dir = is_rtl() ? 'left' : 'right';
    $links = str_replace('</a>&nbsp;(', ' <span class="count '.$dir.'">', $links);
    $links = str_replace(')', '</span></a>', $links);
    return $links;
}

/**
 * Custom Widget Product Categories 
 */
add_filter('wp_list_categories', 'organio_wc_cat_count_span');
function organio_wc_cat_count_span($links) {
    $dir = is_rtl() ? 'left' : 'right';
    $links = str_replace('</a> <span class="count">(', ' <span class="count '.$dir.'">', $links);
    $links = str_replace(')</span>', '</span></a>', $links);
    return $links;
}

/* Favicon */
function organio_site_favicon(){
    
    $favicon = organio_get_opt( 'favicon' );
    
    if(!empty($favicon['url']))
        echo '<link rel="icon" type="image/png" href="'.esc_url($favicon['url']).'"/>';
}
add_action('wp_head', 'organio_site_favicon');

/**
 * Add Template Woocommerce
 */
if(class_exists('Woocommerce')){
    require_once( get_template_directory() . '/woocommerce/wc-function-hooks.php' );
}

/**
 * Show Cart Sidebar Hidden
 */
add_action('wp_ajax_nopriv_item_added', 'organio_addedtocart_sweet_message');
add_action('wp_ajax_item_added', 'organio_addedtocart_sweet_message');
function organio_addedtocart_sweet_message() {
    echo isset($_POST['id']) && $_POST['id'] > 0 ? (int) esc_attr($_POST['id']) : false;
    die();
}
add_action('wp_footer', 'organio_product_count_check');
function organio_product_count_check() {
    $cart_sidebar = organio_get_opt( 'cart_sidebar', true );
    if (class_exists('Woocommerce') && is_checkout())
        return;
    if($cart_sidebar) : ?>
        <script type="text/javascript">
            jQuery( function($) {
                if ( typeof wc_add_to_cart_params === 'undefined' )
                    return false;

                $(document.body).on( 'added_to_cart', function( event, fragments, cart_hash, $button ) {
                    var $pid = $button.data('product_id');

                    $.ajax({
                        type: 'POST',
                        url: wc_add_to_cart_params.ajax_url,
                        data: {
                            'action': 'item_added',
                            'id'    : $pid
                        },
                        success: function (response) {
                            $('.ct-widget-cart-wrap').addClass('open');
                        }
                    });
                });
            });
        </script>
    <?php endif;
}

/* Product Search */
function organio_get_product_search()
{
    if (class_exists('Woocommerce')) :
        $term = get_terms(array('taxonomy' => 'product_cat')); 
        $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
        $myaccount_page_url = '';
        $myaccount_page_url = get_permalink( $myaccount_page );
        ?>
        <div class="ct-header-product-search">
            <form action="<?php echo esc_url(home_url('/')); ?>" class="product-searchform" method="get">
                <div class="product-search-category">
                    <select name="product_cat">
                        <option value=""><?php esc_html_e('Select a Category', 'organio'); ?></option>
                        <?php
                        foreach ($term as $key => $value) {
                            echo '<option value=' . $value->slug . '>' . $value->name . '</option>';
                        } ?>
                    </select>
                </div>
                <div class="product-search-meta">
                    <input type="text" name="s" value="" placeholder="<?php esc_html_e('Search Product', 'organio'); ?>">
                    <button type="submit" class="btn btn-animate"><?php esc_html_e('Search', 'organio'); ?></button>
                    <input type="hidden" name="post_type" value="product"/>
                </div>
            </form>
        </div>
    <?php endif;
}

function organio_get_product_search_h3()
{
    if (class_exists('Woocommerce')) :
        $term = get_terms(array('taxonomy' => 'product_cat')); 
        $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
        $myaccount_page_url = '';
        $myaccount_page_url = get_permalink( $myaccount_page );
        ?>
        <div class="ct-header-product-search2">
            <form action="<?php echo esc_url(home_url('/')); ?>" class="product-searchform" method="get">
                <div class="product-search-meta">
                    <input type="text" name="s" value="" placeholder="<?php esc_html_e('Search products...', 'organio'); ?>">
                    <div class="product-search-category">
                        <select name="product_cat">
                            <option value=""><?php esc_html_e('Category', 'organio'); ?></option>
                            <?php
                            foreach ($term as $key => $value) {
                                echo '<option value=' . $value->slug . '>' . $value->name . '</option>';
                            } ?>
                        </select>
                    </div>
                    <button type="submit" class="product-search-submit"><i class="caseicon-search"></i></button>
                    <input type="hidden" name="post_type" value="product"/>
                </div>
            </form>
        </div>
    <?php endif;
}

function organio_get_product_search_h7()
{
    if (class_exists('Woocommerce')) :
        $term = get_terms(array('taxonomy' => 'product_cat')); 
        $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
        $myaccount_page_url = '';
        $myaccount_page_url = get_permalink( $myaccount_page );
        ?>
        <div class="ct-header-product-search3">
            <form action="<?php echo esc_url(home_url('/')); ?>" class="product-searchform" method="get">
                <div class="product-search-meta">
                    <div class="product-search-category">
                        <select name="product_cat">
                            <option value=""><?php esc_html_e('Select a Category', 'organio'); ?></option>
                            <?php
                            foreach ($term as $key => $value) {
                                echo '<option value=' . $value->slug . '>' . $value->name . '</option>';
                            } ?>
                        </select>
                    </div>
                    <input type="text" name="s" value="" placeholder="<?php esc_html_e('Search products...', 'organio'); ?>">
                    <button type="submit" class="product-search-submit btn btn-animate"><i class="flaticon-search"></i></button>
                    <input type="hidden" name="post_type" value="product"/>
                </div>
            </form>
        </div>
    <?php endif;
}

function organio_get_product_search_h8()
{
    if (class_exists('Woocommerce')) :
        $term = get_terms(array('taxonomy' => 'product_cat')); 
        $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
        $myaccount_page_url = '';
        $myaccount_page_url = get_permalink( $myaccount_page );
        $search_form_product = organio_get_opt( 'search_form_product', true );
        if($search_form_product) : ?>
            <div class="ct-header-product-search4">
                <form action="<?php echo esc_url(home_url('/')); ?>" class="product-searchform" method="get">
                    <div class="product-search-meta">
                        <div class="product-search-category">
                            <select name="product_cat">
                                <option value=""><?php esc_html_e('Select a Category', 'organio'); ?></option>
                                <?php
                                foreach ($term as $key => $value) {
                                    echo '<option value=' . $value->slug . '>' . $value->name . '</option>';
                                } ?>
                            </select>
                        </div>
                        <input type="text" name="s" value="" placeholder="<?php esc_html_e('Search products...', 'organio'); ?>">
                        <button type="submit" class="product-search-submit btn"><i class="flaticon-search"></i></button>
                        <input type="hidden" name="post_type" value="product"/>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    <?php endif;
}

function organio_get_product_search_h11()
{
    $search_form_product = organio_get_opt( 'search_form_product', true );
    if (class_exists('Woocommerce') && $search_form_product == true) :
        $term = get_terms(array('taxonomy' => 'product_cat')); 
        $myaccount_page = get_option( 'woocommerce_myaccount_page_id' );
        $myaccount_page_url = '';
        $myaccount_page_url = get_permalink( $myaccount_page );
        ?>
        <div class="ct-header-product-search11">
            <form action="<?php echo esc_url(home_url('/')); ?>" class="product-searchform" method="get">
                <div class="product-search-meta">
                    <input type="text" name="s" value="" placeholder="<?php esc_html_e('Search Product', 'organio'); ?>">
                    <button type="submit" class="btn btn-animate"><i class="caseicon-search"></i></button>
                    <input type="hidden" name="post_type" value="product"/>
                </div>
            </form>
        </div>
    <?php endif;
}

/**
 * Animate
*/

function organio_animate() {
    $ct_animate = array(
        '' => 'None',
        'wow bounce' => 'bounce',
        'wow flash' => 'flash',
        'wow pulse' => 'pulse',
        'wow rubberBand' => 'rubberBand',
        'wow shake' => 'shake',
        'wow swing' => 'swing',
        'wow tada' => 'tada',
        'wow wobble' => 'wobble',
        'wow bounceIn' => 'bounceIn',
        'wow bounceInDown' => 'bounceInDown',
        'wow bounceInLeft' => 'bounceInLeft',
        'wow bounceInRight' => 'bounceInRight',
        'wow bounceInUp' => 'bounceInUp',
        'wow bounceOut' => 'bounceOut',
        'wow bounceOutDown' => 'bounceOutDown',
        'wow bounceOutLeft' => 'bounceOutLeft',
        'wow bounceOutRight' => 'bounceOutRight',
        'wow bounceOutUp' => 'bounceOutUp',
        'wow fadeIn' => 'fadeIn',
        'wow fadeInDown' => 'fadeInDown',
        'wow fadeInDownBig' => 'fadeInDownBig',
        'wow fadeInLeft' => 'fadeInLeft',
        'wow fadeInLeftBig' => 'fadeInLeftBig',
        'wow fadeInRight' => 'fadeInRight',
        'wow fadeInRightBig' => 'fadeInRightBig',
        'wow fadeInUp' => 'fadeInUp',
        'wow fadeInUpBig' => 'fadeInUpBig',
        'wow fadeOut' => 'fadeOut',
        'wow fadeOutDown' => 'fadeOutDown',
        'wow fadeOutDownBig' => 'fadeOutDownBig',
        'wow fadeOutLeft' => 'fadeOutLeft',
        'wow fadeOutLeftBig' => 'fadeOutLeftBig',
        'wow fadeOutRight' => 'fadeOutRight',
        'wow fadeOutRightBig' => 'fadeOutRightBig',
        'wow fadeOutUp' => 'fadeOutUp',
        'wow fadeOutUpBig' => 'fadeOutUpBig',
        'wow flip' => 'flip',
        'wow flipInX' => 'flipInX',
        'wow flipInY' => 'flipInY',
        'wow flipOutX' => 'flipOutX',
        'wow flipOutY' => 'flipOutY',
        'wow lightSpeedIn' => 'lightSpeedIn',
        'wow lightSpeedOut' => 'lightSpeedOut',
        'wow rotateIn' => 'rotateIn',
        'wow rotateInDownLeft' => 'rotateInDownLeft',
        'wow rotateInDownRight' => 'rotateInDownRight',
        'wow rotateInUpLeft' => 'rotateInUpLeft',
        'wow rotateInUpRight' => 'rotateInUpRight',
        'wow rotateOut' => 'rotateOut',
        'wow rotateOutDownLeft' => 'rotateOutDownLeft',
        'wow rotateOutDownRight' => 'rotateOutDownRight',
        'wow rotateOutUpLeft' => 'rotateOutUpLeft',
        'wow rotateOutUpRight' => 'rotateOutUpRight',
        'wow hinge' => 'hinge',
        'wow rollIn' => 'rollIn',
        'wow rollOut' => 'rollOut',
        'wow zoomIn' => 'zoomIn',
        'wow zoomInDown' => 'zoomInDown',
        'wow zoomInLeft' => 'zoomInLeft',
        'wow zoomInRight' => 'zoomInRight',
        'wow zoomInUp' => 'zoomInUp',
        'wow zoomOut' => 'zoomOut',
        'wow zoomOutDown' => 'zoomOutDown',
        'wow zoomOutLeft' => 'zoomOutLeft',
        'wow zoomOutRight' => 'zoomOutRight',
        'wow zoomOutUp' => 'zoomOutUp',
    );
    return $ct_animate;
}

function organio_animate_case() {
    $ct_animate = array(
        '' => 'None',
        'case-fade-in-up' => 'Case Fade In Up',
        'bounce' => 'bounce',
        'flash' => 'flash',
        'pulse' => 'pulse',
        'rubberBand' => 'rubberBand',
        'shake' => 'shake',
        'swing' => 'swing',
        'tada' => 'tada',
        'wobble' => 'wobble',
        'bounceIn' => 'bounceIn',
        'bounceInDown' => 'bounceInDown',
        'bounceInLeft' => 'bounceInLeft',
        'bounceInRight' => 'bounceInRight',
        'bounceInUp' => 'bounceInUp',
        'bounceOut' => 'bounceOut',
        'bounceOutDown' => 'bounceOutDown',
        'bounceOutLeft' => 'bounceOutLeft',
        'bounceOutRight' => 'bounceOutRight',
        'bounceOutUp' => 'bounceOutUp',
        'fadeIn' => 'fadeIn',
        'fadeInDown' => 'fadeInDown',
        'fadeInDownBig' => 'fadeInDownBig',
        'fadeInLeft' => 'fadeInLeft',
        'fadeInLeftBig' => 'fadeInLeftBig',
        'fadeInRight' => 'fadeInRight',
        'fadeInRightBig' => 'fadeInRightBig',
        'fadeInUp' => 'fadeInUp',
        'fadeInUpBig' => 'fadeInUpBig',
        'fadeOut' => 'fadeOut',
        'fadeOutDown' => 'fadeOutDown',
        'fadeOutDownBig' => 'fadeOutDownBig',
        'fadeOutLeft' => 'fadeOutLeft',
        'fadeOutLeftBig' => 'fadeOutLeftBig',
        'fadeOutRight' => 'fadeOutRight',
        'fadeOutRightBig' => 'fadeOutRightBig',
        'fadeOutUp' => 'fadeOutUp',
        'fadeOutUpBig' => 'fadeOutUpBig',
        'flip' => 'flip',
        'flipInX' => 'flipInX',
        'flipInY' => 'flipInY',
        'flipOutX' => 'flipOutX',
        'flipOutY' => 'flipOutY',
        'lightSpeedIn' => 'lightSpeedIn',
        'lightSpeedOut' => 'lightSpeedOut',
        'rotateIn' => 'rotateIn',
        'rotateInDownLeft' => 'rotateInDownLeft',
        'rotateInDownRight' => 'rotateInDownRight',
        'rotateInUpLeft' => 'rotateInUpLeft',
        'rotateInUpRight' => 'rotateInUpRight',
        'rotateOut' => 'rotateOut',
        'rotateOutDownLeft' => 'rotateOutDownLeft',
        'rotateOutDownRight' => 'rotateOutDownRight',
        'rotateOutUpLeft' => 'rotateOutUpLeft',
        'rotateOutUpRight' => 'rotateOutUpRight',
        'hinge' => 'hinge',
        'rollIn' => 'rollIn',
        'rollOut' => 'rollOut',
        'zoomIn' => 'zoomIn',
        'zoomInDown' => 'zoomInDown',
        'zoomInLeft' => 'zoomInLeft',
        'zoomInRight' => 'zoomInRight',
        'zoomInUp' => 'zoomInUp',
        'zoomOut' => 'zoomOut',
        'zoomOutDown' => 'zoomOutDown',
        'zoomOutLeft' => 'zoomOutLeft',
        'zoomOutRight' => 'zoomOutRight',
        'zoomOutUp' => 'zoomOutUp',
    );
    return $ct_animate;
}

/* Addd shortcode Gallery */
if(function_exists( 'ct_register_shortcode' )) {
    function organio_gallery_shortcode( $atts = array() ) {
        extract(shortcode_atts(array(
         'link' => '#',
         'images_id' => '',
         'cols' => '2',
         'img_size' => 'full'
        ), $atts));

        ob_start();
        ?>
        <div class="ct-gallery gallery-<?php echo esc_attr($cols); ?>-columns">
        <?php
        $ct_images = explode( ',', $images_id );
        foreach ($ct_images as $key => $img_id) :
            $img = ct_get_image_by_size( array(
                'attach_id'  => $img_id,
                'thumb_size' => $img_size,
                'class'      => '',
            ));
            $thumbnail = $img['thumbnail'];
            ?>
            <div class="ct-gallery-item">
                <?php echo ct_print_html($thumbnail); ?>
                <?php if($key == 0) : ?>
                    <a href="<?php echo esc_url($link); ?>" class="btn-video"><i class="fa fa-play"></i></a>
                <?php endif; ?>
            </div>
            <?php
        endforeach;
        ?>
        </div>
        <?php
        $output = ob_get_clean();

        return $output;
    }
    ct_register_shortcode('ct_gallery', 'organio_gallery_shortcode');
}


/* Addd shortcode Video button */
if(function_exists( 'ct_register_shortcode' )) {
    function organio_video_button_shortcode( $atts = array() ) {
        extract(shortcode_atts(array(
         'btn_link' => 'https://www.youtube.com/watch?v=SF4aHwxHtZ0',
         'btn_text' => '',
         'btn_style' => 'slider-style1',
        ), $atts));

        ob_start();
        ?>
        <div class="slider-video-button">
            <a href="<?php echo esc_url($btn_link); ?>" class="slider-video <?php echo esc_attr($btn_style); ?>">
                <i class="fa fa-play"></i>
                <span class="line-video-animation line-video-1"></span>
                <span class="line-video-animation line-video-2"></span>
                <span class="line-video-animation line-video-3"></span>
            </a>
            <?php if(!empty($btn_text)) : ?>
                <span class="slider-video-title"><?php echo esc_attr($btn_text); ?></span>
            <?php endif; ?>
        </div>
        <?php
        $output = ob_get_clean();

        return $output;
    }
    ct_register_shortcode('ct_video_button', 'organio_video_button_shortcode');
}

/* User Login/Register */
function organio_user_form() {
    $user_icon = organio_get_opt( 'user_icon', false );
    if(function_exists('up_get_template_part') && $user_icon && !is_user_logged_in()) : ?>
        <div class="ct-modal ct-user-popup">
            <div class="ct-modal-close"><i class="ct-icon-close"></i></div>
            <div class="ct-modal-content">
                <div class="ct-user ct-user-register u-close">
                    <div class="ct-user-content">
                        <h3 class="ct-user-heading"><?php echo esc_html__('Create your account', 'organio'); ?></h3>
                        <?php echo do_shortcode('[ct-user-form form_type="register"]'); ?>
                        <div class="ct-user-footer">
                            <a href="javascript:void(0)" class="btn-sign-in"> <?php esc_html_e('Sign In', 'organio');?></a>
                        </div>
                    </div>
                    
                </div>
                <div class="ct-user ct-user-login">
                    <div class="ct-user-content">
                        <h3 class="ct-user-heading"><?php echo esc_html__('Log in to Your Account', 'organio'); ?></h3>
                        <?php echo do_shortcode('[ct-user-form form_type="login" is_logged="profile"]'); ?>  
                        <div class="ct-user-footer">
                            <a href="javascript:void(0)" class="btn-sign-up"> <?php esc_html_e('Sign Up', 'organio');?></a>
                        </div>
                        <?php if(class_exists('Woocommerce')) : 
                            $my_ac = get_option( 'woocommerce_myaccount_page_id' ); 
                            $lost_password = get_option( 'woocommerce_myaccount_lost_password_endpoint' );
                            ?>
                            <div class="ct-user-forgot-pass"><a href="<?php echo esc_url(get_permalink($my_ac)); ?><?php echo esc_attr($lost_password); ?>"><?php esc_html_e('Forgot your password?', 'organio');?></a></div>
                        <?php endif; ?>
                    </div>
                </div> 
            </div>
        </div>
    <?php endif;
}

/**
 * Demo Bar
 */
function organio_demo_bar() { ?>
    <div class="ct-demo-bar">
        <div class="ct-demo-option">
            <a class="choose-demo" href="javascript:;">
                <span>Choose Theme Styling</span>
                <i class="far fac-cog"></i>
            </a>
            <a href="https://casethemes.ticksy.com/submit/" target="_blank">
                <span>Submit a Ticket</span>
                <i class="far fac-life-ring"></i>
            </a>
            <a href="https://themeforest.net/cart/add_items?ref=case-themes&item_ids=26053893" target="_blank">
                <span>Purchase Theme</span>
                <i class="far fac-shopping-cart"></i>
            </a>
        </div>
        <div class="ct-demo-bar-inner">
            <div class="ct-demo-bar-meta">
                <h4>Pre-Built Demos Collection</h4>
                <p>Organio comes with a beautiful collection of modern, easily importable, and highly customizable demo layouts. Any of which can be installed via one click.</p>
            </div>
            <div class="ct-demo-bar-list">
                <div class="ct-demo-bar-item">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/home-demo/demo1.jpg'); ?>" alt="Demo" />
                    <div class="ct-demo-bar-holder">
                        <h6>Demo 01</h6>
                        <a class="btn btn-default" href="http://demo.casethemes.net/organio" target="_blank">View Demo</a>
                    </div>
                </div>
                <div class="ct-demo-bar-item">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/home-demo/demo2.jpg'); ?>" alt="Demo" />
                    <div class="ct-demo-bar-holder">
                        <h6>Demo 02</h6>
                        <a class="btn btn-default" href="http://demo.casethemes.net/organio/home-4/" target="_blank">View Demo</a>
                    </div>
                </div>
                <div class="ct-demo-bar-item">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/home-demo/demo3.jpg'); ?>" alt="Demo" />
                    <div class="ct-demo-bar-holder">
                        <h6>Demo 03</h6>
                        <a class="btn btn-default" href="http://demo.casethemes.net/organio/home-2/" target="_blank">View Demo</a>
                    </div>
                </div>
                <div class="ct-demo-bar-item">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/home-demo/demo4.jpg'); ?>" alt="Demo" />
                    <div class="ct-demo-bar-holder">
                        <h6>Demo 04</h6>
                        <a class="btn btn-default" href="http://demo.casethemes.net/organio/home-3/" target="_blank">View Demo</a>
                    </div>
                </div>
                <div class="ct-demo-bar-item">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/home-demo/demo5.jpg'); ?>" alt="Demo" />
                    <div class="ct-demo-bar-holder">
                        <h6>Demo 05</h6>
                        <a class="btn btn-default" href="http://demo.casethemes.net/organio/home-5/" target="_blank">View Demo</a>
                    </div>
                </div>
                <div class="ct-demo-bar-item">
                    <img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/home-demo/demo6.jpg'); ?>" alt="Demo" />
                    <div class="ct-demo-bar-holder">
                        <h6>Demo 06</h6>
                        <a class="btn btn-default" href="http://demo.casethemes.net/organio/home-6/" target="_blank">View Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }

/* Post Type Support */
function organio_add_cpt_support() {
    $cpt_support = get_option( 'elementor_cpt_support' );
    
    if( ! $cpt_support ) {
        $cpt_support = [ 'page', 'post', 'portfolio', 'service', 'footer', 'ct-mega-menu' ];
        update_option( 'elementor_cpt_support', $cpt_support );
    }
    
    else if( ! in_array( 'portfolio', $cpt_support ) ) {
        $cpt_support[] = 'portfolio';
        update_option( 'elementor_cpt_support', $cpt_support );
    }

    else if( ! in_array( 'service', $cpt_support ) ) {
        $cpt_support[] = 'service';
        update_option( 'elementor_cpt_support', $cpt_support );
    }

    else if( ! in_array( 'footer', $cpt_support ) ) {
        $cpt_support[] = 'footer';
        update_option( 'elementor_cpt_support', $cpt_support );
    }

    else if( ! in_array( 'ct-mega-menu', $cpt_support ) ) {
        $cpt_support[] = 'ct-mega-menu';
        update_option( 'elementor_cpt_support', $cpt_support );
    }
}
add_action( 'after_switch_theme', 'organio_add_cpt_support');

/* Custom Archive Post Type Link */
function organio_custom_archive_service_link() {
    if( is_post_type_archive( 'service' ) ) {
        $archive_service_link = organio_get_opt( 'archive_service_link' );
        wp_redirect( get_permalink($archive_service_link), 301 );
        exit();
    }
}
add_action( 'template_redirect', 'organio_custom_archive_service_link' );

function organio_custom_archive_portfolio_link() {
    if( is_post_type_archive( 'portfolio' ) ) {
        $archive_portfolio_link = organio_get_opt( 'archive_portfolio_link' );
        wp_redirect( get_permalink($archive_portfolio_link), 301 );
        exit();
    }
}
add_action( 'template_redirect', 'organio_custom_archive_portfolio_link' );


/* Addd shortcode Year */
if(function_exists( 'ct_register_shortcode' )) {
    function organio_year() { 
        ob_start(); ?>
        <span class="ct-year"><?php echo esc_attr(date("Y")); ?></span>
        <?php
        $output = ob_get_clean();

        return $output;
    }
    ct_register_shortcode('ct_year', 'organio_year');
}

/* Mouse Move Animation */
function organio_mouse_move_animation() { 
    $mouse_move_animation = organio_get_opt( 'mouse_move_animation', false );
    if($mouse_move_animation) {
        wp_enqueue_script( 'organio-cursor', get_template_directory_uri() . '/assets/js/cursor.js', array( 'jquery' ), '1.0.0', true ); ?>  
        <div class="ct-cursor ct-js-cursor">
            <div class="ct-cursor-wrapper">
                <div class="ct-cursor--follower ct-js-follower"></div>
                <div class="ct-cursor--label ct-js-label"></div>
                <div class="ct-cursor--icon ct-js-icon"></div>
            </div>
        </div>
    <?php }
}