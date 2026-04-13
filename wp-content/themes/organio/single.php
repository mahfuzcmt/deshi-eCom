<?php
/**
 * The template for displaying all single posts
 *
 * @package Organio
 */
get_header();
$sidebar_pos = organio_get_opt( 'post_sidebar_pos', 'right' );
$show_sidebar_post = organio_get_page_opt( 'show_sidebar_post', false );
if ($show_sidebar_post){
    $sidebar_pos = organio_get_page_opt( 'sidebar_post_pos' );
}
?>
<div class="container content-container">
    <div class="row content-row">
        <div id="primary" <?php organio_primary_class( $sidebar_pos, 'content-area' ); ?>>
            <main id="main" class="site-main">
                <?php

                    while ( have_posts() )
                    {
                        the_post();
                        get_template_part( 'template-parts/content-single/content', get_post_format() );
                        if ( comments_open() || get_comments_number() )
                        {
                            comments_template();
                        }
                    }
                    
                ?>
            </main><!-- #main -->
        </div><!-- #primary -->

        <?php if ( 'left' == $sidebar_pos && is_active_sidebar( 'sidebar-blog' ) || 'right' == $sidebar_pos && is_active_sidebar( 'sidebar-blog' ) ) : ?>
            <aside id="secondary" <?php organio_secondary_class( $sidebar_pos, 'widget-area' ); ?>>
                <div class="sidebar-sticky">
                    <?php get_sidebar(); ?>
                </div>
            </aside>
        <?php endif; ?>
    </div>
</div>
<?php
organio_set_post_views(get_the_ID());
get_footer();
