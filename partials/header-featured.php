<?php      
  $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
?>

<?php get_template_part('partials/header', 'social'); ?>
  
<header id="header-feature" class="header header-feature">
  <div class="m-wrap m-transparent">
    <div class="header-feature-bg" style="background-image: url(<?php echo $img_url[0] ?>);" data-type="background"></div>
    <div class="m-overlay blanket-light"></div>
  </div>
  
  <?php get_template_part('partials/header', 'nav'); ?>

  <div class="f-grid f-row">
    <div class="f-1 content-wrap">
      <div class="content-row">
        <div class="m-wrap m-transparent header-content">
          <?php 
            $category = category($post->post_type); 
            $logo_url = get_term_meta( $category['id'], 'c-sponsor-url', true );
            
            if ($logo_url):
          ?>
          <div class="header-feature-category">
            <a class="link h-5" href="<?php echo $category['permalink']; ?>">
              <span class="header-feature-category-item"><?php echo $category['name']; ?></span>
              <i class="header-feature-category-item icon-close"></i>
              <img class="category-logo" src="<?php echo $logo_url; ?>">
            </a>
          </div>
          <div class="h-1"><?php the_title(); ?></div>
          <div class="h-4"><?php the_subtitle(); ?></div>
          
          <?php else: ?>
          
          <a class="link h-5" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
          <div class="h-1"><?php the_title(); ?></div>
          <div class="h-4"><?php the_subtitle(); ?></div>
          
          <?php endif; ?>
          
        </div>
      </div>
    </div>
  </div>

  <?php get_template_part('partials/module', 'util-loader'); ?>
</header>