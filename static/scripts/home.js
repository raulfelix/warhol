/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.Home = (function() {

  var Carousel = {
    
    slider: undefined,

    next: function() {
      Carousel.slider.next();
    },
    
    prev: function() {
      Carousel.slider.prev();
    },

    init: function() {
      var container = $('.header-carousel-slides'),
        controlsContainer = $('.header-carousel-controls');
      
      container.royalSlider({
        arrowsNav: false,
        autoPlay: {
          delay: 5000,
          enabled: true,
          pauseOnHover: false
        },
        loopRewind: true,
        navigateByClick: false,
        sliderDrag: false,
        sliderTouch: true,
        transitionSpeed: 500,
        transitionType: 'fade'
      });

      Carousel.slider = container.data('royalSlider');
      controlsContainer.find('.next').click(Carousel.next);
      controlsContainer.find('.prev').click(Carousel.prev);
    }
  };

  return {
    init: function() {
      LWA.Modules.Loader({
        imageContent: '.header-feature-bg',
        hiddenContent: '.header-feature .m-wrap',
        loader: LWA.Modules.Spinner('.header-feature .loader-icon', {show: true}),
        delayLoader: 1600,
        delayReveal: 1600,
        callback: Carousel.init
      });
    }
  };

})();

LWA.Views.Home.init();
