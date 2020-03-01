<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Creative Blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function creative_blog_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}

add_filter( 'body_class', 'creative_blog_body_classes' );

/*
 * Display the date in the header
 */
if ( ! function_exists( 'creative_blog_date_display' ) ) :

	function creative_blog_date_display() {
		?>
		<div class="date-in-header">
			<?php
			if ( get_theme_mod( 'creative_blog_date_display_type', 'theme_default' ) == 'theme_default' ) {
				echo date_i18n( 'l, F j, Y' );
			} elseif ( get_theme_mod( 'creative_blog_date_display_type', 'theme_default' ) == 'wordpress_date_setting' ) {
				echo date_i18n( get_option( 'date_format' ) );
			}
			?>
		</div>
		<?php
	}

endif;

/*
 * Breaking News/Latest Posts ticker section in the header
 */
if ( ! function_exists( 'creative_blog_breaking_news' ) ) :

	function creative_blog_breaking_news() {
		$get_featured_posts = new WP_Query(
			array(
				'posts_per_page'      => 5,
				'post_type'           => 'post',
				'ignore_sticky_posts' => true,
			)
		);
		?>
		<div class="breaking-news">
			<strong class="breaking-news-latest"><?php esc_html_e( 'Latest:', 'creative-blog' ); ?></strong>
			<ul class="newsticker">
				<?php while ( $get_featured_posts->have_posts() ):$get_featured_posts->the_post(); ?>
					<li>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_title(); ?>
						</a>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php
		// Reset Post Data
		wp_reset_query();
	}

endif;

/*
 * Creating Social Menu
 */
if ( ! function_exists( 'creative_blog_social_menu' ) ) :

	function creative_blog_social_menu() {
		if ( has_nav_menu( 'social' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'social',
					'container'       => 'div',
					'container_id'    => 'main-menu-social',
					'container_class' => 'creative-blog-social-menu',
					'depth'           => 1,
					'menu_id'         => 'menu-social',
					'fallback_cb'     => false,
					'link_before'     => '<span class="screen-reader-text">',
					'link_after'      => '</span>',
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				)
			);
		}
	}

endif;

/*
 * Adding the header logo options code
 */
if ( ! function_exists( 'creative_blog_header_text_logo' ) ) :

	function creative_blog_header_text_logo() {
		?>
		<div id="logo-and-title" class="logo-and-title col-md-4">
			<?php
			if ( function_exists( 'the_custom_logo' ) ) {
				the_custom_logo();
			}
			?>

			<div class="site-info">
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</h1>
				<?php else : ?>
					<p class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</p>
				<?php endif; ?>
				<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			</div><!-- .site-info -->
		</div>

		<?php
	}

endif;

/*
 * Category Color Options
 */
if ( ! function_exists( 'creative_blog_category_color' ) ) :

	function creative_blog_category_color( $wp_category_id ) {
		$args     = array(
			'orderby'    => 'id',
			'hide_empty' => 0,
		);
		$category = get_categories( $args );
		foreach ( $category as $category_list ) {
			$color = get_theme_mod( 'creative_blog_category_color_' . $wp_category_id );

			return $color;
		}
	}

endif;

/*
 * Category Color display
 */
if ( ! function_exists( 'creative_blog_colored_category' ) ) :

	function creative_blog_colored_category() {
		global $post;
		$categories = get_the_category();
		$separator  = '&nbsp;';
		$output     = '';
		if ( $categories ) {
			foreach ( $categories as $category ) {
				$color_code = creative_blog_category_color( get_cat_id( $category->cat_name ) );
				if ( ! empty( $color_code ) ) {
					$output .= '<a href="' . get_category_link( $category->term_id ) . '" style="background:' . creative_blog_category_color( get_cat_id( $category->cat_name ) ) . '" rel="category tag">' . $category->cat_name . '</a>' . $separator;
				} else {
					$output .= '<a href="' . get_category_link( $category->term_id ) . '"  rel="category tag">' . $category->cat_name . '</a>' . $separator;
				}
			}
			echo trim( $output, $separator );
		}
	}

endif;

/**
 * adding the hooks to filter the single category title to display the colored category title
 */
