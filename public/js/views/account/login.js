define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'views/header/menu',
  'text!templates/account/login.html'
], function($, _, Backbone, Vm, MenuView, LoginTemplate){
  var LoginPage = Backbone.View.extend({
    el: '#main',
    
    initialize: function (options) {
    	console.log('Initializing Login View');
    	
    },
    
    render: function () {
    	$(this.el).html(LoginTemplate);
    	return this;
    },
    
    login: function (event) {
    	event.preventDefault();
    	var accountEmail = $("#account_email").val();
    	var accountPassword = $("#account_password").val();
    	var url = 'account/index/get';
    	var formValues = {
                account_email: accountEmail,
                account_password: accountPassword
        };
    	
    	$.ajax({
            url:url,
            type:'GET',
            dataType:"json",
            data: formValues,
            success:function (data) {
            	var accountData = data.data;
                localStorage.setItem('accountId', accountData.account_id);
                localStorage.setItem('accountName', accountData.account_name);
                localStorage.setItem('accountEmail', accountData.account_email);
                localStorage.setItem('accountToken', accountData.account_token);
                localStorage.setItem('accountAdmin', accountData.account_admin);
                $("#flashMessenger").html('');
                
                Vm.create(this, 'MenuView', MenuView).render(); 
                
                window.location.replace('/#account');
            },
            error: function (data,  response, options) {
            	console.log('login fail');
            	$("#flashMessenger").html('<div class="alert alert-danger" role="alert">'+options+'</div>');
                
            }
        });
    },
    
    showRegisterFrm: function (event) {
    	event.preventDefault();
    	$("#registerModal").modal('toggle');
    },
    
    saveAccount: function (event) {
    	event.preventDefault();
    	var account = new Account();
    	$("#registerModal").modal('toggle');
    	$('#registerModal').on('hidden.bs.modal', function (e) {
	    	account.save({
	    		account_name: $("#register_account_name").val(),
	    		account_password: $("#register_account_password").val(),
	    		account_email: $("#register_account_email").val(),
	    	} ,{wait:true,
				success:function(account, response, options) {
					
					var accountData = response.data;
					localStorage.setItem('accountId', accountData.account_id);
	                localStorage.setItem('accountName', accountData.account_name);
	                localStorage.setItem('accountEmail', accountData.account_email);
	                localStorage.setItem('accountToken', accountData.account_token);
	                window.location.replace('/#account');
	                
				},
				error: function (model, response, options) {
					 $("#flashMessenger").html('<div class="alert alert-danger">'+response+'</div>');
				}
	    	});
    	});
    },
    
    events: {
    	'click #loginBtn': 'login',
    	'click #registerBtn': 'showRegisterFrm',
    	'click #saveRegisterBtn': 'saveAccount'
    },
    
  
  });
  return LoginPage;
});
