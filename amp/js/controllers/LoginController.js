angular.module('app').controller('LoginController', ['$rootScope','$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies',
function($rootScope, $scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies){
	if(typeof $cookies.user_id == 'undefined'){
		$rootScope.is_login_page = true;
		$rootScope.is_amp_guest = true;
	
		$scope.email= '';
		$scope.password= '';
		$scope.rememberMe= false;
		$scope.loginError = '';
		$scope.loggedUser = '';

		$scope.login = function () {
			
			$http.post(BASE_URL + '/user/login', {email: $scope.email, password: $scope.password, rememberMe: $scope.rememberMe})
		    .success(function(data) {
			    if(data.success){
			    	$scope.loggedUser = data.message;
			    	$scope.loginError = '';
			    	$timeout(function() {
				        $rootScope.is_amp_guest = false;
				    	$rootScope.user_name = data.user_name;
				    	$rootScope.user_email = data.user_email;
						$rootScope.user_id = data.id;

			    		$state.go('home');
				    }, 1000);
			    }
			    else{
		    		$scope.loginError = data.message;
		    		$scope.loggedUser = '';
					$rootScope.is_amp_guest = true;
		    		$state.go('login');
		    		return false;
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});
		 };
	
		// Jquery
		$('input').iCheck({
			checkboxClass : 'icheckbox_square-blue',
			radioClass : 'iradio_square-blue',
			increaseArea : '20%' // optional
		});	
	}
	else{
		$state.go('home');
	}
}]);