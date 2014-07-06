<div id="modal-share" class="modal modal-scrollable">
  <div class="blanket blanket-alpha"></div>
  <a class="modal-action modal-close" href="javascript:void(0)"><i class="icon-close"></i></a>
  <div class="modal-scrollable-content">
    <div class="modal-view modal-share-view">
      <div class="modal-share-secondary">Share this</div>
      <div class="modal-share-primary"><?php the_title(); ?></div>
      <div class="modal-share-actions modal-share-buttons">
        <?php echo generate_share_link('Facebook') ?>
        <?php echo generate_share_link('Twitter') ?>
        <?php echo generate_share_link('Google+') ?>
        <?php echo generate_share_link('Pinterest') ?>
      </div>
      <div class="modal-share-actions">
        <input class="button button-url" value="<?php echo the_permalink(); ?>">
      </div>
    </div>
  </div>
</div>