<?php

class WP_Widget_Post_Last extends WP_Widget {

// Constructor
    function WP_Widget_Post_Last() {
        $widget_ops = array('description' => __('WP-PostViews last post with thumnail', 'wp-postrecent'));
        $this->WP_Widget('recentpost', __('Recent Post with Thumnail', 'wp-postrecent'), $widget_ops);
    }

// Display Widget
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', esc_attr($instance['title']));
        $limit = intval($instance['limit']);
        $post = ($instance['type']);
        $disp_views = intval($instance['disp_views']);

        echo $before_widget . $before_title . $title . $after_title;

        $params = array(
            'post_type' => $post,
            'post_status' => 'publish',
            "orderby" => "date",
            "order" => 'DESC',
            "posts_per_page" => $limit
        );

        $the_query = new WP_Query($params);
        if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                ?>
                <div class="media">
                    <div class="media-left">
                        <a href="<?php echo get_permalink() ?>">
                            <?php if($post == "cv_job"):?>
                            <?php custom_thumb(get_the_ID(), $thumb_key = "_cover_image")?>
                            <?php else:?>
                            <?php the_post_thumbnail(array(80, 80), array('class' => 'pull-left')) ?>
                            <?php endif;?>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><a href="<?php echo get_permalink() ?>"><?php the_title() ?></a></h4>
                        <?php if ($disp_views): ?>
                            <p><small><i><?php echo get_the_time("Y-m-d") ?></i></small></p>
                        <?php endif ?>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;



        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = intval($new_instance['limit']);
        $instance['type'] = strip_tags($new_instance['type']);
        $instance['disp_views'] = strip_tags($new_instance['disp_views']);
        return $instance;
    }

// Display Widget Control Form
    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => __('Title', 'wp-postrecent'), 'type' => 'post', 'mode' => 'both', 'limit' => 5, 'disp_views' => 0));
        $title = esc_attr($instance['title']);
        $limit = intval($instance['limit']);
        $type = ($instance['type']);
        $disp_views = intval($instance['disp_views']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-postrecent'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Number of posts to show:', 'wp-postrecent'); ?> 
                <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $limit; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Custom Type:', 'wp-postrecent'); ?> 
                <input class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" type="text" value="<?php echo $type; ?>" placeholder="post, custom post type" /></label>
        </p>
        <p>
            <label><input type="checkbox" id="disp_views" name="<?php echo $this->get_field_name('disp_views'); ?>" value="1" <?php checked($disp_views, "1"); ?>>
                <?php _e(' Display post date?', 'wp-postrecent'); ?></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
        <?php
    }

}

add_action('widgets_init', 'bzb_widget_last_post_init');

function bzb_widget_last_post_init() {
    register_widget('WP_Widget_Post_Last');
}
