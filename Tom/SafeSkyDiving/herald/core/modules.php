<?php

/**
 * Get module defaults
 *
 * @param string  $type Module type
 * @return array Default arguments of a module
 * @since  1.0
 */

if ( !function_exists( 'herald_get_module_defaults' ) ):
	function herald_get_module_defaults( $type = false ) {

		$defaults = array(
			'posts' => array(
				'type' => 'posts',
				'type_name' => esc_html__( 'Posts', 'herald' ),
				'title' => '',
				'hide_title' => 0,
				'columns' => 12,
				'layout' => 'b',
				'limit' => 10,
				'starter_layout' => 'none',
				'starter_limit' => 1,
				'cat' => array(),
				'cat_child' => 0,
				'cat_inc_exc' => 'in',
				'tag' => array(),
				'tag_inc_exc' => 'in',
				'manual' => array(),
				'time' => 0,
				'order' => 'date',
				'sort' => 'DESC',
				'format' => 0,
				'unique' => 0,
				'slider' => 0,
				'autoplay' => '',
				'cat_nav' => 0,
				'more_text' => '',
				'more_url' => '',
				'css_class' => ''
			),
			'featured' => array(
				'type' => 'featured',
				'type_name' => esc_html__( 'Featured', 'herald' ),
				'title' => '',
				'hide_title' => 0,
				'layout' => '1',
				'cat' => array(),
				'cat_child' => 0,
				'cat_inc_exc' => 'in',
				'tag' => array(),
				'tag_inc_exc' => 'in',
				'manual' => array(),
				'time' => 0,
				'order' => 'date',
				'sort' => 'DESC',
				'format' => 0,
				'unique' => 0,
				'cat_nav' => 0,
				'more_text' => '',
				'more_url' => '',
				'css_class' => ''
			),
			'text' => array(
				'type' => 'text',
				'type_name' => esc_html__( 'Text', 'herald' ),
				'title' => '',
				'hide_title' => 0,
				'columns' => 12,
				'content' => '',
				'autop' => 0,
				'css_class' => ''
			)
		);

		if ( herald_is_woocommerce_active() ) {

			$defaults['woocommerce'] = array(
				'type' => 'woocommerce',
				'type_name' => esc_html__( 'Products', 'herald' ),
				'title' => '',
				'hide_title' => 0,
				'columns' => 12,
				'layout' => 'i',
				'limit' => 8,
				'display_price' => 1,
				'display_cat' => 1,
				'cat' => array(),
				'tag' => array(),
				'manual' => array(),
				'time' => 0,
				'order' => 'date',
				'slider' => 0,
				'autoplay' => '',
				'more_text' => '',
				'more_url' => '',
				'css_class' => ''
			);
		}

		if ( !empty( $type ) && array_key_exists( $type, $defaults ) ) {
			return $defaults[$type];
		}

		return $defaults;

	}
endif;

/**
 * Get module options
 *
 * @param string  $type Module type
 * @return array Options for sepcific module
 * @since  1.0
 */

if ( !function_exists( 'herald_get_module_options' ) ):
	function herald_get_module_options( $type = false ) {

		$options = array(
			'posts' => array(
				'layouts' => herald_get_main_layouts(),
				'starter_layouts' => herald_get_main_layouts( false, true ),
				'columns' => herald_get_module_columns(),
				'cats' => get_categories( array( 'hide_empty' => false, 'number' => 0 ) ),
				'time' => herald_get_time_diff_opts(),
				'order' => herald_get_post_order_opts(),
				'formats' => herald_get_post_format_opts(),
			),
			'featured' => array(
				'layouts' => herald_get_featured_layouts(),
				'cats' => get_categories( array( 'hide_empty' => false, 'number' => 0 ) ),
				'time' => herald_get_time_diff_opts(),
				'order' => herald_get_post_order_opts(),
				'formats' => herald_get_post_format_opts()
			),
			'text' => array(
				'columns' => herald_get_module_columns(),
			)
		);

		if ( herald_is_woocommerce_active() ) {

			$options['woocommerce'] = array(
				'cats' => get_terms( 'product_cat', array( 'hide_empty' => false, 'number' => 0 ) ),
				'order' => herald_get_product_order_opts(),
				'time' => herald_get_time_diff_opts()
			);

		}


		if ( !empty( $type ) && array_key_exists( $type, $options ) ) {
			return $options[$type];
		}

		return $options;

	}
