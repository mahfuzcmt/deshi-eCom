<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 *
 * @package Organio
 */ 
$back_totop_on = organio_get_opt('back_totop_on', true);
?>
	</div><!-- #content inner -->
</div><!-- #content -->

<?php organio_footer(); ?>
<?php if (isset($back_totop_on) && $back_totop_on) : ?>
    <a href="#" class="scroll-top"><i class="caseicon-long-arrow-right-three"></i></a>
<?php endif; ?>

</div><!-- #page -->
<?php organio_search_popup(); ?>
<?php organio_sidebar_hidden(); ?>
<?php organio_cart_sidebar(); ?>
<?php organio_user_form(); ?>
<?php organio_mouse_move_animation(); ?>
<?php wp_footer(); ?>

</body>
</html>
