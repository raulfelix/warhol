<?php 
  $order_query_var = get_query_var('order');
  $page_param = (get_query_var('page')) ? '?page=' . get_query_var('page') : '?page=1';
?>

<div class="f-row button-row button-row-left">
  <div class="f-1">
    <button id="dropdown-sort" class="button dropdown">
      <a href="javascript:void(0)" class="dropdown-label">
        <?php if ($order_query_var == "DESC"): ?>
          <span>sort by latest</span> 
        <?php else: ?>
          <span>sort by oldest</span>
        <?php endif; ?>
        <i class="icon-dropdown"></i>
      </a>
      <div class="dropdown-items">
        <a class="dropdown-item <?php echo ($order_query_var == "DESC") ? 'dropdown-item-active':''?>" href="<?php echo $page_param; ?>&order=DESC" data-sort="latest">sort by latest</a>
        <a class="dropdown-item <?php echo ($order_query_var == "ASC") ? 'dropdown-item-active':''?>" href="<?php echo $page_param; ?>&order=ASC" data-sort="oldest">sort by oldest</a>
      </div>
    </button>
  </div>
</div>