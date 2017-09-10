angular.module('app').directive('productDevelopment',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{},
    templateUrl: "amp/views/productDevelopment/product-create.html",
    controller: ['$scope', '$http', '$rootScope', 'BASE_URL', '$state', function ($scope, $http, $rootScope, BASE_URL, $state){
        $scope.root = $rootScope;
        $scope.init_loaded = false;
        console.log("DEBUG : init ProductDevelopment");
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
                        } else {
                            $state.go('404');
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };

        $scope.createInit();

        $scope.create = function () {
            var information_post = $scope.project;
            $http.post(BASE_URL + '/project/create', information_post)
                    .success(function (data) {
                        if (data.success) {
                            swal('Project created!', "", "success");
                            $state.go('project-detail', {id: data.id});
                        } else {
                            $scope.project_error = data.project_error;
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };

        $scope.update = function () {
            var information_post = $scope.project;
            $http.post(BASE_URL + '/project/update', information_post)
                    .success(function (data) {
                        if (data.success) {
                            swal('Project updated!', "", "success");
                            $scope.project = data.customer;
                            $scope.project_error = $scope.project_error_empty;

                            $("input").removeClass("ng-dirty");
                        } else {
                            swal({
                                title: '',
                                text: 'Project update failed!',
                                type: 'error',
                                html: true
                            });
                            $scope.project_error = data.project_error;
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
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
