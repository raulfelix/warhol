
<?php
  $type = $post->post_type;
  $category = category($post->post_type);
  $query = new WP_Query(array(
    'carousel' => 'editors-pick',
    'order' => 'DESC',
    'posts_per_page' => '2',
    'post__not_in' => array( $post->ID ),
    'tax_query' => array(
  		array(
  			'taxonomy' => $post->post_type == 'lwa_feature' ? 'featured_tax' : 'news_tax',
  			'field'    => 'slug',
  			'terms'    => $category['slug']
  		),
  	)
  ));
  ?>
  
  <?php       
    if ( $query->have_posts() ) : 
  ?>
  <section class="picks">
    <div class="f-grid">
      <div class="f-row">
        <div class="f-1 picks-row">
          <span class="picks-title">Editors Pick</span>
          <span class="picks-underline"></span>
        </div>
      </div>
      
      <div class="f-row">
    <?php
  	  while ( $query->have_posts() ) : $query->the_post();
    ?>
    
        <div class="f-1-2">
          <div class="thumb">
            <a href="<?php echo the_permalink(); ?>" class="thumb-feature">
               <?php get_thumbnail(false, $type === 'lwa_news' ? true : false, false); ?>  
               <div class="m-overlay blanket-light"></div>
              <span class="thumb-time"><?php when(); ?></span>
            </a>
            <a href="<?php echo the_permalink(); ?>" class="h-2 thumb-title"><?php the_title(); ?></a>
            <div class="thumb-caption"><?php the_subtitle(); ?></div>
          </div>
        </div>
  
  <?php
      endwhile;
      wp_reset_postdata();
  ?>
  
      </div>
    </div>
  </section>
      
  <?php
    endif;
  ?>