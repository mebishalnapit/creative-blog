<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Creative Blog
 */
get_header();
?>

<?php do_action('creative_blog_before_body_content'); ?>

<div id="primary" class="content-area col-md-8">
	<main id="main" class="site-main" role="main">

		<?php if (have_posts()) : ?>

			<?php if (is_home() && !is_front_page()) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><span><?php single_post_title(); ?></span></h1>
				</header>
			<?php endif; ?>

			<?php while (have_posts()) : the_post(); ?>

				<?php
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
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
