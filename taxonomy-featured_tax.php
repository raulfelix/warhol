<?php
/**
 * Template Name: category
 */

  get_header();
?>

  <?php

    $paged = (get_query_var('page')) ? get_query_var('page') : 1;

    // get the most recent feature article in current category
    $feature_args = Array(
      'post_type' => 'lwa_feature',
      'posts_per_page' => 1,
      'featured_tax' => $featured_tax
    );

    $feature_query = new WP_Query( $feature_args );

    if ( $feature_query->have_posts() ):
      while ( $feature_query->have_posts() ): 
        $feature_query->the_post();
        $post_ID_no_repeat = get_the_ID();
      endwhile;
    endif;

    /* Restore original Post Data */
    wp_reset_postdata();
  ?>

  <!-- LWA_leaderboard_01 -->
  <div id='div-gpt-ad-1412722263572-0' class="row-ad row-bg-dark">
    <script type='text/javascript'>
      googletag.cmd.push(function() { 
        googletag.display('div-gpt-ad-1412722263572-0'); 
      });
    </script>
  </div>

  <div class="section-thumb-bg">
    <div class="f-grid section-thumb">
      <?php get_template_part('partials/module', 'sort'); ?>
      <div class="f-row">

  <?php
    // get order and default to date otherwise by popularity
    $order = isset($_GET['orderby']) ? $_GET['orderby'] : 'desc';

    if ($order === 'desc') {
      $args = Array(
        'posts_per_page' => 12,
        'paged' => $paged,
        'post__not_in' => array( $post_ID_no_repeat ),
        'featured_tax' => $featured_tax
      );
    } else {
      $args = Array(
        'posts_per_page' => 12,
        'paged' => $paged,
        'post__not_in' => array( $post_ID_no_repeat ),
        'featured_tax' => $featured_tax,
        'meta_key' => '_count-views_all',
        'orderby' => 'meta_value_num'
      );
    }

    
    $wp_query = new WP_Query( $args );
    $idx = 1;
    if ( $wp_query->have_posts() ):
      while ( $wp_query->have_posts() ): 
        $wp_query->the_post();
  ?>

        <div class="f-1-3 bp1-1-2 thumb-no-category">
          <?php get_template_part('partials/article', 'thumb'); ?>
        </div>
  
  <?php  
      generate_inline_thumb_fix($idx++);
      endwhile;
    endif;
  ?>
    </div>
      <?php get_template_part('partials/module', 'paginate-links'); ?>
    </div>
  </div>

  <!-- /27068509/LWA_leaderboard_bottom_category -->
  <div id='div-gpt-ad-1455969211544-0' class="row-ad row-bg-dark">
    <script type='text/javascript'>
      googletag.cmd.push(function() { googletag.display('div-gpt-ad-1455969211544-0'); });
    </script>
  </div>
  
<?php 
  wp_reset_query();
  
  wp_enqueue_script( 'category' );
  get_footer(); 
?>