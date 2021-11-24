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

				</div><!-- .container -->
			</div><!-- #content -->

			<?php if ( is_active_sidebar( 'creative-blog-content-bottom-sidebar' ) ) { ?>
				<div class="content-bottom-sidebar">
					<div class="container ">
						<?php dynamic_sidebar( 'creative-blog-content-bottom-sidebar' ); ?>
					</div>
				</div>
			<?php } ?>

			<?php do_action( 'creative_blog_before_footer' ); ?>
			<footer id="colophon" class="site-footer" role="contentinfo">
				<?php get_sidebar( 'footer' ); ?>

				<div class="site-info">
					<div class="container">
						<?php do_action( 'creative_blog_footer_copyright' ); ?>
					</div>
				</div><!-- .site-info -->
			</footer><!-- #colophon -->

			<a href="#masthead" id="scroll-up"><i class="fa fa-arrow-up"></i></a>
			<?php do_action( 'creative_blog_after_footer' ); ?>
		</div><!-- #page -->

		<?php wp_footer(); ?>

	</body>
</html>
