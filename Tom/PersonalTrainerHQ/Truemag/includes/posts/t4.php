<?php if ( !defined( 'ABSPATH' ) ) exit;
/*

	Post formats compatible.

*/

	// Define classes
	$st_['class'] = has_post_thumbnail() ? 'post-template post-t4' : 'post-template post-t4 post-t4-no-thumb';

	$st_['class'] .= $st_['count'] == 1 ? ' odd' : ' even';

?>
<div class="<?php echo $st_['class']; ?>">

	<?php

		global
			$st_Options,
			$st_Settings;

			// Post format
			$st_['format'] = ( get_post_format( $post->ID ) && $st_Options['global']['post-formats'][get_post_format( $post->ID )]['status'] && function_exists( 'st_kit' ) ) ? get_post_format( $post->ID ) : 'standard';

			// Is title disabled?
			$st_['title_disabled'] = st_get_post_meta( $post->ID, 'disable_title_value', true, 0 );

	
			if ( has_post_thumbnail() ) {
	
				$st_['id'] = get_post_thumbnail_id( $post->ID );
				$st_['thumb'] = wp_get_attachment_image_src( $st_['id'], 'project-thumb' );
				$st_['thumb'] = $st_['thumb'][0];

				echo '<div class="thumb-wrapper">';
					echo '<a href="' . get_permalink() . '" class="post-thumb post-thumb-' . $st_['format'] . '" ' . ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'project-thumb', 'attr' ) : '' ) . ' style="background-image: url(' . $st_['thumb'] . ')" data-format="' . $st_['format'] . '">&nbsp;</a>';
				echo '</div>' . "\n";
		
			}
	
			echo '<div>';
	

				// Meta
				if ( !empty( $st_Settings['post_meta'] ) && $st_Settings['post_meta'] == 'yes' ) {
					st_post_meta( false, true, false, 'number', false, true, false ); }
	
				// Title
				if ( !empty($st_['title_disabled']) != 1 ) {
					echo '<h3 class="post-title' . ( has_excerpt() ? ' post-title-short' : '' ) . '"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>'; }

				// Excerpt
				if ( has_excerpt() ) {
					echo '<p>' . get_the_excerpt() . '</p>'; }


			echo '</div>';

	?>

	<div class="clear"><!-- --></div>

</div><!-- .post-template -->