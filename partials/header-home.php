<?php
  $query = new WP_Query(array(
    'carousel' => 'add-to-homepage-carousel'
  ));
?>

<header class="header header-feature header-carousel">
  <div class="m-wrap m-transparent" style="display:none;">
    <div class="header-carousel-slides royalSlider rsDefault">

      <?php
        if ( $query->have_posts() ):
          while ( $query->have_posts() ): 
            $query->the_post();
            $attrsD = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
            $attrsM = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
      ?>
        
        <div class="header-slide <?php echo $attrs ? '' : 'header-feature-text' ?>">
          <?php if ($attrsD): ?>
            <div class="header-feature-bg" data-type="background" data-desktop="<?php echo $attrsD[0]; ?>" data-mobile="<?php echo $attrsM[0] ?>"></div>
            <div class="blanket-light"></div>
          <?php endif; ?>
          <div class="f-grid f-row">
            <div class="f-1 content-wrap">
              <div class="content-row">
                <div class="header-content">
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
                    <a href="<?php echo the_permalink(); ?>" class="link h-1"><?php the_title(); ?></a>
                <?php 
                  elseif ($category == null): 
                    $shop_url = get_post_meta( get_the_id(), 'shop_url_key', true );
                    $shop_url = $shop_url ? $shop_url : 'lifewithoutandy.myshopify.com';
                ?>
                    <a class="link h-5" href="http://<?php echo $shop_url; ?>" target="_blank">Shop</a>
                    <a class="link h-1" href="http://<?php echo $shop_url; ?>" target="_blank"><?php the_title(); ?></a>
                <?php 
                  else: 
                ?>
                    <a class="link h-5" href="<?php echo $category['permalink']; ?>">
                      <?php echo $category['name']; ?>
                    </a>
                    <a href="<?php echo the_permalink(); ?>" class="link h-1"><?php the_title(); ?></a>
                <?php 
                  endif; 
                ?>
                  <div class="h-4"><?php the_subtitle(); ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      <?php
          endwhile;
        endif;
      ?>
    </div>
    <div class="header-carousel-controls f-grid f-row">
      <div class="f-1">
        <a href="javascript:void(0)" class="header-carousel-control prev"><i class="icon-arrow-left"></i></a>
        <a href="javascript:void(0)" class="header-carousel-control next"><i class="icon-arrow-right"></i></a> 
      </div>
    </div>
  </div>
  
  <?php get_template_part('partials/header', 'nav'); ?>
  <?php get_template_part('partials/module', 'util-loader'); ?>
</header>

<?php
  wp_reset_query();
?>