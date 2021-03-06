<?php
$options           = thrive_get_theme_options();
$sidebar_is_active = _thrive_is_active_sidebar( $options );
?>
<?php get_header(); ?>

<div class="<?php echo _thrive_get_main_wrapper_class( $options ); ?>">

	<?php if ( $options['sidebar_alignement'] == "left" && $sidebar_is_active ): ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>
	<?php if ( $options['blog_layout'] == "masonry_full_width" || $options['blog_layout'] == "masonry_sidebar" ): ?>
		<div class="cata">
			<h5><?php _e( "Archive", 'thrive' ); ?></h5>
		</div>
	<?php endif ?>
	<?php if ( _thrive_is_active_sidebar( $options ) ): ?>
	<div class="bSeCont"><?php endif; ?>
		<section class="<?php echo _thrive_get_main_section_class( $options ); ?>">
			<?php if ( $options['blog_layout'] != "masonry_full_width" && $options['blog_layout'] != "masonry_sidebar" ): ?>
				<div class="cata">
					<h5><?php _e( "Archive", 'thrive' ); ?></h5>
				</div>
			<?php endif ?>
			<?php if ( $options['blog_layout'] == "masonry_full_width" || $options['blog_layout'] == "masonry_sidebar" ): ?>
				<div class="mry-g"></div>
			<?php endif; ?>
			<?php if ( have_posts() ): ?>
				<?php while ( have_posts() ): ?>
					<?php the_post(); ?>
					<?php get_template_part( 'content', _thrive_get_post_content_template( $options ) ); ?>
				<?php endwhile; ?>
				<?php if ( _thrive_check_focus_area_for_pages( "archive", "bottom" ) ): ?>
					<?php if ( strpos( $options['blog_layout'], 'masonry' ) === false && strpos( $options['blog_layout'], 'grid' ) === false ): ?>
						<?php thrive_render_top_focus_area( "bottom", "archive" ); ?>
						<div class="spr"></div>
					<?php endif; ?>
				<?php endif; ?>

			<?php else: ?>
				<!--No contents-->
			<?php endif ?>
		</section>

		<?php if ( _thrive_is_active_sidebar( $options ) ): ?></div><?php endif; ?>
	<?php if ( $options['sidebar_alignement'] == "right" && $sidebar_is_active ): ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>
</div>
<?php get_footer(); ?>
