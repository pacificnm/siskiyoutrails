define([
  'jquery',
  'lodash',
  'backbone',
  'models/attributeType',
  'collections/attributeTypes',
  'text!templates/admin/attributeType.html',
], function($, _, Backbone, AttributeTypeModel, AttributeTypeCollection, AttributeTypeTpl){
  var AdminView = Backbone.View.extend({
    el: '#adminSection',
    intialize: function () {
    	_.bindAll(this, 'render');
    	this.attributeTypes = new AttributeTypeCollection();
    	this.listenTo(this.attributeTypes, 'add', this.render);
	    this.listenTo(this.attributeTypes, 'change', this.render);
	    this.listenTo(this.attributeTypes, 'remove', this.render);
    },
    
    events: {
    	'click #addAttributeTypeBtn': 'showAddAttributeTypeFrm',
    	'click #editAttributeTypeBtn': 'showEditAttributeTypeFrm',
    	'click #saveAttributeTypeBtn': 'saveAttributeType'
    },
    
    showAddAttributeTypeFrm: function (event) {
    	event.preventDefault();
    	$('#attributeTypeFrm').trigger("reset");
    	$('#addAttributeTypeModal').modal('toggle');
    },

    showEditAttributeTypeFrm: function (event) {
    	event.preventDefault();
    	var selectedItem = $(event.currentTarget);
		attributeTypeId = selectedItem.data('id');
		var model = this.attributeTypes.get(attributeTypeId);
		$("#attribute_type_value").val(model.get('attribute_type_value'));
		$("#frm_attribute_type_id").val(model.get('attribute_type_id'));
    	$('#addAttributeTypeModal').modal('toggle');
    },
    
    saveAttributeType: function (event) {
    	var that = this;
    	event.preventDefault();
    	$('#addAttributeTypeModal').modal('toggle');
    	$('#addAttributeTypeModal').on('hidden.bs.modal', function (e) {	
    		var attributeTypeId = $("#frm_attribute_type_id").val(); 
    		
    		if(attributeTypeId > 0 ) {
    			var model = that.attributeTypes.get(attributeTypeId);
    			model.save({
    				attribute_type_id:attributeTypeId,
    				attribute_type_value: $("#attribute_type_value").val()
    		    }, {wait:true,
					success:function(model, response, options) {
						$('#attributeTypeFrm').trigger("reset");
						$("#flashMessenger").html('<div class="alert alert-success">The attribute type was updated</div>');
					},
					error: function (model, response, options) {
						$("#flashMessenger").html('<div class="alert alert-danger">There was an error saving the attribute type</div>');
					}
    		    });
    		} else {
	    		that.attributeTypes.create({
	    			attribute_type_value: $("#attribute_type_value").val()
	    		    } ,{wait:true,
	    			    success:function(model, response, options) {
	    			    	$("#flashMessenger").html('<div class="alert alert-success">The attribute type was created</div>');
	    			},
	    			    error: function (model, response, options) {
	    			    	$("#flashMessenger").html('<div class="alert alert-danger">There was an error saving the attribute type</div>');
	    			}
	     	     });
    		 }
    	});
    },
    
    render: function () {
    	
    	var compiledTemplate = _.template(AttributeTypeTpl, {attributeType:this.attributeTypes});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return AdminView;
});
