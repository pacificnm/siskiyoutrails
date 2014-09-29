define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var accountModel = Backbone.Model.extend({
	idAttribute: "account_id",
	
	defaults: {
	      account_name: 'Guest',
	      account_email: '',
	      account_password: '',
	      account_token: '',
	      account_create: '',
	      account_admin: 0
	},
   
    
    initialize: function(){
    	this.on("change", function (accountModel) {});		
		this.on("add", function(accountModel) {});		
		this.on("remove", function(accountModel) {});		
		this.on("reset", function(accountModel) {});
    },
    
    url : function() {
		return  "/account/index/"; 
	}

  });
  return accountModel;
});