<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Creative Blog
 */
get_header();
?>

<?php do_action('creative_blog_before_body_content'); ?>

<div id="primary" class="content-area col-md-8">
	<main id="main" class="site-main" role="main">

		<?php if (have_posts()) : ?>

			<header class="page-header custom-page-header">
				<h1 class="page-title"><span><?php printf(esc_html__('Search Results for: %s', 'creative-blog'), get_search_query()); ?></span></h1>
			</header><!-- .page-header -->

			<?php while (have_posts()) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part('template-parts/content', get_post_format());
				?>

			<?php endwhile; ?>

			<?php creative_blog_paginate_links_display(); ?>

		<?php else : ?>

			<?php get_template_part('template-parts/content', 'none'); ?>

		<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php creative_blog_sidebar_select(); ?>

<?php do_action('creative_blog_after_body_content'); ?>

<?php get_footer(); ?>
