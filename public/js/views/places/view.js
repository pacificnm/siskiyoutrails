define([
  'jquery',
  'lodash',
  'backbone',
  'events',
  'text!templates/places/view.html',
  'text!templates/places/slider.html',
  'text!templates/places/tabs.html',
], function($, _, Backbone, Events, ViewPlaceTpl, PlaceliderTpl, PlaceTabTpl	){
  var ViewPlaceView = Backbone.View.extend({
    el: '#main',
    intialize: function () {

    },
    
    events: {
    	
    },
    
    render: function () {
    	var compiledTemplate = _.template(ViewPlaceTpl, {sliderTpl:PlaceliderTpl, tabs:PlaceTabTpl});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return ViewPlaceView;
});