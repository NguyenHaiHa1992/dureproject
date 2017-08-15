angular.module('app').controller('StoreSignageController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $window) {
        $scope.root = $rootScope;
        $scope.signages = [];
        $scope.totalresults = 0;
        $scope.start_item = 0;
        $scope.end_item = 0;
        $scope.initFn = function(){
             $http.get(BASE_URL + '/storeSignage/initStoreSignage')
            .success(function (data) {
                if (data.success) {
                    $scope.signage_categories = data.signage_categories;
                    $scope.general_categories = data.general_categories;
                    $scope.tiers = data.tiers;
                    $scope.languages = data.languages;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.initFn();
        
        $scope.currentPage = 1;
        $scope.pages = [];
        $scope.itemsByPage = 10;
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
            }
        ];
        
        $scope.search_signage = {
            id: '',
            created: '',
            category_id: '',
            code: '',
            description: '',
            status: 1,
            store_id: '',
            group_number: '',
            fixture_id: '',
            general_category_id: '',
            store_number: '',
            store_name: '',
            city: '',
            tier_id: '',
            province: '',
            material: '',
            language: '',
            limitstart: 0,
            limitnum: ''
        };
        $scope.copy_search_signage = {
            id: '',
            created: '',
            category_id: '',
            code: '',
            description: '',
            status: 1,
            store_id: '',
            group_number: '',
            fixture_id: '',
            general_category_id: '',
            store_number: '',
            store_name: '',
            city: '',
            tier_id: '',
            province: '',
            material: '',
            language: '',
            limitstart: 0,
            limitnum: ''
        };
        
        $scope.search = function () {
            var post_information = $scope.search_signage;
            $scope.getSignages(post_information);
            $scope.copy_search_signage = post_information;
        }
        
        $scope.resetSearch = function(){
            $scope.search_signage = {};
            $scope.signages = [];
            $scope.pages = [];
            $scope.selectedDbIds = [];
            $scope.totalresults = 0;
            $scope.start_item = 0;
            $scope.end_item = 0;
        }
        
        $scope.getSignages = function (post_information) {
            $http.post(BASE_URL + '/storeSignage/getStoreSignage', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.totalresults = parseInt(data.totalresults);
                    $scope.start_item = data.start_item;
                    $scope.end_item = data.end_item;
                    $scope.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                        $scope.pages.push(p + 1);
                    
                    $scope.signages = [];
                    $scope.signages = data.signages;
                    $scope.selectedDbIds = [];
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // select box
        $scope.selectedDbIds = [];
	$scope.toggleDbSelection = function toggleDbSelection(id) {
	    var idx = $scope.selectedDbIds.indexOf(id);

	    if (idx > -1) {
	      $scope.selectedDbIds.splice(idx, 1);
	    }
	    else {
	      $scope.selectedDbIds.push(id);
	    }
	};
        
        $scope.exportExcel = function(type, is_store){
            var search_information = '&general_category_id=' + $scope.copy_search_signage.general_category_id 
                    + '&category_id=' + $scope.copy_search_signage.category_id 
                    + '&code=' + $scope.copy_search_signage.code
                    + '&store_number=' + $scope.copy_search_signage.store_number
                    + '&store_name=' + $scope.copy_search_signage.store_name
                    + '&city=' + $scope.copy_search_signage.city
                    + '&province=' + $scope.copy_search_signage.province
                    + '&material=' + $scope.copy_search_signage.material
                    + '&language=' + $scope.copy_search_signage.language
                    + '&tier_id=' + $scope.copy_search_signage.tier_id
                    + '&store_id=' + $scope.copy_search_signage.store_id 
                    + '&fixture_id=' + $scope.copy_search_signage.fixture_id 
                    + '&description=' + $scope.copy_search_signage.description
                    + '&type=' + type;
            var exportExcelColumn = 'export-excel-column';
            if(is_store){
                exportExcelColumn = 'export-excel-column-store';
                search_information += '&is_store=1';
            }
            var post_information = $('#'+exportExcelColumn).serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
            $http.get(BASE_URL + '/storeSignage/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Store signage DB exported",
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
        
        // pagination
        $scope.itemsByPage_change_number = 0;
        $scope.$watch('itemsByPage', function () {
            $scope.itemsByPage_change_number++;
            if ($scope.itemsByPage == 0 || $scope.itemsByPage == '0' || $scope.itemsByPage == '' || $scope.itemsByPage == null)
                $scope.itemsByPage = 1;
            var post_information = $scope.search_signage;
            post_information.limitstart = 0;
            post_information.limitnum = $scope.itemsByPage;
            
            if ($scope.itemsByPage_change_number > 1){
                $scope.getSignages(post_information);
//                $scope.copy_search_signage = post_information;
            }
        }, true);
        
        $scope.selectPage = function (page) {
            $scope.currentPage = page;
            var post_information = $scope.search_signage;
            post_information.limitstart = (page - 1) * $scope.itemsByPage;
            post_information.limitnum = $scope.itemsByPage;
            $scope.getSignages(post_information);
        };
        
        
        //email
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
    }
    
]);