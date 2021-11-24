<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Creative Blog
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'creative_blog_before' ); ?>

<?php
/**
 * WordPress function to load custom scripts after body.
 *
 * Introduced in WordPress 5.2.0
 */
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else {
	do_action( 'wp_body_open' );
}
?>

<div id="page" class="site">
	<?php do_action( 'creative_blog_before_header' ); ?>
	<a class="skip-link screen-reader-text" href="#content">
		<?php esc_html_e( 'Skip to content', 'creative-blog' ); ?>
	</a>

	<header id="masthead" class="site-header" role="banner">

		<?php if ( ( get_theme_mod( 'creative_blog_date_display', 0 ) == 1 ) || ( get_theme_mod( 'creative_blog_breaking_news', 0 ) == 1 ) || has_nav_menu( 'social' ) ) : ?>
			<div class="header-top-area">
				<div class="container">
					<?php if ( ( get_theme_mod( 'creative_blog_date_display', 0 ) == 1 ) || ( get_theme_mod( 'creative_blog_breaking_news', 0 ) == 1 ) ) { ?>
						<div id="date-latest" class="header-left-area col-md-8">
							<?php
							// Date display option.
							if ( get_theme_mod( 'creative_blog_date_display', 0 ) == 1 ) {
								creative_blog_date_display();
							}

							// Breaking news display section.
							if ( get_theme_mod( 'creative_blog_breaking_news', 0 ) == 1 ) {
								creative_blog_breaking_news();
							}
							?>
						</div>
					<?php } ?>

					<div id="social-menu" class="header-right-area col-md-4">
						<?php creative_blog_social_menu(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="site-branding">
			<div class="container">
				<?php
				// Function to display the header text/logo.
				creative_blog_header_text_logo();
				?>

				<div id="header-sidebar" class="sidebar-header col-md-8">
					<?php
					if ( is_active_sidebar( 'creative-blog-header-sidebar' ) ) {
						dynamic_sidebar( 'creative-blog-header-sidebar' );
					}
					?>
				</div>
			</div>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation navbar navbar-inverse" role="navigation">
			<div class="container">

				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'creative-blog' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container'       => 'div',
						'depth'           => 2,
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'navbar',
						'menu_class'      => 'nav navbar-nav',
						'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
						'walker'          => new wp_bootstrap_navwalker(),
					)
				);
				?>

			</div>

			<?php if ( get_theme_mod( 'creative_blog_search_icon_in_menu', 0 ) == 1 ) : ?>
				<div class="search-form-top">
					<div class="container">
						<?php get_search_form(); ?>
					</div>
				</div>
			<?php endif; ?>

		</nav><!-- #site-navigation -->

	</header><!-- #masthead -->

	<?php if ( get_header_image() || ( function_exists( 'the_custom_header_markup' ) ) ) : ?>
		<div class="creative-blog-header-image">
			<?php if ( ( get_theme_mod( 'creative_blog_header_image_link', 0 ) == 1 ) && ( ( function_exists( 'the_custom_header_markup' ) && ( ! is_header_video_active() || ! has_header_video() ) ) || ( ! function_exists( 'the_custom_header_markup' ) ) ) ) { ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php
			}

			// Display the header video and header image.
			if ( function_exists( 'the_custom_header_markup' ) ) :
				the_custom_header_markup();
			else :
				the_header_image_tag();
			endif;

			if ( ( get_theme_mod( 'creative_blog_header_image_link', 0 ) == 1 ) && ( ( function_exists( 'the_custom_header_markup' ) && ( ! is_header_video_active() || ! has_header_video() ) ) || ( ! function_exists( 'the_custom_header_markup' ) ) ) ) {
			?>
				</a>
			<?php } ?>
		</div>
	<?php endif; // End header image check. ?>

	<?php
	if ( ! is_front_page() && ( function_exists( 'bcn_display' ) || function_exists( 'yoast_breadcrumb' ) || function_exists( 'rank_math_the_breadcrumbs' ) ) ) :

		if ( function_exists( 'bcn_display' ) ) :
			// Display the Breadcrumb NavXT plugin's breadcrumb.
			?>
			<div class="breadcrumbs-area">
				<div class="container">
					<div class="breadcrumbs col-md-12" typeof="BreadcrumbList" vocab="https://schema.org/">
						<?php bcn_display(); ?>
					</div>
				</div>
			</div>
			<?php
		elseif ( function_exists( 'yoast_breadcrumb' ) ) :
			// Display the Yoast SEO plugin's breadcrumb.
			yoast_breadcrumb(
				'<div class="breadcrumbs-area"><div class="container"><div class="breadcrumbs col-md-12">',
				'</div></div></div>'
			);
		elseif ( function_exists( 'rank_math_the_breadcrumbs' ) ) :
			// Display the Rank Math SEO plugin's breadcrumb.
			rank_math_the_breadcrumbs(
				array(
					'wrap_before' => '<div class="breadcrumbs-area"><div class="container"><div class="breadcrumbs col-md-12">',
					'wrap_after'  => '</div></div></div>',
				)
			);
		endif;

	endif;
	?>

	<?php do_action( 'creative_blog_after_header' ); ?>
	<?php do_action( 'creative_blog_before_main' ); ?>

	<?php if ( is_active_sidebar( 'creative-blog-content-top-sidebar' ) ) { ?>
		<div class="content-top-sidebar">
			<div class="container">
				<?php dynamic_sidebar( 'creative-blog-content-top-sidebar' ); ?>
			</div>
		</div>
	<?php } ?>

	<div id="content" class="site-content">
		<div class="container">
