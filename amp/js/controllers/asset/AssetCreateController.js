angular.module('app').controller('AssetCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
    $scope.init_loaded = false;

    $scope.createInit= function(){
        var post_information= {};
        if(jQuery.type($rootScope.view_detail_asset_id) !== "undefined" && $rootScope.view_detail_asset_id !== ''){
            post_information= {id: $rootScope.view_detail_asset_id};
            $rootScope.view_detail_asset_id= undefined;
        }
        else{
            post_information= {};
        }
        $http.post(BASE_URL + '/asset/createInit', post_information)
        .success(function(data) {
            $scope.init_loaded = true;

            if(data.success) {
                $scope.asset= data.asset;
                $scope.asset_empty= data.asset_empty;
                $scope.asset_error= data.asset_error;
                $scope.asset_error_empty= data.asset_error_empty;
                $scope.asset_categories= data.asset_categories;

                $scope.is_update= data.is_update;
                $scope.is_create= data.is_create;

                $scope.asset_code= $scope.asset.asset_code;

                // If copy asset
                if($rootScope.is_copy_asset){
                    $scope.asset.id = undefined;
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
        var information_post= $scope.asset;
        $http.post(BASE_URL + '/asset/create', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Asset created!', "", "success");
                $state.go('asset-list');
            }
            else{
                $scope.asset_error= data.asset_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.update= function(){
        var information_post= $scope.asset;
        $http.post(BASE_URL + '/asset/update', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Asset updated!', "", "success");
                $scope.asset= data.asset;
                $scope.asset_error= $scope.asset_error_empty;

                $( "input" ).removeClass( "ng-dirty" );
            }
            else{
                swal({
                        title: '',
                        text: 'Asset update failed!',
                        type: 'error',
                        html: true
                });
                $scope.asset_error= data.asset_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };
}]);
