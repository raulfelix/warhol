/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Modules.Util = (function() {
  var
  $body,
  
  Metric = {
    windowWidth: undefined,
    windowHeight: undefined,

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
    },

    setWindowHeight: function() {
      console.log('set window height');
      Metric.windowHeight = $(window).height();
    },

    getWindowHeight: function() {
      return Metric.windowHeight;
    },

    update: function() {
      Metric.setWindowWidth();
      Metric.setWindowHeight();
    }
  };

  function init() {
    $body = $('body');
    Metric.setWindowWidth();
    Metric.setWindowHeight();
    $(window).resize(Metric.update);
  }

  init();

  return {
    getScrollPos: Metric.getScrollPos,
    setScroll: Metric.setScrollTop,
    windowWidth: Metric.getWindowWidth,
    windowHeight: Metric.getWindowHeight
  };

})();

$(document).ready(function() {
  LWA.Modules.Modal('.nav-search a', '#modal-search', { close: LWA.Modules.Search.close });
});