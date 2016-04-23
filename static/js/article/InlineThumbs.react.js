var React = require('react');
var ReactDOM = require('react-dom');
var $header;

module.exports = React.createClass({
  
  getInitialState: function() {
    return {
      initialised: false,
      thumbnails: [],
      sly: null
    };
  },
  
  componentDidMount: function() {
    $('#gallery-thumbs').click(this.toggle);
    $header = ReactDOM.findDOMNode(this).parentNode.parentNode;
    
    var self = this;
    $(window).resize(function() {
      if (self.state.sly) self.state.sly.reload();
    });
  },
  
  render: function() {
    
    var nodes = this.state.thumbnails.map(function(o, i) {
      return <li key={i}>
        <img src={o.src} width="150" height="150" />
      </li>
    });
    
    return (
      <div className="header-gallery-thumbs frame">
        <ul className="slidee">{nodes}</ul>
        <div className="sly-controls">
          <button ref="prev" className="sly-prev"><i className="icon-arrow-left"></i></button>
          <button ref="next" className="sly-next"><i className="icon-arrow-right"></i></button>
        </div>
      </div>
    );
  },
  
  /**
   * Setup slider.
   */
  initialiseSly: function() {
    var sly = new Sly(ReactDOM.findDOMNode(this), {
      horizontal: 1,
      itemNav: 'basic',
      smart: 1,
      activateOn: 'click',
      mouseDragging: 1,
      touchDragging: 0,
      releaseSwing: 1,
      startAt: 0,
      speed: 300,
      elasticBounds: 1,
      easing: 'swing',
      prevPage: this.refs.prev,
      nextPage: this.refs.next
    }).init();
    
    sly.on('active', this.onActivate);
    
    this.setState({
      sly: sly
    });
  },
  
  /**
   * Toggle thumbnail visibility.
   */
  toggle: function() {
    if (!this.state.initialised) {
      this.setState({
        initialised: true,
        thumbnails: LWA.Data.Gallery.thumbnails
      }, this.initialiseSly);
    }
    $header.classList.toggle('header-gallery-thumbs-active');
  },
  
  /**
   * When image activated set the inline gallery.
   * @param  {string} eventName
   * @param  {number} position
   */
  onActivate: function(eventName, position) {
    LWA.Views.Gallery.setActive(position);
  },
  
  /**
   * Public function to set the active item.
   * @param  {number} position
   */
  setActive: function(position) {
    this.state.sly.activate(position);
  }
  
});