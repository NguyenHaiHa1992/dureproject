angular.module('app').controller('ClientCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.client= {};
	$scope.client_error= {
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
	$scope.states = [];
	$scope.client_categories = [];
	
	$scope.client_code= '';
	
	$scope.createInit= function(){
		var post_information= {};
		if(jQuery.type($rootScope.view_detail_client_id) !== "undefined" && $rootScope.view_detail_client_id!= ''){
			post_information= {id: $rootScope.view_detail_client_id};
			$rootScope.view_detail_client_id= undefined;
		}
		else{
			post_information= {};
		}
		$http.post(BASE_URL + '/client/createInit', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.client= data.client;
		    	$scope.client_empty= data.client_empty;
				$scope.client_error= data.client_error;
				$scope.client_error_empty= data.client_error_empty;
				$scope.states= data.states;
				$scope.client_categories= data.client_categories;
				
				$scope.is_update= data.is_update;
				$scope.is_create= data.is_create;
				
				$scope.client_code= $scope.client.client_code;

				// If copy client
		    	if($rootScope.is_copy_client){
		    		$scope.client.id = undefined;
					$scope.is_update= false;
					$scope.is_create= true;
		    	}
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
		var information_post= $scope.client;
		$http.post(BASE_URL + '/client/create', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal('Client created!', "", "success");
		    	$state.go('client-list');
		    }
		    else{
		    	$scope.client_error= data.client_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	
	$scope.update= function(){
		var information_post= $scope.client;
		$http.post(BASE_URL + '/client/update', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal('Client updated!', "", "success");
		    	$scope.client= data.client;
		    	$scope.client_error= $scope.client_error_empty;
		    	
		    	$( "input" ).removeClass( "ng-dirty" );
		    }
		    else{
		    	swal({
		    		title: '',
		    		text: 'Client update failed!',
		    		type: 'error',
		    		html: true
		    	});
		    	$scope.client_error= data.client_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

    $scope.getClientCard = function() {
		// Create card
		$scope.client.card = 'ID: ' + $scope.client.id + 
							'\Name: ' + $scope.client.name + 
							'\nEmail: ' + $scope.client.email + 
							'\nPhone: ' + $scope.client.phone + 
							'\nAddress 1: ' + $scope.client.address1 + 
							'\nAddress 2: ' + $scope.client.address2 + 
							'\nCity: ' + $scope.client.city + 
							'\nState/Province: ' + $scope.client.state_name + 
							'\nZipcode/Postal Code: ' + $scope.client.zipcode;
        return $scope.client.card;
    }

    $scope.copyToClipboard = function () {
    	swal({
    		title: 'You have copied card to clipboard!',
    		text: jQuery('#client_card').html(),
    		type: 'success',
    		html: true
    	});
    }
}]);