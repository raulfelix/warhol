<?php
/**
 * Home page template
 */
?>

<?php get_header(); ?>

  <div class="f-grid section-thumb">
    
    <?php

      // get the most recent feature articles
      $feature_args = Array(
        'post_type' => 'lwa_feature',
        'posts_per_page' => 4
      );

      $feature_query = new WP_Query( $feature_args );
      $count = 0;

      if ( $feature_query->have_posts() ):
        while ( $feature_query->have_posts() ): 
          $feature_query->the_post();
    ?>
        
      <?php if ($count == 0): ?>
        <div class="f-row">
      <?php endif; ?>
            
        <div class="f-1-2 bp2-1">
          <?php get_template_part('partials/article', 'thumb'); ?>
        </div>

      <?php $count++; ?>

      <?php if ($count == 2): $count = 0; ?>
        </div>
      <?php endif; ?>


    <?php
        endwhile;
      endif;

      if ($count == 1) {
        echo "</div>";
      }

      wp_reset_query();
    ?>
    <div id="tmpl_featured"></div>
    <div class="button-row">
      <a id="ajax-load-features" class="button button-large" href="javascript:void(0)">
        <span>load more features</span>
      </a>
    </div>
  </div>


  <div class="section-thumb-bg">
    <div class="f-grid section-thumb section-thumb-news">
      <div id="tmpl_news" class="f-row">
        <?php

          // get all article in the 'news' category
          $news_args = Array(
            'post_type' => 'lwa_news',
            'posts_per_page' => 6
          );

          $news_query = new WP_Query( $news_args );
          $count = 0;

          if ( $news_query->have_posts() ):
            while ( $news_query->have_posts() ): 
              $news_query->the_post();
        ?>
          
          <div class="f-1-3 bp2-1-2 thumb-inline">
            <?php get_template_part('partials/article', 'thumb'); ?>
          </div>

        <?php
            endwhile;
          endif;

          wp_reset_query();
        ?>
      </div>

      <div class="button-row">
        <a id="ajax-load-news" class="button button-large" href="javascript:void(0)">
          <span>load more news</span>
        </a>
      </div>
    </div>
  </div>

  <div class="instabinge">
    <div class="h-1">@lifewithoutandy</div>
    <div id="instabinge" class="frame">
      <ul class="slidee"></ul>
    </div> 
    <div id="instabinge-buttons">
      <button class="instabinge-prev"><i class="icon-arrow-left"></i></button>
      <button class="instabinge-next"><i class="icon-arrow-right"></i></button> 
    </div>
  </div>

<?php 
  wp_enqueue_script( 'home-build' );
  get_footer(); 

?>