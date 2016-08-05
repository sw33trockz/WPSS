<?php if ( !defined( 'ABSPATH' ) ) exit;

/*

	1 - RETRIEVE DATA

	2 - PAGE

		2.2 - Article
			- Title
			- Content
		2.5 - Sidebar

*/

/*===============================================

	R E T R I E V E   D A T A
	Get a required page data

===============================================*/

	global
		$st_Settings;

		$st_ = array();
	
		// Get custom sidebar
		$st_['sidebar'] = 'WooCommerce Sidebar';

		// Get sidebar position
		$st_['sidebar_position'] = st_get_post_meta( $post->ID, 'sidebar_position_value', true, 'right' );

			// Re-define global $content_width if sidebar not exists
			if ( $st_['sidebar_position'] == 'none' ) {
				$content_width = $st_Options['global']['images']['large']['width']; }
			else {
				$content_width = $st_Options['global']['images']['archive-image']['width']; }


/*===============================================

	P A G E
	Display a required page

===============================================*/

	get_header();

		?>

			<div id="content-holder" class="sidebar-position-<?php echo $st_['sidebar_position']; ?>">

				<div id="content-box">
		
					<div>

						<div>

							<?php woocommerce_content(); ?>

							<div class="clear"><!-- --></div>

						</div>

					</div>
			
				</div><!-- #content-box -->
	
				<?php

					/*-------------------------------------------
						2.5 - Sidebar
					-------------------------------------------*/

					if ( !isset( $st_['sidebar_position'] ) || !empty( $st_['sidebar_position'] ) && $st_['sidebar_position'] != 'none' ) {
						get_sidebar(); }

				?>

				<div class="clear"><!-- --></div>

			</div><!-- #content-holder -->
	
		<?php

	get_footer();

?>