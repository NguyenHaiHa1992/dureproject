angular.module('app').controller('MaterialTrackingController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.material_rows= [];
	$scope.materials = [];
	$scope.material_number_warning = 0;
	$scope.material_categories = [];
	$scope.search_material = {material_code :'', category_id : 0};

	$scope.init= function(){
		$http.post(BASE_URL + '/materialCategory/getAll', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.material_categories = data.material_categories;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.init();

	$scope.getMaterials= function(){
		var post_information = $scope.search_material;
		$http.post(BASE_URL + '/material/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.materials = data.materials;

		    	$.each(data.materials, function(key, material){
		    		if(material.is_enough_inventory == "false"){
		    			$scope.material_number_warning += 1;
		    		}
		    	});
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getMaterials();

	$scope.materialClick= function(material_id){
		
	};
	
	$scope.viewPart= function(part_id){
		$state.go('detail-part', {id:part_id});
	};

	$scope.search = function(){
		$scope.getMaterials();
	}

	// View part
	$scope.view_material = {};

	$scope.viewDetail = function(material){
		$scope.view_material = angular.copy(material);
		$('#materialViewModal').modal('show');
	};
}]);