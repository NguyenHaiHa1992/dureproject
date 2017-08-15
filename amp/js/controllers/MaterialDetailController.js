angular.module('app').controller('MaterialDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$filter', '$sce', '$stateParams', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $filter, $sce, $stateParams){
	$scope.material= {};
	$scope.copy_material= {};
	$scope.material.material_code = '';
	$scope.search_material_code= '';
	$scope.am_designation_options = ['General','Brass','Other'];

	$scope.material_error= {
								'id': [],
								'material_code': [],
								'material_code_id': [],
								'category_id': [],
								'date': [],
								'vendor': [],
								'size_in_ft': [],
								'count': [],
								'weight': [],
								'inch_price': [],
								'optimum_inventory': [],
								'stock_in_hand': [],
								'status': [],
								'created_time': [],
								'uol_id': [],
								'uoq_id': [],
								'shape_id': [],
								'note': [],
								'receiver': [],
								'location': [],
								'am_designation':[],
								'designation_id':[],
								'heat_number':[],
								'inches': [],
								'quantity': [],
								'total_lbs': [],
								'cost_lbs': [],
								'cost_inch': [],
								'optimum_inventory':[],
								'stock_in_hand':[],
								'sizes':[],
								'arr_location_ids': [],
							};

	$scope.material_categories= [];
	$scope.vendors = [];
	$scope.locations= [];

	$scope.is_readonly = false;

	$scope.createInit= function(){
		var post_information= {};

		$http.post(BASE_URL + '/material/createInit', post_information)
	    .success(function(data) {
		    if(data.success) {
				$scope.material_error= data.material_error;
				
				$scope.material_empty= data.material_empty;
				$scope.material_error_empty= data.material_error_empty;
				
				$scope.materials= [];
				$scope.material_categories= data.material_categories;
				$scope.uols= data.uols;
				$scope.uoqs= data.uoqs;
				$scope.shapes= data.shapes;
				$scope.locations= data.locations;

				$scope.vendors = data.vendors;
				$scope.employees = data.employees;

				$scope.parts = data.parts;
				$scope.job_orders = data.job_orders;

				$scope.material_code= $scope.material.material_code;
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

	$scope.getMaterialById= function(){
		$http.post(BASE_URL + '/material/getMaterialById', {id: $stateParams.id})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.material = data.material;
		    	$scope.copy_material = angular.copy($scope.material);
				$scope.material_error = data.material_error;
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
	$scope.getMaterialById();
	
	$scope.update= function(){
		var updateMaterial = function(){
			var information_post = $scope.material ;

			$http.post(BASE_URL + '/material/update', information_post)
		    .success(function(data) {
			    if(data.success) {
			    	swal('Material updated!', "", "success");
			    	$scope.material= data.material;
			    	$scope.material_error= $scope.material_error_empty;
					$scope.copy_material = angular.copy($scope.material);

			    	$( "input, select" ).removeClass( "ng-dirty" );

					// Lock material
					$scope.is_readonly = true;
			    }
			    else{
			    	if(data.type== 'alert')
				    	swal({
				    		title: '',
				    		text: data.message,
				    		type: 'error',
				    		html: true
				    	});
			    	else
			    		$scope.material_error= data.material_error;
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});
	  	}

		// Check change Matetrial code
		if($scope.copy_material.material_code != $scope.material.material_code){
		    sweetAlert({
				title: "Are you sure?",
		      	text: "Material Code will be changed!",
		      	type: "warning",
		      	showCancelButton: true,
		      	confirmButtonColor: "#DD6B55",
		      	confirmButtonText: "Yes, do it!",
		      	closeOnConfirm: true,
		      	html: true
		    },
		    function(){
				updateMaterial();
		    });
		}
		else{
			updateMaterial();
		}
	};

	// Get history of check in/out
	$scope.getInOutMaterials = function(){
		var information_post = {material_id: $scope.material.id};
		$http.post(BASE_URL + '/material/getInOutMaterials', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.in_out_materials = data.in_out_materials;
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

	$scope.$watch(
		function(scope){
			return scope.search_material_id;
		},
        function(new_material_id){
        	if(new_material_id != '' && new_material_id != undefined && new_material_id != $scope.material.id){
        		$state.go('material-detail', {id: new_material_id});

				return false;
        	}
        }
    );

	$scope.$watch(
		function(scope){
			return scope.material.id;
		},
        function(new_material_id){
        	if(new_material_id != '' && new_material_id != undefined){
				$scope.material_error= $scope.material_error_empty;

				$scope.is_update= true;
				$scope.is_create= false;

				// Lock material
				$scope.is_readonly = true;

				$scope.copy_material = angular.copy($scope.material);

				// Get in out materials
				$scope.getInOutMaterials();

				return false;
        	}
        }
    );

	$scope.changeShape = function(){
		if($scope.material.shape_id != $scope.copy_material.shape_id){
			$.each($scope.shapes, function(i,v){
				if($scope.material.shape_id == v.id){
					$scope.material.sizes = {};
					$.each(v.sizes, function(i,size){
						$scope.material.sizes[size] = '';
					})
				}
			})
		}
		else{
			$scope.material.sizes = $scope.copy_material.sizes;
		}
	}

	$scope.updateSize = function(label,size){
		$scope.material.sizes[label] = size;
	}

	// Unlock material
	$scope.unlock = function(){
		$scope.is_readonly = false;
	}

	// Check in
	$scope.checkIn = function(){
		$scope.check_in_material = {};
		$scope.check_in_material.heatnumbers = [];
		$scope.check_in_material_error = {};
		$('#checkInModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();

		delete($scope.quick_check_in_out_material_length);
	}

	$scope.checkInUpdateHeatnumbers = function(check_in_material, $event){
		// Insert
		for(var i = 0; i < check_in_material.heatnumber_ids.length; i++){
			var id = check_in_material.heatnumber_ids[i];

			for(var j = 0; j < $scope.material.heatnumbers.length; j++){
				var c = $scope.material.heatnumbers[j];

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
						quantity_detail: [{
							quantity : '',
							length : '',
							location_id : ''
				    	}],
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
		// Validate before
		if($scope.check_in_material.received_date == ''){
	    	swal({
	    		title: 'Error',
	    		text: 'Please input Date of Check In',
	    		type: 'error',
	    		html: true
	    	});

	    	return false;
		}

		$('#checkInModal').modal('hide');
		$http.post(BASE_URL + '/material/checkin', {id: $scope.material.id, check_in: $scope.check_in_material})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.material.arr_location_ids = data.arr_location_ids;
		    	$scope.material.stock_in_hand = data.stock_in_hand;
		    	$scope.material.quantity = data.quantity;
		    	$scope.material.heatnumbers = data.heatnumbers;
		    	$scope.check_in_material = {};
		    	$scope.check_in_material_error = {};
		    	swal('Success', data.message, "success");

				// Get in out materials
				$scope.getInOutMaterials();

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
		    	$scope.check_in_material_error = data.check_in_material_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	// Check out
	$scope.checkOut = function(){
		$scope.check_out_material = {};
		$scope.check_out_material.heatnumbers = [];
		$scope.check_out_material_error = {};
		$('#checkOutModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();

		delete($scope.quick_check_in_out_material_length);
	}

	$scope.checkOutUpdateHeatnumbers = function(check_out_material){
		// Insert
		for(var i = 0; i < check_out_material.heatnumber_ids.length; i++){
			var id = check_out_material.heatnumber_ids[i];

			for(var j = 0; j < $scope.material.heatnumbers.length; j++){
				var c = $scope.material.heatnumbers[j];

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
						quantity_detail: [{
							quantity : '',
							length : '',
							location_id : ''
				    	}],
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
		$http.post(BASE_URL + '/material/checkout', {id: $scope.material.id, check_out: $scope.check_out_material})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.material.stock_in_hand = data.stock_in_hand;
		    	$scope.material.quantity = data.quantity;
		    	$scope.material.heatnumbers = data.heatnumbers;
		    	$scope.check_out_material = {};
		    	$scope.check_out_material_error = {};

		    	swal('Success', data.message, "success");

				// Get in out materials
				$scope.getInOutMaterials();

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

	// Return
	$scope.returnItem = function(){
		$scope.return_material = {};
		$scope.return_material.heatnumbers = [];
		$scope.return_material_error = {};
		$('#returnModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();

		delete($scope.quick_check_in_out_material_length);
	}

	$scope.returnUpdateHeatnumbers = function(return_material){
		// Insert
		for(var i = 0; i < return_material.heatnumber_ids.length; i++){
			var id = return_material.heatnumber_ids[i];

			for(var j = 0; j < $scope.material.heatnumbers.length; j++){
				var c = $scope.material.heatnumbers[j];

				var check_exist = false;
				for(var t = 0; t < return_material.heatnumbers.length; t++){
					d = return_material.heatnumbers[t];
					if(d.id == id)
						check_exist = true;
				}
				if(!check_exist && c.id == id){
					return_material.heatnumbers.push({
						id: c.id,
						heatnumber : c.heatnumber,
						drawing : c.drawing,
						quantity: 0,
						list_length: c.list_length,
						quantity_detail: [{
							quantity : '',
							length : '',
							location_id : ''
				    	}],
			    	});
			    }
			}
		}

		// Remove
		for(var t = 0; t < return_material.heatnumbers.length; t++){
			d = return_material.heatnumbers[t];
			var check_exist = false;

			for(var i = 0; i < return_material.heatnumber_ids.length; i++){
				var id = return_material.heatnumber_ids[i];

				if(d.id == id)
					check_exist = true;
			}

			if(!check_exist){
				return_material.heatnumbers.splice(t, 1);
			}
		}
	}

	// Submit return item
	$scope.submitReturn = function(){
		$('#returnModal').modal('hide');
		$http.post(BASE_URL + '/material/returnItem', {id: $scope.material.id, return_item: $scope.return_material})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.material.stock_in_hand = data.stock_in_hand;
		    	$scope.material.quantity = data.quantity;
		    	$scope.material.heatnumbers = data.heatnumbers;
		    	$scope.return_material = {};
		    	$scope.return_material_error = {};

		    	swal('Success', data.message, "success");

				// Get in out materials
				$scope.getInOutMaterials();

				jQuery('#returnModal input, #returnModal select').removeClass('ng-dirty');
		    }
		    else{
		    	$('#returnModal').modal('show');
		    	swal({
		    		title: 'Error',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    	$scope.return_material_error = data.return_material_error;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

	/*** end ******/

	$scope.watchTotalLbs_In = $scope.watchCostInch_In = $scope.watchInchBar_In = $scope.watchQuantity_In = function(){
		$scope.check_in_material.total_inch = parseInt($scope.check_in_material.quantity) * parseFloat($scope.check_in_material.inch_bar);
		var cost_lbs = $scope.check_in_material.cost_inch * $scope.check_in_material.total_inch / $scope.check_in_material.total_lbs;
		$scope.check_in_material.cost_lbs = $filter('currency')(cost_lbs, '');
	}

	$scope.watchTotalLbs_Out = $scope.watchInchBar_Out = $scope.watchQuantity_Out = function(){
		$scope.check_out_material.total_inch = parseInt($scope.check_out_material.quantity) * parseFloat($scope.check_out_material.inch_bar);
	}

	$scope.watchTotalLbs_Return = $scope.watchInchBar_Return = $scope.watchQuantity_Return = function(){
		$scope.return_material.total_inch = parseInt($scope.return_material.quantity) * parseFloat($scope.return_material.inch_bar);
	}

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
			if(d.quantity != '' && d.length != ''){
				quantity = quantity + d.quantity;
				length = length + strip(d.quantity * d.length);
			}
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
			if(d.quantity != '' && d.length != ''){
				quantity = quantity + d.quantity;
				length = length + strip(d.quantity * d.length);
			}
		}

		heatnumber.quantity = quantity;
		heatnumber.length = length;
		$scope.watchHeatnumberQuantity_Out();
		$scope.watchHeatnumberLength_Out();
	}

	$scope.watchHeatnumberLength_Out = function(){
		var length = 0;
		for(var i = 0; i < $scope.check_out_material.heatnumbers.length; i++){
			var h = $scope.check_out_material.heatnumbers[i];
			length = length + h.length;
		}

		$scope.check_out_material.total_inch = length;
	}

	$scope.watchHeatnumberQuantity_Return = function(){
		var quantity = 0;
		for(var i = 0; i < $scope.return_material.heatnumbers.length; i++){
			var h = $scope.return_material.heatnumbers[i];
			quantity = quantity + h.quantity;
		}

		$scope.return_material.quantity = quantity;
		$scope.watchQuantity_Return();
	}

	$scope.watchHeatnumberQuantityDetail_Return = function(heatnumber){
		var quantity = 0;
		var length = 0;
		for(var i = 0; i < heatnumber.quantity_detail.length; i++){
			var d = heatnumber.quantity_detail[i];
			if(d.quantity != '' && d.length != ''){
				quantity = quantity + d.quantity;
				length = length + strip(d.quantity * d.length);
			}
		}

		heatnumber.quantity = quantity;
		heatnumber.length = length;
		$scope.watchHeatnumberQuantity_Return();
		$scope.watchHeatnumberLength_Return();
	}

	$scope.watchHeatnumberLength_Return = function(){
		var length = 0;
		for(var i = 0; i < $scope.return_material.heatnumbers.length; i++){
			var h = $scope.return_material.heatnumbers[i];
			length = length + h.length;
		}

		$scope.return_material.total_inch = length;
	}

	/************************/
	$scope.viewDetailInOutMaterial = function(item){
		if(item.type_label == 'Check-in'){
			$scope.check_in_material = item;
			$scope.check_in_material.is_readonly = true;
			$('#checkInModal').modal('show');
		}

		if(item.type_label == 'Check-out'){
			$scope.check_out_material = item;
			$scope.check_out_material.is_readonly = true;
			$('#checkOutModal').modal('show');
		}
	}

	// Edit Heat numbers
	$scope.editHeatnumber = function(heatnumber){
		heatnumber.is_edit = true;
	};
	$scope.cancelEditHeatnumber = function(heatnumber){
		var id = heatnumber.id;
		for(var i = 0; i< $scope.copy_material.heatnumbers.length; i++){
			var h = $scope.copy_material.heatnumbers[i];
			if(h.id == id){
				heatnumber.heatnumber = h.heatnumber;
				heatnumber.drawing = h.drawing;
			}
		}

		heatnumber.is_edit = false;
	};

	$scope.removeHeatnumber = function(heatnumber, index){
		if(heatnumber.id == undefined || heatnumber.id == ''){
			$scope.material.heatnumbers.splice(index, 1);
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
				$http.post(BASE_URL + '/material/removeHeatnumber', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.material.heatnumbers.splice(index, 1);
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
		$http.post(BASE_URL + '/material/updateHeatnumber', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal(data.message, "", "success");
		    	heatnumber.designation = data.designation;
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
		$scope.material.heatnumbers.push({
			heatnumber : '',
			designation : '',
			material_id: parseInt($scope.material.id),
			is_edit: true,
			is_new: true,
    	});
	};

	// Import Heatnumber
	$scope.importHeatnumber = function(){
        var file = $scope.uploaded_file;
        if(file){
	        // Validate file
	        var file_name = file.name;
	        var ext = file_name.substring(file_name.lastIndexOf('.') + 1).toLowerCase(); 

	        if(ext == 'xls' || ext == 'xlsx' || ext == 'csv'){
	            var fd = new FormData();
	            fd.append('uploaded_file', file);
	            fd.append('material_id', $scope.material.id);
	            $http.post(BASE_URL + '/material/importHeatnumber', fd, {
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined}
	            })
	            .success(function(data){
	                if(data.success){
	                    swal(data.message, "", "success");

	                    $.each(data.list_new_heatnumber, function(i, v){
	                    	$scope.material.heatnumbers.push(v);
	                    });
	                }
	                else{
	                	swal({
	                		title: "Import finished but some rows dismissed",
	                		text: data.message,
	                		html: true 
	                	});

	                    $.each(data.list_new_heatnumber, function(i, v){
	                    	$scope.material.heatnumbers.push(v);
	                    });
	                }
	            })
	            .error(function(){
	            });
	        }
	        else{
	        	swal('Wrong format. Please select XLS or XLSX or CSV format', "", "error");
	        }
        }
        else{
        	swal('Please select XLS or XLSX or CSV file', "", "error");
        }
	}


	/*** end of heatnumber ***/

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
		heatnumber.length = heatnumber.length - strip(detail.quantity * detail.length);
		heatnumber.quantity_detail.splice(index, 1);

		$scope.check_in_material.total_inch = $scope.check_in_material.total_inch - strip(detail.quantity * detail.length);
		$scope.check_in_material.quantity = $scope.check_in_material.quantity - detail.quantity;
	}

	$scope.removeQuantityDetail_Out = function(heatnumber, index){
		var detail = heatnumber.quantity_detail[index];
		heatnumber.quantity = heatnumber.quantity - detail.quantity;
		heatnumber.length = heatnumber.length - strip(detail.quantity * detail.length);
		heatnumber.quantity_detail.splice(index, 1);

		$scope.check_out_material.total_inch = $scope.check_out_material.total_inch - strip(detail.quantity * detail.length);
		$scope.check_out_material.quantity = $scope.check_out_material.quantity - detail.quantity;
	}

	/************ Quick check in / check out **********/
	//  Quick Check in
	$scope.QuickCheckIn = function(heatnumber, length, quantity){
		$scope.check_in_material = {};
		$scope.check_in_material.heatnumbers = [];
		$scope.quick_check_in_out_material_length = length;

		$scope.check_in_material.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
			quantity_detail: [],
    	});

		$scope.check_in_material.heatnumber_ids = [];
		$scope.check_in_material.heatnumber_ids.push(heatnumber.id);

		$scope.check_in_material.is_quick_check_in = true;
		$scope.check_in_material_error = {};
		$('#checkInModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	//  Quick Check out
	$scope.QuickCheckOut = function(heatnumber, length, quantity){
		$scope.check_out_material = {};
		$scope.check_out_material.heatnumbers = [];
		$scope.quick_check_in_out_material_length = length;

		$scope.check_out_material.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
			quantity_detail: [],
			list_length: heatnumber.list_length
    	});

		$scope.check_out_material.heatnumber_ids = [];
		$scope.check_out_material.heatnumber_ids.push(heatnumber.id);

		$scope.check_out_material.is_quick_check_out = true;
		$scope.check_out_material_error = {};
		$('#checkOutModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	//  Quick Return
	$scope.QuickReturn = function(heatnumber, length, quantity){
		$scope.return_material = {};
		$scope.return_material.heatnumbers = [];
		$scope.quick_check_in_out_material_length = length;

		$scope.return_material.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
			quantity_detail: [],
			list_length: heatnumber.list_length
    	});

		$scope.return_material.heatnumber_ids = [];
		$scope.return_material.heatnumber_ids.push(heatnumber.id);

		$scope.return_material.is_quick_return = true;
		$scope.return_material_error = {};
		$('#returnModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	//  Quick Check in from Popup
	$scope.QuickCheckInFromPopup = function(heatnumber, length, quantity, location_id){
		$scope.check_in_material = {};
		$scope.check_in_material.heatnumbers = [];
		$scope.quick_check_in_out_material_length = length;

		$scope.check_in_material.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
			quantity_detail: [{"length": length, "location_id": location_id, "quantity": ""}],
    	});

		$scope.check_in_material.heatnumber_ids = [];
		$scope.check_in_material.heatnumber_ids.push(heatnumber.id);

		$scope.check_in_material.is_quick_check_in = true;
		$scope.check_in_material.is_quick_check_in_popup = true;
		$scope.check_in_material_error = {};
		$('#heatnumberDetailModal').modal('hide');
		$('#checkInModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	//  Quick Check out from Popup
	$scope.QuickCheckOutFromPopup = function(heatnumber, length, quantity, location_id){
		$scope.check_out_material = {};
		$scope.check_out_material.heatnumbers = [];
		$scope.quick_check_in_out_material_length = length;

		$scope.check_out_material.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
			quantity_detail: [{"length": length, "location_id": location_id, "quantity": ""}],
			list_length: heatnumber.list_length
    	});
		$scope.check_out_material.heatnumber_ids = [];
		$scope.check_out_material.heatnumber_ids.push(heatnumber.id);

		$scope.check_out_material.is_quick_check_out = true;
		$scope.check_out_material.is_quick_check_out_popup = true;
		$scope.check_out_material_error = {};
		$('#heatnumberDetailModal').modal('hide');
		$('#checkOutModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	//  Quick Return from Popup
	$scope.QuickReturnFromPopup = function(heatnumber, length, quantity, location_id){
		$scope.return_material = {};
		$scope.return_material.heatnumbers = [];
		$scope.quick_check_in_out_material_length = length;

		$scope.return_material.heatnumbers.push({
			id: heatnumber.id,
			heatnumber : heatnumber.heatnumber,
			designation : heatnumber.designation,
			quantity: 0,
			quantity_detail: [{"length": length, "location_id": location_id, "quantity": ""}],
			list_length: heatnumber.list_length
    	});

		$scope.return_material.heatnumber_ids = [];
		$scope.return_material.heatnumber_ids.push(heatnumber.id);

		$scope.return_material.is_quick_return = true;
		$scope.return_material.is_quick_return_popup = true;
		$scope.return_material_error = {};
		$('#heatnumberDetailModal').modal('hide');
		$('#returnModal').modal('show');
		$('.chosen_select').chosen('destroy').chosen();
	}

	// See material price
	$scope.seeMaterialPrice = function(){
		var material_id = $scope.material.id;
		var url = $state.href('material-price-list', {'material_id' : material_id});
		window.open(url,'_blank');
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

	// Show heatnumber detail popup
	$scope.getHeatnumberDetailInfo = function(heatnumber){
		var information_post = heatnumber;
		$http.post(BASE_URL + '/material/getHeatnumberDetailInfo', information_post)
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

	/************** Strip function **********/
	function strip(number) {
	    return (parseFloat(number.toPrecision(12)));
	}

	/************** Editor *****************/

	/*************** Advance search ************/
	$scope.advancedSearch = function () {
	    var width = 1200;
	    var height = 500;
	    var left = parseInt((screen.availWidth/2) - (width/2));
	    var top = parseInt((screen.availHeight/2) - (height/2));
	    var windowFeatures = "width=" + width + ",height=" + height + ",status,resizable,left=" + left + ",top=" + top + "screenX=" + left + ",screenY=" + top + ',menubar=no';

		window.$windowScope = $scope;
 		window.open("#/material-list?type=popup", "Search material", windowFeatures);
    };

    /**** Search without reload 
    $scope.$on('selectMaterial', function(event, data) {
    	$scope.material = data;
    	$scope.$apply();
    });
	***/

    $scope.$on('selectMaterial', function(event, data) {
    	$state.go('material-detail', {id: data.id});
    });

    /********************************************/
	$scope.renderHtml = function(html_code)
	{
	    return $sce.trustAsHtml(html_code);
	};
}]);