angular.module('app').controller('StoreCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
    $scope.init_loaded = false;

    $scope.createInit= function(){
        var post_information= {};
        if(jQuery.type($rootScope.view_detail_store_id) !== "undefined" && $rootScope.view_detail_store_id !== ''){
            post_information= {id: $rootScope.view_detail_store_id};
            $rootScope.view_detail_store_id= undefined;
        }
        else{
            post_information= {};
        }
        $http.post(BASE_URL + '/store/createInit', post_information)
        .success(function(data) {
            $scope.init_loaded = true;

            if(data.success) {
                $scope.store= data.store;
                $scope.store_empty= data.store_empty;
                $scope.store_error= data.store_error;
                $scope.store_error_empty= data.store_error_empty;
                $scope.states= data.states;
                $scope.tiers= data.tiers;

                $scope.is_update= data.is_update;
                $scope.is_create= data.is_create;

                $scope.store_code= $scope.store.store_code;

                // If copy store
                if($rootScope.is_copy_store){
                    $scope.store.id = undefined;
                    $scope.store.name = $scope.store.name + ' COPY';
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
        var information_post= $scope.store;
        $http.post(BASE_URL + '/store/create', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Store created!', "", "success");
                $state.go('store-detail', {id: data.id});
            }
            else{
                $scope.store_error= data.store_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.update= function(){
        var information_post= $scope.store;
        $http.post(BASE_URL + '/store/update', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Store updated!', "", "success");
                $scope.store= data.store;
                $scope.store_error= $scope.store_error_empty;

                $( "input" ).removeClass( "ng-dirty" );
            }
            else{
                swal({
                        title: '',
                        text: 'Store update failed!',
                        type: 'error',
                        html: true
                });
                $scope.store_error= data.store_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.getStoreCard = function() {
        // Create card
        $scope.store.card = 'ID: ' + $scope.store.id +
                            '\Name: ' + $scope.store.name +
                            '\nEmail: ' + $scope.store.email +
                            '\nPhone: ' + $scope.store.phone +
                            '\nAddress 1: ' + $scope.store.address1 +
                            '\nAddress 2: ' + $scope.store.address2 +
                            '\nCity: ' + $scope.store.city +
                            '\nState/Province: ' + $scope.store.state_name +
                            '\nZipcode/Postal Code: ' + $scope.store.zipcode;
        return $scope.store.card;
    };

    $scope.copyToClipboard = function () {
    	swal({
            title: 'You have copied card to clipboard!',
            text: jQuery('#store_card').html(),
            type: 'success',
            html: true
    	});
    };

    //Date picker
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
}]);
