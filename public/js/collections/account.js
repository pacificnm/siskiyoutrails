define([
	"backbone", 
	"models/account"
], function(Backbone, AccountModel) {
	
	var accountCollection = Backbone.Collection.extend({
		
		model: AccountModel,
		
		
		// init
		initialize: function (options) {
			this.options = options || {};
						
			this.fetch({data: options, success: this.fetchSuccess,error: this.fetchError});
			
			this.on("add", function(AccountModel) {});
			
			this.on("remove", function(AccountModel) {});
			
			this.on("reset", function(AccountModel) {});
		},
				
		parse : function(response) {
			
			if(response) {
				if (_.isObject(response.data)) {
					return response.data;
				} else {
					return response;
				}
			}
		},

		fetchSuccess: function(collection, response, options) {
			//options.xhr.getResponseHeader('header_name');
			
		}, 
		
		fetchError: function (collection, response, options) {
			var status = options.xhr.status;
			var statusText = options.xhr.statusText;
			
	    },
		
		
		url : function() {
			return "account/index/get";
		},
	});
	return accountCollection;
});