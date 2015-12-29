<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Creative Blog
 */
?>

            </div><!-- #content -->

            <?php do_action('creative_blog_before_footer'); ?>
            <footer id="colophon" class="site-footer" role="contentinfo">
                <?php get_sidebar('footer'); ?>
                <div class="site-info container-fluid">
                    <?php do_action('creative_blog_footer_copyright'); ?>
                </div><!-- .site-info -->
            </footer><!-- #colophon -->
            <a href="#masthead" id="scroll-up"><i class="fa fa-arrow-up"></i></a>
        </div><!-- #page -->

        <?php wp_footer(); ?>

    </body>
</html>
