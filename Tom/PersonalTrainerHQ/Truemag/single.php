<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - RETRIEVE DATA

		- Set views
		- Get post type names
		- Get post format
		- Is title disabled?
		- Is breadcrumbs disabled?
		- Get custom sidebar
		- Get sidebar position

	2 - POST

		2.1 - Breadcrumbs
		2.2 - Article
			- Title
			- After title data
			- Excerpt
			- Featured image
			- Before post data
			- Content
		2.3 - Pagination
		2.4 - Prev/Next post
		2.5 - Related posts
		2.6 - Comments
		2.7 - Post meta
			- Author info
			- Post short info
		2.8 - Post sidebar
		2.9 - Sidebar

*/

/*===============================================

	R E T R I E V E   D A T A
	Get a required post data

===============================================*/

	global
		$st_Options,
		$st_Settings;
	
		$st_ = array();

		// Post format
		$st_['format'] = get_post_format( $post->ID ) ? get_post_format( $post->ID ) : 'standard';

		// Is title disabled?
		$st_['title_disabled'] = st_get_post_meta( $post->ID, 'disable_title_value', true, 0 );
	
		// Is breadcrumbs disabled?
		$st_['breadcrumbs_disabled'] = st_get_post_meta( $post->ID, 'disable_breadcrumbs_value', true, 0 );
	
		// Get custom sidebar
		$st_['sidebar'] = st_get_post_meta( $post->ID, 'sidebar_value', true, 'Default Sidebar' );
	
		// Get sidebar position
		$st_['sidebar_position'] = st_get_post_meta( $post->ID, 'sidebar_position_value', true, 'right' );

			// Re-define global $content_width if sidebar not exists
			if ( $st_['sidebar_position'] == 'none' ) {
				$content_width = $st_Options['global']['images']['large']['width']; }
			else {
				$content_width = $st_Options['global']['images']['post-image']['width']; }

