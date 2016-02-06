var React = require('react');
var Waypoint = require('react-waypoint');
var SearchThumb = require('./SearchThumb.react');

module.exports = React.createClass({
  
  getInitialState: function() {
    return {
      page: 1,
      posts: [],
      hasCompleteASearch: false
    };
  },
  
  render: function() {
    var s = {
      opacity: this.state.page === false || this.state.page === 1 ? 0 : 1
    };
    
    var nodes = this.state.posts.map(function(post, idx) {
      return <SearchThumb data={post} key={idx} />
    });
    
    return (
      <div className="modal-view search-row">
        <div className="search-row-input">
          <div className="input-search input-clearable">
            <input type="text"
              placeholder="Search and press enter"
              value={this.state.term}
              onKeyUp={this.onKeyUp}
              onChange={this.onChange} />
            <button type="button" 
              className="button-input icon-close"
              onClick={this.reset}></button>
            <div className="input-search-underline"></div>
          </div>
        </div>
        <div className="search-row-results">
          <div className="container">{nodes}</div>
          <div className="row-loader" style={s}><i className="icon-loader is-loading"></i></div>
          <Waypoint onEnter={this.onEnter} />
        </div> 
      </div>
    )
  },
  
  reset: function() {
    this.setState({
      posts: [],
      page: 1,
      hasCompleteASearch: false,
      term: ''
    })
  },
  
  onChange: function(e) {
    this.setState({
      term: e.target.value
    })
  },
  
  onKeyUp: function(e) {
    if (e.keyCode === 13) {
      this.setState({
        page: 1,
        posts: [],
        hasCompleteASearch: true
      }, this.load);
    }
  },
  
  
  onEnter: function() {
    if (this.state.hasCompleteASearch && this.state.page !== false) {
      this.load();
    }
  },
  
  
  load: function() {
    var self = this;
    $.getJSON(LWA.Modules.Util.getUrl(), {
      'action': 'do_ajax',
      'fn': 'search_posts',
      'page': this.state.page,
      'posts_per_page': 7,
      's': this.state.term
    })
    .done(function(response) {
      self.setState({
        page: response.nextPage,
        posts: self.state.posts.concat(response.posts)
      });
    })
    .fail(function(response) {
      console.log(response);
    });
  }
  
});