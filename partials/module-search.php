<div id="modal-search" class="modal">
  <a class="modal-action modal-close" href="javascript:void(0)"><i class="icon-close"></i></a>
  <div class="modal-view f-grid f-row search-row">
    <div class="f-1">
      <a href="<?php echo get_home_url(); ?>" class="logo"></a>
      <div class="search-row-input">
        <input class="input-search" type="text" placeholder="Search for something">
        <button id="js-search" class="button button-search button-loader" type="text">
          <span class="text"><i class="icon-search"></i>Search</span>
          <img class="button-loader-icon" src="<?php bloginfo('template_directory'); ?>/static/images/loader.GIF " />
        </button>
      </div>
    </div>
  </div>
  <div class="f-1 search-row-results">
    <div class="container"></div>
    <div class="pagination"></div>
    <div class="loader-container"></div>
  </div> 
</div>