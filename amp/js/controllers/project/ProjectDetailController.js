angular.module('app').controller('ProjectDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window) {
        $scope.root = $rootScope;
        $scope.init_loaded = false;

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
            var information_post = $scope.project;
            $http.post(BASE_URL + '/project/update', information_post)
                    .success(function (data) {
                        if (data.success) {
                            swal('Project updated!', "", "success");
                            $scope.project = data.project;
                            $scope.project_error = $scope.project_error_empty;

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
    }
]);
