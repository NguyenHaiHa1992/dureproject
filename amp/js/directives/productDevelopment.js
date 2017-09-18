angular.module('app').directive('productDevelopment',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{
        productDevelopment : "=",
        productDevelopmentError : "=",
        update : "=",
        create : "=",
    },
//    require :'ngModel',
    templateUrl: "amp/views/productDevelopment/product-create.html",
    controller: ['$scope', '$http', '$rootScope', 'BASE_URL', '$state' ,'$stateParams', function ($scope, $http, $rootScope, BASE_URL, $state, $stateParams){
        $scope.root = $rootScope;
        $scope.init_loaded = false;
        console.log("DEBUG : init ProductDevelopment");

        $scope.createInit = function () {
            console.log("Vao createInit");
            var post_information = {};
            if (jQuery.type($rootScope.view_detail_project_id) !== "undefined" && $rootScope.view_detail_customer_id !== '') {
                post_information = {id: $rootScope.view_detail_customer_id};
                $rootScope.view_detail_project_id = undefined;
            } else {
                post_information = {};
            }
            $http.post(BASE_URL + '/productDevelopment/createInit', post_information)
                    .success(function (data) {
                        $scope.init_loaded = true;
                        if (data.success) {
                            // $scope.productDevelopment = data.productDevelopment;
                            $scope.productDevelopment_empty = data.productDevelopment_empty;
                            $scope.productDevelopmentError = data.productDevelopment_error;
                            $scope.productDevelopmentError_empty = data.productDevelopment_error_empty;
                            $scope.libYesNo = [{'id': '1', 'name': 'Yes'}, {'id': '0', 'name': 'No'}];
                            $scope.is_update = data.is_update;
                            $scope.is_create = data.is_create;
                            $scope.scopeSetData(data.productDevelopment);
                            if($scope.update){
                                console.log("DEBUG : on getProductProjectById");
                                $scope.getProductProjectById();
                            }
                        } else {
                            $state.go('404');
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };

        $scope.createInit();

        console.log("DEBUG : end init productDevelopment");

        $scope.getProductProjectById = function () {
            $http.post(BASE_URL + '/productDevelopment/getProductByProjectId', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    // $scope.productDevelopmentError = data.productDevelopment_error;
                    $scope.scopeSetData($scope.productDevelopmentError ,data.productDevelopment_error)
                    $scope.scopeSetData($scope.productDevelopment, data.productDevelopment);
                }
                else {
//                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.showHideOther = function($model ,compare){
            console.log('DEBUG : function showHideOther');
            if ($model == compare) {
                $model = "";
            }
            console.log('DEBUG : end debug function showHideOther');
        };
        $scope.scopeSetData = function($obj,data){
            if(typeof data !== 'object'){
                console.log(1);
                return;
            }
            else{
                console.log(2);
                for(var dataKey in data){
                    if(!data.hasOwnProperty(dataKey)) continue;
                        $obj[dataKey] = data[dataKey];
                }
            }
        };
        //Date picker
        jQuery('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    }],
    link: function(scope, iElement, iAttrs){
      scope.has_file = false;
      scope.$watch('fileId', function(newValue, oldValue) {});
    }
  };
}]);
