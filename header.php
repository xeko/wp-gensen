<!DOCTYPE HTML>
<html lang="ja">
    <head>
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

        <header>
            <div class="header-nav">                
                <!--NAVIGATION-->
                <?php
                global $logo_inner;
                $logo_image = get_option('logo_image');
                $logo_text = get_option('logo_text');
                if (!empty($logo_image) && get_option('toppage_logo_type') == 'logo_image') :
                    $logo_inner = '<img src="' . get_option('logo_image') . '" alt="' . get_bloginfo('name') . '" width="170" />';
                else:
                    if (!empty($logo_text) && get_option('toppage_logo_type') == 'logo_text') :
                        $logo_inner = get_option('logo_text');
                    else:
                        $logo_inner = get_bloginfo('name');
                    endif;
                endif;
                $logo_wrap = ( is_front_page() || is_home() ) ? 'h1' : 'p';
                ?>                            
                <nav class="navbar">
                    <div class="container">
                        <a class="navbar-logo" href="<?php echo home_url() ?>"><?php echo $logo_inner; ?></a>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" id="btn-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <?php if (has_nav_menu('global_nav')) { ?>
                            <nav class="menu_togglein collapse navbar-collapse">
                                <?php
                                wp_nav_menu(
                                        array(
                                            'theme_location' => 'global_nav',
                                            'menu_id' => 'gnav',
                                            'container' => 'ul',
                                            'menu_class' => 'nav navbar-nav navbar-right'
                                        )
                                );
                                ?>
                            </nav><!--End .menu_items-->
                        <?php } ?>
                    </div>
                </nav>                
            </div><!-- .header-nav -->
            <?php if (is_front_page() || is_home()): ?>
            <ul id="main-slider">
                    <li>
                        <img src="<?php echo get_template_directory_uri() ?>/lib/images/slider/1.jpg" class="scale" data-scale="best-fill" data-align="center">
                        <div class="bx-content">
                            <h2>極楽の名湯、情緒あふれる憩いの湯宿を旅する。</h2>
                            <p>地元で採れる新鮮で旬な食材を使用した、贅沢なフルコース料理を愉しむ。<br/>
                                クラストップの和食懐石からフレンチ懐石まで、各地から訪れる食通を唸らせる、ここでしか味わえない絶品グルメをピックアップ。</p>
                            <a href="#" class="btn">グルメ特集を見る <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <li>
                        <img src="<?php echo get_template_directory_uri() ?>/lib/images/slider/2.jpg" class="scale" data-scale="best-fill" data-align="center">
                        <div class="bx-content">
                            <h2>夢想の絶景、風情感じる露天風呂で愉悦に浸る。</h2>
                            <p>夢にまで見た、超自然が織り成す雄大な景観を静寂が包む様はまさに桃源郷。<br/>
                                解放感あふれる風光明媚な大パノラマを愉しみながら湯に抱かれる。本当は秘匿しておきたい、とっておきの露天風呂をご紹介します。</p>
                            <a href="#" class="btn">グルメ特集を見る <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <li>
                        <img src="<?php echo get_template_directory_uri() ?>/lib/images/slider/3.jpg" class="scale" data-scale="best-fill" data-align="center">
                        <div class="bx-content">
                            <h2>夢想の絶景、風情感じる露天風呂で愉悦に浸る。</h2>
                            <p>夢にまで見た、超自然が織り成す雄大な景観を静寂が包む様はまさに桃源郷。<br/>
                                解放感あふれる風光明媚な大パノラマを愉しみながら湯に抱かれる。本当は秘匿しておきたい、とっておきの露天風呂をご紹介します。</p>
                            <a href="#" class="btn">グルメ特集を見る <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </li>
                    <li>
                        <img src="<?php echo get_template_directory_uri() ?>/lib/images/slider/4.jpg" class="scale" data-scale="best-fill" data-align="center">
                        <div class="bx-content">
                            <h2>美味に舌鼓、四季折々の旬なご馳走を堪能する。</h2>
                            <p>地元で採れる新鮮で旬な食材を使用した、贅沢なフルコース料理を愉しむ。<br/>
                                クラストップの和食懐石からフレンチ懐石まで、各地から訪れる食通を唸らせる、ここでしか味わえない絶品グルメをピックアップ。</p>
                            <a href="#" class="btn">グルメ特集を見る <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                        </div>
                    </li>
                </ul><!--End #main-slider-->

            <?php endif; ?>
            <div id="box-search" class ="clearfix">
                <?php
                $feature_arr = !empty($_REQUEST["feature_category"]) ? $_REQUEST["feature_category"] : array();

                if (!empty($_REQUEST["area_category"])):
                    $area_id = sanitize_key($_REQUEST["area_category"]);
                endif;

                $place_filter = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : array();
                ?>
                <form action="<?php echo esc_url(home_url('/')); ?>" name="frmSearch">                    
                    <input type="hidden" name="post_type" value="place" />
                    <?php
                    if (!empty(array($place_filter))):
                        foreach ($place_filter as $fil_val):
                            ?>
                            <input type="hidden" name="filter[]" value="<?php echo $fil_val ?>" />
                            <?php
                        endforeach;
                    endif;
                    ?>
                    <div class="container">
                        <div class="col-md-3">
                            <input class="chosen_keyword form-control" name="s" placeholder="キーワード" value="<?php echo get_search_query() ?>" >
                        </div>
                        <div class="col-md-3">
                            <?php
                            $terms = get_terms('location', array('hide_empty' => false));
                            $output = get_terms_hierarchical($terms, $area_id);

                            echo '<select class="chosen-area form-control chosen-select-deselect" name="area_category" placeholder="エリアから選ぶ"><option value="">エリアから選ぶ</option>' . $output . '</select>';
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                            $features = get_terms('feature', array('hide_empty' => 0));
                            echo '<select multiple="true" class="chosen-feature form-control" name="feature_category[]" data-placeholder="特徴から探す">';
                            foreach ($features as $feature) {
                                echo '<option value="' . $feature->term_id . '" ' . selected(in_array($feature->term_id, $feature_arr), 1) . '>' . $feature->name . '</option>';
                            }
                            echo '</select>';
                            ?>
                        </div>
                        <div class="col-md-3"><input type="submit" class="btn btn-block" value="検索する" /></div>
                    </div>
                </form>
            </div><!--End #box-search-->
        </header>


