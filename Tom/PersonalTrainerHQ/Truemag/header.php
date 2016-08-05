<?php if ( !defined( 'ABSPATH' ) ) exit; ?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>
		<title><?php wp_title( '-', true, 'right' ); ?></title>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div id="layout">
		
			<div id="header">

				<div id="header-layout">

					<div id="posts-featured">
						<?php
							// Posts featured
							get_template_part( '/includes/posts/featured' );
						?>
						<div class="clear"><!-- --></div>
					</div>

					<div id="header-holder">

						<div id="menu" class="div-as-table <?php global $st_Settings; if ( !empty( $st_Settings['stickymenu'] ) && $st_Settings['stickymenu'] == 'no' ) echo 'no-sticky-menu' ?>">
							<div>
								<div>

									<div id="logo" class="div-as-table">
										<div>
											<div>
												<?php
													// Logo
													st_logo();
												?>
											</div>
										</div>
									</div><!-- #logo -->

									<span id="menu-select"></span>
									<?php
										// Menu Primary
										st_menu_primary();
									?>

									<div class="clear"><!-- --></div>
								</div>
							</div>
						</div><!-- #menu -->

						<div class="clear"><!-- --></div>

					</div><!-- #header-holder -->

				</div><!-- #header-layout -->

				<div id="header-layout-2">

					<div id="header-holder-2">

						<?php

							// Icons the Social
							if ( function_exists( 'st_icons_social' ) ) {
								st_icons_social(); }

							// Menu Secondary
							st_menu_secondary();

						?>

						<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search" id="search-form-header">
							<span></span>
							<input
								type="text"
								name="s"
								value=""
								placeholder="<?php _e( 'Search...', 'strictthemes' ) ?>"
							/>
						</form>

						<div class="clear"><!-- --></div>

					</div><!-- #header-holder-2 -->

					<?php
						// Sidebar Ad A
						if ( is_active_sidebar(4) ) {
							get_template_part( '/includes/sidebars/sidebar_ad_a' ); }
					?>

				</div><!-- #header-layout-2 -->

			</div><!-- #header -->

			<div id="content-parent">
			
				<div id="content-layout">