<?php
/**
 * The Template for displaying author bio
 * and posts by that author
 */

  get_header();
?>

  <div class="section-thumb-bg">
    <div class="f-grid section-thumb">
      <?php get_template_part('partials/module', 'sort'); ?>
      <div class="f-row">

  <?php
    // get order and default to date otherwise by popularity
    $order = ($_GET['orderby']) ? $_GET['orderby'] : 'desc';

    // get the rest of the articles
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;

    if ($order === 'desc') {
      $args = Array(
        'posts_per_page' => 6,
        'paged' => $paged,
        'author_name' => get_query_var('author_name'),
        'post_type' => array('lwa_feature', 'lwa_news'),
        //'post__not_in' => array( $post_ID_no_repeat ),
      );
    } else {
      $args = Array(
        'posts_per_page' => 6,
        'paged' => $paged,
        'author_name' => get_query_var('author_name'),
         'post_type' => array('lwa_feature', 'lwa_news'),
        //'post__not_in' => array( $post_ID_no_repeat ),
        'meta_key' => '_count-views_all',
        'orderby' => 'meta_value_num'
      );
    }

    // todo exclude featured post above
    $wp_query = new WP_Query( $args );

    if ( $wp_query->have_posts() ):
      while ( $wp_query->have_posts() ): 
        $wp_query->the_post();
  ?>

        <div class="f-1-3 bp2-1-2 thumb-inline">
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