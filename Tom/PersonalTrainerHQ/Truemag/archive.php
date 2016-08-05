<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - POSTS

		1.1 - Breadcrumbs
		1.2 - If
			- Date
			- Tag
			- Category
		1.3 - Loop
			- Pagination
		1.4 - Sidebar Secondary
		1.5 - Sidebar Default

	2 - PPOJECTS

		2.1 - Breadcrumbs
		2.2 - Term title
		2.3 - Loop
		2.4 - Sidebar

	3 - 404

		3.1 - Sidebar

*/

/*===============================================

	R E T R I E V E   D A T A
	Get a required page data

===============================================*/

	global
		$st_Options,
		$st_Settings;

		$st_ = array();
		$st_['args'] = array();

		// Post type names
		$st_['st_post'] = !empty( $st_Settings['ctp_post'] ) ? $st_Settings['ctp_post'] : $st_Options['ctp']['post'];
		$st_['st_category'] = !empty( $st_Settings['ctp_category'] ) ? $st_Settings['ctp_category'] : $st_Options['ctp']['category'];
		$st_['st_tag'] = !empty( $st_Settings['ctp_tag'] ) ? $st_Settings['ctp_tag'] : $st_Options['ctp']['tag'];

		// Template name
		$st_['t'] = !empty( $st_Settings['blog_template'] ) ? $st_Settings['blog_template'] : 'default';

		// Get sidebar position
		$st_['sidebar_position'] = st_get_post_meta( st_get_page_by_template('template-frontpage'), 'sidebar_position_value', true, 'right' );

		// Detect the Secondary sidebar
		$st_['secondary_sidebar'] = is_active_sidebar(2) && $st_['sidebar_position'] != 'none' ? true : false;

		// Re-define content width
		$content_width = $st_['secondary_sidebar'] ? $st_Options['global']['images']['project-medium']['width'] : $st_Options['global']['images']['archive-image']['width'];

		$st_['count'] = 0;



/*--- ARCHIVE ---------------------------------*/

	get_header();

		if ( have_posts() ) :



			/*===============================================

				P O S T S
				Display posts archive

			===============================================*/

			?>

				<div id="content-holder" class="<?php echo $st_['secondary_sidebar'] ? 'sidebar-secondary-available ' : 'sidebar-secondary-inactive '; ?>sidebar-position-<?php echo $st_['sidebar_position']; ?>">

					<div id="content-box">

						<div>
	
							<div>

								<?php



									/*-------------------------------------------
										1.1 - Breadcrumbs
									-------------------------------------------*/

									/* no needed */



									/*-------------------------------------------
										1.2 - Title
									-------------------------------------------*/

										/*--- Date -----------------------------*/

										if ( is_day() || is_month() || is_year() ) {
			
											// Get the date
											if ( is_day() ) :
					
												$st_['date'] = get_the_date();
												$st_['y'] = get_the_date('Y');
												$st_['n'] = get_the_date('n');
												$st_['j'] = get_the_date('j');
			
												$st_['qty'] = get_posts( 'year=' . $st_['y'] . '&monthnum=' . $st_['n'] . '&day=' . $st_['j'] . '&posts_per_page=-1' );
												$st_['qty'] = count( $st_['qty'] );
			
											elseif ( is_month() ) :

												$st_['date'] = get_the_date( 'F Y' );
												$st_['y'] = get_the_date('Y');
												$st_['n'] = get_the_date('n');
			
												$st_['qty'] = get_posts( 'year=' . $st_['y'] . '&monthnum=' . $st_['n'] . '&posts_per_page=-1' );
												$st_['qty'] = count( $st_['qty'] );

											elseif ( is_year() ) :
					
												$st_['date'] = get_the_date( 'Y' );
												$st_['y'] = get_the_date('Y');

												$st_['qty'] = 0;
			
													$st_['array'] = array(1,2,3,4,5,6,7,8,9,10,11,12);
			
													foreach ( $st_['array'] as $st_['value'] ) {
			
														$st_['a'] = count( get_posts( 'year=' . $st_['y'] . '&monthnum=' . $st_['value'] . '&posts_per_page=-1' ) );
														$st_['qty'] = $st_['qty'] + $st_['a'];
			
													}
			
											endif;
			
											$st_['out_title'] = $st_['date'] . ' <span class="title-sub">' . $st_['qty'] . '</span>';

										}


										/*--- Tag -----------------------------*/
			
										elseif ( is_tag() ) {
			
											// Get number of posts by tag
											$st_['term'] = get_term_by( 'name', single_tag_title( '', false ), 'post_tag' );
			
											$st_['out_title'] = single_tag_title( '', false ) . ' <span class="title-sub">' . $st_['term']->count . '</span>';

											if ( tag_description() ) {
												$st_['out_description'] = tag_description(); }

										}


										/*--- Category -----------------------------*/
			
										elseif ( is_category() ) {
		
											$st_['category'] = get_queried_object();

											$st_['out_title'] = $st_['category']->name . ' <span class="title-sub">' . $st_['category']->count . '</span>';

											if ( $st_['category']->category_description ) {
												$st_['out_description'] = $st_['category']->category_description; }
			
										}


										/*--- Format -----------------------------*/

										elseif ( get_queried_object()->taxonomy == 'post_format' ) {

											foreach ( $st_Options['global']['post-formats'] as $format => $label ) {
												if ( get_queried_object()->slug == 'post-format-' . $format ) {
													$st_['out_title'] = $label['label'] . ' <span class="title-sub">' . get_queried_object()->count . '</span>'; }
											}

										}


									if ( !empty($st_['out_title']) ) {

										echo
											'<div id="term">' .
												'<div class="term-title"><h1>' . ucwords($st_['out_title']) . '</h1></div>' .
												( !empty($st_['out_description']) ? '<div class="term-description">' . $st_['out_description'] . '</div>' : '' ) .
											'</div>';

									}



									/*-------------------------------------------
										1.3 - Author's vcard
									-------------------------------------------*/

									if ( is_author() ) {
										include( locate_template( '/includes/posts/formats/status.php' ) ); }



									/*-------------------------------------------
										1.3 - Loop
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
									1.4 - Sidebar Secondary
								-------------------------------------------*/

								if ( !isset( $st_['sidebar_position'] ) || !empty( $st_['sidebar_position'] ) && $st_['sidebar_position'] != 'none' ) {
									st_get_sidebar( 'Secondary Sidebar' ); }
	
							?>

							<div class="clear"><!-- --></div>

						</div>

					</div><!-- #content-box -->

					<?php

						/*-------------------------------------------
							1.5 - Sidebar Default
						-------------------------------------------*/

						get_sidebar();

					?>

					<div class="clear"><!-- --></div>

				</div><!-- #content-holder -->

			<?php



		else :



			?>

				<div id="content-holder" class="arch sidebar-position-right">

					<div id="content-box">

						<div>

							<div>

								<?php _e( 'Sorry, no posts matched your criteria.', 'strictthemes' ) ?>

								<div class="clear"><!-- --></div>

							</div>

						</div>

					</div><!-- #content-box -->

					<?php

						/*-------------------------------------------
							3.1 - Sidebar Default
						-------------------------------------------*/

						get_sidebar();

						/*-------------------------------------------
							3.2 - Sidebar Secondary
						-------------------------------------------*/

						st_get_sidebar( 'Secondary Sidebar' );

					?>

					<div class="clear"><!-- --></div>

				</div><!-- #content-holder -->
		
			<?php



		endif;


	get_footer();

?>