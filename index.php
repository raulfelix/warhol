<?php
/**
 * Home page template
 */
?>

<?php get_header(); ?>

  <div class="f-grid section-thumb">
    
    <?php

      // get the most recent feature articles
      $paged = (get_query_var('page')) ? get_query_var('page') : 1;
      $feature_query = custom_home_feature_query(1, 4);

      if ($feature_query): 
        global $post;
        $count = 0;
        foreach( $feature_query as $post ):
          setup_postdata($post);
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
        endforeach;
      endif;

      if ($count == 1) {
        echo "</div>";
      }

      wp_reset_query();
    ?>
    <div id="tmpl_featured"></div>

    <div class="button-row">
      <a id="ajax-load-features" class="button button-large button-loader" href="javascript:void(0)">
        <span class="button-text">load more features</span>
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
            'posts_per_page' => 6,
            'meta_key' => 'news_featured_key',
            'meta_compare' => 'NOT EXISTS'
          );

          $news_query = new WP_Query( $news_args );
          $idx = 1;

          if ( $news_query->have_posts() ):
            while ( $news_query->have_posts() ): 
              $news_query->the_post();
        ?>
          
          <div class="f-1-3 bp1-1-2">
            <?php get_template_part('partials/article', 'thumb'); ?>
          </div>

        <?php
            generate_inline_thumb_fix($idx++);
            endwhile;
          endif;

          wp_reset_query();
        ?>
      </div>

      <div class="button-row">
        <a id="ajax-load-news" class="button button-large button-loader" href="javascript:void(0)">
          <span class="button-text">load more news</span>
        </a>
      </div>
    </div>
  </div>

  <div class="instabinge">
    <div class="instabinge-header">
      <a href="http://instagram.com/lifewithoutandy" class="h-1" target="_blank">@lifewithoutandy</a>
    </div>
    <div id="instabinge" class="frame">
      <ul class="slidee"></ul>
    </div> 
    <div id="instabinge-buttons" class="sly-controls">
      <button class="sly-prev"><i class="icon-arrow-left"></i></button>
      <button class="sly-next"><i class="icon-arrow-right"></i></button> 
    </div>
  </div>
  <?php get_template_part('partials/module', 'instabinge-single'); ?>

<?php 
  wp_enqueue_script( 'home' );
  get_footer(); 
?>