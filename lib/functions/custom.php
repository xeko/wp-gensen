<?php

//Change show default of tag
add_filter('get_terms_args', 'editor_show_tags');

function editor_show_tags($args) {
    if (defined('DOING_AJAX') && DOING_AJAX && isset($_POST['action']) && $_POST['action'] === 'get-tagcloud') {
        unset($args['number']);
        $args['hide_empty'] = 0;
    }
    return $args;
}

function get_terms_hierarchical($terms, $is_select = "", $output = '', $parent_id = 0, $level = 0) {
    //Out Template
    $outputTemplate = '<option value="%ID%" %SELECTED%>%PADDING%%NAME%</option>';

    foreach ($terms as $term) {
        if ($parent_id == $term->parent) {
            //Replacing the template variables
            $itemOutput = str_replace('%ID%', $term->term_id, $outputTemplate);
            $itemOutput = str_replace('%PADDING%', str_pad('', $level * 12, '&nbsp;&nbsp;'), $itemOutput);
            $itemOutput = str_replace('%NAME%', $term->name, $itemOutput);
            if (!empty($is_select) && $is_select == $term->term_id)
                $itemOutput = str_replace('%SELECTED%', 'selected', $itemOutput);

            $output .= $itemOutput;
            $output = get_terms_hierarchical($terms, $is_select, $output, $term->term_id, $level + 1);
        }
    }
    return $output;
}

function place_filter_function() {
    $data = array();
    $args = array();

    // for taxonomies / categories
//    if (isset($_POST['categoryfilter']))
//        $args['tax_query'] = array(
//            array(
//                'taxonomy' => 'category',
//                'field' => 'id',
//                'terms' => $_POST['categoryfilter']
//            )
//        );
//
//    // create $args['meta_query'] array if one of the following fields is filled
//    if (isset($_POST['price_min']) && $_POST['price_min'] || isset($_POST['price_max']) && $_POST['price_max'] || isset($_POST['featured_image']) && $_POST['featured_image'] == 'on')
//        $args['meta_query'] = array('relation' => 'AND'); // AND means that all conditions of meta_query should be true
//
//        
//// if both minimum price and maximum price are specified we will use BETWEEN comparison
//    if (isset($_POST['price_min']) && $_POST['price_min'] && isset($_POST['price_max']) && $_POST['price_max']) {
//        $args['meta_query'][] = array(
//            'key' => '_price',
//            'value' => array($_POST['price_min'], $_POST['price_max']),
//            'type' => 'numeric',
//            'compare' => 'between'
//        );
//    } else {
//        // if only min price is set
//        if (isset($_POST['price_min']) && $_POST['price_min'])
//            $args['meta_query'][] = array(
//                'key' => '_price',
//                'value' => $_POST['price_min'],
//                'type' => 'numeric',
//                'compare' => '>'
//            );
//
//        // if only max price is set
//        if (isset($_POST['price_max']) && $_POST['price_max'])
//            $args['meta_query'][] = array(
//                'key' => '_price',
//                'value' => $_POST['price_max'],
//                'type' => 'numeric',
//                'compare' => '<'
//            );
//    }

    $args['post_type'] = 'place';
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args['paged'] = $paged;
    $args['post_status'] = 'publish';
    // if post thumbnail is set
    if (isset($_POST['filter']))
        $conditions['meta_query'][] = array(
            'taxonomy' => 'filter',
            'field' => 'term_id',
            'terms' => $_REQUEST['filter'],
            'operator' => 'IN'
        );

    $args['tax_query'] = $conditions;

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()): $query->the_post();
            ?>
            <div class="row row_dotted">
                <div class="col-sm-3">
                    <a href="<?php the_permalink() ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
                            </a>
                        <?php endif; ?>
                    </a>
                </div>                    
                <div class="col-sm-9">
                    <a href="<?php the_permalink() ?>" class="job-title"><?php the_title() ?></a>

                    <a href="<?php the_permalink() ?>" class="pull-right">Chi tiết <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                </div>
            </div>
            <?php
        endwhile;
    else:
        echo "Not found";
    endif;
    wp_reset_postdata();

//    echo wp_json_encode($data);
    die();
}

add_action('wp_ajax_place_filter', 'place_filter_function');
add_action('wp_ajax_nopriv_place_filter', 'place_filter_function');

function tab_content_ajax() {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $(".tabs-menu li a").on("click", function (e) {
                e.preventDefault();
                currTab = $(".tabs-menu li a");
                linkID = $(this).attr("data-attr");
                link_category = $('.button-wrap a');
                var std;
                std = $(this).attr("href");
                $.ajax({
                    url: "<?php echo admin_url('admin-ajax.php') ?>",
                    type: 'POST',
                    data: {
                        'action': 'tab_ajax',
                        'id': $(this).attr("data-attr"),
                    },
                    dataType: "html",
                    beforeSend: function () {
                        $('.tab').addClass("loading");
                    },
                    success: function (data) {
                        $('.loading').removeClass('loading');
                        $(".tab-content").html(data);
                        $(".tab-content").attr('id', std);
                        $(link_category).attr("data-post_id", linkID);
                    }
                });
            });
        });
    </script>
    <?php
}

add_action('wp_footer', 'tab_content_ajax');

add_action('wp_ajax_nopriv_tab_ajax', 'post_by_taxonomy');
add_action('wp_ajax_tab_ajax', 'post_by_taxonomy');

