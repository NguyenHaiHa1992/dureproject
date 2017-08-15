angular.module('app').controller('PartCategoryCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.part_category= {};
	$scope.part_category_error= {
							'id': [],
							'name': [],
							'status': [],
							'created_time': [],
						};
	
	$scope.createInit= function(){
		$http.post(BASE_URL + '/partCategory/createInit', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.part_category= data.part_category;
				$scope.part_category_error= data.part_category_error;
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
		var information_post= $scope.part_category;
		$http.post(BASE_URL + '/partCategory/create', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$state.go('list-part-category');
		    }
		    else{
		    	$scope.part_category_error= data.part_category_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
}]);