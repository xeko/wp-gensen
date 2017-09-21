<?php

function func_place_onsen() {
    $labels = array(
        'all_items' => 'Place',
        'menu_name' => 'Place',
        'singular_name' => 'Place',
        'edit_item' => 'Edit Place',
        'new_item' => 'Add New Place',
        'view_item' => 'View Place',
        'items_archive' => 'Place Archive',
        'search_items' => 'Search Place',
        'not_found' => 'No place found',
        'not_found_in_trash' => 'No place found in trash'
    );

    $args = array(
        'labels' => $labels,
        'supports' => array('title', 'author', 'revisions', 'thumbnail', 'editor', 'comments'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 10,
        'menu_icon' => get_template_directory_uri() . '/lib/images/icon/place.png',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
    );
    register_post_type('place', $args);
}

add_action('init', 'func_place_onsen');

add_action('init', 'location_category');

function location_category() {
    register_taxonomy('location', 'place', array(
        'label' => 'Location',
        'labels' => array(
            'name' => __('Location'),
            'add_new_item' => __('New Location'),
            'add_new' => __('Add Location'),
            'edit_item' => __('Edit Location'),
            'singular_name' => 'Location',
            'all_items' => 'All Location',
            'search_items' => 'Search Location',
        ),
        'public' => true,
        'hierarchical' => true,
        'query_var' => true,
        'rewrite' => true
            )
    );
}

add_action('init', 'place_feature');

function place_feature() {
    register_taxonomy('feature', 'place', array(
        'label' => 'Feature',
        'labels' => array(
            'name' => __('Feature'),
            'all_items' => __('All Feature'),
            'add_new_item' => __('New Feature'),
            'add_new' => __('Add Feature'),
            'edit_item' => __('Edit Feature'),
            'singular_name' => 'Feature',
            'search_items' => 'Search Feature',
        ),
        'public' => true,
        'hierarchical' => true,
        'query_var' => true,
        'rewrite' => true
            )
    );
}

add_action('init', 'place_option');

function place_option() {
    register_taxonomy('filter', 'place', array(
        'label' => 'Filter',
        'labels' => array(
            'name' => __('Filter'),
            'all_items' => __('All Filter'),
            'add_new_item' => __('New Filter'),
            'add_new' => __('Add Filter'),
            'edit_item' => __('Edit Filter'),
            'singular_name' => 'Filter',
            'search_items' => 'Filter',
        ),
        'public' => true,
        'hierarchical' => false,
        'query_var' => true,
        'rewrite' => true
            )
    );
}