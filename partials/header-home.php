<header class="header feature">
  <div class="feature-carousel">
    <ul class="slides">

      <?php
        // get items tagged to be in carousel
        $args = Array(
          'carousel' => 'add-to-homepage-carousel'
        );

        $query = new WP_Query( $args );

        if ( $query->have_posts() ):
          while ( $query->have_posts() ): 
            $query->the_post();
      ?>

        <li>
          <?php the_post_thumbnail( 'original'); ?>
          <div class="f-grid f-row">
            <div class="f-1">
              <div class="content">
                <?php 
                  $category = category($post->post_type); 
                ?>
                <a class="link h-5" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
                <a href="<?php echo the_permalink(); ?>" class="link h-1"><?php the_title(); ?></a>
                <div class="h-4"><?php the_subtitle(); ?></div>
              </div>
            </div>
          </div>
        </li>
      
      <?php
          endwhile;
        endif;
      ?>

    </ul>
  </div>
  <?php get_template_part('partials/header', 'nav'); ?>
</header>

<?php
  wp_reset_query();
?>