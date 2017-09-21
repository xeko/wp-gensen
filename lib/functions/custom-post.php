<?php
/* Eventのカスタム投稿タイプ
* ---------------------------------------- */
add_action('init', 'bzb_cta_custom_post_type');
function bzb_cta_custom_post_type() {
  $labels = array(
    'name'                => 'Event',
    'singular_name'       => 'Event',
    'add_new_item'        => '新しいEventを追加',
    'add_new'             => '新規追加',
    'new_item'            => '新しいEvent',
    'view_item'           => 'Eventを表示',
    'not_found'           => 'Eventはありません',
    'not_found_in_trash'  => 'ゴミ箱にEventはありません。',
    'search_items'        => 'Eventを検索',
  );
  $args = array(
    'labels'              => $labels,
    'public'              => true,
      'publicly_queryable' => true,
    'show_ui'             => true,
      'show_in_menu' => true, //Hiển thị trên Admin Menu
    'query_var'           => true,
    'hierarchical'        => false,
    'menu_position'       => 5,
    'has_archive'         => true,//true thì hàm sau mới có hiệu lực: get_post_type_archive_link("event")
    'supports'            => array(
      'title',
      'editor',
      'thumbnail',
      'page-attributes'
      )
  );
  register_post_type('event', $args);
  flush_rewrite_rules( false );  /* これです。 */

}

$meta_box = array(
    'id' => "event_options",
    'title' => __('Event Option'),
    'page' => 'page_event',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array('id' => '_map', 'label' => __('地図'), 'type' => 'text'),
        array('id' => '_event_place', 'label' => __('場所'), 'type' => 'text'),
        array('id' => '_event_time', 'label' => __('日時'), 'type' => 'text'),
        array('id' => '_job_session', 'label' => __('季節'), 'type' => 'select', 'options' => $season),
    )
);

function event_add_box() {
    global $meta_box;
    add_meta_box($meta_box['id'], $meta_box['title'], 'event_show_box', 'event', $meta_box['context'], $meta_box['priority']);
}

add_action('admin_menu', 'event_add_box');

function event_show_box() {
    global $meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="event_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
        '<th style="width:40px;"><label for="', $field['id'], '">', $field['label'], '</label></th>',
        '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', htmlspecialchars($meta) ? htmlspecialchars($meta) : htmlspecialchars($field['std']), '" size="30" style="width:97%" />', '<br />', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
            case 'image':
                $display = $meta == "" ? "none" : "inline-block";
                echo '<input class="element-upload" name="', $field['id'], '" type="hidden" value="' . $meta . '" />';
                echo '<a href="javascript;;" id="cover_image_button" class="button button-primary">Select Image</a> ';
                echo '<a href="javascript;;" class="remove-image button after-upload" style="display: ' . $display . '">Remove</a>';
                echo '<div class="image" style="margin-top: 8px;">';
                if (!empty($meta)) {
                    echo wp_get_attachment_image($meta, array("100", "100"));
                }
                echo '</div>';
                break;
        }
        echo '<td>',
        '</tr>';
    }

    echo '</table>';
}

// Save data from meta box
function event_meta_save_data($post_id) {
    global $meta_box;

    // verify nonce
    if (!wp_verify_nonce($_POST['event_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('event' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

add_action('save_post', 'event_meta_save_data');


/* LPのカスタム投稿タイプ
* ---------------------------------------- */
//add_action('init', 'bzb_lp_custom_post_type');
function bzb_lp_custom_post_type() {
  $labels = array(
    'name'                => 'LP',
    'singular_name'       => 'LP',
    'add_new_item'        => '新しいLPを追加',
    'add_new'             => '新規追加',
    'new_item'            => '新しいLP',
    'view_item'           => 'LPを表示',
    'not_found'           => 'LPはありません',
    'not_found_in_trash'  => 'ゴミ箱にLPはありません。',
    'search_items'        => 'LPを検索',
  );
  $args = array(
    'labels'              => $labels,
    'public'              => true,
    'show_ui'             => true,
    'query_var'           => true,
    'hierarchical'        => false,
    'menu_position'       => 5,
    'has_archive'         => false,
    'capability_type'     => 'page',
    'supports' => array(
      'title',
      'editor',
      'thumbnail',
      'page-attributes'
      )
  ); 
  register_post_type('lp', $args);
  flush_rewrite_rules( false );  /* これです。 */

}
