<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package Creative Blog
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses creative_blog_header_style()
 */
function creative_blog_custom_header_setup() {
	add_theme_support('custom-header', apply_filters('creative_blog_custom_header_args', array(
		'default-image' => '',
		'default-text-color' => '0099ff',
		'width' => 1500,
		'height' => 500,
		'video' => true,
		'flex-width' => true,
		'flex-height' => true,
		'wp-head-callback' => 'creative_blog_header_style',
	)));
}

add_action('after_setup_theme', 'creative_blog_custom_header_setup');

if (!function_exists('creative_blog_header_style')) :

	/**
	 * Styles the header image and text displayed on the blog
	 *
	 * @see creative_blog_custom_header_setup().
	 */
	function creative_blog_header_style() {
		$header_text_color = get_header_textcolor();

		/**
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support('custom-header').
		 */
		if (get_theme_support('custom-header', 'default-text-color') === $header_text_color) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
// Has the text been hidden?
		if (!display_header_text()) :
			?>
				.site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
// If the user has set a custom color for the text use that.
		else :
			?>
				.site-title a,
				.site-description {
					color: #<?php echo esc_attr($header_text_color); ?>;
				}
		<?php endif; ?>
		</style>
		<?php
	}

endif; // creative_blog_header_style
