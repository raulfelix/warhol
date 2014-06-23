<?php 
  $order_query_var = isset($_GET['orderby']) ? $_GET['orderby'] : 'desc';
  $page_param = (get_query_var('page')) ? '?page=' . get_query_var('page') : '?page=1';
?>

<div class="f-row button-row button-row-left">
  <div class="f-1">
    <div id="dropdown-sort" class="button dropdown">
      <a href="javascript:void(0)" class="dropdown-label">
        <?php if ($order_query_var == 'desc'): ?>
          <span>sort by latest</span> 
        <?php else: ?>
          <span>sort by most popular</span>
        <?php endif; ?>
        <i class="icon-dropdown"></i>
      </a>
      <div class="dropdown-items">
        <a class="dropdown-item <?php echo ($order_query_var == "desc") ? 'dropdown-item-active':''?>" href="<?php echo $page_param; ?>&orderby=desc">sort by latest</a>
        <a class="dropdown-item <?php echo ($order_query_var == "popular") ? 'dropdown-item-active':''?>" href="<?php echo $page_param; ?>&orderby=popular">sort by most popular</a>
      </div>
    </div>
  </div>
</div>