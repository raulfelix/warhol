<div class="article-row f-grid f-row">
  <div class="f-1">
    <div class="details-row">
      <?php $category = category($post->post_type); ?>
      <a href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
      <div class="details-row-right">
        <span class="fb-like" data-href="<?php echo the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></span>
      </div>
      <a class="button button-share" href="javascript:void(0)"><i class="icon-share"></i>share this</a>
    </div>
    
    <div class="article-row-content">
      <?php the_content(); ?>
    </div>
   
    <div class="details-row details-row-secondary">
      <?php 
        $photos_id = get_post_meta( get_the_id(), 'photos_key', true );
      ?>

      Words by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('display_name'); ?></a>
      <span class="bullet"></span>
      
      <?php if ($photos_id): ?>
        Photos by <a href="<?php echo get_author_posts_url( $photos_id ); ?>"><?php the_author_meta('display_name', $photos_id); ?></a>
        <span class="bullet"></span>
      <?php endif; ?>
      
      <?php echo get_the_time( get_option('date_format')) ?>
    </div>
  </div>
</div>