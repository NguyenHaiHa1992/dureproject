angular.module('app').directive('sale',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{
        sale : "=",
        update : "=",
        create : "=",
    },
    templateUrl: "amp/views/sale/sale-create.html",
    controller: ['$scope', '$http', '$rootScope', 'BASE_URL', '$state' ,'$stateParams', function ($scope, $http, $rootScope, BASE_URL, $state, $stateParams){
        $scope.root = $rootScope;
        $scope.init_loaded = false;
        console.log("DEBUG : init Sale");

        $scope.createInit = function () {
            var post_information = {};
            $http.post(BASE_URL + '/sale/createInit', post_information)
                    .success(function (data) {
                        $scope.init_loaded = true;
                        if (data.success) {
                            $scope.sale_empty = data.sale_empty;
                            $scope.sale_error = data.sale_error;
                            $scope.sale_error_empty = data.sale_error_empty;
                            $scope.libYesNo = [{'id': '1', 'name': 'Yes'}, {'id': '0', 'name': 'No'}];
                            $scope.is_update = data.is_update;
                            $scope.is_create = data.is_create;
                            $scope.scopeSetData(data.sale);
                            if($scope.update){
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

        console.log("DEBUG : end init sale");

        $scope.getProductProjectById = function () {
            $http.post(BASE_URL + '/sale/getSaleByProjectId', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.sale_error = data.sale_error;
                    $scope.scopeSetData(data.sale);
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
            if ($model == compare) {
                $model = "";
            }
        };
        $scope.scopeSetData = function(data){
            if(typeof data !== 'object'){
                return;
            }
            else{
                for(var dataKey in data){
                    if(!data.hasOwnProperty(dataKey)) continue;
                    $scope.sale[dataKey] = data[dataKey];
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
