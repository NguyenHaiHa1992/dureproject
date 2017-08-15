angular.module('app').controller('MaterialLocationListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies){
	$scope.material_locations= [];
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
	$scope.start_material_location= 1;
	$scope.end_material_location= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'id',
					type: 'DESC',
				};
	$scope.search_location= {
						id: '',
						rack: '',
						row: '',
						box: '',
					};
	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	// Setting MaterialLocation
	$scope.getMaterialLocations= function(post_information){
		$http.post(BASE_URL + '/materialLocation/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_material_location= data.start_material_location;
				$scope.end_material_location= data.end_material_location;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.material_locations= [];
		    	$scope.material_locations = data.locations;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getMaterialLocations(post_information);

	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_location.id,
								'rack': $scope.search_location.rack,
								'row': $scope.search_location.row,
								'box': $scope.search_location.box,
							};
		$scope.getMaterialLocations(post_information);
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
								'rack': $scope.search_location.rack,
								'row': $scope.search_location.row,
								'box': $scope.search_location.box,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getMaterialLocations(post_information);
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
								'rack': $scope.search_location.rack,
								'row': $scope.search_location.row,
								'box': $scope.search_location.box,
							};
		if($scope.search_change_number>1)
			$scope.getMaterialLocations(post_information);
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
								'rack': $scope.search_location.rack,
								'row': $scope.search_location.row,
								'box': $scope.search_location.box,
							};
		$scope.getMaterialLocations(post_information);
	};

	$scope.search = function(){
		post_information.rack = $scope.search_location.rack;
		post_information.row = $scope.search_location.row;
		post_information.box = $scope.search_location.box;

		$scope.getMaterialLocations(post_information);
	}

	// Edit MaterialLocation
	$scope.editMaterialLocation = function(material_location){
		material_location.is_edit = true;
	};

	$scope.removeMaterialLocation = function(material_location, index){
		if(material_location.id == undefined){
			$scope.material_locations.splice(index, 1);
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
				var information_post = material_location;
				$http.post(BASE_URL + '/materialLocation/removeMaterialLocation', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.material_locations.splice(index, 1);
		                material_location.is_edit = false;
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

	$scope.saveMaterialLocation = function(material_location){
		var information_post= material_location;
		$http.post(BASE_URL + '/materialLocation/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	material_location.is_edit = false;
               	material_location.id = data.id;
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

	$scope.addMaterialLocation = function(){
		$scope.material_locations.unshift({
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