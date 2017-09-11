angular.module('app').controller('ProductDevelopmentController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
    $scope.init_loaded = false;
    console.log("DEBUG : init 111");
    $scope.createInit= function(){
        var post_information= {};
        if(jQuery.type($rootScope.view_detail_project_id) !== "undefined" && $rootScope.view_detail_customer_id !== ''){
            post_information= {id: $rootScope.view_detail_customer_id};
            $rootScope.view_detail_project_id= undefined;
        }
        else{
            post_information= {};
        }
        $http.post(BASE_URL + '/project/createInit', post_information)
        .success(function(data) {
            $scope.init_loaded = true;

            if(data.success) {
                $scope.project= data.project;
                $scope.project_empty= data.project_empty;
                $scope.project_error= data.project_error;
                $scope.project_error_empty= data.project_error_empty;
                $scope.project_customers = data.project_customers;
                $scope.project_typeProducts = data.project_typeProducts;
                $scope.project_services = data.project_services;
                $scope.libYesNo = [{'id':1,'name':'Yes'},{'id':0,'name':'No'}];
                $scope.is_update= data.is_update;
                $scope.is_create= data.is_create;

                $scope.project_code= $scope.project.project_code;                
                // If copy project
                if($rootScope.is_copy_project){
                    $scope.project.id = undefined;
                    $scope.project.name = $scope.project.name + ' COPY';
                    $scope.is_update= false;
                    $scope.is_create= true;
                }
            }
            else{
                $state.go('404');
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.createInit();

    $scope.create= function(){
        var information_post = $scope.project;
        $http.post(BASE_URL + '/project/create', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Project created!', "", "success");
                $state.go('project-detail', {id: data.id});
            }
            else{
                $scope.project_error= data.project_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.update= function(){
        var information_post= $scope.project;
        $http.post(BASE_URL + '/project/update', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Project updated!', "", "success");
                $scope.project= data.customer;
                $scope.project_error= $scope.project_error_empty;

                $( "input" ).removeClass( "ng-dirty" );
            }
            else{
                swal({
                        title: '',
                        text: 'Project update failed!',
                        type: 'error',
                        html: true
                });
                $scope.project_error= data.project_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    //Date picker
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
}]);
