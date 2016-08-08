<?php

/* Allow shortcodes in widgets */
add_filter( 'widget_text', 'do_shortcode' );


/* Add classes to body tag */

add_filter( 'body_class', 'herald_body_class' );

if ( !function_exists( 'herald_body_class' ) ):
	function herald_body_class( $classes ) {
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		//Add some broswer classes which can be usefull for some css hacks later
		if ( $is_lynx ) $classes[] = 'lynx';
		elseif ( $is_gecko ) $classes[] = 'gecko';
		elseif ( $is_opera ) $classes[] = 'opera';
		elseif ( $is_NS4 ) $classes[] = 'ns4';
		elseif ( $is_safari ) $classes[] = 'safari';
		elseif ( $is_chrome ) $classes[] = 'chrome';
		elseif ( $is_IE ) $classes[] = 'ie';
		else $classes[] = 'unknown';

		if ( $is_iphone ) $classes[] = 'iphone';

		if ( herald_get_option( 'content_layout' ) == 'boxed' ) {
			$classes[] = 'herald-boxed';
		}

		return $classes;
	}
endif;


/* Print some stuff from options to head tag */

add_action( 'wp_head', 'herald_wp_head', 99 );

if ( !function_exists( 'herald_wp_head' ) ):
	function herald_wp_head() {

		//Additional CSS (if user adds his custom css inside theme options)
		$additional_css = trim( preg_replace( '/\s+/', ' ', herald_get_option( 'additional_css' ) ) );
		if ( !empty( $additional_css ) ) {
			echo '<style type="text/css">'.$additional_css.'</style>';
		}

		//Google Analytics (tracking)
		if ( $ga = herald_get_option( 'ga' ) ) {
			echo $ga;
		}

	}
endif;

/* For advanced use - custom JS code into footer if specified in theme options */

add_action( 'wp_footer', 'herald_wp_footer', 99 );

if ( !function_exists( 'herald_wp_footer' ) ):
	function herald_wp_footer() {

		//Additional JS
		$additional_js = trim( preg_replace( '/\s+/', ' ', herald_get_option( 'additional_js' ) ) );
		if ( !empty( $additional_js ) ) {
			echo '<script type="text/javascript">
				/* <![CDATA[ */
					'.$additional_js.'
				/* ]]> */
				</script>';
		}

	}
endif;


/* Add media grabber features */

add_action( 'init', 'herald_add_media_grabber' );

if ( !function_exists( 'herald_add_media_grabber' ) ):
	function herald_add_media_grabber() {
		if ( !class_exists( 'Hybrid_Media_Grabber' ) ) {
			include_once get_template_directory() .'/inc/media-grabber/class-hybrid-media-grabber.php';
		}
	}
endif;

/* Add class to gallery images to run our pop-up and change sizes */

add_filter( 'shortcode_atts_gallery', 'herald_gallery_atts', 10, 3 );

if ( !function_exists( 'herald_gallery_atts' ) ):
	function herald_gallery_atts( $output, $pairs, $atts ) {

		if( herald_get_option('popup_img') ) {
			$atts['link'] = 'file';
			$output['link'] = 'file';
			add_filter( 'wp_get_attachment_link', 'herald_add_class_attachment_link', 10, 1 );
		}

		if ( !isset( $output['columns'] ) ) {
			$output['columns'] = 1;
		}

		if( herald_get_option('auto_gallery_img_sizes') ) {
			switch ($output['columns']){
				case '1' : $output['size'] = 'herald-lay-a-full'; break;
				case '2' : $output['size'] = 'herald-lay-a'; break;
				case '3' : $output['size'] = 'herald-lay-c1'; break;
				case '4' : $output['size'] = 'herald-lay-f1-full'; break;
				case '5' : 
				case '6' : $output['size'] = 'herald-lay-f1'; break;
				case '7' : 
				case '8' :
				case '9' : $output['size'] = 'herald-lay-i1'; break;
				default: $output['size'] = 'herald-lay-a-full'; break;
			}

			//Check if has a matched image size
			global $herald_image_matches;

			if ( !empty( $herald_image_matches ) && array_key_exists( $output['size'], $herald_image_matches ) ) {
				$output['size'] = $herald_image_matches[$output['size']];
			}
		}
		
		

		return $output;
	}
endif;

if ( !function_exists( 'herald_add_class_attachment_link' ) ):
	function herald_add_class_attachment_link( $link ) {
		$link = str_replace( '<a', '<a class="herald-popup"', $link );
		return $link;
	}
endif;



/* Unregister Entry Views widget */
add_action( 'widgets_init', 'herald_unregister_widgets', 99 );

if ( !function_exists( 'herald_unregister_widgets' ) ):
	function herald_unregister_widgets() {

		$widgets = array( 'EV_Widget_Entry_Views' );

		//Allow child themes or plugins to add/remove widgets they want to unregister
		$widgets = apply_filters( 'herald_modify_unregister_widgets', $widgets );

		if ( !empty( $widgets ) ) {
			foreach ( $widgets as $widget ) {
				unregister_widget( $widget );
			}
		}

	}
