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
          $paged = (get_query_var('page')) ? get_query_var('page') : 1;

          $author_query = custom_authors_query($user->ID, $paged, $order, 12);
          if ($author_query): 
            global $post;
            $idx = 1;
            foreach( $author_query as $post ):
              setup_postdata($post);
        ?>
        
        <div class="f-1-3 bp1-1-2">
          <?php get_template_part('partials/article', 'thumb'); ?>
        </div>
        
        <?php
            generate_inline_thumb_fix($idx++);     
            endforeach;
          endif;
        ?>
      </div>

      <div class="f-row button-row button-row-paginate">
        <div class="f-1">
          <?php 
            $prev_num = null;
            $next_num = null;

            if ( $max_num_pages > 1 ) {
              if ( $paged > 1 ) {
                $prev_num = '?page=' . ($paged - 1);
              }
              if ( $paged < $max_num_pages ) {
                $next_num = '?page=' . ($paged + 1);
              }
            }

            // append order query variable
            $order = isset($_GET['orderby']) ? $_GET['orderby'] : 'desc';
            if ($prev_num == null) {
              $order_prev = '?orderby=' . $order;
            } else {
              $order_prev = '&orderby=' . $order;
            }

            if ($next_num == null) {
              $order_next = '?orderby=' . $order;
            } else {
              $order_next = '&orderby=' . $order;
            }
          ?>
          
          <a class="button button-prev <?php echo $prev_num === null ? 'button-disabled':'' ?>" href="<?php echo $prev_num; ?><?php echo $order_prev; ?>"><i class="icon-arrow-prev"></i>prev</a>
          <a class="button button-next <?php echo $next_num === null ? 'button-disabled':'' ?>" href="<?php echo $next_num; ?><?php echo $order_next; ?>"><i class="icon-arrow-next"></i>next</a>
        </div>
      </div>
    </div>
  </div>

<?php 
  wp_reset_query();
  wp_enqueue_script( 'dropdown' );

  get_footer(); 
?>