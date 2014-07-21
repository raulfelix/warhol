<?php 
  
  // check if there is a gallery associated with the post
  $attachments = new Attachments( 'my_attachments', get_the_id() );
  $post_type = get_post_type( get_the_ID() );
  if ( $attachments->exist() && $post_type != 'lwa_news' ):
    wp_enqueue_script( 'gallery' );
    get_template_part('partials/module', 'js-gallery');
  ?>
 
<div id="modal-gallery" class="modal modal-transparent modal-gallery">
  <button class="modal-action modal-close"><i class="icon-close"></i></button>
  <div class="modal-gallery-count"></div>
  
  <div class="modal-wrap">
    <div class="modal-wrap-row">
      <div id="modal-gallery-frame" class="modal-view frame">
        
        <div class="royalSlider">
          <?php 
            while( $attachments->get() ) : ?>
              <div class="sly-slide">
                <img class="rsImg m-wrap m-transparent" src="<?php echo $attachments->src( 'large' ); ?>" alt="<?php echo $attachments->field( 'caption' ); ?>">
                <?php get_template_part('partials/module', 'util-loader'); ?>
              </div>
          <?php endwhile; ?>
        </div>
      </div>
      <div class="sly-controls">
        <button class="sly-prev"><i class="icon-arrow-left"></i></button>
        <button class="sly-next"><i class="icon-arrow-right"></i></button>
      </div>
    </div>
  </div>
</div>

<header id="header-gallery" class="header header-feature header-gallery">
  <div class="header-gallery-wrap">
    <?php get_template_part('partials/header', 'nav'); ?>

    <div id="header-gallery-wrap" class="m-wrap m-transparent">
      <div id="tmpl-gallery-images"></div>
      <div class="m-overlay blanket-light"></div>
      <div class="header-gallery-content">
        <div class="f-grid f-row">
          <div class="f-1">
            <div class="header-content">
              <div id="header-gallery-title" class="h-1"><?php echo get_the_title(); ?></div>
            </div>
            <div id="inline-gallery-controls" class="sly-controls">
              <div class="f-1">
                <button class="sly-prev"><i class="icon-arrow-left"></i></button>
                <button class="sly-next"><i class="icon-arrow-right"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="header-gallery-details" class="slip-in">
        <div class="header-gallery-controls">
          <button id="gallery-thumbs" class="button button-gallery button-thumbs"><i class="icon-thumbs"></i></button>
          <button id="modal-gallery-button" class="button button-gallery"><i class="icon-expand"></i><span>Launch gallery</span></button>
        </div>
        <div class="header-details">
          <span><?php when(); ?></span>
          <span class="thumb-views"><i class="icon-views"></i><?php views(); ?></span>
        </div>
      </div>
    </div>
  </div>
  
  <?php get_template_part('partials/module', 'util-loader'); ?>

  <div id="header-gallery-thumbs" class="header-gallery-thumbs frame">
    <ul class="slidee">
      <?php 
        $attachments->rewind();
        while( $attachments->get() ) : 
      ?>
        <li><?php echo $attachments->image( 'thumbnail' ); ?></li>
      <?php endwhile; ?>
    </ul>
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