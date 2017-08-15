angular.module('app').controller('EmployeeCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.employee= {};
	$scope.employee_error= {
							'id': [],
							'name': [],
							'status': [],
							'created_time': [],
						};
	
	$scope.createInit= function(){
		$http.post(BASE_URL + '/employee/createInit', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.employee= data.employee;
				$scope.employee_error= data.employee_error;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.createInit();
	
	
	
	$scope.create= function(){
		var information_post= $scope.employee;
		$http.post(BASE_URL + '/employee/create', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$state.go('list-employee');
		    }
		    else{
		    	$scope.employee_error= data.employee_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
}]);