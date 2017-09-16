angular.module('app').controller('ProjectListController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $window) {
	$scope.root = $rootScope;
        $scope.projects = [];
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
        $scope.start_project = 1;
        $scope.end_project = 1;
        $scope.totalresults = 0;
        $scope.sort = {
            attribute: 'created_time',
            type: 'DESC',
        };
        $scope.search_project = {
            id: '',
            name: '',
            email: '',
            created: '',
        };
        $scope.copy_search_project = {
            name: '',
            email: '',
        };
        var post_information = {
            'limitstart': 0,
            'limitnum': $scope.itemsByPage,
            'sort_attribute': $scope.sort.attribute,
            'sort_type': $scope.sort.type,
        };

        //config attributes sortting
        $scope.sorts = [
            {
                'attribute': 'primary_contact' ,
                'label' : 'Primary Contact',
            },
//            {
//                'attribute': 'customer_id' ,
//                'label' : 'Customer',
//            },
            {
                'attribute': 'project_number' ,
                'label' : 'Project Number',
            },
            {
                'attribute': 'volume' ,
                'label' : 'Volume',
            },
            {
                'attribute': 'service' ,
                'label' : 'Service',
            },
        ];

        $scope.getProjects = function (post_information) {
            $http.post(BASE_URL + '/project/getAll', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.totalresults = parseInt(data.totalresults);
                    $scope.start_project = data.start_project;
                    $scope.end_project = data.end_project;
                    $scope.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                        $scope.pages.push(p + 1);
                    $scope.projects = [];
                    $scope.projects = data.projects;
                    
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
        $scope.getProjects(post_information);

        $scope.selectPage = function (page) {
            $scope.currentPage = page;
            var post_information = {
                'limitstart': (page - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_project.id,
            };
            $scope.getProjects(post_information);
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
                'id': $scope.search_project.id,
                'created': $scope.search_project.created,
            };
            if ($scope.itemsByPage_change_number > 1)
                $scope.getProjects(post_information);
        }, true);

        $scope.search_change_number = 0;
        $scope.$watch('search', function () {
            $scope.search_change_number++;
            var post_information = {
                'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_project.id,
                'created': $scope.search_project.created,
            };
            if ($scope.search_change_number > 1)
                $scope.getProjects(post_information);
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
                'id': $scope.search_project.id,
                'created': $scope.search_project.created,
            };
            $scope.getProjects(post_information);
        };

        $scope.search = function () {
            post_information.ship_to = $scope.search_project.ship_to;
            post_information.ship_oa = $scope.search_project.ship_oa;
            post_information.ship_address = $scope.search_project.ship_address;
            post_information.bill_to = $scope.search_project.bill_to;
            post_information.bill_oa = $scope.search_project.bill_oa;
            post_information.bill_address = $scope.search_project.bill_address;
            post_information.phone = $scope.search_project.phone;
            post_information.fax = $scope.search_project.fax;
            
            $scope.copy_search_project.ship_to = $scope.search_project.ship_to;
            $scope.copy_search_project.ship_oa = $scope.search_project.ship_oa;
            $scope.copy_search_project.ship_address = $scope.search_project.ship_address;
            $scope.copy_search_project.bill_to = $scope.search_project.bill_to;
            $scope.copy_search_project.bill_oa = $scope.search_project.bill_oa;
            $scope.copy_search_project.bill_address = $scope.search_project.bill_address;
            post_information.phone = $scope.search_project.phone;
            post_information.fax = $scope.search_project.fax;
            $scope.getProjects(post_information);
        }

        $scope.resetSearch = function(){
            $scope.search_project = {};
            $scope.search();
        }

        $scope.viewDetai = function (project_id) {
            $rootScope.view_detail_project_id = project_id;
            $state.go('project-create');
        };
        
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
            var search_information = '&tier_id=' + $scope.copy_search_project.tier_id 
                    + '&name=' + $scope.copy_search_project.name 
                    + '&city=' + $scope.copy_search_project.city 
                    + '&email=' + $scope.copy_search_project.email
                    + '&signage_id=' + $scope.copy_search_project.signage_id
                    + '&fixture_id=' + $scope.copy_search_project.fixture_id;
            var post_information = $('#export-excel-column').serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
            $http.get(BASE_URL + '/project/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Project DB exported",
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
        
        $scope.exportPdf = function(){
            var search_information = '&tier_id=' + $scope.copy_search_project.tier_id 
                    + '&name=' + $scope.copy_search_project.name 
                    + '&city=' + $scope.copy_search_project.city 
                    + '&email=' + $scope.copy_search_project.email
                    + '&signage_id=' + $scope.copy_search_project.signage_id
                    + '&fixture_id=' + $scope.copy_search_project.fixture_id
                    + '&type=pdf';
            var post_information = $('#export-excel-column').serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
            $http.get(BASE_URL + '/project/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Project DB exported",
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
        
        $scope.deleteProject = function (id) {
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
                $http.post(BASE_URL + '/project/delete', information_post)
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
                        $scope.getProjects(post_information);
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
        
        $scope.copyProject = function (id) {
            $http.post(BASE_URL + '/project/copy', {id: id})
            .success(function (data) {
                if (data.success) {
                    $state.go('project-detail', {id: data.id});
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
        $scope.exportPdfItem = function(projectId){
            $http.get(BASE_URL + '/project/exportPdf?id=' + projectId)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Project Detail exported",
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
        $scope.exportExcelItem = function(projectId){
            $http.get(BASE_URL + '/project/exportExcelItem?id=' + projectId)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Project Detail exported",
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
        
        
        // Import excel
        $scope.uploaded_file = null;
	$scope.importObject = function () {
            var file = $scope.uploaded_file;
            if (file) {
                swal({
                    title: "Project DB Import Option",
                    text: "<button class='email bg-green'><i class='fa fa-plus'></i> New project</button> \n\
                            <button class='download bg-blue'><i class='fa fa-edit'></i> Update project</button>\n\
                            <br><br><p>NOTE: Please use the sample file to list all projects you want to Add/Update with all info. \n\
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
                $http.post(BASE_URL + '/project/importObject', fd, {
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
                    $scope.projects.unshift(v);
                });
            }
            else{
                $.each($scope.projects, function (si, sv) {
                    $.each(list_objects, function (di, dv) {
                        if(sv.project_number && sv.project_number.toString() === dv.project_number.toString()){
                            $scope.projects[si] = dv;
                        }
                    });
                });
            }
        };
    }
]);
