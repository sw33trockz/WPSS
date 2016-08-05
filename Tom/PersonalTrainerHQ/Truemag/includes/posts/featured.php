<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - FEATURED POSTS

*/



/*===============================================

	F E A T U R E D   P O S T S
	Sticky posts

===============================================*/

	global
		$st_Settings;

		$st_['is_featured'] = false;
		$st_['is_others'] = false;
		$st_['sticky_posts'] = array_filter( get_option('sticky_posts') );


		// If no one sticky post
		if ( empty( $st_['sticky_posts'] ) ) {
			return; }


		// If frontpage
		if ( is_front_page() && !empty( $st_Settings['sticky_on_frontpage'] ) == 'yes' ) {
			$st_['is_featured'] = true; }


		// If archives
		if (
			is_category() && !empty( $st_Settings['sticky_on_archives'] ) == 'yes' ||
			is_tag() && !empty( $st_Settings['sticky_on_archives'] ) == 'yes' ||
			get_query_var('post_format') && !empty( $st_Settings['sticky_on_archives'] ) == 'yes'
			) {

				$st_['is_featured'] = true;
				$st_['object'] = get_queried_object();

				// Unique args
				$st_['args'] = array(
					'post__in'				=> $st_['sticky_posts'],
					'posts_per_page'		=> 4,
					'order'					=> 'DESC',
					'orderby'				=> 'date',
					'paged'					=> 1,
					'post_status'			=> 'publish',
					'ignore_sticky_posts'	=> 1,
					'tax_query'				=> array(
													array(
														'taxonomy'	=> $st_['object']->taxonomy,
														'field'		=> 'term_id',
														'terms'		=> $st_['object']->term_id
													)
												)
				);

			}


		// If single
		if ( is_single() && !empty( $st_Settings['sticky_on_single'] ) == 'yes' || is_single() && !empty( $st_Settings['sticky_on_single'] ) == 'yes' && function_exists('is_bbpress') && !is_bbpress() ) {
			$st_['is_featured'] = true; }


		// If others
		if ( !is_front_page() && !is_category() && !is_tag() && !is_single() && !get_query_var('post_format') ) {
			$st_['is_others'] = true; }

		if ( $st_['is_others'] && !empty( $st_Settings['sticky_on_others'] ) == 'yes' ) {
			$st_['is_featured'] = true; }


		// Continue or not?
		if ( $st_['is_featured'] == false ) {
			return; }

		// Default args
		if ( empty( $st_['object'] ) ) {

				$st_['args'] = array(
					'post__in'				=> $st_['sticky_posts'],
					'posts_per_page'		=> 4,
					'order'					=> 'DESC',
					'orderby'				=> 'date',
					'paged'					=> 1,
					'post_status'			=> 'publish',
					'ignore_sticky_posts'	=> 1
				);

		}

		$st_['postcount'] = 0;
		$st_['feat_type'] = !empty( $st_['object'] ) ? $st_['object']->taxonomy . '_' . $st_['object']->term_id : 'recent';


		$st_['temp'] = !empty( $st_query_feat ) ? $st_query_feat : '';
		$st_query_feat = null;


		if ( !empty( $st_Settings['sticky_cache'] ) ) {
			$st_query_feat = get_transient( 'st_sticky_posts_' . $st_['feat_type'] ); }


		if ( $st_query_feat == false ) {

			$st_query_feat = new WP_Query( $st_['args'] );
			wp_reset_postdata();

			set_transient( 'st_sticky_posts_' . $st_['feat_type'], $st_query_feat, 60 * 60 * 12 );

		}

		if ( $st_query_feat->found_posts > 3 ) {

	
			while ( $st_query_feat->have_posts() ) : $st_query_feat->the_post();		
		
				// Post format
				$st_['format'] = get_post_format( $post->ID ) ? get_post_format( $post->ID ) : 'standard';
		
			
				$st_['postcount']++;
			
				// Post's class
				$st_['class'] = '';
				if ( $st_['postcount'] == 1 ) { $st_['class'] = 'first'; }
				if ( $st_['postcount'] == 4 ) { $st_['class'] = 'last'; $st_['postcount'] = 0; }
			
			
				// Feat image
				if ( has_post_thumbnail() ) {
			
					$st_['id'] = get_post_thumbnail_id( $post->ID );
					$st_['thumb'] = wp_get_attachment_image_src( $st_['id'], 'project-thumb' );
					$st_['thumb'] = $st_['thumb'][0];
			
				}
			
				else {
			
					$st_['thumb'] = get_template_directory_uri() . '/assets/images/placeholder.png';
			
				}
			
			
				// Compose post
				echo '<div class="posts-featured-wrapper ' . $st_['class'] . '">';
			
			
					// Compose thumb
					echo '<a href="' . get_permalink() . '" class="post-thumb post-thumb-' . $st_['format'] . '" ' . ( function_exists( 'st_get_2x' ) ? st_get_2x( $post->ID, 'project-thumb', 'attr' ) : '' ) . ' style="background-image: url(' . $st_['thumb'] . ')" data-format="' . $st_['format'] . '"><div><h3>' . get_the_title() . '</h3></div></a>';
			
			
					// Other
					echo '<div class="posts-featured-details-wrapper">';
			
						st_post_meta( false, false, false, 'number', false, true, __( 'More', 'strictthemes' ) );
			
					echo '</div>';
		
			
				echo '</div>' . "\n";
		
		
			endwhile;


		}


		wp_reset_query();


?>