if ( ! function_exists( 'creative_blog_colored_category_title' ) ) :

	function creative_blog_colored_category_title( $title ) {
		$color_value        = creative_blog_category_color( get_cat_id( $title ) );
		$color_border_value = creative_blog_category_color( get_cat_id( $title ) );
		if ( ! empty( $color_value ) ) {
			return '<h1 class="page-title" style="border-bottom: 2px solid' . $color_border_value . '">' . '<span style="background: ' . $color_value . '">' . $title . '</span></h1>';
		} else {
			return '<h1 class="page-title"><span>' . $title . '</span></h1>';
		}
	}

endif;

/*
 * Adding the custom function to filter the category title
 */

function creative_blog_category_title_function( $category_title ) {
	add_filter( 'single_cat_title', 'creative_blog_colored_category_title' );
}

add_action( 'creative_blog_category_title', 'creative_blog_category_title_function' );

/*
 * Random Post in header
 */
if ( ! function_exists( 'creative_blog_random_post' ) ) :

	function creative_blog_random_post() {
		$get_random_post = new WP_Query(
			array(
				'posts_per_page'      => 1,
				'post_type'           => 'post',
				'ignore_sticky_posts' => true,
				'orderby'             => 'rand',
			)
		);
		?>
		<?php while ( $get_random_post->have_posts() ):$get_random_post->the_post(); ?>
			<?php return '<li class="filtered-menu"><a href="' . esc_url( get_the_permalink() ) . '" title="' . esc_html__( 'Random Post', 'creative-blog' ) . '"><i class="fa fa-random"></i></a></li>'; ?>
		<?php endwhile; ?>
		<?php
		// Reset Post Data
		wp_reset_postdata();
	}

endif;

/**
 * Filter passed to add the search and random posts options in primary menu
 */
add_filter( 'wp_nav_menu_items', 'creative_blog_menu_filter', 10, 2 );

if ( ! function_exists( 'creative_blog_menu_filter' ) ) :

	function creative_blog_menu_filter( $items, $args ) {
		// adding custom added ul
		if ( ( ( get_theme_mod( 'creative_blog_random_post_in_menu', 0 ) == 1 ) || ( get_theme_mod( 'creative_blog_search_icon_in_menu', 0 ) == 1 ) ) && $args->theme_location == 'primary' ) {
			$items .= '</ul><ul class="nav navbar-nav navbar-right">';
		}

		// adding the function to call up the random post
		if ( ( get_theme_mod( 'creative_blog_random_post_in_menu', 0 ) == 1 ) && $args->theme_location == 'primary' ) {
			$items .= creative_blog_random_post();
		}

		// showing the random post icon
		if ( ( get_theme_mod( 'creative_blog_search_icon_in_menu', 0 ) == 1 ) && $args->theme_location == 'primary' ) {
			$items .= '<li class="filtered-menu"><a class="search"><i class="fa fa-search search-top"></i></a></li>';
		}

		return $items;
	}

endif;

add_action( 'creative_blog_footer_copyright', 'creative_blog_footer_copyright', 10 );
/**
 * function to show the footer info, copyright information
 */
if ( ! function_exists( 'creative_blog_footer_copyright' ) ) :

	function creative_blog_footer_copyright() {
		$site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" ><span>' . get_bloginfo( 'name', 'display' ) . '</span></a>';

		$wp_link = '<a href="' . esc_url( 'https://wordpress.org' ) . '" target="_blank" title="' . esc_attr__( 'WordPress', 'creative-blog' ) . '"><span>' . esc_html__( 'WordPress', 'creative-blog' ) . '</span></a>';

		$my_link_name = '<a href="' . esc_url( 'https://napitwptech.com/themes/creative-blog/' ) . '" target="_blank" title="' . esc_attr__( 'Bishal Napit', 'creative-blog' ) . '"><span>' . esc_html__( 'Bishal Napit', 'creative-blog' ) . '</span></a>';

		$default_footer_value = sprintf( esc_html__( 'Copyright &copy; %1$s %2$s.', 'creative-blog' ), date( 'Y' ), $site_link ) . ' ' . sprintf( esc_html__( 'Theme: %1$s by %2$s.', 'creative-blog' ), esc_html__( 'Creative Blog', 'creative-blog' ), $my_link_name ) . ' ' . sprintf( esc_html__( 'Powered by %s.', 'creative-blog' ), $wp_link );

		$creative_blog_footer_copyright = '<div class="copyright col-md-12">' . $default_footer_value . '</div>';
		echo $creative_blog_footer_copyright;
	}

