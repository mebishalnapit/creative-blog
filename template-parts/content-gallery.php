<?php
/**
 * Template part for displaying the gallery post format.
 *
 * @package Creative Blog
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action('creative_blog_before_post_content'); ?>

	<?php if (get_post_gallery()) : ?>
		<div id="gallery-carousel" class="carousel slide" data-ride="carousel">
			<?php
			$output = '';
			$galleries = get_post_gallery($post, false);
			$attachment_ids = explode(",", $galleries['ids']);
			$output = '<div class="carousel-inner" role="listbox">';
			$i = 1;
			foreach ($attachment_ids as $attachment_id) {
				if ($i == 1) {
					$active_class = 'active';
				} else {
					$active_class = '';
				}
				// displaying the attached image of gallery
				$link = wp_get_attachment_image($attachment_id, 'creative-blog-featured');
				$output .= '<div class="item ' . esc_attr($active_class) . '">' . $link . '</div>';
				$i++;
			}
			$output .= '</div>';
			echo $output;
			?>
			<!-- Controls -->
			<a class="left carousel-control" href="#gallery-carousel" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only"><?php esc_html__('Previous', 'creative-blog'); ?></span>
			</a>
			<a class="right carousel-control" href="#gallery-carousel" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only"><?php esc_html__('Next', 'creative-blog'); ?></span>
			</a>
		</div>
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
