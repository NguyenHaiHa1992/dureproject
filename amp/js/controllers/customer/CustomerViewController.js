angular.module('app').controller('CustomerViewController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window) {
		$scope.root = $rootScope;
        $scope.init_loaded = true;

        $scope.getCustomerById = function () {
            $http.post(BASE_URL + '/customer/getCustomerById', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.customer = data.customer;
                    $scope.customer_code = $scope.customer.customer_code;
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

//        $scope.getCustomerCard = function () {
//            // Create card
//            $scope.customer.card = 'ID: ' + $scope.customer.id +
//                    '\Name: ' + $scope.customer.name +
//                    '\nEmail: ' + $scope.customer.email +
//                    '\nPhone: ' + $scope.customer.phone +
//                    '\nAddress 1: ' + $scope.customer.address1 +
//                    '\nAddress 2: ' + $scope.customer.address2 +
//                    '\nCity: ' + $scope.customer.city +
//                    '\nState/Province: ' + $scope.customer.state_name +
//                    '\nZipcode/Postal Code: ' + $scope.customer.zipcode;
//            return $scope.customer.card;
//        }

        $scope.copyToClipboard = function () {
            swal({
                title: 'Copied to clipboard!',
                text: jQuery('#customer_card').html(),
                type: 'success',
                html: true
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
        
        // Export Excel and Email
        $scope.exportExcel = function(){
            $http.get(BASE_URL + '/customer/exportExcelItem?id=' + $scope.customer.id)
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
        
        // Export Signage PDF and Email
        $scope.exportPdfItemSignage = function(signage){
            $http.get(BASE_URL + '/signage/exportPdf?id=' + signage.id)
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
        
        // Export Signage Excel and Email
        $scope.exportExcelItemSignage = function(signage){
            $http.get(BASE_URL + '/signage/exportExcelItem?id=' + signage.id)
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
        
        $scope.selectedSignageIds = [];
	$scope.toggleSignageSelection = function toggleSignageSelection(id) {
	    var idx = $scope.selectedSignageIds.indexOf(id);

	    if (idx > -1) {
	      $scope.selectedSignageIds.splice(idx, 1);
	    }
	    else {
	      $scope.selectedSignageIds.push(id);
	    }
	};
        
        $scope.exportExcelListSignage = function(type){
            var search_information = 'category_id=' + $('#search_signage_final').attr('data-category_id') 
                                    + '&code=' + $('#search_signage_final').attr('data-code')
                                    + '&customer_id=' + $scope.customer.id
                                    + '&related_name='+$scope.customer.name;
            var post_information = "";
            $( "input[name^='ExportExcelSignageColumn']" ).each(function(i){
                var checkedValue = $(this).prop('checked') ? 1 : 0;
                post_information += encodeURIComponent("ExportExcelColumn[")+$(this).attr('data-column')+encodeURIComponent("]")+"="+checkedValue+"&";
            });
            post_information += search_information;
            if($scope.selectedSignageIds.length){
                post_information += "&ids="+$scope.selectedSignageIds.toString();
            }
            if(typeof type !== 'undefined'){
                post_information += "&type="+type;
            }
            $http.get(BASE_URL + '/signage/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Customer's signage DB exported",
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
        
        // Export Signage PDF and Email
        $scope.exportPdfItemFixture = function(fixture){
            $http.get(BASE_URL + '/fixture/exportPdf?id=' + fixture.id)
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
                        if(data.result){
                            $window.open(data.result.file_url);
                        }
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
        
        // Export Signage Excel and Email
        $scope.exportExcelItemFixture = function(fixture){
            $http.get(BASE_URL + '/fixture/exportExcelItem?id=' + fixture.id)
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
                        if(data.result){
                            $window.open(data.result.file_url);
                        }
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
        
        $scope.selectedFixtureIds = [];
	$scope.toggleFixtureSelection = function toggleFixtureSelection(id) {
	    var idx = $scope.selectedFixtureIds.indexOf(id);

	    if (idx > -1) {
	      $scope.selectedFixtureIds.splice(idx, 1);
	    }
	    else {
	      $scope.selectedFixtureIds.push(id);
	    }
	};
        
        $scope.exportExcelListFixture = function(type){
            var search_information = 'category_id=' + $('#search_fixture_final').attr('data-category_id') 
                                    + '&code=' + $('#search_fixture_final').attr('data-code')
                                    + '&customer_id=' + $scope.customer.id
                                    + '&related_name='+$scope.customer.name;
            var post_information = "";
            $( "input[name^='ExportExcelFixtureColumn']" ).each(function(i){
                var checkedValue = $(this).prop('checked') ? 1 : 0;
                post_information += encodeURIComponent("ExportExcelColumn[")+$(this).attr('data-column')+encodeURIComponent("]")+"="+checkedValue+"&";
            });
            post_information += search_information;
            if($scope.selectedFixtureIds.length){
                post_information += "&ids="+$scope.selectedFixtureIds.toString();
            }
            if(typeof type !== 'undefined'){
                post_information += "&type="+type;
            }
            $http.get(BASE_URL + '/fixture/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Customer's fixture DB exported",
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
                        if(data.result){
                            $window.open(data.result.file_url);
                        }
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
    }
]);
