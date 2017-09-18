angular.module('app').directive('packProduct',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{
        packProduct : "=",
        packProductError: "=",
        update : "=",
        create : "=",
    },
    templateUrl: "amp/views/packProduct/pack-create.html",
    controller: ['$scope', '$http', '$rootScope', 'BASE_URL', '$state' ,'$stateParams', function ($scope, $http, $rootScope, BASE_URL, $state, $stateParams){
        $scope.root = $rootScope;
        $scope.init_loaded = false;

        $scope.createInit = function () {
            var post_information = {};
            $http.post(BASE_URL + '/packProduct/createInit', post_information)
                    .success(function (data) {
                        $scope.init_loaded = true;
                        if (data.success) {
                            // $scope.packProduct = data.packProduct;
                            $scope.packProduct_empty = data.packProduct_empty;
//                            $scope.packProductError = data.packProductError;
                            $scope.packProductError_empty = data.packProductError_empty;
                            $scope.is_update = data.is_update;
                            $scope.is_create = data.is_create;
                            $scope.scopeSetData($scope.packProduct ,data.packProduct);
                            if($scope.update){
                                $scope.getPackProductByProjectId();
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


        $scope.getPackProductByProjectId = function () {
            $http.post(BASE_URL + '/packProduct/getPackProductByProjectId', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.packProductError = data.packProductError;
                    $scope.scopeSetData($scope.packProduct, data.packProduct);
                }
                else {
//                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.scopeSetData = function($obj ,data){
            if(typeof data !== 'object'){
                return;
            }
            else{
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
