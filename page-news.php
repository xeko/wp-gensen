<?php
/* Template Name: Page News */
get_header();
?>

<div id="content">
    <div id="top-page">
        <div class="container">
            <div class="row">
                <?php bzb_breadcrumb(); ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">                    
                    <?php
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => 'post',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'post_status' => 'publish',
                        'paged' => $paged
                    );

                    $temp = $wp_query;
                    $wp_query = null;
                    $wp_query = new WP_Query($args);

                    if ($wp_query->have_posts()):
                        while ($wp_query->have_posts()): $wp_query->the_post();
                            ?>
                            <div class="box-content">
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
                            <div class="clearfix"></div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>                    
                    <?php get_template_part('pagination'); ?>
                </div>
            </div>
            <div class="col-md-4">
                <sidebar>
                    <?php get_sidebar('place'); ?>
                </sidebar>
            </div>
        </div>
    </div>
</div><!--End #content-->

<?php
get_footer();