/*===============================================

	P O S T
	Display a required post

===============================================*/

	get_header();

		?>

			<div id="content-holder" class="sidebar-position-<?php echo $st_['sidebar_position']; ?>">

				<div id="content-box">
		
					<div>
		
						<?php
	
							if ( have_posts() ) :


								while ( have_posts() ) : the_post();

									?>



										<div id="post-<?php the_ID(); ?>" <?php post_class( 'post-single' ) ?>>

											<?php



												/*-------------------------------------------
													2.1 - Breadcrumbs
												-------------------------------------------*/

												if ( $st_['breadcrumbs_disabled'] != 1 && !is_front_page() && function_exists( 'st_breadcrumbs' ) ) {
													st_breadcrumbs(); }


												/*-------------------------------------------
													2.2 - Title
												-------------------------------------------*/
												if ( !empty( $st_['title_disabled'] ) != 1 && get_the_title() ) { ?>

													<h1 class="entry-title post-title"><?php
											
														the_title();
											
														$st_['subtitle'] = get_post_meta( $post->ID, 'subtitle_value', true );
											
														if ( $st_['subtitle'] ) {
															echo '<span class="title-end">.</span> <span class="title-sub">' . $st_['subtitle'] . '<span class="title-end">.</span></span>'; } ?>
											
													</h1><?php

												}


												/*-------------------------------------------
													2.2 - Article
												-------------------------------------------*/ ?>

												<article>

													<?php

														// Post format
														include( locate_template( '/includes/posts/formats/' . $st_['format'] . '.php' ) );

														// Before post data
														if ( !empty( $st_Settings['before_post'] ) && $st_Settings['before_post'] == 'yes' ) {
															echo '<div id="post-before">' . do_shortcode( $st_Settings['before_post_data'] ) . '</div>'; }

													?>

													<div id="article">

														<?php the_content(); ?>

														<div class="clear"><!-- --></div>

													</div><!-- #article -->

													<?php

														// After post data
														if ( !empty( $st_Settings['after_post'] ) && $st_Settings['after_post'] == 'yes' ) {
															echo '<div id="post-after">' . do_shortcode( $st_Settings['after_post_data'] ) . '</div>'; }

													?>

												</article><?php

												

												/*-------------------------------------------
													2.3 - Pagination
												-------------------------------------------*/

												if ( wp_link_pages( 'echo=0' ) ) {

													echo '<div class="page-pagination">';

														if ( function_exists('wp_pagenavi') ) {
															?><div id="wp-pagenavibox"><?php wp_pagenavi( array( 'type' => 'multipart' ) ); ?></div><?php } 

														else {
															wp_link_pages( array( 'before' => '<span>' . __( 'Pages', 'strictthemes' ) . ':</span> ' ) ); }

													echo '</div>';

												}



												/*-------------------------------------------
													2.4 - Prev/Next post
												-------------------------------------------*/

												echo st_prev_next_post();
					


												/*-------------------------------------------
													2.5 - Related posts
												-------------------------------------------*/

												if ( !empty( $st_Settings['related'] ) == 'yes' && function_exists( 'st_related_posts' ) ) {
													echo st_related_posts( 2, __( 'You Might Also Like', 'strictthemes' ) ); }



												/*-------------------------------------------
													2.6 - Comments
												-------------------------------------------*/

												comments_template();



											?>

											<div class="clear"><!-- --></div>
		
										</div><!-- #post-% -->



										<div class="sidebar-post">
						
											<?php



												/*-------------------------------------------
													2.7 - Post meta
												-------------------------------------------*/

												if ( !isset( $st_Settings['post_meta'] ) || !empty( $st_Settings['post_meta'] ) && $st_Settings['post_meta'] == 'yes' ) {


													/*--- Author info -----------------------------*/	

													if ( !isset( $st_Settings['author_info'] ) || !empty( $st_Settings['author_info'] ) && $st_Settings['author_info'] == 'yes' ) {

														// Author's info
														$st_['user_id'] = $post->post_author;
														$st_['site'] = get_the_author_meta( 'user_url', $st_['user_id'] ) ? st_get_redirect_page_url() . esc_url( get_the_author_meta( 'user_url', $st_['user_id'] ) ) : false;
														$st_['facebook'] = get_the_author_meta( 'facebook', $st_['user_id'] ) ? st_get_redirect_page_url() . esc_url( get_the_author_meta( 'facebook', $st_['user_id'] ) ) : false;
														$st_['google'] = get_the_author_meta( 'googleplus', $st_['user_id'] ) ? st_get_redirect_page_url() . esc_url( get_the_author_meta( 'googleplus', $st_['user_id'] ) ) : false;
														$st_['twitter'] = get_the_author_meta( 'twitter', $st_['user_id'] )? st_get_redirect_page_url() . 'https://twitter.com/' . get_the_author_meta( 'twitter', $st_['user_id'] ) : false;								
														$st_['upic'] = get_avatar( get_the_author_meta( 'user_email' ), '110' );
														$st_['desc'] = get_the_author_meta( 'description' ) ? wpautop( do_shortcode( get_the_author_meta( 'description' ) ) ) : ''; ?>
				
														<div class="single-author-info">
				
															<div class="single-author-upic"><a href="<?php echo get_author_posts_url( $st_['user_id'] ); ?>"><?php echo $st_['upic'] ?></a></div>
										
															<h5><a href="<?php echo get_author_posts_url( $st_['user_id'] ); ?>"><?php echo get_the_author_meta( 'display_name' ); ?></a></h5>
															
															<?php echo $st_['desc']; ?>

															<?php
									
																if ( $st_['site'] || $st_['facebook'] || $st_['google'] || $st_['twitter'] ) {
										
																	echo '<div class="single-author-info-links">';
										
																		if ( $st_['site'] ) {
																			echo '<span class="ico16 ico16-flag"><a target="_blank" href="' . $st_['site'] . '" class="tooltip" title="' . __( 'Website', 'strictthemes' ) . '"></a></span>'; }
										
																		if ( $st_['facebook'] ) {
																			echo '<span class="ico16 ico16-facebook"><a target="_blank" href="' . $st_['facebook'] . '" class="tooltip" title="' . __( 'Facebook', 'strictthemes' ) . '"></a></span>'; }
										
																		if ( $st_['google'] ) {
																			echo '<span class="ico16 ico16-googleplus"><a target="_blank" href="' . $st_['google'] . '" class="tooltip" title="' . __( 'Google+', 'strictthemes' ) . '"></a></span>'; }
										
																		if ( $st_['twitter'] ) {
																			echo '<span class="ico16 ico16-twitter"><a target="_blank" href="' . $st_['twitter'] . '" class="tooltip" title="' . __( 'Twitter', 'strictthemes' ) . '"></a></span>'; }
										
																	echo '</div>';
																	
																}
									
															?>

															<div class="clear"><!-- --></div>

														</div><?php
						
													}
													

													/*--- Post short info -----------------------------*/ ?>

													<div class="post-short-info">

														<?php st_post_meta( true, true, true, true, true, true ); ?>

													</div><?php


												}
						


												/*-------------------------------------------
													2.8 - Post sidebar
												-------------------------------------------*/

												echo '<div><!-- --></div>';
												echo '<div id="stickyDiv">';

													if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Post Sidebar') );

												echo '</div>';


						
											?>
						
										</div><!-- .sidebar-post -->



									<?php
		
								endwhile;



							else :
	

								echo '<h1>404</h1><p>' . __('Sorry, no posts matched your criteria.','strictthemes') . '</p>';
	
						
							endif;
		
						?>
		
						<div class="clear"><!-- --></div>
		
					</div>
			
				</div><!-- #content-box -->

				<?php

					/*-------------------------------------------
						2.9 - Sidebar
					-------------------------------------------*/

					if ( !isset( $st_['sidebar_position'] ) || !empty( $st_['sidebar_position'] ) && $st_['sidebar_position'] != 'none' ) {
						get_sidebar(); }

				?>

				<div class="clear"><!-- --></div>

			</div><!-- #content-holder -->
	
		<?php

	get_footer();

?>