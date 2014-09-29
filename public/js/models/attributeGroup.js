define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var AttributeGropupModel = Backbone.Model.extend({
	idAttribute: "attribute_group_id",
	
	defaults: {
		attribute_group_name: '',
		collection_type: '',
		attribute_group_create: '',
		attribute_group_create_by: ''
	},

    initialize: function(){
    	this.on("change", function (AttributeGropupModel) {});		
		this.on("add", function(AttributeGropupModel) {});		
		this.on("remove", function(AttributeGropupModel) {});		
		this.on("reset", function(AttributeGropupModel) {});
    },
    
    url : function() {
		return  "/attributegroup/index/"; 
	}

  });
  return AttributeGropupModel;
});