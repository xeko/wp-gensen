<?php

/*Popular Posts by Views*/
function wp_set_post_views($postID) {
    global $count_key;
    $count_key = 'baito_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function wp_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    wp_set_post_views($post_id);
}
add_action( 'wp_head', 'wp_track_post_views');

function wp_get_post_views($postID){
    global $count_key;
    
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}


//Function: Gets the number of Post Views to be used later.
function get_PostViews($post_ID){
    global $count_key;
    $count = get_post_meta($post_ID, $count_key, true);
    $count = empty($count) ? 0: $count;
    return $count;
}
//Function: Add/Register the Non-sortable 'Views' Column to your Posts tab in WP Dashboard.
function post_column_views($newcolumn){
    
    $newcolumn['post_views'] = __('Views');
    return $newcolumn;
}
//add_filter( 'manage_posts_columns', 'post_column_views' );
 
function post_custom_column_views($column_name, $id){   
    if($column_name === 'post_views'){
        echo get_PostViews(get_the_ID()) . ' views';
    }
}
add_action('manage_posts_custom_column', 'post_custom_column_views',10,2);
 
function register_post_column_views_sortable( $newcolumn ) {
    $newcolumn['post_views'] = 'post_views';
    return $newcolumn;
}
add_filter( 'manage_edit-post_sortable_columns', 'register_post_column_views_sortable' );
 
function sort_views_column( $vars ) 
{
    global $count_key;
    if ( isset( $vars['orderby'] ) && 'post_views' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => $count_key,
            'orderby' => 'meta_value_num')
        );
    }
    return $vars;
}
add_filter( 'request', 'sort_views_column' );

function top_views($params) {
    global $count_key;
    $display = isset($params['num']) ? (int) $params['num'] : 5;
    
    $conditions = array( 
        'post_type' => array('post'),
        'posts_per_page' => $display,         
        'post_status' => 'publish',
        'meta_key' => $count_key, 
        'orderby' => 'meta_value_num', 
        'order' => 'DESC'  
    );    
    
    $return_str .= '';
 
    $return_str .= '<ul id="top-view" class="list-unstyled">';
    $query = new WP_query($conditions);
    if ($query->have_posts()): while ($query->have_posts()): $query->the_post();            
        $count = get_post_meta(get_the_ID(), $count_key, true);
        $return_str .= '<li>
            <a href="' . get_permalink(get_the_ID()) . '" title="' . get_the_title() . '" class="zoom-effect">
            <figure class="eyecatch">' . get_the_post_thumbnail(get_the_ID(), array(80, 80), array('class' => 'pull-left')) .'</figure>'. get_the_title() . '
            <ul id="post-meta" class="list-inline list-unstyled">
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> ' . get_the_time("Y-m-d", get_the_ID()) . '</li>
                        <li><i class="fa fa-eye" aria-hidden="true"></i> '.$count.' views</li>
                    </ul>
            ';
        $return_str .= '</a></li> ';
        endwhile;
    endif;
    wp_reset_query();
    $return_str .= '</ul>';
    return $return_str;    
}

add_shortcode('top_views', 'top_views');

add_filter('manage_edit-post_columns', 'my_edit_post_columns');

function my_edit_post_columns($columns) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => '名前',
        'categories'  => 'カテゴリー',
        'image' => __('画像'),
        'post_views' => __('Views'),
        'date' => __('日時')
    );

    return $columns;
}

add_action('manage_post_posts_custom_column', 'my_manage_post_columns', 10, 2);

function my_manage_post_columns($column, $post_id) {

    switch ($column) {
        case 'image':
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ));
            if(!empty($image))
                echo "<img src='".esc_url($image[0])."' width='60' />";
            break;
        default :
            break;
    }
}