endif;

add_action( 'wp_head', 'creative_blog_custom_css', 100 );

/**
 * Hooks the Custom Internal CSS to head section
 */
function creative_blog_custom_css() {
	// changing color options
	$creative_blog_custom_options_color = '';
	$primary_color                      = get_theme_mod( 'creative_blog_primary_color', '#0099ff' );
	if ( $primary_color != '#0099ff' ) {
		$creative_blog_custom_options_color .= 'a,a:focus,a:hover{color:' . $primary_color . '}td,th,tr{border:2px solid ' . $primary_color . '}.date-in-header{background-color:' . $primary_color . '}.navigation .nav-next:after,.navigation .nav-previous:before,.newsticker a{color:' . $primary_color . '}.search-field{border:1px solid ' . $primary_color . '}.searchsubmit{background-color:' . $primary_color . '}#menu-social li a::before{color:' . $primary_color . '}.post,.search .page{border-bottom:1px solid ' . $primary_color . '}.custom-page-header .page-title{border-bottom:2px solid ' . $primary_color . '}.custom-page-header .page-title span{background:' . $primary_color . '}.continue-more-link,.continue-more-link:hover,.sticky .continue-more-link,.sticky .continue-more-link:hover{background:' . $primary_color . '}.entry-meta{border-bottom:1px dotted ' . $primary_color . ';border-top:1px dotted ' . $primary_color . '}.category-links a{background-color:' . $primary_color . '}.comments-link,.tags-links .fa{color:' . $primary_color . '}.comment-respond .form-submit input[type=submit]{background:' . $primary_color . '}.comment-author,.comments-area .comment-meta .edit-link:before{color:' . $primary_color . '}.author-box{border:1px dotted ' . $primary_color . '}.featured-image img{border:1px solid ' . $primary_color . '}.format-status .status-details{border-top:1px solid ' . $primary_color . ';border-bottom:1px solid ' . $primary_color . '}a#scroll-up i{color:' . $primary_color . '}.widget-title span{background-color:' . $primary_color . '}.widget-title{border-bottom:2px solid ' . $primary_color . '}.widget_nav_menu a,.widget_pages a,.widget_recent_comments li,.widget_recent_entries li{border-bottom:2px dotted ' . $primary_color . '}.widget_archive li:before,.widget_categories li:before,.widget_nav_menu li:before,.widget_pages li:before,.widget_recent_comments li:before,.widget_recent_entries li:before,.widget_rss li:before{color:' . $primary_color . '}.wp-caption{border:1px solid ' . $primary_color . '}input[type=submit],input[type=reset],.wp-custom-header-video-button{background-color:' . $primary_color . ';border:1px solid ' . $primary_color . '}input[type=file]{background-color:' . $primary_color . '}.content-top-sidebar{border-bottom:1px solid ' . $primary_color . '}.content-bottom-sidebar{border-top:1px solid ' . $primary_color . '}.sticky{background:' . $primary_color . '}.sticky .category-links a{color:' . $primary_color . '}.format-chat .chat-details{background-color:' . $primary_color . '}.format-link .link-details{background-color:' . $primary_color . '}.format-quote .quote-details{background-color:' . $primary_color . '}.sticky .category-links a:hover{color:' . $primary_color . '}.related-posts-main-title span{background:' . $primary_color . '}.related-posts-main-title{border-bottom:2px solid ' . $primary_color . '}';
	}

	// color change options code
	if ( ! empty( $creative_blog_custom_options_color ) ) {
		echo '<!-- ' . get_bloginfo( 'name' ) . ' Internal Styles -->';
		?>
		<style type="text/css"><?php echo esc_html( $creative_blog_custom_options_color ); ?></style>
		<?php
	}
}

/**
 * Controlling the excerpt length
 */
function creative_blog_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_length', 'creative_blog_excerpt_length' );

/**
 * Controlling the excerpt string
 */
function creative_blog_excerpt_string( $more ) {
	return '&hellip;';
}

