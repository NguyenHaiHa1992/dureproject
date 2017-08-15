'use strict';

//var app = angular.module('app', ['ui.router']);

// var app = angular.module('app', [
// 		'ui.router',
// 		'oc.lazyLoad',
// 		'ngCookies',
// 		'angularFileUpload',
// 		'truncate',
// 		'angular.chosen',
// 		'ngCookies',
// 		'ngClipboard',
// 		'highcharts-ng',
// 		'ngTagsInput',
// 		'LocalStorageModule',
// 		// 'ngSanitize', 
// 		// 'ui.select',
// 	]).run(['$rootScope', '$state', '$http', 'BASE_URL', '$cookies','$templateCache', '$location',
// 			function($rootScope, $state, $http, BASE_URL, $cookies, $templateCache, $location) {
// 				if($rootScope.is_amp_guest == undefined)
// 					$rootScope.is_amp_guest = true;

// 	 			// Check user information before any action
// 	 			$rootScope.$on('$stateChangeStart', function(event, toState) {
// 					$http.post(BASE_URL + '/user/isUser', {})
// 				    .success(function(data) {
// 					    if(data.success) {
// 					    	$rootScope.is_amp_guest = false;
// 					    	$rootScope.user_name = data.user_name;
// 					    	$rootScope.user_email = data.user_email;
// 					    	$rootScope.user_id = data.id;
					    	
// 					    	if(toState.name == 'login'){
// 					    		$state.go('home');
// 					    	}
// 					    }
// 					    else{
// 					    	$rootScope.is_amp_guest = true;
// 					    	$state.go('login');
// 					    }
// 					})
// 					.error(function(data, status, headers, config) {
// 			    		$state.go('404');	
// 			  		});
// 				});

// 		 		// Remove cache when route change
// 			    $rootScope.$on('$routeChangeStart', function(event, next, current) {
// 			        if (typeof(current) !== 'undefined'){
// 			            $templateCache.remove(current.templateUrl);
// 			        }
// 			    });

// 			}])

// 			.config(['ngClipProvider', function(ngClipProvider) {
// 				ngClipProvider.setPath("amp/js/libs/ZeroClipboard.swf"); 
// 			}])

//angular.module('app.controllers',[]);