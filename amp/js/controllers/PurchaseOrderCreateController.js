angular.module('app').controller('PurchaseOrderCreateController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 'FileUploader', '$sce', 'localStorageService', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, FileUploader, $sce, localStorageService){
	$scope.purchase_order = {};
	$scope.purchase_order.client = {};
	$scope.client_name = '';
	$scope.purchase_order.purchase_order_details = [];
	$scope.delete_purchase_order_detail_ids = [];
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
															item_number: [],
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
								purchase_order_items: [
														{
															id: [],
															item_name: [],
															purchase_order_id: [],
															quantity: [],
															price: [],
														},
													],
							};

	$scope.createInit= function(){
		var post_information= {};
		if(jQuery.type($rootScope.view_detail_purchase_order_id) !== "undefined" && $rootScope.view_detail_purchase_order_id!= ''){
			post_information= {id: $rootScope.view_detail_purchase_order_id};
			$rootScope.view_detail_purchase_order_id = undefined;
		}
		else{
			post_information= {};
		}

		$http.post(BASE_URL + '/purchaseOrder/createInit', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.purchase_order = data.purchase_order;
		    	$scope.purchase_order_error = data.purchase_order_error;

		    	$scope.po_code= data.po_code;

		    	if($scope.purchase_order.po_code == "" && $rootScope.po_code != "" && $rootScope.po_code != undefined){
		    		$scope.purchase_order.po_code = $rootScope.po_code;
		    	}

		    	$scope.client_name= data.client_name;
		    	$scope.is_update= data.is_update;
		    	$scope.is_create= data.is_create;

		    	if($scope.shipping_address == '')
		    		$scope.shipping_address = data.client.address1;

		    	$scope.purchase_order_empty= data.purchase_order_empty;
		    	$scope.purchase_order_error_empty= data.purchase_order_error_empty;

		    	$scope.existed_items = data.existed_items;

				$scope.purchase_order_categories = data.purchase_order_categories;

				// If copy client
		    	if($rootScope.is_copy_purchase_order){
		    		$scope.purchase_order.id = undefined;
					$scope.is_update= false;
					$scope.is_create= true;
		    	}
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.createInit();

	$scope.create= function(){		
		var information_post= $scope.purchase_order;

		//Validate other items 
		$.each($scope.purchase_order.purchase_order_items, function(i, purchase_order_item){
			console.log(purchase_order_item);
			if(purchase_order_item.item_name == '' || purchase_order_item.quantity == '' || purchase_order_item.price == ''){
				swal("Order Items: Item name, quantity, price should not be blank", "", "error");
			}
		});

		$http.post(BASE_URL + '/purchaseOrder/create', information_post)
	    .success(function(data) {
		    if(data.success) {
				$( "input, select" ).removeClass( "ng-dirty" );
				$scope.purchase_order_error= data.purchase_order_error;

				// Check approve before go to email
				var check_approve = true;
				$.each($scope.purchase_order.purchase_order_details, function(i, purchase_order_detail){
					if(purchase_order_detail.part_id != ''){
						if(!purchase_order_detail.is_approved){
							check_approve = false;
							return false;
						}
					}
				});

				if(check_approve){
		    		swal("Order created!", "You are able to send Order to customer now", "success");

			    	$rootScope.view_detail_purchase_order_id= data.id;
			    	$state.go('email-send', {type: 'order', id: data.id});
			    }
			    else{
			    	swal("Order created!", "You are able to send Order to customer now", "success");
			    	$state.go('purchase-order-detail', {id: data.id});
			    }
		    }
		    else{
		    	if(data.type== 'alert'){
		    		swal(data.message, "", "error");
		    	}
		    	else{
		    		$scope.purchase_order_error= data.purchase_order_error;
		    	}
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.update= function(){
		var updatePurchaseOrder = function(){
			$scope.purchase_order.delete_purchase_order_detail_ids = $scope.delete_purchase_order_detail_ids;
			var information_post= $scope.purchase_order;
			$http.post(BASE_URL + '/purchaseOrder/update', information_post)
		    .success(function(data) {
			    if(data.success) {
					$scope.purchase_order_error= data.purchase_order_error;
					$scope.purchase_order_copy = angular.copy($scope.purchase_order); // Keep before change

					$( "input, select" ).removeClass( "ng-dirty" );

					swal("Order updated!", "You are able to send Order to customer now", "success");

					// Set current purchase order
					$rootScope.current_purchase_order_id = $scope.purchase_order.id;
					$rootScope.current_purchase_order_code = $scope.purchase_order.po_code;
					localStorageService.set('current_purchase_order_code', $scope.purchase_order.po_code);
			    }
			    else{
			    	if(data.type== 'alert'){
			    		swal(data.message, "", "error");
			    	}
			    	else{
			    		swal("Error", data.message, "error");
			    		$scope.purchase_order_error= data.purchase_order_error;
			    	}
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});
	  	}

		// Check change Po code
		if($scope.purchase_order_copy.po_code != $scope.purchase_order.po_code){
		    sweetAlert({
				title: "Are you sure?",
		      	text: "PO Code will be changed!",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, do it!",
		      	closeOnConfirm: true,
		      	html: true
		    },
		    function(){
				updatePurchaseOrder();
		    });
		}
		else{
			updatePurchaseOrder();
		}
	};

	$scope.updateExistingPrice = function(purchase_order_detail){
		if(purchase_order_detail.quantity != '' && purchase_order_detail.part_id != ''){
			$http.post(BASE_URL + '/part/getPrice', {'qty':purchase_order_detail.quantity, 'part_id': purchase_order_detail.part_id})
		    .success(function(data) {
			    if(data.success) {
			    	purchase_order_detail.existing_price = data.price;
			    }
			    else{
			    	
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});
		}
	}

	var uploader = $scope.uploader = new FileUploader({
		url: BASE_URL + '/file/upload',
		autoUpload: true
	});

	uploader.onSuccessItem = function(item, response, status, headers) {
		console.log(uploader);
		$scope.file_cat_ids = [];
		if(typeof response.file.id != 'undefined'){
			item.remove();
			if($scope.fileIds != '')
				$scope.fileIds += ',' + response.file.id;
			else{
				$scope.fileIds += response.file.id;
			}
		}
	}

	// Update delivery date of part item follow Order
	$scope.$watch(
		function(scope){
			return scope.purchase_order.delivery_date;
		},
        function(new_delivery_date){
        	if(new_delivery_date != '' && new_delivery_date != undefined){
        		$.each($scope.purchase_order.purchase_order_details, function(i, v){
	        		v.delivery_date = new_delivery_date;
    	    	})
    	    }
        }
    );

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
			return scope.search_purchase_order_id;
		},
        function(new_purchase_order_id){
        	if(new_purchase_order_id != '' && new_purchase_order_id != undefined && new_purchase_order_id != $scope.purchase_order.id){
        		$state.go('purchase-order-detail', {id: new_purchase_order_id});

				return false;
        	}
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

				// Update revised status
				$.each($scope.purchase_order.purchase_order_details, function(i, v){
					if(v.price != '' || v.price != null)
						$scope.is_revised = true;
					if(v.revised_date != '' || v.revised_date != null)
						$scope.is_revised = true;
				});

				$scope.purchase_order_copy = angular.copy($scope.purchase_order); // Keep before change

				// Set current purchase order
				$rootScope.current_purchase_order_id = $scope.purchase_order.id;
				$rootScope.current_purchase_order_code = $scope.purchase_order.po_code;
				localStorageService.set('current_purchase_order_id', $scope.purchase_order.id);
				localStorageService.set('current_purchase_order_code', $scope.purchase_order.po_code);

				return false;
        	}
        }
    );
    
	$scope.addPurchaseOrderDetail= function(){
		var purchase_order_detail_number= $scope.purchase_order.purchase_order_details.length;
		$.each($scope.purchase_order_empty.purchase_order_details, function(key, empty_purchase_order_detail){
			$scope.purchase_order.purchase_order_details[parseInt(key)+purchase_order_detail_number]= empty_purchase_order_detail;
		});
	};
	
	$scope.subtractPurchaseOrderDetail= function(){
		var purchase_order_detail_number= $scope.purchase_order.purchase_order_details.length;
		if(purchase_order_detail_number>0){
			for(var i= purchase_order_detail_number-1; (0<=i && i>= purchase_order_detail_number-5); i-- ){
				$scope.purchase_order.purchase_order_details.splice(i, 1);
			}
		}
	};
	
	$scope.deletePurchaseOrderDetail= function(index){
		var delete_purchase_order_detail = $scope.purchase_order.purchase_order_details[index];
		$scope.delete_purchase_order_detail_ids.push(delete_purchase_order_detail.id);
		$scope.purchase_order.purchase_order_details.splice(index, 1);
	};

	// Preview Order confirmation
	$scope.preview= function(option){
		var information_post= {'id': $scope.purchase_order.id, 'option': option, 'version': $scope.which_version};
		$http.post(BASE_URL + '/purchaseOrder/preview', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.order_preview = data.order_preview;
		    	$('#previewOrderModal').modal('show');
		    }
		    else{
				swal(data.message, "", "error");
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.renderHtml = function (htmlCode) {
		return $sce.trustAsHtml(htmlCode);
	};

	$scope.downloadPdf = function(htmlCode) {
		var information_post= {
			html: htmlCode, 
			file_name: $scope.purchase_order.po_code + '_Order',
			option: 'landscape'
		};
		$http.post(BASE_URL + '/file/downloadPdf', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	console.log('PDF downloaded');
		    	$("body").append("<iframe src='" + data.url + "' style='display: none;' ></iframe>");
		    }
		    else{
				swal(data.message, "", "error");
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.is_revised = false;

	$scope.revisedPurchaseOrder = function(value){
		$scope.is_revised = false;
		$.each($scope.purchase_order.purchase_order_details, function(i, v){
			if(v.price != '' && v.price != null)
				$scope.is_revised = true;
			if(v.revised_date != '' && v.revised_date != null)
				$scope.is_revised = true;
		});
	}

	/************* Other items **************/
	$scope.addNewPurchaseOrderItem = function(){
		$scope.purchase_order.purchase_order_items.push({
			item_name : '',
			quantity: 1,
			price: 0,
			id: ''
    	});
	}

	$scope.addExistedPurchaseOrderItem = function(selected_item_id){
		if(selected_item_id == '' || selected_item_id == undefined){
			swal("Error", "Please select an Item from Existing Items Dropdown List", "error");
		}
		else{
			$.each($scope.existed_items, function(i, v){
				if(v.id == selected_item_id){
					selected_item = v;
				}
			})

			$scope.purchase_order.purchase_order_items.push({
				item_name : selected_item.name,
				quantity: 1,
				price: selected_item.price,
				id: ''
	    	});
		}
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


	// $('.popover_item').popover({});
	// $('body').on('click', function (e) {
	//     $('[data-toggle="popover"]').each(function () {
	//         if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
	//             $(this).popover('hide');
	//         }
	//     });
	// });
}]);