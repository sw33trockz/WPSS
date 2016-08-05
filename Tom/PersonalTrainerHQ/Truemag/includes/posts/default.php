<?php
/*

	This is standard template for archives.
	Post formats compatible.

*/
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('post-template post-default'); ?>>


	<?php

		global
			$st_Options;

			// More tag
			$more = 0;

			// Title
			if ( !empty($st_['title_disabled']) != 1 ) {
				echo '<h3 class="post-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>'; }

			// Meta
			st_post_meta();

			// Post format
			$st_['format'] = ( get_post_format( $post->ID ) && $st_Options['global']['post-formats'][get_post_format( $post->ID )]['status'] && function_exists( 'st_kit' ) ) ? get_post_format( $post->ID ) : 'standard';

			include( locate_template( '/includes/posts/formats/' . $st_['format'] . '.php' ) );

			// Content
			echo '<div class="post-format-' . $st_['format'] . '-content content-data">'; the_content(); echo '</div><div class="clear"><!-- --></div>';
	
			// Pagination
			if ( wp_link_pages( 'echo=0' ) ) {

				echo '<div class="page-pagination">';

					if ( function_exists('wp_pagenavi') ) {
						?><div id="wp-pagenavibox"><?php wp_pagenavi( array( 'type' => 'multipart' ) ); ?></div><?php } 

					else {
						wp_link_pages( array( 'before' => '<span>' . __( 'Pages', 'strictthemes' ) . ':</span> ' ) ); }

				echo '</div>';

			}

	?>

	<div class="clear"><!-- --></div>

</div><!-- .post-template -->