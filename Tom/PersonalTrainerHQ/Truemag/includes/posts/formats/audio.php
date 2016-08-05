<?php if ( !defined( 'ABSPATH' ) ) exit;
/*

	Post format: Audio

*/

	/*--- After title data -----------------------------*/

	if ( is_single() && !empty( $st_Settings['after_title'] ) && $st_Settings['after_title'] == 'yes' ) {
		echo '<div id="title-after">' . do_shortcode( $st_Settings['after_title_data'] ) . '</div><div class="clear"><!-- --></div>'; }


	/*--- Excerpt -----------------------------*/

	if ( is_single() && !empty( $st_Settings['excerpt'] ) && $st_Settings['excerpt'] == 'yes' && $post->post_excerpt ) {
		echo '<div class="clear"><!-- --></div><div id="post-excerpt">' . wpautop( $post->post_excerpt ) . '</div>'; } ?>


	<div class="st-format-audio-holder"><?php

		/*===============================================
		
			F E A T U R E D   I M A G E
			With different sizes dipends of many reasons
		
		===============================================*/

			if ( has_post_thumbnail() ) {
		
				/*-------------------------------------------
					on Post page:
					- sidebar(+), modal window(+)
					- sidebar(+), modal window(-)
					- sidebar(-), modal window(+)
					- sidebar(-), modal window(-)
				-------------------------------------------*/
		
				if ( is_single() ) {
			
					if ( !empty( $st_Settings['post_feat_image'] ) == 'yes' ) {
			
						// if sidebar (+)
						if ( !$st_['sidebar_position'] || $st_['sidebar_position'] && $st_['sidebar_position'] != 'none' ) {
		
							$st_['feat_img'] = get_the_post_thumbnail( $post->ID, 'post-image', ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'post-image', 'array', 'size-original featured-image' ) : '' ) );
			
						}
			
						// if sidebar (-)
						else {
		
							$st_['feat_img'] = get_the_post_thumbnail( $post->ID, 'large', ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'large', 'array', 'size-original featured-image' ) : '' ) );
		
						}
		
						// if modal window (+)
						if ( st_get_post_meta( $post->ID, 'lightbox_value', true, '' ) ) {
				
							$st_['large_image_url'] = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
			
							echo '<a href="' . $st_['large_image_url'][0] . '" title="' . the_title_attribute( 'echo=0' ) . '" >' . $st_['feat_img'] . '</a>';
				
						}
			
						// if modal window (-)
						else {
				
							echo $st_['feat_img'];
				
						}
			
					}
			
				}
			
				/*-------------------------------------------
					on Arhive page:
					- blog page, sidebar(+)
					- blog page, sidebar(-)
					- archive
				-------------------------------------------*/
			
				else {
		
					// if blog
					if ( !empty( $st_['is_blog'] ) ) {
			
						// if sidebar (+)
						if ( $st_['secondary_sidebar'] == true ) {
		
							echo '<a href="' . get_permalink( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'project-medium', ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'project-medium', 'array', 'size-original featured-image' ) : '' ) ) . '</a>';
		
						}
			
						// if sidebar (-)
						else {
		
							echo '<a href="' . get_permalink( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'archive-image', ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'archive-image', 'array', 'size-original featured-image' ) : '' ) ) . '</a>';
		
						}
			
					}
			
					// if archive
					else {
		
						echo '<a href="' . get_permalink( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'archive-image', ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'archive-image', 'array', 'size-original featured-image' ) : '' ) ) . '</a>';
		
					}
		
				}
		
			}


		/*===============================================
		
			A U D I O
			Post Format
		
		===============================================*/
	
			$st_['mp3'] = st_get_post_meta( $post->ID, 'mp3_value', true, '' ) ? ' mp3="' . st_get_post_meta( $post->ID, 'mp3_value', true, '' ) . '"' : '';
			$st_['ogg'] = st_get_post_meta( $post->ID, 'ogg_value', true, '' ) ? ' ogg="' . st_get_post_meta( $post->ID, 'ogg_value', true, '' ) . '"' : '';
			$st_['audio'] = st_get_post_meta( $post->ID, 'audio_value', true, '' );
	
	
			/*--- Audio -----------------------------*/
		
			if ( $st_['audio'] ) {
				echo $st_['audio']; }
	
			elseif ( $st_['mp3'] || $st_['ogg'] ) {
				echo do_shortcode('[audio' . $st_['mp3'] . $st_['ogg'] . ' preload=none]'); }


		?>
	
	</div>