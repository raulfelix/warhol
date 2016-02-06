var React = require('react');
var Waypoint = require('react-waypoint');
var PostThumb = require('../shared/PostThumb');
var FeedMixin = require('./FeedMixin');

module.exports = React.createClass({
  
  mixins: [FeedMixin],
  
  getInitialState: function() {
    return {
      page: 1,
      posts: [],
      isLoading: false
    }
  },
  
  render: function() {
    var s = {
      opacity: this.state.isLoading ? 1 : 0  
    },
    nodes = [];
    
    for (var i = 0; i < this.state.posts.length; i++) {
      var id = this.state.posts[i].id;
      if (i % 2 === 0) {
        nodes.push(<div key={'n' + id} className="thumb-touch-inline-fix"></div>);
      }
      if (i % 3 === 0) {
        nodes.push(<div key={'m' + id} className="thumb-inline-fix"></div>);
      }
      nodes.push(
        <div key={id} className="f-1-3 bp1-1-2">
          <PostThumb data={this.state.posts[i]} />
        </div>
      );
    }
    
    return (
      <section className="f-grid section-thumb section-thumb-news">
        <div className="f-row">
          {nodes}
        </div>
        <div className="row-loader" style={s}><i className="icon-loader is-loading"></i></div>
        <Waypoint onEnter={this.onEnter} />
      </section>
    );
  },
  
  
  onEnter: function() {
    this.load('get_next_news_posts');
  }
    
});