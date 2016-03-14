/* global LWA, Sly, imagesLoaded, Handlebars, ga */
var LazyLoader = require('./LazyLoader');

function Strip(frame, loader, imgs) {
  
  var swiper;
  
  function reflow() {
    if (window.matchMedia('(max-width: 480px)').matches) {
      setHeights(imgs, 240);
      frame.style.height = '240px';
    }
    else if (window.matchMedia('(max-width: 650px)').matches) {
      setHeights(imgs, 360);
      frame.style.height = '360px';
    } else {
      setHeights(imgs, 500);
      frame.style.height = '500px';
    }
    swiper.reload();
  }
  
  swiper = new Sly(frame, {
    horizontal: 1,
    itemNav: 'centered',
    smart: 1,
    activateOn: 'click',
    touchDragging: 0,
    releaseSwing: 1,
    startAt: 0,
    speed: 300,
    elasticBounds: 1,
    easing: 'swing'
  });
  
  swiper.init();
  
  $(frame.getElementsByClassName('sly-next')[0]).click(function() {
    swiper.next();
    loader.load(swiper.rel.activeItem + 1);
  });
  
  
  $(frame.getElementsByClassName('sly-prev')[0]).click(function() {
    swiper.prev();
  });
  
  reflow();
  
  $(window).resize(function() {
    reflow();
  });
}


function setHeights(imgs, height) {
  for (var j = 0; j < imgs.length; j++) {
    var r = parseInt(imgs[j].getAttribute('data-width')) / parseInt(imgs[j].getAttribute('data-height'));
    imgs[j].parentNode.style.width = Math.floor(r * height) + 'px';
  }
}

var Gallery = {
  
  init: function() {
    var $frames = document.getElementsByClassName('swiper-container');
    
    for (var i = 0; i < $frames.length; i++) {
      var imgs = $frames[i].getElementsByTagName('img');
      setHeights(imgs, 500);
      var lazy = LazyLoader.init(imgs);
      var strip = new Strip($frames[i], lazy, imgs);
    }
  }
  
};

module.exports = Gallery;