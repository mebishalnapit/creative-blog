<?php
/**
 * The template for displaying archive pages.
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

			<header class="page-header custom-page-header">
				<?php
				if (is_category()) :
					do_action('creative_blog_category_title');
					single_cat_title();
				else :
					the_archive_title('<h1 class="page-title"><span>', '</span></h1>');
				endif;
				the_archive_description('<div class="taxonomy-description">', '</div>');
				?>
			</header><!-- .page-header -->

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
