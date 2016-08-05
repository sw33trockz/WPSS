<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - RETRIEVE DATA

	2 - CONTENT

		2.1 - Breadcrumbs
		2.2 - Article
			- Title
			- Content
		2.3 - Pagination

*/

/*===============================================

	R E T R I E V E   D A T A
	Get a required page data

===============================================*/

	global
		$st_Settings;

		$st_ = array();

		// Is title disabled?
		$st_['title_disabled'] = st_get_post_meta( $post->ID, 'disable_title_value', true, 0 );

		// Is breadcrumbs disabled?
		$st_['breadcrumbs_disabled'] = st_get_post_meta( $post->ID, 'disable_breadcrumbs_value', true, 0 );
	
		// buddyPress sidebar sidebar
		if ( $st_Options['sidebars']['buddyPress'] && function_exists('is_buddypress') ) {
			if ( is_buddypress() ) {
				$st_['sidebar'] = 'BuddyPress Sidebar'; }
		}

		// Get sidebar position
		$st_['sidebar_position'] = 'none';

		// Re-define global $content_width if sidebar not exists
		$content_width = $st_Options['global']['images']['large']['width'];


/*===============================================

	C O N T E N T
	Display a required content

===============================================*/ ?>

	<div id="content-holder" class="sidebar-position-none">

		<div id="content-box">

			<div>

				<div>

					<?php



						/*-------------------------------------------
							2.1 - Breadcrumbs
						-------------------------------------------*/

						if ( $st_['breadcrumbs_disabled'] != 1 && !is_front_page() && function_exists( 'st_breadcrumbs' ) ) {
							st_breadcrumbs(); }



						/*-------------------------------------------
							2.2 - Article
						-------------------------------------------*/ ?>

						<article><?php



							/*--- Title -----------------------------*/

							if ( $st_['title_disabled'] != 1 && !is_front_page() ) { ?>
				
								<h1 class="page-title"><?php

									// Title
									the_title();

									// Subtitle
									$st_['subtitle'] = get_post_meta( $post->ID, 'subtitle_value', true );

										if ( $st_['subtitle'] ) {
											echo '<span class="title-end">.</span> <span class="title-sub">' . $st_['subtitle'] . '<span class="title-end">.</span></span>'; } ?>


								</h1><?php

							}
				


							/*--- Content -----------------------------*/

							echo '<div id="content-data">'; the_content(); echo '</div>'; ?>



						</article>

						<div class="clear"><!-- --></div><?php

			

						/*-------------------------------------------
							2.3 - Pagination
						-------------------------------------------*/

						wp_link_pages( array( 'before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number' ) );
						


					?>

					<div class="clear"><!-- --></div>

				</div>

			</div>
	
		</div><!-- #content-box -->

	</div><!-- #content-holder -->