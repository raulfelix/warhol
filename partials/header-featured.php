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
            $output = render_header_category($category, $post);
            echo $output;
          ?>
          <div class="h-1"><?php the_title(); ?></div>
          <div class="h-4"><?php the_subtitle(); ?></div>
        </div>
      </div>
    </div>
  </div>

  <?php get_template_part('partials/module', 'util-loader'); ?>
</header>