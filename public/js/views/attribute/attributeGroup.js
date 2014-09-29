define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'collections/attributeGroups',
  'text!templates/attribute/attributeGroup.html',
], function($, _, Backbone, Vm, AttributeGroupCollection, AttributeGroupTpl){
  var AttributeGroupView = Backbone.View.extend({
    el: '#attributeGroupSection',
    
    initialize: function (options) {
    	this.options = options || {};
    	
    	this.attributeGroups = new AttributeGroupCollection(this.options);
    	this.listenTo(this.attributeGroups, 'add', this.render);
	    this.listenTo(this.attributeGroups, 'change', this.render);
	    this.listenTo(this.attributeGroups, 'remove', this.render);
    	
    	_.bindAll(this, 'render');
    },
   
    render: function () {
    	
    	var compiledTemplate = _.template(AttributeGroupTpl, {attributeGroups: this.attributeGroups});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return AttributeGroupView;
});