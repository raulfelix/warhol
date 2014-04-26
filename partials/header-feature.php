<header class="header feature">
  <?php $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original'); ?>
  <div class="feature-bg" style="background-image: url(<?php echo $img_url[0] ?>);"></div>
  
  <?php get_template_part('partials/header', 'nav'); ?>

  <div class="f-grid f-row">
    <div class="f-1">
      <div class="content">
        <a class="link h-5" href="#"><?php echo the_tags('') ?></a>
        <h1 class="h-1"><?php the_title(); ?></h1>
        <h4 class="h-4">We give you the complete run-down of the latest addition to the Air Max family</h4>
      </div>
    </div>
  </div>
</header>