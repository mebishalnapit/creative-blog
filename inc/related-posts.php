<?php
/**
 * Template to show the related posts of the single posts
 */
?>

<?php $related_posts = creative_blog_related_posts_function(); ?>

<?php if ($related_posts->have_posts()): ?>
	<div class="related-posts-main">

		<h3 class="related-posts-main-title"><span><?php esc_html_e('Similar Articles', 'creative-blog'); ?></span></h3>

		<div class="related-posts-total row">

			<?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
				<div class="related-posts col-xs-4">

					<?php if (has_post_thumbnail()): ?>
						<div class="related-posts-thumbnail">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail('creative-blog-featured-small'); ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="related-post-content">

						<h4 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h4><!-- .entry-title -->

						<div class="entry-meta">
							<?php creative_blog_entry_meta_custom(); ?>
						</div>

					</div>

				</div><!--.related-posts-->
			<?php endwhile; ?>

		</div><!-- .related-posts-total -->
	</div><!-- .related-posts-main -->

	<?php wp_reset_postdata(); ?>

<?php endif; ?>
