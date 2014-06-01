<?php 
  
  $is_feature = has_post_thumbnail( get_the_id() );
  if ($is_feature === true) {
    $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
  } 

  $heximus = get_post_meta( get_the_id(), 'heximus_key', true );
  $alpha = get_post_meta( get_the_id(), 'heximus_alpha_key', true );
?>

<header class="header header-feature header-category">
  <div class="header-feature-bg" style="background-image: url(<?php echo $img_url[0] ?>);"></div>
  <?php if ($is_feature === true): ?>
    <div class="blanket-overlay" style="background-color:<?php echo ($heximus) ? $heximus : '#000000' ?>;opacity: <?php echo ($alpha) ? $alpha : '0.8' ?>;"></div>
  <?php endif; ?>
  <?php get_template_part('partials/header', 'nav'); ?>

  <div class="f-grid f-row f-full">
    <div class="f-1">
      <div class="header-category-content">
        <div class="f-1-2 bp1-1">
          <div class="header-category-h1"><?php the_title(); ?></div>
          <div class="header-category-h2"><?php the_subtitle(); ?></div>
        </div>
        <div class="f-1-2 header-category-branded">
          <?php 
            $gallery = new Attachments( 'my_attachments', get_the_id() );
            if ( $gallery->exist() ):
              echo $gallery->image( 'original', 0 );
              echo '<div class="header-category-h2">in partnership with</div>';
            endif;
          ?>
        </div>
      </div>
    </div>
  </div>
</header>