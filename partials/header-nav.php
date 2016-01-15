
<nav class="header-nav nav">
  <div class="nav-primary-bg"></div>
  <div class="nav-secondary-bg"></div>
  <div class="f-grid f-row">
    <div class="f-1">
      <a href="<?php echo get_home_url(); ?>" class="logo"></a>
      <a href="javascript:void(0)" id="nav" class="nav-item nav-menu" >
        <i class="icon-menu"></i>
      </a>
      <a href="javascript:void(0)" class="nav-item nav-search">
        <i class="icon-search"></i>
      </a>
    
      <div class="nav-links">
        <ul class="nav-links-primary">
          <li><a class="nav-link" href="<?php echo get_home_url(); ?>/featured/tuesday-without">Tuesday Without</a></li>
          <li><a class="nav-link" href="<?php echo get_home_url(); ?>/featured/party-bullshit">Party &amp; Bullshit</a></li>
          <li><a class="nav-link" href="<?php echo get_home_url(); ?>/featured/twentyfour">TwentyFour</a></li>
          <li>
            <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/frames">Frames</a>
          </li>
          <li>
            <a class="nav-link" href="<?php echo get_home_url(); ?>/news/news">News</a>
            <div class="nav-links-secondary">
              <div class="f-grid f-row">
              <?php
                $args = array(
                  'orderby' => 'name',
                  'order' => 'ASC',
                  'parent' => 7,
                  'taxonomy' => 'news_tax'
                );
                $categories = get_categories($args);
                foreach ($categories as $category) { 
                  echo '<a class="nav-sublink" href="' . get_home_url() . '/news/' . $category->slug . '">' . $category->name . '</a>';
                }
                ?>
              </div>
            </div>
          </li>
          <li><a class="nav-link" href="http://www.lifewithoutandy.myshopify.com">Shop</a></li>
          <li><a class="nav-link" href="<?php echo get_permalink(get_page_by_title('info')); ?>">Info</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>