angular.module('app').controller('HeaderController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.po_code_header= 'abc';
	$scope.po_create= false;
	$scope.po_update= false;
	$scope.purchase_orders= [];
	$scope.createInit= function(){
		var post_information= {};
		$http.post(BASE_URL + '/home/createInit', post_information)
	    .success(function(data) {
		    if(data.success) {
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
	$scope.createInit();
	
	
	$scope.poProcess= function(){
		if($scope.po_create){
			console.log($scope.po_create); console.log($scope.po_update);
			alert('create'); return false;
			$state.go('purchase-order-create');
		}
		else if($scope.po_update){
			console.log($scope.po_create); console.log($scope.po_update);
			alert('update'); return false;
			jQuery('#processPO').modal('show');
		}
		else{}
	};
	
	$scope.number_po_code_change= 0;
	$scope.focus_po_code= false;
	$scope.blur_po_code= false;
	//$scope.$watchCollection('[po_code, blur_po_code]',
	$scope.$watch('po_code_header',
        function(){
        	
        	$scope.number_po_code_change++;
        	console.log($scope.number_po_code_change); 
        	//if($scope.number_po_code_change>1){
        		//if($scope.blur_po_code== true){
        			var in_array= false;
		        	$.each($scope.purchase_orders, function(key, purchase_order_value){
						if(purchase_order_value.po_code== $scope.po_code_header){
							$rootScope.view_detail_purchase_order_id= purchase_order_value.id;
							in_array= true;
							$scope.po_update= true;
							$scope.po_create= false;
							console.log(purchase_order_value);
							return false;
						}
					});
					if(in_array== false){
						$scope.po_update= false;
						$scope.po_create= true;
						
					}
        		//}
        	//}
        	
        }, true
     );
}]);