function post_by_taxonomy() {
    $term_ID = intval($_REQUEST['id']);

    $location_args = array(
        'post_type' => 'place',
        'post_status' => 'publish',
        'posts_per_page' => 8,
        'tax_query' => array(
            array(
                'taxonomy' => 'location',
                'field' => 'id',
                'terms' => $term_ID
            ),
        ),
    );
    $place_location = new WP_Query($location_args);
    if ($place_location->have_posts()) :
        while ($place_location->have_posts()) : $place_location->the_post();
            ?>
            <div class="col-xs-6 col-sm-4 col-md-3 item">
                <div class="post-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <a class="item-desc" href="<?php the_permalink() ?>"><?php the_title() ?><?php // print_r($place_location)      ?></a>
            </div>
            <?php
        endwhile;

    endif;
    if ($place_location->post_count == 8):
        $term_link = get_term_link((int) $term_ID, 'location');
        ?>
        <div class="clearfix"></div>
        <div class="button-wrap">
            <a href="<?php echo $term_link ?>" data-post_id="<?php echo $term_ID ?>">エリアの一覧記事を見る <i class="fa fa-angle-right"></i></a>
        </div>
        <?php
    endif;
    wp_reset_postdata();

    die();
}

function get_taxonomies_terms($post_id, $taxonomy_slug) {

    $out = array();

    $terms = get_the_terms($post_id, $taxonomy_slug);

    if (!empty($terms)) {
        $out[] = "<ul class='list-inline' id='job_cate'>";
        foreach ($terms as $term) {
            $out[] = sprintf('<li><a href="%1$s" title="' . $term->name . '" target="_blank">%2$s</a></li>', esc_url(get_term_link($term->slug, $taxonomy_slug)), esc_html($term->name)
            );
        }
        $out[] = "\n</ul>\n";
    }

    return implode('', $out);
}

add_action('wp_head', 'like_counter');

function like_counter() {
    ?>
    <script type="text/javascript" >

        jQuery(function ($) {
            $("#go").click(function (event) {
                var btnGO;
                btnGO = $(this);
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        'action': 'count_like',
                        'place_id': <?php echo get_the_ID() ?>
                    },
                    success: function (data) {
                        $('.count-number-like').html(data);
                        $(btnGO).css({'pointer-events': 'none', 'cursor': 'default'})
                        console.log(data);
                    }
                });
            });
        });
    </script>
    <?php
}

function counter_like_ajax() {
    global $place_id, $like_key;
    $place_id = $_POST['place_id'];
    $like_key = 'counter_like';

    $auto_count = get_post_meta($place_id, $like_key, true);

    if (empty($auto_count)) {
        add_post_meta($place_id, $like_key, 1);
    } else {
        $auto_count += 1;
        update_post_meta($place_id, $like_key, $auto_count);
    }
    echo $auto_count;
    wp_die();
}

add_action('wp_ajax_count_like', 'counter_like_ajax');
add_action('wp_ajax_nopriv_count_like', 'counter_like_ajax');

/**
 * Edit comment form
 */
function custom_form_comment($comment, $args, $depth) {
    if ('div' === $args['style']) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ('div' != $args['style']) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ($args['avatar_size'] != 0) echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'img-circle')); ?>
            <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()); ?>
        </div>
        <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.'); ?></em>
            <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
                <?php
                /* translators: 1: date, 2: time */
                printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time());
                ?></a><?php edit_comment_link(__('(Edit)'), '  ', '');
                ?>
        </div>

        <?php comment_text(); ?>

        <div class="reply">
            <?php comment_reply_link(array_merge($args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
        </div>
        <?php if ('div' != $args['style']) : ?>
        </div>
    <?php endif; ?>
    <?php
}

function hoatv_move_comment_form_below($fields) {
    $comment_field = $fields['comment'];
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter('comment_form_fields', 'hoatv_move_comment_form_below');

/**
 * 
 * @param type $atts
 * @param type $content
 * Get instagram of image
 */
function get_instagram($atts = "", $content = "") {
    $url = "https://www.instagram.com/relux_jp/media/";

    $content = wp_remote_get($url);
    $data = json_decode($content['body']);
    $data = $data->items;
    ?>

    <ul id="list-gal" class="bxslider">
        <?php
        if (!empty($data)):
            foreach ($data as $value) {
//                $img_link = $value->images->standard_resolution->url;
                $img_link = $value->images->low_resolution->url;
                ?>
                <li><a href="<?php echo $value->link ?>" target="_blank"><img src="<?php echo $img_link; ?>" /></a></li>
            <?php } endif; ?>
    </ul><!--End list-gal-->                

    <?php
}

add_filter('widget_text', 'do_shortcode');
add_shortcode('place_raking', 'func_place_ranking');

function func_place_ranking() {
    ob_start();
    $rate_args = array(
        'posts_per_page' => 3,
        'post_type' => 'place',
        'post_status' => 'publish',
        'meta_key' => 'counter_like',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );
    $place_rate_query = new WP_Query($rate_args);
    echo '<ul class="clearfix" id="place_ranking">';
    if ($place_rate_query->have_posts()) :
        while ($place_rate_query->have_posts()) : $place_rate_query->the_post();
            ?>
            <li>
                <div class="place_thumb>"
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php echo get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'img-responsive')); ?>
                            </a>
                        <?php endif; ?>
                </div><!--End .place_thumb-->
                <div class="rate"><?php echo get_post_meta(get_the_ID(), 'counter_like', true); ?> <i class="fa fa-heart-o" aria-hidden="true"></i></div>
                <a class="place_titl" href="<?php the_permalink() ?>"><?php the_title() ?></a>
            </li>
            <?php
        endwhile;
    endif;
    wp_reset_postdata();
    echo '</ul>';

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
