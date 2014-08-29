/* global LWA */
window.Namespace('Modules');

/*
 * Overlay a modal view setting html element to 
 * overflow hidden to prevent scrolling. This requires
 * caching of scroll position to be reset onClose.
 *
 * Include a loading view for slow content.
 */
LWA.Modules.Modal = function(triggerSelector, modalSelector, options) {

  var $html, $modal;

  var Loader = {

    start: function() {
      $modal.addClass('modal-loader-active');
      if (options.start) {
        options.start();
      }
    },

    stop: function() {
      $modal.removeClass('modal-loader-active');
      if (options.stop) {
        options.stop();
      }
    }

  };

  var Actions = {
    scrollTop: undefined,

    open: function() {
      Actions.scrollTop = LWA.Modules.Util.getScrollPos();

      $modal.toggleClass('modal-active');
      $html.toggleClass('no-scroll');

      if (options.open) {
        options.open();
      }
    },

    close: function() {
      $modal.removeClass('modal-active');
      $html.removeClass('no-scroll');
      
      // reset the scrollheight
      LWA.Modules.Util.setScroll(Actions.scrollTop);

      if (options.close) {
        options.close();
      }
    }
  };

  function canClose(ev) {
    if ($(ev.target).data('closeable') === 0) {
      Actions.close();
      ev.preventDefault();
    }
  }

  function init() {
    $html = $('html');
    $modal = $(modalSelector);

    if (options === undefined) {
      options = {};
    }

    if (options.closeable) {
      $modal.on('click', canClose);
    }
    
    if (triggerSelector !== undefined) {
      $(triggerSelector).on('click', Actions.open);
    }
    
    $('.modal-close', $modal).click(Actions.close);
  }

  init();

  return {
    loader: {
      start: Loader.start,
      stop: Loader.stop
    },
    show: function() {
      Actions.open();
      return this;
    },
    el: function() {
      return $modal;
    },
    $el: $modal
  };

};