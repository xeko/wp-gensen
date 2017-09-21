<?php

if (!function_exists('baito_widgets_init')) :

    function baito_widgets_init() {

        // Default Sidebar (WP main sidebar)
        register_sidebar(
                array(// 1
                    'name' => __('Main Sidebar', 'baito'),
                    'id' => 'sidebar-main',
                    'description' => __('Default Blog Sidebar.', 'baito'),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h4 class="widget-title"><span>',
                    'after_title' => '</span></h4>'));

        // Job Sidebar (WP main sidebar)
        register_sidebar(
                array(// 2
                    'name' => __('Job Sidebar', 'baito'),
                    'id' => 'sidebar-job',
                    'description' => __('Default Sidebar for Job.', 'baito'),
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h4 class="widget-title"><span>',
                    'after_title' => '</span></h4>'));
    }

    add_action('widgets_init', 'baito_widgets_init');

endif;
