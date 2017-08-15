angular.module('app').controller('MaterialPriceListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$filter', '$stateParams',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $filter, $stateParams){
	$scope.material_prices= [];
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
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};
	$scope.pages= [];
	$scope.currentPage= 1;
	$scope.start_material_price= 1;
	$scope.end_material_price= 1;
	$scope.totalresults= 0;
	$scope.locations= [];

	$scope.search_material_price = {
		id: '',
		date: '',
		material_id :'',
		vendor_id : '',
	};

	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	if($stateParams.material_id){
		post_information.material_id = $stateParams.material_id;
	}

	$scope.init= function(){
		$http.post(BASE_URL + '/vendor/getAll', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.vendors = data.vendors;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	//$scope.init();

	$scope.getMaterialPrices= function(post_information){
		$http.post(BASE_URL + '/materialPrice/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_material_price= data.start_material_price;
				$scope.end_material_price= data.end_material_price;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.material_prices= [];
		    	$scope.material_prices= data.material_prices;
		    	//$scope.locations= data.locations;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getMaterialPrices(post_information);
	
	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_material_price.id,
								'name': $scope.search_material_price.name,
								'created': $scope.search_material_price.created,

								'vendor_id': $scope.search_material_price.vendor_id,
								'material_id': $scope.search_material_price.material_id,
							};
		$scope.getMaterialPrices(post_information);
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
								
								'id': $scope.search_material_price.id,
								'name': $scope.search_material_price.name,
								'created': $scope.search_material_price.created,

								'vendor_id': $scope.search_material_price.vendor_id,
								'material_id': $scope.search_material_price.material_id,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getMaterialPrices(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_material_price.id,
								'name': $scope.search_material_price.name,
								'created': $scope.search_material_price.created,

								'vendor_id': $scope.search_material_price.vendor_id,
								'material_id': $scope.search_material_price.material_id,
							};
		if($scope.search_change_number>1)
			$scope.getMaterialPrices(post_information);
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
								
								'id': $scope.search_material_price.id,
								'name': $scope.search_material_price.name,
								'created': $scope.search_material_price.created,

								'material_price_code': $scope.search_material_price.material_price_code,
								'category_id': $scope.search_material_price.category_id,
							};
		$scope.getParts(post_information);
	};
	
	$scope.viewDetail = function(material_price_id){
		$rootScope.view_detail_material_price_id= material_price_id;
		$state.go('material-price-create');
	};

	$scope.search = function(){
		post_information.material_id = $scope.search_material_price.material_id;
		post_information.vendor_id = $scope.search_material_price.vendor_id; 

		$scope.getMaterialPrices(post_information);
	}

	$scope.importFile = function(){
        var file = $scope.uploaded_file;
        if(file){
	        // Validate file
	        var file_name = file.name;
	        var ext = file_name.substring(file_name.lastIndexOf('.') + 1).toLowerCase(); 

	        if(ext == 'xls' || ext == 'xlsx' || ext == 'csv'){
	            var fd = new FormData();
	            fd.append('uploaded_file', file);
	            $http.post(BASE_URL + '/materialPrice/importFile', fd, {
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined}
	            })
	            .success(function(data){
	                if(data.success){
	                    swal(data.message, "", "success");
	                	$state.reload();
	                }
	                else
	                	swal({
	                		title: "Import finished but some rows dismissed",
	                		text: data.message,
	                		html: true 
	                	});
	                	$state.reload();
	            })
	            .error(function(){
	            });
	        }
	        else{
	        	swal('Wrong format. Please select XLS or XLSX or CSV format', "", "error");
	        }
        }
        else{
        	swal('Please select XLS or XLSX or CSV file', "", "error");
        }
	}

	/************ Date picker **************/
	$('body').on('click', 'input.datepicker', function(event) {
	    $(this).datepicker({
	        showOn: 'focus',
	        yearRange: '1900:+0',
	        changeMonth: true,
	        changeYear: true,
			format: 'yyyy-mm-dd',
	    }).focus().on('changeDate', function(e){
			$(this).datepicker('hide');
		});
	});
}]);