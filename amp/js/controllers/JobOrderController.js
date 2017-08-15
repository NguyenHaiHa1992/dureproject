angular.module('app').controller('JobOrderController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$sce', '$stateParams',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $sce, $stateParams){
	$scope.job_order = {};
	$scope.job_order.job_order_details = {};
	$scope.current_index = 0;
	$scope.current_job_order_detail = {};
	$scope.current_job_order_detail.new_machine = {};

	$scope.init = function(){
		var post_information= {id: $stateParams.id};
		$http.post(BASE_URL + '/jobOrder/init', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.job_order = data.job_order;
		    	$scope.next_job_order_id = data.next_job_order_id;
		    	$scope.next_job_order_count = (data.next_job_order_count > 0)?data.next_job_order_count:"";
		    	$scope.previous_job_order_id = data.previous_job_order_id;
		    	$scope.previous_job_order_count = (data.previous_job_order_count > 0)?data.previous_job_order_count:"";
		    	$scope.current_job_order_detail = $scope.job_order.job_order_details[$scope.current_index];
		    	$scope.machines = data.machines;
		    	$scope.operations = data.operations;
		    }
		    else{
		    	swal(data.message, "", "error");
		    	return false;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};
	$scope.init();

	$scope.nextPart = function(){
		if($scope.current_index + 1 < $scope.job_order.job_order_details.length){
			$scope.current_index = $scope.current_index + 1;
			$scope.current_job_order_detail = $scope.job_order.job_order_details[$scope.current_index];
		}
	}

	$scope.prevPart = function(){
		if($scope.current_index > 0){
			$scope.current_index = $scope.current_index - 1;
			$scope.current_job_order_detail = $scope.job_order.job_order_details[$scope.current_index];
		}
	}

	$scope.updateMachineSchedule = function(schedule, machine, current_job_order_detail,$event){
		schedule['job_order_id'] = current_job_order_detail.job_order_id;
		schedule['part_id'] = current_job_order_detail.part_id;
		schedule['material_id'] = current_job_order_detail.material.id;
		schedule['job_order_detail_id'] = current_job_order_detail.id;
		schedule['machine_id'] = machine.id;
		

		var post_information= {schedule: schedule};
		$http.post(BASE_URL + '/machine/updateSchedule', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	schedule.status = data.schedule.status;
		    	schedule.id = data.schedule.id;

		    	swal(data.message, "", "success");

		    	// Remove "ng-dirty" class
		    	var btn = angular.element($event.target);
		    	var parent = btn.parent().parent();
		    	jQuery('input', parent).removeClass('ng-dirty');
		    }
		    else{
		    	swal({
		    		title: 'Errors',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    	return false;
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	}

	$scope.releaseMachineSchedule = function(machine, current_job_order_detail){
		sweetAlert({
			title: "Release this machine?",
	      	text: "Do you want to release this machine schedule?",
	      	type: "warning",
	      	showCancelButton: true,
	      	confirmButtonColor: "#DD6B55",
	      	confirmButtonText: "Yes, release it!",
	      	closeOnConfirm: false,
	      	html: true
	    },
	    function(){
			var information_post = {schedule: machine.schedule};
			$http.post(BASE_URL + '/machine/releaseSchedule', information_post)
		    .success(function(data) {
			    if(data.success){
			    	swal(data.message, "", "success");
	                machine.schedule = data.schedule;
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

	$scope.restartMachineSchedule = function(machine, current_job_order_detail){
		sweetAlert({
			title: "Restart this machine?",
	      	text: "Do you want to restart this machine schedule?",
	      	type: "warning",
	      	showCancelButton: true,
	      	confirmButtonColor: "#DD6B55",
	      	confirmButtonText: "Yes, restart it!",
	      	closeOnConfirm: false,
	      	html: true
	    },
	    function(){
			var information_post = {schedule: machine.schedule};
			$http.post(BASE_URL + '/machine/restartSchedule', information_post)
		    .success(function(data) {
			    if(data.success){
			    	swal(data.message, "", "success");
	                machine.schedule = data.schedule;
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

	$scope.deleteMachineSchedule = function($index, schedule, machine, current_job_order_detail){
		sweetAlert({
			title: "Delete this schedule?",
	      	text: "Do you want to delete this machine schedule?",
	      	type: "warning",
	      	showCancelButton: true,
	      	confirmButtonColor: "#DD6B55",
	      	confirmButtonText: "Yes, delete it!",
	      	closeOnConfirm: false,
	      	html: true
	    },
	    function(){
			var information_post = {schedule: schedule};
			$http.post(BASE_URL + '/machine/deleteSchedule', information_post)
		    .success(function(data) {
			    if(data.success){
			    	swal(data.message, "", "success");
	                machine.schedules.splice($index, 1);
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

	$scope.getSum = function(a, b){
		if(a != undefined && b != undefined && a != '' && b != ''){
			var sum = parseInt(a) + parseInt(b);
			if(sum == NaN) sum = '';
			return sum;
		}
		else
			return;
	}

	$scope.addMachine = function(machine_id, current_job_order_detail, $event){
		if(machine_id == undefined){
	    	swal({
	    		title: 'Please choose a Machine!',
	    		text: '',
	    		type: 'error',
	    		html: true
	    	});
		}
		else{
			var check = true;
			$.each($scope.current_job_order_detail.machines, function(i, v){
				if(v.id == machine_id){
			    	swal({
			    		title: 'This machine is already added',
			    		text: 'Please choose an other machine',
			    		type: 'error',
			    		html: true
			    	});
			    	check = false;
			    	return false;
				}
			})

			if(check){
				var new_machine = {};
				$.each($scope.machines, function(i,v){
					if(v.id == machine_id)
						new_machine = v;
				})

				$scope.current_job_order_detail.machines.push({
					id: new_machine.id,
					name: new_machine.name,
					schedules: []
		    	});
			}
		}
	}

	$scope.addMachineSchedule = function(machine, current_job_order_detail,$event){
		machine.schedules.push({});
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

	$('.popover_item').popover({});
	$('body').on('click', function (e) {
	    $('[data-toggle="popover"]').each(function () {
	        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
	            $(this).popover('hide');
	        }
	    });
	});

	// Jquery
	jQuery("#machines").on('click', "[data-widget='collapse']", function() {
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