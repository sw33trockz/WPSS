<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	Template Name: Frontpage

	1 - RETRIEVE DATA

	2 - POSTS

		2.1 - Recent Posts
		2.2 - Sidebar Secondary
		2.3 - Sidebar Default

*/

/*===============================================

	R E T R I E V E   D A T A
	Get a required page data

===============================================*/

	global
		$st_Options,
		$st_Settings,
		$paged;

		$st_ = array();

		// Template name
		$st_['t'] = !empty( $st_Settings['blog_template'] ) ? $st_Settings['blog_template'] : 'default';

		// Get custom sidebar
		$st_['sidebar'] = st_get_post_meta( $post->ID, 'sidebar_value', true, 'Default Sidebar' );
	
		// Get sidebar position
		$st_['sidebar_position'] = st_get_post_meta( $post->ID, 'sidebar_position_value', true, 'right' );

		// Detect the Secondary sidebar
		$st_['secondary_sidebar'] = is_active_sidebar(2) && $st_['sidebar_position'] != 'none' ? true : false;

		// Define content width
		$content_width = $st_['secondary_sidebar'] ? $st_Options['global']['images']['project-medium']['width'] : $st_Options['global']['images']['archive-image']['width'];

		// Is blog?
		$st_['is_blog'] = true;

		// Paged
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged'); }
		
		elseif ( get_query_var('page') ) {
			$paged = get_query_var('page'); }
		
		else {
			$paged = 1; }
		
		$st_['paged'] = $paged;

		// Counter
		$st_['count'] = 0;


/*===============================================

	P O S T S
	Display posts archive

===============================================*/

	get_header();

		?>

			<div id="content-holder" class="<?php echo $st_['secondary_sidebar'] ? 'sidebar-secondary-available ' : 'sidebar-secondary-inactive '; ?>sidebar-position-<?php echo $st_['sidebar_position']; ?>">

				<div id="content-box">

					<div>
		
						<div>

							<?php


								/*-------------------------------------------
									2.1 - Recent Posts
								-------------------------------------------*/

								$st_['qty'] = get_option( 'posts_per_page' );

								$st_['args_recent'] = array(
									'showposts'				=> $st_['qty'],
									'orderby'				=> 'date',
									'paged'					=> $st_['paged'],
									'post_status'			=> 'publish',
									'ignore_sticky_posts'	=> 1,
									'post__not_in'			=> !empty( $st_Settings['sticky_exclude'] ) && $st_Settings['sticky_exclude'] == 'yes' ? get_option('sticky_posts') : ''
								);

								$st_query = new WP_Query();
								wp_reset_postdata();
								$st_query->query( $st_['args_recent'] );


								/*--- Loop -----------------------------*/

								while ( $st_query->have_posts() ) : $st_query->the_post();

									$st_['count']++;

									// Select highlighted post for the t4 template
									if ( $st_['count'] == 1 && $st_['t'] == 't4' ) {
										include( locate_template( '/includes/posts/highlighted.php' ) ); }

									else {
										include( locate_template( '/includes/posts/' . $st_['t'] . '.php' ) ); }

									// Sidebar Ad B
									if ( $st_['count'] == 1 && is_active_sidebar(5) ) {
										get_template_part( '/includes/sidebars/sidebar_ad_b' ); }

								endwhile;
						

								// Pagination
								if ( function_exists('wp_pagenavi') ) {
									?><div id="wp-pagenavibox"><?php wp_pagenavi( array( 'query' => $st_query ) ); ?></div><?php }
								else {
									?><div id="but-prev-next"><?php next_posts_link( __( 'Older posts', 'strictthemes' ), $st_query->max_num_pages ); previous_posts_link( __( 'Newer posts', 'strictthemes' ) ); ?></div><?php }


							?>

							<div class="clear"><!-- --></div>

						</div>
			
						<?php

							/*-------------------------------------------
								2.2 - Sidebar Secondary
							-------------------------------------------*/

							if ( !isset( $st_['sidebar_position'] ) || !empty( $st_['sidebar_position'] ) && $st_['sidebar_position'] != 'none' ) {
								st_get_sidebar( 'Secondary Sidebar' ); }

						?>

						<div class="clear"><!-- --></div>

					</div>

				</div><!-- #content-box -->

				<?php

					/*-------------------------------------------
						2.3 - Sidebar Default
					-------------------------------------------*/

					get_sidebar();

				?>

				<div class="clear"><!-- --></div>

			</div><!-- #content-holder -->
	
		<?php

	get_footer();

?>