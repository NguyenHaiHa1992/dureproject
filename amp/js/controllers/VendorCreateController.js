angular.module('app').controller('VendorCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.vendor= {};
	$scope.vendor_error= {
							'id': [],
							'name': [],
							'address1': [],
							'address2': [],
							'city': [],
							'zipcode': [],
							'state_id': [],
							'category_ids': [],
							'company_name': [],
							'contact_name': [],
							'country': [],
							'email': [],
							'phone': [],
							'fax': [],
							'status': [],
							'created_time': [],
							'category_ids':[]
						};
	
	$scope.vendor_code= '';
	
	$scope.createInit= function(){
		var post_information= {};
		if(jQuery.type($rootScope.view_detail_vendor_id) !== "undefined" && $rootScope.view_detail_vendor_id!= ''){
			post_information= {id: $rootScope.view_detail_vendor_id};
			$rootScope.view_detail_vendor_id= undefined;
		}
		else{
			post_information= {};
		}
		$http.post(BASE_URL + '/vendor/createInit', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.vendor= data.vendor;
		    	$scope.vendor_empty= data.vendor_empty;
				$scope.vendor_error= data.vendor_error;
				$scope.vendor_error_empty= data.vendor_error_empty;

				$scope.states= data.states;
				$scope.vendor_categories= data.vendor_categories;
				
				$scope.is_update= data.is_update;
				$scope.is_create= data.is_create;
				
				$scope.vendor_code= $scope.vendor.vendor_code;
				console.log($scope.vendor);
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
		var information_post= $scope.vendor;
		$http.post(BASE_URL + '/vendor/create', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal('Vendor created!', "", "success");
		    	$state.go('vendor-list');
		    }
		    else{
		    	$scope.vendor_error= data.vendor_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	
	$scope.update= function(){
		var information_post= $scope.vendor;
		$http.post(BASE_URL + '/vendor/update', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal('Vendor updated!', "", "success");
		    	$scope.vendor= data.vendor;
		    	$scope.vendor_error= $scope.vendor_error_empty;
		    	
		    	$( "input" ).removeClass( "ng-dirty" );
		    }
		    else{
		    	swal({
		    		title: '',
		    		text: 'Vendor update failed!',
		    		type: 'error',
		    		html: true
		    	});
		    	$scope.vendor_error= data.vendor_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

    $scope.getVendorCard = function() {
		// Create card
		$scope.vendor.card = 'ID: ' + $scope.vendor.id + 
							'\Name: ' + $scope.vendor.name + 
							'\nEmail: ' + $scope.vendor.email + 
							'\nPhone: ' + $scope.vendor.phone + 
							'\nAddress 1: ' + $scope.vendor.address1 + 
							'\nAddress 2: ' + $scope.vendor.address2 + 
							'\nCity: ' + $scope.vendor.city + 
							'\nState/Province: ' + $scope.vendor.state_name + 
							'\nZipcode/Postal Code: ' + $scope.vendor.zipcode;
        return $scope.vendor.card;
    }

    $scope.copyToClipboard = function () {
    	swal({
    		title: 'You have copied card to clipboard!',
    		text: jQuery('#vendor_card').html(),
    		type: 'success',
    		html: true
    	});
    }
}]);