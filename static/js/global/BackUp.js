module.exports = (function() {

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