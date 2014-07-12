/* global LWA */
window.Namespace('Views');

LWA.Views.BackUp = (function() {

  var $body;

  function scroll() {
    $body.animate({
      scrollTop: 0
    }, 500);
  }

  return {
    init: function() {
      $body = $('html,body');
      $('#back-up').click(scroll);
    }
  };

})();

LWA.Views.BackUp.init();