angular.module('app').controller('EmployeeListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies){
	$scope.employees= [];
	$scope.itemsByPage= 10;
	$scope.itemsByPages= [
							{
								value: 10,
								name: 10
							},
							{
								value: 20,
								name: 20
							},
							{
								value: 30,
								name: 30
							},
						];
	$scope.pages= [];
	$scope.currentPage= 1;
	$scope.start_employee= 1;
	$scope.end_employee= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};
	$scope.search_employee= {
						id: '',
						name: '',
						created: '',
					};
	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};
	// Setting Employee
	$scope.getEmployees= function(post_information){
		$http.post(BASE_URL + '/employee/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_employee= data.start_employee;
				$scope.end_employee= data.end_employee;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.employees= [];
		    	$scope.employees= data.employees;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getEmployees();

	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_employee.id,
								'name': $scope.search_employee.name,
								'created': $scope.search_employee.created,
							};
		$scope.getEmployees(post_information);
	};
	
	$scope.itemsByPage_change_number= 0;
	$scope.$watch('itemsByPage', function(){
		$scope.itemsByPage_change_number++;
		if($scope.itemsByPage== 0 || $scope.itemsByPage== '0' || $scope.itemsByPage== '' || $scope.itemsByPage== null)
			$scope.itemsByPage= 1;
		var post_information= {
								'limitstart': 0,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_employee.id,
								'name': $scope.search_employee.name,
								'created': $scope.search_employee.created,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getEmployees(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_employee.id,
								'name': $scope.search_employee.name,
								'created': $scope.search_employee.created,
							};
		if($scope.search_change_number>1)
			$scope.getEmployees(post_information);
	}, true);
	
	$scope.sort= function(sort_attribute){
		if($scope.sort.attribute== sort_attribute)
			if($scope.sort.type== 'DESC')
				$scope.sort.type= 'ASC';
			else
				$scope.sort.type= 'DESC';
		else{
			$scope.sort.attribute= sort_attribute;
			$scope.sort.type= 'DESC';
		}
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_employee.id,
								'name': $scope.search_employee.name,
								'created': $scope.search_employee.created,
							};
		$scope.getEmployees(post_information);
	};

	$scope.search = function(){
		post_information.name = $scope.search_employee.name;

		$scope.getEmployees(post_information);
	}

	// Edit Employee
	$scope.editEmployee = function(employee){
		employee.is_edit = true;
	};

	$scope.removeEmployee = function(employee, index){
		if(employee.id == undefined){
			$scope.employees.splice(index, 1);
		}
		else{
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
				var information_post = employee;
				$http.post(BASE_URL + '/employee/removeEmployee', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.employees.splice(index, 1);
		                employee.is_edit = false;
				    }
				    else{
				    	swal({
				    		title: '',
				    		text: data.message,
				    		type: 'error',
				    		html: true
				    	});
				    }
				})
				.error(function(data, status, headers, config) {
		    		$state.go('404');	
		  		});
		    });
		}
	};

	$scope.saveEmployee = function(employee){
		var information_post= employee;
		$http.post(BASE_URL + '/employee/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	employee.is_edit = false;
               	employee.id = data.id;
		    	swal(data.message, "", "success");
		    }
		    else{
		    	swal({
		    		title: '',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.addEmployee = function(){
		$scope.employees.unshift({
			name : '',
			status: 1,
			is_edit: true,
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
}]);