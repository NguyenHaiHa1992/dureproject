angular.module('app').controller('CocListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies){
	$scope.inOutParts= [];
	$scope.inOutPartsByPage= 10;
	$scope.inOutPartsByPages= [
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
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};
	$scope.pages= [];
	$scope.currentPage= 1;
	$scope.start_inOutPart= 1;
	$scope.end_inOutPart= 1;
	$scope.totalresults= 0;

	$scope.search_inOutPart = {
		id: '',
		created: '',
		purchase_order_id : '',
		part_id : '',
		type: '1'
	};

	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.inOutPartsByPage,
						'type': '1',
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	// Setting InOutPart
	$scope.getInOutParts= function(post_information){
		$http.post(BASE_URL + '/part/getAllInOutPart', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_inOutPart= data.start_inOutPart;
				$scope.end_inOutPart= data.end_inOutPart;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.inOutPartsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.inOutParts= [];
		    	$scope.inOutParts = data.inOutParts;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	//$scope.getInOutParts();

	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.inOutPartsByPage,
								'limitnum': $scope.inOutPartsByPage,

								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								'type': '1',

								'id': $scope.search_inOutPart.id,
								'purchase_order_id': $scope.search_inOutPart.purchase_order_id,
								'part_id': $scope.search_inOutPart.part_id,
							};
		$scope.getInOutParts(post_information);
	};
	
	$scope.inOutPartsByPage_change_number= 0;
	$scope.$watch('inOutPartsByPage', function(){
		$scope.inOutPartsByPage_change_number++;
		if($scope.inOutPartsByPage== 0 || $scope.inOutPartsByPage== '0' || $scope.inOutPartsByPage== '' || $scope.inOutPartsByPage== null)
			$scope.inOutPartsByPage= 1;
		var post_information= {
								'limitstart': 0,
								'limitnum': $scope.inOutPartsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'type': '1',

								'id': $scope.search_inOutPart.id,
								'purchase_order_id': $scope.search_inOutPart.purchase_order_id,
								'part_id': $scope.search_inOutPart.part_id,
						};
		if($scope.inOutPartsByPage_change_number>1)
			$scope.getInOutParts(post_information);
	}, true);

	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.inOutPartsByPage,
								'limitnum': $scope.inOutPartsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,

								'type': '1',

								'id': $scope.search_inOutPart.id,
								'purchase_order_id': $scope.search_inOutPart.purchase_order_id,
								'part_id': $scope.search_inOutPart.part_id,
							};
		if($scope.search_change_number>1)
			$scope.getInOutParts(post_information);
	}, true);

	$scope.search = function(){
		post_information.purchase_order_id = $scope.search_inOutPart.purchase_order_id;
		post_information.part_id = $scope.search_inOutPart.part_id;

		$scope.getInOutParts(post_information);
	}

	$scope.viewDetailInOutPart = function(item){
		$scope.check_out_part = item;
		$scope.check_out_part.is_readonly = true;

		// Get part detail
		$http.post(BASE_URL + '/part/getPartById', {id: item.part_id})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.part = data.part;
			    $timeout(function() {
					$('.chosen_select').chosen('destroy').trigger('chosen:updated').chosen();
				}, 0, false);
		    }
		    else{
		    	swal({
		    		title: 'Error occurs',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    }
		})
		.error(function(data, status, headers, config) {
	    	swal({
	    		title: 'Error occurs',
	    		text: '',
	    		type: 'error',
	    		html: true
	    	});
  		});

  		// Get part location
		$http.post(BASE_URL + '/partLocation/getAll', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.locations = data.locations;
		    }
		    else{
		    	swal({
		    		title: 'Error occurs',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    }
		})
		.error(function(data, status, headers, config) {
	    	swal({
	    		title: 'Error occurs',
	    		text: '',
	    		type: 'error',
	    		html: true
	    	});
  		});

		$('#checkOutModal').modal('show');
	}

	// Get location by id
	$scope.locations = [];
	$scope.getLocationAttrById = function(id, attr){
		var result = {};
		$.each($scope.locations, function(i,v){
			if(id == v.id){
				result = v;
			}
		})

		return result[attr];
	}

	$scope.getFileNameFromPath = function(path){
		return path.split('/').pop();
	}

	// Show Certificate Conformance
	$scope.confirmGenerateCertificate = function(checkout){
		swal({
			title: "Are you sure?",
			text: "Do you want to generate Certificates of Conformance?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, generate!",
			closeOnConfirm: false}, 
			function(){ 
				$scope.generateCertificate(checkout);
			}
		);
	}

	$scope.generateCertificate = function(checkout){
		$http.post(BASE_URL + '/purchaseOrder/generateCertificate', {
			checkout_id: checkout.id, 
			purchase_order_code: checkout.purchase_order.purchase_order_code
		})
	    .success(function(data) {
		    if(data.success) {
		    	swal({
		    		title: 'Certificates generated',
		    		text: data.message,
		    		type: 'success',
		    		html: true
		    	});

		    	checkout.coc_files = data.coc_files;
		    }
		    else{
		    	swal({
		    		title: '',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	}
}]);