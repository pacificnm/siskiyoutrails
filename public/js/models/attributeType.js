define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var AttributeTypeModel = Backbone.Model.extend({
	idAttribute: "attribute_type_id",
	
	defaults: {
		attribute_type_value: '',
	},

    initialize: function(){
    	this.on("change", function (AttributeTypeModel) {});		
		this.on("add", function(AttributeTypeModel) {});		
		this.on("remove", function(AttributeTypeModel) {});		
		this.on("reset", function(AttributeTypeModel) {});
    },
    
    url : function() {
		return  "/attributetype/index/"; 
	}

  });
  return AttributeTypeModel;
});