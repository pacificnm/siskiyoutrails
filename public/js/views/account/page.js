define([
  'jquery',
  'lodash',
  'backbone',
  'models/account',
  'collections/account',
  'text!templates/account/page.html',
  'text!templates/account/login.html'
], function($, _, Backbone, Model, Collection, AccountPageTemplate, LoginTemplate){
  var AccountPage = Backbone.View.extend({
    el: '#main',
    
    initialize: function (options) {
        this.options = options || {};
        
        this.account = new Collection({account_email:localStorage.getItem('accountEmail'),account_token:localStorage.getItem('accountToken') });
        
        
        this.listenTo(this.account, 'add', this.render);
	    this.listenTo(this.account, 'change', this.render);
	    this.listenTo(this.account, 'remove', this.render);
    },
    
    render: function () {
    	model = this.account.get(localStorage.getItem('accountId'));
    	if(model) {
    		var compiledTemplate = _.template(AccountPageTemplate, {account: model});
    		$(this.el).html(compiledTemplate);
    	}
    	return this;
    },
    
    events: {
    	'click #editAccountBtn': 'showEditFrm',
    	'click #resetPasswordBtn': 'showResetPasswordFrm',
    	'click #saveAccountBtn': 'saveAccount'
    },
    
    
    showEditFrm: function (event) {
    	event.preventDefault();
    	$('#editAccountModal').modal('toggle');
    },
    
    showResetPasswordFrm: function (event) {
    	event.preventDefault();
    	$('#resetPasswordModal').modal('toggle');
    },
    
    saveAccount: function event (event) {
    	event.preventDefault();
    	var account = this.account.get(localStorage.getItem('accountId'));
    	$("#editAccountModal").modal('toggle');
    	$('#editAccountModal').on('hidden.bs.modal', function (e) {
    		account.save({
	    		account_name: $("#register_account_name").val(),
	    		account_email: $("#register_account_email").val(),
	    		account_id: localStorage.getItem('accountId'),
	    	} ,{wait:true,
				success:function(account, response, options) {
					localStorage.setItem('accountName', $("#register_account_name").val());
	                localStorage.setItem('accountEmail', $("#register_account_email").val());
	                $("#flashMessenger").html('<div class="alert alert-success">Account was updated.</div>');
				},
				error: function (model, response, options) {
					 $("#flashMessenger").html('<div class="alert alert-danger">'+response+'</div>');
				}
	    	});
    	});
    }
    
  });
  return AccountPage;
});
