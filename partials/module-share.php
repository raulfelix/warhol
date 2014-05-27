<div id="modal-share" class="modal">
  <a class="modal-action modal-close" href="javascript:void(0)"><i class="icon-close"></i></a>
  <div class="modal-view modal-share-view">
    <div class="modal-share-secondary">Share this</div>
    <div class="modal-share-primary"><?php the_title(); ?></div>
    <div class="modal-share-actions">
      <button class="button button-social" data-href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(the_permalink()) ?>&title=<?php echo urlencode(the_title()) ?>">Facebook</button>
      <button class="button button-social" data-href="https://twitter.com/share?url=<?php echo urlencode(the_permalink()) ?>">Twitter</button>
      <button class="button button-social" data-href="https://plus.google.com/share?url=<?php echo urlencode(the_permalink()) ?>">Google+</button>
    </div>
    <div class="modal-share-actions">
      <input class="button button-url" value="<?php echo the_permalink(); ?>">
    </div>
  </div>
</div>
<?php wp_enqueue_script( 'single-build' );?>