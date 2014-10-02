define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'views/trails/list',
  'views/trails/filter',
  'text!templates/trails/page.html',
  'text!templates/trails/filter.html',
], function($, _, Backbone, Vm, TrailListView, TrailFilterView, TrailTpl, FilterTrailTpl){
  var TrailView = Backbone.View.extend({
    el: '#main',
    initialize: function (options) {
    	this.options = options || {};
	    
    },
    
    events: {
    	'change #trail_forest': 'filter',
    	'change #trail_difficulty': 'filter',
    	'click #next': 'filter',
    	'click #previous': 'filter',
    	 "keyup #trail_name":    "filter",
    	 "keypress #filterText": "onkeypress",
    	 
    		
    },
    
    onkeypress: function (event) {
        if (event.keyCode === 13) { // enter key pressed
            event.preventDefault();
        }
    },
    
    filter: function (event) {  	
    	event.preventDefault();
    	var selectedItem = $(event.currentTarget);
    	console.log(event.target.id);
    	
    	 var key = $('#trail_name').val();
    	 var forestSlug = $("#trail_forest").val();
    	 var trailDifficulty = $('input[name=trail_difficulty]:checked', '#filterTrailFrm').val();
    	 
    	 if(event.target.id === 'trail_name') {
    		 $("#previous").prop("disabled",true);
    		 $("#next").prop("disabled",false);
    		 
    	 }
    	 
    	 
    	 if(event.target.id === 'next' || event.target.id === 'previous') {
    		 var page = selectedItem.data('id');
    		// if we hit next we add
        	 if(event.target.id == 'next') {
        		 $("#previous").prop("disabled",false);
        		 $("#next").data('id', $("#next").data('id') + 1);
        		 $("#previous").data('id', $("#previous").data('id') + 1);
        		 if($("#next").data('id') > window.totalPages) {
        			 $("#next").prop("disabled",true);
        		 } else {
        			 $("#next").prop("disabled",false);
        		 }
        	 } else {
        		 if( $("#previous").data('id') < 1 ){
        			 $("#previous").prop("disabled",true);
        		 } else {
        			 $("#next").data('id', $("#next").data('id') - 1);
            		 $("#previous").data('id', $("#previous").data('id') - 1);
        		 }
        		 $("#next").prop("disabled",false);
        	 }
    	 } else {
    		 var page = 1;
    	 }
    	 
    	 Vm.create(this, 'TrailListView', TrailListView, {trail_forest:forestSlug, trail_name:key, trail_difficulty:trailDifficulty, page:page});
   
  
    	 
    },
    
    render: function (options) {
    	
    	
    	var compiledTemplate = _.template(TrailTpl);
		$(this.el).html(compiledTemplate);
		
		Vm.create(this, 'TrailListView', TrailListView);
		Vm.create(this, 'TrailFilterView', TrailFilterView);
		document.title = 'Siskiyou Trails: Browse Trails';
		
    },
    
  });

  return TrailView;
});
