define([
  'jquery',
  'lodash',
  'backbone',
  'events',
  'text!templates/places/page.html',
  'text!templates/places/filter.html',
  'text!templates/places/list.html',
], function($, _, Backbone, Events, PlaceTpl, PlaceFilterTpl, PlaceListTpl	){
  var PlaceView = Backbone.View.extend({
    el: '#main',
    intialize: function () {

    },
    
    events: {
    	
    },
    
    render: function () {
    	var compiledTemplate = _.template(PlaceTpl, {filterPlaceTpl: PlaceFilterTpl, listPlaceTpl:PlaceListTpl});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return PlaceView;
});
