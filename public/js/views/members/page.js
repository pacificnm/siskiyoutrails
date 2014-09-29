define([
  'jquery',
  'lodash',
  'backbone',
  'events',
  'text!templates/members/page.html',
  'text!templates/members/list.html',
  'text!templates/members/filter.html',
], function($, _, Backbone, Events, MemberTpl, ListMemberTpl, FilterMemberTpl){
  var MemberView = Backbone.View.extend({
    el: '#main',
    intialize: function () {

    },
    
    events: {
    	
    },
    
    render: function () {
    	var compiledTemplate = _.template(MemberTpl, {filterMemberTpl:FilterMemberTpl, listMemberTpl:ListMemberTpl});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return MemberView;
});
