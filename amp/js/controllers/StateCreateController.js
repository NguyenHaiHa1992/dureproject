angular.module('app').controller('StateCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.state= {};
	$scope.state_error= {
							'id': [],
							'state_short': [],
							'state_full': [],
							'country_short': [],
							'country_full': [],
						};
	$scope.states= [];
	
	$scope.state_code= '';
	
	$scope.createInit= function(){
		var post_information= {};
		if(jQuery.type($rootScope.view_detail_state_id) !== "undefined" && $rootScope.view_detail_state_id!= ''){
			post_information= {id: $rootScope.view_detail_state_id};
			$rootScope.view_detail_state_id= undefined;
		}
		else{
			post_information= {};
		}
		$http.post(BASE_URL + '/state/createInit', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.state= data.state;
		    	$scope.state_empty= data.state_empty;
				$scope.state_error= data.state_error;
				$scope.state_error_empty= data.state_error_empty;
				$scope.states= data.states;
				
				$scope.is_update= data.is_update;
				$scope.is_create= data.is_create;
				
				$scope.state_code= $scope.state.state_code;
				console.log($scope.state);
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
		var information_post= $scope.state;
		$http.post(BASE_URL + '/state/create', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal('State created!', "", "success");
		    	$state.go('list-state');
		    }
		    else{
		    	$scope.state_error= data.state_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	
	$scope.update= function(){
		var information_post= $scope.state;
		$http.post(BASE_URL + '/state/update', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal('State updated!', "", "success");
		    	$scope.state= data.state;
		    	$scope.state_error= $scope.state_error_empty;
		    	
		    	$( "input" ).removeClass( "ng-dirty" );
		    }
		    else{
		    	swal({
		    		title: '',
		    		text: 'State update failed!',
		    		type: 'error',
		    		html: true
		    	});
		    	$scope.state_error= data.state_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
}]);