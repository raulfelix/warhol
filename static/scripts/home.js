/* global LWA */
window.Namespace('Views');

LWA.Views.Home = (function() {

  var Carousel = {
    
    element: {
      wrap: undefined,
      carousel: undefined
    },

    state: {
      spinner: undefined,
      slider: undefined
    },

    init: function() {
      var controls = $('.header-carousel-controls');
      controls.find('.next').click(Carousel.next);
      controls.find('.prev').click(Carousel.prev);

      Carousel.element.wrap = $('.header-feature .m-wrap');
      Carousel.element.carousel = Carousel.element.wrap.find('.header-carousel-slides');
      Carousel.state.slider = Carousel.element.carousel.royalSlider({
        arrowsNav: false,
        addActiveClass: true,
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
      }).data('royalSlider');

      // mark the first slide in carousel after initialisation
      Carousel.state.slider.currSlide.holder.addClass('first-slide');
      setTimeout(function() { Carousel.state.slider.currSlide.holder.addClass('first-slide-active'); }, 1650);
    },

    next: function() {
      Carousel.state.slider.next();
    },
    
    prev: function() {
      Carousel.state.slider.prev();
    },

    reload: function() {
      if (LWA.Modules.Util.getResponsive().BP1.match() && !Carousel.state.isTouch) {
        Carousel.refreshImages('mobile');
        Carousel.state.isTouch = true;
      }
      else if (!LWA.Modules.Util.getResponsive().BP1.match() && Carousel.state.isTouch) {
        Carousel.refreshImages('desktop');
        Carousel.state.isTouch = false;
      }
    },

    setImages: function(type) {
      $('.header-feature .m-wrap').attr('style', '');
      $('.header-feature-bg').each(function() {
        $(this).css('background-image', 'url(' + $(this).data(type) + ')');
      });
    },

    refreshImages: function(type) {
      Carousel.element.wrap.css('transition', 'opacity 100ms ease').addClass('m-transparent');
      Carousel.state.spinner.show();
      Carousel.setImages(type);
      
      setTimeout(function() { Carousel.element.wrap.attr('style', null); }, 200);

      LWA.Modules.Loader({
        imageContent: '.header-feature-bg',
        hiddenContent: Carousel.element.wrap,
        delayReveal: 1600,
        delayLoader: 1600,
        loader: Carousel.state.spinner
      });
    },

    onResize: function() {
      LWA.Modules.Util.delay(Carousel.reload, 200);
    }
  };

  return {
    init: function() {
      Carousel.state.isTouch = LWA.Modules.Util.getResponsive().BP1.match();
      Carousel.state.spinner = LWA.Modules.Spinner('.header-feature .loader-icon', { show: true });
      
      Carousel.setImages(Carousel.state.isTouch ? 'mobile' : 'desktop');
      
      LWA.Modules.Loader({
        imageContent: '.header-feature-bg',
        hiddenContent: '.header-feature .m-wrap',
        delayLoader: 1600,
        delayReveal: 1600,
        callback: Carousel.init,
        loader: Carousel.state.spinner
      });

      $(window).resize(Carousel.onResize);
    }
  };

})();

LWA.Views.Home.init();