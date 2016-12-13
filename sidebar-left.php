<?php
/**
 * The sidebar containing the left widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Creative Blog
 */
?>

<aside id="secondary" class="widget-area col-md-4" role="complementary">
	<?php do_action('creative_blog_before_sidebar'); ?>

	<?php
	if (is_page_template('page-template/contact.php')) {
		$sidebar = 'creative-blog-contact-sidebar';
	} else {
		$sidebar = 'creative-blog-left-sidebar';
	}
	?>

	<?php
	if (!dynamic_sidebar($sidebar)) :
		if ($sidebar == 'creative-blog-contact-sidebar') {
			$sidebar_display_text = esc_html__('Contact Page', 'creative-blog');
		} else {
			$sidebar_display_text = esc_html__('Left', 'creative-blog');
		}

		// displaying the default widget text if no widget is associated with it
		the_widget('WP_Widget_Text', array(
			'title' => esc_html__('Example Widget', 'creative-blog'),
			'text' => sprintf(esc_html__('This is an example widget to show how the %s Sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin area. If the custom widget is added in this sidebar, then, this will be replaced by those widgets.', 'creative-blog'), $sidebar_display_text, current_user_can('edit_theme_options') ? '<a href="' . esc_url(admin_url('widgets.php')) . '">' : '', current_user_can('edit_theme_options') ? '</a>' : '' ),
			'filter' => true,
				), array(
			'before_widget' => '<section class="widget widget_text">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title"><span>',
			'after_title' => '</span></h3>'
				)
		);
	endif;
	?>

	<?php do_action('creative_blog_after_sidebar'); ?>
</aside><!-- #secondary -->
