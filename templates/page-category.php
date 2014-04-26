<?php
/**
 * Template Name: category
 */

  get_header();
?>

  <?php
    // get the most recent feature article in current category
    $category_id = get_cat_ID( get_the_title(get_the_ID()) );
    
    $feature_args = Array(
      'posts_per_page' => 1,
      'category__and' => array( 8, $category_id ) // must be in both categories
    );

    $feature_query = new WP_Query( $feature_args );

    if ( $feature_query->have_posts() ):
      while ( $feature_query->have_posts() ): 
        $feature_query->the_post();
  ?>

        <div class="f-grid">
          <div class="f-row thumb-category">
            <div class="f-2-3 bp2-1">
              <div class="thumb">
                <div class="thumb-feature">
                  <?php the_post_thumbnail( 'large'); ?>  
                  <span class="thumb-time"><?php echo when(); ?></span>
                  <span class="thumb-views data-views"><i class="icon-eye"></i>5,213</span>
                </div>
              </div>
            </div>
            <div class="f-1-3 bp2-1">
              <p>Featured</p>
              <a href="<?php echo the_permalink(); ?>" class="thumb-title"><?php the_title(); ?></a>
              <div class="thumb-caption"><?php the_subtitle(); ?></div>
            </div>
          </div>
        </div>

  <?php  
      endwhile;
    endif;

    /* Restore original Post Data */
    //wp_reset_postdata();
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
      'category__and' => array( $category_id )
    );

    // todo exclude featured post above
    $wp_query = new WP_Query( $args );

    if ( $wp_query->have_posts() ):
      while ( $wp_query->have_posts() ): 
        $wp_query->the_post();
  ?>

        <div class="f-1-3 bp2-1-2">
          <div class="thumb thumb-third">
            <div class="thumb-feature">
              <?php the_post_thumbnail( 'medium'); ?>
              <span class="thumb-time"><?php echo when(); ?></span>
              <span class="thumb-views data-views"><i class="icon-eye"></i>5,213</span>
            </div>
            <a href="<?php echo the_permalink(); ?>" class="h-2 thumb-title"><?php the_title(); ?></a>
            <div class="h-5 thumb-caption"><?php the_subtitle(); ?></div>
          </div>
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

            // $prev_link = get_previous_posts_link( 'prev' );
            // if ($prev_link === null) {
            //   echo '<a class="button button-prev button-disabled" href="javascript:void(0)">prev</a>';
            // } else {
            //   preg_match('/(http:\/\/.+?)([ \\n\\r])/', $prev_link, $matches );
            //   echo '<a class="button button-prev" href="'. $matches[0] .'>prev</a>';
            // }

          ?>

          <?php 
            
            // $next_link = get_next_posts_link( 'next' );
            // if ($next_link === null) {
            //   echo '<a class="button button-next button-disabled" href="javascript:void(0)">next</a>';
            // } else {
            //   preg_match('/(http:\/\/.+?)([ \\n\\r])/', $next_link, $matches );
            //   echo '<a class="button button-next" href="'. $matches[0] .'>next</a>';
            // }

          ?>
        </div>
      </div>
    </div>
  </div>
<?php 
  /* Restore original Post Data */
  wp_reset_postdata();
  
  get_footer(); 
?>