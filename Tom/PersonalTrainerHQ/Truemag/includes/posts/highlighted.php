<?php if ( !defined( 'ABSPATH' ) ) exit;

	echo "\n";

	// Post format
	$st_['format'] = get_post_format( $post->ID ) ? get_post_format( $post->ID ) : 'standard';


	/*-------------------------------------------
		POST A
	-------------------------------------------*/

	echo '<div class="post-template posts-highlighted">';


		// Feat image
		if ( $st_['format'] == 'standard' ) {

			if ( has_post_thumbnail() ) {

				$st_['id'] = get_post_thumbnail_id( $post->ID );
				$st_['thumb'] = wp_get_attachment_image_src( $st_['id'], $st_['secondary_sidebar'] ? 'project-medium' : 'archive-image' );
				$st_['thumb'] = $st_['thumb'][0];

				// Compose thumb
				echo '<a href="' . get_permalink() . '" class="post-thumb" ' . ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, $st_['secondary_sidebar'] ? 'project-medium' : 'archive-image', 'attr' ) : '' ) . ' style="background-image: url(' . $st_['thumb'] . ')" data-format="' . $st_['format'] . '">&nbsp;</a>';

			}
	
		}


		// Format
		if ( $st_['format'] != 'standard' ) {
			include( locate_template( '/includes/posts/formats/' . $st_['format'] . '.php' ) ); }


		// Other
		echo '<div class="posts-highlighted-details"><div>' .

			( get_the_title() ? '<h1><a href="' . get_permalink() . '">' . get_the_title() . '</a></h1>' : '' ) .

			wpautop( do_shortcode( get_the_excerpt() ) );

			st_post_meta( true, true, true, 'number', false, true, false );

		echo '</div></div>';

	echo '</div>' . "\n";



?>