endif;



/**
 * Get module layout
 *
 * Functions gets current post layout for specific module
 *
 * @param array   $module Module data
 * @param int     $i      index of current post
 * @return string id of current layout
 * @since  1.0
 */

if ( !function_exists( 'herald_get_module_layout' ) ):
	function herald_get_module_layout( $module, $i ) {

		if ( herald_module_is_slider( $module ) ) {

			return $module['layout'];

		} else if ( isset( $module['starter_layout'] ) && $module['starter_layout'] != 'none' &&  $i < absint( $module['starter_limit'] ) ) {

				return $module['starter_layout'];
			}

		return $module['layout'];
	}
endif;

/**
 * Is module slider
 *
 * Check if slider is applied to module
 *
 * @param array   $module Module data
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'herald_module_is_slider' ) ):
	function herald_module_is_slider( $module ) {

		if ( isset( $module['slider'] ) && !empty( $module['slider'] ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Is module combined
 *
 * Check if module has starter posts
 *
 * @param array   $module Module data
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'herald_module_is_combined' ) ):
	function herald_module_is_combined( $module ) {

		if ( isset( $module['starter_layout'] ) && $module['starter_layout'] != 'none' && !empty( $module['starter_limit'] ) ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Is module paginated
 *
 * Check if current module has a pagination
 *
 * @param unknown $i current section index
 * @param unknown $j current module index
 * @return bool
 * @since  1.0
 */

if ( !function_exists( 'herald_module_is_paginated' ) ):
	function herald_module_is_paginated( $i, $j ) {
		global $herald_module_pag_index;

		if ( !empty( $herald_module_pag_index ) && $herald_module_pag_index['s_ind'] == $i && $herald_module_pag_index['m_ind'] == $j ) {
			return true;
		}

		return false;
	}
endif;

/**
 * Set paginated module index
 *
 * Get last posts module index so we know to which module we should apply pagination
 * and set indexes to $herald_module_pag_index global var
 *
 * @param array   $sections Sections data array
 * @return void
 * @since  1.0
 */

if ( !function_exists( 'herald_set_paginated_module_index' ) ):
	function herald_set_paginated_module_index( $sections, $paged = false ) {

		global $herald_module_pag_index;

		//If we are on paginated modules page it shows only one section and module so index is set to "0"
		if ( $paged ) {

			$herald_module_pag_index = array( 's_ind' => 0, 'm_ind' => 0 );

		} else {

			$last_section_index = false;
			$last_module_index = false;
			foreach ( $sections as $m => $section ) {
				if ( !empty( $section['modules'] ) ) {
					foreach ( $section['modules'] as $n => $module ) {
						if ( $module['type'] == 'posts' ) {
							$last_section_index = $m;
							$last_module_index = $n;
						}
					}
				}
			}

			if ( $last_section_index !== false && $last_module_index !== false ) {
				$herald_module_pag_index = array( 's_ind' => $last_section_index, 'm_ind' => $last_module_index );
			}
		}
	}
endif;

/**
 * Module template is paged
 *
 * Check if we are on paginated modules page
 *
 * @return int|false
 * @since  1.0
 */

if ( !function_exists( 'herald_module_template_is_paged' ) ):
	function herald_module_template_is_paged() {
		$curr_page = is_front_page() ? absint( get_query_var( 'page' ) ) : absint( get_query_var( 'paged' ) );
		return $curr_page > 1 ? $curr_page : false;
	}
endif;


/**
 * Parse paged module template
 *
 * When we are on paginated module page
 * pull only the last posts module and its section
 * but check queries for other modules in other sections
 *
 * @param array   $sections existing sections data
 * @return array parsed new section data
 * @since  1.0
 */

