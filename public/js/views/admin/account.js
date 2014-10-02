define([
  'jquery',
  'lodash',
  'backbone',
  'collections/account',
  'text!templates/admin/account.html',
], function($, _, Backbone, AccountCollection, AccountTpl){
  var AdminView = Backbone.View.extend({
    el: '#adminSection',
    
    intialize: function () {
    	this.account = new AccountCollection({account_email:localStorage.getItem('accountEmail'),account_token:localStorage.getItem('accountToken') });
    	
    	this.accounts = new AccountCollection({account_email:localStorage.getItem('accountEmail'),account_token:localStorage.getItem('accountToken') });
    	
    	this.listenTo(this.accounts, 'add', this.render);
	    this.listenTo(this.accounts, 'change', this.render);
	    this.listenTo(this.accounts, 'remove', this.render);
    },
    
    
    events: {
    	
    },

    render: function () {
    	var compiledTemplate = _.template(AccountTpl, {accounts:this.accounts});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return AdminView;
});