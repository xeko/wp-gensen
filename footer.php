<footer id="footer">
    <div id="f-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="ibox-title">
                        <h4><span>エリア</span></h4>
                    </div>
                    <ul class="area-list text-left">
                        <?php
                        $loc_terms = get_terms('location', array('hide_empty' => false));

                        foreach ($loc_terms as $term_v):
                            if ($term_v->parent == 0):
                                ?>
                                <li><span><a href="<?php echo get_term_link($term_v, 'location') ?>"><?php echo $term_v->name; ?></a></span>
                                    <?php
                                    $term_v_child = get_term_children($term_v->term_id, 'location');
                                    if (!empty($term_v_child)):
                                        ?>
                                        <ul class="list-inline">
                                            <?php
                                            foreach ($term_v_child as $term_child):
                                                $term = get_term_by('id', $term_child, 'location');
                                                echo '<li><a href="' . get_term_link($term_child, 'location') . '">' . $term->name . '</a></li>';
                                            endforeach;
                                            ?>
                                        </ul>
                                    <?php endif;
                                    ?>
                                </li>
                                <?php
                            endif;

                        endforeach;
                        ?>
                    </ul>                        
                </div>
                <div class="col-md-6">
                    <div class="ibox-title">
                        <h4><span>特徴</span></h4>
                    </div>
                    <ul class="category_list row">
                        <?php
                        $feature_terms = get_terms('feature', array('hide_empty' => false));

                        foreach ($feature_terms as $term_fea):
                            ?>
                            <li class="col-md-4 col-xs-6"><span><a href="<?php echo get_term_link($term_fea->term_id, 'feature') ?>"><?php echo $term_fea->name; ?></a></span></li>
                            <?php
                        endforeach;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-wrap">
        <?php global $logo_inner; ?>
        <figure><?php echo $logo_inner ?></figure>
        <div class="footer-title">GENSEN</div>
        <div class="footer-desc">全国おすすめ温泉・温泉宿情報サイト</div>

        <ul class="list-inline footer-sns">
            <li class="facebook_icon"><a href="https://facebook.com" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
            <li class="twitter_icon"><a target="_blank" href="https://twitter.com"><i class="fa fa-twitter"></i></a></li>
            <li class="google_icon"><a target="_blank" href="https://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
            <li class="pinterest_icon"><a target="_blank" href="https://jp.pinterest.com"><i class="fa fa-pinterest"></i></a></li>
            <li class="instagram_icon"><a target="_blank" href="https://instagram.com"><i class="fa fa-instagram"></i></a></li>
        </ul>

    </div>
    <p class="copyright">
        © Copyright <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>. All rights reserved.
    </p>
</footer>
<div class="pagetop"></div>
<?php wp_footer(); ?>
</body>
</html>