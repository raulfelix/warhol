<div id="modal-search" class="modal modal-search">
  <div class="blanket blanket-alpha"></div>
  <a class="modal-action modal-close" href="javascript:void(0)"><i class="icon-close"></i></a>
  <div class="modal-view f-grid f-row search-row">
    <div class="f-1">
      <a href="<?php echo get_home_url(); ?>" class="logo"></a>
      <div class="search-row-input">
        <div class="input-search">
          <input type="text" placeholder="Search for something">
          <div class="input-search-underline"></div>
        </div>
        <button id="js-search" class="button button-search button-loader button-icon" type="text">
          <span class="button-text text"><i class="icon icon-search"></i>Search</span>
          <?php get_template_part('partials/module', 'util-loader'); ?>
        </button>
      </div>
    </div>
  </div>
  <div class="search-row-results">
    <div class="f-grid f-row">
      <div class="f-1">
        <div class="container"></div>
        <div class="pagination"></div>
        <div class="loader-container"></div>
      </div>
    </div>
  </div> 
</div>