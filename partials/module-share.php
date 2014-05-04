<div id="modal-share" class="modal">
  <a class="modal-close" href="javascript:void(0)"><i class="icon-close"></i></a>
  <div class="modal-view modal-share-view">
    <div class="modal-share-secondary">Share this</div>
    <div class="modal-share-primary"><?php the_title(); ?></div>
    <div class="modal-share-actions">
      <a class="button" href="#">Facebook</a>
      <a class="button" href="#">Twitter</a>
      <div class="button g-plus" data-action="share" data-url="http://www.raulfelixcarrizo.com" data-annotation="none">Google+</div>
    </div>
    <div class="modal-share-actions">
      <div class="button button-url">
        <?php the_permalink(); ?>
        <a class="button-url-copy" href="#">Copy URL</a>
      </div>
    </div>
  </div>
</div>