angular.module('app').controller('StoreDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window) {
        $scope.root = $rootScope;
        $scope.init_loaded = false;

        $scope.createInit = function () {
            var post_information = {};

            $http.post(BASE_URL + '/store/createInit', post_information)
            .success(function (data) {
                $scope.init_loaded = true;
                if (data.success) {
                    $scope.store_empty = data.store_empty;
                    $scope.store_error = data.store_error;
                    $scope.store_error_empty = data.store_error_empty;
                    $scope.states = data.states;
                    $scope.tiers = data.tiers;

                    $scope.is_update = true;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.createInit();

        $scope.getStoreById = function () {
            $http.post(BASE_URL + '/store/getStoreById', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.store = data.store;
                    $scope.store_code = $scope.store.store_code;
                    $scope.store_error = data.store_error;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getStoreById();

        $scope.update = function () {
            var information_post = $scope.store;
            $http.post(BASE_URL + '/store/update', information_post)
                    .success(function (data) {
                        if (data.success) {
                            swal('Store updated!', "", "success");
                            $scope.store = data.store;
                            $scope.store_error = $scope.store_error_empty;

                            $("input").removeClass("ng-dirty");
                        }
                        else {
                            swal({
                                title: '',
                                text: 'Store update failed!',
                                type: 'error',
                                html: true
                            });
                            $scope.store_error = data.store_error;
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };

        $scope.getStoreCard = function () {
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
        }

        $scope.copyToClipboard = function () {
            swal({
                title: 'Copied to clipboard!',
                text: jQuery('#store_card').html(),
                type: 'success',
                html: true
            });
        }

        $scope.copyStore = function () {
//            $rootScope.view_detail_store_id = $scope.store.id;
//            $rootScope.is_copy_store = true;
//            $state.go('store-create');
            $http.post(BASE_URL + '/store/copy', {id: $scope.store.id})
            .success(function (data) {
                if (data.success) {
                    $state.go('store-detail', {id: data.id});
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
    
        }

        // Store's signages list
        $scope.store_signage_list = {};
        $scope.store_signage_list.signages = [];
        $scope.store_signage_list.itemsByPage = 10;
        $scope.store_signage_list.itemsByPages = [
            {value: 10, name: 10}, 
            {value: 20, name: 20}, 
            {value: 30, name: 30},
            {
                value: 50,
                name: 50
            },
            {
                value: 100,
                name: 100
            },];
        $scope.store_signage_list.pages = [];
        $scope.store_signage_list.currentPage = 1;
        $scope.store_signage_list.start_signage = 1;
        $scope.store_signage_list.end_signage = 1;
        $scope.store_signage_list.totalresults = 0;
        $scope.store_signage_list.sort = {
            attribute: 'created_time',
            type: 'DESC',
        };
        $scope.store_signage_list.search_signage = {
            id: '',
            code: '',
            email: '',
            created: '',
            category_id: ''
        };
        var store_signage_post_information = {
            'store_id': $stateParams.id,
            'limitstart': 0,
            'limitnum': $scope.store_signage_list.itemsByPage,
            'sort_attribute': $scope.store_signage_list.sort.attribute,
            'sort_type': $scope.store_signage_list.sort.type,
        };

        $scope.store_signage_list.getSignages = function (store_signage_post_information) {
            $http.post(BASE_URL + '/storeSignage/getAll', store_signage_post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.store_signage_list.totalresults = parseInt(data.totalresults);
                    $scope.store_signage_list.start_signage = data.start_signage;
                    $scope.store_signage_list.end_signage = data.end_signage;
                    $scope.store_signage_list.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.store_signage_list.itemsByPage); p++)
                        $scope.store_signage_list.pages.push(p + 1);
                        $scope.store_signage_list.signages = [];
                        $scope.store_signage_list.signages = data.signages;
                    $scope.selectedSignageIds = [];
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.store_signage_list.getSignages(store_signage_post_information);

        $scope.store_signage_list.getSignageCategories = function (post_information) {
            $http.post(BASE_URL + '/signageCategory/getAll', [])
            .success(function (data) {
                if (data.success) {
                    $scope.store_signage_list.signage_categories = data.signage_categories;
                }
                else {
                    swal('Can not get signage category list', '', 'error');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.store_signage_list.getSignageCategories(store_signage_post_information);

        $scope.store_signage_list.selectPage = function (page) {
            $scope.store_signage_list.currentPage = page;
            var store_signage_post_information = {
                'store_id': $stateParams.id,
                'limitstart': (page - 1) * $scope.store_signage_list.itemsByPage,
                'limitnum': $scope.store_signage_list.itemsByPage,
                'sort_attribute': $scope.store_signage_list.sort.attribute,
                'sort_type': $scope.store_signage_list.sort.type,
                'id': $scope.store_signage_list.search_signage.id,
                'code': $scope.store_signage_list.search_signage.code,
                'category_id': $scope.store_signage_list.search_signage.category_id,
                'email': $scope.store_signage_list.search_signage.email,
                'created': $scope.store_signage_list.search_signage.created,
            };
            $scope.store_signage_list.getSignages(store_signage_post_information);
        };

        $scope.store_signage_list.itemsByPage_change_number = 0;
        $scope.$watch('store_signage_list.itemsByPage', function () {
            $scope.store_signage_list.itemsByPage_change_number++;
            if ($scope.store_signage_list.itemsByPage == 0 || $scope.store_signage_list.itemsByPage == '0' || $scope.store_signage_list.itemsByPage == '' || $scope.store_signage_list.itemsByPage == null)
                $scope.store_signage_list.itemsByPage = 1;
            var store_signage_post_information = {
                'store_id': $stateParams.id,
                'limitstart': 0,
                'limitnum': $scope.store_signage_list.itemsByPage,
                'sort_attribute': $scope.store_signage_list.sort.attribute,
                'sort_type': $scope.store_signage_list.sort.type,
                'id': $scope.store_signage_list.search_signage.id,
                'code': $scope.store_signage_list.search_signage.code,
                'category_id': $scope.store_signage_list.search_signage.category_id,
                'email': $scope.store_signage_list.search_signage.email,
                'created': $scope.store_signage_list.search_signage.created,
            };
            if ($scope.store_signage_list.itemsByPage_change_number > 1)
                $scope.store_signage_list.getSignages(store_signage_post_information);
        }, true);

        $scope.store_signage_list.search_change_number = 0;
        $scope.$watch('store_signage_list.search', function () {
            $scope.store_signage_list.search_change_number++;
            var store_signage_post_information = {
                'store_id': $stateParams.id,
                'limitstart': ($scope.store_signage_list.currentPage - 1) * $scope.store_signage_list.itemsByPage,
                'limitnum': $scope.store_signage_list.itemsByPage,
                'sort_attribute': $scope.store_signage_list.sort.attribute,
                'sort_type': $scope.store_signage_list.sort.type,
                'id': $scope.store_signage_list.search_signage.id,
                'code': $scope.store_signage_list.search_signage.code,
                'category_id': $scope.store_signage_list.search_signage.category_id,
                'email': $scope.store_signage_list.search_signage.email,
                'created': $scope.store_signage_list.search_signage.created,
            };
            if ($scope.store_signage_list.search_change_number > 1)
                $scope.store_signage_list.getSignages(store_signage_post_information);
        }, true);

        $scope.store_signage_list.sort = function (sort_attribute) {
            if ($scope.store_signage_list.sort.attribute == sort_attribute)
                if ($scope.store_signage_list.sort.type == 'DESC')
                    $scope.store_signage_list.sort.type = 'ASC';
                else
                    $scope.store_signage_list.sort.type = 'DESC';
            else {
                $scope.store_signage_list.sort.attribute = sort_attribute;
                $scope.store_signage_list.sort.type = 'DESC';
            }
            var post_information = {
                'store_id': $stateParams.id,
                'limitstart': ($scope.store_signage_list.currentPage - 1) * $scope.store_signage_list.itemsByPage,
                'limitnum': $scope.store_signage_list.itemsByPage,
                'sort_attribute': $scope.store_signage_list.sort.attribute,
                'sort_type': $scope.store_signage_list.sort.type,
                'id': $scope.store_signage_list.search_signage.id,
                'code': $scope.store_signage_list.search_signage.code,
                'category_id': $scope.store_signage_list.search_signage.category_id,
                'email': $scope.store_signage_list.search_signage.email,
                'created': $scope.store_signage_list.search_signage.created,
            };
            $scope.store_signage_list.getSignages(post_information);
        };

        $scope.store_signage_list.search = function () {
            store_signage_post_information.category_id = $scope.store_signage_list.search_signage.category_id;
            store_signage_post_information.code = $scope.store_signage_list.search_signage.code;
            store_signage_post_information.email = $scope.store_signage_list.search_signage.email;

            $scope.store_signage_list.getSignages(store_signage_post_information);
            $('#search_signage_final').attr('data-category_id', $scope.store_signage_list.search_signage.category_id);
            $('#search_signage_final').attr('data-code', $scope.store_signage_list.search_signage.code);
        }

        $scope.store_signage_list.removeStoreSignage = function(store_signage_id){
          sweetAlert({
            title: "Are you sure?",
            text: "Store Signage will be deleted?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: true,
            html: true
        },
        function(){
            var information_post = {id: store_signage_id};

            $http.post(BASE_URL + '/storeSignage/delete', information_post)
            .success(function (data) {
                if (data.success) {
//                    swal(data.message, "", "success");
                    $scope.store_signage_list.getSignages(store_signage_post_information);
                }
                else {
                    swal({
                        title: 'Oop...',
                        text: data.message,
                        type: 'error',
                        html: true
                    });
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
  		    });
        }

        $scope.store_signage_list.updateStoreSignage = function(signage){
          $scope.store_signage_form.store_signage = {
            id: signage.store_signage_id,
            store_id: $stateParams.id,
            signage_id: signage.id,
            signage_code: signage.code,
            code: signage.store_signage_code,
            note: signage.store_signage_note,
            signage_quantity: signage.signage_quantity,
          };

        	$('#formStoreSignageModal').modal('show');
        }

        // Popup
        $scope.store_signage_form = {};
        $scope.store_signage_form.store_signage = {
          store_id: $stateParams.id
        };

        $scope.store_signage_form.addStoreSignage = function(){
            $scope.store_signage_form.store_signage = {
                store_id: $scope.store.id,
                signage_id: "",
                signage_code: "",
                code: "",
                note: "",
                signage_quantity: 1,
              };
        	$('#formStoreSignageModal').modal('show');
        }

        $scope.store_signage_form.saveStoreSignage = function(){
            var information_post = $scope.store_signage_form.store_signage;
            $http.post(BASE_URL + '/storeSignage/update', information_post)
            .success(function (data) {
                if (data.success) {
                    swal('Signage saved!', "", "success");
                    $('#formStoreSignageModal').modal('hide');
                    $scope.store_signage_form.store_signage_error = {};
                    $scope.store_signage_list.getSignages(store_signage_post_information);
                }
                else {
                    swal({
                        title: '',
                        text: 'Signage save failed!',
                        type: 'error',
                        html: true
                    });
                    $scope.store_signage_form.store_signage_error = data.errors;
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };

        // Store's fixtures list
        $scope.store_fixture_list = {};
        $scope.store_fixture_list.fixtures = [];
        $scope.store_fixture_list.itemsByPage = 10;
        $scope.store_fixture_list.itemsByPages = [
            {value: 10, name: 10}, 
            {value: 20, name: 20},
            {value: 30, name: 30},
            {
                value: 50,
                name: 50
            },
            {
                value: 100,
                name: 100
            },
        ];
        $scope.store_fixture_list.pages = [];
        $scope.store_fixture_list.currentPage = 1;
        $scope.store_fixture_list.start_fixture = 1;
        $scope.store_fixture_list.end_fixture = 1;
        $scope.store_fixture_list.totalresults = 0;
        $scope.store_fixture_list.sort = {
            attribute: 'created_time',
            type: 'DESC',
        };
        $scope.store_fixture_list.search_fixture = {
            id: '',
            name: '',
            email: '',
            created: '',
            category_id: ''
        };
        var store_fixture_post_information = {
            'store_id': $stateParams.id,
            'limitstart': 0,
            'limitnum': $scope.store_fixture_list.itemsByPage,
            'sort_attribute': $scope.store_fixture_list.sort.attribute,
            'sort_type': $scope.store_fixture_list.sort.type,
        };

        $scope.store_fixture_list.getFixtures = function (store_fixture_post_information) {
            $http.post(BASE_URL + '/storeFixture/getAll', store_fixture_post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.store_fixture_list.totalresults = parseInt(data.totalresults);
                    $scope.store_fixture_list.start_fixture = data.start_fixture;
                    $scope.store_fixture_list.end_fixture = data.end_fixture;
                    $scope.store_fixture_list.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.store_fixture_list.itemsByPage); p++)
                        $scope.store_fixture_list.pages.push(p + 1);
                        $scope.store_fixture_list.fixtures = [];
                        $scope.store_fixture_list.fixtures = data.fixtures;
                    $scope.selectedFixtureIds = [];
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.store_fixture_list.getFixtures(store_fixture_post_information);

        $scope.store_fixture_list.getFixtureCategories = function (post_information) {
            $http.post(BASE_URL + '/fixtureCategory/getAll', [])
            .success(function (data) {
                if (data.success) {
                    $scope.store_fixture_list.fixture_categories = data.fixture_categories;
                }
                else {
                    swal('Can not get fixture category list', '', 'error');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.store_fixture_list.getFixtureCategories(store_fixture_post_information);

        $scope.store_fixture_list.selectPage = function (page) {
            $scope.store_fixture_list.currentPage = page;
            var store_fixture_post_information = {
                'store_id': $stateParams.id,
                'limitstart': (page - 1) * $scope.store_fixture_list.itemsByPage,
                'limitnum': $scope.store_fixture_list.itemsByPage,
                'sort_attribute': $scope.store_fixture_list.sort.attribute,
                'sort_type': $scope.store_fixture_list.sort.type,
                'id': $scope.store_fixture_list.search_fixture.id,
                'code': $scope.store_fixture_list.search_fixture.code,
                'category_id': $scope.store_fixture_list.search_fixture.category_id,
                'email': $scope.store_fixture_list.search_fixture.email,
                'created': $scope.store_fixture_list.search_fixture.created,
            };
            $scope.store_fixture_list.getFixtures(store_fixture_post_information);
        };

        $scope.store_fixture_list.itemsByPage_change_number = 0;
        $scope.$watch('store_fixture_list.itemsByPage', function () {
            $scope.store_fixture_list.itemsByPage_change_number++;
            if ($scope.store_fixture_list.itemsByPage == 0 || $scope.store_fixture_list.itemsByPage == '0' || $scope.store_fixture_list.itemsByPage == '' || $scope.store_fixture_list.itemsByPage == null)
                $scope.store_fixture_list.itemsByPage = 1;
            var store_fixture_post_information = {
                'store_id': $stateParams.id,
                'limitstart': 0,
                'limitnum': $scope.store_fixture_list.itemsByPage,
                'sort_attribute': $scope.store_fixture_list.sort.attribute,
                'sort_type': $scope.store_fixture_list.sort.type,
                'id': $scope.store_fixture_list.search_fixture.id,
                'code': $scope.store_fixture_list.search_fixture.code,
                'category_id': $scope.store_fixture_list.search_fixture.category_id,
                'email': $scope.store_fixture_list.search_fixture.email,
                'created': $scope.store_fixture_list.search_fixture.created,
            };
            if ($scope.store_fixture_list.itemsByPage_change_number > 1)
                $scope.store_fixture_list.getFixtures(store_fixture_post_information);
        }, true);

        $scope.store_fixture_list.search_change_number = 0;
        $scope.$watch('store_fixture_list.search', function () {
            $scope.store_fixture_list.search_change_number++;
            var store_fixture_post_information = {
                'store_id': $stateParams.id,
                'limitstart': ($scope.store_fixture_list.currentPage - 1) * $scope.store_fixture_list.itemsByPage,
                'limitnum': $scope.store_fixture_list.itemsByPage,
                'sort_attribute': $scope.store_fixture_list.sort.attribute,
                'sort_type': $scope.store_fixture_list.sort.type,
                'id': $scope.store_fixture_list.search_fixture.id,
                'code': $scope.store_fixture_list.search_fixture.code,
                'category_id': $scope.store_fixture_list.search_fixture.category_id,
                'email': $scope.store_fixture_list.search_fixture.email,
                'created': $scope.store_fixture_list.search_fixture.created,
            };
            if ($scope.store_fixture_list.search_change_number > 1)
                $scope.store_fixture_list.getFixtures(store_fixture_post_information);
        }, true);

        $scope.store_fixture_list.sort = function (sort_attribute) {
            if ($scope.store_fixture_list.sort.attribute == sort_attribute)
                if ($scope.store_fixture_list.sort.type == 'DESC')
                    $scope.store_fixture_list.sort.type = 'ASC';
                else
                    $scope.store_fixture_list.sort.type = 'DESC';
            else {
                $scope.store_fixture_list.sort.attribute = sort_attribute;
                $scope.store_fixture_list.sort.type = 'DESC';
            }
            var store_fixture_post_information = {
                'store_id': $stateParams.id,
                'limitstart': ($scope.store_fixture_list.currentPage - 1) * $scope.store_fixture_list.itemsByPage,
                'limitnum': $scope.store_fixture_list.itemsByPage,
                'sort_attribute': $scope.store_fixture_list.sort.attribute,
                'sort_type': $scope.store_fixture_list.sort.type,
                'id': $scope.store_fixture_list.search_fixture.id,
                'code': $scope.store_fixture_list.search_fixture.code,
                'category_id': $scope.store_fixture_list.search_fixture.category_id,
                'email': $scope.store_fixture_list.search_fixture.email,
                'created': $scope.store_fixture_list.search_fixture.created,
            };
            $scope.store_fixture_list.getFixtures(store_fixture_post_information);
        };

        $scope.store_fixture_list.search = function () {
            store_fixture_post_information.category_id = $scope.store_fixture_list.search_fixture.category_id;
            store_fixture_post_information.code = $scope.store_fixture_list.search_fixture.code;
            store_fixture_post_information.email = $scope.store_fixture_list.search_fixture.email;

            $scope.store_fixture_list.getFixtures(store_fixture_post_information);
            $('#search_fixture_final').attr('data-category_id', $scope.store_fixture_list.search_fixture.category_id);
            $('#search_fixture_final').attr('data-code', $scope.store_fixture_list.search_fixture.code);
        }

        $scope.store_fixture_list.removeStoreFixture = function(store_fixture_id){
          sweetAlert({
            title: "Are you sure?",
            text: "Store Fixture will be deleted?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: true,
            html: true
        },
        function(){
            var information_post = {id: store_fixture_id};

            $http.post(BASE_URL + '/storeFixture/delete', information_post)
            .success(function (data) {
                if (data.success) {
//                    swal(data.message, "", "success");
                    $scope.store_fixture_list.getFixtures(store_fixture_post_information);
                }
                else {
                    swal({
                        title: 'Oop...',
                        text: data.message,
                        type: 'error',
                        html: true
                    });
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
  		    });
        }

        $scope.store_fixture_list.updateStoreFixture = function(fixture){
          $scope.store_fixture_form.store_fixture = {
            id: fixture.store_fixture_id,
            store_id: $stateParams.id,
            fixture_id: fixture.id,
            fixture_code: fixture.code,
            code: fixture.store_fixture_code,
            note: fixture.store_fixture_note,
          };

        	$('#formStoreFixtureModal').modal('show');
        }

        // Popup
        $scope.store_fixture_form = {};
        $scope.store_fixture_form.store_fixture = {
          store_id: $stateParams.id
        };

        $scope.store_fixture_form.addStoreFixture = function(){
        	$('#formStoreFixtureModal').modal('show');
        }

        $scope.store_fixture_form.saveStoreFixture = function(){
            var information_post = $scope.store_fixture_form.store_fixture;

            $http.post(BASE_URL + '/storeFixture/update', information_post)
            .success(function (data) {
                if (data.success) {
                    swal('Fixture saved!', "", "success");
                    $('#formStoreFixtureModal').modal('hide');
                    $scope.store_fixture_form.store_fixture_error = {};
                    $scope.store_fixture_list.getFixtures(store_fixture_post_information);
                }
                else {
                    swal({
                        title: '',
                        text: 'Fixture save failed!',
                        type: 'error',
                        html: true
                    });
                    $scope.store_fixture_form.store_fixture_error = data.errors;
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export PDF and Email
        $scope.exportPdf = function(){
            $http.get(BASE_URL + '/store/exportPdf?id=' + $scope.store.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Store Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });
                    
                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.initEmail = function () {
            var post_information = {type: 'document'};
            $http.post(BASE_URL + '/email/init', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.email = data.email;
                    $scope.email_title = data.email_title;
                    $scope.email_empty = data.email_empty;
                    $scope.email_error = data.email_error_empty;
                    $scope.email_error_empty = data.email_error_empty;
                }
                else {
                    if (data.type == 'nothing') {
                    }
                    else if (data.type == 'alert') {
                        swal(data.message, "", "error");

                        return false;
                    }
                    else {
                        $state.go('404');
                    }
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.initEmail();
        
        $scope.email = {};
        $scope.email.documents = [];
        $scope.emailFile = function (file) {
            $scope.email.documents = [];
            $scope.email.documents.push(file);
            $scope.$apply();
            $('#sendEmailModal').modal('show');
        }

        $scope.sendEmail = function () {
            var information_post = {'email': $scope.email, 'type': 'document'};
            $http.post(BASE_URL + '/email/send', information_post)
            .success(function (data) {
                if (data.success) {
                    swal(data.message, "", "success");
                    $('#sendEmailModal').modal('hide');
                    $scope.email.content = "";
                    $scope.email.subject = "";
                    $scope.email.to = "";
                }
                else {
                    swal(data.message, "", "error");
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
		// Jquery
		jQuery("[data-widget='collapse']").click(function() {
			//Find the box parent........
			var box = jQuery(this).parents(".box").first();
			//Find the body and the footer
			var bf = box.find(".box-body, .box-footer");
			if (!jQuery(this).children().hasClass("fa-plus")) {
				jQuery(this).children(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
				bf.slideUp();
			} else {
				//Convert plus into minus
				jQuery(this).children(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
				bf.slideDown();
			}
		});
            
        $scope.copySignage = function (signage) {
//            $rootScope.view_detail_signage_id = signage.id;
//            $rootScope.is_copy_signage = true;
//            $state.go('signage-create');
            $http.post(BASE_URL + '/signage/copy', {id: signage.id})
            .success(function (data) {
                if (data.success) {
                    $state.go('signage-detail', {id: data.id});
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.copyFixture = function (fixture) {
//            $rootScope.view_detail_fixture_id = fixture.id;
//            $rootScope.is_copy_fixture = true;
//            $state.go('fixture-create');
            $http.post(BASE_URL + '/fixture/copy', {id: fixture.id})
            .success(function (data) {
                if (data.success) {
                    $state.go('fixture-detail', {id: data.id});
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export Signage PDF and Email
        $scope.exportPdfItemSignage = function(signage){
            $http.get(BASE_URL + '/signage/exportPdf?id=' + signage.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Signage Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export Signage Excel and Email
        $scope.exportExcelItemSignage = function(signage){
            $http.get(BASE_URL + '/signage/exportExcelItem?id=' + signage.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Signage Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.selectedSignageIds = [];
	$scope.toggleSignageSelection = function toggleSignageSelection(id) {
	    var idx = $scope.selectedSignageIds.indexOf(id);

	    if (idx > -1) {
	      $scope.selectedSignageIds.splice(idx, 1);
	    }
	    else {
	      $scope.selectedSignageIds.push(id);
	    }
	};
        
        $scope.exportExcelListSignage = function(type){
            var search_information = 'category_id=' + $('#search_signage_final').attr('data-category_id') 
                                    + '&code=' + $('#search_signage_final').attr('data-code')
                                    + '&store_id=' + $scope.store.id
                                    + '&related_name='+$scope.store.name;
            var post_information = "";
            $( "input[name^='ExportExcelSignageColumn']" ).each(function(i){
                var checkedValue = $(this).prop('checked') ? 1 : 0;
                post_information += encodeURIComponent("ExportExcelColumn[")+$(this).attr('data-column')+encodeURIComponent("]")+"="+checkedValue+"&";
            });
            post_information += search_information;
            if($scope.selectedSignageIds.length){
                post_information += "&ids="+$scope.selectedSignageIds.toString();
            }
            if(typeof type !== 'undefined'){
                post_information += "&type="+type;
            }
            $http.get(BASE_URL + '/signage/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Store's signage DB exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });
                    
                    $('.sweet-alert .email').click(function(){
                        console.log('email')
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export Signage PDF and Email
        $scope.exportPdfItemFixture = function(fixture){
            $http.get(BASE_URL + '/fixture/exportPdf?id=' + fixture.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Fixture Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        if(data.result){
                            $window.open(data.result.file_url);
                        }
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export Signage Excel and Email
        $scope.exportExcelItemFixture = function(fixture){
            $http.get(BASE_URL + '/fixture/exportExcelItem?id=' + fixture.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Fixture Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        if(data.result){
                            $window.open(data.result.file_url);
                        }
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.selectedFixtureIds = [];
	$scope.toggleFixtureSelection = function toggleFixtureSelection(id) {
	    var idx = $scope.selectedFixtureIds.indexOf(id);

	    if (idx > -1) {
	      $scope.selectedFixtureIds.splice(idx, 1);
	    }
	    else {
	      $scope.selectedFixtureIds.push(id);
	    }
	};
        
        $scope.exportExcelListFixture = function(type){
            var search_information = 'category_id=' + $('#search_fixture_final').attr('data-category_id') 
                                    + '&code=' + $('#search_fixture_final').attr('data-code')
                                    + '&store_id=' + $scope.store.id
                                    + '&related_name='+$scope.store.name;
            var post_information = "";
            $( "input[name^='ExportExcelFixtureColumn']" ).each(function(i){
                var checkedValue = $(this).prop('checked') ? 1 : 0;
                post_information += encodeURIComponent("ExportExcelColumn[")+$(this).attr('data-column')+encodeURIComponent("]")+"="+checkedValue+"&";
            });
            post_information += search_information;
            if($scope.selectedFixtureIds.length){
                post_information += "&ids="+$scope.selectedFixtureIds.toString();
            }
            if(typeof type !== 'undefined'){
                post_information += "&type="+type;
            }
            $http.get(BASE_URL + '/fixture/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Store's fixture DB exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });
                    
                    $('.sweet-alert .email').click(function(){
                        console.log('email')
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        if(data.result){
                            $window.open(data.result.file_url);
                        }
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export Excel and Email
        $scope.exportExcel = function(){
            $http.get(BASE_URL + '/store/exportExcelItem?id=' + $scope.store.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Store Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });
                    
                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.delete = function () {
            sweetAlert({
                title: "Are you sure?",
                text: "You will not be able to recover it!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: true
            },
            function(){
                var information_post = {'id': $scope.store.id};
                $http.post(BASE_URL + '/store/delete', information_post)
                .success(function (data) {
                    if (data.success) {
                        swal(data.message, "", "success");
                        swal.close();
                        $state.go('store-list');
                    }
                    else {
                        swal(data.message, "", "error");
                        swal.close();
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            });
        };
    }
]);
