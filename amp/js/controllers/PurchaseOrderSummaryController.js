angular.module('app').controller('PurchaseOrderSummaryController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$sce', '$stateParams', 'localStorageService',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $sce, $stateParams, localStorageService){
	$scope.purchase_order = {};
	$scope.purchase_order.client = {};
	$scope.client_name = '';
	$scope.purchase_order.purchase_order_details = [];
	$scope.file = {};

	$scope.purchase_order_error= {
								id: [],
								po_code: [],
								client_id: [],
								ship_via: [],
								order_date: [],
								file_id: [],
								status: [],
								created_time: [],
								shipping_address: [],
								purchase_order_details: [
														{
															id: [],
															purchase_order_id: [],
															quantity: [],
															part_id: [],
															drawing_id: [],
															price: [],
															discount: [],
															delivery_date: [],
															take_from_inventory: [],
															status: [],
															created_time: [],
															part: []
														},
													],
							};

	$scope.checkOutInit= function(){
		$http.post(BASE_URL + '/purchaseOrder/checkOutInit', {})
	    .success(function(data) {
		    if(data.success) {
				$scope.locations= data.locations;
				$scope.employees = data.employees;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.checkOutInit();

	$scope.summary = function(){
		$http.post(BASE_URL + '/purchaseOrder/summary', {id: $stateParams.id})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.purchase_order = data.purchase_order;
		    	// Caculate new property
		    	$.each($scope.purchase_order.purchase_order_details, function(i, purchase_order_detail){
		    		if(purchase_order_detail.id != ""){
				    	purchase_order_detail.inventory_after_order = purchase_order_detail.part.inventory_on_hand - purchase_order_detail.quantity;
				    	if(purchase_order_detail.inventory_after_order >= purchase_order_detail.part.optimum_inventory){
				    		purchase_order_detail.quantity_to_manufacture = 0;
				    	}
				    	else{
				    		purchase_order_detail.quantity_to_manufacture = purchase_order_detail.part.optimum_inventory - purchase_order_detail.inventory_after_order;
				    	}
		    		}
		    	});

		    	$scope.purchase_order_error = data.purchase_order_error;

		    	$scope.po_code= data.po_code;
		    	$scope.client_name= data.client_name;
		    	$scope.is_update= data.is_update;
		    	$scope.is_create= data.is_create;

		    	if($scope.shipping_address == '')
		    		$scope.shipping_address = data.client.address1;

		    	$scope.purchase_order_empty= data.purchase_order_empty;
		    	$scope.purchase_order_error_empty= data.purchase_order_error_empty;
		    	
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.summary();


	$scope.$watch(
		function(scope){
			return scope.purchase_order.client.id;
		},
        function(new_client_id){
        	$scope.purchase_order.client_id = $scope.purchase_order.client.id;
        	$scope.purchase_order.shipping_address = $scope.purchase_order.client.address1;
        }
     );

	$scope.$watch(
		function(scope){
			return scope.purchase_order.id;
		},
        function(new_purchase_order_id){
			if(new_purchase_order_id != '' && new_purchase_order_id != undefined){
				$scope.is_update= true;
				$scope.is_create= false;

				// Set current purchase order
				$rootScope.current_purchase_order_id = $scope.purchase_order.id;
				$rootScope.current_purchase_order_code = $scope.purchase_order.po_code;
				localStorageService.set('current_purchase_order_id', $scope.purchase_order.id);
				localStorageService.set('current_purchase_order_code', $scope.purchase_order.po_code);


				return false;
        	}
        }
    );

	$scope.checkoutOrder = function(){
		sweetAlert({
			title: "Are you sure?",
	      	text: "Inventory details will be updated permanently, do you want to continue?",
	      	type: "warning",
	      	showCancelButton: true,
	      	confirmButtonColor: "#DD6B55",
	      	confirmButtonText: "Yes, do it!",
	      	closeOnConfirm: false,
	      	html: true
	    },
	    function(){
	    	var information_post = {};
			information_post['purchase_order_details'] = $scope.purchase_order.purchase_order_details;

			$http.post(BASE_URL + '/purchaseOrder/checkout', information_post)
		    .success(function(data) {
			    if(data.success) {
			    	$scope.purchase_order.purchase_order_details = data.purchase_order_details;

			    	// Re-Caculate new property
			    	$.each($scope.purchase_order.purchase_order_details, function(i, purchase_order_detail){
			    		if(purchase_order_detail.id != ""){
					    	purchase_order_detail.inventory_after_order = purchase_order_detail.part.inventory_on_hand - purchase_order_detail.quantity;
					    	if(purchase_order_detail.inventory_after_order >= purchase_order_detail.part.optimum_inventory){
					    		purchase_order_detail.quantity_to_manufacture = 0;
					    	}
					    	else{
					    		purchase_order_detail.quantity_to_manufacture = purchase_order_detail.part.optimum_inventory - purchase_order_detail.inventory_after_order;
					    	}
			    		}
			    	});

			    	swal({
			    		title: 'Success',
			    		text: data.message,
			    		type: 'success',
			    		html: true
			    	});

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

	$scope.createJobOrder = function(){
    	$scope.create_job_orders = [];
    	$.each($scope.purchase_order.purchase_order_details, function(i,v){
    		if(v.quantity_to_manufacture > 0){
	    		$scope.create_job_orders.push({
	    			'purchase_order_detail_id': v.id,
	    			'part_id': v.part.id,
	    			'material_id': v.part.material_id,
	    			'part_code': v.part.part_code,
	    			'quantity_to_manufacture': v.quantity_to_manufacture,
	    			'jo_code': ''
	    		});
    		}
    	});
    	$('#jobOrderListModal').modal('show');
	}

	$scope.submitCreateJobOrder = function(){
		sweetAlert({
			title: "Are you sure?",
	      	text: "You will create new JOs for this Order?",
	      	type: "warning",
	      	showCancelButton: true,
	      	confirmButtonColor: "#DD6B55",
	      	confirmButtonText: "Yes, do it!",
	      	closeOnConfirm: true,
	      	html: true
	    },
	    function(){
			var information_post = {};
			information_post['purchase_order_details'] = $scope.purchase_order.purchase_order_details;
			information_post['purchase_order_id'] = $scope.purchase_order.id;
			information_post['create_job_orders'] = $scope.create_job_orders;

			$http.post(BASE_URL + '/jobOrder/create', information_post)
		    .success(function(data) {
			    if(data.success) {
			    	swal("JO created", "You will go to Job Order Summary page now!", "success");
			    	$state.go('job-order', {'id': data.jo_group});
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

	$scope.listJobOrder = function(){
    	var information_post = {purchase_order_id : $scope.purchase_order.id};
		$http.post(BASE_URL + '/jobOrder/getJobOrdersByPurchaseOrderId', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.job_orders = data.job_orders;
		    	$('#listJobOrderModal').modal('show');
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

	$scope.viewDetailPart = function(part_id){
		$rootScope.view_detail_part_id = part_id;
		$state.go('part-create');
	}

	/************ Check out ****************/
	$scope.selected_purchase_order_detail = {};
	$scope.selected_part = {};

	// Show Check out
	$scope.checkOutPurchaseOrderDetail = function(purchase_order_detail){
		$scope.check_out_part = {};
		$scope.check_out_part.purchase_order_id = purchase_order_detail.purchase_order_id;
		$scope.check_out_part.purchase_order_code = $scope.purchase_order.po_code;
		$scope.check_out_part.heatnumbers = [];
		$scope.check_out_part_error = {};

		$scope.selected_purchase_order_detail = purchase_order_detail;
		$scope.selected_part = purchase_order_detail.part;

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

				// Confirm generate Certificate
				$scope.confirmGenerateCertificate(data.checkout);
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

	// Show Certificate Conformance
	$scope.confirmGenerateCertificate = function(checkout){
		swal({
			title: "Are you sure?",
			text: "Do you want to generate Certificates of Conformance?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes, generate!",
			closeOnConfirm: false}, 
			function(){ 
				$scope.generateCertificate(checkout);
			}
		);
	}

	$scope.generateCertificate = function(checkout){
		$http.post(BASE_URL + '/purchaseOrder/generateCertificate', {
			checkout_id: checkout.id, 
			purchase_order_code: $scope.purchase_order.po_code
		})
	    .success(function(data) {
		    if(data.success) {
		    	swal({
		    		title: 'Certificates generated',
		    		text: data.message,
		    		type: 'success',
		    		html: true
		    	});
		    	
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

	$('body').popover({
	    selector: '.popover_item',
	    trigger: 'hover'
	});

	/************ Date picker **************/
	$('.modal-dialog').on('click', 'input.datepicker', function(event) {
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

	$('.modal-dialog').on('focus', 'input.datepicker', function(event) {
	    $(this).datepicker({
	        showOn: 'focus',
	        yearRange: '1900:+0',
	        changeMonth: true,
	        changeYear: true,
			format: 'yyyy-mm-dd',
	    }).on('changeDate', function(e){
			$(this).datepicker('hide');
		});
	});

}]);