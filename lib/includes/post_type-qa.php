<?php

function baito_qa() {
    $labels = array(
        'all_items' => 'Q&A',
        'menu_name' => 'Q&A',
        'singular_name' => 'Q&A',
        'edit_item' => 'Edit Q&A',
        'new_item' => 'Add New Q&A',
        'view_item' => 'View Q&A',
        'items_archive' => 'Q&A Archive',
        'search_items' => 'Search Q&A',
        'not_found' => 'No q&a found',
        'not_found_in_trash' => 'No q&a found in trash'
    );

    $args = array(
        'labels' => $labels,
        'supports' => array('title'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 13,
        'menu_icon' => get_template_directory_uri() . '/img/icons/q&a-icon.png',
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
    );
    register_post_type('qa', $args);
}

add_action('init', 'baito_qa');

add_action('init', 'qa_category');

function qa_category() {
    register_taxonomy('category_qa', 'qa', array(
        'label' => 'Q&A Category',
        'labels' => array(
            'name' => __('Category'),
            'add_new_item' => __('New Q&A Category'),
            'add_new' => __('Add Q&A Category'),
            'edit_item' => __('Edit Q&A Category'),
            'singular_name' => 'Q&A Category',
            'all_items' => 'All Q&A Category',
            'search_items' => 'Search Q&A Category',
        ),
        'public' => true,
        'hierarchical' => true,
        'query_var' => true,
        'rewrite' => true
            )
    );
}

$meta_box_qa = array(
    'id' => "baito_qa",
    'title' => __('Box Q&A', 'baito'),
    'page' => 'qa',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array('id' => '_qa_question', 'label' => __('Nội dung câu hỏi', 'baito'), 'type' => 'textarea'),
        array('id' => '_qa_answer', 'label' => __('Nội dung trả lời', 'baito'), 'type' => 'textarea'),
    )
);

function baito_add_box_qa() {
    global $meta_box_qa;
    add_meta_box($meta_box_qa['id'], $meta_box_qa['title'], 'baito_metabox_qa', $meta_box_qa['page'], $meta_box_qa['context'], $meta_box_qa['priority']);
}

add_action('admin_menu', 'baito_add_box_qa');

function baito_metabox_qa() {
    global $meta_box_qa, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="metabox_qa_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($meta_box_qa['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
        '<td><label for="', $field['id'], '"><strong>', $field['label'], '</strong></label></td></tr>',
        '<tr><td>';
        switch ($field['type']) {
            case 'textarea':
                wp_editor($meta ? $meta : $field['std'], $field['id'], array('textarea_rows' => '5'));
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
function meta_qa_save_data($post_id) {
    global $meta_box_qa;

    // verify nonce
    if (!wp_verify_nonce($_POST['metabox_qa_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('qa' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($meta_box_qa['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}

add_action('save_post', 'meta_qa_save_data');
