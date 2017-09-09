angular.module('app').controller('ProjectViewController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window) {
	$scope.root = $rootScope;
        $scope.init_loaded = true;
        
        $scope.getProjectById = function () {
            $http.post(BASE_URL + '/project/getProjectById', {id: $stateParams.id})
            .success(function (data) {
                if (data.success) {
                    $scope.project = data.project;
                    // process to get label attribute project
                    preProcessProject();
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

        $scope.copyToClipboard = function () {
            swal({
                title: 'Copied to clipboard!',
                text: jQuery('#project_card').html(),
                type: 'success',
                html: true
            });
        }
        
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
        
        function preProcessProject(){
//            $scope.customer_name = $scope;
            $scope.project.type_product_label = $scope.project.life_style == 'type_other' ? $scope.project.other_type_product : $scope.project.life_style;
            $scope.project.service_label = $scope.project.service == 'type_other' ? $scope.project.other_service : $scope.project.service;
            $scope.project.product_match_label = $scope.project.product_match == '1' ? "Yes" : 'No';
            console.log("After preProcessProject : "+ ($scope.project.type_product_label));
        }
        
//        $scope.selectedSignageIds = [];
//	$scope.toggleSignageSelection = function toggleSignageSelection(id) {
//	    var idx = $scope.selectedSignageIds.indexOf(id);
//
//	    if (idx > -1) {
//	      $scope.selectedSignageIds.splice(idx, 1);
//	    }
//	    else {
//	      $scope.selectedSignageIds.push(id);
//	    }
//	};
        
//        $scope.selectedFixtureIds = [];
//	$scope.toggleFixtureSelection = function toggleFixtureSelection(id) {
//	    var idx = $scope.selectedFixtureIds.indexOf(id);
//
//	    if (idx > -1) {
//	      $scope.selectedFixtureIds.splice(idx, 1);
//	    }
//	    else {
//	      $scope.selectedFixtureIds.push(id);
//	    }
//	};
    }
]);
