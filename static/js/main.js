// main app
// 
var React = require('react');
var ReactDom = require('react-dom');

// var gallery = require('./Gallery');
// gallery.init();


var FeatureFeed = require('./home/FeatureFeed.react');
var NewsFeed = require('./home/NewsFeed.react');

ReactDom.render(
  React.createElement(FeatureFeed),
  document.getElementById('feature-waypoint')
);

ReactDom.render(
  React.createElement(NewsFeed),
  document.getElementById('news-waypoint')
);