angular.module('app').controller('ProjectCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
    $scope.init_loaded = false;
    $scope.isFullInfo = true;
    $scope.formAttributes = [];
    $scope.createInit= function(){
        //  init Project
        function initProject(){
            var post_information= {};
            if(jQuery.type($rootScope.view_detail_project_id) !== "undefined" && $rootScope.view_detail_customer_id !== ''){
                post_information= {id: $rootScope.view_detail_customer_id};
                $rootScope.view_detail_project_id= undefined;
            }
            else{
                post_information= {};
            }
            $http.post(BASE_URL + '/project/createInit', post_information)
            .success(function(data) {
                $scope.init_loaded = true;

                if(data.success) {
                    $scope.project = data.project;
                    $scope.project_empty= data.project_empty;
                    $scope.project_error= data.project_error;
                    $scope.project_error_empty= data.project_error_empty;
                    $scope.project_customers = data.project_customers;
                    $scope.project_typeProducts = data.project_typeProducts;
                    $scope.project_services = data.project_services;
                    $scope.libYesNo = [{'id':1,'name':'Yes'},{'id':0,'name':'No'}];
                    $scope.is_update= data.is_update;
                    $scope.is_create= data.is_create;

                    $scope.project_code= $scope.project.project_code;

                    // If copy project
                    if($rootScope.is_copy_project){
                        $scope.project.id = undefined;
                        $scope.project.name = $scope.project.name + ' COPY';
                        $scope.is_update= false;   
                        $scope.is_create= true;
                    }
                    $scope.productDevelopment = {};
                    $scope.productDevelopment_error = {};
                    
                    $scope.qa = {};
                    $scope.qa_error = {};
                    
                    $scope.packProduct = {};
                    // add lib customers
                    $scope.packProduct.customers = data.project_customers;
                    $scope.packProduct_error = {};
                    
                    $scope.sale = {};
                    $scope.sale_error = {};
                    
                    $scope.productApproval = {};
                    $scope.productApproval_error = {};

                    $scope.formAttributes = data.formAttributes;
                }
                else{
                    $state.go('404');
                }
            })
            .error(function(data, status, headers, config) {
                $state.go('404');
            });
        }

        // end init Project

         initProject();
         // initProductDevelopment();
    };

    $scope.createInit();

    $scope.create= function(){
        var information_post = {
            project : $scope.project,
            productDevelopment : $scope.productDevelopment,
            qa: $scope.qa,
            packProduct : $scope.packProduct,
            sale : $scope.sale,
            productApproval : $scope.productApproval,
        };
        
        $http.post(BASE_URL + '/project/create', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Project created!', "", "success");
                $state.go('project-detail', {id: data.project.id});
            }
            else{
                swal({
                    title: '',
                    text: 'Project create failed!',
                    type: 'error',
                    html: true
                });
                if(data.project.project_error){
                    $scope.project_error= data.project.project_error;    
                }
                else{
                    $scope.emptyError('project_error');
                }
                if(data.productDevelopment.productDevelopment_error){
                    $scope.productDevelopment_error = data.productDevelopment.productDevelopment_error;    
                }
                else{
                    $scope.emptyError('productDevelopment_error');
                }
                if(data.qa.qa_error){
                    $scope.qa_error = data.qa.qa_error;    
                }
                else{
                    $scope.emptyError('qa_error');
                }
                if(data.packProduct.packProduct_error){
                    $scope.packProduct_error = data.packProduct.packProduct_error;    
                }
                else{
                    $scope.emptyError('packProduct_error');
                }
                if(data.sale.sale_error){
                    $scope.sale_error = data.sale.sale_error;    
                }
                else{
                    $scope.emptyError('sale_error');
                }
                if(data.productApproval.productApproval_error){
                    $scope.productApproval_error = data.productApproval.productApproval_error;    
                }
                else{
                    $scope.emptyError('productApproval_error');
                }
                
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.update= function(){
        var information_post= $scope.project;
        $http.post(BASE_URL + '/project/update', information_post)
        .success(function(data) {
            if(data.success) {
                swal('Project updated!', "", "success");
                $scope.project= data.customer;
                $scope.project_error= $scope.project_error_empty;

                $( "input" ).removeClass( "ng-dirty" );
            }
            else{
                swal({
                        title: '',
                        text: 'Project update failed!',
                        type: 'error',
                        html: true
                });
                $scope.project_error= data.project.project_error;
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
    };

    $scope.copyToClipboard = function () {
    	swal({
            title: 'You have copied card to clipboard!',
            text: jQuery('#project_card').html(),
            type: 'success',
            html: true
    	});
    };

    $scope.showHideOther = function(){
        if ($scope.project.service == 'type_other') {
            $scope.project.other_service = "";
        }
    };
    
    $scope.showHideLifeStyle = function(){
        if($scope.project.life_style == 'type_other'){
            $scope.project.other_type_product = "";
        }
    }
    
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
    }

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
                if($scope[object]){
                    objectsIsFullInfo = objectsIsFullInfo && $scope[object].isFullInfo;
                }
            });
            if($scope.project){
                $scope.isFullInfo = $scope.project.isFullInfo && objectsIsFullInfo;
            }
        }, true);
        
        objects.forEach(function(object){
            $scope.$watch(object, function () {
                if($scope[object]){
                    $scope[object].isFullInfo = true;
                }
                if(object === 'productApproval'){
                    console.log(object + ' change');
                    console.log($scope[object]);
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
                    if($scope[object]){
                        objectsIsFullInfo = objectsIsFullInfo && $scope[object].isFullInfo;
                    }
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

        $scope.emptyError = function(objectKey){
            if(typeof $scope[objectKey] !== 'object'){
                return false;
            }
            for(var k in $scope[objectKey]){
                if(!$scope[objectKey].hasOwnProperty(k)) continue;
                $scope[objectKey][k] = [];
            }
        }
    
    // Jquery collapse
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
    //Date picker
    jQuery('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
}]);
