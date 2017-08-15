angular.module('app').controller('MachineScheduleController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$stateParams',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams){
	$scope.machine_rows= [];
	$scope.machines = [];
	$scope.machine_number_working = 0;
	$scope.title = 'Machine Schedule Dashboard';

	// Get current date
	var currentDate = new Date();
	var day = currentDate.getDate();
	var month = currentDate.getMonth() + 1;
	var year = currentDate.getFullYear();

	$scope.filter = {date : year + '-' + month + '-' + day};

	if($stateParams.order_id == undefined || $stateParams.order_id == ''){
		$scope.getMachines = function(){
			$http.post(BASE_URL + '/machine/getAll')
		    .success(function(data) {
			    if(data.success) {
			    	$scope.machines = data.machines;

			    	$.each(data.machines, function(key, machine){
			    		if(machine.is_jobs == true){
			    			$scope.machine_number_working += 1;
			    		}
			    	});
			    }
			    else{
			    	$state.go('404');	
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});	
		};
	}
	else{
		$scope.getMachines = function(){
			$http.post(BASE_URL + '/machine/getMachinesByOrderId', {'order_id': $stateParams.order_id})
		    .success(function(data) {
			    if(data.success) {
			    	$scope.title = 'Machine Schedule by Order: '+ data.purchase_order.po_code;
			    	console.log($scope.title);
			    	$scope.machines = data.machines;

			    	$.each(data.machines, function(key, machine){
			    		if(machine.is_jobs == true){
			    			$scope.machine_number_working += 1;
			    		}
			    	});
			    }
			    else{
			    	$state.go('404');	
			    }
			})
			.error(function(data, status, headers, config) {
	    		$state.go('404');	
	  		});	
		};
	}

	$scope.getMachines();
	
	$scope.machineClick = function($event, machine_id){
		var current = $event.currentTarget;
		var parent = jQuery(current).parent().parent();
		jQuery('.btn', jQuery(parent)).removeClass('selected');
		current.className += " selected";
	};
	
	$scope.machineScheduleDetail = function($event, machine){
		var current = $event.currentTarget;
		var parent = jQuery(current).parent().parent();
		jQuery('.btn', jQuery(parent)).removeClass('selected');
		current.className += " selected";

		var machine_schedules = {};

		if($stateParams.order_id == undefined || $stateParams.order_id == ''){
			var post_params = {'id': machine.id, 'date': $scope.filter.date};
		}
		else{
			var post_params = {'id': machine.id, 'date': $scope.filter.date, 'purchase_order_id': $stateParams.order_id};
		}

		$http.post(BASE_URL + '/machine/getMachineSchedulesById', post_params)
	    .success(function(data) {
		    if(data.success) {
		    	machine_schedules = data.machine_schedules;

				var data_schedule_hours = [];
				var data_actual_hours = [];
				var categories = [];
				$.each(machine_schedules, function(i, v){
					data_schedule_hours.push(v.scheduled_hour);
					data_actual_hours.push(v.actual_hour);
					categories.push(v.part_code);
				});

				/****** Bar chart *****/
				$scope.show_chart = true;
				//This is not a highcharts object. It just looks a little like one!
				$scope.chartConfig = {

					options: {
				      	chart: {
				      		type: 'column'
				      	},
				      	tooltip: {
				      		style: {
				      			padding: 10,
				      			fontWeight: 'bold'
				      		}
				      	},
						legend: {
							enabled: true
						},
				  	},
				  	series: [{
				  		name: 'Scheduled hours',
				  		data: data_schedule_hours
				  	},{
				  		name: 'Actual hours',
				  		data: data_actual_hours
				  	}],

					title: {
				  		text: 'Job running on ' + machine.name
				  	},

					loading: false,

					xAxis: {
				  		title: {text: 'Part code'},
				  		categories: categories
				  	},

					yAxis: {
				  		title: {text: 'Scheduled / Actual hours'}
				  	},

					useHighStocks: false,

					credits: {
						enabled: false
					},

					func: function (chart) {
				   		//setup some logic for the chart
					}
				};
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	

	};

	$scope.chartConfig = {
		options: {
		    chart: {
				width: 0,
		  		height: 0
		    },
		},
	};

	// Refresh chart when filter date change
	$scope.$watch(
		function(scope){
			return scope.filter.date;
		},
        function(new_filter_date){
        	console.log(new_filter_date);
        	if(new_filter_date != '' && new_filter_date != undefined){
				$timeout(function() {
					angular.element('.machine.selected').trigger('click');
				}, 100);
    	    }
        }
    );

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
}]);