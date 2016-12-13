<?php
/**
 * Template part for displaying the chat post format.
 *
 * @package Creative Blog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action('creative_blog_before_post_content'); ?>

	<div class="chat-details">
		<?php the_content(); ?>
	</div>

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
			the_excerpt();
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
