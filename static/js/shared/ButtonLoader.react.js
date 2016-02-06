var React = require('react');
var ReactDOM = require('react-dom');

module.exports = React.createClass({
  
  getInitialState: function() {
    return {
      isLoading: false
    }
  },
  
  render: function() {
    var
      node,
      classes = ['button button-loader'];
    
    if (this.state.isLoading) {
      classes.push('button-loader-active');
      node = <i className="icon icon-loader is-loading"></i>
    } else {
      node = <span className="button-text">{this.props.label}</span>
    }
    
    return <button type="button" className={classes.join(' ')}
      onClick={this._onClick}>
      {node}
    </button>
  },
  
  
  _onClick: function() {
    if (this.state.isLoading) return;
    
    this.setState({
      isLoading: true
    });
    this.props.onClick();
  },
  
  
  stop: function() {
    this.setState({
      isLoading: false
    });
  },

  
  kill: function() {
    ReactDOM.findDOMNode(this).style.display = 'none';
  }
  
});