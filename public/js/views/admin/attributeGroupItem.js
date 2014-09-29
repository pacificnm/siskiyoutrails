define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'collections/attributeGroupItems',
  'views/admin/attributeTypeSelect',
  'text!templates/admin/attributeGroupItem.html',
], function($, _, Backbone, Vm, AttributeGroupItemCollection, AttributeTypeSelectView, AttributeGroupItemTpl){
  var AttributeGroupItemView = Backbone.View.extend({
    el: '#adminSection',
    
    initialize: function (options) {
    	this.options = options || {};
    	
    	this.attributeGroupItems = new AttributeGroupItemCollection(this.options);
    	this.listenTo(this.attributeGroupItems, 'add', this.render);
	    this.listenTo(this.attributeGroupItems, 'change', this.render);
	    this.listenTo(this.attributeGroupItems, 'remove', this.render);
    	
    	_.bindAll(this, 'render');
    },
    
    events: {
    	'click #addAttributeGroupItemBtn': 'showAddAttributeItemFrm',
    	'click #saveAttributeGroupItemBtn': 'saveAttributeGroupItem'
    },
    
    showAddAttributeItemFrm: function (event) {
    	event.preventDefault();
    	Vm.create(this, 'AttributeTypeSelectView', AttributeTypeSelectView);
    	$('#attributeGroupItemFrm').trigger("reset");
    	$('#addAttributeGroupItemModal').modal('toggle');
    },
    
    saveAttributeGroupItem: function (event) {
    	event.preventDefault();
    	var that = this;
    	$('#addAttributeGroupItemModal').modal('toggle');
    	$('#addAttributeGroupItemModal').on('hidden.bs.modal', function (e) {
    		
    		that.attributeGroupItems.create({
    			attribute_group_id:that.options.attribute_group_id,
    			attribute_type_id: $("#attribute_type_id").val()
    			},{wait:true,
			    success:function(model, response, options) {
			    	$("#flashMessenger").html('<div class="alert alert-success">The attribute group was created</div>');
			    },
			    error: function (model, response, options) {
			    	$("#flashMessenger").html('<div class="alert alert-danger">There was an error saving the attribute group</div>');
			    }
    			
    		});
    		
    	});
    },
    
    render: function () {
    	
    	var compiledTemplate = _.template(AttributeGroupItemTpl, {attributeGroupItems: this.attributeGroupItems, attributeGroupName:this.options.attributeGroupName});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return AttributeGroupItemView;
});
    