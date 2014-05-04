<?php
/**
 * Template Name: category
 */

  get_header();
?>

  <?php

    // get the most recent article in current category
    global $post;
    $post_slug = $post->post_name;
    $category = category($post->post_type)['slug'];
    
    $feature_args = Array(
      'post_type' => 'lwa_news',
      'posts_per_page' => 1,
      'news_tax' => $category
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
                  <?php get_thumbnail(); ?>  
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
      <div class="f-row button-row button-row-left">
        <div class="f-1">
          <div class="button dropdown" href="#">
            <a href="#" class="dropdown-label">sort by latest <i class="icon-arrow-down"></i></a>
          </div>
        </div>
      </div>
      <div class="f-row">

  <?php
    // get the rest of the articles
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = Array(
      'posts_per_page' => 6,
      'paged' => $paged,
      'post__not_in' => array( $post_ID_no_repeat ),
      'news_tax' => $category
    );

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
      <div class="f-row button-row button-row-paginate">
        <div class="f-1">
          <?php 
            get_pagination_link( 'prev' );
            get_pagination_link( 'next' );
          ?>
        </div>
      </div>
    </div>
  </div>

<?php 
  wp_reset_query();
  
  get_footer(); 
?>