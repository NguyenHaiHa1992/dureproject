angular.module('app').controller('EmailSendController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$sce',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $sce) {
        $scope.email_title = 'E-Mail';
        $scope.email = {
            from: '',
            to: '',
            subject: '',
            content: '',
            signature: '',
        };
        $scope.email_empty = {};
        $scope.email_error = {
            from: [],
            to: [],
            subject: [],
            content: [],
            signature: [],
        };
        $scope.email_error_empty = {};
        $scope.init = function () {
            var post_information = {type: $stateParams.type, id: $stateParams.id, option: $stateParams.option};
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
        $scope.init();

        $scope.send = function () {
            var information_post = {'email': $scope.email, 'type': $stateParams.type, 'id': $stateParams.id, 'option': $stateParams.option};
            $http.post(BASE_URL + '/email/send', information_post)
            .success(function (data) {
                if (data.success) {
                    $('input, select').removeClass('ng-dirty');
                    swal(data.message, "", "success");
                }
                else {
                    swal(data.message, "", "error");
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };

        $scope.preview = function () {
            var information_post = {'email': $scope.email, 'type': $stateParams.type, 'id': $stateParams.id, 'option': $stateParams.option};
            $http.post(BASE_URL + '/email/preview', information_post)
            .success(function (data) {
                if (data.success) {
                    $scope.email_preview = data.email_preview;
                    $('#previewEmailModal').modal('show');
                }
                else {
                    swal(data.message, "", "error");
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };

        $scope.renderHtml = function (htmlCode) {
            return $sce.trustAsHtml(htmlCode);
        };

        $scope.discard = function () {
            if (jQuery.type($rootScope.view_detail_purchase_order_id) !== "undefined" && $rootScope.view_detail_purchase_order_id != '') {
                $state.go('purchase-order-create');
            }
            else {
                $state.go('home');
            }
        };

        $scope.changeVersionTemplate = function (version) {
            var information_post = {version: version, type: $stateParams.type, id: $stateParams.id, option: $stateParams.option};
            $http.post(BASE_URL + '/email/changeVersionTemplate', information_post)
            .success(function (data) {
                if (data.success) {
                    $scope.email.subject = data.email.subject;
                    $scope.email.content = data.email.content;
                    $scope.email_title = data.email_title;
                }
                else {
                    swal(data.message, "", "error");
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        }
    }]);