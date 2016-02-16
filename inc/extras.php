<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Creative Blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function creative_blog_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    return $classes;
}

add_filter('body_class', 'creative_blog_body_classes');

/*
 * Display the date in the header
 */
if (!function_exists('creative_blog_date_display')) :

    function creative_blog_date_display() {
        ?>
        <div class="date-in-header">
            <?php echo date_i18n('l, F j, Y'); ?>
        </div>
        <?php
    }

endif;

/*
 * Breaking News/Latest Posts ticker section in the header
 */
if (!function_exists('creative_blog_breaking_news')) :

    function creative_blog_breaking_news() {
        $get_featured_posts = new WP_Query(array(
            'posts_per_page' => 5,
            'post_type' => 'post',
            'ignore_sticky_posts' => true
        ));
        ?>
        <div class="breaking-news">
            <strong class="breaking-news-latest"><?php esc_html_e('Latest:', 'creative-blog'); ?></strong>
            <ul class="newsticker">
                <?php while ($get_featured_posts->have_posts()):$get_featured_posts->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php
        // Reset Post Data
        wp_reset_query();
    }

endif;

/*
 * Creating Social Menu
 */
if (!function_exists('creative_blog_social_menu')) :

    function creative_blog_social_menu() {
        if (has_nav_menu('social')) {
            wp_nav_menu(
                    array(
                        'theme_location' => 'social',
                        'container' => 'div',
                        'container_id' => 'main-menu-social',
                        'container_class' => 'creative-blog-social-menu',
                        'depth' => 1,
                        'menu_id' => 'menu-social',
                        'fallback_cb' => false,
                        'link_before' => '<span class="screen-reader-text">',
                        'link_after' => '</span>',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    )
            );
        }
    }

endif;

/*
 * Adding the header logo options code
 */
