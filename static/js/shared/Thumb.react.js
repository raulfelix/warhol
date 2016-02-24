var React = require('react');
var ReactDOM = require('react-dom');
var imagesLoaded = require('imagesLoaded');

module.exports = React.createClass({
  
  displayName: 'Thumb',
  
  getInitialState: function() {
    var ratio = 0;
    if (this.props.data && this.props.data.length) {
      ratio = (this.props.data[2] / this.props.data[1]);
    }
    return {
      isLoaded: false,
      ratio: ratio
    };
  },
  
  componentDidMount: function() {
    imagesLoaded(ReactDOM.findDOMNode(this), this.onImageLoaded);
  },
  
  
  render: function() {
    var
      imgNode,
      classes = 'thumb-loading',
      s = {};
      
    if (this.state.ratio === 0) {
      // no thumbnail
      imgNode = <img
        src={ajaxEndpoint.assets + "/static/images/placeholder.png"}
        alt="Post thumbnail" />
    } else {
      s.height = Math.floor(this.props.width * this.state.ratio) + 'px';
      imgNode = <img
        src={this.props.data[0]}
        alt="Post thumbnail" />
    }
    
    if (this.state.isLoaded) {
      classes = 'thumb-loading is-loaded';
      s = {};
    }
    
    return (
      <div className={classes} style={s}>
        {imgNode}
        <div className="m-overlay blanket-light"></div>
      </div>
    );
  },
  
  /**
   * When the image has loaded
   * @return {[type]} [description]
   */
  onImageLoaded: function() {
    this.setState({
      isLoaded: true
    });
  }
  
});