<?php if ( !defined( 'ABSPATH' ) ) exit;
/*

	Post format: Quote

*/

	/*--- After title data -----------------------------*/

	if ( is_single() && !empty( $st_Settings['after_title'] ) && $st_Settings['after_title'] == 'yes' ) {
		echo '<div id="title-after">' . do_shortcode( $st_Settings['after_title_data'] ) . '</div><div class="clear"><!-- --></div>'; }


	/*--- Excerpt -----------------------------*/

	if ( is_single() && !empty( $st_Settings['excerpt'] ) && $st_Settings['excerpt'] == 'yes' && $post->post_excerpt ) {
		echo '<div class="clear"><!-- --></div><div id="post-excerpt">' . wpautop( $post->post_excerpt ) . '</div>'; } ?>


	<div class="st-format-quote-holder"><?php

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
						if ( !$st_['sidebar_position'] || $st_['sidebar_position'] && $st_['sidebar_position'] != 'none' ) {
		
							echo '<a href="' . get_permalink( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'archive-image', ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'archive-image', 'array', 'size-original featured-image' ) : '' ) ) . '</a>';
		
						}
			
						// if sidebar (-)
						else {
		
							echo '<a href="' . get_permalink( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'large', ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'large', 'array', 'size-original featured-image' ) : '' ) ) . '</a>';
		
						}
			
					}
			
					// if archive
					else {
		
						echo '<a href="' . get_permalink( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, 'archive-image', ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'archive-image', 'array', 'size-original featured-image' ) : '' ) ) . '</a>';
		
					}
		
				}
		
			}
	
	
		/*===============================================
		
			Q U O T E
			Post Format
		
		===============================================*/
		
			$st_['quote'] = st_get_post_meta( $post->ID, 'quote_value', true, '' );
		
			if ( $st_['quote'] ) {
				echo '<div><blockquote><p>' . $st_['quote'] . '</p></blockquote></div>'; }

		?>
	
	</div>