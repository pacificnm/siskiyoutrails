define([
  'jquery',
  'lodash',
  'backbone',
  'events',
  'text!templates/members/view.html',
  'text!templates/members/tabs.html',
], function($, _, Backbone, Events, ViewMemberTpl, TabsMemberTpl	){
  var ViewMemberView = Backbone.View.extend({
    el: '#main',
    intialize: function (options) {
    	console.log(options);
    },
    
    events: {
    	
    },
    
    render: function () {
    	var compiledTemplate = _.template(ViewMemberTpl, {memberTabs:TabsMemberTpl });
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return ViewMemberView;
});
