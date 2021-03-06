angular.module('app').controller('ProjectDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window) {
        $scope.root = $rootScope;
        $scope.init_loaded = false;
        $scope.productDevelopment = {};
        $scope.productDevelopment_error = {};
        $scope.qa = {};
        $scope.qa_error = {};
        $scope.packProduct = {};
        $scope.packProduct_error = {};
        $scope.sale = {};
        $scope.sale_error = {};
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
//                    if(data.project.in_trash){
//                        $state.go('404');
//                    }
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
            
            $http.post(BASE_URL + '/project/update', information_post)
                    .success(function (data) {
                        if (data.success) {
                            swal('Project updated!', "", "success");
                            
                            $scope.project = data.project.project;
                            $scope.productDevelopment = data.productDevelopment.productDevelopment;
                            $scope.qa = data.qa.qa;
                            $scope.packProduct = data.packProduct.packProduct;
                            $scope.sale = data.sale.sale;
                            $scope.productApproval = data.productApproval.productApproval;
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
                        if(data.project.project_error){
                            $scope.project_error = data.project.project_error;
                            $scope.has_error_project = $scope.checkErrorObject($scope.project_error);
                        }
                        if(data.productDevelopment.productDevelopment_error){
                            $scope.productDevelopment_error = data.productDevelopment.productDevelopment_error;
                            $scope.has_error_productDevelopment = $scope.checkErrorObject($scope.productDevelopment_error);
                        }
                        if(data.qa.qa_error){
                            $scope.qa_error = data.qa.qa_error;
                            $scope.has_error_qa = $scope.checkErrorObject($scope.qa_error);
                        }
                        if(data.packProduct.packProduct_error){
                            $scope.packProduct_error = data.packProduct.packProduct_error;
                            $scope.has_error_qa = $scope.checkErrorObject($scope.qa_error);
                        }
                        if(data.sale.sale_error){
                            $scope.sale_error = data.sale.sale_error;
                            $scope.has_error_sale = $scope.checkErrorObject($scope.sale_error);
                        }
                        if(data.productApproval.productApproval_error){
                            $scope.productApproval_error = data.productApproval.productApproval_error;
                            $scope.has_error_product_approval = $scope.checkErrorObject($scope.productApproval_error);
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
        
        
        $scope.checkErrorObject = function(obj){
            if(typeof obj !== 'object'){
                return false;
            }
            else{
                for(var errAttr in obj){
                    if(errAttr.length > 0){
                        return true;
                    }
                }
            }
            return false;
        }
        // Export PDF and Email
        $scope.exportPdf = function(){
            //submit data
            var information_post = {
                'project' : $scope.project,
                'productDevelopment' : $scope.productDevelopment,
                'qa' : $scope.qa,
                'packProduct' : $scope.packProduct,
                'sale' : $scope.sale,
                'productApproval' : $scope.productApproval
            };
            
            $http.post(BASE_URL + '/project/create?export=export', information_post)
            .success(function (dataCreate) {
                if (dataCreate.success) {
                    $("input").removeClass("ng-dirty");
                    //export here
                    $http.get(BASE_URL + '/project/exportPdf?project_id=' + dataCreate.project.id)
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
                }
                else {
                    swal({
                        title: '',
                        text: 'Please fix some errors before export',
                        type: 'error',
                        html: true
                    });
                }
                $scope.setDataError(dataCreate);
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
        
        // show hide warning
//        $(document).ready(function(){
//            jQuery(".box-header").each(function(){
//                var that = jQuery(this);
//                var hasError = that.parent().find(".has-error").length;
//                if(hasError > 0){
//                    that.addClass("alert-warning");
//                    that.find(".btn-warning").show();
//                }else{
//                    that.removeClass("alert-warning");
//                    that.find(".btn-warning").hide();
//                }
//            });
//        });
        
        
        
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
        }

        $scope.submitAddCustomer = function(customer){
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
                            $scope.project.customer_id = data.customer.id;
                            $scope.project_customers.push({'id' : data.customer.id ,'name' : data.customer.ship_address});
                        }
                        else{
                            $scope.customer = customer;
                            $scope.customer_error= data.customer_error;
                        }
                    })
                    .error(function(data, status, headers, config) {
                        $state.go('404');	
                    });
        };
        
        var objects = ['sale', 'qa', 'productDevelopment', 'packProduct', 'productApproval'];
        $scope.$watch('project', function () {
            if($scope.project){
                $scope.project.isFullInfo = true;
            }
            for(var key in $scope.project){
                if(!$scope.project.hasOwnProperty(key) 
                    || !in_array($scope.formAttributes, key)){ continue; } 
                if(typeof($scope.project[key]) === 'undefined' 
                        || $scope.project[key] === null || $scope.project[key] === ''){
                    $scope.project.isFullInfo = false;
                    $scope.productApproval.status = 0;
                }
            }
            var objectsIsFullInfo = true;
            objects.forEach(function(object){
                objectsIsFullInfo = objectsIsFullInfo && $scope[object].isFullInfo;
            });
            if($scope.project){
                $scope.isFullInfo = $scope.project.isFullInfo && objectsIsFullInfo;
            }
        }, true);
        
//        $scope.$watch('sale', function () {
//            if($scope.sale){
//                $scope.sale.isFullInfo = true;
//            }
//            for(var key in $scope.sale){
//                if(!$scope.sale.hasOwnProperty(key) 
//                    || !in_array($scope.sale.formAttributes, key)){ continue; } 
//                if(typeof($scope.sale[key]) === 'undefined' 
//                        || $scope.sale[key] === null || $scope.sale[key] === ''){
//                    $scope.sale.isFullInfo = false;
//                    $scope.productApproval.status = 0;
//                }
//            }
//            $scope.isFullInfo = $scope.isFullInfo && $scope.sale.isFullInfo;
//        }, true);
        
        objects.forEach(function(object){
            $scope.$watch(object, function () {
                if($scope[object]){
                    $scope[object].isFullInfo = true;
                }
                for(var key in $scope[object]){
                    if(!$scope[object].hasOwnProperty(key) 
                        || !in_array($scope[object].formAttributes, key)){ continue; } 
                    if(typeof($scope[object][key]) === 'undefined' 
                            || $scope[object][key] === null || $scope[object][key] === ''){
                        $scope[object].isFullInfo = false;
                        $scope.productApproval.status = 0;
                    }
                }
                var objectsIsFullInfo = true;
                objects.forEach(function(object){
                    objectsIsFullInfo = objectsIsFullInfo && $scope[object].isFullInfo;
                });
                if($scope.project){
                    $scope.isFullInfo = $scope.project.isFullInfo && objectsIsFullInfo;
                }
            }, true);
        });
                
        $scope.$watch('isFullInfo', function(){
            console.log('is full info');
            console.log($scope.isFullInfo);
        });
        
        $scope.setDataError = function(data){
            if(data.project.project_error){
                $scope.project_error = data.project.project_error;
                $scope.has_error_project = $scope.checkErrorObject($scope.project_error);
            }
            if(data.productDevelopment.productDevelopment_error){
                $scope.productDevelopment_error = data.productDevelopment.productDevelopment_error;
                $scope.has_error_productDevelopment = $scope.checkErrorObject($scope.productDevelopment_error);
            }
            if(data.qa.qa_error){
                $scope.qa_error = data.qa.qa_error;
                $scope.has_error_qa = $scope.checkErrorObject($scope.qa_error);
            }
            if(data.packProduct.packProduct_error){
                $scope.packProduct_error = data.packProduct.packProduct_error;
                $scope.has_error_qa = $scope.checkErrorObject($scope.qa_error);
            }
            if(data.sale.sale_error){
                $scope.sale_error = data.sale.sale_error;
                $scope.has_error_sale = $scope.checkErrorObject($scope.sale_error);
            }
            if(data.productApproval.productApproval_error){
                $scope.productApproval_error = data.productApproval.productApproval_error;
                $scope.has_error_product_approval = $scope.checkErrorObject($scope.productApproval_error);
            }
        };
    }
]);
