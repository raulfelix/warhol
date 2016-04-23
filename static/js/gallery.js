/* global LWA, Sly, imagesLoaded, Handlebars, ga */
var LazyLoader = require('./LazyLoader');
// 
// function setHeights(imgs, height) {
//   for (var j = 0; j < imgs.length; j++) {
//     var r = parseInt(imgs[j].getAttribute('data-width')) / parseInt(imgs[j].getAttribute('data-height'));
//     imgs[j].parentNode.style.width = Math.floor(r * height) + 'px';
//   }
// }

var Gallery = {
  
  init: function() {
    $('.swiper-container').slick({
      infinite: true,
      speed: 250,
      lazyLoad: 'progressive',
      slidesToShow: 1,
      centerMode: true,
      variableWidth: true,
      prevArrow: "<button class='sly-prev'><i class='icon-arrow-left'></i></button>",
      nextArrow: "<button class='sly-next'><i class='icon-arrow-right'></i></button>"
    });
  }
  
};

module.exports = Gallery;