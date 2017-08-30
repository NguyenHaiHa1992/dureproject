angular.module('app').controller('CustomerDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window) {
        $scope.root = $rootScope;
        $scope.init_loaded = false;

        $scope.createInit = function () {
            var post_information = {};

            $http.post(BASE_URL + '/customer/createInit', post_information)
            .success(function (data) {
                $scope.init_loaded = true;
                if (data.success) {
                    $scope.customer_empty = data.customer_empty;
                    $scope.customer_error = data.customer_error;
                    $scope.customer_error_empty = data.customer_error_empty;
                    $scope.states = data.states;
                    $scope.tiers = data.tiers;

                    $scope.is_update = true;
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

        $scope.getCustomerById = function () {
            $http.post(BASE_URL + '/customer/getCustomerById', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.customer = data.customer;
                    $scope.customer_code = $scope.customer.customer_code;
                    $scope.customer_error = data.customer_error;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getCustomerById();

        $scope.update = function () {
            var information_post = $scope.customer;
            $http.post(BASE_URL + '/customer/update', information_post)
                    .success(function (data) {
                        if (data.success) {
                            swal('Customer updated!', "", "success");
                            $scope.customer = data.customer;
                            $scope.customer_error = $scope.customer_error_empty;

                            $("input").removeClass("ng-dirty");
                        }
                        else {
                            swal({
                                title: '',
                                text: 'Customer update failed!',
                                type: 'error',
                                html: true
                            });
                            $scope.customer_error = data.customer_error;
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };

        $scope.copyToClipboard = function () {
            swal({
                title: 'Copied to clipboard!',
                text: jQuery('#customer_card').html(),
                type: 'success',
                html: true
            });
        }

        $scope.copyCustomer = function () {
//            $rootScope.view_detail_customer_id = $scope.customer.id;
//            $rootScope.is_copy_customer = true;
//            $state.go('customer-create');
            $http.post(BASE_URL + '/customer/copy', {id: $scope.customer.id})
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
        $scope.exportPdf = function(){
            $http.get(BASE_URL + '/customer/exportPdf?id=' + $scope.customer.id)
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
                var information_post = {'id': $scope.customer.id};
                $http.post(BASE_URL + '/customer/delete', information_post)
                .success(function (data) {
                    if (data.success) {
                        swal(data.message, "", "success");
                        swal.close();
                        $state.go('customer-list');
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
    }
]);
