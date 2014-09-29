define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'collections/attributeGroups',
  'views/admin/attributeGroupItem',
  'text!templates/admin/attributeGroup.html',
], function($, _, Backbone, Vm, AttributeGroupCollection,AttributeGroupItemView, AttributeGroupTpl){
  var AttributeGroupView = Backbone.View.extend({
    el: '#adminSection',
    
    initialize: function (options) {
    	this.options = options || {};
    	
    	this.attributeGroups = new AttributeGroupCollection(this.options);
    	this.listenTo(this.attributeGroups, 'add', this.render);
	    this.listenTo(this.attributeGroups, 'change', this.render);
	    this.listenTo(this.attributeGroups, 'remove', this.render);
    	
    	_.bindAll(this, 'render');
    },
    events: {
    	'click #addAttributeGroupBtn': 'openAdminAddAttributeGroup',
    	'click #saveAttributeGroupBtn': 'saveAttributeGroup',
    	'click #showAttributeGroupItems': 'showAttributeGroupItems'
    },
    
    openAdminAddAttributeGroup: function (event) {
    	event.preventDefault();
    	$('#attributeGroupFrm').trigger("reset");
    	$('#addAttributeGroupModal').modal('toggle');
    },
    
    saveAttributeGroup: function (event) {
    	event.preventDefault();
    	var that = this;
    	console.log('save')
    	$('#addAttributeGroupModal').modal('toggle');
    	$('#addAttributeGroupModal').on('hidden.bs.modal', function (e) {
    		var attributeGroupId = $("#frm_attribute_group_id").val(); 
    		if(attributeGroupId > 0 ) {
    			var model = that.attributeGroups.get(attributeGroupId);
    			model.save({
    				attribute_group_id: attributeGroupId,
    				attribute_group_name: $("#attribute_group_name").val(),
    				collection_type: $("#collection_type").val()
    			},{wait:true,
    			    success:function(model, response, options) {
    			    	$("#flashMessenger").html('<div class="alert alert-success">The attribute group was created</div>');
    			    },
    			    error: function (model, response, options) {
    			    	$("#flashMessenger").html('<div class="alert alert-danger">There was an error saving the attribute group</div>');
    			    }
    			});
    		} else {
    			that.attributeGroups.create({
    				attribute_group_name: $("#attribute_group_name").val(),
    				collection_type: $("#collection_type").val()
    			},{wait:true,
    			    success:function(model, response, options) {
    			    	$("#flashMessenger").html('<div class="alert alert-success">The attribute group was created</div>');
    			    },
    			    error: function (model, response, options) {
    			    	$("#flashMessenger").html('<div class="alert alert-danger">There was an error saving the attribute group</div>');
    			    }
    			});
    		}
    	});
    },
    
    showAttributeGroupItems: function (event) {
    	event.preventDefault();
    	
    	var selectedItem = $(event.currentTarget);
		var attributeGroupId = selectedItem.data('id');
		model = this.attributeGroups.get(attributeGroupId);
		$("#adminPageHeader").html('Admin Attribute Group Items ' + model.get('attribute_group_name'));
    	document.title = 'Admin: Attribute Group Items ' + model.get('attribute_group_name');
    	
    	Vm.create(this, 'AttributeGroupItemView', AttributeGroupItemView, {attribute_group_id:attributeGroupId,attributeGroupName:model.get('attribute_group_name')}); 
		
    },
    
    render: function () {
    	
    	var compiledTemplate = _.template(AttributeGroupTpl, {attributeGroups: this.attributeGroups});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return AttributeGroupView;
});