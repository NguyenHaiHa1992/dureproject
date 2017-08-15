angular.module('app').controller('PartDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$stateParams', '$sce',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $sce){
	$scope.part= {};
	$scope.part_copy= {};
	$scope.Math = Math;

	$scope.part_error= {
							'id': [],
							'part_code': [],
							'category_id': [],
							'description': [],
							'design': [],
							'revision': [],
							'uom_id': [],
							'price': [],
							'optimum_inventory': [],
							'inventory_on_hand': [],
							'notes': [],
							'location': [],
							'shop_floor': [],
							'material_id': [],
							'bar_length_pc': [],
							'bars_needed': [],
							'slug_length': [],
							'heat_code': [],
							'designation': [],
							'status': [],
							'created_time': [],
							'tmp_file_ids': [],
							'arr_machine_ids': [],
							'arr_location_ids': [],
							'bar_length': [],
							'part_length': [],
							'drawing': [],
							'client_id': []
						};
	$scope.part_categories= [];
	$scope.machines= [];
	$scope.locations= [];
	$scope.materials= [];
	$scope.parts= [];
	$scope.part_code= '';
	$scope.is_readonly = false;
	$scope.file_categories= [];

	$scope.createInit= function(){
		var post_information= {};

		$http.post(BASE_URL + '/part/createInit', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.part_empty= data.part_empty;
				$scope.part_error= data.part_error;
				$scope.part_error_empty= data.part_error_empty;
				$scope.part_categories= data.part_categories;
				$scope.uoms= data.uoms;
				$scope.machines= data.machines;
				$scope.locations= data.locations;

				$scope.purchase_orders = data.purchase_orders;
				$scope.employees = data.employees;

				$scope.file_categories= data.file_categories;
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

	$scope.getPartById = function(){
		$http.post(BASE_URL + '/part/getPartById', {id: $stateParams.id})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.part = data.part;
		    	$scope.part_copy = angular.copy($scope.part);
				$scope.part_error = data.part_error;
				$scope.is_update= true;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.getPartById();

	// Get history of check in/out
	$scope.getInOutParts = function(){
		var information_post = {part_id: $scope.part.id};
		$http.post(BASE_URL + '/part/getInOutParts', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.in_out_parts = data.in_out_parts;
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
	
	$scope.update = function(){
		var updatePart = function(){
			var information_post= $scope.part;
			$http.post(BASE_URL + '/part/update', information_post)
		    .success(function(data) {
			    if(data.success) {
			    	swal("Part updated!", "", "success");
			    	$scope.part= data.part;
			    	$scope.part_copy = angular.copy($scope.part); // Keep before change part

			    	$scope.part_error= $scope.part_error_empty;
			    	$scope.is_readonly = true;
			    	
			    	$( "input, select" ).removeClass( "ng-dirty" );
			    }
			    else{
			    	alert('Error');
			    	$scope.part_error= data.part_error;
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});
	  	}

		// Check change Part code
		if($scope.part_copy.part_code != $scope.part.part_code){
		    sweetAlert({
				title: "Are you sure?",
		      	text: "Part Code will be changed!",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, do it!",
		      	closeOnConfirm: true,
		      	html: true
		    },
		    function(){
				updatePart();
		    });
		}
		else{
			updatePart();
		}
	};

	$scope.reset = function(){
		$scope.part_code = '';
		$scope.part = {};
		$( "input, select" ).removeClass( "ng-dirty" );
	};

	// Edit Price Range
	$scope.editPriceRange = function(price){
		price.is_edit = true;
	};

	$scope.cancelEditPriceRange = function(price){
		var id = price.id;
		for(var i = 0; i< $scope.part_copy.heatnumbers.length; i++){
			var h = $scope.part_copy.prices[i];
			if(h.id == id){
				price.max = h.max;
				price.price = h.price;
			}
		}

		price.is_edit = false;
	};

	$scope.removePriceRange = function(price, index){
		if(price.id == undefined || price.id == ''){
			$scope.part.prices.splice(index, 1);
		}
		else{
		    sweetAlert({
				title: "Are you sure?",
		      	text: "You will not be able to recover!",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, delete it!",
		      	closeOnConfirm: false,
		      	html: true
		    },
		    function(){
				var information_post= price;
				$http.post(BASE_URL + '/part/removePriceRange', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.part.prices.splice(index, 1);
		                price.is_edit = false;
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

	$scope.savePriceRange = function(price){
		var information_post= price;
		$http.post(BASE_URL + '/part/updatePriceRange', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal(data.message, "", "success");
                price.is_edit = false;
                price.price = data.price;
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

	$scope.addPriceRange = function(){
		$scope.part.prices.push({
			min : '',
			max : '',
			price : '',
			part_id: parseInt($scope.part.id),
			is_edit: true,
    	});
	};

	$scope.updatePriceRanges = function(){
		var check = true;
		if($scope.part.list_upto == undefined || $scope.part.list_upto == '' || $scope.part.list_price == undefined || $scope.part.list_price == ''){
			$scope.price_range_message_is_show = true;
			$scope.price_range_message = 'Field UPTO and PRICE can not be empty!';
			check = false;
		}
		else{
			var list_upto = $scope.part.list_upto.split(",");
			var list_price = $scope.part.list_price.split(",");

			$scope.price_range_message_is_show = false;
			$scope.price_range_message = '';

			if(list_upto.length != list_price.length){
				check = false;
				$scope.price_range_message_is_show = true;
				$scope.price_range_message = 'The number of "Upto" item is different from one of "Price" item. Please fix it.';
			}
			else{

				// sort list_upto
				$.each(list_upto, function(i,upto){
					list_upto[i] = parseInt(upto);
				})
				list_upto.sort(function(a, b){return a-b;});

				// Check the range before add
				$.each(list_upto, function(i,upto){
					// Check the range before add
					$.each($scope.part.prices, function(j, price){
						if(price.max == upto){
							check = false;
							$scope.price_range_message_is_show = true;
							$scope.price_range_message = 'The number '+ upto +' has existed in range. Please fix it.';
							return false;
						}
					})
				})

				// Compare and add
				if(check){
					$.each(list_upto, function(i,upto){
						if($scope.part.prices.length == 0){
							$scope.part.prices.push({id: '', price: list_price[i], max: upto, is_edit: true, part_id: parseInt($scope.part.id)});
						}
						else{
							// Add range
							$.each($scope.part.prices, function(j, price){
								if(price.max < upto){
									$scope.part.prices.splice(j, 0, {id: '', price: list_price[i], max: upto, is_edit: true, part_id: parseInt($scope.part.id)});
									return false;
								}
								else{
									$scope.part.prices.push({id: '', price: list_price[i], max: upto, is_edit: true, part_id: parseInt($scope.part.id)});
									return false;
								}
							})
						}
					})
				}
			}
		}
	};

	// Edit Heat numbers
	$scope.editHeatnumber = function(heatnumber){
		heatnumber.is_edit = true;
	};

	$scope.cancelEditHeatnumber = function(heatnumber){
		var id = heatnumber.id;
		for(var i = 0; i< $scope.part_copy.heatnumbers.length; i++){
			var h = $scope.part_copy.heatnumbers[i];
			if(h.id == id){
				heatnumber.heatnumber = h.heatnumber;
				heatnumber.drawing = h.drawing;
				heatnumber.designation = h.designation;
			}
		}

		heatnumber.is_edit = false;
	};

	$scope.removeHeatnumber = function(heatnumber, index){
		if(heatnumber.id == undefined || heatnumber.id == ''){
			$scope.part.heatnumbers.splice(index, 1);
		}
		else{
		    sweetAlert({
				title: "Are you sure?",
		      	text: "You will not be able to recover!",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, delete it!",
		      	closeOnConfirm: false,
		      	html: true
		    },
		    function(){
				var information_post = heatnumber;
				$http.post(BASE_URL + '/part/removeHeatnumber', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.part.heatnumbers.splice(index, 1);
		                heatnumber.is_edit = false;
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

	$scope.saveHeatnumber = function(heatnumber){
		var information_post= heatnumber;
		$http.post(BASE_URL + '/part/updateHeatnumber', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal(data.message, "", "success");
                heatnumber.is_edit = false;
                heatnumber.is_new = false;
                heatnumber.id = data.id;
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

	$scope.addHeatnumber = function(){
		$scope.part.heatnumbers.push({
			heatnumber : '',
			drawing : '',
			designation : '',
			part_id: parseInt($scope.part.id),
			is_edit: true,
			is_new: true,
    	});
	};

	$scope.changeHeatnumber = function(heatnumber){
		$.each($scope.part.material.heatnumbers, function(i,v){
			if(v.heatnumber == heatnumber.heatnumber){
				heatnumber.designation = v.designation;
				return true;
			}
		})
	}

	/*** end of heatnumber ***/

	$scope.$watch(
		function(scope){
			return scope.search_part_id;
		},
        function(new_part_id){
        	if(new_part_id != '' && new_part_id != undefined && new_part_id != $scope.part.id){
        		$state.go('part-detail', {id: new_part_id});

				return false;
        	}
        }
    );

	$scope.$watch(
		function(scope){
			return scope.part.id;
		},
        function(new_part_id){
        	if(new_part_id != '' && new_part_id != undefined){
				$scope.part_error= $scope.part_error_empty;

				$scope.is_update= true;
				$scope.is_create= false;
				$scope.is_readonly = true;

		    	$scope.part_copy = angular.copy($scope.part); // Keep before change part

		    	// Get inout parts
				$scope.getInOutParts();
				// Change url without re loading
				//$state.transitionTo('part-detail', {id: $scope.part.id}, { location: true, inherit: true, relative: $state.$current, notify: false });
				
				// Get ordered info
				$scope.refreshOrderedPartInfo();

				return false;
        	}
        }
     );

	// Unlock part
	$scope.unlock = function(){
		$scope.is_readonly = false;
	}

	// Download Price List PDF
	$scope.download_pdf = {rfq_number: '#', comment: '', email: false, download: false};
	$scope.emailTablePriceInit = function(){
		$scope.download_pdf.email = true;
		$scope.download_pdf.download = false;
		$('#downloadPdfInitModal').modal('show');
	}

	$scope.getTablePricePdfInit = function(){
		$scope.download_pdf.email = false;
		$scope.download_pdf.download = true;
		$('#downloadPdfInitModal').modal('show');
	}

	$scope.getTablePricePdf = function() {
		$http.post(BASE_URL + '/part/getPriceTablePdf', {
			part: $scope.part,
			rfq_number: $scope.download_pdf.rfq_number,
			comment: $scope.download_pdf.comment
		})
	    .success(function(data) {
		    if(data.success) {
		    	var html_code = data.content;

				var information_post= {
					html: html_code, 
					file_name: $scope.part.part_code + '_PartPriceList',
				};

				$http.post(BASE_URL + '/file/downloadPdf', information_post)
			    .success(function(data) {
				    if(data.success) {
					    // Add documents to list downloaded file
				    	$scope.price_pdf_documents = [];
				    	$scope.price_pdf_documents.push({
				    		'url': data.url, 
				    		'filename': data.filename,
				    		'extension': data.extension,
				    		'dirname': data.dirname
				    	});

				    	console.log('PDF downloaded');
				    	$("body").append("<iframe src='" + data.url + "' style='display: none;' ></iframe>");
				    }
				    else{
						swal(data.message, "", "error");
				    }

			    	// Show confirm popup
			    	$scope.confirmAddPdf();
				})
				.error(function(data, status, headers, config) {
		    		$state.go('404');	
		  		});
		    }
		    else{
				swal(data.message, "", "error");
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});

	};

    $scope.email = {};
    $scope.email.price_ = [];
    $scope.emailTablePrice = function(){
    	// Init email
		var post_information= {type: 'document'};
		$http.post(BASE_URL + '/email/init', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.email= data.email;
		    	$scope.email_title = data.email_title;
		    	$scope.email_empty= data.email_empty;
		    	$scope.email_error= data.email_error_empty;
		    	$scope.email_error_empty= data.email_error_empty;
		    }
		    else{
		    	if(data.type== 'nothing'){}
		    	else if(data.type== 'alert'){
		    		swal(data.message, "", "error");

		    		return false;
		    	}
		    	else{
		    		$state.go('404');
		    	}	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});

    	// Create price list pdf
		$http.post(BASE_URL + '/part/getPriceTablePdf', {
			part: $scope.part,
			rfq_number: $scope.download_pdf.rfq_number,
			comment: $scope.download_pdf.comment
		})
	    .success(function(data) {
		    if(data.success) {
		    	var html_code = data.content;

				var information_post= {
					html: html_code, 
					file_name: $scope.part.part_code + '_PartPriceList',
				};

				$http.post(BASE_URL + '/file/downloadPdf', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	$scope.email.documents = [];
				    	$scope.email.documents.push({
				    		'url': data.url, 
				    		'filename': data.filename,
				    		'extension': data.extension,
				    		'dirname': data.dirname
				    	});

				    	$scope.price_pdf_documents = [];
				    	$scope.price_pdf_documents.push({
				    		'url': data.url, 
				    		'filename': data.filename,
				    		'extension': data.extension,
				    		'dirname': data.dirname
				    	});

				    	$('#sendEmailModal').modal('show');
				    }
				    else{
						swal(data.message, "", "error");
				    }
				})
				.error(function(data, status, headers, config) {
		    		$state.go('404');	
		  		});
		    }
		    else{
				swal(data.message, "", "error");
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
    }

	$scope.sendEmailTablePrice = function(){
		var information_post= {'email': $scope.email, 'type': 'document'};
		$http.post(BASE_URL + '/email/send', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal(data.message, "", "success");
		    	$('#sendEmailModal').modal('hide');
		    	$scope.email.content = "";
                        $scope.email.subject = "";
                        $scope.email.to = "";

		    	// Show confirm popup
		    	$scope.confirmAddPdf();
		    }
		    else{
				swal(data.message, "", "error");
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	$scope.confirmAddPdf = function(){
		$('#confirmAddPdfModal').modal('show');
	}

	$scope.savePdfToUploadDocuments = function(){
		var check = false;
		if($scope.download_pdf_category_id == ''){
			swal('Please select file category', "", "error");
		}
		else{
			check = true;
		}

		if(check){
			var information_post = {
				'documents': $scope.price_pdf_documents, 
				'category_id': $scope.download_pdf_category_id,
				'part_id': $scope.part.id
			};
			$http.post(BASE_URL + '/part/savePdfToUploadDocuments', information_post)
		    .success(function(data) {
			    if(data.success) {
			    	$('#confirmAddPdfModal').modal('hide');
			    	swal(data.message, "", "success");
			    	$scope.part.tmp_file_ids = data.tmp_file_ids;
			    }
			    else{
					swal(data.message, "", "error");
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});
		}
	}

	/**** End of pdf price list ****/

	$scope.selected_document_ids = [];
	$scope.toggleSelection = function toggleSelection(file_id) {
	    var idx = $scope.selected_document_ids.indexOf(file_id);

	    if (idx > -1) {
	      $scope.selected_document_ids.splice(idx, 1);
	    }
	    else {
	      $scope.selected_document_ids.push(file_id);
	    }
	};

	$scope.$watch(
		function(scope){
			return scope.part.material_id;
		},
        function(new_material_id){
        	if(new_material_id != '' && new_material_id != undefined){
				var information_post= {'id': new_material_id};
				$http.post(BASE_URL + '/material/getMaterialById', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	$scope.part.material = data.material;
				    	$scope.part.material.sizes = data.material.sizes;
				    	$scope.part.material.shape_img_src = data.material.shape_img_src;
				    }
				    else{
						swal(data.message, "", "error");
				    }
				})
				.error(function(data, status, headers, config) {
		    		$state.go('404');	
		  		});
        	}
        	else{
		    	$scope.part.material = {};
        	}
        }
    );

	// Check in
	$scope.checkIn = function(){
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

			for(var j = 0; j < $scope.part.heatnumbers.length; j++){
				var c = $scope.part.heatnumbers[j];

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
						quantity_details: {
							quantity: "",
							location_id: ""
						}
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
		// Validator before check in

		$('#checkInModal').modal('hide');
		$http.post(BASE_URL + '/part/checkin', {id: $scope.part.id, check_in: $scope.check_in_part})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.part.arr_location_ids = data.arr_location_ids;
		    	$scope.part.quantity = data.quantity;
		    	$scope.part.heatnumbers = data.heatnumbers;
		    	$scope.check_in_part = {};
		    	$scope.check_in_part_error = {};

		    	swal('Success', data.message, "success");

				jQuery('#checkInModal input, #checkInModal select').removeClass('ng-dirty');

				// Get in out parts
				$scope.getInOutParts();
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
	$scope.checkOut = function(){
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

			for(var j = 0; j < $scope.part.heatnumbers.length; j++){
				var c = $scope.part.heatnumbers[j];

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
						quantity_details: {
							quantity: "",
							location_id: ""
						}
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
		$http.post(BASE_URL + '/part/checkout', {id: $scope.part.id, check_out: $scope.check_out_part})
	    .success(function(data) {
		    if(data.success) {
				$scope.part.quantity = data.quantity;
				$scope.part.heatnumbers = data.heatnumbers;
		    	$scope.check_out_part = {};
		    	$scope.check_out_part_error = {};

		    	swal('Success', data.message, "success");

				jQuery('#checkOutModal input, #checkOutModal select').removeClass('ng-dirty');

				// Get in out parts
				$scope.getInOutParts();
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
			$('.chosen_select').chosen('destroy').chosen();
		}

		if(item.type_label == 'Check-out'){
			$scope.check_out_part = item;
			$scope.check_out_part.is_readonly = true;
			$('#checkOutModal').modal('show');
			$('.chosen_select').chosen('destroy').chosen();
		}
	}

	// View related machine
	$scope.related_machines = [];
	$scope.viewRelatedMachines = function(){
		$http.post(BASE_URL + '/part/getRelatedMachines', {id: $scope.part.id})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.related_machines = data.related_machines;
				$('#relatedMachinesModal').modal('show');
		    }
		    else{
		    	swal({
		    		title: 'Error',
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

	/************ Quick check in / check out **********/
	//  Quick Check in
	$scope.QuickCheckIn = function(heatnumber){
		$scope.check_in_part = {};
		$scope.check_in_part.heatnumbers = [];

		$scope.check_in_part.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
    	});

		$scope.check_in_part.heatnumber_ids = [];
		$scope.check_in_part.heatnumber_ids.push(heatnumber.id);

		$scope.check_in_part.is_quick_check_in = true;
		$scope.check_in_part_error = {};

		$('#checkInModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	//  Quick Check out
	$scope.QuickCheckOut = function(heatnumber){
		$scope.check_out_part = {};
		$scope.check_out_part.heatnumbers = [];

		$scope.check_out_part.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
    	});

		$scope.check_out_part.heatnumber_ids = [];
		$scope.check_out_part.heatnumber_ids.push(heatnumber.id);

		$scope.check_out_part.is_quick_check_out = true;
		$scope.check_out_part_error = {};
		$('#checkOutModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}
	/*************** End checkout ************/

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
	//  Quick Check in
	$scope.QuickCheckInFromPopup = function(heatnumber, quantity, location_id){
		$scope.check_in_part = {};
		$scope.check_in_part.heatnumbers = [];

		$scope.check_in_part.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
			quantity_details: [{"location_id": location_id, "quantity": ""}],
    	});

		$scope.check_in_part.heatnumber_ids = [];
		$scope.check_in_part.heatnumber_ids.push(heatnumber.id);

		$scope.check_in_part.is_quick_check_in = true;
		$scope.check_in_part.is_quick_check_in_popup = true;
		$scope.check_in_part_error = {};
		$('#heatnumberDetailModal').modal('hide');
		$('#checkInModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	//  Quick Check out
	$scope.QuickCheckOutFromPopup = function(heatnumber, quantity, location_id){
		$scope.check_out_part = {};
		$scope.check_out_part.heatnumbers = [];

		$scope.check_out_part.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
			quantity_details: [{"location_id": location_id, "quantity": ""}],
    	});
		$scope.check_out_part.heatnumber_ids = [];
		$scope.check_out_part.heatnumber_ids.push(heatnumber.id);

		$scope.check_out_part.is_quick_check_out = true;
		$scope.check_out_part.is_quick_check_out_popup = true;
		$scope.check_out_part_error = {};
		$('#heatnumberDetailModal').modal('hide');
		$('#checkOutModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	$scope.copyPart = function(){
		$rootScope.view_detail_part_id = $scope.part.id;
		$rootScope.is_copy_part = true;
		$state.go('part-create');
	}

	/************** Get ordered part info **********/
	$scope.refreshOrderedPartInfo = function(){
		$http.post(BASE_URL + '/part/getOrderedPartInfo', {part_id: $scope.part.id})
	    .success(function(data) {
		    if(data.success) {
				$scope.ordered_part_info = data.ordered_part_info;
		    }
		    else{
		    	swal({
		    		title: 'Error',
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

	/************** Jquery ***************/
	jQuery('#list_upto').bind('input', function(){
	    jQuery(this).val(function(_, v){
	    	var v = v.replace(/\s+/g, '').replace(/[^0-9,]+/, '');
			return v;
	    });
	});

	jQuery('#list_price').bind('input', function(){
	    jQuery(this).val(function(_, v){
	    	var v = v.replace(/\s+/g, '').replace(/[^0-9.,]+/, '');
			return v;
	    });
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

	/*************** Advance search ************/
	$scope.advancedSearch = function () {
	    var width = 1200;
	    var height = 500;
	    var left = parseInt((screen.availWidth/2) - (width/2));
	    var top = parseInt((screen.availHeight/2) - (height/2));
	    var windowFeatures = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top + ',menubar=no';

		window.$windowScope = $scope;
 		window.open("#/part-list?type=popup", "Search part", windowFeatures);
    };

    /*** Search without change location
    $scope.$on('selectPart', function(event, data) {
    	$scope.part = data;
    	$scope.$apply();
    });
	***/

    $scope.$on('selectPart', function(event, data) {
    	$state.go('part-detail', {id: data.id});
    });

    /********************************************/
	$scope.renderHtml = function(html_code)
	{
	    return $sce.trustAsHtml(html_code);
	};
}]);