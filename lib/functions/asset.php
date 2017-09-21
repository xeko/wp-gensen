<?php

/* StyleSheet
* ---------------------------------------- */

if( !is_admin() ){
  add_action('wp_enqueue_scripts', 'bzb_add_style', 9);
  function bzb_register_style(){
    wp_register_style( 'bootstrap', get_template_directory_uri().'/lib/css/bootstrap.min.css' );
    wp_register_style( 'bxslider', get_template_directory_uri().'/lib/css/jquery.bxslider.min.css' );
    wp_register_style( 'base-css', get_template_directory_uri().'/base.css' );
    wp_register_style( 'animate', get_template_directory_uri().'/lib/css/animate.min.css' );
    wp_register_style( 'chosen', get_template_directory_uri().'/lib/css/chosen.min.css' );
    wp_register_style( 'custom-style', get_template_directory_uri().'/lib/css/custom-style.css' );
    wp_register_style( 'main-css', get_stylesheet_directory_uri().'/style.css',array('base-css') );
  }
  function bzb_add_style(){
    bzb_register_style();
    wp_enqueue_style('bootstrap');
    wp_enqueue_style('bxslider');
    wp_enqueue_style('headhesive');
    wp_enqueue_style('base-css');
    wp_enqueue_style('animate');
    wp_enqueue_style('chosen');
    wp_enqueue_style('main-css');
    wp_enqueue_style('custom-style');
  }
}
add_action('wp_enqueue_scripts', 'bzb_add_awesome_style', 9);
function register_awesome_font(){
  wp_register_style( 'font-awesome', get_template_directory_uri() . '/lib/fonts/font-awesome-4.5.0/css/font-awesome.min.css');
}

function bzb_add_awesome_style(){
  register_awesome_font();
  wp_enqueue_style('font-awesome');
}



/* JavaScript
* ---------------------------------------- */

if (!is_admin()) {
  add_action('wp_enqueue_scripts', 'bzb_add_script');
  function bzb_register_script(){
    // トップページへ戻る
    wp_register_script('bxslider', get_template_directory_uri().'/lib/js/jquery.bxslider.min.js', array('jquery'), false, true );
    wp_register_script('headhesive', get_template_directory_uri().'/lib/js/headhesive.min.js', array('jquery'), false, true );
    wp_register_script('matchHeight', get_template_directory_uri().'/lib/js/jquery.matchHeight-min.js', array('jquery'), false, true );
    wp_register_script('chosen', get_template_directory_uri().'/lib/js/chosen.jquery.min.js', array('jquery'), false, true );
    wp_register_script('custom', get_template_directory_uri().'/lib/js/custom.js', array('jquery'), false, true );
  }
  function bzb_add_script() {
    bzb_register_script();
    wp_enqueue_script('headhesive');
    wp_enqueue_script('bxslider');
    wp_enqueue_script('matchHeight');
    wp_enqueue_script('chosen');
    wp_enqueue_script('custom');
  }
}


/* admin
* ---------------------------------------- */
add_action('admin_enqueue_scripts', 'bzb_admin_asset');
function bzb_admin_asset(){

  // CSSファイルを登録
  wp_register_style( 'bzb_admin_css', get_template_directory_uri().'/style_admin.css' );
  // CSSファイルを表示
  wp_enqueue_style( 'bzb_admin_css' );

  // JSファイルを登録
  wp_register_script( 'bzb_admin_js', get_template_directory_uri().'/lib/js/bzb-admin.js', array('jquery') );
  //JSファイルを表示
  wp_enqueue_script('bzb_admin_js');
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-tabs');
}