if ( !function_exists( 'herald_parse_paged_module_template' ) ):
	function herald_parse_paged_module_template( $sections ) {

		foreach ( $sections as $s_ind => $section ) {
			if ( !empty( $section['modules'] ) ) {
				foreach ( $section['modules'] as $m_ind => $module ) {

					$module = herald_parse_args( $module, herald_get_module_defaults( $module['type'] ) );

					if ( $module['type'] == 'posts' ) {

						if ( herald_module_is_paginated( $s_ind, $m_ind ) ) {

							$new_sections = array( 0 => $section );
							$module['starter_layout'] = 'none';
							$new_sections[0]['modules'] = array( 0 => $module );
							return $new_sections;

						} else {

							if ( $module['unique'] ) {
								herald_get_module_query( $module );
							}
						}

					} else if ( $module['type'] == 'featured' ) {

							if ( $module['unique'] ) {
								herald_get_featured_module_query( $module );
							}
						}
				}
			}
		}

	}
endif;




/**
 * Get module heading
 *
 * Function gets heading/title html for current module
 *
 * @param array   $module Module data
 * @return string HTML output
 * @since  1.0
 */

if ( !function_exists( 'herald_get_module_heading' ) ):
	function herald_get_module_heading( $module ) {

		$args = array();

		if ( !empty( $module['title'] ) && empty( $module['hide_title'] ) ) {

			$args['title'] = '<h2 class="h6 herald-mod-h herald-color">'.$module['title'].'</h2>';
		}

		if ( !empty( $module['cat'] ) && count( $module['cat'] ) == 1 ) {
			$args['cat'] = $module['cat'][0];
		}

		if ( isset( $args['cat'] ) && isset( $module['cat_nav'] ) && !empty( $module['cat_nav'] ) ) {
			$sub = get_categories( array( 'parent' => $args['cat'], 'hide_empty' => false ) );
			if ( !empty( $sub ) ) {
				$args['subnav'] = '';
				foreach ( $sub as $child ) {
					$args['subnav'] .= '<a href="'.esc_url( get_category_link( $child ) ).'">'.$child->name.'</a>';
				}
			}
		}

		$args['actions'] = '';

		if ( isset( $module['more_text'] ) && !empty( $module['more_text'] ) && !empty( $module['more_url'] ) ) {
			$args['actions'].= '<a class="herald-all-link" href="'.esc_url( $module['more_url'] ).'">'.$module['more_text'].'</a>';
		}

		if ( herald_module_is_slider( $module ) ) {
			$args['actions'].= '<div class="herald-slider-controls" data-col="'.esc_attr( herald_layout_columns( $module['layout'] ) ).'" data-autoplay="'.absint( $module['autoplay'] ).'"></div>';
		}

		return !empty( $args ) ? herald_print_heading( $args ) : '';

	}
endif;

/**
 * Get module query
 *
 * @param array   $module Module data
 * @return object WP_query
 * @since  1.0
 */

if ( !function_exists( 'herald_get_module_query' ) ):
	function herald_get_module_query( $module, $paged = false ) {

		global $herald_unique_module_posts;

		$module = wp_parse_args( $module, herald_get_module_defaults( $module['type'] ) );

		$args['ignore_sticky_posts'] = 1;

		if ( !empty( $module['manual'] ) ) {

			$args['posts_per_page'] = absint( count( $module['manual'] ) );
			$args['orderby'] =  'post__in';
			$args['post__in'] =  $module['manual'];
			$args['post_type'] = array_keys( get_post_types( array( 'public' => true ) ) ); //support all existing public post types

		} else {

			$args['post_type'] = 'post';
			$args['posts_per_page'] = absint( $module['limit'] );

			if ( !empty( $module['cat'] ) ) {

				if ( $module['cat_child'] ) {
					$child_cat_temp = array();
					foreach ( $module['cat'] as $parent ) {
						$child_cats = get_categories( array( 'child_of' => $parent ) );
						if ( !empty( $child_cats ) ) {
							foreach ( $child_cats as $child ) {
								$child_cat_temp[] = $child->term_id;
							}
						}
					}
					$module['cat'] = array_merge( $module['cat'], $child_cat_temp );
				}

				$args['category__'.$module['cat_inc_exc']] = $module['cat'];
			}

			if ( !empty( $module['tag'] ) ) {
				$args['tag_slug__'.$module['tag_inc_exc']] = $module['tag'];
			}

			if ( !empty( $module['format'] ) ) {

				if ( $module['format'] == 'standard' ) {

					$terms = array();
					$formats = get_theme_support( 'post-formats' );
					if ( !empty( $formats ) && is_array( $formats[0] ) ) {
						foreach ( $formats[0] as $format ) {
							$terms[] = 'post-format-'.$format;
						}
					}
					$operator = 'NOT IN';

				} else {
					$terms = array( 'post-format-'.$module['format'] );
					$operator = 'IN';
				}

				$args['tax_query'] = array(
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => $terms,
						'operator' => $operator
					)
				);
			}


			$args['orderby'] = $module['order'];

			if ( $args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {

				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = ev_get_meta_key();

			} else if ( strpos( $args['orderby'], 'reviews' ) !== false && herald_is_wp_review_active() ) {

					$review_type = substr( $args['orderby'], 8, strlen( $args['orderby'] ) );

					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = 'wp_review_total';

					$args['meta_query'] = array(
						array(
							'key'     => 'wp_review_type',
							'value'   => $review_type,
						)
					);

				}

			$args['order'] = $module['sort'];

			if ( $time_diff = $module['time'] ) {
				$args['date_query'] = array( 'after' => date( 'Y-m-d', herald_calculate_time_diff( $time_diff ) ) );
			}

			if ( !empty( $herald_unique_module_posts ) ) {
				$args['post__not_in'] = $herald_unique_module_posts;
			}
		}

		if ( $paged ) {
			$args['paged'] = $paged;
		}

		$query = new WP_Query( $args );

		if ( $module['unique'] && !is_wp_error( $query ) && !empty( $query ) ) {

			foreach ( $query->posts as $p ) {
				$herald_unique_module_posts[] = $p->ID;
			}
		}

		return $query;

	}
