<!DOCTYPE HTML>
<html lang="ja">
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
        <meta charset="UTF-8">
        <title><?php bzb_title(); ?></title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

        <?php wp_head(); ?>

        <?php echo get_option('analytics_tracking_code'); ?>
        <?php echo get_option('webmaster_tool'); ?>

    </head>

    <body <?php body_class(); ?>>

        <?php bzb_show_facebook_block(); ?>

        <?php if (is_singular('lp')) { ?>

            <div class="lp-wrap">

                <header id="lp-header">
                    <h1 class="lp-title"><?php wp_title(''); ?></h1>
                </header>

            <?php } else { ?>

                <header>

                    <div class="header-nav page">                            
                        <!--NAVIGATION-->
                        <?php
                        $logo_image = get_option('logo_image');
                        $logo_text = get_option('logo_text');
                        if (!empty($logo_image) && get_option('toppage_logo_type') == 'logo_image') :
                            $logo_inner = '<img src="' . get_option('logo_image') . '" alt="' . get_bloginfo('name') . '" />';
                        else:
                            if (!empty($logo_text) && get_option('toppage_logo_type') == 'logo_text') :
                                $logo_inner = get_option('logo_text');
                            else:
                                $logo_inner = get_bloginfo('name');
                            endif;
                        endif;
                        ?>                            
                        <nav class="navbar">
                            <div class="container">
                                <div class="row">
                                    <div class="pull-left">
                                        <div class="navbar-header">
                                            <a class="logo" href="<?php echo home_url() ?>"><?php echo $logo_inner ?></a>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <div id="menu_box">
                                            <div class="menu_ele">
                                                <div class="nav-search">
                                                    <div class="search-help togglebutton"><img src="<?php echo get_template_directory_uri() ?>/lib/images/icon_heart.png" alt=""> 結婚式のお役立ち情報を知りたい <i class="fa fa-caret-down"></i></div>
                                                    <div class="menu_togglein menu_items">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div id="submenu_top" class="clearfix">
                                                                    <div class="col-sm-6 visible-lg visible-md">
                                                                        <ul class="search-help-wrap list-inline">
                                                                            <li><a href="#"><i class="fa fa-rss"></i> 新着記事一覧</a></li>
                                                                            <li><a href="#"><i class="fa fa-video-camera"></i> 結婚式動画一覧</a></li>                                                                    
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="search-nav pull-right">
                                                                            <form role="search" method="get" id="searchform" action="">
                                                                                <div>
                                                                                    <input type="text" value="" name="s" id="s">
                                                                                    <button type="submit" id="searchsubmit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                                                </div>
                                                                            </form>                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="title"><img src="<?php echo get_template_directory_uri() ?>/lib/images/sample/icon_search_folder.png" alt="icon_paper"> 記事カテゴリーから探す</div>
                                                                    <ul class="cat_def list_cats">
                                                                        <?php
                                                                        $categories = get_categories('number=6');
                                                                        foreach ($categories as $category) {
                                                                            ?>
                                                                            <li>
                                                                                <a href="<?php echo esc_url(get_category_link($category->term_id)) ?>"><?php echo esc_html($category->cat_name) ?><span class="category_count"><?php echo esc_html($category->category_count) ?></span></a>
                                                                            </li>                                                                
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="title"><img src="<?php echo get_template_directory_uri() ?>/lib/images/sample/icon_paper.png" alt="icon_paper"> まとめ記事から探す</div>
                                                                    <ul class="list-inline summary">
                                                                        <li>
                                                                            <a href="#">何回やるの!? “結婚式の打ち合わせ”で決めることと失敗しないためのポイント</a>
                                                                        </li>
                                                                        <li><a href="#">いちいち可愛い♡大好きなピンクのコーディネート特集</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">非現実を味わうならリムジンを使ってみませんか？</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">12月の結婚式はクリスマスカラーが可愛い♡フラワーコーディネート〜ボルドー編〜</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#">春まで待ちどうしい♡フラワーコーディネート〜カラフル編〜</a>
                                                                        </li>                                                                            
                                                                    </ul>
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="menu_ele">
                                                <div class="nav-search">
                                                    <div class="togglebutton"><i class="fa fa-list-ul"></i> 他ページ</div>
                                                    <?php if (has_nav_menu('global_nav')) { ?>
                                                        <nav class="menu_togglein menu_items">
                                                            <?php
                                                            wp_nav_menu(
                                                                    array(
                                                                        'theme_location' => 'global_nav',
                                                                        'menu_id' => 'main_menu',
                                                                        'container' => 'ul'
                                                                    )
                                                            );
                                                            ?>
                                                        </nav><!--End .menu_items-->
                                                    <?php } ?>                                                
                                                </div>
                                            </div>
                                        </div><!--End #menu_box-->
                                    </div>                        
                                </div>
                        </nav>
                    </div><!-- .header-nav -->

                </header>

                <?php
            } // if is_singular('lp')
            
            