if (!function_exists('creative_blog_header_text_logo')) :

    function creative_blog_header_text_logo() {
        ?>
        <div id="logo-and-title" class="logo-and-title col-md-4">
            <?php if (((get_theme_mod('creative_blog_header_logo_placement', 'header_text_only') == 'show_both') || (get_theme_mod('creative_blog_header_logo_placement', 'header_text_only') == 'header_logo_only')) && get_theme_mod('creative_blog_logo', '') != '') : ?>
                <div class="header-logo-image">
                    <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo esc_url(get_theme_mod('creative_blog_logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"></a>
                </div><!-- #header-logo-image -->
            <?php endif; ?>

            <?php
            $class = '';
            if ((get_theme_mod('creative_blog_header_logo_placement', 'header_text_only') == 'header_logo_only') || (get_theme_mod('creative_blog_header_logo_placement', 'header_text_only') == 'disable')) {
                $class = 'screen-reader-text';
            }
            ?>

            <div class="site-info <?php echo $class; ?>">
                <?php if (is_front_page() && is_home()) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
                <?php endif; ?>
                <p class="site-description"><?php bloginfo('description'); ?></p>
            </div><!-- .site-info -->
        </div>

        <?php
    }

endif;

/*
 * Category Color Options
 */
if (!function_exists('creative_blog_category_color')) :

    function creative_blog_category_color($wp_category_id) {
        $args = array(
            'orderby' => 'id',
            'hide_empty' => 0
        );
        $category = get_categories($args);
        foreach ($category as $category_list) {
            $color = get_theme_mod('creative_blog_category_color_' . $wp_category_id);
            return $color;
        }
    }

endif;

/*
 * Category Color display
 */
if (!function_exists('creative_blog_colored_category')) :

    function creative_blog_colored_category() {
        global $post;
        $categories = get_the_category();
        $separator = '&nbsp;';
        $output = '';
        if ($categories) {
            foreach ($categories as $category) {
                $color_code = creative_blog_category_color(get_cat_id($category->cat_name));
                if (!empty($color_code)) {
                    $output .= '<a href="' . get_category_link($category->term_id) . '" style="background:' . creative_blog_category_color(get_cat_id($category->cat_name)) . '" rel="category tag">' . $category->cat_name . '</a>' . $separator;
                } else {
                    $output .= '<a href="' . get_category_link($category->term_id) . '"  rel="category tag">' . $category->cat_name . '</a>' . $separator;
                }
            }
            echo trim($output, $separator);
        }
    }

endif;

/**
 * adding the hooks to filter the single category title to display the colored category title
 */
if (!function_exists('creative_blog_colored_category_title')) :

    function creative_blog_colored_category_title($title) {
        $color_value = creative_blog_category_color(get_cat_id($title));
        $color_border_value = creative_blog_category_color(get_cat_id($title));
        if (!empty($color_value)) {
            return '<h1 class="page-title" style="border-bottom: 2px solid' . $color_border_value . '">' . '<span style="background: ' . $color_value . '">' . $title . '</span></h1>';
        } else {
            return '<h1 class="page-title"><span>' . $title . '</span></h1>';
        }
    }

endif;

/*
 * Adding the custom function to filter the category title
 */
function creative_blog_category_title_function($category_title) {
    add_filter('single_cat_title', 'creative_blog_colored_category_title');
}

add_action('creative_blog_category_title', 'creative_blog_category_title_function');

/*
 * Random Post in header
 */
if (!function_exists('creative_blog_random_post')) :

    function creative_blog_random_post() {
        $get_random_post = new WP_Query(array(
            'posts_per_page' => 1,
            'post_type' => 'post',
            'ignore_sticky_posts' => true,
            'orderby' => 'rand'
        ));
        ?>
        <?php while ($get_random_post->have_posts()):$get_random_post->the_post(); ?>
            <?php return '<li class="filtered-menu"><a href="' . esc_url(get_the_permalink()) . '" title="' . esc_html__('Random Post', 'creative-blog') . '"><i class="fa fa-random"></i></a></li>'; ?>
        <?php endwhile; ?>
        <?php
        // Reset Post Data
        wp_reset_postdata();
    }

endif;

/**
 * Filter passed to add the search and random posts options in primary menu
 */
add_filter('wp_nav_menu_items', 'creative_blog_menu_filter', 10, 2);

if (!function_exists('creative_blog_menu_filter')) :

    function creative_blog_menu_filter($items, $args) {
        // adding custom added ul
        if (((get_theme_mod('creative_blog_random_post_in_menu', 0) == 1) || (get_theme_mod('creative_blog_search_icon_in_menu', 0) == 1 )) && $args->theme_location == 'primary') {
            $items .= '</ul><ul class="nav navbar-nav navbar-right">';
        }

        // adding the function to call up the random post
        if ((get_theme_mod('creative_blog_random_post_in_menu', 0) == 1) && $args->theme_location == 'primary') {
            $items .= creative_blog_random_post();
        }

        // showing the random post icon
        if ((get_theme_mod('creative_blog_search_icon_in_menu', 0) == 1) && $args->theme_location == 'primary') {
            $items .= '<li class="filtered-menu"><a class="search"><i class="fa fa-search search-top"></i></a></li>';
        }

        return $items;
    }

endif;

add_action('creative_blog_footer_copyright', 'creative_blog_footer_copyright', 10);
/**
 * function to show the footer info, copyright information
 */
if (!function_exists('creative_blog_footer_copyright')) :

    function creative_blog_footer_copyright() {
        $site_link = '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name', 'display')) . '" ><span>' . get_bloginfo('name', 'display') . '</span></a>';

        $wp_link = '<a href="http://wordpress.org" target="_blank" title="' . esc_attr__('WordPress', 'creative-blog') . '"><span>' . __('WordPress', 'creative-blog') . '</span></a>';

        $my_link_name = '<a href="http://napitwptech.com" target="_blank" title="' . esc_attr__('Bishal Napit', 'creative-blog') . '"><span>' . __('Bishal Napit', 'creative-blog') . '</span></a>';

        $default_footer_value = sprintf(esc_html__('Copyright &copy; %1$s %2$s.', 'creative-blog'), date('Y'), $site_link) . ' ' . sprintf(esc_html__('Theme: %1$s by %2$s.', 'creative-blog'), 'Creative Blog', $my_link_name) . ' ' . sprintf(esc_html__('Powered by %s.', 'creative-blog'), $wp_link);

        $creative_blog_footer_copyright = '<div class="copyright col-md-12">' . $default_footer_value . '</div>';
        echo $creative_blog_footer_copyright;
    }

endif;

add_action('wp_head', 'creative_blog_custom_css');

/**
 * Hooks the Custom Internal CSS to head section
 */
