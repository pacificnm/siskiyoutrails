define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'collections/attributeGroupItems',
  'text!templates/attribute/attributeGroupItem.html',
], function($, _, Backbone, Vm, AttributeGroupItemCollection, AttributeGroupItemTpl){
  var AttributeGroupItemView = Backbone.View.extend({
    
    
    initialize: function (options) {
    	this.options = options || {};
    	
    	this.attributeGroupItems = new AttributeGroupItemCollection(this.options);
    	this.listenTo(this.attributeGroupItems, 'add', this.render);
	    this.listenTo(this.attributeGroupItems, 'change', this.render);
	    this.listenTo(this.attributeGroupItems, 'remove', this.render);
    	
    	_.bindAll(this, 'render');
    },
    
    
    
    render: function () {
    	
    	var compiledTemplate = _.template(AttributeGroupItemTpl, {attributeGroupItems: this.attributeGroupItems});
		$("#"+this.options.section).html(compiledTemplate);
		return this;
    },
    
  });

  return AttributeGroupItemView;
});
    