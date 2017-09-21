<?php get_header(); ?>

<div id="content">        
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php bzb_breadcrumb(); ?>
                <h1 class="post-title"><?php bzb_title(); ?></h1>
                <ul id="filter-box" class="clearfix">
                    <?php foreach ($season as $k => $sea): ?>
                        <li class="event-titl event-<?php echo $seasion_classname[$sea] ?>"><a href="<?php echo get_post_type_archive_link("event") ?>?season=<?php echo $sea ?>"><?php echo $sea ?></a></li>
                    <?php endforeach; ?>
                </ul><!--End #filter-box-->
                <div class="post-loop-wrap">
                    <?php
                    $meta_query = array();
                    $season = isset($_REQUEST['season']) ? sanitize_text_field($_REQUEST['season']) : '';
                    if (!empty($season)) {
                        $meta_query = array(
                            'key' => '_job_session',
                            'value' => $season,
                            'compare' => 'IN',
                        );
                    }
                    $event_args = array(
                        'post_type' => 'event',
                        'post_status' => 'publish',
                        'meta_query' => array($meta_query)
                    );
                    $event_query = new WP_Query($event_args);
                    
                    if ($event_query->have_posts()) :
                        while ($event_query->have_posts()) : $event_query->the_post();
                            $seasion = get_post_meta(get_the_ID(), '_job_session', true)
                            ?>
                            <div class="col-md-4 col-xs-12">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <article id="post-<?php echo the_ID(); ?>" <?php post_class('item'); ?>>
                                        <p class="event-s event-<?php echo $seasion_classname[$seasion] ?>"><span><?php echo $seasion ?></span></p>
                                        <?php if (has_post_thumbnail()) : ?>                                        
                                            <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>                                                                                    
                                        <?php endif; ?>
                                        <div class="post-event-titl"><?php the_title(); ?></div>
                                    </article>
                                </a>
                            </div>
                            <?php
                        endwhile;
                    endif;
                    ?>
                    <div class="clearfix"></div>
                    <?php
                    if (function_exists("pagination")) {
                        echo '<div class="text-center">';
                        pagination($event_query->max_num_pages);
                        echo '</div>';
                    }
                    ?>
                </div><!-- /post-loop-wrap -->
            </div>
            <div class="col-md-3">
                <?php get_sidebar('place'); ?>
            </div>
        </div>
    </div>

</div><!-- /content -->

<?php
get_footer();