add_filter( 'excerpt_more', 'creative_blog_excerpt_string' );

/*
 * Display the related posts
 */
if ( ! function_exists( 'creative_blog_related_posts_function' ) ) :

	function creative_blog_related_posts_function() {
		global $post;

		// Define shared post arguments
		$args = array(
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'ignore_sticky_posts'    => 1,
			'orderby'                => 'rand',
			'post__not_in'           => array( $post->ID ),
			'posts_per_page'         => 3,
		);

		// Related by categories
		if ( get_theme_mod( 'creative_blog_related_posts', 'categories' ) == 'categories' ) {
			$cats                 = wp_get_post_categories( $post->ID, array( 'fields' => 'ids' ) );
			$args['category__in'] = $cats;
		}

		// Related by tags
		if ( get_theme_mod( 'creative_blog_related_posts', 'categories' ) == 'tags' ) {
			$tags            = wp_get_post_tags( $post->ID, array( 'fields' => 'ids' ) );
			$args['tag__in'] = $tags;

			// If no tags added, return
			if ( ! $tags ) {
				$break = true;
			}
		}

		$query = ! isset( $break ) ? new WP_Query( $args ) : new WP_Query;

		return $query;
	}

endif;

/*
 * posts pagnation
 */
if ( ! function_exists( 'creative_blog_posts_pagination' ) ) :

	function creative_blog_posts_pagination() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<h4 class="screen-reader-text"><?php esc_html_e( 'Post navigation', 'creative-blog' ); ?></h4>
		<ul class="pager single-post-navigations">
			<?php
			previous_post_link( '<li class="previous">%link</li>', _x( '<span class="meta-nav"><i class="fa fa-arrow-circle-o-left"></i></span>%title', 'Previous post link', 'creative-blog' ) );
			next_post_link( '<li class="next">%link</li>', _x( '%title<span class="meta-nav"><i class="fa fa-arrow-circle-o-right"></i></span>', 'Next post link', 'creative-blog' ) );
			?>
		</ul><!-- .nav-links -->
		<?php
	}

endif;

add_filter( 'body_class', 'creative_blog_body_class' );

/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function creative_blog_body_class( $classes ) {

	// custom layout options for posts and pages
	global $post;

	if ( $post ) {
		$creative_blog_layout_meta = get_post_meta( $post->ID, 'creative_blog_page_layout', true );
	}

	if ( is_home() ) {
		$queried_id                = get_option( 'page_for_posts' );
		$creative_blog_layout_meta = get_post_meta( $queried_id, 'creative_blog_page_layout', true );
	}

	if ( empty( $creative_blog_layout_meta ) || is_archive() || is_search() || is_404() ) {
		$creative_blog_layout_meta = 'default_layout';
	}

	$creative_blog_default_layout      = get_theme_mod( 'creative_blog_default_layout', 'right_sidebar' );
	$creative_blog_default_page_layout = get_theme_mod( 'creative_blog_default_page_layout', 'right_sidebar' );
	$creative_blog_default_post_layout = get_theme_mod( 'creative_blog_default_single_posts_layout', 'right_sidebar' );

	if ( $creative_blog_layout_meta == 'default_layout' ) {
		if ( is_page() ) {
			if ( $creative_blog_default_page_layout == 'right_sidebar' ) {
				$classes[] = 'right-sidebar';
			} elseif ( $creative_blog_default_page_layout == 'left_sidebar' ) {
				$classes[] = 'left-sidebar';
			} elseif ( $creative_blog_default_page_layout == 'no_sidebar_full_width' ) {
				$classes[] = 'no-sidebar-full-width';
			} elseif ( $creative_blog_default_page_layout == 'no_sidebar_content_centered' ) {
				$classes[] = 'no-sidebar-content-centered';
			}
		} elseif ( is_single() ) {
			if ( $creative_blog_default_post_layout == 'right_sidebar' ) {
				$classes[] = 'right-sidebar';
			} elseif ( $creative_blog_default_post_layout == 'left_sidebar' ) {
				$classes[] = 'left-sidebar';
			} elseif ( $creative_blog_default_post_layout == 'no_sidebar_full_width' ) {
				$classes[] = 'no-sidebar-full-width';
			} elseif ( $creative_blog_default_post_layout == 'no_sidebar_content_centered' ) {
				$classes[] = 'no-sidebar-content-centered';
			}
		} elseif ( $creative_blog_default_layout == 'right_sidebar' ) {
			$classes[] = 'right-sidebar';
		} elseif ( $creative_blog_default_layout == 'left_sidebar' ) {
			$classes[] = 'left-sidebar';
		} elseif ( $creative_blog_default_layout == 'no_sidebar_full_width' ) {
			$classes[] = 'no-sidebar-full-width';
		} elseif ( $creative_blog_default_layout == 'no_sidebar_content_centered' ) {
			$classes[] = 'no-sidebar-content-centered';
		}
	} elseif ( $creative_blog_layout_meta == 'right_sidebar' ) {
		$classes[] = 'right-sidebar';
	} elseif ( $creative_blog_layout_meta == 'left_sidebar' ) {
		$classes[] = 'left-sidebar';
	} elseif ( $creative_blog_layout_meta == 'no_sidebar_full_width' ) {
		$classes[] = 'no-sidebar-full-width';
	} elseif ( $creative_blog_layout_meta == 'no_sidebar_content_centered' ) {
		$classes[] = 'no-sidebar-content-centered';
	}

	// custom layout option for site
	if ( get_theme_mod( 'creative_blog_site_layout', 'wide_layout' ) == 'wide_layout' ) {
		$classes[] = 'wide';
	} elseif ( get_theme_mod( 'creative_blog_site_layout', 'wide_layout' ) == 'boxed_layout' ) {
		$classes[] = 'boxed';
	}

	return $classes;
}

