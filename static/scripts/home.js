/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.Home = (function() {

  return {
    init: function() {
      $('.feature-carousel').flexslider({
        controlsContainer: '#feature-carousel-control',
      });

      LWA.Modules.Loader({
        imageContent: '.header-feature-bg',
        hiddenContent: '.header-feature .m-wrap',
        loader: LWA.Modules.Spinner('.header-feature .loader-icon', {show: true})
      });
    }
  };

})();

LWA.Views.Home.init();
