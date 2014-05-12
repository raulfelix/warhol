<?php
/**
 * Template Name: category
 */

  get_header();
?>

  <?php

    // get the most recent feature article in current category
    global $post;
    $post_slug = $post->post_name;

    $feature_args = Array(
      'post_type' => 'lwa_feature',
      'posts_per_page' => 1,
      'featured_tax' => $post_slug
    );

    $feature_query = new WP_Query( $feature_args );

    if ( $feature_query->have_posts() ):
      while ( $feature_query->have_posts() ): 
        $feature_query->the_post();
        $post_ID_no_repeat = get_the_ID();
  ?>

        <div class="f-grid">
          <div class="f-row thumb-category">
            <div class="f-2-3 bp2-1">
              <div class="thumb">
                <a href="<?php echo the_permalink(); ?>" class="thumb-feature">
                  <?php the_post_thumbnail( 'large'); ?>  
                  <span class="thumb-time"><?php when(); ?></span>
                  <span class="thumb-views data-views"><i class="icon-views"></i><?php views(); ?></span>
                </a>
              </div>
            </div>
            <div class="f-1-3 bp2-1">
              <p>Latest</p>
              <a href="<?php echo the_permalink(); ?>" class="thumb-title"><?php the_title(); ?></a>
              <div class="thumb-caption"><?php the_subtitle(); ?></div>
            </div>
          </div>
        </div>

  <?php  
      endwhile;
    endif;

    /* Restore original Post Data */
    wp_reset_postdata();
  ?>

  <div class="section-thumb-bg">
    <div class="f-grid section-thumb">
      <?php get_template_part('partials/module', 'sort'); ?>
      <div class="f-row">

  <?php
    // get order and default to DESC
    $order = (get_query_var('order')) ? get_query_var('order') : 'DESC';

    // get the rest of the articles
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
    $args = Array(
      'posts_per_page' => 6,
      'paged' => $paged,
      'post__not_in' => array( $post_ID_no_repeat ),
      'featured_tax' => $post_slug,
      'order' => $order
    );

    // todo exclude featured post above
    $wp_query = new WP_Query( $args );

    if ( $wp_query->have_posts() ):
      while ( $wp_query->have_posts() ): 
        $wp_query->the_post();
  ?>

        <div class="f-1-3 bp2-1-2 thumb-inline thumb-no-category">
          <?php get_template_part('partials/article', 'thumb'); ?>
        </div>
  
  <?php  
      endwhile;
    endif;
  ?>
    </div>
      <?php get_template_part('partials/module', 'paginate-links'); ?>
    </div>
  </div>

<?php 
  wp_reset_query();
  
  wp_enqueue_script( 'category-build' );
  get_footer(); 
?>