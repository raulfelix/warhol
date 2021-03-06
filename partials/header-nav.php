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
  
  foreach ($cats as $cat) {
    if ($cat->slug == 'frames') {
      $frames = $cat->term_id;
    } elseif ($cat->slug == 'party-bullshit') {
      $party = $cat->term_id;
    } elseif ($cat->slug == 'tuesday-without') {
      $tuesday = $cat->term_id;
    } elseif ($cat->slug == 'twentyfour') {
      $twentyfour = $cat->term_id;
    }
  }
  
  $newsCats = get_categories(array(
    'orderby' => 'name',
    'order' => 'ASC',
    'parent' => 0,
    'taxonomy' => 'news_tax'
  ));
  
  foreach ($newsCats as $cat) {
    if ($cat->slug == 'news') {
      $news = $cat->term_id;
    } 
  }
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
    </div>
  </div>
  <div class="nav-links">
    <ul class="nav-links-primary">
      <li>
        <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/tuesday-without">Tuesday Without</a>
        <?php 
          $links = getSubNav($tuesday, 'featured_tax'); 
          if ($links) {
            echo '<button type="button" class="nav-touch-toggle">+</button>';
            echo $links;
          }
        ?>
      </li>
      
      <li>
        <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/party-bullshit">Party &amp; Bullshit</a>
        <?php $links = getSubNav($party, 'featured_tax'); 
          if ($links) {
            echo '<button type="button" class="nav-touch-toggle">+</button>';
            echo $links;
          }
        ?>
      </li>
      <li>
        <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/twentyfour">TwentyFour</a>
        <?php $links = getSubNav($twentyfour, 'featured_tax');
          if ($links) {
            echo '<button type="button" class="nav-touch-toggle">+</button>';
            echo $links;
          }
         ?>
      </li>
      <li>
        <a class="nav-link" href="<?php echo get_home_url(); ?>/featured/frames">Frames</a>
        <?php $links = getSubNav($frames, 'featured_tax');
          if ($links != false) {
            echo '<button type="button" class="nav-touch-toggle">+</button>';
            echo $links;
          }
         ?>
      </li>
      <li>
        <a class="nav-link" href="<?php echo get_home_url(); ?>/news/news">News</a>
        <?php $links = getSubNav(0, 'news_tax');
          if ($links) {
            echo '<button type="button" class="nav-touch-toggle">+</button>';
            echo $links;
          }
         ?>
      </li>
      <li><a class="nav-link" href="http://www.lifewithoutandy.myshopify.com">Shop</a></li>
      <li>
        <a class="nav-link" href="<?php echo get_permalink(get_page_by_title('info')); ?>">Info</a>
        <button type="button" class="nav-touch-toggle">+</button>
        <div class="nav-links-secondary">
          <div class="f-grid f-row">
            <a class="nav-sublink" href="<?php echo get_permalink(get_page_by_title('contributors')); ?>">contributors</a>
            <a class="nav-sublink" href="<?php echo get_permalink(get_page_by_title('subscribe')); ?>">Subscribe</a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>