angular.module('app').controller('StateListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state){
	$scope.states= [];
	$scope.itemsByPage= 50;
	$scope.itemsByPages= [
							{
								value: 50,
								name: 50
							},
							{
								value: 100,
								name: 100
							},
							{
								value: 150,
								name: 150
							},
						];
	$scope.pages= [];
	$scope.currentPage= 1;
	$scope.start_state= 1;
	$scope.end_state= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};
	$scope.search= {
						id: '',
						name: '',
						created: '',
					};
	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
					};
					
	$scope.getStates= function(post_information){
		$http.post(BASE_URL + '/state/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_state= data.start_state;
				$scope.end_state= data.end_state;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.states= [];
		    	$scope.states= data.states;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getStates(post_information);
	
	$scope.selectPage= function(page){
		$scope.currentPage= page;
		var post_information= {
								'limitstart': (page-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search.id,
								'name': $scope.search.name,
								'created': $scope.search.created,
							};
		$scope.getStates(post_information);
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
								
								'id': $scope.search.id,
								'name': $scope.search.name,
								'created': $scope.search.created,
						};
		if($scope.itemsByPage_change_number>1)
			$scope.getStates(post_information);
	}, true);
	
	$scope.search_change_number= 0;
	$scope.$watch('search', function(){
		$scope.search_change_number++;
		var post_information= {
								'limitstart': ($scope.currentPage-1)*$scope.itemsByPage,
								'limitnum': $scope.itemsByPage,
								
								'sort_attribute': $scope.sort.attribute,
								'sort_type': $scope.sort.type,
								
								'id': $scope.search.id,
								'name': $scope.search.name,
								'created': $scope.search.created,
							};
		if($scope.search_change_number>1)
			$scope.getStates(post_information);
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
								
								'id': $scope.search.id,
								'name': $scope.search.name,
								'created': $scope.search.created,
							};
		$scope.getStates(post_information);
	};
	
	$scope.viewDetail = function(state_id){
		$rootScope.view_detail_state_id= state_id;
		$state.go('state-create');
	};
}]);