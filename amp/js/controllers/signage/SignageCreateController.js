angular.module('app').controller('SignageCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
    $scope.init_loaded = false;

    $scope.createInit= function(){
        var post_information= {};
        if(jQuery.type($rootScope.view_detail_signage_id) !== "undefined" && $rootScope.view_detail_signage_id !== ''){
            post_information= {id: $rootScope.view_detail_signage_id};
            $rootScope.view_detail_signage_id= undefined;
        }
        else{
            post_information= {};
        }
        $http.post(BASE_URL + '/signage/createInit', post_information)
        .success(function(data) {
            $scope.init_loaded = true;

            if(data.success) {
                $scope.signage= data.signage;
                $scope.signage_empty= data.signage_empty;
                $scope.signage_error= data.signage_error;
                $scope.signage_error_empty= data.signage_error_empty;
                $scope.signage_categories= data.signage_categories;

                $scope.is_update= data.is_update;
                $scope.is_create= data.is_create;

                $scope.signage_code= $scope.signage.signage_code;

                // If copy signage
                if($rootScope.is_copy_signage){
                    $scope.signage.id = undefined;
                    $scope.signage.code = $scope.signage.code + ' COPY';
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
        var information_post= $scope.signage;
        $http.post(BASE_URL + '/signage/create', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Signage created!', "", "success");
                $state.go('signage-detail', {id: data.id});
            }
            else{
                $scope.signage_error= data.signage_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.update= function(){
        var information_post= $scope.signage;
        $http.post(BASE_URL + '/signage/update', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Signage updated!', "", "success");
                $scope.signage= data.signage;
                $scope.signage_error= $scope.signage_error_empty;

                $( "input" ).removeClass( "ng-dirty" );
            }
            else{
                swal({
                        title: '',
                        text: 'Signage update failed!',
                        type: 'error',
                        html: true
                });
                $scope.signage_error= data.signage_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };
}]);
