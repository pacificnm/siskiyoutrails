define([
  'jquery',
  'lodash',
  'backbone',
  'text!templates/header/menu.html'
], function($, _, Backbone, HeaderMenuTpl){
  var HeaderMenuView = Backbone.View.extend({
    el: '#menu',
    
    
    initialize: function () {
    	
    },
    
    render: function () {
    	this.headAccount = {
            	accountName:localStorage.getItem('accountName'),
            	accountAdmin:localStorage.getItem('accountAdmin'),
            };
    	
    	var compiledTemplate = _.template(HeaderMenuTpl, {headAccount: this.headAccount});
        $(this.el).html(compiledTemplate);
        $("#menu li").find('a[href="' + window.location.hash + '"]').parent().addClass('active');
    },
    
    events: {
      'click a': 'highlightMenuItem'
    },
    
    highlightMenuItem: function (ev) {
      $('.active').removeClass('active');
      $(ev.currentTarget).parent().addClass('active');
    }
  });

  return HeaderMenuView;
});
