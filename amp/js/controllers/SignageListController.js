angular.module('app').controller('SignageListController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $window) {
        $scope.root = $rootScope;
        $scope.signages = [];
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
        ];
        $scope.pages = [];
        $scope.currentPage = 1;
        $scope.start_signage = 1;
        $scope.end_signage = 1;
        $scope.totalresults = 0;
        $scope.sort = {
            attribute: 'created_time',
            type: 'DESC',
        };
        $scope.search_signage = {
            id: '',
            created: '',
            category_id: '',
            code: '',
            description: '',
            status: '1'
        };
        $scope.copy_search_signage = {code: '', category_id: '', description:'', status: '1'};
        var post_information = {
            'limitstart': 0,
            'limitnum': $scope.itemsByPage,
            'sort_attribute': $scope.sort.attribute,
            'sort_type': $scope.sort.type,
        };

        $scope.getSignages = function (post_information) {
            $http.post(BASE_URL + '/signage/getAll', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.totalresults = parseInt(data.totalresults);
                    $scope.start_signage = data.start_signage;
                    $scope.end_signage = data.end_signage;
                    $scope.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                        $scope.pages.push(p + 1);
                    //$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
                    $scope.signages = [];
                    $scope.signages = data.signages;
                    // for(var i= 0; i< data.signages.length; i++)
                    // $scope.signages.push(data.email_templates[i]);
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getSignages(post_information);

        $scope.getSignageCategories = function (post_information) {
            $http.post(BASE_URL + '/signageCategory/getAll', [])
            .success(function (data) {
                if (data.success) {
                    $scope.signage_categories = data.signage_categories;
                }
                else {
                    swal('Can not get signage category list', '', 'error');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getSignageCategories(post_information);

        $scope.selectPage = function (page) {
            $scope.currentPage = page;
            var post_information = {
                'limitstart': (page - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_signage.id,
                'category_id': $scope.search_signage.category_id,
                'code': $scope.search_signage.code,
                'description': $scope.search_signage.description,
                'status': $scope.search_signage.status,
                'created': $scope.search_signage.created,
            };
            $scope.getSignages(post_information);
        };

        $scope.itemsByPage_change_number = 0;
        $scope.$watch('itemsByPage', function () {
            $scope.itemsByPage_change_number++;
            if ($scope.itemsByPage == 0 || $scope.itemsByPage == '0' || $scope.itemsByPage == '' || $scope.itemsByPage == null)
                $scope.itemsByPage = 1;
            var post_information = {
                'limitstart': 0,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_signage.id,
                'category_id': $scope.search_signage.category_id,
                'code': $scope.search_signage.code,
                'status': $scope.search_signage.status,
                'description': $scope.search_signage.description,
                'created': $scope.search_signage.created,
            };
            if ($scope.itemsByPage_change_number > 1)
                $scope.getSignages(post_information);
        }, true);

        $scope.search_change_number = 0;
        $scope.$watch('search', function () {
            $scope.search_change_number++;
            var post_information = {
                'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_signage.id,
                'category_id': $scope.search_signage.category_id,
                'code': $scope.search_signage.code,
                'status': $scope.search_signage.status,
                'description': $scope.search_signage.description,
                'created': $scope.search_signage.created,
            };
            if ($scope.search_change_number > 1)
                $scope.getSignages(post_information);
        }, true);

        $scope.sort = function (sort_attribute) {
            if ($scope.sort.attribute == sort_attribute)
                if ($scope.sort.type == 'DESC')
                    $scope.sort.type = 'ASC';
                else
                    $scope.sort.type = 'DESC';
            else {
                $scope.sort.attribute = sort_attribute;
                $scope.sort.type = 'DESC';
            }
            var post_information = {
                'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_signage.id,
                'category_id': $scope.search_signage.category_id,
                'code': $scope.search_signage.code,
                'status': $scope.search_signage.status,
                'description': $scope.search_signage.description,
                'created': $scope.search_signage.created,
            };
            $scope.getSignages(post_information);
        };

        $scope.search = function () {
            post_information.category_id = $scope.search_signage.category_id;
            post_information.code = $scope.search_signage.code;
            post_information.description = $scope.search_signage.description;
            post_information.status = $scope.search_signage.status;

            $scope.copy_search_signage.category_id = $scope.search_signage.category_id;
            $scope.copy_search_signage.code = $scope.search_signage.code;
            $scope.copy_search_signage.description = $scope.search_signage.description;
            $scope.copy_search_signage.status = $scope.search_signage.status;

            $scope.getSignages(post_information);
        }
        
        $scope.resetSearch = function(){
            $scope.search_signage = {};
            $scope.search_signage.status = '1';
            $scope.search();
        }
        
        // Filter show hide colums
        $('#export-excel-column').find('input').change(function(){
            var text = $(this).parent().text().trim();
            var table = $('#example2');
            var j;

            table.find('thead').find('th').each(function(i,v){
                if($(v).text().trim() === text){
                    j = i;
                }
            });

            if($(this).is(":checked")){
                table.find('thead').find('th').eq(j).show();
                table.find('tfoot').find('th').eq(j).show();
                $('tr td:nth-child('+(j+1)+')', table).show();
            }
            else{
                table.find('thead').find('th').eq(j).hide();
                table.find('tfoot').find('th').eq(j).hide();
                $('tr td:nth-child('+(j+1)+')', table).hide();
            }
        });
        
        $scope.exportExcel = function(){
            var search_information = '&category_id=' + $scope.copy_search_signage.category_id + '&code=' + $scope.copy_search_signage.code + '&description=' + $scope.copy_search_signage.description;
            var post_information = $('#export-excel-column').serialize() + search_information;
            $http.get(BASE_URL + '/signage/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Signage DB exported",
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

        $scope.exportPdf = function(){
            var search_information = '&category_id=' + $scope.copy_search_signage.category_id + '&name=' + $scope.copy_search_signage.name + '&city=' + $scope.copy_search_signage.city + '&email=' + $scope.copy_search_signage.email + '&type=pdf';
            var post_information = $('#export-excel-column').serialize() + search_information;
            $http.get(BASE_URL + '/signage/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Signage DB exported",
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

		$('.dropdown-menu').click(function(e) {
			e.stopPropagation();
		});
    }
]);
