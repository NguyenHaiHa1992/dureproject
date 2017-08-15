angular.module('app').controller('UserListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.users= [];
	$scope.itemsByPage= 10;
	$scope.itemsByPages= [
							{
								value: 10,
								name: 10
							},
							{
								value: 20,
								name: 20
							},
							{
								value: 30,
								name: 30
							},
						];
	$scope.pages= [];
	$scope.currentPage= 1;
	$scope.start_user= 1;
	$scope.end_user= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};
	$scope.search_user= {
						id: '',
						name: '',
						email: '',
						created: '',
					};
	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};
					
	$scope.getUsers= function(post_information){
		$http.post(BASE_URL + '/user/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_user= data.start_user;
				$scope.end_user= data.end_user;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.users= [];
		    	$scope.users= data.users;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getUsers(post_information);
	
	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_user.id,
								'name': $scope.search_user.name,
								'email': $scope.search_user.email,
								'created': $scope.search_user.created,
							};
		$scope.getUsers(post_information);
	};
	
	$scope.itemsByPage_change_number= 0;
	$scope.$watch('itemsByPage', function(){
		$scope.itemsByPage_change_number++;
		if($scope.itemsByPage== 0 || $scope.itemsByPage== '0' || $scope.itemsByPage== '' || $scope.itemsByPage== null)
			$scope.itemsByPage= 1;
		var post_information= {
								'limitstart': 0,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_user.id,
								'name': $scope.search_user.name,
								'email': $scope.search_user.email,
								'created': $scope.search_user.created,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getUsers(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_user.id,
								'name': $scope.search_user.name,
								'email': $scope.search_user.email,
								'created': $scope.search_user.created,
							};
		if($scope.search_change_number>1)
			$scope.getUsers(post_information);
	}, true);
	
	$scope.sort= function(sort_attribute){
		if($scope.sort.attribute== sort_attribute)
			if($scope.sort.type== 'DESC')
				$scope.sort.type= 'ASC';
			else
				$scope.sort.type= 'DESC';
		else{
			$scope.sort.attribute= sort_attribute;
			$scope.sort.type= 'DESC';
		}
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_user.id,
								'name': $scope.search_user.name,
								'email': $scope.search_user.email,
								'created': $scope.search_user.created,
							};
		$scope.getUsers(post_information);
	};

	$scope.search = function(){
		post_information.name = $scope.search_user.name;
		post_information.email = $scope.search_user.email;

		$scope.getUsers(post_information);
	}

	$scope.list_role = [];
	$scope.getRoles = function(){
		$http.post(BASE_URL + '/user/getListRole', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.list_role = data.list_role;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getRoles();

	$scope.changeStatus = function(user){
		if(user.status == 1){
			sweetAlert({
				title: "Are you sure?",
		      	text: "Do you want to disable this user? This user will not able to login to system until be re-enabled",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, disable this user!",
		      	closeOnConfirm: true,
		      	html: true
		    },
		    function(){
				$http.post(BASE_URL + '/user/changeStatus', {'user_id': user.id})
			    .success(function(data) {
				    if(data.success) {
				    	user.status = 0;
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
		else{
			sweetAlert({
				title: "Are you sure?",
		      	text: "Do you want to enable this user? This user will able to login to system.",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, enable this user!",
		      	closeOnConfirm: true,
		      	html: true
		    },
		    function(){
				$http.post(BASE_URL + '/user/changeStatus', {'user_id': user.id})
			    .success(function(data) {
				    if(data.success) {
				    	user.status = 1;
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
	}

	// Create and update user
	$scope.edit_user= {};
	$scope.edit_user_error= {
							'id': [],
							'name': [],
							'username': [],
							'email': [],
							'role': [],
							'status': [],
							'clear_password': [],
						};

	$scope.edit_user.is_update = false;
	$scope.viewDetail = function(user){
		$scope.edit_user = angular.copy(user);
		$scope.edit_user.is_update = true;
		$('#userEditModal').modal('show');
	};

	$scope.showResetPasswordModal = function(user){
		$scope.edit_user = angular.copy(user);
		$('#userResetPasswordModal').modal('show');
	};

	$scope.generatePassword = function(user){
		var randomstring = Math.random().toString(36).slice(-10);
		user.password = randomstring;
	};

	$scope.createUser = function(){
		$scope.edit_user = {};
		$scope.edit_user_error = {
							'id': [],
							'name': [],
							'username': [],
							'email': [],
							'role': [],
							'status': [],
							'clear_password': [],
						};
		$scope.edit_user.is_update = false;
		$('input, select').removeClass('ng-dirty');
		$('#userEditModal').modal('show');
	};

	$scope.editUser = function(user){
		var information_post = user;
		$http.post(BASE_URL + '/user/edit', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.getUsers(post_information);
		    	swal(data.message, "", "success");
		    	$('#userEditModal').modal('hide');
				$scope.edit_user_error= {
									'id': [],
									'name': [],
									'username': [],
									'email': [],
									'role': [],
									'status': [],
									'clear_password': [],
								};
		    }
		    else{
		    	$scope.edit_user_error= data.user_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.resetPasswordUser = function(user){
		if(user.password != undefined && user.password != ''){
			var information_post = user;
			$http.post(BASE_URL + '/user/resetPassword', information_post)
		    .success(function(data) {
			    if(data.success) {
			    	user.password = '';
			    	$scope.getUsers(post_information);
			    	swal('Password has been reset!', "", "success");
			    	$('#userResetPasswordModal').modal('hide');
					$scope.edit_user_error= {
										'id': [],
										'name': [],
										'username': [],
										'email': [],
										'role': [],
										'status': [],
										'clear_password': [],
									};
			    }
			    else{
			    	$scope.edit_user_error= data.user_error;
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});
	  	}
	  	else{
	  		swal('Password can not be empty!', "", "error");
	  	}
	};
}]);