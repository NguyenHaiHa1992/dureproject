angular.module('app').controller('MaterialPriceCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$filter',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $filter, $stateParams){
	$scope.material_price= {};
	$scope.copy_material_price= {};
	$scope.material_price.id = '';
	$scope.material_price.material = {};

	$scope.material_price_error= {
								'id': [],
								'material_id': [],
								'vendor_id': [],
								'total_inch': [],
								'weight': [],
								'price_per_inch': [],
								'price_per_lbs': [],
							};

	$scope.vendors = [];
	$scope.materials = [];

	$scope.is_readonly = false;

	$scope.createInit= function(){
		var post_information = {};

		if(jQuery.type($rootScope.view_detail_material_price_id) !== "undefined" && $rootScope.view_detail_material_price_id!= ''){
			post_information= {id: $rootScope.view_detail_material_price_id};
			$rootScope.view_detail_material_price_id= undefined;
		}
		else{
			post_information= {};
		}

		$http.post(BASE_URL + '/materialPrice/createInit', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.material_price= data.material_price;
				$scope.material_price_error= data.material_price_error;
				
				$scope.material_price_empty= data.material_price_empty;
				$scope.material_price_error_empty= data.material_price_error_empty;

				$scope.vendors = data.vendors;
				$scope.materials = data.materials;

				$scope.is_update= data.is_update;
				$scope.is_create= data.is_create;

				$scope.copy_material_price = angular.copy($scope.material_price);
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
		var information_post= $scope.material_price;
		$http.post(BASE_URL + '/materialPrice/create', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal('Material Price created!', "", "success");
		    	$scope.is_readonly = true;
		    	$state.go('material-price-list');
		    }
		    else{
		    	if(data.type== 'alert')
			    	swal({
			    		title: '',
			    		text: data.message,
			    		type: 'error',
			    		html: true
			    	});

		    	else
		    		$scope.material_price_error= data.material_price_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	
	$scope.update= function(){
		var updateMaterialPrice = function(){
			var information_post = $scope.material_price ;

			$http.post(BASE_URL + '/materialPrice/update', information_post)
		    .success(function(data) {
			    if(data.success) {
			    	swal('Material Price updated!', "", "success");
			    	$scope.material_price= data.material_price;
			    	$scope.material_price_error= $scope.material_price_error_empty;
					$scope.copy_material_price = angular.copy($scope.material_price);

			    	$( "input, select" ).removeClass( "ng-dirty" );

					// Lock material_price
					$scope.is_readonly = true;
			    }
			    else{
			    	if(data.type== 'alert')
				    	swal({
				    		title: '',
				    		text: data.message,
				    		type: 'error',
				    		html: true
				    	});
			    	else
			    		$scope.material_price_error= data.material_price_error;
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});
	  	}

		// Check change Material
		if($scope.copy_material_price.material_id != $scope.material_price.material_id){
		    sweetAlert({
				title: "Are you sure?",
		      	text: "Material Code in Material Price will be changed!",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, do it!",
		      	closeOnConfirm: true,
		      	html: true
		    },
		    function(){
				updateMaterialPrice();
		    });
		}
		else{
			updateMaterialPrice();
		}

		// Check change Vendor
		if($scope.copy_material_price.vendor_id != $scope.material_price.vendor_id){
		    sweetAlert({
				title: "Are you sure?",
		      	text: "Vendor in Material Price will be changed!",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, do it!",
		      	closeOnConfirm: true,
		      	html: true
		    },
		    function(){
				updateMaterialPrice();
		    });
		}
		else{
			updateMaterialPrice();
		}
	};

	// Unlock material_price
	$scope.unlock = function(){
		$scope.is_readonly = false;
	}

	// Watch material change
	$scope.changeMaterial = function(){
		$.each($scope.materials, function(i,v){
			if(v.id == $scope.material_price.material_id){
				console.log(v);
				$scope.material_price.material = {};
				$scope.material_price.material.shape = v.shape;
				$scope.material_price.material.sizes = v.sizes;
			}
		})
	}

	$scope.changePricePerInch = $scope.changeWeight = function(){
		if($scope.material_price.total_inch !='' && $scope.material_price.price_per_inch !='' && $scope.material_price.weight !=''){
			$scope.material_price.price_per_lbs = strip(parseFloat($scope.material_price.total_inch) * parseFloat($scope.material_price.price_per_inch) / parseFloat($scope.material_price.weight));
		}
	}

	$scope.changePricePerLbs = $scope.changeTotalInch = function(){
		if($scope.material_price.total_inch !='' && $scope.material_price.price_per_lbs !='' && $scope.material_price.weight !=''){
			$scope.material_price.price_per_inch = strip(parseFloat($scope.material_price.weight) * parseFloat($scope.material_price.price_per_lbs) / parseFloat($scope.material_price.total_inch));
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

	/************** Strip function **********/
	function strip(number) {
	    return (parseFloat(number.toPrecision(12)));
	}

	/************** Editor *****************/
}]);