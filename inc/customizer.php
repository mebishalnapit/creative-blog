<?php
/**
 * Creative Blog Theme Customizer.
 *
 * @package Creative Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function creative_blog_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// extending Customizer Class to add the theme important links
	class Creative_Blog_Important_Links extends WP_Customize_Control {

		public $type = "creative-blog-important-links";

		public function render_content() {
			$important_links = array(
				'theme-info'    => array(
					'link' => esc_url( 'https://napitwptech.com/themes/creative-blog/' ),
					'text' => esc_html__( 'View Theme Info', 'creative-blog' ),
				),
				'documentation' => array(
					'link' => esc_url( 'https://napitwptech.com/themes/creative-blog/creative-blog-wordpress-theme-documentation/' ),
					'text' => esc_html__( 'Theme Documentation', 'creative-blog' ),
				),
				'demo'          => array(
					'link' => esc_url( 'https://demo.napitwptech.com/creative-blog/' ),
					'text' => esc_html__( 'View Theme Demo', 'creative-blog' ),
				),
				'contact'       => array(
					'link' => esc_url( 'https://napitwptech.com/contact-us/' ),
					'text' => esc_html__( 'Contact Us', 'creative-blog' ),
				),
				'forum'         => array(
					'link' => esc_url( 'https://support.napitwptech.com/forums/forum/creative-blog/' ),
					'text' => esc_html__( 'Support Forum', 'creative-blog' ),
				),
				'rating'        => array(
					'link' => esc_url( 'https://wordpress.org/support/theme/creative-blog/reviews/' ),
					'text' => esc_html__( 'Rate This Theme', 'creative-blog' ),
				),
			);
			foreach ( $important_links as $important_link ) {
				echo '<p><a target="_blank" href="' . esc_url( $important_link['link'] ) . '" >' . esc_attr( $important_link['text'] ) . ' </a></p>';
			}
		}

	}

	// adding section for the theme important links
	$wp_customize->add_section( 'creative_blog_important_links_section', array(
		'priority' => 1,
		'title'    => esc_html__( 'Theme Important Links', 'creative-blog' ),
	) );

	// adding setting for the theme important links
	$wp_customize->add_setting( 'creative_blog_important_links', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_important_links_sanitize',
	) );

	// adding control for the theme important links
	$wp_customize->add_control( new Creative_Blog_Important_Links( $wp_customize, 'creative_blog_important_links', array(
		'section' => 'creative_blog_important_links_section',
		'setting' => 'creative_blog_important_links',
	) ) );

	// Start Of Header Options
	$wp_customize->add_panel( 'creative_blog_header_options', array(
		'capabitity'  => 'edit_theme_options',
		'description' => esc_html__( 'Change the Header Settings from here as you want to best suit your need.', 'creative-blog' ),
		'priority'    => 500,
		'title'       => esc_html__( 'Header Options', 'creative-blog' ),
	) );

	// date display enable/disable
	$wp_customize->add_section( 'creative_blog_date_display_section', array(
		'priority' => 2,
		'title'    => esc_html__( 'Show Date', 'creative-blog' ),
		'panel'    => 'creative_blog_header_options',
	) );

	$wp_customize->add_setting( 'creative_blog_date_display', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_date_display', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to show the date in header area.', 'creative-blog' ),
		'section'  => 'creative_blog_date_display_section',
		'settings' => 'creative_blog_date_display',
	) );

	// date in header display type
	$wp_customize->add_setting( 'creative_blog_date_display_type', array(
		'default'           => 'theme_default',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_radio_select_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_date_display_type', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Date in header display type:', 'creative-blog' ),
		'choices'  => array(
			'theme_default'          => esc_html__( 'Theme Default Setting', 'creative-blog' ),
			'wordpress_date_setting' => esc_html__( 'WordPress General Date Setting', 'creative-blog' ),
		),
		'section'  => 'creative_blog_date_display_section',
		'settings' => 'creative_blog_date_display_type',
	) );

	// breaking news enable/disable
	$wp_customize->add_section( 'creative_blog_breaking_news_section', array(
		'priority' => 3,
		'title'    => esc_html__( 'Breaking News', 'creative-blog' ),
		'panel'    => 'creative_blog_header_options',
	) );

	$wp_customize->add_setting( 'creative_blog_breaking_news', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_breaking_news', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to enable the breaking news section.', 'creative-blog' ),
		'section'  => 'creative_blog_breaking_news_section',
		'settings' => 'creative_blog_breaking_news',
	) );

	// sticky menu enable/disable
	$wp_customize->add_section( 'creative_blog_sticky_menu_section', array(
		'priority' => 4,
		'title'    => esc_html__( 'Sticky Menu', 'creative-blog' ),
		'panel'    => 'creative_blog_header_options',
	) );

	$wp_customize->add_setting( 'creative_blog_sticky_menu', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_sticky_menu', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to enable the sticky menu feature. Note: This feature is only applied to the primary menu.', 'creative-blog' ),
		'section'  => 'creative_blog_sticky_menu_section',
		'settings' => 'creative_blog_sticky_menu',
	) );

	// random posts in menu enable/disable
	$wp_customize->add_section( 'creative_blog_random_post_in_menu_section', array(
		'priority' => 5,
		'title'    => esc_html__( 'Random Post', 'creative-blog' ),
		'panel'    => 'creative_blog_header_options',
	) );

	$wp_customize->add_setting( 'creative_blog_random_post_in_menu', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_random_post_in_menu', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to display the random post icon in the primary menu. Note: Only works when you have set the primary menu manually.', 'creative-blog' ),
		'section'  => 'creative_blog_random_post_in_menu_section',
		'settings' => 'creative_blog_random_post_in_menu',
	) );

	// search icon in menu enable/disable
	$wp_customize->add_section( 'creative_blog_search_icon_in_menu_section', array(
		'priority' => 6,
		'title'    => esc_html__( 'Search Icon', 'creative-blog' ),
		'panel'    => 'creative_blog_header_options',
	) );

	$wp_customize->add_setting( 'creative_blog_search_icon_in_menu', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_search_icon_in_menu', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to display the search icon in the primary menu. Note: Only works when you have set the primary menu manually.', 'creative-blog' ),
		'section'  => 'creative_blog_search_icon_in_menu_section',
		'settings' => 'creative_blog_search_icon_in_menu',
	) );
	// End Of Header Options
	// Start Of Design Options
	$wp_customize->add_panel( 'creative_blog_design_options', array(
		'capabitity'  => 'edit_theme_options',
		'description' => esc_html__( 'Change the Design Settings from here as you want to best suit your need.', 'creative-blog' ),
		'priority'    => 505,
		'title'       => esc_html__( 'Design Options', 'creative-blog' ),
	) );

	// site layout setting
	$wp_customize->add_section( 'creative_blog_site_layout_setting', array(
		'priority' => 1,
		'title'    => esc_html__( 'Site Layout', 'creative-blog' ),
		'panel'    => 'creative_blog_design_options',
	) );

	$wp_customize->add_setting( 'creative_blog_site_layout', array(
		'default'           => 'wide_layout',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_radio_select_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_site_layout', array(
		'type'    => 'radio',
		'label'   => esc_html__( 'Choose your site layout. The change is reflected in the whole site.', 'creative-blog' ),
		'choices' => array(
			'boxed_layout' => esc_html__( 'Boxed Layout', 'creative-blog' ),
			'wide_layout'  => esc_html__( 'Wide Layout', 'creative-blog' ),
		),
		'section' => 'creative_blog_site_layout_setting',
	) );

	// layout option
	class Creative_Blog_Image_Radio_Control extends WP_Customize_Control {

		public function render_content() {

			if ( empty( $this->choices ) ) {
				return;
			}

			$name = '_customize-radio-' . $this->id;
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul class="controls" id='creative-blog-img-container'>
				<?php
				foreach ( $this->choices as $value => $label ) :
					$class = ( $this->value() == $value ) ? 'creative-blog-radio-img-selected creative-blog-radio-img-img' : 'creative-blog-radio-img-img';
					?>
					<li style="display: inline;">
						<label>
							<input <?php $this->link(); ?>style='display:none'
							       type="radio"
							       value="<?php echo esc_attr( $value ); ?>"
							       name="<?php echo esc_attr( $name ); ?>" <?php
							$this->link();
							checked( $this->value(), $value );
							?> />
							<img src='<?php echo esc_html( $label ); ?>' class='<?php echo esc_html( $class ); ?>' />
						</label>
						<?php
						$replace_text = str_replace( "_", " ", $value );
						$display_text = ucwords( $replace_text );
						echo esc_html( $display_text );
						?>
					</li>
				<?php
				endforeach;
				?>
			</ul>
			<?php
		}

	}

	// default layout setting
	$wp_customize->add_section( 'creative_blog_default_layout_setting', array(
		'priority' => 2,
		'title'    => esc_html__( 'Default layout', 'creative-blog' ),
		'panel'    => 'creative_blog_design_options',
	) );

	$wp_customize->add_setting( 'creative_blog_default_layout', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_radio_select_sanitize',
	) );

	$wp_customize->add_control( new Creative_Blog_Image_Radio_Control( $wp_customize, 'creative_blog_default_layout', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from the other options available in this theme.', 'creative-blog' ),
		'section'  => 'creative_blog_default_layout_setting',
		'settings' => 'creative_blog_default_layout',
		'choices'  => array(
			'right_sidebar'               => get_template_directory_uri() . '/img/right-sidebar.png',
			'left_sidebar'                => get_template_directory_uri() . '/img/left-sidebar.png',
			'no_sidebar_full_width'       => get_template_directory_uri() . '/img/no-sidebar-full-width-layout.png',
			'no_sidebar_content_centered' => get_template_directory_uri() . '/img/no-sidebar-content-centered-layout.png',
		),
	) ) );

	// default layout for pages
	$wp_customize->add_section( 'creative_blog_default_page_layout_setting', array(
		'priority' => 3,
		'title'    => esc_html__( 'Default layout for pages only', 'creative-blog' ),
		'panel'    => 'creative_blog_design_options',
	) );

	$wp_customize->add_setting( 'creative_blog_default_page_layout', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_radio_select_sanitize',
	) );

	$wp_customize->add_control( new Creative_Blog_Image_Radio_Control( $wp_customize, 'creative_blog_default_page_layout', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for the specific page.', 'creative-blog' ),
		'section'  => 'creative_blog_default_page_layout_setting',
		'settings' => 'creative_blog_default_page_layout',
		'choices'  => array(
			'right_sidebar'               => get_template_directory_uri() . '/img/right-sidebar.png',
			'left_sidebar'                => get_template_directory_uri() . '/img/left-sidebar.png',
			'no_sidebar_full_width'       => get_template_directory_uri() . '/img/no-sidebar-full-width-layout.png',
			'no_sidebar_content_centered' => get_template_directory_uri() . '/img/no-sidebar-content-centered-layout.png',
		),
	) ) );

	// default layout for single posts
	$wp_customize->add_section( 'creative_blog_default_single_posts_layout_setting', array(
		'priority' => 4,
		'title'    => esc_html__( 'Default layout for single posts only', 'creative-blog' ),
		'panel'    => 'creative_blog_design_options',
	) );

	$wp_customize->add_setting( 'creative_blog_default_single_posts_layout', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_radio_select_sanitize',
	) );

	$wp_customize->add_control( new Creative_Blog_Image_Radio_Control( $wp_customize, 'creative_blog_default_single_posts_layout', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for the specific post.', 'creative-blog' ),
		'section'  => 'creative_blog_default_single_posts_layout_setting',
		'settings' => 'creative_blog_default_single_posts_layout',
		'choices'  => array(
			'right_sidebar'               => get_template_directory_uri() . '/img/right-sidebar.png',
			'left_sidebar'                => get_template_directory_uri() . '/img/left-sidebar.png',
			'no_sidebar_full_width'       => get_template_directory_uri() . '/img/no-sidebar-full-width-layout.png',
			'no_sidebar_content_centered' => get_template_directory_uri() . '/img/no-sidebar-content-centered-layout.png',
		),
	) ) );
	// End Of Design Options
	// Start of Additional Options
	$wp_customize->add_panel( 'creative_blog_additional_options', array(
		'capability'  => 'edit_theme_options',
		'description' => esc_html__( 'Change the Additional Settings from here as you want to best suite your site.', 'creative-blog' ),
		'priority'    => 515,
		'title'       => esc_html__( 'Additional Options', 'creative-blog' ),
	) );

	// related posts
	$wp_customize->add_section( 'creative_blog_related_posts_section', array(
		'priority' => 1,
		'title'    => esc_html__( 'Related Posts', 'creative-blog' ),
		'panel'    => 'creative_blog_additional_options',
	) );

	$wp_customize->add_setting( 'creative_blog_related_posts_activate', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_related_posts_activate', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to activate the related posts.', 'creative-blog' ),
		'section'  => 'creative_blog_related_posts_section',
		'settings' => 'creative_blog_related_posts_activate',
	) );

	$wp_customize->add_setting( 'creative_blog_related_posts', array(
		'default'           => 'categories',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_radio_select_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_related_posts', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Related Posts To Be Shown As:', 'creative-blog' ),
		'section'  => 'creative_blog_related_posts_section',
		'settings' => 'creative_blog_related_posts',
		'choices'  => array(
			'categories' => esc_html__( 'Related Posts By Categories', 'creative-blog' ),
			'tags'       => esc_html__( 'Related Posts By Tags', 'creative-blog' ),
		),
	) );

	// featured image popup check
	$wp_customize->add_section( 'creative_blog_featured_image_popup_setting', array(
		'priority' => 2,
		'title'    => esc_html__( 'Image Lightbox', 'creative-blog' ),
		'panel'    => 'creative_blog_additional_options',
	) );

	$wp_customize->add_setting( 'creative_blog_featured_image_popup', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_featured_image_popup', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to enable the lightbox feature for the featured images in single post page. Note: the post should be of image post format to support this feature, ie, we have supported the featured image in single post page only when image post format is choosen.', 'creative-blog' ),
		'section'  => 'creative_blog_featured_image_popup_setting',
		'settings' => 'creative_blog_featured_image_popup',
	) );

	$wp_customize->add_section( 'creative_blog_author_bio_social_links_setting', array(
		'priority' => 3,
		'title'    => esc_html__( 'Social Links In Author Bio', 'creative-blog' ),
		'panel'    => 'creative_blog_additional_options',
	) );

	$wp_customize->add_setting( 'creative_blog_author_bio_social_links', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_author_bio_social_links', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to enable the social links in the Author Bio section. For this to work, you need to add the URL of your social sites in the profile section. This theme supports WordPress SEO and All In One SEO Pack plugin for this feature.', 'creative-blog' ),
		'section'  => 'creative_blog_author_bio_social_links_setting',
		'settings' => 'creative_blog_author_bio_social_links',
	) );

	// Sticky Sidebar and Content area
	$wp_customize->add_section( 'creative_blog_sticky_sidebar_content_setting', array(
		'priority' => 3,
		'title'    => esc_html__( 'Sticky Sidebar And Content Area', 'creative-blog' ),
		'panel'    => 'creative_blog_additional_options',
	) );

	$wp_customize->add_setting( 'creative_blog_sticky_sidebar_content', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_sticky_sidebar_content', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to enable the feature of sticky sidebar and content area.', 'creative-blog' ),
		'section'  => 'creative_blog_sticky_sidebar_content_setting',
		'settings' => 'creative_blog_sticky_sidebar_content',
	) );
	// End Of Additional Options
	// Category Color Options
	$wp_customize->add_panel( 'creative_blog_category_color_panel', array(
		'priority'    => 535,
		'title'       => esc_html__( 'Category Color Options', 'creative-blog' ),
		'capability'  => 'edit_theme_options',
		'description' => esc_html__( 'Change the color of each category items as you want to best suit your requirement.', 'creative-blog' ),
	) );

	$wp_customize->add_section( 'creative_blog_category_color_setting', array(
		'priority' => 1,
		'title'    => esc_html__( 'Category Color Settings', 'creative-blog' ),
		'panel'    => 'creative_blog_category_color_panel',
	) );

	$i                = 1;
	$args             = array(
		'orderby'    => 'id',
		'hide_empty' => 0,
	);
	$categories       = get_categories( $args );
	$wp_category_list = array();

	// looping through each category colors
	foreach ( $categories as $category_list ) {
		$wp_category_list[ $category_list->cat_ID ] = $category_list->cat_name;

		$wp_customize->add_setting( 'creative_blog_category_color_' . get_cat_id( $wp_category_list[ $category_list->cat_ID ] ), array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'creative_blog_color_option_hex_sanitize',
			'sanitize_js_callback' => 'creative_blog_color_escaping_option_sanitize',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'creative_blog_category_color_' . get_cat_id( $wp_category_list[ $category_list->cat_ID ] ), array(
			'label'    => sprintf( esc_html__( '%s', 'creative-blog' ), $wp_category_list[ $category_list->cat_ID ] ),
			'section'  => 'creative_blog_category_color_setting',
			'settings' => 'creative_blog_category_color_' . get_cat_id( $wp_category_list[ $category_list->cat_ID ] ),
			'priority' => $i,
		) ) );
		$i ++;
	}
	// End Of Category Color Options
	// Start of the WordPress default sections for theme related options
	// header image link enable/disable
	$wp_customize->add_setting( 'creative_blog_header_image_link', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'creative_blog_checkbox_sanitize',
	) );

	$wp_customize->add_control( 'creative_blog_header_image_link', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to enable the header image to link back to the home page.', 'creative-blog' ),
		'section'  => 'header_image',
		'settings' => 'creative_blog_header_image_link',
	) );

	// primary color options
	$wp_customize->add_setting( 'creative_blog_primary_color', array(
		'default'              => '#0099ff',
		'capability'           => 'edit_theme_options',
		'sanitize_callback'    => 'creative_blog_color_option_hex_sanitize',
		'sanitize_js_callback' => 'creative_blog_color_escaping_option_sanitize',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'creative_blog_primary_color', array(
		'label'    => esc_html__( 'Primary Color', 'creative-blog' ),
		'section'  => 'colors',
		'settings' => 'creative_blog_primary_color',
	) ) );

	// End of the WordPress default sections for theme related options
	// sanitization works
	// radio/select buttons sanitization
	function creative_blog_radio_select_sanitize( $input, $setting ) {
		// Ensuring that the input is a slug.
		$input = sanitize_key( $input );
		// Get the list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it, else, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	// checkbox sanitization
	function creative_blog_checkbox_sanitize( $input ) {
		return ( 1 === absint( $input ) ) ? 1 : 0;
	}

	// color sanitization
	function creative_blog_color_option_hex_sanitize( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
			return '#' . $unhashed;
		}

		return $color;
	}

	function creative_blog_color_escaping_option_sanitize( $input ) {
		$input = esc_attr( $input );

		return $input;
	}

	// link sanitization
	function creative_blog_important_links_sanitize() {
		return false;
	}

}

add_action( 'customize_register', 'creative_blog_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function creative_blog_customize_preview_js() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'creative_blog_customizer', get_template_directory_uri() . '/js/customizer' . $suffix . '.js', array( 'customize-preview' ), '20130508', true );
}

add_action( 'customize_preview_init', 'creative_blog_customize_preview_js' );
