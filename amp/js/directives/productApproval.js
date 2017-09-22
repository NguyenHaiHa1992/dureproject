angular.module('app').directive('productApproval',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{
        productApproval : "=",
        productApprovalError: "=",
        update : "=",
        create : "=",
        isFullInfo: "="
    },
    templateUrl: "amp/views/productApproval/productAppr-create.html",
    controller: ['$scope', '$http', '$rootScope', 'BASE_URL', '$state' ,'$stateParams', function ($scope, $http, $rootScope, BASE_URL, $state, $stateParams){
        $scope.root = $rootScope;
        $scope.init_loaded = false;
        $scope.createInit = function () {
            var post_information = {};
            $http.post(BASE_URL + '/productApproval/createInit', post_information)
                    .success(function (data) {
                        $scope.init_loaded = true;
                        if (data.success) {
                            // $scope.productApproval = data.productApproval;
                            $scope.productApproval_empty = data.productApproval_empty;
//                            $scope.productApprovalError = data.productApproval_error;
                            $scope.productApprovalError_empty = data.productApprovalError_empty;
                            $scope.is_update = data.is_update;
                            $scope.is_create = data.is_create;
                            $scope.scopeSetData($scope.productApprovalError , data.productApproval_error);
                            if($scope.update){
                                $scope.getProductApprovalByProjectId();
                            }
                            else{
                                $scope.scopeSetData($scope.productApproval ,data.productApproval);
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


        $scope.getProductApprovalByProjectId = function () {
            $http.post(BASE_URL + '/productApproval/getProductApprovalByProjectId', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.scopeSetData($scope.productApproval, data.productApproval);
                    $scope.scopeSetData($scope.productApprovalError , data.productApproval_error);
                }
                else {
                    $scope.productApproval.project_id = $stateParams.id;
                    $scope.productApproval.status = 0;
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
