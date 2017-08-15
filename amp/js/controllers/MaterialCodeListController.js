angular.module('app').controller('MaterialCodeListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies){
	$scope.material_codes= [];
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
	$scope.sort= {
					attribute: 'id',
					type: 'DESC',
				};
	$scope.pages= [];
	$scope.currentPage= 1;
	$scope.start_material_code= 1;
	$scope.end_material_code= 1;
	$scope.totalresults= 0;

	$scope.search_material_code = {
		id: '',
		created: '',
		code :'',
	};

	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	// Get MaterialCode
	$scope.getMaterialCodes= function(post_information){
		$http.post(BASE_URL + '/materialCode/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_material_code= data.start_material_code;
				$scope.end_material_code= data.end_material_code;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.material_codes= [];
		    	$scope.material_codes = data.material_codes;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.getMaterialCodes(post_information);

	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_material_code.id,
								'created': $scope.search_material_code.created,

								'code': $scope.search_material_code.code,
							};
		$scope.getMaterialCodes(post_information);
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
								
								'id': $scope.search_material_code.id,
								'created': $scope.search_material_code.created,

								'code': $scope.search_material_code.code,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getMaterialCodes(post_information);
	}, true);

	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_material_code.id,
								'created': $scope.search_material_code.created,

								'code': $scope.search_material_code.code,
							};
		if($scope.search_change_number>1)
			$scope.getMaterialCodes(post_information);
	}, true);

	$scope.search = function(){
		post_information.code = $scope.search_material_code.code;

		$scope.getMaterialCodes(post_information);
	}

	// Edit MaterialCode
	$scope.editMaterialCode = function(material_code){
		material_code.is_edit = true;
		$scope.edit_material_code = angular.copy(material_code);
	};

	// Cancel Edit MaterialCode
	$scope.cancelEditMaterialCode = function(material_code){
		material_code.is_edit = false;
		material_code.code = $scope.edit_material_code.code;
		material_code.description = $scope.edit_material_code.description;
	};

	$scope.removeMaterialCode = function(material_code, index){
		if(material_code.id == undefined){
			$scope.material_codes.splice(index, 1);
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
				var information_post = material_code;
				$http.post(BASE_URL + '/materialCode/removeMaterialCode', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.material_codes.splice(index, 1);
		                material_code.is_edit = false;
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

	$scope.saveMaterialCode = function(material_code){
		var information_post= {
			id: material_code.id, 
			code: material_code.code, 
			description: material_code.description
		};

		$http.post(BASE_URL + '/materialCode/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	material_code.is_edit = false;
               	material_code.id = data.id;
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

	$scope.addMaterialCode = function(){
		$scope.material_codes.unshift({
			code : '',
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