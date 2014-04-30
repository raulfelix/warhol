/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.Home = (function() {

  return {
    init: function() {
      $('.feature-carousel').flexslider();
    }
  };

})();

LWA.Views.Home.init();
