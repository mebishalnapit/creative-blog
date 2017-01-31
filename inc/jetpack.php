<?php

/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Creative Blog
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function creative_blog_jetpack_setup() {
	add_theme_support('infinite-scroll', array(
		'container' => 'main',
		'render' => 'creative_blog_infinite_scroll_render',
		'footer' => 'page',
		'wrapper' => false,
	));

	// Add theme support for Responsive Videos.
	add_theme_support('jetpack-responsive-videos');
}

// end function creative_blog_jetpack_setup
add_action('after_setup_theme', 'creative_blog_jetpack_setup');

/**
 * Custom render function for Infinite Scroll.
 */
function creative_blog_infinite_scroll_render() {
	while (have_posts()) {
		the_post();
		get_template_part('template-parts/content', get_post_format());
	}
}

// end function creative_blog_infinite_scroll_render

/**
 * Enables Jetpack's Infinite Scroll in search pages, archive pages and blog pages and disables it in WooCommerce product as well as WooCommerce archive pages
 *
 * @return bool
 */
function creative_blog_jetpack_infinite_scroll_supported() {
	return current_theme_supports('infinite-scroll') && (is_home() || is_archive() || is_search()) && !(is_post_type_archive('product') || is_tax('product_cat') || is_tax('product_tag'));
}

add_filter('infinite_scroll_archive_supported', 'creative_blog_jetpack_infinite_scroll_supported');
