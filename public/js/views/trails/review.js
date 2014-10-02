define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'events',
  'collections/reviews',
  'text!templates/trails/review.html',
], function($, _, Backbone, Vm, Events,  ReviewCollection, ReviewTpl){
  var ReviewView = Backbone.View.extend({
    el: '#trailReviewsTab',
    initialize: function (options) {
    	this.options = options || {};
    	this.options.account_email = localStorage.getItem('accountEmail');
    	this.options.account_token = localStorage.getItem('accountToken');
    	this.reviews = new ReviewCollection(this.options);   	
    	this.listenTo(this.reviews, 'add', this.render);
	    this.listenTo(this.reviews, 'change', this.render);
	    this.listenTo(this.reviews, 'remove', this.render);
	    
	    _.bindAll(this, 'render');
    },
    
    events: {
    	'click #saveTrailReviewBtn': 'saveReview',
    	'click #editReviewBtn': 'showEditReview'
    },
    
    showEditReview: function (event) {
    	event.preventDefault();
    	var that = this;
    	var selectedItem = $(event.currentTarget);
    	reviewId = this.selectedItemId = selectedItem.data('id')
    	var model = that.reviews.get(reviewId);
    	$("#review_text").val(model.get('review_text'));
    	$("#review_date").val(model.get('review_date'));
    	$("#review_id").val(reviewId);
    	$('#WriteReviewModal').modal('toggle');
    },
    
    saveReview: function (event) {
    	event.preventDefault();
    	var that = this;
    	var reviewId = $("#review_id").val(); 
    	
    	
    	$('#WriteReviewModal').modal('toggle');
    	$('#WriteReviewModal').on('hidden.bs.modal', function (e) {
	    	if(reviewId > 0 ) {
	    		var model = that.reviews.get(reviewId);
	    		model.save({
	    			review_id:reviewId,
	    			account_id: localStorage.getItem('accountId'),
	    			account_email: localStorage.getItem('accountEmail'),
	    			account_token: localStorage.getItem('accountToken'),
	    			account_name: localStorage.getItem('accountName'),
	    			collection_type: 'trail',
	    			collection_id: that.options.collection_id,
	    			review_text: $("#review_text").val(),
	    			review_date: $("#review_date").val(),
	    			review_rate: $('input[name=review_rate]:checked', '#trailReviewFrm').val(),
	    		});
	    	} else {
	    		that.reviews.create({
	    			account_id: localStorage.getItem('accountId'),
	    			account_email: localStorage.getItem('accountEmail'),
	    			account_token: localStorage.getItem('accountToken'),
	    			account_name: localStorage.getItem('accountName'),
	    			collection_type: 'trail',
	    			collection_id: that.options.collection_id,
	    			review_text: $("#review_text").val(),
	    			review_date: $("#review_date").val(),
	    			review_rate: $('input[name=review_rate]:checked', '#trailReviewFrm').val(),
	    			can_edit_review:1
	    		});
	    		// hide button
	    		$("#writeTrailReview").hide();
	    	}
    	});
    	console.log('saved review');
    },
    
    
    
    render: function () {
    	var compiledTemplate = _.template(ReviewTpl, {reviews:this.reviews, trailName:this.options.trailName});
		$(this.el).html(compiledTemplate);
		
		
		return this;
    },   
  });

  return ReviewView;
});