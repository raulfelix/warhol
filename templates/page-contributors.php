<?php

/**
 * Template Name: contributors
 *
 * Exclude 'warhol' from the list of users as this
 * is our dev account.
 */

  get_header();
?>

<div class="f-grid f-row">
  <div class="f-row">
    <div class="f-5-6 f-center">
      <div class="section">
        <div class="section-article">
          <h2><?php the_title(); ?></h2>
        </div>
      </div>
    </div>
  </div>
  <div class="f-row">
    <?php
      $users = get_users(array(
        'fields' => 'all_with_meta'
      ));

      $users = array_filter($users, function($u) { return $u->user_login != 'warhol'; });
      
      function sort_display($a, $b) {
        return ($a->display_order < $b->display_order) ? -1 : 1;
      } 
   
      // Sort using our custom comparison function
      usort($users, "sort_display");

      foreach ($users as $user):
    ?>
    <div class="f-1-3 bp1-1">
      <div class="thumb-author">
        <a class="thumb-author-image" href="<?php echo get_author_posts_url($user->ID); ?>">
          <?php echo get_avatar( $user->ID, 512 ); ?>
          <div class="blanket thumb-blanket"><span>view bio</span></div>
        </a>
        <a href="<?php echo get_author_posts_url($user->ID); ?>" class="h-2 thumb-author-details">
          <?php echo $user->display_name ?>
        </a>
        <div class="h-5 thumb-author-location">
          <?php echo ($user->location) ? $user->location : 'unknown location'; ?>
        </div>
      </div>
    </div>
    <?php
      endforeach; 
    ?>
  </div>
</div>

<?php 
  get_footer(); 
?>