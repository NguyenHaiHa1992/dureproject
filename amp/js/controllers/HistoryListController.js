angular.module('app').controller('HistoryListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$stateParams',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams){
	$scope.histories= [];
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
	$scope.start_history= 1;
	$scope.end_history= 1;
	$scope.totalresults= 0;
	$scope.sort= {
					attribute: 'created_time',
					type: 'DESC',
				};

	$scope.search_history = {history_code :'', category_id : ''};
	$scope.class = $stateParams.class;
	$scope.test =  {"tmp_file_ids":{"old":"99,103","new":"99,103,104"}};

	var post_information= {
						'limitstart': 0,
						'limitnum': $scope.itemsByPage,
						
						'sort_attribute': $scope.sort.attribute,
						'sort_type': $scope.sort.type,
						'class': $stateParams.class,
						'id': $stateParams.id,
					};

	$scope.getHistories= function(post_information){
		$http.post(BASE_URL + '/history/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_history= data.start_history;
				$scope.end_history= data.end_history;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.histories= [];
		    	$scope.histories= data.histories;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getHistories(post_information);
	
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
		$scope.getHistories(post_information);
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
			$scope.getHistories(post_information);
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
			$scope.getHistories(post_information);
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
		$scope.getHistories(post_information);
	};

	$scope.viewDetail = function(history_id){
		$rootScope.view_detail_history_id= history_id;
		$state.go('history-create');
	};

	$scope.search = function(){
		post_information.history_code = $scope.search_history.history_code;
		post_information.category_id = $scope.search_history.category_id; 

		$scope.getHistories(post_information);
	}
}]);