/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.Home = (function() {

  return {
    initialiseCarousel: function() {
      $('.feature-carousel').flexslider({
        controlsContainer: '#feature-carousel-control',
        initDelay: 1000 // delay the start
      });
    },

    init: function() {
      LWA.Modules.Loader({
        imageContent: '.header-feature-bg',
        hiddenContent: '.header-feature .m-wrap',
        loader: LWA.Modules.Spinner('.header-feature .loader-icon', {show: true}),
        delayLoader: 1600,
        delayReveal: 1700,
        callback: this.initialiseCarousel
      });
    }
  };

})();

LWA.Views.Home.init();
