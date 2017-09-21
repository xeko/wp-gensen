<?php get_header('page'); ?>

<div id="content">        
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php bzb_breadcrumb(); ?>
                <section class="cat-content">
                    <header class="cat-header">
                        <h1 class="post-title"><?php bzb_title(); ?></h1>
                    </header>
                    <?php if (is_category()) { ?>
                        <?php bzb_category_description(); ?>
                    <?php } ?>

                </section>
                <?php
                $t_id = get_category(intval(get_query_var('cat')))->term_id;
                $cat_option = get_option('cat_' . $t_id);
                ?>

                <div class="post-loop-wrap">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            ?>
                            <article id="post-<?php echo the_ID(); ?>" <?php post_class('item'); ?>>
                                <a href="<?php the_permalink(); ?>">
                                    <div class="post-archive-wrapper">
                                        <?php if (get_the_post_thumbnail()) { ?>
                                            <?php the_post_thumbnail(); ?>
                                        <?php } else { ?>
                                            <img src="<?php echo get_template_directory_uri() ?>/lib/images/default.jpg" class="no-img" />
                                        <?php } ?>

                                        <div class="img-shade"></div>
                                    </div>
                                    <div class="post-title-bottom">
                                        <div class="paw-date"><?php the_time('Y.m.d'); ?></div>
                                        <h2><?php the_title(); ?></h2>
                                    </div>
                                </a>
                            </article>
                            <?php
                        endwhile;

                    else :
                        ?>

                        <article id="post-404"class="cotent-none post">
                            <section class="post-content" itemprop="text">
                                <?php echo get_template_part('content', 'none'); ?>
                            </section>
                        </article>

                    <?php
                    endif;
                    ?>
                    <div class="clearfix"></div>
                    <?php
                    if (function_exists("pagination")) {
                        echo '<div class="text-center">';
                            pagination($wp_query->max_num_pages);
                        echo '</div>';
                    }
                    ?>
                </div><!-- /post-loop-wrap -->
            </div>
            <div class="col-md-3">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>

</div><!-- /content -->

<?php
get_footer();
