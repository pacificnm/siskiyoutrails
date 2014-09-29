define([
  'jquery',
  'lodash',
  'backbone',
  'collections/attributeTypes',
  'text!templates/admin/attributeTypeSelect.html',
], function($, _, Backbone, AttributeTypeCollection, AttributeTypeTpl){
  var AdminView = Backbone.View.extend({
    el: '#attributeTypeSelect',
    initialize: function () {
    	_.bindAll(this, 'render');
    	this.attributeTypes = new AttributeTypeCollection();
    	this.listenTo(this.attributeTypes, 'add', this.render);
	    this.listenTo(this.attributeTypes, 'change', this.render);
	    this.listenTo(this.attributeTypes, 'remove', this.render);
    },
    
    
    
    render: function () {
    	console.log('render')
    	var compiledTemplate = _.template(AttributeTypeTpl, {attributeType:this.attributeTypes});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return AdminView;
});
