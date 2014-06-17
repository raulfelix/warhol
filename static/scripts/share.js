/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Modules.Share = (function() {

  var modal, buttonUrl;

  function share() {
    window.open(
      $(this).data('href'),
      '',
      'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'
    );
  }

  function highlight() {
    buttonUrl.select();
    return false;
  }

  return {
    init: function() {
      buttonUrl = $('#modal-share .button-url').click(highlight);

      modal = LWA.Modules.Modal('.button-share', '#modal-share');
      modal.el().find('.button-social').click(share);
    }
  };

})();

LWA.Modules.Share.init();