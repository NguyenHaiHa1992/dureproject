/*jshint globalstrict:true*/
'use strict';

var isDefined = angular.isDefined,
	isUndefined = angular.isUndefined,
	isNumber = angular.isNumber,
	isObject = angular.isObject,
	isArray = angular.isArray,
	extend = angular.extend,
	toJson = angular.toJson;

// Test if string is only contains numbers
// e.g '1' => true, "'1'" => true
function isStringNumber(num) {
	return  /^-?\d+\.?\d*$/.test(num.replace(/["']/g, ''));
}

// //Constants
// var app = angular.module('app')
//     .constant('BASE_URL', './server/index.php/api')
// 	.constant('USER_ROLES', {
// 		all: '*',
// 		admin: 'admin',
// 		editor: 'editor',
// 		guest: 'guest'
// 	})

// 	.config(function ($httpProvider) {
// 		$httpProvider.interceptors.push([
// 			'$injector',
// 			function ($injector) {
// 				return $injector.get('AuthInterceptor');
// 			}
// 			]);
// 	})

// 	.factory('AuthInterceptor', function ($rootScope, $q) {
// 		return {
// 			responseError: function (response) { 
// 				return $q.reject(response);
// 			}
// 		};
// 	})
// ;