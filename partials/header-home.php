<header class="header header-feature">
  <div class="m-wrap m-transparent feature-carousel">
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
          <?php 
            $attrs = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
          ?>
          <?php if ($attrs): ?>
            <div class="header-feature-bg" style="background-image: url(<?php echo $attrs[0]; ?>);"></div>
            <div class="blanket-light"></div>
          <?php endif; ?>
          <div class="f-grid f-row">
            <div class="f-1 content-wrap">
              <div class="content-row">
                <div class="header-content">
                  <?php 
                    $category = category($post->post_type); 
                  ?>
                  <a class="link h-5" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
                  <a href="<?php echo the_permalink(); ?>" class="link h-1"><?php the_title(); ?></a>
                  <div class="h-4"><?php the_subtitle(); ?></div>
                </div>
              </div>
            </div>
          </div>
        </li>
      
      <?php
          endwhile;
        endif;
      ?>

    </ul>
    <div class="f-grid f-row">
      <div id="feature-carousel-control" class="f-1"></div>
    </div>
  </div>
  <?php get_template_part('partials/header', 'nav'); ?>
  <?php get_template_part('partials/module', 'util-loader'); ?>
</header>

<?php
  wp_reset_query();
?>