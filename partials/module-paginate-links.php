<div class="f-row button-row button-row-paginate">
  <div class="f-1">
  
  <?php 

    $prev_num = null;
    $next_num = null;

    if ( $wp_query->max_num_pages > 1 ) {
      if ( $paged > 1 ) {
        $prev_num = '?page=' . ($paged - 1);
      }

      if ( $paged < $wp_query->max_num_pages ) {
        $next_num = '?page=' . ($paged + 1);
      }
    }

    // append order query variable
    $order = (get_query_var('order')) ? get_query_var('order') : '';
    if ($prev_num == null) {
      $order_prev = '?order=' . $order;
    } else {
      $order_prev = '&order=' . $order;
    }

    if ($next_num == null) {
      $order_next = '?order=' . $order;
    } else {
      $order_next = '&order=' . $order;
    }

  ?>
  
  <a class="button button-prev <?php echo $prev_num === null ? 'button-disabled':'' ?>" href="<?php echo $prev_num; ?><?php echo $order_prev; ?>"><i class="icon-arrow-prev"></i>prev</a>
  <a class="button button-next <?php echo $next_num === null ? 'button-disabled':'' ?>" href="<?php echo $next_num; ?><?php echo $order_next; ?>"><i class="icon-arrow-next"></i>next</a>

  </div>
</div>