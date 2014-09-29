define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'events',
  'collections/account',
  'views/admin/attributeType',
  'views/admin/account',
  'views/admin/upload',
  'views/admin/forest',
  'views/admin/attributeGroup',
  'text!templates/admin/page.html',
], function($, _, Backbone, Vm, Events, AccountCollection, AttributeTypeView, 
		AccountView, UploadView, ForestView, AttributeGroupView, AdminTpl){
  var AdminView = Backbone.View.extend({
    el: '#main',
    intialize: function () {
    	this.account = new AccountCollection({account_email:localStorage.getItem('accountEmail'),account_token:localStorage.getItem('accountToken') });
    	
    },
    
    events: {
    	'click #adminHomeBtn': 'openAdminHome',
    	'click #adminAclBtn': 'openAdminAcl',
    	'click #adminAttributesBtn': 'openAdminAttributes',
    	'click #adminAccountsBtn': 'openAccounts',
    	'click #adminUploadBtn': 'openUploadFile',
    	'click #adminForestBtn': 'openForest',
    	'click #adminAttributeGroupsBtn': 'openAdminAttributeGroups',
    	
    		
    		
    },
    
    openAdminHome: function (event) {
    	event.preventDefault();
    	var selectedItem = $(event.currentTarget);
    	$("#adminNavs li").removeClass('active');
		$("#adminPageHeader").html('Admin Home');
		document.title = 'Admin: Home';
		selectedItem.parent('li').addClass("active");
		$("#adminSection").html("");
    },
    
    openAdminAcl: function (event) {
    	event.preventDefault();
    	var selectedItem = $(event.currentTarget);
    	$("#adminNavs li").removeClass('active');
    	$("#adminPageHeader").html('Admin ACLs');
    	document.title = 'Admin: ACLs';
 	    selectedItem.parent('li').addClass("active");
 	   $("#adminSection").html("");
    },
    
    openAdminAttributes: function (event) {
    	var selectedItem = $(event.currentTarget);
    	event.preventDefault();
    	$("#adminNavs li").removeClass('active');
    	$("#adminPageHeader").html('Admin Attribute Types');
    	document.title = 'Admin: Attribute Types';
    	selectedItem.parent('li').addClass("active");
    	$("#adminSection").html("");
    	Vm.create(this, 'AttributeTypeView', AttributeTypeView).intialize(); 
    },
    
    openAdminAttributeGroups: function (event) {
    	var selectedItem = $(event.currentTarget);
    	event.preventDefault();
    	$("#adminNavs li").removeClass('active');
    	$("#adminPageHeader").html('Admin Attribute Groups');
    	document.title = 'Admin: Attribute Groups';
    	selectedItem.parent('li').addClass("active");
    	$("#adminSection").html("");
    	Vm.create(this, 'AttributeTypeView', AttributeGroupView);
    },
    
    
    openAccounts: function (event) {
    	var selectedItem = $(event.currentTarget);
    	event.preventDefault();
    	$("#adminNavs li").removeClass('active');
    	$("#adminPageHeader").html('Admin Accounts');
    	document.title = 'Admin: Accounts';
    	selectedItem.parent('li').addClass("active");
    	$("#adminSection").html("");
    	Vm.create(this, 'AccountView', AccountView).intialize(); 
    },
    
    openUploadFile: function (event) {
    	var selectedItem = $(event.currentTarget);
    	event.preventDefault();
    	$("#adminNavs li").removeClass('active');
    	$("#adminPageHeader").html('Admin Upload File');
    	selectedItem.parent('li').addClass("active");
    	document.title = 'Admin: Upload File';
    	$("#adminSection").html("");
    	Vm.create(this, 'UploadView', UploadView).render(); 
    },
    
    openForest: function (event) {
    	var selectedItem = $(event.currentTarget);
    	event.preventDefault();
    	$("#adminNavs li").removeClass('active');
    	$("#adminPageHeader").html('Admin Forests');
    	selectedItem.parent('li').addClass("active");
    	document.title = 'Admin: Forests';
    	$("#adminSection").html("");
    	Vm.create(this, 'AdminForestView', ForestView).render(); 
    },
    
    render: function () {
    	if(localStorage.getItem('accountAdmin') != 1) {
    		window.location.replace('/#denied');
    	}
    	var compiledTemplate = _.template(AdminTpl);
		$(this.el).html(compiledTemplate);
		
		document.title = 'Admin: Home';
		
		return this;
    },
    
  });

  return AdminView;
});
