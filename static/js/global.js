var React = require('react');
var ReactDom = require('react-dom');
var Search = require('./global/Search.react');
var Nav = require('./global/Nav');
var BackUp = require('./global/BackUp');
var Share = require('./global/Share');


BackUp.init();
Nav.init();
Share.init();

ReactDom.render(
  <Search />,
  document.getElementById('search-react')
);