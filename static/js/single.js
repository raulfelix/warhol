var React = require('react');
var ReactDOM = require('react-dom');
var Subscribe = require('./article/Subscribe');
var Sticky = require('./article/Sticky.react');

Subscribe.init();

LWA.Modules.Loader({
  imageContent: '.header-feature-bg',
  hiddenContent: '#header-feature .m-wrap',
  loader: LWA.Modules.Spinner('#header-feature .loader-icon', {show: true})
});

LWA.Modules.Loader({
  imageContent: '.media-target-footer',
  hiddenContent: '.footer-next-feature .m-wrap'
});

ReactDOM.render(
  <Sticky />,
  document.getElementById('LWA_sidebar_02-waypoint')
);