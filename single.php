<?php get_header(); ?>

<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php do_action('xeory_prepend_content'); ?>
                <?php do_action('xeory_prepend_wrap'); ?>

                <?php bzb_breadcrumb(); ?>
                <?php do_action('xeory_prepend_main'); ?>

                    <?php do_action('xeory_prepend_main-inner'); ?>

                    <?php
                    if (have_posts()) :

                        while (have_posts()) : the_post();
                            ?>

                            <?php
                            global $post;
                            $cf = get_post_meta($post->ID);
                            ?>
                            <article id="post-<?php the_id(); ?>" <?php post_class(); ?>>

                                <header class="post-header">
                                    <ul class="post-meta list-inline">
                                        <li class="date updated" datetime="<?php the_time('c'); ?>"><i class="fa fa-clock-o"></i> <?php the_time('Y.m.d'); ?></li>
                                    </ul>
                                    <h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
                                    <div class="post-header-meta">
                                        <?php bzb_social_buttons(); ?>
                                    </div>
                                </header>

                                <section class="post-content">

                                    <?php the_content(); ?>

                                </section>

                                <footer class="post-footer">

                                    <ul class="post-footer-list">
                                        <li class="cat"><i class="fa fa-folder"></i> <?php the_category(', '); ?></li>
                                        <?php
                                        $posttags = get_the_tags();
                                        if ($posttags) {
                                            ?>
                                            <li class="tag"><i class="fa fa-tag"></i> <?php the_tags(''); ?></li>
                                        <?php } ?>
                                    </ul>
                                </footer>

                                <?php echo bzb_get_cta($post->ID); ?>

                                <div class="post-share">

                                    <h4 class="post-share-title">SNSでもご購読できます。</h4>
                                    <?php
                                    if (is_active_sidebar('under_post_area')) {
                                        dynamic_sidebar('under_post_area');
                                    }
                                    ?>

                                    <?php
                                    $twitter_from_db = "https://twitter.com/" . esc_html(get_option('twitter_id'));
                                    $feedly_url = "http://cloud.feedly.com/#subscription%2Ffeed%2F" . urlencode(get_bloginfo('rss2_url'));
                                    ?>

                                    <aside class="post-sns">
                                        <ul>
                                            <li class="post-sns-twitter"><a href="<?php echo $twitter_from_db; ?>"><span>Twitter</span>でフォローする</a></li>
                                            <li class="post-sns-feedly"><a href="<?php echo $feedly_url; ?>"><span>Feedly</span>でフォローする</a></li>
                                        </ul>
                                    </aside>
                                </div>

                                <?php bzb_show_avatar(); ?>
                                
                            </article>


                            <?php
                        endwhile;

                    else :
                        ?>

                        <p>投稿が見つかりません。</p>

                    <?php
                    endif;
                    ?>

                    <?php do_action('xeory_append_main-inner'); ?>
                
            </div>
            <div class="col-md-3">
                <?php get_sidebar(); ?>
            </div>
            <?php do_action('xeory_append_wrap'); ?>
            <?php do_action('xeory_append_content'); ?>
        </div>
    </div>

   
    

</div><!-- /content -->

<?php
get_footer();


