<?php
/**
 * Displays the searchform of the theme.
 *
 * @package Creative Blog
 */

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'creative-blog' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search for&hellip;', 'creative-blog' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php esc_attr_e( 'Search for:', 'creative-blog' ); ?>" />
	</label>
	<button class="searchsubmit" name="submit" type="submit"><i class="fa fa-search"></i></button>
</form>
