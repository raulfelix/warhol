/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

/*
 *
 */
LWA.Modules.Modal = function(triggerSelector, modalSelector) {

  var $body, $modal;

  function onOpen(ev) {
    ev.preventDefault();
    $modal.toggleClass('modal-active');
    $body.toggleClass('no-scroll');
  }

  function onClose() {
    $modal.removeClass('modal-active');
    $body.removeClass('no-scroll');
  }

  function init() {
    $body = $('body');
    $modal = $(modalSelector);
    $(triggerSelector).on('click', onOpen);
    $('.modal-close', $modal).click(onClose);
  }

  init();

  return {
  };

};