function creative_blog_custom_css() {
    // changing color options
    $creative_blog_custom_options_color = '';
    $primary_color = get_theme_mod('creative_blog_primary_color', '#0099ff');
    if ($primary_color != '#0099ff') {
        $creative_blog_custom_options_color .= 'a,a:focus,a:hover{color:' . $primary_color . '}td,th,tr{border:2px solid ' . $primary_color . '}.date-in-header{background-color:' . $primary_color . '}.navigation .nav-next:after,.navigation .nav-previous:before,.newsticker a{color:' . $primary_color . '}.search-field{border:1px solid ' . $primary_color . '}.searchsubmit{background-color:' . $primary_color . '}#menu-social li a::before{color:' . $primary_color . '}.post,.search .page{border-bottom:1px solid ' . $primary_color . '}.custom-page-header .page-title{border-bottom:2px solid ' . $primary_color . '}.custom-page-header .page-title span{background:' . $primary_color . '}.continue-more-link,.continue-more-link:hover,.sticky .continue-more-link,.sticky .continue-more-link:hover{background:' . $primary_color . '}.entry-meta{border-bottom:1px dotted ' . $primary_color . ';border-top:1px dotted ' . $primary_color . '}.category-links a{background-color:' . $primary_color . '}.comments-link,.tags-links .fa{color:' . $primary_color . '}.comment-respond .form-submit input[type=submit]{background:' . $primary_color . '}.bypostauthor>.comment-body .fn:before{color:' . $primary_color . '}.comment-author,.comments-area .comment-meta .edit-link:before{color:' . $primary_color . '}.author-box{border:1px dotted ' . $primary_color . '}.featured-image img{border:1px solid ' . $primary_color . '}.format-status .status-details{border-top:1px solid ' . $primary_color . ';border-bottom:1px solid ' . $primary_color . '}a#scroll-up i{color:' . $primary_color . '}.widget-title span{background-color:' . $primary_color . ';border-bottom:1px solid ' . $primary_color . '}.widget-title{border-bottom:2px solid ' . $primary_color . '}.widget_nav_menu a,.widget_pages a,.widget_recent_comments li,.widget_recent_entries li{border-bottom:2px dotted ' . $primary_color . '}.widget_archive li:before,.widget_categories li:before,.widget_nav_menu li:before,.widget_pages li:before,.widget_recent_comments li:before,.widget_recent_entries li:before,.widget_rss li:before{color:' . $primary_color . '}.wp-caption{border:1px solid ' . $primary_color . '}input[type="submit"]{background-color:' . $primary_color . ';border:1px solid ' . $primary_color . '}input[type="file"]{background-color:' . $primary_color . '}.content-top-sidebar{border-bottom:1px solid '. $primary_color . '}.content-bottom-sidebar{border-top:1px solid '. $primary_color . '}.sticky{background:'. $primary_color . '}.sticky .category-links a{color:'. $primary_color . '}.format-chat .chat-details{background-color:'. $primary_color . '}.format-link .link-details{background-color:'. $primary_color . '}.format-quote .quote-details{background-color:'. $primary_color . '}.sticky .category-links a:hover{color:'. $primary_color . '}.related-posts-main-title span{background:'. $primary_color . '}.related-posts-main-title{border-bottom: 2px solid '. $primary_color . '}';
    }

    // color change options code
    if (!empty($creative_blog_custom_options_color)) {
        echo '<!-- ' . get_bloginfo('name') . ' Internal Styles -->';
        ?><style type="text/css"><?php echo esc_html($creative_blog_custom_options_color); ?></style>
        <?php
    }

    // custom CSS codes goes here
    $creative_blog_custom_css = get_theme_mod('creative_blog_custom_css', '');
    if (!empty($creative_blog_custom_css)) {
        echo '<!-- ' . get_bloginfo('name') . ' Custom Styles -->';
        ?><style type="text/css"><?php echo esc_html($creative_blog_custom_css); ?></style><?php
    }
}

/**
 * Controlling the excerpt length
 */
function creative_blog_excerpt_length($length) {
    return 40;
}

add_filter('excerpt_length', 'creative_blog_excerpt_length');

/**
 * Controlling the excerpt string
 */
function creative_blog_excerpt_string($more) {
    return '&hellip;';
}

