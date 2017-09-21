<?php get_header('page'); ?>

<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <?php bzb_breadcrumb(); ?>
                <div id="main">

                    <?php
                    if (have_posts()) :

                        while (have_posts()) : the_post();
                            ?>


                            <?php $cf = get_post_meta($post->ID); ?>
                            <article id="post-<?php echo the_ID(); ?>" <?php post_class(); ?>>

                                <header class="post-header">
                                    <h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
                                </header>

                                <section class="post-content">

                                    <?php if (get_the_post_thumbnail()) : ?>
                                        <div class="post-thumbnail">
                                            <?php the_post_thumbnail(); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php the_content(); ?>
                                </section>


                            </article>

                            <?php
                        endwhile;

                    else :
                        ?>

                        <p>投稿が見つかりません。</p>

                    <?php
                    endif;
                    ?>

                </div><!-- /main -->
            </div>
            <div class="col-md-3">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div> 

</div><!-- /content -->

<?php
get_footer();
