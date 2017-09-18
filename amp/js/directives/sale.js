angular.module('app').directive('sale',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{
        sale : "=",
        saleError : "=",
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
                            $scope.saleError = data.sale_error;
                            $scope.saleError_empty = data.sale_error_empty;

                            /** setLib **/
                            $scope.libYesNo = [{'id': '1', 'name': 'Yes'}, {'id': '0', 'name': 'No'}];
                            $rootScope.libTypeProductInfo = data.libTypeProductInfo;
                            $rootScope.libTypeOfPacking = data.libTypeOfPacking;
                            $rootScope.libPackPlain = data.libPackPlain;
                            $rootScope.libPackCustomer = data.libPackCustomer;

                            /*end setLib*/

                            $scope.scopeSetData($scope.sale , data.sale);
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
                    $scope.saleError = data.sale_error;
                    $scope.scopeSetData($scope.sale ,data.sale);
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
