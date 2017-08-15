angular.module('app').directive('myModalProcessPo', function () {
    return {
        restrict: 'E', 
        replace: true,
        scope:{uiId: '=',},
        templateUrl: "amp/views/partials/_modalProcessPO.html",
        controller: ['$scope', '$filter', '$http', 'BASE_URL', '$rootScope', '$state',
        	function ($scope, $filter, $http, BASE_URL, $rootScope, $state) {
	            $scope.closeModal= function(){
	            	$('#processPO').modal('hide');
	            };

                $scope.purchaseOrderDetail = function(){
                    $('#processPO').modal('hide');
                    $state.go('purchase-order-detail',{id: $scope.uiId});
                };

                $scope.purchaseOrderSummary = function(){
                    $('#processPO').modal('hide');
                    $state.go('purchase-order-summary',{id: $scope.uiId});
                };

                $scope.purchaseOrderMachineSchedule = function(){
                    $('#processPO').modal('hide');
                    $state.go('machine-schedule',{order_id: $scope.uiId});
                };

        }]
    };
});