endif;

/**
 * Get featured module query
 *
 * @param array   $module Module data
 * @return object WP_query
 * @since  1.0
 */

if ( !function_exists( 'herald_get_featured_module_query' ) ):
	function herald_get_featured_module_query( $module ) {

		global $herald_unique_module_posts;

		$module = wp_parse_args( $module, herald_get_module_defaults( $module['type'] ) );

		$args['ignore_sticky_posts'] = 1;

		if ( !empty( $module['manual'] ) ) {

			$args['orderby'] =  'post__in';
			$args['post__in'] =  $module['manual'];
			$args['post_type'] = array_keys( get_post_types( array( 'public' => true ) ) ); //support all existing public post types

		} else {

			$args['post_type'] = 'post';
			$args['posts_per_page'] = absint( herald_get_featured_area_numposts( $module['layout'] ) );

			if ( !empty( $module['cat'] ) ) {

				if ( $module['cat_child'] ) {
					$child_cat_temp = array();
					foreach ( $module['cat'] as $parent ) {
						$child_cats = get_categories( array( 'child_of' => $parent ) );
						if ( !empty( $child_cats ) ) {
							foreach ( $child_cats as $child ) {
								$child_cat_temp[] = $child->term_id;
							}
						}
					}
					$module['cat'] = array_merge( $module['cat'], $child_cat_temp );
				}

				$args['category__'.$module['cat_inc_exc']] = $module['cat'];
			}

			if ( !empty( $module['tag'] ) ) {
				$args['tag_slug__'.$module['tag_inc_exc']] = $module['tag'];
			}

			if ( !empty( $module['format'] ) ) {

				if ( $module['format'] == 'standard' ) {

					$terms = array();
					$formats = get_theme_support( 'post-formats' );
					if ( !empty( $formats ) && is_array( $formats[0] ) ) {
						foreach ( $formats[0] as $format ) {
							$terms[] = 'post-format-'.$format;
						}
					}
					$operator = 'NOT IN';

				} else {
					$terms = array( 'post-format-'.$module['format'] );
					$operator = 'IN';
				}

				$args['tax_query'] = array(
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => $terms,
						'operator' => $operator
					)
				);
			}

			$args['orderby'] = $module['order'];

			if ( $args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = ev_get_meta_key();
			} else if ( strpos( $args['orderby'], 'reviews' ) !== false && herald_is_wp_review_active() ) {

					$review_type = substr( $args['orderby'], 8, strlen( $args['orderby'] ) );

					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = 'wp_review_total';

					$args['meta_query'] = array(
						array(
							'key'     => 'wp_review_type',
							'value'   => $review_type,
						)
					);

				}

			$args['order'] = $module['sort'];

			if ( $time_diff = $module['time'] ) {
				$args['date_query'] = array( 'after' => date( 'Y-m-d', herald_calculate_time_diff( $time_diff ) ) );
			}

			if ( !empty( $herald_unique_module_posts ) ) {
				$args['post__not_in'] = $herald_unique_module_posts;
			}
		}


		$query = new WP_Query( $args );

		if ( $module['unique'] && !is_wp_error( $query ) && !empty( $query ) ) {

			foreach ( $query->posts as $p ) {
				$herald_unique_module_posts[] = $p->ID;
			}
		}

		return $query;

	}
