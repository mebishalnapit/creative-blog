<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Creative Blog
 */
get_header();
?>

<?php do_action('creative_blog_before_body_content'); ?>

<?php creative_blog_left_sidebar_select(); ?>

<div id="primary" class="content-area <?php creative_blog_layout_class(); ?>">
    <main id="main" class="site-main" role="main">

        <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part('template-parts/content', get_post_format()); ?>

            <?php
            if (function_exists('creative_blog_posts_pagination')) {
                creative_blog_posts_pagination();
            } else {
                the_post_navigation();
            }
            ?>

            <?php if (get_the_author_meta('description')) : ?>
                <div class="author-box">
                    <div class="author-img"><?php echo get_avatar(get_the_author_meta('user_email'), '100'); ?></div>
                    <h4 class="author-name"><?php the_author_meta('display_name'); ?></h4>
                    <p class="author-description"><?php the_author_meta('description'); ?></p>
                </div>
            <?php endif; ?>

            <?php
            if (get_theme_mod('creative_blog_related_posts_activate', 0) == 1)
                get_template_part('inc/related-posts');
            ?>

            <?php
            do_action('creative_blog_before_comments_template');
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; // End of the loop.   ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php creative_blog_right_sidebar_select(); ?>

<?php do_action('creative_blog_after_body_content'); ?>

<?php get_footer(); ?>
