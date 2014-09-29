define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var AttributeGroupItemModel = Backbone.Model.extend({
	idAttribute: "attribute_group_item_id",
	
	defaults: {
		attribute_group_id: '',
		attribute_type_id: ''
	},

    initialize: function(){
    	this.on("change", function (AttributeGroupItemModel) {});		
		this.on("add", function(AttributeGroupItemModel) {});		
		this.on("remove", function(AttributeGroupItemModel) {});		
		this.on("reset", function(AttributeGroupItemModel) {});
    },
    
    url : function() {
		return  "/attributegroupitem/index/"; 
	}

  });
  return AttributeGroupItemModel;
});