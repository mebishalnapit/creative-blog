<?php

/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Creative Blog
 */
if (!function_exists('creative_blog_posted_on')) :

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function creative_blog_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
		);

		$posted_on = sprintf(
				esc_html_x('%s', 'post date', 'creative-blog'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . '<i class="fa fa-calendar"></i>' . $time_string . '</a>'
		);

		$byline = sprintf(
				esc_html_x('%s', 'post author', 'creative-blog'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . '<i class="fa fa-user"></i>' . esc_html(get_the_author()) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

		if (!post_password_required() && ( comments_open() || get_comments_number() )) {
			echo '<span class="comments-link">';
			comments_popup_link(wp_kses(__('<i class="fa fa-comment"></i>Leave a reply', 'creative-blog'), array('i' => array('class' => array()))), wp_kses(__('<i class="fa fa-comment"></i>1 Comment', 'creative-blog'), array('i' => array('class' => array()))), wp_kses(__('<i class="fa fa-comment"></i>% Comments', 'creative-blog'), array('i' => array('class' => array()))), '', wp_kses(__('<i class="fa fa-comment"></i>Comments Disabled', 'creative-blog'), array('i' => array('class' => array()))));
			echo '</span>';
		}

		edit_post_link(
				wp_kses(sprintf(
								/* translators: %s: Name of current post */
								__('<i class="fa fa-edit"></i>Edit %s', 'creative-blog'), the_title('<span class="screen-reader-text">"', '"</span>', false)
						), array('i' => array('class' => array()), 'span' => array('class' => array()))), '<span class="edit-link">', '</span>'
		);
	}

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function creative_blog_categorized_blog() {
	if (false === ( $all_the_cool_cats = get_transient('creative_blog_categories') )) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(array(
			'fields' => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number' => 2,
		));

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count($all_the_cool_cats);

		set_transient('creative_blog_categories', $all_the_cool_cats);
	}

	if ($all_the_cool_cats > 1) {
		// This blog has more than 1 category so creative_blog_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so creative_blog_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in creative_blog_categorized_blog.
 */
function creative_blog_category_transient_flusher() {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient('creative_blog_categories');
}

add_action('edit_category', 'creative_blog_category_transient_flusher');
add_action('save_post', 'creative_blog_category_transient_flusher');
