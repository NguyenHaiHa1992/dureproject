angular.module('app').controller('CustomerCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
    $scope.init_loaded = false;

    $scope.createInit= function(){
        var post_information= {};
        if(jQuery.type($rootScope.view_detail_customer_id) !== "undefined" && $rootScope.view_detail_customer_id !== ''){
            post_information= {id: $rootScope.view_detail_customer_id};
            $rootScope.view_detail_customer_id= undefined;
        }
        else{
            post_information= {};
        }
        $http.post(BASE_URL + '/customer/createInit', post_information)
        .success(function(data) {
            $scope.init_loaded = true;

            if(data.success) {
                $scope.customer= data.customer;
                $scope.customer_empty= data.customer_empty;
                $scope.customer_error= data.customer_error;
                $scope.customer_error_empty= data.customer_error_empty;
                $scope.states= data.states;
                $scope.tiers= data.tiers;

                $scope.is_update= data.is_update;
                $scope.is_create= data.is_create;

                $scope.customer_code= $scope.customer.customer_code;

                // If copy customer
                if($rootScope.is_copy_customer){
                    $scope.customer.id = undefined;
                    $scope.customer.name = $scope.customer.name + ' COPY';
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
        var information_post= $scope.customer;
        $http.post(BASE_URL + '/customer/create', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Customer created!', "", "success");
                $state.go('customer-detail', {id: data.id});
            }
            else{
                $scope.customer_error= data.customer_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.update= function(){
        var information_post= $scope.customer;
        $http.post(BASE_URL + '/customer/update', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Customer updated!', "", "success");
                $scope.customer= data.customer;
                $scope.customer_error= $scope.customer_error_empty;

                $( "input" ).removeClass( "ng-dirty" );
            }
            else{
                swal({
                        title: '',
                        text: 'Customer update failed!',
                        type: 'error',
                        html: true
                });
                $scope.customer_error= data.customer_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.getCustomerCard = function() {
        // Create card
        $scope.customer.card = 'ID: ' + $scope.customer.id +
                            '\Name: ' + $scope.customer.name +
                            '\nEmail: ' + $scope.customer.email +
                            '\nPhone: ' + $scope.customer.phone +
                            '\nAddress 1: ' + $scope.customer.address1 +
                            '\nAddress 2: ' + $scope.customer.address2 +
                            '\nCity: ' + $scope.customer.city +
                            '\nState/Province: ' + $scope.customer.state_name +
                            '\nZipcode/Postal Code: ' + $scope.customer.zipcode;
        return $scope.customer.card;
    };

    $scope.copyToClipboard = function () {
    	swal({
            title: 'You have copied card to clipboard!',
            text: jQuery('#customer_card').html(),
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
