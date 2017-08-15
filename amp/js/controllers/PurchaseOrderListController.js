angular.module('app').controller('PurchaseOrderListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.purchase_orders= [];
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
	$scope.start_purchase_order= 1;
	$scope.end_purchase_order= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};

	$scope.search_purchase_order = {
		po_code :'', 
		id: '',
		name: '',
		created: '',
		category: ''
	};

	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	$scope.init= function(){
		$http.post(BASE_URL + '/purchaseOrder/getAllCategory', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.purchase_order_categories = data.purchase_order_categories;
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

	$scope.getPurchaseOrders= function(post_information){
		$http.post(BASE_URL + '/purchaseOrder/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_purchase_order= data.start_purchase_order;
				$scope.end_purchase_order= data.end_purchase_order;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.purchase_orders= [];
		    	$scope.purchase_orders= data.purchase_orders;

		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getPurchaseOrders(post_information);
	
	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_purchase_order.id,
								'name': $scope.search_purchase_order.name,
								'created': $scope.search_purchase_order.created,

								'po_code': $scope.search_purchase_order.po_code,
								'category': $scope.search_purchase_order.category,
							};
		$scope.getPurchaseOrders(post_information);
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
								
								'id': $scope.search_purchase_order.id,
								'name': $scope.search_purchase_order.name,
								'created': $scope.search_purchase_order.created,

								'po_code': $scope.search_purchase_order.po_code,
								'category': $scope.search_purchase_order.category,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getPurchaseOrders(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_purchase_order.id,
								'name': $scope.search_purchase_order.name,
								'created': $scope.search_purchase_order.created,

								'part_code': $scope.search_purchase_order.po_code,
								'category': $scope.search_purchase_order.category,
							};
		if($scope.search_change_number>1)
			$scope.getPurchaseOrders(post_information);
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
								
								'id': $scope.search_purchase_order.id,
								'name': $scope.search_purchase_order.name,
								'created': $scope.search_purchase_order.created,

								'po_code': $scope.search_purchase_order.po_code,
								'category': $scope.search_purchase_order.category
							};
		$scope.getPurchaseOrders(post_information);
	};
	
	$scope.viewDetail = function(purchase_order_id){
		$rootScope.view_detail_purchase_order_id= purchase_order_id;
		$state.go('purchase-order-create');
	};

	$scope.search = function(){
		post_information.po_code = $scope.search_purchase_order.po_code;
		post_information.category = $scope.search_purchase_order.category;

		$scope.getPurchaseOrders(post_information);
	}
}]);