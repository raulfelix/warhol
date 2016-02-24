<div class="f-grid">
  <div class="f-row">
    <div class="f-1">
      <div class="details-row">
        <?php $category = category($post->post_type); ?>
        <a class="article-detail bp1-pull-left" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
        <span class="article-detail bp1-pull-left"><?php when(); ?></span>

        <div class="details-row-right bp1-pull-right">
          <span class="fb-like" data-href="<?php echo the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></span>
        </div>
        <button class="button button-share">share this</button>
      </div>
    </div>
  </div>
  <div class="f-row relative">
    <div class="f-3-4-fixed bp4-1">
      <div class="section">
        <div class="section-article">
          <?php the_content(); ?>
        </div>
       
        <div class="details-row details-row-secondary">
          <?php 
            $photos_id = get_post_meta( get_the_id(), 'photos_key', true );
            $filmed_id = get_post_meta( get_the_id(), 'filmed_key', true );
          ?>

          <?php if (get_the_author_meta('user_login') != 'warhol'): ?>
            Words by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('display_name'); ?></a>
            <span class="bullet"></span>
          <?php endif; ?>

          <?php if ($photos_id): ?>
            Photos by <a href="<?php echo get_author_posts_url( $photos_id ); ?>"><?php the_author_meta('display_name', $photos_id); ?></a>
            <span class="bullet"></span>
          <?php endif; ?>
          
          <?php if ($filmed_id): ?>
            Filmed by <a href="<?php echo get_author_posts_url( $filmed_id ); ?>"><?php the_author_meta('display_name', $filmed_id); ?></a>
            <span class="bullet"></span>
          <?php endif; ?>
          
          <?php echo get_the_time( get_option('date_format')) ?>
        </div>
      </div>
    </div>
    
    <div class="f-300 bp4-gone">
      
      <!-- /27068509/LWA_sidebar_01 -->
      <div id='div-gpt-ad-1453979832228-0' style='height:250px; width:300px;'>
        <script type='text/javascript'>
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1453979832228-0'); });
        </script>
      </div>
      
      <?php 
        wp_reset_query();
        
        $args = Array(
          'posts_per_page' => 5,
          'post_type' => array('lwa_feature', 'lwa_news'),
          'meta_key' => '_count-views_all',
          'orderby' => 'meta_value_num'
        );

        $wp_query = new WP_Query( $args );
        if ( $wp_query->have_posts() ):
      ?>

        <div class="section-popular">
          <h5>Most Popular</h5>
          
          <?php
            while ( $wp_query->have_posts() ): 
              $wp_query->the_post();
          ?>

          <div class="thumb thumb-popular">
            <a href="<?php echo the_permalink(); ?>" class="h-4 thumb-title"><?php the_title(); ?></a>
            <a href="<?php echo the_permalink(); ?>" class="thumb-feature">
              <?php get_thumbnail(false, true, false); ?>  
              <div class="m-overlay blanket-light"></div>
            </a>
          </div>

          <?php  
            endwhile;
          ?>
        </div>
      <?php
        endif;
        wp_reset_query();
       ?>
      
      <div id="LWA_sidebar_02-waypoint"></div> 
      <!-- /27068509/LWA_sidebar_02 -->
      <div id='div-gpt-ad-1453981103890-0' style='height:600px; width:300px;'>
        <script type='text/javascript'>
        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1453981103890-0'); });
        </script>
      </div>

    </div>
  </div>
</div>

<div class="row-ad-large">
  <!-- /27068509/LWA_leaderboard_bottom_article -->
  <div id='div-gpt-ad-1454813276057-0'>
    <script type='text/javascript'>
      googletag.cmd.push(function() { googletag.display('div-gpt-ad-1454813276057-0'); });
    </script>
  </div>
</div>