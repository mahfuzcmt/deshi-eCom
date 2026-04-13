<?php
/**
 * Template part for displaying posts in loop
 *
 * @package Organio
 */
$post_tags_on = organio_get_opt( 'post_tags_on', true );
$post_navigation_on = organio_get_opt( 'post_navigation_on', false );
$post_social_share_on = organio_get_opt( 'post_social_share_on', false );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('single-hentry'); ?>>
    <div class="entry-blog">
        <?php if (has_post_thumbnail()) {
            echo '<div class="entry-featured">'; ?>
                <?php the_post_thumbnail('organio-post'); ?>
            <?php echo '</div>';
        } ?>
        <div class="entry-body">

            <?php organio_post_meta(); ?>

            <div class="entry-content clearfix">
                <?php
                    the_content();
                    wp_link_pages( array(
                        'before'      => '<div class="page-links">',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                    ) );
                ?>
            </div>

        </div>
    </div>
    <?php if($post_tags_on || $post_social_share_on ) :  ?>
        <div class="entry-footer">
            <?php if($post_tags_on) { organio_entry_tagged_in(); } ?>
            <?php if($post_social_share_on) { organio_socials_share_default(); } ?>
        </div>
    <?php endif; ?>

    <?php if($post_navigation_on) { organio_post_nav_default(); } ?>
</article><!-- #post -->