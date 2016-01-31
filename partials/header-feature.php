<?php 
  
  // check if there is a gallery associated with the post
  $attachments = new Attachments( 'my_attachments', get_the_id() );
  $post_type = get_post_type( get_the_ID() );

  if ( $attachments->exist()):
    wp_enqueue_script( 'gallery' );
    get_template_part('partials/module', 'js-gallery');
?>
 
<div id="modal-gallery" class="modal modal-transparent modal-gallery">
  <button class="modal-action modal-close"><i class="icon-close"></i></button>
  <div class="modal-gallery-count"></div>
  
  <div class="modal-wrap">
    <div class="modal-wrap-row" data-closeable="0">
      <div id="modal-gallery-frame" class="modal-view frame" data-closeable="0">
        <div class="royalSlider"></div>
      </div>
      <button class="gallery-home button button-white" id="modal-gallery-home">back to start</button>
      <div class="sly-controls">
        <button class="sly-prev"><i class="icon-arrow-left"></i></button>
        <button class="sly-next"><i class="icon-arrow-right"></i></button>
      </div>
    </div>
  </div>

  <div id="modal-slider-next" class="gallery-next-overlay" data-closeable="0">
    <div class="royalSlider">
      <div class="gallery-next-slide" data-closeable="0"></div>
      <div class="gallery-next-slide" data-closeable="0">
        <div class="f-grid f-row" data-closeable="0">
          <div class="f-1 content-wrap" data-closeable="0">
            <div class="content-row" data-closeable="0">
              <div class="header-content" data-closeable="0">
                <?php get_template_part('partials/gallery', 'next'); ?>
                <button class="button button-white modal-gallery-home" id="modal-gallery-home">back to start</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

<header id="header-gallery" class="header header-feature header-gallery">
  <div class="header-gallery-wrap">
    <div id="header-gallery-wrap" class="m-wrap m-transparent">
      <div id="tmpl-gallery-images"></div>
      <div class="m-overlay blanket-light"></div>
      
      <div class="f-grid f-row sly-controls">
        <div id="inline-gallery-controls" class="f-1">
          <button class="gallery-home button button-white" id="inline-gallery-home">back to start</button>
          <button class="sly-prev"><i class="icon-arrow-left"></i></button>
          <button class="sly-next"><i class="icon-arrow-right"></i></button>
        </div>
      </div>

      <div class="f-grid f-row header-gallery-title">
        <div class="f-1 content-wrap">
          <div class="content-row">
            <div class="header-content">
              <?php
                $category = category($post->post_type); 
                $logo_src_url = get_term_meta( $category['id'], 'c-sponsor-url', true ); 
                $sponsor_link = get_term_meta( $category['id'], 'c-sponsor-link', true );
                
                $post_sponsor_src = get_post_meta($post->ID, 'post_sponsor_src', true);
                $post_sponsor_url = get_post_meta($post->ID, 'post_sponsor_url', true);
                
                if ($post_sponsor_src) {
                  $logo_src_url = $post_sponsor_src;
                }
                
                if ($post_sponsor_url) {
                  $sponsor_link = $post_sponsor_url;
                  if (strpos($sponsor_link, 'http://') !== false) {
                    // has http included;
                  } else {
                    $sponsor_link = 'http://' . $sponsor_link;
                  }
                }
                
                if ($logo_src_url):
              ?>
              <div class="header-feature-category">
                <a class="link h-5" href="<?php echo $category['permalink']; ?>">
                  <span class="header-feature-category-item"><?php echo $category['name']; ?></span>
                </a>
                <i class="header-feature-category-item icon-close"></i>
                <a class="link h-5" href="<?php echo $sponsor_link ?>" target="_blank">
                  <img class="category-logo" src="<?php echo $logo_src_url; ?>">
                </a>
              </div>
              <div class="h-1"><?php echo get_the_title(); ?></div>
              
              <?php else: ?>
              
              <a class="link h-5" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
              <div class="h-1"><?php echo get_the_title(); ?></div>
              
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="gallery-next-overlay">
        <div class="gallery-next-wrap">
          <div class="f-grid f-row">
            <div class="f-1 content-wrap">
              <div class="content-row">
                <div class="header-content">
                  <?php get_template_part('partials/gallery', 'next'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="header-gallery-details">
        <div class="header-gallery-controls">
          <button id="gallery-thumbs" class="button button-gallery button-thumbs"><i class="icon-thumbs"></i></button>
          <button id="modal-gallery-button" class="button button-gallery"><i class="icon-expand"></i><span>Launch gallery</span></button>
        </div>
      </div>
    </div>
  </div>
  
  <?php get_template_part('partials/module', 'util-loader'); ?>

  <div id="header-gallery-thumbs" class="header-gallery-thumbs frame">
    <ul class="slidee"></ul>
    <div class="sly-controls">
      <button class="sly-prev"><i class="icon-arrow-left"></i></button>
      <button class="sly-next"><i class="icon-arrow-right"></i></button>
    </div>
  </div>
</header>

<?php
  else:

    if ( has_a_feature_image() ) {
      get_template_part('partials/header', 'featured');
    } else {
      get_template_part('partials/header', 'standard');
    }
  
  endif;
?>