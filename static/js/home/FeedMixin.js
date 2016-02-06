module.exports = {
  
  load: function(postType, callback) {
    var self = this;
    
    if (this.state.page === false) {
      return;
    }

    this.setState({
      isLoading: true
    });
    
    $.getJSON(LWA.Modules.Util.getUrl(), {
      'action': 'do_ajax',
      'fn': postType,
      'page': this.state.page
    })
    .done(function(response) {
      self.setState({
        page: response.nextPage,
        posts: self.state.posts.concat(response.posts),
        isLoading: false
      });
      
      if (callback) callback();
    });
  }
  
}