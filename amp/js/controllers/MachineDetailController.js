angular.module('app').controller('MachineDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$stateParams', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams){
	$scope.machine= {};
	$scope.machine_error= {
							'id': [],
							'name': [],
							'status': [],
							'created_time': [],
						};
	
	$scope.getMachineById= function(){
		$http.post(BASE_URL + '/machine/getMachineById', {id: $stateParams.id})
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
	$scope.getMachineById();
	
	
	
	$scope.update= function(){
		
		var information_post= $scope.machine;
		$http.post(BASE_URL + '/machine/update', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.machine= data.machine;
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