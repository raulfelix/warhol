var React = require('react');
var ReactDom = require('react-dom');
var FeatureFeed = require('./home/FeatureFeed.react');
var NewsFeed = require('./home/NewsFeed.react');
var Home = require('./home/home.js');

Home.init();

ReactDom.render(
  React.createElement(FeatureFeed),
  document.getElementById('feature-waypoint')
);

ReactDom.render(
  React.createElement(NewsFeed),
  document.getElementById('news-waypoint')
);