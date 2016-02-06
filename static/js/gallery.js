/* global LWA, Sly, imagesLoaded, Handlebars, ga */
var LazyLoader = require('./LazyLoader');

function Strip(frame, loader, imgs) {
  
  var
    sly;
  
  function reflow() {
    if (window.matchMedia('(max-width: 480px)').matches) {
      setHeights(imgs, 300);
      frame.style.height = '300px';
    } else {
      setHeights(imgs, 500);
      frame.style.height = '500px';
    }
    sly.reload();
  }
  
  function next() {
    sly.next();
    loader.load(sly.rel.activePage + 1);
  }
  
  function prev() {
    sly.prev();
  }
  
  // create a sly bastard
  sly = new Sly(frame, {
    horizontal: 1,
    itemNav: 'centered',
    smart: 1,
    activateOn: 'click',
    touchDragging: 1,
    releaseSwing: 1,
    startAt: 0,
    speed: 300,
    elasticBounds: 1,
    easing: 'swing'
  });
  
  sly.on('active', function(eventName, idx) {
    console.log(idx);
  });
  
  $(frame.getElementsByClassName('sly-next')[0]).click(function() {
    sly.next();
    loader.load(sly.rel.activePage + 1);
  });
  
  
  $(frame.getElementsByClassName('sly-prev')[0]).click(function() {
    sly.prev();
  });
  
  frame.style.height = '500px';
  
  reflow();
  $(window).resize(function() {
    reflow();
  });
  
  
  setTimeout(function() {
    sly.init();
  }, 100);
}


function setHeights(imgs, height) {
  for (var j = 0; j < imgs.length; j++) {
    var r = parseInt(imgs[j].getAttribute('data-width')) / parseInt(imgs[j].getAttribute('data-height'));
    imgs[j].parentNode.style.width = Math.floor(r * height) + 'px';
  }
}

var Gallery = {
  
  init: function() {
    var $frames = document.getElementsByClassName('gallery');
    
    for (var i = 0; i < $frames.length; i++) {
      var imgs = $frames[i].getElementsByTagName('img');
      setHeights(imgs, 500);
      var lazy = LazyLoader.init(imgs);
      var strip = new Strip($frames[i], lazy, imgs);
    }
  }

  
};

module.exports = Gallery;