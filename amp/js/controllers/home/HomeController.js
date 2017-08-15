angular.module('app').controller('HomeController', ['$scope', '$timeout', '$http', '$location', '$rootScope', '$state', '$stateParams', 'BASE_URL', 'localStorageService', '$ocLazyLoad',
    function ($scope, $timeout, $http, $location, $rootScope, $state, $stateParams, BASE_URL, localStorageService, $ocLazyLoad) {
        $scope.root = $rootScope;
        $scope.purchase_order = {};
        $scope.po_code = '';
        $scope.search_purchase_order_id = '';

        $scope.poProcess = function () {
            if ($scope.search_purchase_order_id != '') {
                $http.post(BASE_URL + '/purchaseOrder/checkPurchaseOrderCode', {'po_code': $scope.po_code})
                        .success(function (data) {
                            if (data.success) {
                                $rootScope.view_detail_purchase_order_id = data.id;
                                $('#processPO').modal('show');
                            }
                            else {
                                sweetAlert({
                                    title: "Are you sure?",
                                    text: "This PO code does not exist, do you want to create new PO?",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "Yes, create new PO!",
                                    closeOnConfirm: true,
                                    html: true
                                },
                                function () {
                                    $rootScope.po_code = $scope.po_code;
                                    $state.go('purchase-order-create');
                                });
                            }
                        })
                        .error(function (data, status, headers, config) {
                            $state.go('404');
                        });
            }
        };

        $scope.$watch(
                function (scope) {
                    return scope.search_purchase_order_id;
                },
                function (new_purchase_order_id) {
                    if (new_purchase_order_id != '' && new_purchase_order_id != undefined) {
                        localStorageService.set('current_purchase_order_code', $scope.purchase_order.po_code);
                        localStorageService.set('current_purchase_order_id', $scope.purchase_order.id);
                    }
                }
        );

    }]);