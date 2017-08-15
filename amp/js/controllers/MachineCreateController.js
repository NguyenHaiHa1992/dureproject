angular.module('app').controller('MachineCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.machine= {};
	$scope.machine_error= {
							'id': [],
							'name': [],
							'status': [],
							'created_time': [],
						};
	
	$scope.createInit= function(){
		$http.post(BASE_URL + '/machine/createInit', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.machine= data.machine;
				$scope.machine_error= data.machine_error;
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
		var information_post= $scope.machine;
		$http.post(BASE_URL + '/machine/create', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$state.go('list-machine');
		    }
		    else{
		    	$scope.machine_error= data.machine_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
}]);