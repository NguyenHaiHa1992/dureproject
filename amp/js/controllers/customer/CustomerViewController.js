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

        $scope.getCustomerCard = function () {
            // Create card
            $scope.customer.card = 'ID: ' + $scope.customer.id +
                    '\Name: ' + $scope.customer.name +
                    '\nEmail: ' + $scope.customer.email +
                    '\nPhone: ' + $scope.customer.phone +
                    '\nAddress 1: ' + $scope.customer.address1 +
                    '\nAddress 2: ' + $scope.customer.address2 +
                    '\nCity: ' + $scope.customer.city +
                    '\nState/Province: ' + $scope.customer.state_name +
                    '\nZipcode/Postal Code: ' + $scope.customer.zipcode;
            return $scope.customer.card;
        }

        $scope.copyToClipboard = function () {
            swal({
                title: 'Copied to clipboard!',
                text: jQuery('#customer_card').html(),
                type: 'success',
                html: true
            });
        }

        // Customer's signages list
        $scope.customer_signage_list = {};
        $scope.customer_signage_list.signages = [];
        $scope.customer_signage_list.itemsByPage = 10;
        $scope.customer_signage_list.itemsByPages = [
            {value: 10, name: 10}, 
            {value: 20, name: 20}, 
            {value: 30, name: 30},
            {value: 50, name: 50}, 
            {value: 100, name: 100}
        ];
        $scope.customer_signage_list.pages = [];
        $scope.customer_signage_list.currentPage = 1;
        $scope.customer_signage_list.start_signage = 1;
        $scope.customer_signage_list.end_signage = 1;
        $scope.customer_signage_list.totalresults = 0;
        $scope.customer_signage_list.sort = {
            attribute: 'created_time',
            type: 'DESC',
        };
        $scope.customer_signage_list.search_signage = {
            id: '',
            code: '',
            email: '',
            created: '',
            category_id: ''
        };
        var customer_signage_post_information = {
            'customer_id': $stateParams.id,
            'limitstart': 0,
            'limitnum': $scope.customer_signage_list.itemsByPage,
            'sort_attribute': $scope.customer_signage_list.sort.attribute,
            'sort_type': $scope.customer_signage_list.sort.type,
        };

        $scope.customer_signage_list.getSignages = function (customer_signage_post_information) {
            $http.post(BASE_URL + '/customerSignage/getAll', customer_signage_post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.customer_signage_list.totalresults = parseInt(data.totalresults);
                    $scope.customer_signage_list.start_signage = data.start_signage;
                    $scope.customer_signage_list.end_signage = data.end_signage;
                    $scope.customer_signage_list.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.customer_signage_list.itemsByPage); p++)
                        $scope.customer_signage_list.pages.push(p + 1);
                    $scope.customer_signage_list.signages = [];
                    $scope.customer_signage_list.signages = data.signages;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.customer_signage_list.getSignages(customer_signage_post_information);

        $scope.customer_signage_list.getSignageCategories = function (post_information) {
            $http.post(BASE_URL + '/signageCategory/getAll', [])
            .success(function (data) {
                if (data.success) {
                    $scope.customer_signage_list.signage_categories = data.signage_categories;
                }
                else {
                    swal('Can not get signage category list', '', 'error');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.customer_signage_list.getSignageCategories(customer_signage_post_information);

        $scope.customer_signage_list.selectPage = function (page) {
            $scope.customer_signage_list.currentPage = page;
            var customer_signage_post_information = {
                'customer_id': $stateParams.id,
                'limitstart': (page - 1) * $scope.customer_signage_list.itemsByPage,
                'limitnum': $scope.customer_signage_list.itemsByPage,
                'sort_attribute': $scope.customer_signage_list.sort.attribute,
                'sort_type': $scope.customer_signage_list.sort.type,
                'id': $scope.customer_signage_list.search_signage.id,
                'code': $scope.customer_signage_list.search_signage.code,
                'category_id': $scope.customer_signage_list.search_signage.category_id,
                'email': $scope.customer_signage_list.search_signage.email,
                'created': $scope.customer_signage_list.search_signage.created,
            };
            $scope.customer_signage_list.getSignages(customer_signage_post_information);
        };

        $scope.customer_signage_list.itemsByPage_change_number = 0;
        $scope.$watch('customer_signage_list.itemsByPage', function () {
            $scope.customer_signage_list.itemsByPage_change_number++;
            if ($scope.customer_signage_list.itemsByPage == 0 || $scope.customer_signage_list.itemsByPage == '0' || $scope.customer_signage_list.itemsByPage == '' || $scope.customer_signage_list.itemsByPage == null)
                $scope.customer_signage_list.itemsByPage = 1;
            var customer_signage_post_information = {
                'customer_id': $stateParams.id,
                'limitstart': 0,
                'limitnum': $scope.customer_signage_list.itemsByPage,
                'sort_attribute': $scope.customer_signage_list.sort.attribute,
                'sort_type': $scope.customer_signage_list.sort.type,
                'id': $scope.customer_signage_list.search_signage.id,
                'code': $scope.customer_signage_list.search_signage.code,
                'category_id': $scope.customer_signage_list.search_signage.category_id,
                'email': $scope.customer_signage_list.search_signage.email,
                'created': $scope.customer_signage_list.search_signage.created,
            };
            if ($scope.customer_signage_list.itemsByPage_change_number > 1)
                $scope.customer_signage_list.getSignages(customer_signage_post_information);
        }, true);

        $scope.customer_signage_list.search_change_number = 0;

        $scope.customer_signage_list.sort = function (sort_attribute) {
            if ($scope.customer_signage_list.sort.attribute == sort_attribute)
                if ($scope.customer_signage_list.sort.type == 'DESC')
                    $scope.customer_signage_list.sort.type = 'ASC';
                else
                    $scope.customer_signage_list.sort.type = 'DESC';
            else {
                $scope.customer_signage_list.sort.attribute = sort_attribute;
                $scope.customer_signage_list.sort.type = 'DESC';
            }
            var customer_signage_post_information = {
                'customer_id': $stateParams.id,
                'limitstart': ($scope.customer_signage_list.currentPage - 1) * $scope.customer_signage_list.itemsByPage,
                'limitnum': $scope.customer_signage_list.itemsByPage,
                'sort_attribute': $scope.customer_signage_list.sort.attribute,
                'sort_type': $scope.customer_signage_list.sort.type,
                'id': $scope.customer_signage_list.search_signage.id,
                'code': $scope.customer_signage_list.search_signage.code,
                'category_id': $scope.customer_signage_list.search_signage.category_id,
                'email': $scope.customer_signage_list.search_signage.email,
                'created': $scope.customer_signage_list.search_signage.created,
            };
            $scope.customer_signage_list.getSignages(customer_signage_post_information);
        };

        $scope.customer_signage_list.search = function () {
            customer_signage_post_information.category_id = $scope.customer_signage_list.search_signage.category_id;
            customer_signage_post_information.code = $scope.customer_signage_list.search_signage.code;
            customer_signage_post_information.email = $scope.customer_signage_list.search_signage.email;

            $scope.customer_signage_list.getSignages(customer_signage_post_information);
        }

        $scope.customer_signage_list.viewCustomerSignage = function (signage) {
            $scope.customer_signage_form = {};
            $scope.customer_signage_form.customer_signage = {
                id: signage.customer_signage_id,
                customer_id: $stateParams.id,
                signage_id: signage.id,
                signage_code: signage.code,
                code: signage.customer_signage_code,
                note: signage.customer_signage_note,
            };

            $('#viewCustomerSignageModal').modal('show');
        }

        // Customer's fixtures list
        $scope.customer_fixture_list = {};
        $scope.customer_fixture_list.fixtures = [];
        $scope.customer_fixture_list.itemsByPage = 10;
        $scope.customer_fixture_list.itemsByPages = [
            {value: 10, name: 10}, 
            {value: 20, name: 20}, 
            {value: 30, name: 30},
            {value: 50, name: 50}, 
            {value: 100, name: 100}
        ];
        $scope.customer_fixture_list.pages = [];
        $scope.customer_fixture_list.currentPage = 1;
        $scope.customer_fixture_list.start_fixture = 1;
        $scope.customer_fixture_list.end_fixture = 1;
        $scope.customer_fixture_list.totalresults = 0;
        $scope.customer_fixture_list.sort = {
            attribute: 'created_time',
            type: 'DESC',
        };
        $scope.customer_fixture_list.search_fixture = {
            id: '',
            code: '',
            email: '',
            created: '',
            category_id: ''
        };
        var customer_fixture_post_information = {
            'customer_id': $stateParams.id,
            'limitstart': 0,
            'limitnum': $scope.customer_fixture_list.itemsByPage,
            'sort_attribute': $scope.customer_fixture_list.sort.attribute,
            'sort_type': $scope.customer_fixture_list.sort.type,
        };

        $scope.customer_fixture_list.getFixtures = function (customer_fixture_post_information) {
            $http.post(BASE_URL + '/customerFixture/getAll', customer_fixture_post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.customer_fixture_list.totalresults = parseInt(data.totalresults);
                    $scope.customer_fixture_list.start_fixture = data.start_fixture;
                    $scope.customer_fixture_list.end_fixture = data.end_fixture;
                    $scope.customer_fixture_list.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.customer_fixture_list.itemsByPage); p++)
                        $scope.customer_fixture_list.pages.push(p + 1);
                    $scope.customer_fixture_list.fixtures = [];
                    $scope.customer_fixture_list.fixtures = data.fixtures;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.customer_fixture_list.getFixtures(customer_fixture_post_information);

        $scope.customer_fixture_list.getFixtureCategories = function (post_information) {
            $http.post(BASE_URL + '/fixtureCategory/getAll', [])
            .success(function (data) {
                if (data.success) {
                    $scope.customer_fixture_list.fixture_categories = data.fixture_categories;
                }
                else {
                    swal('Can not get fixture category list', '', 'error');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.customer_fixture_list.getFixtureCategories(customer_fixture_post_information);

        $scope.customer_fixture_list.selectPage = function (page) {
            $scope.customer_fixture_list.currentPage = page;
            var customer_fixture_post_information = {
                'customer_id': $stateParams.id,
                'limitstart': (page - 1) * $scope.customer_fixture_list.itemsByPage,
                'limitnum': $scope.customer_fixture_list.itemsByPage,
                'sort_attribute': $scope.customer_fixture_list.sort.attribute,
                'sort_type': $scope.customer_fixture_list.sort.type,
                'id': $scope.customer_fixture_list.search_fixture.id,
                'code': $scope.customer_fixture_list.search_fixture.code,
                'category_id': $scope.customer_fixture_list.search_fixture.category_id,
                'email': $scope.customer_fixture_list.search_fixture.email,
                'created': $scope.customer_fixture_list.search_fixture.created,
            };
            $scope.customer_fixture_list.getFixtures(customer_fixture_post_information);
        };

        $scope.customer_fixture_list.itemsByPage_change_number = 0;
        $scope.$watch('customer_fixture_list.itemsByPage', function () {
            $scope.customer_fixture_list.itemsByPage_change_number++;
            if ($scope.customer_fixture_list.itemsByPage == 0 || $scope.customer_fixture_list.itemsByPage == '0' || $scope.customer_fixture_list.itemsByPage == '' || $scope.customer_fixture_list.itemsByPage == null)
                $scope.customer_fixture_list.itemsByPage = 1;
            var customer_fixture_post_information = {
                'customer_id': $stateParams.id,
                'limitstart': 0,
                'limitnum': $scope.customer_fixture_list.itemsByPage,
                'sort_attribute': $scope.customer_fixture_list.sort.attribute,
                'sort_type': $scope.customer_fixture_list.sort.type,
                'id': $scope.customer_fixture_list.search_fixture.id,
                'code': $scope.customer_fixture_list.search_fixture.code,
                'category_id': $scope.customer_fixture_list.search_fixture.category_id,
                'email': $scope.customer_fixture_list.search_fixture.email,
                'created': $scope.customer_fixture_list.search_fixture.created,
            };
            if ($scope.customer_fixture_list.itemsByPage_change_number > 1)
                $scope.customer_fixture_list.getFixtures(customer_fixture_post_information);
        }, true);

        $scope.customer_fixture_list.search_change_number = 0;

        $scope.customer_fixture_list.sort = function (sort_attribute) {
            if ($scope.customer_fixture_list.sort.attribute == sort_attribute)
                if ($scope.customer_fixture_list.sort.type == 'DESC')
                    $scope.customer_fixture_list.sort.type = 'ASC';
                else
                    $scope.customer_fixture_list.sort.type = 'DESC';
            else {
                $scope.customer_fixture_list.sort.attribute = sort_attribute;
                $scope.customer_fixture_list.sort.type = 'DESC';
            }
            var customer_fixture_post_information = {
                'customer_id': $stateParams.id,
                'limitstart': ($scope.customer_fixture_list.currentPage - 1) * $scope.customer_fixture_list.itemsByPage,
                'limitnum': $scope.customer_fixture_list.itemsByPage,
                'sort_attribute': $scope.customer_fixture_list.sort.attribute,
                'sort_type': $scope.customer_fixture_list.sort.type,
                'id': $scope.customer_fixture_list.search_fixture.id,
                'code': $scope.customer_fixture_list.search_fixture.code,
                'category_id': $scope.customer_fixture_list.search_fixture.category_id,
                'email': $scope.customer_fixture_list.search_fixture.email,
                'created': $scope.customer_fixture_list.search_fixture.created,
            };
            $scope.customer_fixture_list.getFixtures(customer_fixture_post_information);
        };

        $scope.customer_fixture_list.search = function () {
            customer_fixture_post_information.category_id = $scope.customer_fixture_list.search_fixture.category_id;
            customer_fixture_post_information.code = $scope.customer_fixture_list.search_fixture.code;
            customer_fixture_post_information.email = $scope.customer_fixture_list.search_fixture.email;

            $scope.customer_fixture_list.getFixtures(customer_fixture_post_information);
        }

        $scope.customer_fixture_list.viewCustomerFixture = function (fixture) {
            $scope.customer_fixture_form = {};
            $scope.customer_fixture_form.customer_fixture = {
                id: fixture.customer_fixture_id,
                customer_id: $stateParams.id,
                fixture_id: fixture.id,
                fixture_code: fixture.code,
                code: fixture.customer_fixture_code,
                note: fixture.customer_fixture_note,
            };

            $('#viewCustomerFixtureModal').modal('show');
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
