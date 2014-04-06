/* global LWA */
window.LWA = window.LWA || { Views: {} };

LWA.Views.BackUp = (function() {

  var $body;

  function scroll() {
    $body.animate({
      scrollTop: 0
    }, 500);
  }

  return {
    init: function() {
      $body = $('body');
      $('#back-up').click(scroll);
    }
  };

})();

LWA.Views.BackUp.init();