/*
 * function to display the sidebar according to layout choosed
 */
if ( ! function_exists( 'creative_blog_sidebar_select' ) ) :

	function creative_blog_sidebar_select() {
		global $post;

		if ( $post ) {
			$creative_blog_layout_meta = get_post_meta( $post->ID, 'creative_blog_page_layout', true );
		}

		if ( is_home() ) {
			$queried_id                = get_option( 'page_for_posts' );
			$creative_blog_layout_meta = get_post_meta( $queried_id, 'creative_blog_page_layout', true );
		}

		if ( empty( $creative_blog_layout_meta ) || is_archive() || is_search() || is_404() ) {
			$creative_blog_layout_meta = 'default_layout';
		}

		$creative_blog_default_layout      = get_theme_mod( 'creative_blog_default_layout', 'right_sidebar' );
		$creative_blog_default_page_layout = get_theme_mod( 'creative_blog_default_page_layout', 'right_sidebar' );
		$creative_blog_default_post_layout = get_theme_mod( 'creative_blog_default_single_posts_layout', 'right_sidebar' );

		if ( $creative_blog_layout_meta == 'default_layout' ) {
			if ( is_page() ) {
				if ( $creative_blog_default_page_layout == 'right_sidebar' ) {
					get_sidebar();
				} elseif ( $creative_blog_default_page_layout == 'left_sidebar' ) {
					get_sidebar( 'left' );
				}
			} elseif ( is_single() ) {
				if ( $creative_blog_default_post_layout == 'right_sidebar' ) {
					get_sidebar();
				} elseif ( $creative_blog_default_post_layout == 'left_sidebar' ) {
					get_sidebar( 'left' );
				}
			} elseif ( $creative_blog_default_layout == 'right_sidebar' ) {
				get_sidebar();
			} elseif ( $creative_blog_default_layout == 'left_sidebar' ) {
				get_sidebar( 'left' );
			}
		} elseif ( $creative_blog_layout_meta == 'right_sidebar' ) {
			get_sidebar();
		} elseif ( $creative_blog_layout_meta == 'left_sidebar' ) {
			get_sidebar( 'left' );
		}
	}

endif;

/**
 * functon for dsplaying the custom meta data
 */
