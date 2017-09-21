<?php get_header(); ?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div id="box-search-ajax">                    
                    <h2><span>絞り込み検索</span></h2>
                    <?php
                    $feature_category = isset($_REQUEST['feature_category'])? $_REQUEST['feature_category']: array();
                    ?>
                    
                    <form action="<?php echo esc_url(home_url('/')); ?>" id="filter">
                        <div class="row clearfix">                        
                            <input type="hidden" name="post_type" value="place" />
                            <input type="hidden" name="area_category" value="<?php echo (!empty($_REQUEST["area_category"])) ? $_REQUEST["area_category"] : '' ?>" />
                            <input type="hidden" name="s" value="<?php echo (!empty($_REQUEST["s"])) ? $_REQUEST["s"] : '' ?>" />
                            <?php
                            if (!empty(array($feature_category))):
                                foreach ($feature_category as $feature_val):
                                    ?>
                                    <input type="hidden" name="feature_category[]" value="<?php echo $feature_val ?>" />
                                <?php
                                endforeach;
                            endif;
                            ?>
                            <?php                            
                            $filter_val = (!empty($_REQUEST['filter'])) ? $_REQUEST['filter'] : array();
                            
                            $filters = get_terms('filter', array('hide_empty' => 0));

                            foreach ($filters as $filt):                                
                                ?>
                                <label class="col-sm-3 col-xs-6">
                                    <input type="checkbox" name="filter[]" value="<?php echo $filt->term_id ?>" <?php checked(in_array($filt->term_id, $filter_val))?>><span> <?php echo $filt->name ?></span>
                                </label>
                            <?php endforeach; ?>                                                        
                            <input type="hidden" name="action" value="place_filter">
                            <div id="response"></div>
                        </div>
                    </form>
                </div><!--End #box-search-ajax-->
                <div id="box-content">
                <?php get_template_part('place-loop'); ?>
                </div>
                <?php get_template_part('pagination'); ?>

            </div>
            <div class="col-md-3">
                <sidebar>
<?php get_sidebar('place'); ?>
                </sidebar>
            </div>
        </div>
    </div>
</div><!--End #content-->

<?php
get_footer();
