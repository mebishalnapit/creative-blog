<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Creative Blog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action('creative_blog_before_post_content'); ?>

	<?php if (has_post_thumbnail()) : ?>
		<?php if (!is_single()) : ?>
			<div class="featured-image">
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('creative-blog-featured-thumb'); ?></a>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ('post' === get_post_type()) : ?>
		<div class="category-links">
			<?php creative_blog_colored_category(); ?>
		</div><!-- .entry-meta -->
	<?php endif; ?>

	<header class="entry-header">
		<?php
		if (is_single()) :
			the_title('<h1 class="entry-title">', '</h1>');
		else :
			the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>');
		endif;
		?>

		<?php if ('post' === get_post_type()) : ?>
			<div class="entry-meta">
				<?php creative_blog_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if (is_single()) :
			the_content();
		else :
			if (is_sticky()) :
				// displaying full content for the sticky post
				the_content(sprintf(
								/* translators: %s: Name of current post. */
								wp_kses('<button type="button" class="btn btn-primary continue-more-link">' . __('Read More <i class="fa fa-arrow-circle-o-right"></i>', 'creative-blog') . '</button> %s', array('span' => array('class' => array()), 'i' => array('class' => array()), 'button' => array('class' => array(), 'type' => array()))), the_title('<span class="screen-reader-text">', '</span>', false)
				));
			else :
				the_excerpt(); // displaying excerpt for the archive pages
			endif;
		endif;
		?>

		<?php
		wp_link_pages(array(
			'before' => '<div class="page-links">' . esc_html__('Pages:', 'creative-blog'),
			'after' => '</div>',
		));
		?>
	</div><!-- .entry-content -->

	<?php
	if (is_single()) :
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list('', esc_html__(', ', 'creative-blog'));
		if ($tags_list) {
			printf('<span class="tags-links"><i class="fa fa-tags"></i>' . esc_html__('%1$s', 'creative-blog') . '</span>', $tags_list); // WPCS: XSS OK.
		}
	endif;
	?>

	<?php do_action('creative_blog_after_post_content'); ?>
</article><!-- #post-## -->
