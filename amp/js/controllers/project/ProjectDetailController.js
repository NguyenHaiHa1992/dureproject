angular.module('app').controller('ProjectDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window) {
        $scope.root = $rootScope;
        $scope.init_loaded = false;
        $scope.productDevelopment = {};
        $scope.qa = {};
        $scope.qa_error = {};
        $scope.packProduct = {};
        $scope.packProduct_error = {};
        $scope.sale = {};
        $scope.productApproval = {};
        $scope.productApproval_error = {};
        $scope.isFullInfo = true;
        $scope.formAttributes = [];
        
        $scope.createInit = function () {
            var post_information = {};

            $http.post(BASE_URL + '/project/createInit', post_information)
            .success(function (data) {
                $scope.init_loaded = true;
                if (data.success) {
                    $scope.project_empty = data.project_empty;
                    $scope.project_error = data.project_error;
                    $scope.project_error_empty = data.project_error_empty;
                    $scope.project_customers = data.project_customers;
                    $scope.project_typeProducts = data.project_typeProducts;
                    $scope.project_services = data.project_services;
                    $scope.libYesNo = [{id:1,name:'Yes'},{id:0,name:'No'}];
                    $scope.is_update = true;
                    
                    $scope.packProduct.customers = data.project_customers;
                    $scope.formAttributes = data.formAttributes;
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

        $scope.getProjectById = function () {
            $http.post(BASE_URL + '/project/getProjectById', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.project = data.project;
                    $scope.project_code = $scope.project.project_code;
                    $scope.project_error = data.project_error;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getProjectById();

        $scope.update = function () {
            var projectInfo = $scope.project;
            var productDevInof = $scope.productDevelopment;
            var qaInfo = $scope.qa;
            var packProductInfo = $scope.packProduct;
            var saleInfo = $scope.sale;
            var productAppr = $scope.productApproval;
            
            var information_post = {
                'project' : projectInfo,
                'productDevleopment' : productDevInof,
                'qa' : qaInfo,
                'packProduct' : packProductInfo,
                'sale' : saleInfo,
                'productApproval' : productAppr,
            };
            
            console.log("DEBUG :  submit information: " + JSON.stringify(information_post));
            
            $http.post(BASE_URL + '/project/update', information_post)
                    .success(function (data) {
                        if (data.success) {
                            console.log("Project Update success");
                            swal('Project updated!', "", "success");
                            
                            $scope.project = data.project.project;
                            $scope.project_error = data.project.project_error;
                            $scope.productDevelopment = data.productDevelopment.productDevelopment;
                            $scope.productDevelopmentError = data.productDevelopment.productDevelopment_error_empty;
                            
                            $scope.qa = data.qa.qa;
                            $scope.qaError = data.qa.qa_error;
                            
                            $scope.packProduct = data.packProduct.packProduct;
                            $scope.packProductError = data.packProduct.packProduct_error_empty;
                            
                            $scope.sale = data.sale.sale;
                            $scope.saleError = data.sale.sale_error_empty;
                            
                            $scope.productApproval = data.productApproval.productApproval;
                            $scope.productApprovalError = data.productApproval.productApproval_error;
                            $("input").removeClass("ng-dirty");
                        }
                        else {
                            swal({
                                title: '',
                                text: 'Project update failed!',
                                type: 'error',
                                html: true
                            });
                            $scope.project_error = data.project_error;
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };

        $scope.copyToClipboard = function () {
            swal({
                title: 'Copied to clipboard!',
                text: jQuery('#project_card').html(),
                type: 'success',
                html: true
            });
        }

        $scope.copyProject = function () {
            $http.post(BASE_URL + '/project/copy', {id: $scope.project.id})
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
        $scope.exportPdf = function(){
            $http.get(BASE_URL + '/project/exportPdf?id=' + $scope.project.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "project Detail exported",
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

		/// Jquery collapse
        jQuery("[data-widget='collapse']").click(function() {
                //Find the box parent........
                var first = jQuery(this).hasClass('box-first');
                var box = jQuery(this).parents(".box").first();
                //Find the body and the footer
                var bf = box.find(".box-body, .box-footer");
                if (!jQuery(this).children().hasClass("fa-plus")) {
                        jQuery(this).children(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
                        bf.slideUp();
                        if(!first){
                            box.parent(".box-over").removeClass("col-md-12").addClass("col-md-6");
                        }
                } else {
                        //Convert plus into minus
                        jQuery(this).children(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
                        bf.slideDown();
                        if(!first){
                            box.parent(".box-over").removeClass("col-md-6").addClass("col-md-12");
                        }
                }
        });
            
        
        
        
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
                var information_post = {'id': $scope.project.id};
                $http.post(BASE_URL + '/project/delete', information_post)
                .success(function (data) {
                    if (data.success) {
                        swal(data.message, "", "success");
                        swal.close();
                        $state.go('project-list');
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
        
        $scope.addCustomer = function(){
            console.log("DEBUG : function addCustomer");
            $('input, select').removeClass('ng-dirty');
            $scope.customer_error = {
                'ship_to' : [],
                'ship_oa' : [],
                'ship_address' : [],
                'bill_to' : [],
                'bill_oa' : [],
                'bill_address' : [],
                'phone' : [],
                'fax' :[],
            };
            $scope.customer = {};
            $('#customerAddModal').modal('show');
            console.log("DEBUG : end function addCustomer");
        }

        $scope.submitAddCustomer = function(customer){
            console.log("DEBUG : function submitAddCustomer");
            var information_post = customer;
            $http.post(BASE_URL + '/customer/create', information_post)
                .success(function(data) {
                        if(data.success) {
                            swal(data.message, "", "success");
                            $('#customerAddModal').modal('hide');
                            $scope.customer_error = 
                                {
                                    'ship_to' : [],
                                    'ship_oa' : [],
                                    'ship_address' : [],
                                    'bill_to' : [],
                                    'bill_oa' : [],
                                    'bill_address' : [],
                                    'phone' : [],
                                    'fax' :[],
                                };

                            //  update customer select
                            console.log("DEBUG : customer  update success, get by add : " + JSON.stringify(data.customer));
                            $scope.project.customer_id = data.customer.id;
                            $scope.project_customers.push({'id' : data.customer.id ,'name' : data.customer.ship_address});
                            console.log("DEBUG : project customer after update : " + JSON.stringify($scope.project_customers));
                        }
                        else{
                            $scope.customer = customer;
                            $scope.customer_error= data.customer_error;
                        }
                    })
                    .error(function(data, status, headers, config) {
                        $state.go('404');	
                    });
            console.log("DEBUG : end funciton submitAddCustomer");
        };
        
//        $scope.productDevelopment = {};
//        $scope.qa = {};
//        $scope.qa_error = {};
//        $scope.packProduct = {};
//        $scope.packProduct_error = {};
//        $scope.sale = {};
//        $scope.productApproval = {};
//        $scope.isFullInfo = false;
        $scope.$watch('project', function () {
            console.log('change project');
            console.log($scope.project);
            $scope.isFullInfo = true;
            for(var key in $scope.project){
                if(!$scope.project.hasOwnProperty(key) 
                    || typeof($scope.project[key]) === 'object' 
                    || !in_array($scope.formAttributes, key)) continue;
                    if(typeof($scope.project[key]) === 'undefined' 
                            || $scope.project[key] === null || $scope.project[key] === ''){
                        $scope.isFullInfo = false;
                    }
            }
            if(!$scope.isFullInfo){
                $scope.productApproval.status = 0;
            }
        }, true);
        
        $scope.$watch('isFullInfo', function(){
            console.log('is full info');
            console.log($scope.isFullInfo);
        });
    }
]);
