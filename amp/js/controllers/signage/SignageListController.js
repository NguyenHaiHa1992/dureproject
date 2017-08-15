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
            status: '',
            store_id: '',
            group_number: '',
            fixture_id: '',
            general_category_id: '',
            material: '',
            language: ''
        };
        $scope.copy_search_signage = {code: '', category_id: '', description:'', status: '1', 
            store_id: '', fixture_id: '', group_number: '', general_category_id: '', 
            material: '', language: ''};
        var post_information = {
            'limitstart': 0,
            'limitnum': $scope.itemsByPage,
            'sort_attribute': $scope.sort.attribute,
            'sort_type': $scope.sort.type,
            'status': '1',
            'store_id': '',
            'fixture_id': '',
            'group_number': '',
            'general_category_id': '',
            'material': '',
            'language': ''
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
                    
                    $scope.selectedDbIds = [];
                    $scope.general_categories = data.general_categories;
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
                'general_category_id': $scope.search_signage.general_category_id,
                'material': $scope.search_signage.material,
                'language': $scope.search_signage.language,
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
                'general_category_id': $scope.search_signage.general_category_id,
                'material': $scope.search_signage.material,
                'language': $scope.search_signage.language,
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
                'general_category_id': $scope.search_signage.general_category_id,
                'material': $scope.search_signage.material,
                'language': $scope.search_signage.language,
            };
            $scope.getSignages(post_information);
        };

        $scope.search = function () {
            post_information.category_id = $scope.search_signage.category_id;
            post_information.code = $scope.search_signage.code;
            post_information.description = $scope.search_signage.description;
            post_information.status = $scope.search_signage.status;
            post_information.store_id = $scope.search_signage.store_id;
            post_information.fixture_id = $scope.search_signage.fixture_id;
            post_information.group_number = $scope.related_fixtures_groupnumber[$scope.search_signage.fixture_id];
            post_information.general_category_id = $scope.search_signage.general_category_id;
            post_information.material = $scope.search_signage.material;
            post_information.language = $scope.search_signage.language;
            
            $scope.copy_search_signage.category_id = $scope.search_signage.category_id;
            $scope.copy_search_signage.code = $scope.search_signage.code;
            $scope.copy_search_signage.description = $scope.search_signage.description;
            $scope.copy_search_signage.status = $scope.search_signage.status;
            $scope.copy_search_signage.store_id = $scope.search_signage.store_id;
            $scope.copy_search_signage.fixture_id = $scope.search_signage.fixture_id;
            $scope.copy_search_signage.group_number = $scope.related_fixtures_groupnumber[$scope.search_signage.fixture_id];
            $scope.copy_search_signage.general_category_id = $scope.search_signage.general_category_id;
            $scope.copy_search_signage.material = $scope.search_signage.material;
            $scope.copy_search_signage.language = $scope.search_signage.language;
            
            post_information.limitnum = $scope.itemsByPage;
            post_information.sort_attribute = $scope.sort.attribute;
            post_information.sort_type = $scope.sort.typy;
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
            var search_information = '&category_id=' + $scope.copy_search_signage.category_id 
                    + '&general_category_id=' + $scope.copy_search_signage.general_category_id 
                    + '&material=' + $scope.copy_search_signage.material 
                    + '&language=' + $scope.copy_search_signage.language 
                    + '&code=' + $scope.copy_search_signage.code 
                    + '&description=' + $scope.copy_search_signage.description
                    + '&status=' + $scope.copy_search_signage.status
                    + '&store_id=' + $scope.copy_search_signage.store_id 
                    + '&fixture_id=' + $scope.copy_search_signage.fixture_id 
                    + '&group_number=' + $scope.copy_search_signage.group_number;
            var post_information = $('#export-excel-column').serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
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
            var search_information = '&category_id=' + $scope.copy_search_signage.category_id 
                    + '&general_category_id=' + $scope.copy_search_signage.general_category_id
                    + '&material=' + $scope.copy_search_signage.material
                    + '&language=' + $scope.copy_search_signage.language
                    + '&code=' + $scope.copy_search_signage.code 
                    + '&description=' + $scope.copy_search_signage.description
                    + '&status=' + $scope.copy_search_signage.status
                    + '&store_id=' + $scope.copy_search_signage.store_id 
                    + '&fixture_id=' + $scope.copy_search_signage.fixture_id 
                    + '&group_number=' + $scope.copy_search_signage.group_number
                    + '&type=pdf';
            var post_information = $('#export-excel-column').serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
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
        
        $scope.deleteSignage = function (id) {
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
                $http.post(BASE_URL + '/signage/delete', information_post)
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
                        $scope.getSignages(post_information);
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
        
        $scope.copySignage = function (id) {
//            $rootScope.view_detail_signage_id = id;
//            $rootScope.is_copy_signage = true;
//            $state.go('signage-create');
            $http.post(BASE_URL + '/signage/copy', {id: id})
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
        }
		
        // Export PDF and Email
        $scope.exportPdfItem = function(signageId){
            $http.get(BASE_URL + '/signage/exportPdf?id=' + signageId)
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
        $scope.exportExcelItem = function(signageId){
            $http.get(BASE_URL + '/signage/exportExcelItem?id=' + signageId)
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
//            $http.get(BASE_URL + '/storeSignage/getAll?get_stores=1')
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
        
        $scope.related_fixtures = [];
        $scope.related_fixtures_groupnumber = {};
        $scope.getRelatedFixtures = function(){
//            $http.get(BASE_URL + '/fixture/getAll?all_related=1')
            $http.get(BASE_URL + '/fixture/getAll?sort_attribute=code&sort_type=ASC')
            .success(function (data) {
                if (data.success) {
                    angular.forEach(data.fixtures, function(v, i){
                        var itemTmp = {id: v.id, code: v.code};
                        $scope.related_fixtures.push(itemTmp);
                        $scope.related_fixtures_groupnumber[v.id] = v.group_number;
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
        $scope.getRelatedFixtures();
        
        $scope.goRelatedStore = function (id) {
            $rootScope.signageDetail = {
                hash: 'related-store'
            };
            var url = $state.href('signage-detail', {'id': id});
            window.open(url+'#related-store', '_blank');
        };
        
        // Import excel
        $scope.uploaded_file = null;
	$scope.importObject = function () {
            var file = $scope.uploaded_file;
            if (file) {
                swal({
                    title: "Signage DB Import Option",
                    text: "<button class='email bg-green'><i class='fa fa-plus'></i> New signage</button> \n\
                            <button class='download bg-blue'><i class='fa fa-edit'></i> Update signage</button>\n\
                            <br><br><p>NOTE: Please use the sample file to list all signages you want to Add/Update with all info. \n\
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
                $http.post(BASE_URL + '/signage/importObject', fd, {
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
                    $scope.signages.unshift(v);
                });
            }
            else{
                $.each($scope.signages, function (si, sv) {
                    $.each(list_objects, function (di, dv) {
                        if(sv.code && sv.code.toString() === dv.code.toString()){
                            $scope.signages[si] = dv;
                        }
                    });
                });
            }
        };
    }
]);
