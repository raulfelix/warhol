<div class="article-row f-grid f-row">
  <div class="f-1">
    <div class="details-row">
      <?php $category = category($post->post_type); ?>
    <a href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
      <span><?php when(); ?></span>
      <span class="data-views"><i class="icon-views"></i><?php views(); ?></span>Facebook
      <a class="button button-share" href="javascript:void(0)"><i class="icon-share"></i>share this</a>
    </div>
    <div class="article-row-content">
      <?php the_content(); ?>
    </div>
    <div class="button-row">
      <a class="button button-share" href="javascript:void(0)"><i class="icon-share"></i>share this</a>
    </div>
    <div class="details-row details-row-secondary">
      Words by <?php echo get_the_author_meta('display_name'); ?>
      <span class="bullet"></span>
      Photos by Mitchel Tomlinson
      <span class="bullet"></span>
      <?php echo get_the_time( get_option('date_format')) ?>
    </div>
  </div>
</div>