/* global LWA, ajaxEndpoint */
window.LWA = window.LWA || {};

window.Namespace = function (ns) {
  var parent = window.LWA, namespace = ns.split('.');
 
  for (var i = 0, length = namespace.length; i < length; i++) {
    var name = namespace[i];
    if (typeof parent[name] === 'undefined') {
      parent[name] = {};
    }
    parent = parent[name];
  }
  return parent;
};


var Modules = window.Namespace('Modules');
Modules.Util = (function() {
  var $body,
  
  Ajax = {
    getUrl: function() {
      return ajaxEndpoint.url;
    }
  },

  Responsive = {
    BP3: {
      state: undefined,
      query: '(max-width: 768px)',

      match: function() {
        return this.state;
      },

      set: function() {
        this.state = window.matchMedia && window.matchMedia(this.query).matches;
      }
    },

    BP1: {
      state: undefined,
      query: '(max-width: 599px)',

      match: function() {
        return this.state;
      },

      set: function() {
        this.state = window.matchMedia && window.matchMedia(this.query).matches;
      }
    },

    setBreakpoints: function() {
      Responsive.BP1.set();
      Responsive.BP3.set();
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
      Responsive.setBreakpoints();
    }
  };

  function init() {
    $body = $('body');
    Metric.update();
    $(window).resize(Metric.update);
  }

  init();

  return {
    getScrollPos: Metric.getScrollPos,
    setScroll: Metric.setScrollTop,
    windowWidth: Metric.getWindowWidth,
    windowHeight: Metric.getWindowHeight,
    getUrl: Ajax.getUrl,
    getResponsive: function () {
      return Responsive;
    }
  };

})();

$(document).ready(function() {
  LWA.Modules.Modal('.nav-search a', '#modal-search', { close: LWA.Modules.Search.close });
});