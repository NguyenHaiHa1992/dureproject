angular.module('app').controller('FixtureListController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $window) {
        $scope.root = $rootScope;
        $scope.fixtures = [];
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
            },
        ];
        $scope.pages = [];
        $scope.currentPage = 1;
        $scope.start_fixture = 1;
        $scope.end_fixture = 1;
        $scope.totalresults = 0;
        $scope.sort = {
            attribute: 'created_time',
            type: 'DESC',
        };
        $scope.search_fixture = {
            id: '',
            name: '',
            email: '',
            created: '',
            category_id: '',
            code: '',
            description: '',
            store_id: '',
            signage_id: '',
            group_number: '',
            general_category_id: '',
        };
        $scope.copy_search_fixture = {code: '', category_id: '', description:'', store_id: '', 
            signage_id: '', group_number: '', general_category_id: ''};
        var post_information = {
            'limitstart': 0,
            'limitnum': $scope.itemsByPage,
            'sort_attribute': $scope.sort.attribute,
            'sort_type': $scope.sort.type,
            'store_id': '',
            'signage_id': '',
            'group_number': '',
            'general_category_id': ''
        };

        $scope.getFixtures = function (post_information) {
            $http.post(BASE_URL + '/fixture/getAll', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.totalresults = parseInt(data.totalresults);
                    $scope.start_fixture = data.start_fixture;
                    $scope.end_fixture = data.end_fixture;
                    $scope.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                        $scope.pages.push(p + 1);
                    //$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
                    $scope.fixtures = [];
                    $scope.fixtures = data.fixtures;
                    // for(var i= 0; i< data.fixtures.length; i++)
                    // $scope.fixtures.push(data.email_templates[i]);
                    
                    $scope.selectedDbIds = [];
                    $scope.general_categories = data.general_categories;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getFixtures(post_information);

        $scope.getFixtureCategories = function (post_information) {
            $http.post(BASE_URL + '/fixtureCategory/getAll', [])
            .success(function (data) {
                if (data.success) {
                    $scope.fixture_categories = data.fixture_categories;
                }
                else {
                    swal('Can not get fixture category list', '', 'error');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getFixtureCategories(post_information);

        $scope.selectPage = function (page) {
            $scope.currentPage = page;
            var post_information = {
                'limitstart': (page - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_fixture.id,
                'category_id': $scope.search_fixture.category_id,
                'code': $scope.search_fixture.code,
                'description': $scope.search_fixture.description,
                'created': $scope.search_fixture.created,
            };
            $scope.getFixtures(post_information);
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
                'id': $scope.search_fixture.id,
                'category_id': $scope.search_fixture.category_id,
                'code': $scope.search_fixture.code,
                'description': $scope.search_fixture.description,
                'created': $scope.search_fixture.created,
            };
            if ($scope.itemsByPage_change_number > 1)
                $scope.getFixtures(post_information);
        }, true);

        $scope.search_change_number = 0;
        $scope.$watch('search', function () {
            $scope.search_change_number++;
            var post_information = {
                'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_fixture.id,
                'category_id': $scope.search_fixture.category_id,
                'code': $scope.search_fixture.code,
                'description': $scope.search_fixture.description,
                'created': $scope.search_fixture.created,
            };
            if ($scope.search_change_number > 1)
                $scope.getFixtures(post_information);
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
                'category_id': $scope.search_fixture.category_id,
                'code': $scope.search_fixture.code,
                'description': $scope.search_fixture.description,
                'created': $scope.search_fixture.created,
            };
            $scope.getFixtures(post_information);
        };

        $scope.search = function () {
            post_information.category_id = $scope.search_fixture.category_id;
            post_information.code = $scope.search_fixture.code;
            post_information.description = $scope.search_fixture.description;
            post_information.store_id = $scope.search_fixture.store_id;
            post_information.signage_id = $scope.search_fixture.signage_id;
            post_information.group_number = $scope.related_signages_groupnumber[$scope.search_fixture.signage_id];
            post_information.general_category_id = $scope.search_fixture.general_category_id;

            $scope.copy_search_fixture.category_id = $scope.search_fixture.category_id;
            $scope.copy_search_fixture.code = $scope.search_fixture.code;
            $scope.copy_search_fixture.description = $scope.search_fixture.description;
            $scope.copy_search_fixture.store_id = $scope.search_fixture.store_id;
            $scope.copy_search_fixture.signage_id = $scope.search_fixture.signage_id;
            $scope.copy_search_fixture.group_number = $scope.related_signages_groupnumber[$scope.search_fixture.signage_id];
            $scope.copy_search_fixture.general_category_id = $scope.search_fixture.general_category_id;
            
            $scope.getFixtures(post_information);
        }
        
        $scope.resetSearch = function(){
            $scope.search_fixture = {};
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
            var search_information = '&category_id=' + $scope.copy_search_fixture.category_id 
                    + '&code=' + $scope.copy_search_fixture.code 
                    + '&description=' + $scope.copy_search_fixture.description
                    + '&store_id=' + $scope.copy_search_fixture.store_id
                    + '&group_number=' + $scope.copy_search_fixture.group_number;
            var post_information = $('#export-excel-column').serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
            $http.get(BASE_URL + '/fixture/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Fixture DB exported",
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
            var search_information = '&category_id=' + $scope.copy_search_fixture.category_id 
                    + '&code=' + $scope.copy_search_fixture.code 
                    + '&description=' + $scope.copy_search_fixture.description
                    + '&store_id=' + $scope.copy_search_fixture.store_id
                    + '&group_number=' + $scope.copy_search_fixture.group_number 
                    + '&type=pdf';
            var post_information = $('#export-excel-column').serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
            $http.get(BASE_URL + '/fixture/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Fixture DB exported",
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
        
        $scope.deleteFixture = function (id) {
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
                var information_post = {'id': id};
                $http.post(BASE_URL + '/fixture/delete', information_post)
                .success(function (data) {
                    if (data.success) {
                        swal(data.message, "", "success");
                        var post_information = {
                            'limitstart': 0,
                            'limitnum': $scope.itemsByPage,
                            'sort_attribute': $scope.sort.attribute,
                            'sort_type': $scope.sort.type,
                        };
                        swal.close();
                        $scope.getFixtures(post_information);
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
        
        $scope.copyFixture = function (id) {
//            $rootScope.view_detail_fixture_id = id;
//            $rootScope.is_copy_fixture = true;
//            $state.go('fixture-create');
            $http.post(BASE_URL + '/fixture/copy', {id: id})
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
        }
		
       // Export PDF and Email
        $scope.exportPdfItem = function(fixtureId){
            $http.get(BASE_URL + '/fixture/exportPdf?id=' + fixtureId)
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
        $scope.exportExcelItem = function(fixtureId){
            $http.get(BASE_URL + '/fixture/exportExcelItem?id=' + fixtureId)
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
        
        // search relate
        $scope.related_stores = [];
        $scope.getRelatedStores = function(){
//            $http.get(BASE_URL + '/storeFixture/getAll?get_stores=1')
            $http.get(BASE_URL + '/store/getAll?sort_attribute=name&sort_type=ASC')
            .success(function (data) {
                if (data.success) {
//                    var tmpList = [];
                    angular.forEach(data.stores, function(v, i){
                        var itemTmp = {id: v.id, name: v.name};
//                        var idTmp = tmpList.indexOf(v.id);
//                        if(idTmp === -1){
//                            tmpList.push(v.id);
                            $scope.related_stores.push(itemTmp);
//                        }
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
        //$scope.getRelatedStores();
        
        $scope.related_signages = [];
        $scope.related_signages_groupnumber = {};
        $scope.getRelatedSignages = function(){
//            $http.get(BASE_URL + '/signage/getAll?all_related=1')
            $http.get(BASE_URL + '/signage/getAll?sort_attribute=code&sort_type=ASC')
            .success(function (data) {
                if (data.success) {
                    angular.forEach(data.signages, function(v, i){
                        var itemTmp = {id: v.id, code: v.code};
                        $scope.related_signages.push(itemTmp);
                        $scope.related_signages_groupnumber[v.id] = v.group_number;
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
        //$scope.getRelatedSignages();
        
        // Import excel
        $scope.uploaded_file = null;
	$scope.importObject = function () {
            var file = $scope.uploaded_file;
            if (file) {
                swal({
                    title: "Fixture DB Import Option",
                    text: "<button class='email bg-green'><i class='fa fa-plus'></i> New fixture</button> \n\
                            <button class='download bg-blue'><i class='fa fa-edit'></i> Update fixture</button>\n\
                            <br><br><p>NOTE: Please use the sample file to list all fixtures you want to Add/Update with all info. \n\
                                Please check the file carefully before importing since this action cannot be reversed.</p>",
                    type: "info",
                    showConfirmButton: false,
                    showCancelButton: true,
                    closeOnCancel: true,
                    html: true,
                });
                $('.sweet-alert .email').click(function(){
                    $scope.importProcess(file, "new");
                });

                $('.sweet-alert .download').click(function(){
                    $scope.importProcess(file, "update");
                });
            } else {
                swal('Please select XLS or XLSX or CSV file', "", "error");
            }
        };
        
        $scope.importProcess = function(file, option){
            // Validate file
            var file_name = file.name;
            var ext = file_name.substring(file_name.lastIndexOf('.') + 1).toLowerCase();

            if (ext == 'xls' || ext == 'xlsx' || ext == 'csv') {
                var fd = new FormData();
                fd.append('uploaded_file', file);
                fd.append('option', option);
                $http.post(BASE_URL + '/fixture/importObject', fd, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                })
                .success(function (data) {
                    if (data.success) {
                        swal(data.message, "", "success");
                    } else {
                        swal({
                            title: "Import finished but some rows dismissed",
                            text: data.message,
                            html: true
                        });
                    }
                    if(data.list_objects){
                        $scope.updateAfterImport(option, data.list_objects);
                    }
                })
                .error(function () {
                });
            } else {
                swal('Wrong format. Please select XLS or XLSX or CSV format', "", "error");
            }
        };
        
        $scope.updateAfterImport = function(option, list_objects){
            if(option === "new"){
                $.each(list_objects, function (i, v) {
                    $scope.fixtures.unshift(v);
                });
            }
            else{
                $.each($scope.fixtures, function (si, sv) {
                    $.each(list_objects, function (di, dv) {
                        if(sv.code && sv.code.toString() === dv.code.toString()){
                            $scope.fixtures[si] = dv;
                        }
                    });
                });
            }
        };
    }
]);
