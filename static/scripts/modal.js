/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

/*
 * Overlay a modal view setting html element to 
 * overflow hidden to prevent scrolling.
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

  function onOpen() {
    $modal.toggleClass('modal-active');
    $html.toggleClass('no-scroll');
    if (options.open) {
      options.open();
    }
  }

  function onClose() {
    $modal.removeClass('modal-active');
    $html.removeClass('no-scroll');
    if (options.close) {
      options.close();
    }
  }

  function canClose(ev) {
    if (ev.target.nodeName !== 'IMG' && ev.target.nodeName !== 'I' && ev.target.className === 'modal-wrap-row' || ev.target.className === 'sly-slide active') {
      onClose();
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
      $(triggerSelector).on('click', onOpen);
    }
    
    $('.modal-close', $modal).click(onClose);
  }

  init();

  return {
    loader: {
      start: Loader.start,
      stop: Loader.stop
    },
    show: function() {
      onOpen();
      return this;
    },
    el: function() {
      return $modal;
    }
  };

};