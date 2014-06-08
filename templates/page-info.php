<?php
/**
 * Template Name: info
 */

  get_header();
?>

<div class="article-row f-grid f-row">
  <div class="f-1">
    <div class="article-row-content">
      <?php 
        if (have_posts()): while (have_posts()): the_post();
          global $more;
          $more = 0;
          the_content(''); 
      ?>
    </div>
  </div>
</div>

<div class="f-grid f-row">
  <?php
    $users = get_users();
    foreach ($users as $user):
  ?>
  <div class="f-1-3 bp1-1">
    <div class="thumb-author">
      <a class="thumb-author-image" href="<?php echo get_author_posts_url($user->ID); ?>">
        <?php echo get_avatar( $user->ID, 512 ); ?>
        <div class="blanket thumb-blanket">
          <span>view bio</span>
        </div>
      </a>
      <a href="<?php echo get_author_posts_url($user->ID); ?>" class="h-2 thumb-author-details">
        <?php echo $user->display_name ?>
      </a>
      <div class="h-5 thumb-author-location">
        <?php echo ($user->location) ? $user->location : 'unknown location'; ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="article-row f-grid f-row">
  <div class="f-1">
    <div class="article-row-content article-row-no-break">
      <?php
        $more = 1;
        the_content('', true); 

        endwhile; endif;
      ?>
    </div>
  </div>
</div>  


<?php 
  get_footer(); 
?>