define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var AttributeModel = Backbone.Model.extend({
	idAttribute: "attribute_id",
	
	defaults: {
	},
   
    
    initialize: function(){
    	this.on("change", function (AttributeModel) {});		
		this.on("add", function(AttributeModel) {});		
		this.on("remove", function(AttributeModel) {});		
		this.on("reset", function(AttributeModel) {});
    },
    
    url : function() {
		return  "/attribute/index/"; 
	}

  });
  return AttributeModel;
});