add_filter('excerpt_more', 'creative_blog_excerpt_string');

/*
 * Display the related posts
 */
if (!function_exists('creative_blog_related_posts_function')) :

    function creative_blog_related_posts_function() {
        global $post;

        // Define shared post arguments
        $args = array(
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'ignore_sticky_posts' => 1,
            'orderby' => 'rand',
            'post__not_in' => array($post->ID),
            'posts_per_page' => 4
        );
        // Related by categories
        if (get_theme_mod('creative_blog_related_posts', 'categories') == 'categories') {

            $cats = get_post_meta($post->ID, 'related-posts', true);

            if (!$cats) {
                $cats = wp_get_post_categories($post->ID, array('fields' => 'ids'));
                $args['category__in'] = $cats;
            } else {
                $args['cat'] = $cats;
            }
        }
        // Related by tags
        if (get_theme_mod('creative_blog_related_posts', 'categories') == 'tags') {

            $tags = get_post_meta($post->ID, 'related-posts', true);

            if (!$tags) {
                $tags = wp_get_post_tags($post->ID, array('fields' => 'ids'));
                $args['tag__in'] = $tags;
            } else {
                $args['tag_slug__in'] = explode(',', $tags);
            }
            if (!$tags) {
                $break = true;
            }
        }

        $query = !isset($break) ? new WP_Query($args) : new WP_Query;
        return $query;
    }

endif;

/*
 * posts pagnation
 */
if (!function_exists('creative_blog_posts_pagination')) :

    function creative_blog_posts_pagination() {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = ( is_attachment() ) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
        $next = get_adjacent_post(false, '', false);

        if (!$next && !$previous) {
            return;
        }
        ?>
        <h4 class="screen-reader-text"><?php _e('Post navigation', 'creative-blog'); ?></h4>
        <ul class="pager single-post-navigations">
            <?php
            previous_post_link('<li class="previous">%link</li>', _x('<span class="meta-nav"><i class="fa fa-arrow-circle-o-left"></i></span>%title', 'Previous post link', 'creative-blog'));
            next_post_link('<li class="next">%link</li>', _x('%title<span class="meta-nav"><i class="fa fa-arrow-circle-o-right"></i></span>', 'Next post link', 'creative-blog'));
            ?>
        </ul><!-- .nav-links -->
        <?php
    }

endif;

/*
 * Adding the custom meta box for supporting the post formats in this theme
 */
if (!function_exists('creative_blog_post_format_meta_box')) :

    function creative_blog_post_format_meta_box() {
        add_meta_box('post-video-url', esc_html__('Video URL', 'creative-blog'), 'creative_blog_post_format_video_url', 'post', 'side', 'high');
        add_meta_box('post-audio-url', esc_html__('Audio URL', 'creative-blog'), 'creative_blog_post_format_audio_url', 'post', 'side', 'high');
        add_meta_box('post-status', esc_html__('Status', 'creative-blog'), 'creative_blog_post_format_status', 'post', 'side', 'high');
        add_meta_box('post-chat', esc_html__('Chat', 'creative-blog'), 'creative_blog_post_format_chat', 'post', 'side', 'high');
        // adding link text boxes
        add_meta_box('post-link-text', esc_html__('Link Text', 'creative-blog'), 'creative_blog_post_format_link_text', 'post', 'side', 'high');
        add_meta_box('post-link-url', esc_html__('Link URL', 'creative-blog'), 'creative_blog_post_format_link_url', 'post', 'side', 'high');
        // adding quote text boxes
        add_meta_box('post-quote-text', esc_html__('Quote Text', 'creative-blog'), 'creative_blog_post_format_quote_text', 'post', 'side', 'high');
        add_meta_box('post-quote-author', esc_html__('Quote Author', 'creative-blog'), 'creative_blog_post_format_quote_author', 'post', 'side', 'high');
    }

endif;

add_action('add_meta_boxes', 'creative_blog_post_format_meta_box');

