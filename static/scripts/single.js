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