<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Creative Blog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action('creative_blog_before_post_content'); ?>

	<header class="entry-header">
		<?php
		if (is_front_page()) :
			the_title('<h2 class="entry-title">', '</h2>');
		else :
			the_title('<h1 class="entry-title">', '</h1>');
		endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages(array(
			'before' => '<div class="page-links">' . esc_html__('Pages:', 'creative-blog'),
			'after' => '</div>',
		));
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		edit_post_link(
				wp_kses(sprintf(
								/* translators: %s: Name of current post */
								__('<i class="fa fa-edit"></i>Edit %s', 'creative-blog'), the_title('<span class="screen-reader-text">"', '"</span>', false)
						), array('i' => array('class' => array()), 'span' => array('class' => array()))), '<span class="edit-link">', '</span>'
		);
		?>
	</footer><!-- .entry-footer -->

	<?php do_action('creative_blog_after_post_content'); ?>
</article><!-- #post-## -->
