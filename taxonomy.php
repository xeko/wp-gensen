<?php get_header(); ?>
<div id="content">
    <div id="top-page">
        <div class="container">
            <div class="row">
                <?php bzb_breadcrumb(); ?>
                <div class="titl"><?php the_title() ?></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="box-content">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            ?>
                            <div class="event_single">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                                <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
                                            </a>
                                            <div class="item-position"><?php echo get_post_meta(get_the_ID(), 'counter_like', true); ?> <i class="fa fa-heart-o" aria-hidden="true"></i></div>
                                        <?php endif; ?>
                                    </div>                    
                                    <div class="col-sm-8">
                                        <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                                        <div class="event_sub">
                                            <div class="label-location clearfix">
                                                <?php echo get_taxonomies_terms(get_the_ID(), 'location'); ?>
                                            </div>
                                            <div class="label-featured clearfix">
                                                <?php echo get_taxonomies_terms(get_the_ID(), 'feature'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
<?php get_template_part('pagination'); ?>

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
