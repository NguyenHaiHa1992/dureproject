angular.module('app').controller('FixtureCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
    $scope.init_loaded = false;

    $scope.createInit= function(){
        var post_information= {};
        if(jQuery.type($rootScope.view_detail_fixture_id) !== "undefined" && $rootScope.view_detail_fixture_id !== ''){
            post_information= {id: $rootScope.view_detail_fixture_id};
            $rootScope.view_detail_fixture_id= undefined;
        }
        else{
            post_information= {};
        }
        $http.post(BASE_URL + '/fixture/createInit', post_information)
        .success(function(data) {
            $scope.init_loaded = true;

            if(data.success) {
                $scope.fixture= data.fixture;
                $scope.fixture_empty= data.fixture_empty;
                $scope.fixture_error= data.fixture_error;
                $scope.fixture_error_empty= data.fixture_error_empty;
                $scope.fixture_categories= data.fixture_categories;

                $scope.is_update= data.is_update;
                $scope.is_create= data.is_create;

                $scope.fixture_code= $scope.fixture.fixture_code;

                // If copy fixture
                if($rootScope.is_copy_fixture){
                    $scope.fixture.id = undefined;
                    $scope.fixture.code = $scope.fixture.code + ' COPY';
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
        var information_post= $scope.fixture;
        $http.post(BASE_URL + '/fixture/create', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Fixture created!', "", "success");
                $state.go('fixture-detail', {id: data.id});
            }
            else{
                $scope.fixture_error= data.fixture_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.update= function(){
        var information_post= $scope.fixture;
        $http.post(BASE_URL + '/fixture/update', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Fixture updated!', "", "success");
                $scope.fixture= data.fixture;
                $scope.fixture_error= $scope.fixture_error_empty;

                $( "input" ).removeClass( "ng-dirty" );
            }
            else{
                swal({
                        title: '',
                        text: 'Fixture update failed!',
                        type: 'error',
                        html: true
                });
                $scope.fixture_error= data.fixture_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };
}]);
