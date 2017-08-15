angular.module('app').controller('PartLocationListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies){
	$scope.part_locations= [];
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
	$scope.start_part_location= 1;
	$scope.end_part_location= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'id',
					type: 'DESC',
				};
	$scope.search_location= {
						id: '',
						shelf: '',
						section: '',
						box: '',
					};
	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	// Setting PartLocation
	$scope.getPartLocations= function(post_information){
		$http.post(BASE_URL + '/partLocation/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_part_location= data.start_part_location;
				$scope.end_part_location= data.end_part_location;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.part_locations= [];
		    	$scope.part_locations = data.locations;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getPartLocations(post_information);

	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_location.id,
								'shelf': $scope.search_location.shelf,
								'section': $scope.search_location.section,
								'box': $scope.search_location.box,
							};
		$scope.getPartLocations(post_information);
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
								
								'id': $scope.search_location.id,
								'shelf': $scope.search_location.shelf,
								'section': $scope.search_location.section,
								'box': $scope.search_location.box,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getPartLocations(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_location.id,
								'shelf': $scope.search_location.shelf,
								'section': $scope.search_location.section,
								'box': $scope.search_location.box,
							};
		if($scope.search_change_number>1)
			$scope.getPartLocations(post_information);
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
								
								'id': $scope.search_location.id,
								'shelf': $scope.search_location.shelf,
								'section': $scope.search_location.section,
								'box': $scope.search_location.box,
							};
		$scope.getPartLocations(post_information);
	};

	$scope.search = function(){
		post_information.shelf = $scope.search_location.shelf;
		post_information.section = $scope.search_location.section;
		post_information.box = $scope.search_location.box;

		$scope.getPartLocations(post_information);
	}

	// Edit PartLocation
	$scope.editPartLocation = function(part_location){
		part_location.is_edit = true;
	};

	$scope.removePartLocation = function(part_location, index){
		if(part_location.id == undefined){
			$scope.part_locations.splice(index, 1);
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
				var information_post = part_location;
				$http.post(BASE_URL + '/partLocation/removePartLocation', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.part_locations.splice(index, 1);
		                part_location.is_edit = false;
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

	$scope.savePartLocation = function(part_location){
		var information_post= part_location;
		$http.post(BASE_URL + '/partLocation/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	part_location.is_edit = false;
               	part_location.id = data.id;
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

	$scope.addPartLocation = function(){
		$scope.part_locations.unshift({
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