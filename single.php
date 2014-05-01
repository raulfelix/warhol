<?php
/**
 * The Template for displaying all single posts
 */
?>

  <?php
    get_header();
    
    if (have_posts()): while (have_posts()): the_post();
      get_template_part( 'partials/article', 'content' );
    endwhile; endif;
    
  ?>
  <div id="modal-share" class="modal">
    <a class="modal-close" href="javascript:void(0)"><i class="icon-close"></i></a>
    <div class="modal-view modal-share-view">
      <div class="modal-share-secondary">Share this</div>
      <div class="modal-share-primary">Chris Gibbs knows how to influence streetwear</div>
      <div class="modal-share-actions">
        <a class="button" href="#">Facebook</a>
        <a class="button" href="#">Twitter</a>
        <div class="button g-plus" data-action="share" data-url="http://www.raulfelixcarrizo.com" data-annotation="none">Google+</div>
      </div>
      <div class="modal-share-actions">
        <div class="button button-url">
          http://www.someurlthatisquitelongtoremember.com.au
          <a class="button-url-copy" href="#">Copy URL</a>
        </div>
      </div>
    </div>
  </div>
<?php get_footer(); ?>