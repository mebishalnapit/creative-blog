<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Creative Blog
 */
if (!is_active_sidebar('creative-blog-footer-sidebar-one') && !is_active_sidebar('creative-blog-footer-sidebar-two') && !is_active_sidebar('creative-blog-footer-sidebar-three') && !is_active_sidebar('creative-blog-footer-sidebar-four')) {
	return;
}
?>

<div id="footer-widgets-area" class="footer-widgets">
	<div class="container">
		<div class="footer-area-one col-md-3">
			<?php
			if (is_active_sidebar('creative-blog-footer-sidebar-one')) {
				dynamic_sidebar('creative-blog-footer-sidebar-one');
			}
			?>
		</div>
		<div class="footer-area-two col-md-3">
			<?php
			if (is_active_sidebar('creative-blog-footer-sidebar-two')) {
				dynamic_sidebar('creative-blog-footer-sidebar-two');
			}
			?>
		</div>
		<div class="footer-area-three col-md-3">
			<?php
			if (is_active_sidebar('creative-blog-footer-sidebar-three')) {
				dynamic_sidebar('creative-blog-footer-sidebar-three');
			}
			?>
		</div>
		<div class="footer-area-four col-md-3">
			<?php
			if (is_active_sidebar('creative-blog-footer-sidebar-four')) {
				dynamic_sidebar('creative-blog-footer-sidebar-four');
			}
			?>
		</div>
	</div>
</div>
