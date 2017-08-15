angular.module('app').controller('GraphicCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
    $scope.init_loaded = false;

    $scope.createInit= function(){
        var post_information= {};
        if(jQuery.type($rootScope.view_detail_graphic_id) !== "undefined" && $rootScope.view_detail_graphic_id !== ''){
            post_information= {id: $rootScope.view_detail_graphic_id};
            $rootScope.view_detail_graphic_id= undefined;
        }
        else{
            post_information= {};
        }
        $http.post(BASE_URL + '/graphic/createInit', post_information)
        .success(function(data) {
            $scope.init_loaded = true;

            if(data.success) {
                $scope.graphic= data.graphic;
                $scope.graphic_empty= data.graphic_empty;
                $scope.graphic_error= data.graphic_error;
                $scope.graphic_error_empty= data.graphic_error_empty;
                $scope.graphic_categories= data.graphic_categories;

                $scope.is_update= data.is_update;
                $scope.is_create= data.is_create;

                $scope.graphic_code= $scope.graphic.graphic_code;

                // If copy graphic
                if($rootScope.is_copy_graphic){
                    $scope.graphic.id = undefined;
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
        var information_post= $scope.graphic;
        $http.post(BASE_URL + '/graphic/create', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Graphic created!', "", "success");
                $state.go('graphic-list');
            }
            else{
                $scope.graphic_error= data.graphic_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.update= function(){
        var information_post= $scope.graphic;
        $http.post(BASE_URL + '/graphic/update', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Graphic updated!', "", "success");
                $scope.graphic= data.graphic;
                $scope.graphic_error= $scope.graphic_error_empty;

                $( "input" ).removeClass( "ng-dirty" );
            }
            else{
                swal({
                        title: '',
                        text: 'Graphic update failed!',
                        type: 'error',
                        html: true
                });
                $scope.graphic_error= data.graphic_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };
}]);
