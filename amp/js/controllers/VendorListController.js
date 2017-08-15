angular.module('app').controller('VendorListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.vendors= [];
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
	$scope.start_vendor= 1;
	$scope.end_vendor= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};
	$scope.search_vendor= {
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
					
	$scope.getVendors= function(post_information){
		$http.post(BASE_URL + '/vendor/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_vendor= data.start_vendor;
				$scope.end_vendor= data.end_vendor;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);
		    	//$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
		    	$scope.vendors= [];
		    	$scope.vendors= data.vendors;
		    	// for(var i= 0; i< data.vendors.length; i++)
		        	// $scope.vendors.push(data.email_templates[i]);
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getVendors(post_information);
	
	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_vendor.id,
								'name': $scope.search_vendor.name,
								'email': $scope.search_vendor.email,
								'created': $scope.search_vendor.created,
							};
		$scope.getVendors(post_information);
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
								
								'id': $scope.search_vendor.id,
								'name': $scope.search_vendor.name,
								'email': $scope.search_vendor.email,
								'created': $scope.search_vendor.created,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getVendors(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_vendor.id,
								'name': $scope.search_vendor.name,
								'email': $scope.search_vendor.email,
								'created': $scope.search_vendor.created,
							};
		if($scope.search_change_number>1)
			$scope.getVendors(post_information);
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
								
								'id': $scope.search_vendor.id,
								'name': $scope.search_vendor.name,
								'email': $scope.search_vendor.email,
								'created': $scope.search_vendor.created,
							};
		$scope.getVendors(post_information);
	};

	$scope.search = function(){
		post_information.name = $scope.search_vendor.name;
		post_information.email = $scope.search_vendor.email;

		$scope.getVendors(post_information);
	}

	$scope.viewDetai= function(vendor_id){
		$rootScope.view_detail_vendor_id= vendor_id;
		$state.go('vendor-create');
	};
}]);