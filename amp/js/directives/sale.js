angular.module('app').directive('sale',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{
        sale : "=",
        saleError : "=",
        update : "=",
        create : "=",
        projectService: "="
    },
    templateUrl: "amp/views/sale/sale-create.html",
    controller: ['$scope', '$http', '$rootScope', 'BASE_URL', '$state' ,'$stateParams', function ($scope, $http, $rootScope, BASE_URL, $state, $stateParams){
        $scope.root = $rootScope;
        $scope.init_loaded = false;
        $scope.createInit = function () {
            var post_information = {};
            $http.post(BASE_URL + '/sale/createInit', post_information)
                    .success(function (data) {
                        $scope.init_loaded = true;
                        if (data.success) {
                            $scope.sale_empty = data.sale_empty;
                            // $scope.saleError = data.sale_error;
                            $scope.saleError_empty = data.sale_error_empty;
                            $scope.is_update = data.is_update;
                            $scope.is_create = data.is_create;

                            /** setLib **/
                            $scope.libYesNo = [{'id': '1', 'name': 'Yes'}, {'id': '0', 'name': 'No'}];
                            $scope.libTypeProductInfo = data.libTypeProductInfo;
                            $scope.libTypeOfPacking = data.libTypeOfPacking;
                            $scope.libPackPlain = data.libPackPlain;
                            $scope.libPackCustomer = data.libPackCustomer;

                            /*end setLib*/
                            $scope.scopeSetData($scope.sale , data.sale);
                            $scope.scopeSetData($scope.saleError , data.sale_error);
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

        $scope.getProductProjectById = function () {
            $http.post(BASE_URL + '/sale/getSaleByProjectId', {id: $stateParams.id})
            .success(function (data) {
                console.log('get sale by project di');
                console.log(data);
                if (data.success) {
                    $scope.scopeSetData($scope.sale ,data.sale);
                    $scope.scopeSetData($scope.saleError ,data.sale_error);
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
        
        $scope.$watch('saleError', function(){
            console.log('sale error change');
            console.log($scope.saleError);
        });
    }],
    link: function(scope, iElement, iAttrs){
      scope.has_file = false;
      scope.$watch('fileId', function(newValue, oldValue) {});
    }
  };
}]);
