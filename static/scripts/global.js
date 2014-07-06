/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Modules.Util = (function() {
  var
  $body,
  
  Metric = {
    windowWidth: undefined,

    setScrollTop: function(position) {
      $body.scrollTop(position);
    },

    getScrollPos: function() {
      return $body.scrollTop();
    },

    setWindowWidth: function() {
      console.log('set window width');
      Metric.windowWidth = $(window).width();
    },

    getWindowWidth: function() {
      return Metric.windowWidth;
    }
  };

  function init() {
    $body = $('body');
    Metric.setWindowWidth();
    
    $(window).resize(Metric.setWindowWidth);
  }

  init();

  return {
    getScrollPos: Metric.getScrollPos,
    setScroll: Metric.setScrollTop,
    windowWidth: Metric.getWindowWidth
  };

})();

$(document).ready(function() {
  LWA.Modules.Modal('.nav-search a', '#modal-search', { close: LWA.Modules.Search.close });
});