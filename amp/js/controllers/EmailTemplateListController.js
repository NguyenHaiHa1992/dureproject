angular.module('app').controller('EmailTemplateListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies', '$sce',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies, $sce){
	// Setting EmailTemplate
	$scope.getEmailTemplates= function(){
		$http.post(BASE_URL + '/emailTemplate/getAll', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.email_templates = data.email_templates;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getEmailTemplates();


	// Edit EmailTemplate
	$scope.editEmailTemplate = function(email_template){
		email_template.is_edit = true;
		$scope.edit_email = angular.copy(email_template);
	};

	// Cancel Edit EmailTemplate
	$scope.cancelEditEmailTemplate = function(email_template){
		email_template.is_edit = false;
		email_template.subject = $scope.edit_email.subject;
		email_template.content = $scope.edit_email.content;
	};

	$scope.removeEmailTemplate = function(email_template, index){
		if(email_template.id == undefined){
			$scope.email_templates.splice(index, 1);
		}
		else{
		    sweetAlert({
				title: "Are you sure?",
		      	text: "You will not be able to recover it!",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, delete it!",
		      	closeOnConfirm: false,
		      	html: true
		    },
		    function(){
				var information_post = email_template;
				$http.post(BASE_URL + '/emailTemplate/removeEmailTemplate', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.email_templates.splice(index, 1);
		                email_template.is_edit = false;
				    }
				    else{
				    	swal({
				    		title: '',
				    		text: data.message,
				    		type: 'error',
				    		html: true
				    	});
				    }
				})
				.error(function(data, status, headers, config) {
		    		$state.go('404');	
		  		});
		    });
		}
	};

	$scope.saveEmailTemplate = function(email_template, $index){
		var information_post = email_template;
		$http.post(BASE_URL + '/emailTemplate/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	email_template.is_edit = false;
               	email_template.id = data.id;
               	$scope.email_templates[$index] = data.email_template;

		    	swal('Template update!', "", "success");
		    }
		    else{
		    	swal({
		    		title: '',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.renderHtml = function (htmlCode) {
		return $sce.trustAsHtml(htmlCode);
	};

	// Jquery
	jQuery("[data-widget='collapse']").click(function() {
	    //Find the box parent........
	    var box = jQuery(this).parents(".box").first();
	    //Find the body and the footer
	    var bf = box.find(".box-body, .box-footer");
	    if (!jQuery(this).children().hasClass("fa-plus")) {
	        jQuery(this).children(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
	        bf.slideUp();
	    } else {
	        //Convert plus into minus
	        jQuery(this).children(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
	        bf.slideDown();
	    }
	});
}]);