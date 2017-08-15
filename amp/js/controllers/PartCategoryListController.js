angular.module('app').controller('PartCategoryListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$sce',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $sce){
	$scope.part_category_rows= [];
	$scope.part_rows= [];
	$scope.part_categories = [];
	$scope.part_category_number_warning = 0;

	$scope.getPartCategories= function(){
		$http.post(BASE_URL + '/partCategory/getAll', {})
	    .success(function(data) {
		    if(data.success) {
		    	var part_category_number = 0;
		    	var tmp_part_category_row= [];
		    	$scope.part_categories = data.part_categories;
		    	$.each(data.part_categories, function(key, part_category){
		    		if(part_category.is_enough_inventory == "false"){
						$scope.part_category_number_warning += 1;
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
	$scope.getPartCategories();

	$scope.part_category = [];
	$scope.part_number_warning = 0;
	$scope.partCategoryClick = function($event, part_category_id){
		var current = $event.currentTarget;
		var parent = jQuery(current).parent().parent();
		jQuery('.btn', jQuery(parent)).removeClass('selected');
		current.className += " selected";

		$scope.selected_part_category = current.innerText ;
		$http.post(BASE_URL + '/part/getPartsByCategoryId', {id: part_category_id})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.part_category = data.parts;
		    	$.each(data.parts, function(key, part){
		    		if(part.is_enough_inventory == "false"){
						$scope.part_number_warning += 1;
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

	// View part
	$scope.view_part= {};

	$scope.viewDetail = function(part){
		$scope.view_part = angular.copy(part);
		$('#partViewModal').modal('show');
	};

	$scope.renderHtml = function (htmlCode) {
		return $sce.trustAsHtml(htmlCode);
	};
}]);