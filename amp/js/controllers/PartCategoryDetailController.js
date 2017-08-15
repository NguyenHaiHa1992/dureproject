angular.module('app').controller('PartCategoryDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$stateParams', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams){
	$scope.part_category= {};
	$scope.part_category_error= {
							'id': [],
							'name': [],
							'status': [],
							'created_time': [],
						};
	
	$scope.getPartCategoryById= function(){
		$http.post(BASE_URL + '/partCategory/getPartCategoryById', {id: $stateParams.id})
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
	$scope.getPartCategoryById();
	
	
	
	$scope.update= function(){
		
		var information_post= $scope.part_category;
		$http.post(BASE_URL + '/partCategory/update', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.part_category= data.part_category;
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