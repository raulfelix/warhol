/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

/*
 * Overlay a modal view setting html element to 
 * overflow hidden to prevent scrolling
 */
LWA.Modules.Modal = function(triggerSelector, modalSelector, options) {

  var $html, $modal;

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

  function init() {
    $html = $('html');
    $modal = $(modalSelector);

    if (options === undefined) {
      options = {};
    }
    
    if (triggerSelector !== undefined) {
      $(triggerSelector).on('click', onOpen);
    }
    
    $('.modal-close', $modal).click(onClose);
  }

  init();

  return {
    show: function() {
      onOpen();
    },
    el: function() {
      return $modal;
    }
  };

};