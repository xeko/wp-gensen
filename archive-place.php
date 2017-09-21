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
                    <?php get_template_part('place-loop'); ?>
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
