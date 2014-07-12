/* global LWA */
window.Namespace('Views');

LWA.Views.Navigation = (function() {

  var $nav;

  function onClick(ev) {
    ev.preventDefault();
    $nav.toggleClass('nav-active');
  }

  return {
    init: function() {
      $nav = $('.nav');
      $nav.find('#nav').click(onClick);
    }
  };

})();

LWA.Views.Navigation.init();