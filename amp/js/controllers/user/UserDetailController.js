angular.module('app').controller('UserDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$stateParams', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams){
	$scope.user= {};
	$scope.user_error= {
							'id': [],
							'name': [],
							'status': [],
							'created_time': [],
						};
	
	$scope.getUserById= function(){
		$http.post(BASE_URL + '/user/getUserById', {id: $stateParams.id})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.user= data.user;
				$scope.user_error= data.user_error;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.getUserById();
	
	$scope.updateProfile = function(){
		$scope.user.password = '';
		$scope.user.confirm_password = '';
		var information_post= $scope.user;
		$http.post(BASE_URL + '/user/updateProfile', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.user= data.user;
		    	$scope.user_error= data.user_error;
		    	$('input, select').removeClass('ng-dirty');
				swal("User profile updated!", "", "success");

				// Update rootScope
				$rootScope.user_name = data.user.name;
		    }
		    else{
		    	$scope.user_error= data.user_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.changePassword = function(){
		var information_post= $scope.user;
		$http.post(BASE_URL + '/user/changePassword', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.user= data.user;
		    	$scope.user_error= data.user_error;
		   		$scope.user.password = '';
				$scope.user.confirm_password = '';
				$('input, select').removeClass('ng-dirty');
				swal("User password changed!", "", "success");
		    }
		    else{
		    	$scope.user_error= data.user_error;
				$scope.user.password = '';
				$scope.user.confirm_password = '';
				swal("Password does not match the confirm password", "", "error");
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
}]);