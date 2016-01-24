<?php
  /*
   * Header category
   */
  wp_enqueue_script( 'category' );
?>

<?php      
  $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
?>

<header id="header-feature" class="header header-feature">
  <div class="m-wrap m-transparent">
    <div class="header-feature-bg" style="background-image: url(<?php echo $img_url[0] ?>);" data-type="background"></div>
    <div class="m-overlay blanket-light"></div>
  </div>
  
  <div class="f-grid f-row">
    <div class="f-1 content-wrap">
      <div class="content-row">
        <div class="m-wrap m-transparent header-content">
          <?php
            $category = category($post->post_type); 
            $logo_src_url = get_term_meta( $category['id'], 'c-sponsor-url', true ); 
            $sponsor_link = get_term_meta( $category['id'], 'c-sponsor-link', true );
            
            if ($logo_src_url):
          ?>
          <div class="header-feature-category">
            <a class="link h-5" href="<?php echo $category['permalink']; ?>">
              <span class="header-feature-category-item"><?php echo $category['name']; ?></span>
            </a>
            <i class="header-feature-category-item icon-close"></i>
            <a class="link h-5" href="<?php echo $sponsor_link ?>">
              <img class="category-logo" src="<?php echo $logo_src_url; ?>">
            </a>
          </div>
          <a class="link h-1" href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
          <div class="h-4"><?php the_subtitle(); ?></div>
          
          <?php else: ?>
          
          <a class="link h-5" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
          <a class="link h-1" href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a>
          <div class="h-4"><?php the_subtitle(); ?></div>
          
          <?php endif; ?>
          
        </div>
      </div>
    </div>
  </div>

  <?php get_template_part('partials/module', 'util-loader'); ?>
</header>