endif;

/**
 * Get module query
 *
 * @param array   $module Module data
 * @return object WP_query
 * @since  1.0
 */

if ( !function_exists( 'herald_get_module_products_query' ) ):
	function herald_get_module_products_query( $module ) {

		$module = wp_parse_args( $module, herald_get_module_defaults( $module['type'] ) );

		$args['ignore_sticky_posts'] = 1;

		if ( !empty( $module['manual'] ) ) {

			$args['posts_per_page'] = absint( count( $module['manual'] ) );
			$args['orderby'] =  'post__in';
			$args['post__in'] =  $module['manual'];
			$args['post_type'] = 'product';

		} else {

			$args['post_type'] = 'product';
			$args['posts_per_page'] = absint( $module['limit'] );

			$args['tax_query'] = array();

			if ( !empty( $module['cat'] ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $module['cat'],
				);
			}

			if ( !empty( $module['tag'] ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'product_tag',
					'field'    => 'slug',
					'terms'    => $module['tag'],
				);
			}

			if ( count( $args['tax_query'] ) > 1 ) {
				$args['tax_query']['relation'] = 'AND';
			}

			$args['orderby'] = $module['order'];

			if ( $args['orderby'] == 'views' && function_exists( 'ev_get_meta_key' ) ) {
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = ev_get_meta_key();
			}

			if ( $time_diff = $module['time'] ) {
				$args['date_query'] = array( 'after' => date( 'Y-m-d', herald_calculate_time_diff( $time_diff ) ) );
			}

		}

		$query = new WP_Query( $args );


		return $query;

	}
endif;

/**
 * Get layout columns
 *
 * @param string  $layout Layout ID
 * @return int Bootsrap col-lg ID
 * @since  1.0
 */

if ( !function_exists( 'herald_layout_columns' ) ):
	function herald_layout_columns( $layout ) {

		$layouts = array(
			'a' => 12,
			'a1' => 12,
			'a2' => 12,
			'a3' => 12,
			'b' => 12,
			'b1' => 12,
			'c' => 6,
			'c1' =>  6,
			'd' =>  6,
			'd1' =>  6,
			'e' =>  6,
			'f' =>  4,
			'f1' =>  4,
			'g' =>  4,
			'g1' =>  4,
			'h' =>  4,
			'i' =>  3,
			'i1' => 3,
			'j' =>  3,
			'k' =>  2,
			'l' => 2
		);

		return $layouts[$layout];

	}
endif;


/**
 * Check if we need to apply eq height class to specific posts module
 *
 * @param array   $module
 * @return bool
 * @since  1.3
 */

if ( !function_exists( 'herald_module_is_eq_height' ) ):
	function herald_module_is_eq_height( $module ) {

		if ( !herald_module_is_combined( $module ) ) {
			return true;
		}

		if ( ( herald_layout_columns( $module['starter_layout'] ) * $module['starter_limit'] ) % $module['columns'] ) {
			return false;
		}

		return true;

	}
endif;


/**
 * Get module css classes
 *
 * @param array   $module
 * @return string
 * @since  1.5.2
 */

if ( !function_exists( 'herald_get_module_class' ) ):
	function herald_get_module_class( $module ) {

		$class = '';

		if ( $module['type'] == 'featured' ) {
			$class = 'col-lg-12 col-md-12 col-sm-12';
		} else {
			$class = 'col-lg-' . $module['columns'] . ' col-md-' . $module['columns'] .' col-sm-' . $module['columns'];
		}

		if ( !empty( $module['css_class'] ) ) {
			$class .= ' ' . $module['css_class'];
		}

		return $class;

	}
endif;


?>
