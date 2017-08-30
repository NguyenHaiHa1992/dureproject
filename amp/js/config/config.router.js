'use strict';

/**
 * @ngdoc function
 * @name app.config:uiRouter
 * @description
 * # Config
 * Config for the router
 */
angular.module('app', [
    'ui.router',
    'oc.lazyLoad',
    'ngCookies',
    'angularFileUpload',
    'truncate',
    'angular.chosen',
    'ngCookies',
    'ngClipboard',
    //'highcharts-ng',
    'ngTagsInput',
    'LocalStorageModule',
])
.constant('BASE_URL', './server/index.php/api')
.constant('USER_ROLES', {
    all: '*',
    admin: 'admin',
    editor: 'editor',
    guest: 'guest'
})

.config(function ($httpProvider) {
    $httpProvider.interceptors.push([
        '$injector',
        function ($injector) {
            return $injector.get('AuthInterceptor');
        }
    ]);
})

.factory('AuthInterceptor', function ($rootScope, $q) {
    return {
        responseError: function (response) {
            return $q.reject(response);
        }
    };
})

.run(
    ['$rootScope', '$state', '$stateParams', '$http', '$templateCache', 'BASE_URL',
        function ($rootScope, $state, $stateParams, $http, $templateCache, BASE_URL) {
            $rootScope.$state = $state;
            $rootScope.$stateParams = $stateParams;

            // Check user information before any action
            $rootScope.$on('$stateChangeSuccess', function (event, toState) {
                $http.post(BASE_URL + '/user/isUser', {})
                .success(function (data) {
                    if (data.success) {
                        $rootScope.is_amp_guest = false;
                        $rootScope.user_name = data.user_name;
                        $rootScope.user_email = data.user_email;
                        $rootScope.user_id = data.id;
                        $rootScope.is_superadmin = data.is_superadmin;

                        if (toState.name == 'login') {
                            $state.go('home');
                        }
                    }
                    else {
                        $rootScope.is_amp_guest = true;
                        $state.go('login');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            });

            // Remove cache when route change
            /*
            $rootScope.$on('$routeChangeStart', function (event, next, current) {
                if (typeof (current) !== 'undefined') {
                    $templateCache.remove(current.templateUrl);
                }
            });
            */
        }
    ]
)

.config(
    ['$stateProvider', '$locationProvider', '$urlRouterProvider', '$ocLazyLoadProvider',
        function ($stateProvider, $locationProvider, $urlRouterProvider, $ocLazyLoadProvider) {
            $urlRouterProvider.otherwise('/login');

            $stateProvider
            .state('home', {
                url: '/home',
                views: {
                    "lazyLoadView": {
                        controller: 'HomeController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/home/home.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/home/HomeController.js'
                        ]});
                    }]
                }
            })

            .state('store-create', {
                url: '/store-create',
                views: {
                    lazyLoadView: {
                        controller: 'StoreCreateController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/store/store-create.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/store/StoreCreateController.js',
                        ]});
                    }]
                }
            })
            .state('store-detail', {
                url: '/store-detail/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'StoreDetailController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/store/store-detail.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/store/StoreDetailController.js',
                        ]});
                    }]
                }
            })
            .state('store-view', {
                url: '/store-view/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'StoreViewController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/store/store-view.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/store/StoreViewController.js',
                        ]});
                    }]
                }
            })
            .state('store-list', {
                url: '/store-list',
                views: {
                    "lazyLoadView": {
                        controller: 'StoreListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/store/store-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/store/StoreListController.js'
                        ]});
                    }]
                }
            })

            .state('signage-create', {
                url: '/signage-create',
                views: {
                    lazyLoadView: {
                        controller: 'SignageCreateController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/signage/signage-create.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/signage/SignageCreateController.js',
                        ]});
                    }]
                }
            })
            .state('signage-detail', {
                url: '/signage-detail/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'SignageDetailController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/signage/signage-detail.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/signage/SignageDetailController.js',
                        ]});
                    }]
                }
            })
            .state('signage-view', {
                url: '/signage-view/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'SignageViewController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/signage/signage-view.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/signage/SignageViewController.js',
                        ]});
                    }]
                }
            })
            .state('signage-list', {
                url: '/signage-list',
                views: {
                    "lazyLoadView": {
                        controller: 'SignageListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/signage/signage-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/signage/SignageListController.js'
                        ]});
                    }]
                }
            })

            .state('fixture-create', {
                url: '/fixture-create',
                views: {
                    lazyLoadView: {
                        controller: 'FixtureCreateController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/fixture/fixture-create.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/fixture/FixtureCreateController.js',
                        ]});
                    }]
                }
            })
            .state('fixture-detail', {
                url: '/fixture-detail/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'FixtureDetailController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/fixture/fixture-detail.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/fixture/FixtureDetailController.js',
                        ]});
                    }]
                }
            })
            .state('fixture-view', {
                url: '/fixture-view/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'FixtureViewController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/fixture/fixture-view.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/fixture/FixtureViewController.js',
                        ]});
                    }]
                }
            })
            .state('fixture-list', {
                url: '/fixture-list',
                views: {
                    "lazyLoadView": {
                        controller: 'FixtureListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/fixture/fixture-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/fixture/FixtureListController.js'
                        ]});
                    }]
                }
            })
            /*
             * @author tunghus1993@gmail.com
             * list customer
             */
            .state('customer-list',{
                url: '/customer-list',
                views: {
                    "lazyLoadView": {
                        controller: 'CustomerListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/customer/customer-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/customer/CustomerListController.js',
                                ]});
                        }]
                }
            })
            .state('customer-detail', {
                url: '/customer-detail/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'CustomerDetailController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/customer/customer-detail.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/customer/CustomerDetailController.js'
                        ]});
                    }]
                }
            })
            .state('customer-view', {
                url: '/customer-view/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'CustomerViewController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/customer/customer-view.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/customer/CustomerViewController.js',
                        ]});
                    }]
                }
            })
            /*
             * @author tunghus1993@gmail.com
             * create customer
             */
            .state('customer-create', {
                url: '/customer-create',
                views: {
                    lazyLoadView: {
                        controller: 'CustomerCreateController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/customer/customer-create.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/customer/CustomerCreateController.js',
                        ]});
                    }]
                }
            })
    
            .state('user-list', {
                url: '/user-list',
                views: {
                    "lazyLoadView": {
                        controller: 'UserListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/user/user-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/user/UserListController.js',
                                ]});
                        }]
                }
            })
            .state('user-detail', {
                url: '/user-detail/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'UserDetailController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/user/user-detail.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/user/UserDetailController.js',
                                ]});
                        }]
                }
            })

            .state('state-create', {
                url: '/state-create',
                views: {
                    "lazyLoadView": {
                        controller: 'StateCreateController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/state-create.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/StateCreateController.js',
                                ]});
                        }]
                }
            })
            .state('state-list', {
                url: '/state-list',
                views: {
                    "lazyLoadView": {
                        controller: 'StateListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/state-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/StateListController.js',
                                ]});
                        }]
                }
            })

            .state('email-send', {
                url: '/email-send/:type/:id/:option',
                views: {
                    "lazyLoadView": {
                        controller: 'EmailSendController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/email-send.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/EmailSendController.js',
                                ]});
                        }]
                }
            })
            .state('email-template-list', {
                url: '/email-template-list',
                views: {
                    "lazyLoadView": {
                        controller: 'EmailTemplateListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/email-template-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/EmailTemplateListController.js',
                                ]});
                        }]
                }
            })

            .state('login', {
                url: '/login',
                views: {
                    "lazyLoadView": {
                        controller: 'LoginController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/login.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/libs/angular-cookies.js',
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/LoginController.js',
                                ]});
                        }]
                }
            })

            .state('file', {
                url: '/file',
                views: {
                    "lazyLoadView": {
                        controller: 'FileController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/file/file.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/file/FileController.js'
                        ]});
                    }]
                }
            })

            .state('file-list', {
                url: '/file-list',
                views: {
                    "lazyLoadView": {
                        controller: 'FileListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/file/file-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/file/FileListController.js',
                                ]});
                        }]
                }
            })

            /*
            .state('file-list', {
                url: '/file-list/:category/:code',
                views: {
                    "lazyLoadView": {
                        controller: 'FileListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/file-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/FileListController.js',
                                ]});
                        }]
                }
            })
            */

            .state('setting', {
                url: '/setting',
                views: {
                    "lazyLoadView": {
                        controller: 'SettingController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/setting/setting.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                                'amp/js/config/app.js',
                                'amp/js/config/constant.js',
                                'amp/js/controllers/setting/SettingController.js',
                            ]});
                    }]
                }
            })

            .state('history-list', {
                url: '/history-list/:class/:id',
                views: {
                    "lazyLoadView": {
                        controller: 'HistoryListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/history-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/HistoryListController.js',
                                ]});
                        }]
                }
            })
            
            .state('store-signage', {
                url: '/store-signage',
                views: {
                    "lazyLoadView": {
                        controller: 'StoreSignageController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/store-signage/list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/store-signage/StoreSignageController.js'
                        ]});
                    }]
                }
            })
            /**
             * @author tunghus1993@gmail.com
             * add controller project-list
             */
            .state('project-list',{
                url:'/project-list',
                views:{
                    "lazyLoadView":{
                        controller:"ProjectListController",
                        templateUrl:'amp/views/project/list.html'
                    }
                },
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/project/ProjectListController.js'
                        ]});
                    }]
                },
            })
            /**
             * @author tunghus1993@gmail.com
             * add controller project-view
             */
            .state('project-view',{
                url:'/project-view',
                views:{
                    "lazyLoadView":{
                        controller:"ProjectViewController",
                        templateUrl:'amp/views/project/view.html'
                    }
                },
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/project/ProjectViewController.js'
                        ]});
                    }]
                },
            })
            /**
             * @author tunghus1993@gmail.com
             * add controller project-detail
             */
            .state('project-detail',{
                url:'/project-detail',
                views:{
                    "lazyLoadView":{
                        controller:"ProjectDetailController",
                        templateUrl:'amp/views/project/detail.html'
                    }
                },
                resolve: {
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/project/ProjectDetailController.js'
                        ]});
                    }]
                },
            })

            .state('project-create', {
                url: '/project-create',
                views: {
                    lazyLoadView: {
                        controller: 'ProjectCreateController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/project/create.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                        // you can lazy load files for an existing module
                        return $ocLazyLoad.load({files: [
                            'amp/js/config/app.js',
                            'amp/js/config/constant.js',
                            'amp/js/controllers/project/ProjectCreateController.js',
                        ]});
                    }]
                }
            })
    
            .state('404', {
                url: '/404',
                views: {
                    "lazyLoadView": {
                        templateUrl: 'amp/views/404.html'
                    }
                },
            })

            /*
            .state('employee-list', {
                url: '/employee-list',
                views: {
                    "lazyLoadView": {
                        controller: 'EmployeeListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/employee-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/EmployeeListController.js',
                                ]});
                        }]
                }
            })
            .state('employee-create', {
                url: '/employee-create',
                views: {
                    "lazyLoadView": {
                        controller: 'EmployeeCreateController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/employee-create.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/EmployeeCreateController.js',
                                ]});
                        }]
                }
            })

            .state('material-price-list', {
                url: '/material-price-list/:material_id',
                views: {
                    "lazyLoadView": {
                        controller: 'MaterialPriceListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/material-price-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/MaterialPriceListController.js',
                                ]});
                        }]
                }
            })
            .state('material-price-create', {
                url: '/material-price-create',
                views: {
                    "lazyLoadView": {
                        controller: 'MaterialPriceCreateController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/material-price-create.html',
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/MaterialPriceCreateController.js',
                                ]});
                        }]
                }
            })

            .state('item-list', {
                url: '/item-list',
                views: {
                    "lazyLoadView": {
                        controller: 'ItemListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/item-list.html',
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/ItemListController.js',
                                ]});
                        }]
                }
            })

            .state('material-code-list', {
                url: '/material-code-list',
                views: {
                    "lazyLoadView": {
                        controller: 'MaterialCodeListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/material-code-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/MaterialCodeListController.js',
                                ]});
                        }]
                }
            })

            .state('coc-list', {
                url: '/coc-list',
                views: {
                    "lazyLoadView": {
                        controller: 'CocListController', // This view will use AppCtrl loaded below in the resolve
                        templateUrl: 'amp/views/coc-list.html'
                    }
                },
                resolve: {// Any property in resolve should return a promise and is executed before the view is loaded
                    loadMyCtrl: ['$ocLazyLoad', function ($ocLazyLoad) {
                            // you can lazy load files for an existing module
                            return $ocLazyLoad.load({files: [
                                    'amp/js/config/app.js',
                                    'amp/js/config/constant.js',
                                    'amp/js/controllers/CocListController.js'
                                ]});
                        }]
                }
            });
            */

            $locationProvider.html5Mode(true);

            // $ocLazyLoadProvider.config({
            //     modules: [{
            //         name: 'constant',
            //         files: [
            //         'amp/js/libs/angular-cookies.js'
            //         ]
            //     }]
            // });
        }
    ]
)

.config(['ngClipProvider', function (ngClipProvider) {
    ngClipProvider.setPath("amp/js/libs/ZeroClipboard.swf");
}])

.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });

                event.preventDefault();
            }
        });
    };
})

.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;

            element.bind('change', function () {
                scope.$apply(function () {
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}])


;
