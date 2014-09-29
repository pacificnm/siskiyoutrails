define([
	"backbone", 
	"models/attributeGroup"
], function(Backbone, AttributeGroupModel) {	
	var AttributeGroupCollection = Backbone.Collection.extend({	
		model: AttributeGroupModel,
		// init
		initialize: function (options) {
			this.options = options || {};		
			this.fetch({data: options, success: this.fetchSuccess,error: this.fetchError});			
			this.on("add", function(model) {});			
			this.on("remove", function(model) {});			
			this.on("reset", function(model) {});
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
			options.xhr.getResponseHeader('header_name');	
		}, 		
		fetchError: function (collection, response, options) {
			 status = options.xhr.status;
			 statusText = options.xhr.statusText;
	    },
		url : function() {
			return "/attributegroup/index";
		},
	});
	return AttributeGroupCollection;
});