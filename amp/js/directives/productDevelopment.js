angular.module('app').directive('productDevelopment',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{
        ngModel : "=",
        fileId : "=",
    },
    require :'ngModel',
    templateUrl: "amp/views/productDevelopment/product-create.html",
    controller: ['$scope', '$http', '$rootScope', 'BASE_URL', '$state', function ($scope, $http, $rootScope, BASE_URL, $state){
        $scope.root = $rootScope;
        $scope.init_loaded = false;
        console.log("id : " + $scope.ngModel.id);
        console.log("project_id : " + $scope.ngModel.id);
//        for(var k in $scope.ngModel){
//            if(!$scope.ngModel.hasOwnProperty(k)) continue;
//            console.log(k + $scope.ngModel[k]);
//        }
        console.log("DEBUG : init ProductDevelopment");
        console.log($scope.fileId);
        $scope.createInit = function () {
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
                            $scope.productDevelopment = data.productDevelopment;
                            $scope.productDevelopment_empty = data.productDevelopment_empty;
                            $scope.productDevelopment_error = data.productDevelopment_error;
                            $scope.productDevelopment_error_empty = data.productDevelopment_error_empty;
                            $scope.libYesNo = [{'id': 1, 'name': 'Yes'}, {'id': 0, 'name': 'No'}];
                            $scope.is_update = data.is_update;
                            $scope.is_create = data.is_create;
                            $scope.ngModel = $scope.productDevelopment;
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
        
        $scope.showHideOther = function($model ,compare){
            console.log('DEBUG : function showHideOther');
            if ($model == compare) {
                $model = "";
            }
            console.log('DEBUG : end debug function showHideOther');
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
