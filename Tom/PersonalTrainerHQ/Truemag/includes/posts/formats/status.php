<?php if ( !defined( 'ABSPATH' ) ) exit;
/*

	Post format: Status

*/

	/*--- After title data -----------------------------*/

	if ( is_single() && !empty( $st_Settings['after_title'] ) && $st_Settings['after_title'] == 'yes' ) {
		echo '<div id="title-after">' . do_shortcode( $st_Settings['after_title_data'] ) . '</div><div class="clear"><!-- --></div>'; }


	/*--- Excerpt -----------------------------*/

	if ( is_single() && !empty( $st_Settings['excerpt'] ) && $st_Settings['excerpt'] == 'yes' && $post->post_excerpt ) {
		echo '<div class="clear"><!-- --></div><div id="post-excerpt">' . wpautop( $post->post_excerpt ) . '</div>'; } ?>


	<div class="st-format-status-holder"><?php
	
		/*===============================================
		
			S T A T U S
			Post Format
		
		===============================================*/
	
			$st_['user_id'] = get_the_author_meta( 'ID' );
			$st_['upic'] = get_avatar( get_the_author_meta( 'user_email' ), '110' );												
			$st_['name'] = get_the_author_meta( 'display_name', $st_['user_id'] );
			$st_['posts_url'] = get_author_posts_url( $st_['user_id'] );
			$st_['site'] = get_the_author_meta( 'user_url', $st_['user_id'] ) ? st_get_redirect_page_url() . esc_url( get_the_author_meta( 'user_url', $st_['user_id'] ) ) : false;
			$st_['facebook'] = get_the_author_meta( 'facebook', $st_['user_id'] ) ? st_get_redirect_page_url() . esc_url( get_the_author_meta( 'facebook', $st_['user_id'] ) ) : false;
			$st_['google'] = get_the_author_meta( 'googleplus', $st_['user_id'] ) ? st_get_redirect_page_url() . esc_url( get_the_author_meta( 'googleplus', $st_['user_id'] ) ) : false;
			$st_['twitter'] = get_the_author_meta( 'twitter', $st_['user_id'] )? st_get_redirect_page_url() . 'https://twitter.com/' . get_the_author_meta( 'twitter', $st_['user_id'] ) : false;

		
			/*--- Status -----------------------------*/
		
			$st_['status'] = st_get_post_meta( $post->ID, 'status_value', true, '' );
		
			if ( $st_['status'] || is_author() ) {
		
				echo "\n"; ?>

					<div class="status-header">

						<a href="<?php echo $st_['posts_url'] ?>"><?php echo $st_['name']; echo is_author() ? ' <span>' . $wp_query->found_posts . '</span>' : ''; ?></a>

						<?php

							if ( $st_['site'] || $st_['facebook'] || $st_['google'] || $st_['twitter'] ) {
	
								echo '<div class="status-header-links">' . "\n";
	
									if ( $st_['site'] ) {
										echo '<span class="ico16 ico16-flag"><a href="' . $st_['site'] . '">' . __( 'Website', 'strictthemes' ) . '</a></span>' . "\n"; }
	
									if ( $st_['facebook'] ) {
										echo '<span class="ico16 ico16-facebook"><a href="' . $st_['facebook'] . '">' . __( 'Facebook', 'strictthemes' ) . '</a></span>' . "\n"; }
	
									if ( $st_['google'] ) {
										echo '<span class="ico16 ico16-googleplus"><a href="' . $st_['google'] . '">' . __( 'Google+', 'strictthemes' ) . '</a></span>' . "\n"; }
	
									if ( $st_['twitter'] ) {
										echo '<span class="ico16 ico16-twitter"><a href="' . $st_['twitter'] . '">' . __( 'Twitter', 'strictthemes' ) . '</a></span>' . "\n"; }
	
								echo '</div>';
								
							}

						?>
	
						<div class="status-header-upic">
							<a href="<?php echo $st_['posts_url'] ?>"><?php echo $st_['upic'] ?></a>
						</div>

					</div>

					<div class="status-content">
						<?php

							if ( is_author() ) {
								echo wpautop( wptexturize( do_shortcode( get_the_author_meta('description') ) ) ); }

							else {
								echo wpautop( wptexturize( do_shortcode( $st_['status'] ) ) ); }

						?>
						<div class="clear"><!-- --></div>
					</div>

				<?php
			}

	
		?>
	
	</div>