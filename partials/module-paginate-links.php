<div class="f-row button-row button-row-paginate">
  <div class="f-1">
  
  <?php 

    $prev_num = null;
    $next_num = null;
    
    if ( $wp_query->max_num_pages > 1 ) {
      if ( $paged > 1 ) {
        $prev_num = $paged -1;
      }

      if ( $paged < $wp_query->max_num_pages ) {
        $next_num = $paged + 1;
      }
    }

  ?>
  
  <a class="button button-prev <?php echo $prev_num === null ? 'button-disabled':'' ?>" href="?page=<?php echo $prev_num; ?>"><i class="icon-arrow-prev"></i>prev</a>
  <a class="button button-next <?php echo $next_num === null ? 'button-disabled':'' ?>" href="?page=<?php echo $next_num; ?>"><i class="icon-arrow-next"></i>next</a>

  </div>
</div>