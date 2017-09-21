<?php get_header(); ?>
<div id="frm_search" class="clearfix">
    <div class="container">
        <div class="clearfix">
            <div class="col-md-4">

            </div>
        </div>
    </div>
</div><!--End #frm_search-->

<div id="content" class="clearfix">
    <div class="container">
        <div id="intro">
            <h2 class="intro-title">絶景の湯宿。美味に舌鼓。全国おすすめ温泉地特集！</h2>
            <p>息を吞むほど美しい絶景が望める露天風呂に、新鮮な旬の食材を使った、心温まる郷土料理。<br />
                温泉好きであれば一度は行っておきたい、各地域を代表する人気の温泉地、温泉宿情報を余すところなくお伝えします。</p>
        </div><!--End #intro-->

    </div>
    <section id="article-special">
        <div class="container">
            <div class="news-icon">
                <figure><img src="<?php echo get_template_directory_uri() ?>/lib/images/icon_news.png" width="26" class="scale" /></figure>
            </div>
            <h3>誰もが知る有名温泉宿から、知る人ぞ知る秘湯の温泉宿まで、<br class="sp" />日本全国、津々浦々の温泉地から厳選した、とっておきの温泉情報を検索。</h3>
            <div class="row">
                <?php
                $place_args = array(
                    'posts_per_page' => 4,
                    'post_type' => 'place',
                    'post_status' => 'publish',
                    'meta_key' => 'counter_like', 
                    'orderby' => 'meta_value_num', 
                    'order' => 'DESC'
                );
                $place_query = new WP_Query($place_args);
                if ($place_query->have_posts()) :
                    while ($place_query->have_posts()) : $place_query->the_post();
                        ?>
                        <div class="col-xs-6 col-sm-4 col-md-3 item">
                            <div class="post-image">                            
                                <figure>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
                                        </a>
                                    <?php endif; ?>
                                </figure>

                            </div>
                            <div class="item-position"><?php echo get_post_meta(get_the_ID(), 'counter_like', true);?> <i class="fa fa-heart-o" aria-hidden="true"></i></div>
                            <a class="item-desc" href="<?php the_permalink() ?>"><?php the_title() ?></a>
                        </div>
                        <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>                
            </div>
        </div>
    </section><!--End #article-special-->
    <section id="post">
        <div class="container">
            <h2 class="t_h2"><span class="title">エリア<span>の</span>オススメ</span><span class="title-sub">結婚に関する記事</span></h2>
            <div class="content-desc">
                <p>理想の結婚式に役立つお得な情報を発信しています。</p>
                <p>結婚式の選び方やお呼ばれされた時の作法まで結婚に関わる情報をご覧いただけます。</p>
            </div>
            <div id="tabs-container">
                <?php
                $location_set = array(72, 38, 71, 48, 44);
                ?>
                <ul class="tabs-menu">
                    <?php
                    foreach ($location_set as $k => $lo_val):
                        $location_val = get_term($lo_val, 'location');
                        $term_link = get_term_link( $lo_val, 'location' );
                        ?>
                        <li class="<?php echo ($k == 0) ? 'current' : '' ?>"><a href="#tab-<?php echo $k ?>" data-attr="<?php echo $lo_val ?>"><?php echo $location_val->name ?></a></li>
                        
                    <?php endforeach; ?>
                </ul>
                <div class="row tab">
                    <div class="load_bg"><span class="load"></span></div>                    
                    <?php
                    $location_args = array(
                        'post_type' => 'place',
                        'post_status' => 'publish',
                        'posts_per_page' => 8,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'location',
                                'field' => 'id',
                                'terms' => $location_set[0]
                            ),
                        ),
                    );
                    ?>
                    <div id="tab-0" class="tab-content">                        
                        <?php
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
                                    <a class="item-desc" href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                </div>                                
                                <?php
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                        <?php
                        if($place_location->post_count == 8):
                            $term_link = get_term_link( $location_set[0], 'location' );
                        ?>
                        <div class="clearfix"></div>
                        <div class="button-wrap">
                            <a href="<?php echo $term_link?>" data-post_id="<?php echo current($location_set)?>">エリアの一覧記事を見る <i class="fa fa-angle-right"></i></a>
                        </div>
                        <?php endif;?>
                    </div>
                </div><!--End .tab-->                
                
            </div><!--End #tabs-container-->
        </div>
    </section><!--End #post-->
    <section id="wedding-hall">
        <div class="container">
            <h2 class="t_h2"><span class="title">NEWS</span><span class="title-sub">温泉ニュース・温泉宿ブログ</span></h2>
            <div class="content-desc">
                <span>思わずため息が漏れるほど美しい絶景を、露天風呂から望む。誰にも気兼ねのないプライベートな空間で、優雅で贅沢なひとときを。<br />
                    おすすめの温泉宿だけでなく、近隣の観光地に、レジャーやグルメまで、温泉旅行に役立つ情報が満載です。</span>
            </div>
            <div class="row">
                <?php
                $blog_args = array(
                    'posts_per_page' => 4,
                    'post_type' => 'post',
                    'post_status' => 'publish'
                );
                $blog_query = new WP_Query($blog_args);
                if ($blog_query->have_posts()) :
                    while ($blog_query->have_posts()) : $blog_query->the_post();
                        ?>
                        <div class="col-md-6">                    
                            <div class="row">
                                <div class="col-xs-12 col-md-4">
                                    <div class="post-image">
                                        <?php if (has_post_thumbnail()) : ?>                                    
                                            <?php the_post_thumbnail(array(600, 400), array('class' => 'img-responsive center-block')); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-8">
                                    <h4 class="media-heading"><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h4>
                                    <p>
                                        <?php
                                        if (mb_strlen(get_the_content(), 'UTF-8') > 80) {
                                            $content = mb_substr(strip_tags(get_the_content(), '<br><span>'), 0, 80, 'UTF-8');
                                            echo $content;
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
                <div class="clearfix"></div>
                <div class="button-wrap"><a href="<?php echo get_permalink(142)?>">一覧記事を見る <i class="fa fa-angle-right"></i></a></div>
            </div>
        </div>
    </section><!--End #wedding-hall-->    
    <section id="event">
        <div class="container">
            <h2 class="t_h2"><span class="title">EVENT</span><span class="title-sub">イベント</span></h2>
            <div class="content-desc"><span>温泉では、四季折々のまつりやイベントが開催されています。</span></div>
            <div class="row">
                <p class="ttitle">注目のインベント情報</p>
                <?php
                $event_args = array(
                    'post_type' => 'event',
                    'post_status' => 'publish',
                    'posts_per_page' => 4,
                    'orderby' => 'date',
                    'order' => 'DESC',
                );
                $event_query = new WP_Query($event_args);
                if ($event_query->have_posts()) :
                    while ($event_query->have_posts()) : $event_query->the_post();
                        $seasion = get_post_meta(get_the_ID(), '_job_session', true)
                        ?>
                        <div class="col-md-3">
                            <div class="event-box <?php echo $seasion_classname[$seasion] ?>-box">
                                <h4 class="media-heading"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
                                <p class="event_seasion <?php echo $seasion_classname[$seasion] ?>"><span><?php echo $seasion ?></span></p>                                
                                <p class="event_opt"><strong>日時:</strong> <?php echo get_post_meta(get_the_ID(), '_event_time', true) ?></p>
                                <p class="event_opt"><strong>開催場所:</strong> <?php echo get_post_meta(get_the_ID(), '_event_place', true) ?></p>
                                <div class="event-thumb">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink() ?>">
                                            <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
                                        </a>
                                    <?php endif; ?>
                                </div><!--End .event-thumb-->
                                <div class="event-body">
                                    <p>
                                        <?php
                                        if (mb_strlen(get_the_content(), 'UTF-8') > 80) {
                                            $content = mb_substr(strip_tags(get_the_content(), '<br><span>'), 0, 80, 'UTF-8');
                                            echo $content . '...';
                                        } else {
                                            the_content();
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>                    
                        </div>
                        <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
                <div class="clearfix"></div>
                <div class="button-wrap"><a href="<?php echo get_post_type_archive_link("event")?>">一覧イベントを見る <i class="fa fa-angle-right"></i></a></div>
            </div>
        </div>
    </section><!--End #event-->    
    <section id="sns">
        <div class="container">
            <h2 class="t_h2"><span class="title">INSTAGRAM</span><span class="title-sub">Instagramの写真</span></h2>
            <div class="instagram">
                <?php get_instagram(); ?>
            </div>
        </div>
    </section>

</div><!--End #content-->


<?php
get_footer();


