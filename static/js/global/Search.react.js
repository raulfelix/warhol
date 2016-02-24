var React = require('react');
var Waypoint = require('react-waypoint');
var SearchThumb = require('./SearchThumb.react');

module.exports = React.createClass({
  
  getInitialState: function() {
    return {
      page: 1,
      posts: null,
      hasCompleteASearch: false,
      term: ''
    };
  },
  
  render: function() {
    var nodes;
    
    var s = {
      opacity: this.state.page === false || this.state.page === 1 ? 0 : 1
    };
    
    if (this.state.isLoading) {
      s.opacity = 1;
    }
    
    if (this.state.posts !== null && this.state.posts.length === 0) {
      nodes = <span>There are no results to display</span>
    } else if (this.state.posts !== null) {
      nodes = this.state.posts.map(function(post, idx) {
        return <SearchThumb data={post} key={idx} />
      });
    }
    
    return (
      <div className="modal-view search-row">
        <div className="search-row-input">
          <div className="input-search input-clearable">
            <input
              type="text"
              ref="field"
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
          <div className="container">
            {nodes}
          </div>
          <div className="row-loader" style={s}><i className="icon-loader is-loading"></i></div>
          <Waypoint onEnter={this.onEnter} />
        </div> 
      </div>
    )
  },
  
  /**
   * Clear the search results and 
   * refocus on the input field.
   */
  reset: function() {
    this.setState({
      posts: null,
      page: 1,
      hasCompleteASearch: false,
      term: ''
    });
    this.refs.field.focus();
  },
  
  
  /**
   * When text is entered in search field.
   * @param  {object} e 
   */
  onChange: function(e) {
    this.setState({
      term: e.target.value,
      hasCompleteASearch: false
    });
  },
  
  
  /**
   * Listen for the enter button.
   * @param  {object} e
   */
  onKeyUp: function(e) {
    if (e.keyCode === 13 && this.state.term.length > 0) {
      this.setState({
        page: 1,
        posts: null,
        hasCompleteASearch: true
      }, this.load);
    }
  },
  
  
  /**
   * Waypoint callback
   */
  onEnter: function() {
    if (this.state.hasCompleteASearch && this.state.page !== false) {
      this.load();
    }
  },
  
  
  /**
   * Fetch the search data.
   */
  load: function() {
    this.setState({
      isLoading: true
    });
    $.getJSON(LWA.Modules.Util.getUrl(), {
      'action': 'do_ajax',
      'fn': 'search_posts',
      'page': this.state.page,
      'posts_per_page': 7,
      's': this.state.term
    })
    .done(this.onSearchLoad)
    .fail(function(response) {
      console.log(response);
    });
  },
  
  
  /**
   * When search results load.
   * @param  {object} response { posts: [], nextPage: true }
   */
  onSearchLoad: function(response) {
    var posts = this.state.posts ? this.state.posts : [];
    this.setState({
      page: response.nextPage,
      posts: posts.concat(response.posts),
      isLoading: false
    });
    
    // if there are results blur the search field
    if (response.posts.length > 0) {
      this.refs.field.blur();
    }
  }
  
});