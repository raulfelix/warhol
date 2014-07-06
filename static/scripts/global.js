/* global LWA, ajaxEndpoint */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Modules.Util = (function() {
  var
  $body,
  
  Ajax = {
    getUrl: function() {
      return ajaxEndpoint.url;
    }
  },

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
      Metric.windowWidth = $(window).width();
    },

    getWindowWidth: function() {
      return Metric.windowWidth;
    },

    setWindowHeight: function() {
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
    windowHeight: Metric.getWindowHeight,
    getUrl: Ajax.getUrl
  };

})();

$(document).ready(function() {
  LWA.Modules.Modal('.nav-search a', '#modal-search', { close: LWA.Modules.Search.close });
});