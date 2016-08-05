<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - RETRIEVE DATA

	2 - POSTS

		2.1 - Loop
		2.2 - Sidebar Secondary
		2.3 - Sidebar Default

*/

/*===============================================

	R E T R I E V E   D A T A
	Get a required page data

===============================================*/

	global
		$st_Settings;

		$st_ = array();

		// Template name
		$st_['t'] = !empty( $st_Settings['blog_template'] ) ? $st_Settings['blog_template'] : 'default';

		// Detect the Secondary sidebar
		$st_['secondary_sidebar'] = is_active_sidebar(2) ? true : false;

		// Define content width
		$content_width = $st_['secondary_sidebar'] ? $st_Options['global']['images']['project-medium']['width'] : $st_Options['global']['images']['archive-image']['width'];

		$st_['count'] = 0;


/*===============================================

	P O S T S
	Display posts archive

===============================================*/

	get_header();

		?>
		
			<div id="content-holder" class="<?php echo $st_['secondary_sidebar'] ? 'sidebar-secondary-available ' : ''; ?>sidebar-position-right">
		
				<div id="content-box">
		
					<div>

						<div>

							<?php

								/*-------------------------------------------
									2.1 - Loop
								-------------------------------------------*/

								while ( have_posts() ) : the_post();
	
									include( locate_template( '/includes/posts/' . $st_['t'] . '.php' ) );

									$st_['count']++;

									// Sidebar Ad B
									if ( $st_['count'] == 1 && is_active_sidebar(5) ) {
										get_template_part( '/includes/sidebars/sidebar_ad_b' ); }
	
								endwhile;


								// Pagination
								if ( function_exists('wp_pagenavi') ) {
									?><div id="wp-pagenavibox"><?php wp_pagenavi(); ?></div><?php } 
								else {
									?><div id="but-prev-next"><?php next_posts_link( __( 'Older posts', 'strictthemes' ) ); previous_posts_link( __( 'Newer posts', 'strictthemes' ) ); ?></div><?php } 

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