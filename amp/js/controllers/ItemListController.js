angular.module('app').controller('ItemListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies){
	$scope.items= [];
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
					attribute: 'created_time',
					type: 'DESC',
				};
	$scope.pages= [];
	$scope.currentPage= 1;
	$scope.start_item= 1;
	$scope.end_item= 1;
	$scope.totalresults= 0;

	$scope.search_item = {
		id: '',
		created: '',
		name :'',
	};

	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	// Setting Item
	$scope.getItems= function(post_information){
		$http.post(BASE_URL + '/item/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_item= data.start_item;
				$scope.end_item= data.end_item;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.items= [];
		    	$scope.items = data.items;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.getItems();

	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_item.id,
								'created': $scope.search_item.created,

								'name': $scope.search_item.name,
							};
		$scope.getItems(post_information);
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
								
								'id': $scope.search_item.id,
								'created': $scope.search_item.created,

								'name': $scope.search_item.name,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getItems(post_information);
	}, true);

	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_item.id,
								'created': $scope.search_item.created,

								'name': $scope.search_item.name,
							};
		if($scope.search_change_number>1)
			$scope.getItems(post_information);
	}, true);

	$scope.search = function(){
		post_information.name = $scope.search_item.name;

		$scope.getItems(post_information);
	}

	// Edit Item
	$scope.editItem = function(item){
		item.is_edit = true;
	};

	$scope.removeItem = function(item, index){
		if(item.id == undefined){
			$scope.items.splice(index, 1);
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
				var information_post = item;
				$http.post(BASE_URL + '/item/removeItem', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.items.splice(index, 1);
		                item.is_edit = false;
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

	$scope.saveItem = function(item){
		var information_post= item;
		$http.post(BASE_URL + '/item/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	item.is_edit = false;
               	item.id = data.id;
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

	$scope.addItem = function(){
		$scope.items.unshift({
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