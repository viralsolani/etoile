<?php
/**
 * Template Name: Blog Page
 */

get_header(); ?>
<div class="container-main">
<?php $page_banner_src    	= get_field('demo_page_banner');
      $default_banner_src 	= get_field('demo_default_page_banner', 'option');
      $page_banner_url		= !(empty ( $page_banner_src) ) ? $page_banner_src : $default_banner_src;

      if($page_banner_url){
        $image_welcome           = aq_resize( $page_banner_url, 1920, 500, true, false, true );
        $filter_page_banner_url  = $image_welcome ? $image_welcome[0] : '';
    }

      $new_option_title         = get_post_meta($post->ID, 'cms_title_digital', true );
?>


<?php $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        $posts_per_page = get_option('posts_per_page');
        $banner_args = array(
                            'posts_per_page' => $posts_per_page,
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'paged' => $paged

                        );
    $banner_query = new WP_Query($banner_args);
    if ($banner_query) {
?>
    <section class="inner_page blog_page">
                	<div class="container">
                    	<div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                                <div class="blogs">
                                <?php while ($banner_query->have_posts()) { $banner_query->the_post();
                                            $serivces_image_url_feat        = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                        if ($serivces_image_url_feat) {
                                            $ser_img_url_feat = aq_resize($serivces_image_url_feat[0], 150, 150, true, false, true);
                                        }
                                        $services_image_src = $serivces_image_url_feat ? $ser_img_url_feat[0] : 'https://placeholdit.imgix.net/~text?txtsize=20&txt=' .get_the_title().'&w=150&h=150';
                                    ?>

                                    <div class="blog">
                                        <div class="blog_content">
                                            <div class="blog_img">
											<img src="<?php echo $services_image_src; ?>" alt="<?php the_title(); ?>" />
											</div>
                                            <h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                                            <div class="comment_box">
                                                <span class="blog_date"><?php echo get_the_time('j M, Y'); ?></span>
                                                <span class="blog_author">Lorem Ipsum</span>
                                            </div>
                                            <?php $ass_content = strip_tags(get_the_content());
                                                if($ass_content) { ?>
                                                <p><?php echo substr($ass_content ,0,300 ) . "..";	?></p>
                                            <?php } ?>
											<div class="main_btn black_btn">
												<a href="<?php echo get_permalink(); ?>" title="Read More" class="submit-btn">Read More</a>
											</div>
                                        </div>
                                    </div>
                               <?php } wp_reset_postdata();  ?>
                                    <div class="my_pagination">
                                        <?php if ( function_exists( 'wp_pagenavi' ) ) {
                                               wp_pagenavi( array( 'query' => $banner_query) );
                                               wp_reset_postdata();

                                           } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <div class="blog-sidebar">
                                    <div class="blog_listing">
                                        <h5>Categories</h5>
                                        <span></span>
                                        <?php dynamic_sidebar('sidebar-2'); ?>
                                    </div>
                                    <div class="blog_listing">
                                        <h5>Archives</h5>
                                        <span></span>
                                        <?php dynamic_sidebar('sidebar-1'); ?>
                                    </div>
                                    <div class="blog_listing tags">
                                        <h5>Tags</h5>
                                        <span></span>
                                        <div class="tags-box">
                                            <?php dynamic_sidebar('sidebar-3'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
<?php } ?>
<?php
	get_footer();
?>