// creating the required text box for the video url for the video post format
function creative_blog_post_format_video_url($post) {
    $video_post_id = get_post_custom($post->ID);
    $video_post_url = isset($video_post_id['video_url']) ? esc_url($video_post_id['video_url'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="video_url" id="video_url" value="<?php echo esc_url($video_post_url); ?>" />
    </p>
    <?php
}

// creating the required text box for the audio url for the audio post format
function creative_blog_post_format_audio_url($post) {
    $audio_post_id = get_post_custom($post->ID);
    $audio_post_url = isset($audio_post_id['audio_url']) ? esc_url($audio_post_id['audio_url'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="audio_url" id="audio_url" value="<?php echo esc_url($audio_post_url); ?>" />
    </p>
    <?php
}

// creating the required textarea for the status post format
function creative_blog_post_format_status($post) {
    $status_post_id = get_post_custom($post->ID);
    $status_post_text = isset($status_post_id['status_text']) ? esc_attr($status_post_id['status_text'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <textarea class="widefat" rows="5" cols="20" name="status_text" id="status_text"><?php echo esc_html($status_post_text); ?></textarea>
    </p>
    <?php
}

// creating the required textarea for the chat post format
function creative_blog_post_format_chat($post) {
    $chat_post_id = get_post_custom($post->ID);
    $chat_post_text = isset($chat_post_id['chat_text']) ? esc_attr($chat_post_id['chat_text'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <textarea class="widefat" rows="5" cols="20" name="chat_text" id="chat_text"><?php echo esc_textarea($chat_post_text); ?></textarea>
    </p>
    <?php
}

// creating the required text box for the link text for the link post format
function creative_blog_post_format_link_text($post) {
    $link_post_id = get_post_custom($post->ID);
    $link_post_text = isset($link_post_id['link_text']) ? esc_attr($link_post_id['link_text'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="link_text" id="link_text" value="<?php echo esc_html($link_post_text); ?>" />
    </p>
    <?php
}

// creating the required text box for the link url for the link post format
function creative_blog_post_format_link_url($post) {
    $link_post_id = get_post_custom($post->ID);
    $link_post_url = isset($link_post_id['link_url']) ? esc_url($link_post_id['link_url'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="link_url" id="link_url" value="<?php echo esc_url($link_post_url); ?>" />
    </p>
    <?php
}

// creating the required textarea for the text used in the quote post format
function creative_blog_post_format_quote_text($post) {
    $quote_post_id = get_post_custom($post->ID);
    $quote_post_text = isset($quote_post_id['quote_text']) ? esc_attr($quote_post_id['quote_text'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <textarea class="widefat" rows="5" cols="20" name="quote_text" id="quote_text"><?php echo esc_textarea($quote_post_text); ?></textarea>
    </p>
    <?php
}

// creating the required text box for the quote author for the quote post format
function creative_blog_post_format_quote_author($post) {
    $quote_post_id = get_post_custom($post->ID);
    $quote_post_author = isset($quote_post_id['quote_author']) ? esc_attr($quote_post_id['quote_author'][0]) : '';
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
    ?>
    <p>
        <input type="text" class="widefat" name="quote_author" id="quote_author" value="<?php echo esc_html($quote_post_author); ?>" />
    </p>
    <?php
}

/*
 * Saving the custom meta box data for post format in the post editor
 */
if (!function_exists('creative_blog_post_meta_save')) :

    function creative_blog_post_meta_save($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        // checking if the nonce isn't there, or we can't verify it, then we should return
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'my_meta_box_nonce'))
            return;

        // checking if the current user can't edit this post, then we should return
        if (!current_user_can('edit_posts'))
            return;

        // saving the data in meta box
        // saving the video url in the meta box
        if (isset($_POST['video_url'])) {
            update_post_meta($post_id, 'video_url', esc_url_raw($_POST['video_url']));
        }
        // saving the audio url in the meta box
        if (isset($_POST['audio_url'])) {
            update_post_meta($post_id, 'audio_url', esc_url_raw($_POST['audio_url']));
        }
        // saving the status text in the meta box
        if (isset($_POST['status_text'])) {
            update_post_meta($post_id, 'status_text', wp_filter_nohtml_kses($_POST['status_text']));
        }
        // saving the chat text in the meta box
        if (isset($_POST['chat_text'])) {
            update_post_meta($post_id, 'chat_text', wp_filter_nohtml_kses($_POST['chat_text']));
        }
        // saving the link text in the meta box
        if (isset($_POST['link_text'])) {
            update_post_meta($post_id, 'link_text', wp_filter_nohtml_kses($_POST['link_text']));
        }
        // saving the link url in the meta box
        if (isset($_POST['link_url'])) {
            update_post_meta($post_id, 'link_url', esc_url_raw($_POST['link_url']));
        }
        // saving the quote text in the meta box
        if (isset($_POST['quote_text'])) {
            update_post_meta($post_id, 'quote_text', wp_filter_nohtml_kses($_POST['quote_text']));
        }
        // saving the quote author in the meta box
        if (isset($_POST['quote_author'])) {
            update_post_meta($post_id, 'quote_author', wp_filter_nohtml_kses($_POST['quote_author']));
        }
    }

endif;

add_action('save_post', 'creative_blog_post_meta_save');

/*
 * Meta box toggle js script
 */
if (!function_exists('creative_blog_meta_box_display_toggle')) :

    function creative_blog_meta_box_display_toggle() {
        $custom_script = '
        <script type="text/javascript">
            jQuery(document).ready(function() {
                // hide the div by default
                jQuery( "#post-video-url" ).hide();
                jQuery( "#post-audio-url" ).hide();
                jQuery( "#post-status" ).hide();
                jQuery( "#post-chat" ).hide();
                jQuery( "#post-link-text" ).hide();
                jQuery( "#post-link-url" ).hide();
                jQuery( "#post-quote-text" ).hide();
                jQuery( "#post-quote-author" ).hide();

                // if post format is selected, then, display the respective div
                if(jQuery( "#post-format-video" ).is( ":checked" ))
                    jQuery( "#post-video-url" ).show();
                if(jQuery( "#post-format-audio" ).is( ":checked" ))
                    jQuery( "#post-audio-url" ).show();
                if(jQuery( "#post-format-status" ).is( ":checked" ))
                    jQuery( "#post-status" ).show();
                if(jQuery( "#post-format-chat" ).is( ":checked" ))
                    jQuery( "#post-chat" ).show();
                if(jQuery( "#post-format-link" ).is( ":checked" )) {
                    jQuery( "#post-link-text" ).show();
                    jQuery( "#post-link-url" ).show();
                }
                if(jQuery( "#post-format-quote" ).is( ":checked" )) {
                    jQuery( "#post-quote-text" ).show();
                    jQuery( "#post-quote-author" ).show();
                }

                // hiding the default post format type input box by default
                jQuery( "input[name=\"post_format\"]" ).change(function() {
                    jQuery( "#post-video-url" ).hide();
                    jQuery( "#post-audio-url" ).hide();
                    jQuery( "#post-status" ).hide();
                    jQuery( "#post-chat" ).hide();
                    jQuery( "#post-link-text" ).hide();
                    jQuery( "#post-link-url" ).hide();
                    jQuery( "#post-quote-text" ).hide();
                    jQuery( "#post-quote-author" ).hide();
                });

                // if post format is selected, then, display the respective input div
                jQuery( "input#post-format-video" ).change( function() {
                    jQuery( "#post-video-url" ).show();
                });
                jQuery( "input#post-format-audio" ).change( function() {
                    jQuery( "#post-audio-url" ).show();
                });
                jQuery( "input#post-format-status" ).change( function() {
                    jQuery( "#post-status" ).show();
                });
                jQuery( "input#post-format-chat" ).change( function() {
                    jQuery( "#post-chat" ).show();
                });
                jQuery( "input#post-format-link" ).change( function() {
                    jQuery( "#post-link-text" ).show();
                    jQuery( "#post-link-url" ).show();
                });
                jQuery( "input#post-format-quote" ).change( function() {
                    jQuery( "#post-quote-text" ).show();
                    jQuery( "#post-quote-author" ).show();
                });
            });
        </script>
        ';

        return print $custom_script;
    }

endif;

add_action('admin_footer', 'creative_blog_meta_box_display_toggle');

add_filter('body_class', 'creative_blog_body_class');

/**
 * Filter the body_class
 *
 * Throwing different body class for the different layouts in the body tag
 */
function creative_blog_body_class($classes) {

    if (get_theme_mod('creative_blog_site_layout', 'wide_layout') == 'wide_layout') {
        $classes[] = 'wide';
    } elseif (get_theme_mod('creative_blog_site_layout', 'wide_layout') == 'boxed_layout') {
        $classes[] = 'boxed';
    }

    return $classes;
}

/*
 * function to add the classess to the respective pages/posts as called upon the layout option choosed
 */
if (!function_exists('creative_blog_layout_class')) :

    function creative_blog_layout_class() {
        global $post;

        if ($post) {
            $creative_blog_layout_meta = get_post_meta($post->ID, 'creative_blog_page_layout', true);
        }

        if (is_home()) {
            $queried_id = get_option('page_for_posts');
            $creative_blog_layout_meta = get_post_meta($queried_id, 'creative_blog_page_layout', true);
        }

        if (empty($creative_blog_layout_meta) || is_archive() || is_search() || is_404()) {
            $creative_blog_layout_meta = 'default_layout';
        }

        $creative_blog_default_layout = get_theme_mod('creative_blog_default_layout', 'right_sidebar');
        $creative_blog_default_page_layout = get_theme_mod('creative_blog_default_page_layout', 'right_sidebar');
        $creative_blog_default_post_layout = get_theme_mod('creative_blog_default_single_posts_layout', 'right_sidebar');

        $class = '';
        if ($creative_blog_layout_meta == 'default_layout') {
            if (is_page()) {
                if (($creative_blog_default_page_layout == 'right_sidebar') || ($creative_blog_default_page_layout == 'left_sidebar')) {
                    $class = 'col-md-8';
                } elseif ($creative_blog_default_page_layout == 'no_sidebar_full_width') {
                    $class = 'col-md-12';
                } elseif ($creative_blog_default_page_layout == 'no_sidebar_content_centered') {
                    $class = 'content-centered col-md-8';
                }
            } elseif (is_single()) {
                if (($creative_blog_default_post_layout == 'right_sidebar') || ($creative_blog_default_post_layout == 'left_sidebar')) {
                    $class = 'col-md-8';
                } elseif ($creative_blog_default_post_layout == 'no_sidebar_full_width') {
                    $class = 'col-md-12';
                } elseif ($creative_blog_default_post_layout == 'no_sidebar_content_centered') {
                    $class = 'content-centered col-md-8';
                }
            } elseif (($creative_blog_default_layout == 'right_sidebar') || ($creative_blog_default_layout == 'left_sidebar')) {
                $class = 'col-md-8';
            } elseif ($creative_blog_default_layout == 'no_sidebar_full_width') {
                $class = 'col-md-12';
            } elseif ($creative_blog_default_layout == 'no_sidebar_content_centered') {
                $class = 'content-centered col-md-8';
            }
        } elseif (($creative_blog_layout_meta == 'right_sidebar') || ($creative_blog_layout_meta == 'left_sidebar')) {
            $class = 'col-md-8';
        } elseif ($creative_blog_layout_meta == 'no_sidebar_full_width') {
            $class = 'col-md-12';
        } elseif ($creative_blog_layout_meta == 'no_sidebar_content_centered') {
            $class = 'content-centered col-md-8';
        }
        
        return $class;
    }

endif;

/*
 * function to display the right sidebar according to layout choosed
 */
if (!function_exists('creative_blog_right_sidebar_select')) :

    function creative_blog_right_sidebar_select() {
        global $post;

        if ($post) {
            $creative_blog_layout_meta = get_post_meta($post->ID, 'creative_blog_page_layout', true);
        }

        if (is_home()) {
            $queried_id = get_option('page_for_posts');
            $creative_blog_layout_meta = get_post_meta($queried_id, 'creative_blog_page_layout', true);
        }

        if (empty($creative_blog_layout_meta) || is_archive() || is_search() || is_404()) {
            $creative_blog_layout_meta = 'default_layout';
        }

        $creative_blog_default_layout = get_theme_mod('creative_blog_default_layout', 'right_sidebar');
        $creative_blog_default_page_layout = get_theme_mod('creative_blog_default_page_layout', 'right_sidebar');
        $creative_blog_default_post_layout = get_theme_mod('creative_blog_default_single_posts_layout', 'right_sidebar');

        if ($creative_blog_layout_meta == 'default_layout') {
            if (is_page()) {
                if ($creative_blog_default_page_layout == 'right_sidebar') {
                    get_sidebar();
                }
            } elseif (is_single()) {
                if ($creative_blog_default_post_layout == 'right_sidebar') {
                    get_sidebar();
                }
            } elseif ($creative_blog_default_layout == 'right_sidebar') {
                get_sidebar();
            }
        } elseif ($creative_blog_layout_meta == 'right_sidebar') {
            get_sidebar();
        }
    }

endif;

/*
 * function to display the left sidebar according to layout choosed
 */
if (!function_exists('creative_blog_left_sidebar_select')) :

    function creative_blog_left_sidebar_select() {
        global $post;

        if ($post) {
            $creative_blog_layout_meta = get_post_meta($post->ID, 'creative_blog_page_layout', true);
        }

        if (is_home()) {
            $queried_id = get_option('page_for_posts');
            $creative_blog_layout_meta = get_post_meta($queried_id, 'creative_blog_page_layout', true);
        }

        if (empty($creative_blog_layout_meta) || is_archive() || is_search() || is_404()) {
            $creative_blog_layout_meta = 'default_layout';
        }

        $creative_blog_default_layout = get_theme_mod('creative_blog_default_layout', 'right_sidebar');
        $creative_blog_default_page_layout = get_theme_mod('creative_blog_default_page_layout', 'right_sidebar');
        $creative_blog_default_post_layout = get_theme_mod('creative_blog_default_single_posts_layout', 'right_sidebar');

        if ($creative_blog_layout_meta == 'default_layout') {
            if (is_page()) {
                if ($creative_blog_default_page_layout == 'left_sidebar') {
                    get_sidebar('left');
                }
            } elseif (is_single()) {
                if ($creative_blog_default_post_layout == 'left_sidebar') {
                    get_sidebar('left');
                }
            } elseif ($creative_blog_default_layout == 'left_sidebar') {
                get_sidebar('left');
            }
        } elseif ($creative_blog_layout_meta == 'left_sidebar') {
            get_sidebar('left');
        }
    }

endif;

/**
 * functon for dsplaying the custom meta data
 */
if (!function_exists('creative_blog_entry_meta_custom')) :

    function creative_blog_entry_meta_custom() {
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

        echo '<span class="comments-link">';
        comments_popup_link(__('<i class="fa fa-comment"></i>Leave a reply', 'creative-blog'), __('<i class="fa fa-comment"></i>1 Comment', 'creative-blog'), __('<i class="fa fa-comment"></i>% Comments', 'creative-blog'), '', __('<i class="fa fa-comment"></i>Comments Disabled', 'creative-blog'));
        echo '</span>';
    }

endif;

/**
 * function to add the social links in the Author Bio section
 */
if (!function_exists('creative_blog_author_bio_links')) :

    function creative_blog_author_bio_links() {
        $author_name = get_the_author_meta('display_name');
        
        // pulling the author social links url which are provided through WordPress SEO and All In One SEO Pack plugin
        $author_facebook_link = get_the_author_meta('facebook');
        $author_twitter_link = get_the_author_meta('twitter');
        $author_googleplus_link = get_the_author_meta('googleplus');
        
        if ($author_twitter_link || $author_googleplus_link || $author_facebook_link) {
            echo '<div class="author-social-links">';
            printf(esc_html__( 'Follow %s on:', 'creative-blog' ), $author_name );
            if ($author_facebook_link) {
                echo '<a href="' . esc_url($author_facebook_link) . '" title="' . esc_html__('Facebook', 'creative-blog') . '" target="_blank"><i class="fa fa-facebook"></i><span class="screen-reader-text">' . esc_html__( 'Facebook', 'creative-blog' ) . '</span></a>';
            }
            if ($author_twitter_link) {
                echo '<a href="https://twitter.com/' . esc_attr($author_twitter_link) . '" title="' . esc_html__('Twitter', 'creative-blog') .'" target="_blank"><i class="fa fa-twitter"></i><span class="screen-reader-text">' . esc_html__( 'Twitter', 'creative-blog' ) . '</span></a>';
            }
            if ($author_googleplus_link) {
                echo '<a href="' . esc_url($author_googleplus_link) . '" title="' . esc_html__('Google Plus', 'creative-blog') . '" rel="author" target="_blank"><i class="fa fa-google-plus"></i><span class="screen-reader-text">' . esc_html__( 'Google Plus', 'creative-blog' ) . '</span></a>';
            }
            echo '</div>';
        }
    }

endif;
