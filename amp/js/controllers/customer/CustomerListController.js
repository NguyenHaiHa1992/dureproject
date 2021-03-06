angular.module('app').controller('CustomerListController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $window) {
	$scope.root = $rootScope;
        $scope.customers = [];
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
        $scope.start_customer = 1;
        $scope.end_customer = 1;
        $scope.totalresults = 0;
        $scope.sort = {
            attribute: 'created_time',
            type: 'DESC',
        };
        $scope.search_customer = {
            id: '',
            name: '',
            email: '',
            created: '',
//            tier_id: '',
//            city: '',
//            signage_id: '',
//            fixture_id: ''
        };
        $scope.copy_search_customer = {
            name: '',
            email: '',
//            tier_id: '',
//            city: '',
//            signage_id: '',
//            fixture_id: ''
        };
        var post_information = {
            'limitstart': 0,
            'limitnum': $scope.itemsByPage,
            'sort_attribute': $scope.sort.attribute,
            'sort_type': $scope.sort.type,
        };

        $scope.getCustomers = function (post_information) {
            $http.post(BASE_URL + '/customer/getAll', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.totalresults = parseInt(data.totalresults);
                    $scope.start_customer = data.start_customer;
                    $scope.end_customer = data.end_customer;
                    $scope.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                        $scope.pages.push(p + 1);
                    //$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
                    $scope.customers = [];
                    $scope.customers = data.customers;
                    // for(var i= 0; i< data.customers.length; i++)
                    // $scope.customers.push(data.email_templates[i]);
                    
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
        $scope.getCustomers(post_information);

        $scope.selectPage = function (page) {
            $scope.currentPage = page;
            var post_information = {
                'limitstart': (page - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_customer.id,
//                'name': $scope.search_customer.name,
//                'tier_id': $scope.search_customer.tier_id,
//                'email': $scope.search_customer.email,
//                'created': $scope.search_customer.created,
//                'city': $scope.search_customer.city,
            };
            $scope.getCustomers(post_information);
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
                'id': $scope.search_customer.id,
//                'name': $scope.search_customer.name,
//                'tier_id': $scope.search_customer.tier_id,
//                'email': $scope.search_customer.email,
                'created': $scope.search_customer.created,
//                'city': $scope.search_customer.city,
            };
            if ($scope.itemsByPage_change_number > 1)
                $scope.getCustomers(post_information);
        }, true);

        $scope.search_change_number = 0;
        $scope.$watch('search', function () {
            $scope.search_change_number++;
            var post_information = {
                'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
                'id': $scope.search_customer.id,
//                'name': $scope.search_customer.name,
//                'tier_id': $scope.search_customer.tier_id,
//                'email': $scope.search_customer.email,
                'created': $scope.search_customer.created,
//                'city': $scope.search_customer.city,
            };
            if ($scope.search_change_number > 1)
                $scope.getCustomers(post_information);
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
                'id': $scope.search_customer.id,
//                'name': $scope.search_customer.name,
//                'tier_id': $scope.search_customer.tier_id,
//                'email': $scope.search_customer.email,
                'created': $scope.search_customer.created,
//                'city': $scope.search_customer.city,
            };
            $scope.getCustomers(post_information);
        };

        $scope.search = function () {
            post_information.ship_to = $scope.search_customer.ship_to;
            post_information.ship_oa = $scope.search_customer.ship_oa;
            post_information.ship_address = $scope.search_customer.ship_address;
            post_information.bill_to = $scope.search_customer.bill_to;
            post_information.bill_oa = $scope.search_customer.bill_oa;
            post_information.bill_address = $scope.search_customer.bill_address;
            post_information.phone = $scope.search_customer.phone;
            post_information.fax = $scope.search_customer.fax;
            
            $scope.copy_search_customer.ship_to = $scope.search_customer.ship_to;
            $scope.copy_search_customer.ship_oa = $scope.search_customer.ship_oa;
            $scope.copy_search_customer.ship_address = $scope.search_customer.ship_address;
            $scope.copy_search_customer.bill_to = $scope.search_customer.bill_to;
            $scope.copy_search_customer.bill_oa = $scope.search_customer.bill_oa;
            $scope.copy_search_customer.bill_address = $scope.search_customer.bill_address;
            post_information.phone = $scope.search_customer.phone;
            post_information.fax = $scope.search_customer.fax;
            $scope.getCustomers(post_information);
        }

        $scope.resetSearch = function(){
            $scope.search_customer = {};
            $scope.search();
        }

        $scope.viewDetai = function (customer_id) {
            $rootScope.view_detail_customer_id = customer_id;
            $state.go('customer-create');
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
            var search_information = '&tier_id=' + $scope.copy_search_customer.tier_id 
                    + '&name=' + $scope.copy_search_customer.name 
                    + '&city=' + $scope.copy_search_customer.city 
                    + '&email=' + $scope.copy_search_customer.email
                    + '&signage_id=' + $scope.copy_search_customer.signage_id
                    + '&fixture_id=' + $scope.copy_search_customer.fixture_id;
            var post_information = $('#export-excel-column').serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
            $http.get(BASE_URL + '/customer/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Customer DB exported",
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
            var search_information = '&tier_id=' + $scope.copy_search_customer.tier_id 
                    + '&name=' + $scope.copy_search_customer.name 
                    + '&city=' + $scope.copy_search_customer.city 
                    + '&email=' + $scope.copy_search_customer.email
                    + '&signage_id=' + $scope.copy_search_customer.signage_id
                    + '&fixture_id=' + $scope.copy_search_customer.fixture_id
                    + '&type=pdf';
            var post_information = $('#export-excel-column').serialize() + search_information;
            if($scope.selectedDbIds.length){
                post_information += "&ids="+$scope.selectedDbIds.toString();
            }
            $http.get(BASE_URL + '/customer/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Customer DB exported",
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
        
        $scope.deleteCustomer = function (id) {
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
                $http.post(BASE_URL + '/customer/delete', information_post)
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
                        $scope.getCustomers(post_information);
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
        
        $scope.copyCustomer = function (id) {
//            $rootScope.view_detail_customer_id = id;
//            $rootScope.is_copy_customer = true;
//            $state.go('customer-create');
            $http.post(BASE_URL + '/customer/copy', {id: id})
            .success(function (data) {
                if (data.success) {
                    $state.go('customer-detail', {id: data.id});
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
        $scope.exportPdfItem = function(customerId){
            $http.get(BASE_URL + '/customer/exportPdf?id=' + customerId)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Customer Detail exported",
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
        $scope.exportExcelItem = function(customerId){
            $http.get(BASE_URL + '/customer/exportExcelItem?id=' + customerId)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Customer Detail exported",
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
        $scope.related_signages = [];
        $scope.getRelatedSignages = function(){
            $http.get(BASE_URL + '/signage/getAll?sort_attribute=code&sort_type=ASC')
            .success(function (data) {
                if (data.success) {
//                    var tmpList = [];
                    angular.forEach(data.signages, function(v, i){
                        var itemTmp = {id: v.id, code: v.code};
//                        var idTmp = tmpList.indexOf(v.id);
//                        if(idTmp === -1){
//                            tmpList.push(v.id);
                            $scope.related_signages.push(itemTmp);
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
        //$scope.getRelatedSignages();
        
        $scope.related_fixtures = [];
        $scope.getRelatedFixtures = function(){
            $http.get(BASE_URL + '/fixture/getAll?sort_attribute=code&sort_type=ASC')
            .success(function (data) {
                if (data.success) {
//                    var tmpList = [];
                    angular.forEach(data.fixtures, function(v, i){
                        var itemTmp = {id: v.id, code: v.code};
//                        var idTmp = tmpList.indexOf(v.id);
//                        if(idTmp === -1){
//                            tmpList.push(v.id);
                            $scope.related_fixtures.push(itemTmp);
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
        //$scope.getRelatedFixtures();
        
        // Import excel
        $scope.uploaded_file = null;
	$scope.importObject = function () {
            var file = $scope.uploaded_file;
            if (file) {
                swal({
                    title: "Customer DB Import Option",
                    text: "<button class='email bg-green'><i class='fa fa-plus'></i> New customer</button> \n\
                            <button class='download bg-blue'><i class='fa fa-edit'></i> Update customer</button>\n\
                            <br><br><p>NOTE: Please use the sample file to list all customers you want to Add/Update with all info. \n\
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
                $http.post(BASE_URL + '/customer/importObject', fd, {
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
                    $scope.customers.unshift(v);
                });
            }
            else{
                $.each($scope.customers, function (si, sv) {
                    $.each(list_objects, function (di, dv) {
                        if(sv.customer_number && sv.customer_number.toString() === dv.customer_number.toString()){
                            $scope.customers[si] = dv;
                        }
                    });
                });
            }
        };
    }
]);
