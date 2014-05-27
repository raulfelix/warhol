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

  return {
    init: function() {
      buttonUrl = $('#modal-share .button-url');
      modal = LWA.Modules.Modal('.button-share', '#modal-share', {
        open: function() {
          buttonUrl.focus().select();
        }
      });

      modal.el().find('.button-social').click(share);
    }
  };

})();

LWA.Modules.Share.init();