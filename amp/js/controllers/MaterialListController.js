angular.module('app').controller('MaterialListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$filter', '$ocLazyLoad',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $filter, $ocLazyLoad){

	$scope.materials= [];
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
	$scope.start_material= 1;
	$scope.end_material= 1;
	$scope.totalresults= 0;
	$scope.locations= [];

	$scope.search_material = {
		id: '',
		name: '',
		created: '',
		material_code :'',
		category_id : '',
	};

	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};

	$scope.init= function(){
		$http.post(BASE_URL + '/materialCategory/getAll', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.material_categories = data.material_categories;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});

		$http.post(BASE_URL + '/vendor/getAll', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.vendors = data.vendors;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});

		$http.post(BASE_URL + '/shape/getAll', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.shapes = data.shapes;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});

		$http.post(BASE_URL + '/material/listInit', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.employees = data.employees;
				$scope.job_orders = data.job_orders;
				$scope.parts = data.parts;
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

	$scope.getMaterials= function(post_information){
		$http.post(BASE_URL + '/material/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_material= data.start_material;
				$scope.end_material= data.end_material;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.materials= [];
		    	$scope.materials= data.materials;
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
	$scope.getMaterials(post_information);
	
	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_material.id,
								'name': $scope.search_material.name,
								'created': $scope.search_material.created,

								'material_code': $scope.search_material.material_code,
								'category_id': $scope.search_material.category_id,
							};
		$scope.getMaterials(post_information);
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
								
								'id': $scope.search_material.id,
								'name': $scope.search_material.name,
								'created': $scope.search_material.created,

								'material_code': $scope.search_material.material_code,
								'category_id': $scope.search_material.category_id,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getMaterials(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search_material.id,
								'name': $scope.search_material.name,
								'created': $scope.search_material.created,

								'material_code': $scope.search_material.material_code,
								'category_id': $scope.search_material.category_id,
							};
		if($scope.search_change_number>1)
			$scope.getMaterials(post_information);
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
								
								'id': $scope.search_material.id,
								'name': $scope.search_material.name,
								'created': $scope.search_material.created,

								'material_code': $scope.search_material.material_code,
								'category_id': $scope.search_material.category_id,
							};
		$scope.getParts(post_information);
	};
	
	$scope.viewDetail = function(material){
		$rootScope.view_detail_material_id= material.id;
		$state.go('material-create');
	};

	// Change shape
	$scope.changeShape = function(){
		$.each($scope.shapes, function(i,v){
			if($scope.search_material.shape_id == v.id){
				$scope.search_material.sizes = {};
				$scope.search_material.size_labels = [];
				$.each(v.sizes, function(i,size){
					$scope.search_material.sizes[size] = '';
					$scope.search_material.size_labels.push(size);
				})
			}
		})

		if($scope.search_material.shape_id === undefined){
			$scope.search_material.sizes = {};
			$scope.search_material.size_labels = [];
		}
	}

	// Change shape size
	$scope.is_change_size = false;
	$scope.changeShapeSize = function(){
		var check = false;
		$.each($('#shape_size_options .size_options'), function(i,v){
			if($(v).val() != ''){
				check = true;
			}
			else{
				var parent = $(v).parent();
				$('input', parent).val('');
			}

		})

		$.each($('#shape_size_options .size_values'), function(i,v){
			if($(v).val() != '') check = true;
		})

		$scope.is_change_size = check;
	}

	$scope.search = function(){
		post_information.material_code = $scope.search_material.material_code;
		post_information.category_id = $scope.search_material.category_id; 
		post_information.shape_id = $scope.search_material.shape_id; 
		post_information.size_labels = $scope.search_material.size_labels; 

		var size_options = [];
		$.each($('#shape_size_options .size_options'), function(i,v){
			size_options.push($(v).val());
		})
		post_information.size_options = size_options;

		var size_values = [];
		$.each($('#shape_size_options .size_values'), function(i,v){
			size_values.push($(v).val());
		})
		
		post_information.is_change_size = $scope.is_change_size;
		post_information.size_values = size_values;

		$scope.getMaterials(post_information);
	}

	// Check in
	$scope.checkIn = function(material){
		$scope.selected_material = material;
		$scope.check_in_material = {};
		$scope.check_in_material.heatnumbers = [];
		$scope.check_in_material_error = {};
		$('#checkInModal').modal('show');
	    $timeout(function() {
			$('.chosen_select').chosen('destroy').trigger('chosen:updated').chosen();
		}, 0, false);
	}

	$scope.checkInUpdateHeatnumbers = function(check_in_material){
		// Insert
		for(var i = 0; i < check_in_material.heatnumber_ids.length; i++){
			var id = check_in_material.heatnumber_ids[i];

			for(var j = 0; j < $scope.selected_material.heatnumbers.length; j++){
				var c = $scope.selected_material.heatnumbers[j];

				var check_exist = false;
				for(var t = 0; t < check_in_material.heatnumbers.length; t++){
					d = check_in_material.heatnumbers[t];
					if(d.id == id)
						check_exist = true;
				}
				if(!check_exist && c.id == id){
					check_in_material.heatnumbers.push({
						id: c.id,
						heatnumber : c.heatnumber,
						designation : c.designation,
						quantity: 0,
						quantity_detail: [],
			    	});
			    }
			}
		}

		// Remove
		for(var t = 0; t < check_in_material.heatnumbers.length; t++){
			d = check_in_material.heatnumbers[t];
			var check_exist = false;

			for(var i = 0; i < check_in_material.heatnumber_ids.length; i++){
				var id = check_in_material.heatnumber_ids[i];

				if(d.id == id)
					check_exist = true;
			}

			if(!check_exist){
				check_in_material.heatnumbers.splice(t, 1);
			}
		}
	}

	// Submit check in
	$scope.submitCheckIn = function(){
		$('#checkInModal').modal('hide');
		$http.post(BASE_URL + '/material/checkin', {id: $scope.selected_material.id, check_in: $scope.check_in_material})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.selected_material.stock_in_hand = data.stock_in_hand;
		    	$scope.selected_material.quantity = data.quantity;
		    	$scope.selected_material.heatnumbers = data.heatnumbers;
		    	$scope.check_in_material = {};
		    	$scope.check_in_material_error = {};
		    	swal('Success', data.message, "success");

				jQuery('#checkInModal input, #checkInModal select').removeClass('ng-dirty');
		    }
		    else{
		    	$('#checkInModal').modal('show');
		    	swal({
		    		title: 'Error',
		    		text: '',
		    		type: 'error',
		    		html: true
		    	});
		    	$scope.check_in_material_error = data.check_in_material_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	// Check out
	$scope.checkOut = function(material){
		$scope.selected_material = material;
		$scope.check_out_material = {};
		$scope.check_out_material.heatnumbers = [];
		$scope.check_out_material_error = {};
		$('#checkOutModal').modal('show');
	    $timeout(function() {
			$('.chosen_select').chosen('destroy').trigger('chosen:updated').chosen();
		}, 0, false);
	}

	$scope.checkOutUpdateHeatnumbers = function(check_out_material){
		// Insert
		for(var i = 0; i < check_out_material.heatnumber_ids.length; i++){
			var id = check_out_material.heatnumber_ids[i];

			for(var j = 0; j < $scope.selected_material.heatnumbers.length; j++){
				var c = $scope.selected_material.heatnumbers[j];

				var check_exist = false;
				for(var t = 0; t < check_out_material.heatnumbers.length; t++){
					d = check_out_material.heatnumbers[t];
					if(d.id == id)
						check_exist = true;
				}
				if(!check_exist && c.id == id){
					check_out_material.heatnumbers.push({
						id: c.id,
						heatnumber : c.heatnumber,
						drawing : c.drawing,
						quantity: 0,
						list_length: c.list_length,
						quantity_detail: [],
			    	});
			    }
			}
		}

		// Remove
		for(var t = 0; t < check_out_material.heatnumbers.length; t++){
			d = check_out_material.heatnumbers[t];
			var check_exist = false;

			for(var i = 0; i < check_out_material.heatnumber_ids.length; i++){
				var id = check_out_material.heatnumber_ids[i];

				if(d.id == id)
					check_exist = true;
			}

			if(!check_exist){
				check_out_material.heatnumbers.splice(t, 1);
			}
		}
	}

	// Submit check out
	$scope.submitCheckOut = function(){
		$('#checkOutModal').modal('hide');
		$http.post(BASE_URL + '/material/checkout', {id: $scope.selected_material.id, check_out: $scope.check_out_material})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.selected_material.stock_in_hand = data.stock_in_hand;
		    	$scope.selected_material.quantity = data.quantity;
		    	$scope.selected_material.heatnumbers = data.heatnumbers;
		    	$scope.check_out_material = {};
		    	$scope.check_out_material_error = {};

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
		    	$scope.check_out_material_error = data.check_out_material_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.watchHeatnumberLength_In = function(){
		var length = 0;
		for(var i = 0; i < $scope.check_in_material.heatnumbers.length; i++){
			var h = $scope.check_in_material.heatnumbers[i];
			length = length + h.length;
		}

		$scope.check_in_material.total_inch = length;
	}

	$scope.watchHeatnumberQuantity_In = function(){
		var quantity = 0;
		for(var i = 0; i < $scope.check_in_material.heatnumbers.length; i++){
			var h = $scope.check_in_material.heatnumbers[i];
			quantity = quantity + h.quantity;
		}

		$scope.check_in_material.quantity = quantity;
		$scope.watchQuantity_In();
	}

	$scope.watchHeatnumberQuantityDetail_In = function(heatnumber){
		var quantity = 0;
		var length = 0;
		for(var i = 0; i < heatnumber.quantity_detail.length; i++){
			var d = heatnumber.quantity_detail[i];
			quantity = quantity + d.quantity;
			length = length + d.quantity * d.length;
		}

		heatnumber.quantity = quantity;
		heatnumber.length = length;
		$scope.watchHeatnumberQuantity_In();
		$scope.watchHeatnumberLength_In();
	}

	$scope.watchHeatnumberLength_Out = function(){
		var length = 0;
		for(var i = 0; i < $scope.check_out_material.heatnumbers.length; i++){
			var h = $scope.check_out_material.heatnumbers[i];
			length = length + h.length;
		}

		$scope.check_out_material.total_inch = length;
	}

	$scope.watchHeatnumberQuantity_Out = function(){
		var quantity = 0;
		for(var i = 0; i < $scope.check_out_material.heatnumbers.length; i++){
			var h = $scope.check_out_material.heatnumbers[i];
			quantity = quantity + h.quantity;
		}

		$scope.check_out_material.quantity = quantity;
		$scope.watchQuantity_Out();
	}

	$scope.watchHeatnumberQuantityDetail_Out = function(heatnumber){
		var quantity = 0;
		var length = 0;
		for(var i = 0; i < heatnumber.quantity_detail.length; i++){
			var d = heatnumber.quantity_detail[i];
			quantity = quantity + d.quantity;
			length = length + d.quantity * d.length;
		}

		heatnumber.quantity = quantity;
		heatnumber.length = length;
		$scope.watchHeatnumberQuantity_Out();
		$scope.watchHeatnumberLength_Out();
	}

	$scope.watchTotalLbs_In = $scope.watchCostInch_In = $scope.watchInchBar_In = $scope.watchQuantity_In = function(){
		$scope.check_in_material.total_inch = parseInt($scope.check_in_material.quantity) * parseInt($scope.check_in_material.inch_bar);
		var cost_lbs = $scope.check_in_material.cost_inch * $scope.check_in_material.total_inch / $scope.check_in_material.total_lbs;
		$scope.check_in_material.cost_lbs = $filter('currency')(cost_lbs, '');
	}

	$scope.watchTotalLbs_Out = $scope.watchInchBar_Out = $scope.watchQuantity_Out = function(){
		$scope.check_out_material.total_inch = parseInt($scope.check_out_material.quantity) * parseInt($scope.check_out_material.inch_bar);
	}

	// View quantity detail
	$scope.viewQuantity = function(material){
		$scope.selected_material = material;
		$('#viewQuantityModal').modal('show');
	}

	/***** Quantity detail *****/
	$scope.addQuantityDetail = function(quantity_detail){
		if(quantity_detail == undefined)
			quantity_detail = [];

		if($scope.quick_check_in_out_material_length == undefined || $scope.quick_check_in_out_material_length == ""){
			quantity_detail.push({
				quantity : '',
				length : '',
				location_id : ''
	    	});
		}
	    else{
			quantity_detail.push({
				quantity : '',
				length : $scope.quick_check_in_out_material_length,
				location_id : ''
	    	});
	    }
	};

	$scope.removeQuantityDetail_In = function(heatnumber, index){
		var detail = heatnumber.quantity_detail[index];
		heatnumber.quantity = heatnumber.quantity - detail.quantity;
		heatnumber.length = heatnumber.length - detail.quantity * detail.length;
		heatnumber.quantity_detail.splice(index, 1);

		$scope.check_in_material.total_inch = $scope.check_in_material.total_inch - detail.quantity * detail.length;
		$scope.check_in_material.quantity = $scope.check_in_material.quantity - detail.quantity;
	}

	$scope.removeQuantityDetail_Out = function(heatnumber, index){
		var detail = heatnumber.quantity_detail[index];
		heatnumber.quantity = heatnumber.quantity - detail.quantity;
		heatnumber.length = heatnumber.length - detail.quantity * detail.length;
		heatnumber.quantity_detail.splice(index, 1);

		$scope.check_out_material.total_inch = $scope.check_out_material.total_inch - detail.quantity * detail.length;
		$scope.check_out_material.quantity = $scope.check_out_material.quantity - detail.quantity;
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

	/************ Date picker **************/
	$('body').on('click', 'input.datepicker', function(event) {
	    $(this).datepicker({
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

			$scope.viewDetail = function(material){
				if (window.opener != null && !window.opener.closed) {
					$scope.parentWindow = window.opener.$windowScope;
					$scope.parentWindow.$emit('selectMaterial', material);
					window.close();
		        }
			}
		}, 0);
	}
}]);