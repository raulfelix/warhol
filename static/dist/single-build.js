/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Modules.Share = (function() {

  function share() {
    window.open(
      $(this).data('href'),
      '',
      'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'
    );
  }

  return {
    init: function() {
      $('#modal-share .button-social').click(share);
    }
  };

})();

LWA.Modules.Share.init();