<?php $meta_bar_position = herald_get_single_meta_bar_position(); ?>

<?php if( $meta_bar_position != 'none') : ?>

	<div class="col-lg-2 col-md-2 col-sm-2 hidden-xs <?php echo esc_attr( 'herald-'.$meta_bar_position); ?>">

		<div class="entry-meta-wrapper">

		<?php if(herald_get_option('single_avatar')): ?>
			<div class="entry-meta-author">	
				<?php echo get_avatar( get_the_author_meta('ID'), 112 ); ?>
				
				<a class="herald-author-name" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author_meta('display_name') ?></a>

				<?php if( $twitter_url = get_the_author_meta('twitter') ) : ?>
					<a class="herald-author-twitter" href="<?php echo esc_url( $twitter_url ); ?>"><?php echo basename($twitter_url); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if( $meta = herald_get_meta_data( 'single_big' ) ) : ?>
			<div class="entry-meta"><?php echo $meta; ?></div>
		<?php endif; ?>

		<?php if( herald_get_option('single_share') ): ?>
			<?php get_template_part('template-parts/single/share'); ?>
		<?php endif; ?>

		</div>

	</div>

<?php endif; ?>