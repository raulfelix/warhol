<?php

  // get all top level feartured categories
  $cats = get_categories(array(
    'orderby' => 'name',
    'order' => 'ASC',
    'parent' => 0,
    'taxonomy' => 'featured_tax'
  ));
  
  $tuesday = 0;
  $party = 0;
  $twentyfour = 0;
  $frames = 0;
  
  $length = count($cats);
  for ($i = 0; $i < $length; $i++) {
    
    if ($i == 0) {
      $frames = $cats[$i]->term_id;
    } elseif ($i == 1) {
      $party = $cats[$i]->term_id;
    } elseif ($i == 2) {
      $tuesday = $cats[$i]->term_id;
    } elseif ($i == 3) {
      $twentyfour = $cats[$i]->term_id;
    }
  }
  
  $newsCats = get_categories(array(
    'orderby' => 'name',
    'order' => 'ASC',
    'parent' => 0,
    'taxonomy' => 'news_tax'
  ));
?>

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
          <li>
            <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/tuesday-without">Tuesday Without</a>
            <?php echo getSubNav($tuesday, 'featured_tax'); ?>
          </li>
          
          <li>
            <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/party-bullshit">Party &amp; Bullshit</a>
            <?php echo getSubNav($party, 'featured_tax'); ?>
          </li>
          <li>
            <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/twentyfour">TwentyFour</a>
            <?php echo getSubNav($twentyfour, 'featured_tax'); ?>
          </li>
          <li>
            <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/frames">Frames</a>
            <?php echo getSubNav($frames, 'featured_tax'); ?>
          </li>
          <li>
            <a class="nav-link" href="<?php echo get_home_url(); ?>/news/news">News</a>
            <?php  echo getSubNav($newsCats[1]->term_id, 'news_tax'); ?>
          </li>
          <li><a class="nav-link" href="http://www.lifewithoutandy.myshopify.com">Shop</a></li>
          <li><a class="nav-link" href="<?php echo get_permalink(get_page_by_title('info')); ?>">Info</a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>