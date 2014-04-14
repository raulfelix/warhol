/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

/*
 *
 */
LWA.Modules.Modal = (function() {

  var $modal;

  function onClick(ev) {
    ev.preventDefault();
    $modal.toggleClass('modal-active');
  }

  function onClose() {
    $modal.removeClass('modal-active');
  }

  return {
    init: function(triggerSelector, modalSelector) {
      $modal = $(modalSelector);
      $(triggerSelector).on('click', onClick);
      $('.modal-close', $modal).click(onClose);
    }
  };

})();