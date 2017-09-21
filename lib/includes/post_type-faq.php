<?php

function baito_faq() {
    $labels = array(
        'all_items' => 'FAQ',
        'menu_name' => 'FAQ',
        'singular_name' => 'FAQs',
        'edit_item' => 'Edit FAQ',
        'new_item' => 'Add New FAQ',
        'view_item' => 'View FAQ',
        'items_archive' => 'FAQs Archive',
        'search_items' => 'Search FAQs',
        'not_found' => 'No faq found',
        'not_found_in_trash' => 'No faq found in trash'
    );

    $args = array(
        'labels' => $labels,
        'supports' => array('title', 'editor'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 12,
        'menu_icon' => get_template_directory_uri() . '/img/icons/faq-icon.png',
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
    );
    register_post_type('faq', $args);
}

add_action('init', 'baito_faq');

add_action('init', 'faq_category');

function faq_category() {
    register_taxonomy('category_faq', 'faq', array(
        'label' => 'FAQs Category',
        'labels' => array(
            'name' => __('Category'),
            'add_new_item' => __('New FAQ Category'),
            'add_new' => __('Add FAQ Category'),
            'edit_item' => __('Edit FAQ Category'),
            'singular_name' => 'FAQ Category',
            'all_items' => 'All FAQs Category',
            'search_items' => 'Search FAQ Category',
        ),
        'public' => true,
        'hierarchical' => FALSE,
        'query_var' => true,
        'rewrite' => true
            )
    );
}
