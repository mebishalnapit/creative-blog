<?php
/**
 * Contains all the widgets parts included in the theme
 *
 * @package Creative Blog
 */

class Creative_Blog_Tabbed_Widget extends WP_Widget {

    /**
     * Register widget in WordPress
     */
    function __construct() {
        parent::__construct(
                'creative_blog_tabbed_widget', __('CB: Tabbed Widget', 'creative-blog'), // Name of the widget
                array('description' => __('Displays the popular posts, recents posts and the recent comments in the tabs.', 'creative-blog')) // Arguments of the widget, here it is provided with the description
        );
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    function form($instance) {
        $number = !empty($instance['number']) ? $instance['number'] : 4;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of popular posts, recent posts and comments to display:', 'creative-blog'); ?></label> 
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo absint($number); ?>" size="3">
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['number'] = (!empty($new_instance['number']) ) ? absint($new_instance['number']) : 4;

        return $instance;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    function widget($args, $instance) {
        $number = (!empty($instance['number']) ) ? $instance['number'] : 4;
        echo $args['before_widget'];
        ?>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs creative-blog-tabs" role="tablist">
            <li role="presentation" class="popular active"><a href="#popular" aria-controls="popular" role="tab" data-toggle="tab"><i class="fa fa-star"></i><?php _e('Popular', 'creative-blog'); ?></a></li>
            <li role="presentation" class="recent"><a href="#recent" aria-controls="recent" role="tab" data-toggle="tab"><i class="fa fa-history"></i><?php _e('Recent', 'creative-blog'); ?></a></li>
            <li role="presentation" class="comment"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab"><i class="fa fa-comment"></i><?php _e('Comment', 'creative-blog'); ?></a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content creative-blog-tab-content">

            <!-- Popular Tab -->
            <div role="tabpanel" class="tab-pane popular-tab active" id="popular">
                <?php
                global $post;
                $get_popular_posts = new WP_Query(array(
                    'posts_per_page' => $number,
                    'post_type' => 'post',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'comment_count',
                    'no_found_rows' => true
                ));
                ?>
                <?php while ($get_popular_posts->have_posts()) : $get_popular_posts->the_post(); ?>
                    <div class="single-article">
                        <?php if (has_post_thumbnail()) { ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('creative-blog-featured-widget'); ?></a>
                        <?php } ?>
                        <h3 class="entry-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="entry-meta">
                            <?php creative_blog_entry_meta_custom(); ?>
                        </div>
                    </div>
                    <?php
                endwhile;
                // Reset Post Data
                wp_reset_query();
                ?>
            </div>

            <!-- Recent Tab -->
            <div role="tabpanel" class="tab-pane recent-tab" id="recent">
                <?php
                global $post;
                $get_recent_posts = new WP_Query(array(
                    'posts_per_page' => $number,
                    'post_type' => 'post',
                    'ignore_sticky_posts' => true,
                    'no_found_rows' => true
                ));
                ?>
                <?php
                $i = 1;
                while ($get_recent_posts->have_posts()) : $get_recent_posts->the_post();
                    ?>
                    <div class="single-article">
                        <?php if (has_post_thumbnail()) { ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('creative-blog-featured-widget'); ?></a>
                        <?php } ?>
                        <h3 class="entry-title">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="entry-meta">
                            <?php creative_blog_entry_meta_custom(); ?>
                        </div>
                    </div>
                    <?php
                    $i++;
                endwhile;
                // Reset Post Data
                wp_reset_query();
                ?>
            </div>

            <!-- Comment Tab -->
            <div role="tabpanel" class="tab-pane comment-tab" id="comments">
                <?php
                $comments_query = new WP_Comment_Query();
                $comments = $comments_query->query(array('number' => $number, 'status' => 'approve'));
                $commented = '';
                if ($comments) : foreach ($comments as $comment) :
                        $commented .= '<li class="comments-tab-widget"><a class="author" href="' . get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID . '">';
                        $commented .= get_avatar($comment->comment_author_email, '50');
                        $commented .= get_comment_author($comment->comment_ID) . '</a>' . ' ' . __('says:', 'creative-blog');
                        $commented .= '<p class="commented-post">' . strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, '50')) . '&hellip;</p></li>';
                    endforeach;
                else :
                    $commented .= '<p class="no-comments-commented-post">' . __('No Comments', 'creative-blog') . '</p>';
                endif;
                echo $commented;
                ?>
            </div>

        </div>

        <?php
        echo $args['after_widget'];
    }

}
?>
