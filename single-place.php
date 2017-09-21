<?php get_header(); ?>
<?php global $like_place, $like_key; ?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php do_action('xeory_prepend_content'); ?>
                <?php do_action('xeory_prepend_wrap'); ?>

                <?php bzb_breadcrumb(); ?>
                <?php do_action('xeory_prepend_main'); ?>

                <?php do_action('xeory_prepend_main-inner'); ?>

                <?php
                if (have_posts()) :

                    while (have_posts()) : the_post();
                        ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <header class="post-header">
                                <h2 class="post-title"><?php the_title(); ?></h2>
                                <div class="label-location clearfix">
                                    <?php echo get_taxonomies_terms(get_the_ID(), 'location'); ?>
                                </div>
                                <div class="label-featured clearfix">
                                    <?php echo get_taxonomies_terms(get_the_ID(), 'feature'); ?>
                                </div>                                

                            </header>

                            <section class="post-content">

                                <?php if (get_the_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
                                    </div>
                                <?php endif; ?>
                                <?php the_content(); ?>

                            </section>

                            <?php edit_post_link(); ?>
                            <div class="tags-share-box">
                                <?php
                                $like_count = get_post_meta(get_the_ID(), 'counter_like', true);
                                ?>                                
                                <div class="text-center post-share">
                                    <span class="single-comment-o"><?php if (comments_open(get_the_ID())): ?><i class="fa fa-comment-o"></i> <?php echo number_format_i18n(get_comments_number()) ?> comments<?php endif; ?></span>
                                    <span class="count-number-like"><?php echo empty($like_count) ? 0 : $like_count ?></span> <a href="javascript:void(0)" id="go" data-post_id="<?php the_ID() ?>" class="btn" data-like="Like" title="気にする"><i class="fa fa-heart-o" aria-hidden="true"></i></a> 
                                    <div class="list-posts-share list-inline">                                        
                                        <a target="_blank" href="#"><i class="fa fa-facebook"></i><span class="dt-share">Facebook</span></a>
                                        <a target="_blank" href="#"><i class="fa fa-twitter"></i><span class="dt-share">Twitter</span></a>
                                        <a target="_blank" href="#"><i class="fa fa-google-plus"></i><span class="dt-share">Google +</span></a>
                                        <a target="_blank" href="#"><i class="fa fa-pinterest"></i><span class="dt-share">Pinterest</span></a>
                                    </div>
                                </div>
                            </div><!--End .tags-share-box-->
                            <?php
                            $next_post = get_next_post();
                            $previous_post = get_previous_post();
                            the_post_navigation(array(
                                'screen_reader_text' => ' ',
                                'next_text' => '<span class="hidden-xs hidden-sm pull-right">' . get_the_post_thumbnail($next_post->ID, 'thumbnail') . '</span><span class="next-title relate_titl">%title</span>',
                                'prev_text' => '<span class="hidden-xs hidden-sm pull-left">' . get_the_post_thumbnail($previous_post->ID, 'thumbnail') . '</span><span class="prev-title relate_titl">%title</span>',
                            ));
                            ?>

                            <div class="clearfix"></div>

                            <?php
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;
                            ?> 
                            <?php echo bzb_get_cta($post->ID); ?>

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
            <div class="col-md-4">
                <?php get_sidebar('place'); ?>
            </div>
            <?php do_action('xeory_append_wrap'); ?>
            <?php do_action('xeory_append_content'); ?>
        </div>
    </div>




</div><!-- /content -->

<?php
get_footer();


