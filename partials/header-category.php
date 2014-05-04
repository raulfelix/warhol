<?php 
  
  $is_feature = has_post_thumbnail( get_the_id() );
  if ($is_feature === true) {
    $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
  } 

?>

<header class="header feature category">
  <div class="feature-bg" style="background-image: url(<?php echo $img_url[0] ?>);"></div>
  <div class="blanket"></div>

  <?php get_template_part('partials/header', 'nav'); ?>

  <div class="f-grid f-row">
    <div class="f-1">
      <div class="content">
        <div class="f-1-2 bp1-1">
          <div class="category-h1"><?php the_title(); ?></div>
          <div class="category-h2"><?php the_subtitle(); ?></div>
        </div>
        <div class="f-1-2 bp1-1 category-branding">
          <div class="category-h2">in partnership with</div>
          <!-- <img src="../images/red_bull.png"> -->
        </div>
      </div>
    </div>
  </div>
</header>