angular.module('app').controller('SignageViewController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window', 
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window) {
        $scope.root = $rootScope;
        $scope.init_loaded = true;

        $scope.getSignageById = function () {
            $http.post(BASE_URL + '/signage/getSignageById', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.signage = data.signage;
                    $scope.signage_code = $scope.signage.signage_code;
                    $scope.signage_error = data.signage_error;
                    
                    $scope.fsPagination.getParams.group_number = data.signage.group_number;
                    $scope.getFixturePagination(data.signage.fsPagination);
                    $scope.fsPagination.categories = data.signage.related_fixtures_categories;
                    $scope.getStorePagination(data.signage.storePagination);
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getSignageById();
        
        // Export PDF and Email
        $scope.exportPdf = function(){
            $http.get(BASE_URL + '/signage/exportPdf?id=' + $scope.signage.id)
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
        
        // Export Excel and Email
        $scope.exportExcel = function(){
            $http.get(BASE_URL + '/signage/exportExcelItem?id=' + $scope.signage.id)
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
        
        $scope.itemsByPages = [
            {
                value: 10,
                name: 10
            },
            {
                value: 20,
                name: 20
            },
            {
                value: 30,
                name: 30
            },
            {
                value: 50,
                name: 50
            },
            {
                value: 100,
                name: 100
            },
        ];
        
        // fixtures
        $scope.exportExcelListFixture = function(type){
            var post_information = "";
            $( "input[name^='ExportExcelFixtureColumn']" ).each(function(i){
                var checkedValue = $(this).prop('checked') ? 1 : 0;
                post_information += encodeURIComponent("ExportExcelColumn[")+$(this).attr('data-column')+encodeURIComponent("]")+"="+checkedValue+"&";
            });
//            if($scope.selectedFixtureIds.length){
//                post_information += "&ids="+$scope.selectedFixtureIds.toString();
//            }
//            else if($scope.signage.related_fixtures.length){
            if($scope.signage.related_fixtures.length){
                var rfIds = [];
                angular.forEach($scope.signage.related_fixtures, function(v,i){
                    rfIds.push(v.id);
                });
                post_information += "&ids="+rfIds.toString();
            }
            post_information += "&related_name="+$scope.signage.code;
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
                            swal.close();
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
        
        // pagination for Fixture
        $scope.fsPagination = {
            itemsByPage_change_number: 0,
            fsByPage: 10,
            start: 0,
            end: 0,
            totalresults: 0,
            pages: [],
            currentPage: 1,
            selectPage: null,
            getFixtures: null,
            getParams: {
                limitstart: 0,
                limitnum: 10,
                group_number: "",
                category_id: 0,
                code: "",
            },
            categories: [],
        };
        
        $scope.getFixturePagination = function(data){
            $scope.fsPagination.start = data.start_fixture;
            $scope.fsPagination.end = data.end_fixture;
            $scope.fsPagination.totalresults = data.totalresults;
            $scope.fsPagination.pages = [];
            for (var p = 0; p < Math.ceil(data.totalresults / $scope.fsPagination.fsByPage); p++)
                $scope.fsPagination.pages.push(p + 1);
        };
        
        $scope.$watch('fsPagination.fsByPage', function () {
            $scope.fsPagination.itemsByPage_change_number++;
            if ($scope.fsPagination.fsByPage == 0 || $scope.fsPagination.fsByPage == '0' || $scope.fsPagination.fsByPage == '' || $scope.fsPagination.fsByPage == null)
                $scope.fsPagination.fsByPage = 1;
            $scope.fsPagination.getParams.limitstart = 0;
            $scope.fsPagination.getParams.limitnum = $scope.fsPagination.fsByPage;
            if ($scope.fsPagination.itemsByPage_change_number > 1)
                $scope.fsPagination.getFixtures();
        }, true);
        
        $scope.fsPagination.getFixtures = function(){
            $http.post(BASE_URL + '/fixture/getAll', $scope.fsPagination.getParams)
            .success(function (data) {
                if (data.success) {
                    $scope.getFixturePagination(data);
                    $scope.signage.related_fixtures = [];
                    $scope.signage.related_fixtures = data.fixtures;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        }
        
        $scope.fsPagination.selectPage = function(page){
            $scope.fsPagination.currentPage = page;
            $scope.fsPagination.getParams.limitstart = (parseInt(page) - 1) * parseInt($scope.fsPagination.fsByPage);
            $scope.fsPagination.getFixtures();
        };
        
        // stores
        $scope.exportExcelListStore = function(type){
            var search_information = 'tier_id=' + $('#search_store_final').attr('data-tier_id') 
                                    + '&name=' + $('#search_store_final').attr('data-name')
                                    + '&country=' + $('#search_store_final').attr('data-country')
                                    + '&signage_id=' + $stateParams.id
                                    + '&related_name='+$scope.signage.name;
            var post_information = "";
            $( "input[name^='ExportStoreExcelColumn']" ).each(function(i){
                var checkedValue = $(this).prop('checked') ? 1 : 0;
                post_information += encodeURIComponent("ExportExcelColumn[")+$(this).attr('data-column')+encodeURIComponent("]")+"="+checkedValue+"&";
            });
            post_information += search_information;
//            if($scope.selectedStoreIds.length){
//                post_information += "&ids="+$scope.selectedStoreIds.toString();
//            }
            if(typeof type !== 'undefined'){
                post_information += "&type="+type;
            }
            $http.get(BASE_URL + '/store/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Related store DB exported",
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
        
        $scope.getTiers = function () {
            $http.post(BASE_URL + '/tier/getAll', [])
            .success(function (data) {
                if (data.success) {
                    $scope.tiers = data.tiers;
                }
                else {
                    swal('Can not get tier list', '', 'error');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getTiers();
        
        $scope.search_store = {
            signage_id: $stateParams.id,
            id: '',
            tier_id: '',
            name: '',
            country: '',
            limitstart: 0,
            limitnum: 10,
        };
        
        $scope.searchStore = function(){
            $scope.getStores($scope.search_store);
            $('#search_store_final').attr('data-tier_id', $scope.search_store.tier_id);
            $('#search_store_final').attr('data-name', $scope.search_store.name);
            $('#search_store_final').attr('data-country', $scope.search_store.country);
        };
        
        $scope.getStores = function (post_information) {
            $http.post(BASE_URL + '/store/getAll', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.getStorePagination(data);
                    $scope.signage.related_stores = data.stores;
                    $scope.selectedStoreIds = [];
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // pagination for Store
        $scope.storePagination = {
            itemsByPage_change_number: 0,
            fsByPage: 10,
            start: 0,
            end: 0,
            totalresults: 0,
            pages: [],
            currentPage: 1,
            selectPage: null,
        };
        
        $scope.getStorePagination = function(data){
            $scope.storePagination.start = data.start_store;
            $scope.storePagination.end = data.end_store;
            $scope.storePagination.totalresults = data.totalresults;
            $scope.storePagination.pages = [];
            for (var p = 0; p < Math.ceil(data.totalresults / $scope.storePagination.fsByPage); p++)
                $scope.storePagination.pages.push(p + 1);
        };
        
        $scope.$watch('storePagination.fsByPage', function () {
            $scope.storePagination.itemsByPage_change_number++;
            if ($scope.storePagination.fsByPage == 0 || $scope.storePagination.fsByPage == '0' || $scope.storePagination.fsByPage == '' || $scope.storePagination.fsByPage == null)
                $scope.storePagination.fsByPage = 1;
            $scope.search_store.limitstart = 0;
            $scope.search_store.limitnum = $scope.storePagination.fsByPage;
            if ($scope.storePagination.itemsByPage_change_number > 1)
                $scope.searchStore();
        }, true);
        
        $scope.storePagination.selectPage = function(page){
            $scope.storePagination.currentPage = page;
            $scope.search_store.limitstart = (parseInt(page) - 1) * parseInt($scope.storePagination.fsByPage);
            $scope.searchStore();
        };
    }
]);
