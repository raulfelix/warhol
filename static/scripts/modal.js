/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

/*
 * Overlay a modal view setting html element to 
 * overflow hidden to prevent scrolling
 */
LWA.Modules.Modal = function(triggerSelector, modalSelector) {

  var $html, $modal;

  function onOpen(ev) {
    ev.preventDefault();
    $modal.toggleClass('modal-active');
    $html.toggleClass('no-scroll');
  }

  function onClose() {
    $modal.removeClass('modal-active');
    $html.removeClass('no-scroll');
  }

  function init() {
    $html = $('html');
    $modal = $(modalSelector);
    $(triggerSelector).on('click', onOpen);
    $('.modal-close', $modal).click(onClose);
  }

  init();

  return {
  };

};