endif;


/* Remove entry views support for other post types, we need post support only */

add_action( 'init', 'herald_remove_entry_views_support', 99 );

if ( !function_exists( 'herald_remove_entry_views_support' ) ):
	function herald_remove_entry_views_support() {

		$types = array( 'page', 'attachment', 'literature', 'portfolio_item', 'recipe', 'restaurant_item' );

		//Allow child themes or plugins to modify entry views support
		$widgets = apply_filters( 'herald_modify_entry_views_support', $types );

		if ( !empty( $types ) ) {
			foreach ( $types as $type ) {
				remove_post_type_support( $type, 'entry-views' );
			}
		}

	}
endif;


/* Prevent redirect issue that may brake home page pagination caused by some plugins */
add_filter( 'redirect_canonical', 'herald_disable_redirect_canonical' );

function herald_disable_redirect_canonical( $redirect_url ) {
	if ( is_page_template( 'template-modules.php' ) && is_paged() ) {
		$redirect_url = false;
	}
	return $redirect_url;
}



/* Add span elements to post count number in category widget */

add_filter( 'wp_list_categories', 'herald_add_span_cat_count', 10, 2 );

if ( !function_exists( 'herald_add_span_cat_count' ) ):
	function herald_add_span_cat_count( $links, $args ) {

		if ( isset( $args['taxonomy'] ) && $args['taxonomy'] != 'category' ) {
			return $links;
		}

		$links = preg_replace( '/(<a[^>]*>)/', '$1<span class="category-text">', $links );
		$links = str_replace( '</a>', '</span></a>', $links );
		$links = str_replace( '</a> (', '<span class="count">', $links );
		$links = str_replace( ')', '</span></a>', $links );

		return $links;
	}
endif;




/* Pre get posts */
add_action( 'pre_get_posts', 'herald_pre_get_posts' );

if ( !function_exists( 'herald_pre_get_posts' ) ):
	function herald_pre_get_posts( $query ) {

		if ( !is_admin() && $query->is_main_query() && $query->is_archive() ) {

			$template = herald_detect_template();
			
			/* Check whether to change number of posts per page for specific archive template */
			$ppp = herald_get_option( $template.'_ppp' );
			
			if ( $template == 'category' ) {
				$obj = get_queried_object();
				$cat_meta = herald_get_category_meta( $obj->term_id );
				
				if ( $cat_meta['layout'] == 'inherit' || $cat_meta['ppp'] == 'inherit') {
					if($ppp == 'custom'){
						$ppp_num = absint( herald_get_option( $template.'_ppp_num' ) );
						$query->set( 'posts_per_page', $ppp_num );
					}
				} else {
					if( $cat_meta['ppp'] == 'custom'){
						$query->set( 'posts_per_page', $cat_meta['ppp_num'] );
					}
				}
			} else {
				if ( $ppp == 'custom') {
					$ppp_num = absint( herald_get_option( $template.'_ppp_num' ) );
					$query->set( 'posts_per_page', $ppp_num );
				}
			}

			/* Check for featured area on category page and exclude those posts from main post listing */
			if ( $template == 'category' ) {

				$fa = herald_get_featured_area();

				if ( !empty($fa) && herald_get_option( 'category_fa_unique' ) ) {

					if ( isset( $fa['query'] ) && !is_wp_error( $fa['query'] ) && !empty( $fa['query'] ) ) {
						$exclude_ids = array();
						foreach ( $fa['query']->posts as $p ) {
							$exclude_ids[] = $p->ID;
						}

						$query->set( 'post__not_in', $exclude_ids );
					}

				}
			}

		}

	}
endif;


/**
 * Modify WooCommerce Wrappers
 *
 * Modify WooCommerce Wrappers according to Herald Structure
 *
 * @return HTML output
 * @since  1.2
 */


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_before_main_content', 'herald_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'herald_woocommerce_wrapper_end', 10 );

if ( !function_exists( 'herald_woocommerce_wrapper_start' ) ):
	function herald_woocommerce_wrapper_start() {
		global $herald_sidebar_opts;
		$col_class = $herald_sidebar_opts['use_sidebar'] == 'none' ? 12 : 9;
		$left_sid_mod_class = $herald_sidebar_opts['use_sidebar'] == 'left' ? 'herald-woo-mod-right' : '';
		echo '<div class="herald-section container"><div class="row"><div class="herald-module herald-main-content '.$left_sid_mod_class.' col-lg-'.esc_attr($col_class).' col-md-'.esc_attr($col_class).'">';
	}
endif;

if ( !function_exists( 'herald_woocommerce_wrapper_end' ) ):
	function herald_woocommerce_wrapper_end() {
		echo '</div>';
	}
endif;

add_action('herald_before_end_content', 'herald_woocommerce_close_wrap');

if ( !function_exists( 'herald_woocommerce_close_wrap' ) ):
	function herald_woocommerce_close_wrap() {
		if( herald_is_woocommerce_active() && herald_is_woocommerce_page() ) {
			echo '</div></div>';
		}
	}
endif;


?>