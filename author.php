<?php
/**
 * The Template for displaying author bio
 * and posts by that author
 */

  get_header();

  $user = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
?>
  <div class="section-bio f-grid">
    <div class="f-row">
      <div class="f-1-3 bp1-1">
        <div class="thumb-author">
          <a target="_blank" class="thumb-author-image" href="<?php echo $user->user_url; ?>">
            <?php echo get_avatar( $user->ID, 512 ); ?>
          </a>
          <a target="_blank" href="<?php echo $user->user_url; ?>" class="h-2 thumb-author-details">
            <?php echo $user->display_name; ?>
          </a>
          <div class="h-5 thumb-author-location">
            <?php echo ($user->location) ? $user->location : 'unknown location'; ?>
          </div>
        </div>
      </div>
      <div class="f-2-3 bp1-1">
        <?php echo wpautop( $user->description, true ); ?>
        <a target="_blank" class="link link-pink" href="<?php echo $user->user_url; ?>"><?php echo $user->user_url; ?></a>
      </div>
    </div>
  </div>

  <div class="section-thumb-bg">
    <div class="f-grid section-thumb">
      <?php get_template_part('partials/module', 'sort'); ?>
      <div class="f-row">

  <?php
    // get order and default to date otherwise by popularity
    $order = isset($_GET['orderby']) ? $_GET['orderby'] : 'desc';

    // get the rest of the articles
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;

    if ($order === 'desc') {
      $args = Array(
        'posts_per_page' => 12,
        'paged' => $paged,
        'author_name' => $author_name,
        'post_type' => array('lwa_feature', 'lwa_news'),
      );
    } else {
      $args = Array(
        'posts_per_page' => 12,
        'paged' => $paged,
        'author_name' => $author_name,
         'post_type' => array('lwa_feature', 'lwa_news'),
        'meta_key' => '_count-views_all',
        'orderby' => 'meta_value_num'
      );
    }

    $wp_query = new WP_Query( $args );
    $idx = 1;
    if ( $wp_query->have_posts() ):
      while ( $wp_query->have_posts() ): 
        $wp_query->the_post();
  ?>
        <div class="f-1-3 bp1-1-2">
          <?php get_template_part('partials/article', 'thumb'); ?>
        </div>
  <?php
      generate_inline_thumb_fix($idx++);  
      endwhile;
    endif;
  ?>
    </div>
      <?php get_template_part('partials/module', 'paginate-links'); ?>
    </div>
  </div>

<?php 
  wp_reset_query();
  
  get_footer(); 
?>