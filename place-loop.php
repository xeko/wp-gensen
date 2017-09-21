<?php
$conditions = array();

if (!empty($_REQUEST['area_category']))
    $place_location = array(
        'taxonomy' => 'location',
        'field' => 'term_id',
        'terms' => $_REQUEST['area_category'],
        'operator' => 'IN'
    );
if (!empty($_REQUEST['feature_category']))
    $place_feature = array(
        'taxonomy' => 'feature',
        'field' => 'term_id',
        'terms' => $_REQUEST['feature_category'],
        'operator' => 'IN'
    );
if (!empty($_REQUEST['filter']))
    $place_filter = array(
        'taxonomy' => 'filter',
        'field' => 'term_id',
        'terms' => $_REQUEST['filter'],
        'operator' => 'IN'
    );

$conditions = array(
    'relation' => 'AND',
    $place_feature,
    $place_location,
    $place_filter
);

$args['post_type'] = 'place';
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args['paged'] = $paged;
$args['post_status'] = 'publish';
$args['s'] = $_REQUEST['s'];

$args['tax_query'] = $conditions;

$wp_query = new WP_Query($args);

if ($wp_query->have_posts()) :
    while ($wp_query->have_posts()) : $wp_query->the_post();
        ?>
        <div class="event_single">
            <div class="row">
                <div class="col-sm-4">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
                        </a>
                    <div class="item-position"><?php echo get_post_meta(get_the_ID(), 'counter_like', true);?> <i class="fa fa-heart-o" aria-hidden="true"></i></div>
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
else:
    ?>

    <article>
        <h2 class="text-center"><?php _e('Sorry, nothing to display.'); ?></h2>
    </article>
<?php endif;