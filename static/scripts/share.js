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

  function positionContent() {
    var windowHeight = $(window).height(),
      contentHeight = modal.$el.find('.modal-view').height();
    if (windowHeight > contentHeight) {
      modal.$el.find('.modal-view').css('margin-top', (windowHeight - contentHeight) / 2 );
    } else {
      modal.$el.find('.modal-view').css('margin-top', '20px');
    }
  }

  return {
    init: function() {
      buttonUrl = $('#modal-share .button-url').click(highlight);

      modal = LWA.Modules.Modal('.button-share', '#modal-share', { open: positionContent });
      modal.$el.find('.button-social').click(share);
    }
  };

})();

LWA.Modules.Share.init();