if ( ! function_exists( 'creative_blog_entry_meta_custom' ) ) :

	function creative_blog_entry_meta_custom() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string, esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ), esc_attr( get_the_modified_date( 'c' ) ), esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( '%s', 'post date', 'creative-blog' ), '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . '<i class="fa fa-calendar"></i>' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( '%s', 'post author', 'creative-blog' ), '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . '<i class="fa fa-user"></i>' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

		echo '<span class="comments-link">';
		comments_popup_link( wp_kses( __( '<i class="fa fa-comment"></i>Leave a reply', 'creative-blog' ), array( 'i' => array( 'class' => array() ) ) ), wp_kses( __( '<i class="fa fa-comment"></i>1 Comment', 'creative-blog' ), array( 'i' => array( 'class' => array() ) ) ), wp_kses( __( '<i class="fa fa-comment"></i>% Comments', 'creative-blog' ), array( 'i' => array( 'class' => array() ) ) ), '', wp_kses( __( '<i class="fa fa-comment"></i>Comments Disabled', 'creative-blog' ), array( 'i' => array( 'class' => array() ) ) ) );
		echo '</span>';
	}

endif;

/**
 * function to add the social links in the Author Bio section
 */
if ( ! function_exists( 'creative_blog_author_bio_links' ) ) :

	function creative_blog_author_bio_links() {
		$author_name = get_the_author_meta( 'display_name' );

		// pulling the author social links url which are provided through WordPress SEO and All In One SEO Pack plugin
		$author_facebook_link   = get_the_author_meta( 'facebook' );
		$author_twitter_link    = get_the_author_meta( 'twitter' );
		$author_googleplus_link = get_the_author_meta( 'googleplus' );

		if ( $author_twitter_link || $author_googleplus_link || $author_facebook_link ) {
			echo '<div class="author-social-links">';
			printf( esc_html__( 'Follow %s on:', 'creative-blog' ), $author_name );
			if ( $author_facebook_link ) {
				echo '<a href="' . esc_url( $author_facebook_link ) . '" title="' . esc_html__( 'Facebook', 'creative-blog' ) . '" target="_blank"><i class="fa fa-facebook"></i><span class="screen-reader-text">' . esc_html__( 'Facebook', 'creative-blog' ) . '</span></a>';
			}
			if ( $author_twitter_link ) {
				echo '<a href="https://twitter.com/' . esc_attr( $author_twitter_link ) . '" title="' . esc_html__( 'Twitter', 'creative-blog' ) . '" target="_blank"><i class="fa fa-twitter"></i><span class="screen-reader-text">' . esc_html__( 'Twitter', 'creative-blog' ) . '</span></a>';
			}
			if ( $author_googleplus_link ) {
				echo '<a href="' . esc_url( $author_googleplus_link ) . '" title="' . esc_html__( 'Google Plus', 'creative-blog' ) . '" rel="author" target="_blank"><i class="fa fa-google-plus"></i><span class="screen-reader-text">' . esc_html__( 'Google Plus', 'creative-blog' ) . '</span></a>';
			}
			echo '</div>';
		}
	}

endif;

// link post format support added
if ( ! function_exists( 'creative_blog_link_post_format' ) ) :

	function creative_blog_link_post_format() {
		if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) ) {
			return false;
		}

		return esc_url_raw( $matches[1] );
	}

endif;

// audio and video post format support added
if ( ! function_exists( 'creative_blog_audio_video_post_format' ) ) :

	function creative_blog_audio_video_post_format() {
		$document = new DOMDocument();
		$content  = apply_filters( 'the_content', get_the_content( '', true ) );
		if ( '' != $content ) {
			libxml_use_internal_errors( true );
			$document->loadHTML( $content );
			libxml_clear_errors();
			$iframes  = $document->getElementsByTagName( 'iframe' );
			$objects  = $document->getElementsByTagName( 'object' );
			$embeds   = $document->getElementsByTagName( 'embed' );
			$document = new DOMDocument();
			if ( $iframes->length ) {
				$iframe = $iframes->item( $iframes->length - 1 );
				$document->appendChild( $document->importNode( $iframe, true ) );
			} elseif ( $objects->length ) {
				$object = $objects->item( $objects->length - 1 );
				$document->appendChild( $document->importNode( $object, true ) );
			} elseif ( $embeds->length ) {
				$embed = $embeds->item( $embeds->length - 1 );
				$document->appendChild( $document->importNode( $embed, true ) );
			}

			return wpautop( $document->saveHTML() );
		}

		return false;
	}

endif;

