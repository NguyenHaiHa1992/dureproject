angular.module('app').controller('PartListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.parts= [];
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
	$scope.start_part= 1;
	$scope.end_part= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};

	$scope.search_part = {
		part_code :'', 
		category_id : '',
		id: '',
		name: '',
		created: '',
		description: '',
		client_id: ''
	};

	$scope.locations= [];

	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	$scope.init= function(){
		$http.post(BASE_URL + '/partCategory/getAll', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.part_categories = data.part_categories;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});

		$http.post(BASE_URL + '/part/listInit', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.employees = data.employees;
				$scope.purchase_orders = data.purchase_orders;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});

		$http.post(BASE_URL + '/partLocation/getAll', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.locations = data.locations;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});

	};
	$scope.init();

	$scope.getParts= function(post_information){
		$http.post(BASE_URL + '/part/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_part= data.start_part;
				$scope.end_part= data.end_part;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.parts= [];
		    	$scope.parts= data.parts;
		    	$scope.locations= data.locations;

		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getParts(post_information);
	
	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_part.id,
								'name': $scope.search_part.name,
								'created': $scope.search_part.created,

								'part_code': $scope.search_part.part_code,
								'category_id': $scope.search_part.category_id,
								'client_id': $scope.search_part.client_id,
							};
		$scope.getParts(post_information);
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
								
								'id': $scope.search_part.id,
								'name': $scope.search_part.name,
								'created': $scope.search_part.created,

								'part_code': $scope.search_part.part_code,
								'category_id': $scope.search_part.category_id,
								'client_id': $scope.search_part.client_id,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getParts(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_part.id,
								'name': $scope.search_part.name,
								'created': $scope.search_part.created,

								'part_code': $scope.search_part.part_code,
								'category_id': $scope.search_part.category_id,
								'description': $scope.search_part.description,
								'client_id': $scope.search_part.client_id,
							};
		if($scope.search_change_number>1)
			$scope.getParts(post_information);
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
								
								'id': $scope.search_part.id,
								'name': $scope.search_part.name,
								'created': $scope.search_part.created,

								'part_code': $scope.search_part.part_code,
								'category_id': $scope.search_part.category_id,
								'description': $scope.search_part.description,
								'client_id': $scope.search_part.client_id,
							};
		$scope.getParts(post_information);
	};
	
	$scope.viewDetail = function(part){
		$rootScope.view_detail_part_id= part.id;
		$state.go('part-create');
	};

	$scope.search = function(){
		post_information.part_code = $scope.search_part.part_code;
		post_information.category_id = $scope.search_part.category_id; 
		post_information.description = $scope.search_part.description; 
		post_information.client_id = $scope.search_part.client_id; 

		$scope.getParts(post_information);
	}

	// Check in
	$scope.checkIn = function(part){
		$scope.selected_part = part;
		$scope.check_in_part = {};
		$scope.check_in_part.heatnumbers = [];
		$scope.check_in_part_error = {};
		$('#checkInModal').modal('show');

	    $timeout(function() {
			$('.chosen_select').chosen('destroy').trigger('chosen:updated').chosen();
		}, 0, false);
	}

	$scope.checkInUpdateHeatnumbers = function(check_in_part){
		// Insert
		for(var i = 0; i < check_in_part.heatnumber_ids.length; i++){
			var id = check_in_part.heatnumber_ids[i];

			for(var j = 0; j < $scope.selected_part.heatnumbers.length; j++){
				var c = $scope.selected_part.heatnumbers[j];

				var check_exist = false;
				for(var t = 0; t < check_in_part.heatnumbers.length; t++){
					d = check_in_part.heatnumbers[t];
					if(d.id == id)
						check_exist = true;
				}
				if(!check_exist && c.id == id){
					check_in_part.heatnumbers.push({
						id: c.id,
						heatnumber : c.heatnumber,
						drawing : c.drawing,
						quantity: 0,
			    	});
			    }
			}
		}

		// Remove
		for(var t = 0; t < check_in_part.heatnumbers.length; t++){
			d = check_in_part.heatnumbers[t];
			var check_exist = false;

			for(var i = 0; i < check_in_part.heatnumber_ids.length; i++){
				var id = check_in_part.heatnumber_ids[i];

				if(d.id == id)
					check_exist = true;
			}

			if(!check_exist){
				check_in_part.heatnumbers.splice(t, 1);
			}
		}
	}

	// Submit check in
	$scope.submitCheckIn = function(){
		$('#checkInModal').modal('hide');
		$http.post(BASE_URL + '/part/checkin', {id: $scope.selected_part.id, check_in: $scope.check_in_part})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.selected_part.quantity = data.quantity;
		    	$scope.selected_part.heatnumbers = data.heatnumbers;
		    	$scope.check_in_part = {};
		    	$scope.check_in_part_error = {};
		    	swal('Success', data.message, "success");

				jQuery('#checkInModal input, #checkInModal select').removeClass('ng-dirty');
		    }
		    else{
		    	$('#checkInModal').modal('show');
		    	swal({
		    		title: 'Error',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    	$scope.check_in_part_error = data.check_in_part_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	// Check out
	$scope.checkOut = function(part){
		$scope.selected_part = part;
		$scope.check_out_part = {};
		$scope.check_out_part.heatnumbers = [];
		$scope.check_out_part_error = {};
		$('#checkOutModal').modal('show');

	    $timeout(function() {
			$('.chosen_select').chosen('destroy').trigger('chosen:updated').chosen();
		}, 0, false);
	}

	$scope.checkOutUpdateHeatnumbers = function(check_out_part){
		// Insert
		for(var i = 0; i < check_out_part.heatnumber_ids.length; i++){
			var id = check_out_part.heatnumber_ids[i];

			for(var j = 0; j < $scope.selected_part.heatnumbers.length; j++){
				var c = $scope.selected_part.heatnumbers[j];

				var check_exist = false;
				for(var t = 0; t < check_out_part.heatnumbers.length; t++){
					d = check_out_part.heatnumbers[t];
					if(d.id == id)
						check_exist = true;
				}
				if(!check_exist && c.id == id){
					check_out_part.heatnumbers.push({
						id: c.id,
						heatnumber : c.heatnumber,
						drawing : c.drawing,
						quantity: 0,
			    	});
			    }
			}
		}

		// Remove
		for(var t = 0; t < check_out_part.heatnumbers.length; t++){
			d = check_out_part.heatnumbers[t];
			var check_exist = false;

			for(var i = 0; i < check_out_part.heatnumber_ids.length; i++){
				var id = check_out_part.heatnumber_ids[i];

				if(d.id == id)
					check_exist = true;
			}

			if(!check_exist){
				check_out_part.heatnumbers.splice(t, 1);
			}
		}
	}

	// Submit check out
	$scope.submitCheckOut = function(){
		$('#checkOutModal').modal('hide');
		$http.post(BASE_URL + '/part/checkout', {id: $scope.selected_part.id, check_out: $scope.check_out_part})
	    .success(function(data) {
		    if(data.success) {
				$scope.selected_part.quantity = data.quantity;
				$scope.selected_part.heatnumbers = data.heatnumbers;
		    	$scope.check_out_part = {};
		    	$scope.check_out_part_error = {};

		    	swal('Success', data.message, "success");

				jQuery('#checkOutModal input, #checkOutModal select').removeClass('ng-dirty');
		    }
		    else{
		    	$('#checkOutModal').modal('show');
		    	swal({
		    		title: 'Error',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    	$scope.check_out_part_error = data.check_out_part_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.viewDetailInOutPart = function(item){
		if(item.type_label == 'Check-in'){
			$scope.check_in_part = item;
			$scope.check_in_part.is_readonly = true;
			$('#checkInModal').modal('show');
		}

		if(item.type_label == 'Check-out'){
			$scope.check_out_part = item;
			$scope.check_out_part.is_readonly = true;
			$('#checkOutModal').modal('show');
		}
	}

	// View quantity detail
	$scope.viewQuantity = function(part){
		$scope.selected_part = part;
		$('#viewQuantityModal').modal('show');
	}

	// Add heatnumber quantity detail
	$scope.addQuantityDetail = function(heatnumber){
			if(heatnumber.quantity_details == undefined)
				heatnumber.quantity_details = [];

			heatnumber.quantity_details.push({
				quantity: "",
				location_id: ""
			});
	}

	// Get location by id
	$scope.getLocationAttrById = function(id, attr){
		var result = {};
		$.each($scope.locations, function(i,v){
			if(id == v.id){
				result = v;
			}
		})

		return result[attr];
	}

	$scope.changeHeatnumberLocationQty = function(heatnumber, item){
		if(item.quantity <= 0){
	    	swal({
	    		title: 'Error',
	    		text: 'Quantity must be bigger than zero',
	    		type: 'error',
	    		html: true
	    	});

	    	item.quantity = "";
		}
		else{
			var total_quantity = 0;

			$.each(heatnumber.quantity_details, function(i,v){
				total_quantity = total_quantity + parseInt(v.quantity);
			})

			heatnumber.quantity = total_quantity;
		}
	}

	$scope.changeHeatnumberLocationId = function(heatnumber, item, $index){
		$.each(heatnumber.quantity_details, function(i,v){
			if($index != i && item.location_id == v.location_id){
		    	swal({
		    		title: 'Error',
		    		text: 'This Location has been selected, please select an other Location',
		    		type: 'error',
		    		html: true
		    	});

		    	item.location_id = "";
			}
		})
	}

	$scope.removeHeatnumerQuantityDetail = function(heatnumber, $index){
		heatnumber.quantity_details.splice($index, 1);

		var total_quantity = 0;
		$.each(heatnumber.quantity_details, function(i,v){
			total_quantity = total_quantity + parseInt(v.quantity);
		})

		heatnumber.quantity = total_quantity;
	}

	// Show heatnumber detail popup
	$scope.getHeatnumberDetailInfo = function(heatnumber){
		var information_post = heatnumber;
		$http.post(BASE_URL + '/part/getHeatnumberDetailInfo', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.selected_heatnumber = heatnumber;
		    	$scope.selected_heatnumber.detail_information = data.location_heatnumbers;
		    	$('#heatnumberDetailModal').modal('show');
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
	}
	// end of detail popup

	/************ Date picker **************/
	$('body').on('click', 'input.datepicker', function(event) {
	    $(this).datepicker({
	    	isOpen: true,
	        showOn: 'focus',
	        yearRange: '1900:+0',
	        changeMonth: true,
	        changeYear: true,
			format: 'yyyy-mm-dd',

	    }).focus().on('changeDate', function(e){
			$(this).datepicker('hide');
		});
	});

	/************ Check for advance search popup *************/
	function getQueryParam( name ){
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");  
	  var regexS = "[\\?&]"+name+"=([^&#]*)";  
	  var regex = new RegExp( regexS );  
	  var results = regex.exec( window.location.href ); 
	   if( results == null )    return "";  
	  else    return results[1];
	}

	if(getQueryParam('type')){
		$timeout( function(){
			$('.main-header, .tool_box, .breadcrumb, .main-footer').hide();

			$scope.viewDetail = function(part){
				if (window.opener != null && !window.opener.closed) {
					$scope.parentWindow = window.opener.$windowScope;
					$scope.parentWindow.$emit('selectPart', part);
					window.close();
		        }
			}
		}, 0);
	}
}]);