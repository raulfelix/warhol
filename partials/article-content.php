<div class="f-grid f-row">
  <div class="f-5-6 f-center bp1-1">
    <div class="section">
      <div class="details-row">
        <?php $category = category($post->post_type); ?>
        <a class="bp1-pull-left" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
        <div class="details-row-right bp1-pull-right">
          <span class="fb-like" data-href="<?php echo the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></span>
        </div>
        <button class="button button-share"><i class="icon-share"></i>share this</button>
      </div>
      
      <div class="section-article">
        <?php the_content(); ?>
      </div>
     
      <div class="details-row details-row-secondary">
        <?php 
          $photos_id = get_post_meta( get_the_id(), 'photos_key', true );
        ?>

        <?php if (get_the_author_meta('user_login') != 'warhol'): ?>
          Words by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('display_name'); ?></a>
          <span class="bullet"></span>
        <?php endif; ?>

        <?php if ($photos_id): ?>
          Photos by <a href="<?php echo get_author_posts_url( $photos_id ); ?>"><?php the_author_meta('display_name', $photos_id); ?></a>
          <span class="bullet"></span>
        <?php endif; ?>
        
        <?php echo get_the_time( get_option('date_format')) ?>
      </div>
    </div>
  </div>
</div>