// status post format support added
if ( ! function_exists( 'creative_blog_status_post_format_first_paragraph' ) ) :

	function creative_blog_status_post_format_first_paragraph() {
		$first_paragraph_str = wpautop( get_the_content() );
		$first_paragraph_str = substr( $first_paragraph_str, 0, strpos( $first_paragraph_str, '</p>' ) + 4 );
		$first_paragraph_str = strip_tags( $first_paragraph_str, '<a><strong><em>' );

		return '<p>' . $first_paragraph_str . '</p>';
	}

endif;

if ( ! function_exists( 'creative_blog_status_post_format_avatar_image' ) ) :

	function creative_blog_status_post_format_avatar_image() {
		return get_avatar( get_the_author_meta( 'user_email' ), '75' );
	}

endif;

// quote post format support added
if ( ! function_exists( 'creative_blog_quote_post_format_blockquote' ) ) :

	function creative_blog_quote_post_format_blockquote() {

		$document = new DOMDocument();
		$content  = apply_filters( 'the_content', get_the_content( '', true ) );
		$output   = '';
		if ( '' != $content ) {
			libxml_use_internal_errors( true );
			$document->loadHTML( mb_convert_encoding( $content, 'html-entities', 'utf-8' ) );
			libxml_clear_errors();
			$blockquotes = $document->getElementsByTagName( 'blockquote' );
			if ( $blockquotes->length ) {
				$blockquote = $blockquotes->item( 0 );
				$document   = new DOMDocument();
				$document->appendChild( $document->importNode( $blockquote, true ) );
				$output .= $document->saveHTML();
			}
		}

		return wpautop( $output );
	}

endif;

if ( ! function_exists( 'creative_blog_paginate_links' ) ) :

	function creative_blog_paginate_links() {
		?>
		<div class="post-nav">
			<?php
			global $wp_query;
			$big        = 999999999; // need an unlikely integer
			$pagination = paginate_links(
				array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'current'   => max( 1, absint( get_query_var( 'paged' ) ) ),
					'total'     => $wp_query->max_num_pages,
					'mid_size'  => 4,
					'type'      => 'array',
					'prev_text' => wp_kses( __( '<i class="glyphicon glyphicon-chevron-left"></i>', 'creative-blog' ), array( 'i' => array( 'class' => array() ) ) ),
					'next_text' => wp_kses( __( '<i class="glyphicon glyphicon-chevron-right"></i>', 'creative-blog' ), array( 'i' => array( 'class' => array() ) ) ),
				)
			);
			?>

			<?php if ( ! empty( $pagination ) ) : ?>
				<h4 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'creative-blog' ); ?></h4>
				<ul class="pager">
					<?php foreach ( $pagination as $key => $page_link ) : ?>
						<li<?php
						if ( strpos( $page_link, 'current' ) !== false ) {
							echo ' class="active"';
						}
						?>><?php echo wp_kses_post( $page_link ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
		<?php
	}

endif;

function creative_blog_paginate_links_display() {
	echo creative_blog_paginate_links();
}

/**
 * Migrate any existing theme CSS codes added in Customize Options to the core option added in WordPress 4.7
 */
function creative_blog_custom_css_migrate() {
	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		$custom_css = get_theme_mod( 'creative_blog_custom_css' );
		if ( $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return   = wp_update_custom_css_post( $core_css . $custom_css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'creative_blog_custom_css' );
			}
		}
	}
}

add_action( 'after_setup_theme', 'creative_blog_custom_css_migrate' );

/**
 * Make theme WooCommerce plugin compatible
 */
// Remove WooCommerce default wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
// Remove WooCommerce default sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
// Remove WooCommerce Breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// Add theme wrapper for WooCommerce pages
add_action( 'woocommerce_before_main_content', 'creative_blog_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'creative_blog_wrapper_end', 10 );

function creative_blog_wrapper_start() {
	echo '<div id="primary" class="content-area col-md-8"><main id="main" class="site-main" role="main">';
}

function creative_blog_wrapper_end() {
	echo '</main></div><!-- #primary -->';
	creative_blog_sidebar_select();
}

if ( ! function_exists( 'creative_blog_pingback_header' ) ) :

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function creative_blog_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

endif;

add_action( 'wp_head', 'creative_blog_pingback_header' );
