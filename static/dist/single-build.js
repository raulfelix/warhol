/* global LWA */
window.Namespace('Modules');

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
    var contentHeight = modal.$el.find('.modal-view').height();
    if (LWA.Modules.Util.windowHeight() > contentHeight) {
      modal.$el.find('.modal-view').css('margin-top', (LWA.Modules.Util.windowHeight() - contentHeight) / 2 );
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
/* global LWA */
LWA.Modules.Loader({
  imageContent: '.header-feature-bg',
  hiddenContent: '#header-feature .m-wrap',
  loader: LWA.Modules.Spinner('#header-feature .loader-icon', {show: true})
});

LWA.Modules.Loader({
  imageContent: '.media-target-footer',
  hiddenContent: '.footer-next-feature .m-wrap'
});