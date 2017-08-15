angular.module('app').controller('FileListController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$stateParams', 'FileUploader', 
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, FileUploader){
	$scope.category_name = $stateParams.category;
	$scope.category_id = 0;

	$scope.files= [];
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
	$scope.start_file= 1;
	$scope.end_file= 1;
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

						'category_code': $stateParams.code
					};
					
	$scope.getFiles= function(post_information){
		$http.post(BASE_URL + '/file/getAll', post_information)
	    .success(function(data) {
		    if(data.success) {
		    	$scope.totalresults= parseInt(data.totalresults);
		    	$scope.start_file= data.start_file;
				$scope.end_file= data.end_file;
		    	$scope.pages= [];
		    	for(var p= 0; p<Math.ceil(data.totalresults/$scope.itemsByPage); p++)
		    		$scope.pages.push(p+1);

		    	$scope.files= [];
		    	$scope.files= data.files;

		    	$scope.category_id = data.category_id;
		    	$scope.category_name = data.category_name;
		    	$scope.category_code = data.category_code;
		    }
		    else{
		    	$state.go('404');	
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});	
	};
	$scope.getFiles(post_information);

	$scope.initEmail = function(){
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
	};
	$scope.initEmail();

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
		$scope.getFiles(post_information);
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
			$scope.getFiles(post_information);
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
			$scope.getFiles(post_information);
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
		$scope.getFiles(post_information);
	};
	
	$scope.viewDetail = function(file_id){
		$rootScope.view_detail_file_id= file_id;
		$state.go('file-create');
	};

	// Uploader
	var uploader = $scope.uploader = new FileUploader({
		url: BASE_URL + '/file/upload',
	});

	$scope.file_cat_ids = [];

	$scope.uploadItem = function(item, $index){
		console.log($index);
		if($scope.category_id != undefined && $scope.category_id != '' ){
			$scope.file_cat_ids[$index] = $scope.category_id;
			item.upload();
		}
		else{
			if( $scope.file_cat_ids[$index] == undefined){
				sweetAlert("Oops...", "Please select file category!", "error");
			}
			else{
				item.upload();
			}		
		}
	}

	uploader.onBeforeUploadItem = function (item) {
		index = uploader.getIndexOfItem(item);
		if(typeof $scope.file_cat_ids[index] != 'undefined')
			item.formData.push({file_cat_id: $scope.file_cat_ids[index]});
		else{
			uploader.cancelItem(item);
            //sweetAlert("Oops...", "Please select file category!", "error");
        }
    }

    uploader.onSuccessItem = function(item, response, status, headers) {
		$scope.getFiles(post_information); // Refresh table
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

    $scope.file_categories= [];
    $http.get(BASE_URL + '/file/init')
    .success(function(data) {
    	$scope.file_categories = data;
    })
    .error(function(data, status, headers, config) {
    	$state.go('404'); 
    });

    $scope.remove = function(item) {
    	if(item.id == undefined){
    		$scope.files.splice(index, 1);
    	}
    	else{
    		sweetAlert({
    			title: "Are you sure?",
    			text: "You will not be able to recover this file!",
    			type: "warning",
    			showCancelButton: true,
    			confirmButtonColor: "#DD6B55",
    			confirmButtonText: "Yes, delete it!",
    			closeOnConfirm: false,
    			html: false
    		},
    		function(){
    			var index = $scope.files.indexOf(item);
    			$http.post(BASE_URL + '/file/deleteFileById', {id: item.id})
    			.success(function(data) {
    				if(data.success) {
    					$scope.files.splice(index, 1);
    					swal("Deleted!",
    						"Your file has been deleted.",
    						"success");
    				}
    				else{

    				}
    			})
    			.error(function(data, status, headers, config) {
    				$state.go('404'); 
    			});
    		});
    	}
    }

    $scope.email = {};
    $scope.email.documents = [];
    $scope.emailDocument = function(file){
    	$scope.email.documents = [];
    	$scope.email.documents.push(file);

    	$('#sendEmailModal').modal('show');
    }

    $scope.emailDocuments = function(){
    	$scope.email.documents = [];
    	$.each($scope.files, function(i, v){
	    	if($scope.selected_document_ids.indexOf(v.id) > -1){
	    		$scope.email.documents.push(v);
	    	}
	    })

    	$('#sendEmailModal').modal('show');
    }

	$scope.sendEmail = function(){
		var information_post= {'email': $scope.email, 'type': 'document'};
		$http.post(BASE_URL + '/email/send', information_post)
	    .success(function(data) {
		    if(data.success) {
		    	swal(data.message, "", "success");
		    	$('#sendEmailModal').modal('hide');
		    	$scope.email.content = "";
                        $scope.email.subject = "";
                        $scope.email.to = "";
		    }
		    else{
				swal(data.message, "", "error");
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');	
  		});
	};

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

}]);