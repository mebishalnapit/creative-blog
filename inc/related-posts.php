<?php
/**
 * Template to show the related posts of the single posts
 */
?>

<?php $related_posts = creative_blog_related_posts_function(); ?>

<?php if ($related_posts->have_posts()): ?>
    <div class="related-posts-main">

        <h3 class="related-posts-main-title"><i class="fa fa-thumbs-up"></i><span><?php _e('You May Also Like', 'creative-blog'); ?></span></h3>

        <div class="related-posts-total clearfix">

            <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                <div class="related-posts col-sm-3">

                    <?php if (has_post_thumbnail()): ?>
                        <div class="related-posts-thumbnail">
                            <a href="<?php the_permalink(); ?>" alt="<?php the_title(); ?>">
                                <?php the_post_thumbnail('creative-blog-featured-small'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="related-post-content">

                        <h4 class="entry-title">
                            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </h4><!-- .entry-title -->

                        <div class="entry-meta">
                            <?php
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
                            ?>
                        </div>

                    </div>

                </div><!--.related-posts-->
            <?php endwhile; ?>

        </div><!-- .related-posts-total -->
    </div><!-- .related-posts-main -->
<?php endif; ?>

<?php wp_reset_query(); ?>
