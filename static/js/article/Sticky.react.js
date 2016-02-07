var React = require('react');
var Waypoint = require('react-waypoint');

module.exports = React.createClass({

  componentDidMount: function() {
    this._local = {
      ad: document.getElementById('div-gpt-ad-1453981103890-0')
    };
  },
  
  render: function() {
    return (
      <Waypoint onEnter={this.onEnter} onLeave={this.onLeave} />
    );
  },
  
  onEnter: function(e, position) {
    console.log('enter', position);
    
    if (position === 'above') {
      // if stuck unstick it
      this._local.ad.style.position = 'relative';
      this._local.ad.style.top = 'auto';
      this._local.ad.style.zIndex = '1';
    }
    
  },
  
  onLeave: function(e, position) {
    console.log('leave', position);
      // stick the add in place
    if (position === 'above') {
      this._local.ad.style.position = 'fixed';
      this._local.ad.style.top = '0';
      this._local.ad.style.zIndex = '100';
    }
  }
  
});