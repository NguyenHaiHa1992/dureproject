angular.module('app').directive('myHeader', [function () {
        return {
            restrict: 'E',
            replace: true,
            // scope: {po_code_header: '=poCodeHeader',
            // purchase_orders: '=purchaseOrders',
            // po_create: '=poCreate',
            // po_update: '=poUpdate'}, 
            scope: {},
            templateUrl: "amp/views/partials/_header.html",
            // templateUrl: 
            // function(){
            // if(typeof $cookieStore.get('is_amp_guest') == 'undefined' || $cookieStore.get('is_amp_guest')== true){
            // console.log('header');
            // console.log($cookieStore.get('is_amp_guest'));
            // return "amp/views/blank.html";
            // }
            // else{
            // console.log('header 2');
            // console.log($cookieStore.get('is_amp_guest'));
            // return "amp/views/partials/_header.html";
            // }
            // },
            controller: ['$scope', '$filter', '$http', 'BASE_URL', '$rootScope', '$state', '$cookies', '$location', '$timeout', '$templateCache',
                function ($scope, $filter, $http, BASE_URL, $rootScope, $state, $cookies, $location, $timeout, $templateCache) {

                    $scope.po_code_header = '';
                    $scope.purchase_orders = [];
                    $scope.po_update = false;
                    $scope.po_create = false;
                    $scope.number_po_code_change = 0;

                    $scope.$watch('po_code_header',
                            function () {
                                $scope.number_po_code_change++;
                                //if($scope.number_po_code_change>1){
                                //if($scope.blur_po_code== true){
                                var in_array = false;
                                $.each($scope.purchase_orders, function (key, purchase_order_value) {
                                    if (purchase_order_value.po_code == $scope.po_code_header) {
                                        $rootScope.view_detail_purchase_order_id = purchase_order_value.id;
                                        in_array = true;
                                        $scope.po_update = true;
                                        $scope.po_create = false;
                                        return false;
                                    }
                                });
                                if (in_array == false) {
                                    $scope.po_update = false;
                                    $scope.po_create = true;

                                }
                                //}
                                //}
                            }, true
                            );

                    $scope.poProcess = function () {
                        if ($scope.po_create) {
                            $state.go('purchase-order-create');
                        }
                        else if ($scope.po_update) {
                            jQuery('#processPO').modal('show');
                        }
                        else {
                        }
                    };

                    $scope.logout = function () {
                        $http.post(BASE_URL + '/user/logout', {})
                                .success(function (data) {
                                    if (data.success) {
                                        // Remove cache
                                        $templateCache.removeAll();

                                        $timeout(function () {
                                            $rootScope.is_amp_guest = true;
                                            $state.go('login');
                                        }, 1000);

                                    }
                                    else {
                                        // Remove cache
                                        $templateCache.removeAll();

                                        $timeout(function () {
                                            $rootScope.is_amp_guest = true;
                                            $state.go('login');
                                        }, 1000);
                                        console.log('Note: User has been logout before');
                                    }
                                })
                                .error(function (data, status, headers, config) {
                                    $state.go('404');
                                });
                    };

                    $scope.$watch(function () {
                        return $rootScope.user_id;
                    }, function () {
                        if ($rootScope.user_id != undefined) {
                            $scope.user_email = $rootScope.user_email;
                            $scope.user_id = $rootScope.user_id;
                            $scope.user_name = $rootScope.user_name;
                        }
                    }, true);

                    // When update profile
                    $scope.$watch(function () {
                        return $rootScope.user_name;
                    }, function () {
                        if ($rootScope.user_name != undefined) {
                            $scope.user_name = $rootScope.user_name;
                        }
                    }, true);

                }]
        };
    }]);