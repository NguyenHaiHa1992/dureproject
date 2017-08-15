angular.module('app').directive('mySidebar', [function () {
    return {
        restrict: 'E',
        replace: true,
        scope: {},
        templateUrl: "amp/views/partials/_sidebar.html",
        controller: ['$scope', '$filter', '$http', 'BASE_URL', '$rootScope', '$state', '$cookies', '$location', '$timeout', '$templateCache', 'localStorageService',
            function ($scope, $filter, $http, BASE_URL, $rootScope, $state, $cookies, $location, $timeout, $templateCache, localStorageService) {
                $scope.root = $rootScope;
                $scope.purchase_order_sidebar = {};
                $scope.po_code_sidebar = '';
                $scope.current_purchase_order_status = false;
                $scope.current_purchase_order_id = localStorageService.get('current_purchase_order_id');

                $scope.PurchaseOrderDetail = function () {
                    if (localStorageService.get('current_purchase_order_id') != null) {
                        $rootScope.view_detail_purchase_order_id = localStorageService.get('current_purchase_order_id');
                        $state.go('purchase-order-detail', {id: localStorageService.get('current_purchase_order_id')}, {reload: true});
                    }
                }

                $scope.PurchaseOrderSummary = function () {
                    if (localStorageService.get('current_purchase_order_id') != null) {
                        $state.go('purchase-order-summary', {id: localStorageService.get('current_purchase_order_id')});
                    }
                }

                $scope.MachineSchedule = function () {
                    if (localStorageService.get('current_purchase_order_id') != null) {
                        $state.go('machine-schedule', {order_id: localStorageService.get('current_purchase_order_id')});
                    }
                }

                if (localStorageService.get('current_purchase_order_id') != null) {
                    $scope.current_purchase_order_status = true;
                    $scope.po_code_sidebar = localStorageService.get('current_purchase_order_code');
                }

                $scope.$watch(function () {
                    return $rootScope.current_purchase_order_id;
                }, function () {
                    if ($rootScope.current_purchase_order_code != undefined) {
                        $scope.po_code_sidebar = $rootScope.current_purchase_order_code;
                        $scope.current_purchase_order_status = true;
                        $('#Search_PurchaseOrder_id_sidebar_ampautocomplete .chosen-single span').text($scope.po_code_sidebar);
                    }
                }, true);

                $scope.poProcess = function () {
                    if ($scope.po_code_sidebar != '') {
                        $http.post(BASE_URL + '/purchaseOrder/checkPurchaseOrderCode', {'po_code': $scope.po_code_sidebar})
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
                                            $state.go('purchase-order-create', {po_code: $scope.po_code_sidebar});
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
                            return scope.purchase_order_sidebar.id;
                        },
                        function (new_purchase_order_sidebar_id) {
                            if (new_purchase_order_sidebar_id != '' && new_purchase_order_sidebar_id != undefined) {
                                localStorageService.set('current_purchase_order_code', $scope.purchase_order_sidebar.po_code);
                                localStorageService.set('current_purchase_order_id', $scope.purchase_order_sidebar.id);
                            }
                        }
                );

                $scope.$watch(
                        function (scope) {
                            return scope.search_purchase_order_id_sidebar;
                        },
                        function (new_purchase_order_sidebar_id) {
                            if (new_purchase_order_sidebar_id != '' && new_purchase_order_sidebar_id != undefined) {
                                localStorageService.set('current_purchase_order_code', $('#Search_PurchaseOrder_id_sidebar').val());
                                localStorageService.set('current_purchase_order_id', new_purchase_order_sidebar_id);
                            }
                        }
                );

                setTimeout(function () {
                    jQuery('.sidebar-toggle').click(function (e) {
                        e.preventDefault();
                        jQuery('body').toggleClass('sidebar-collapse');
                    });

                    jQuery('.sidebar').slimScroll({
                        //height: (jQuery('body').height() - 100) + 'px'
                        height: '600px'
                    });

                    jQuery('.treeview > a').click(function (e) {
                        e.preventDefault();
                        jQuery('.treeview').removeClass('active');
                        jQuery('.treeview-menu').removeClass('menu-open').css('display', 'none');

                        var treeview = jQuery(this).parent();
                        treeview.toggleClass('active');
                        jQuery('.treeview-menu', treeview).addClass('menu-open').css('display', 'block');
                    })
                }, 0);
            }]
    };
}]);