angular.module('app').controller('FileController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', 'FileUploader', 'File',
    function($scope, $route, File, BASE_URL, FileUploader) {
	 	$scope.baseUrl = BASE_URL;
	 	$scope.filterCriteria = {
             currentPage: 1,
             pageSize: 20,
             orders: {
                 name: 'desc',
                 filename: 'asc',
                 id: ''
             },
             // EQUAL, NOT_EQUAL, CONTAINS, DOES_NOT_CONTAIN
             // LESS_THAN, LESS_THAN_OR_EQUAL, GREATER_THAN, GREATER_THAN_OR_EQUAL, IN, STARTS_WITH, ENDS_WITH
             filters: {
                 name: {
                     operator: 'EQUAL',
                     value: ''
                 },
                 filename: {
                     operator: 'CONTAINS',
                     value: ''
                 }
             }
         };

         if($route.current.params.page > 0) {
             $scope.filterCriteria.currentPage = parseInt($route.current.params.page);
         };
         $scope.filesCount = 0;
         $scope.totalPages = 0;

         $scope.fetchResult = function () {
             return File.query($scope.filterCriteria).$promise.then(function (data) {
                 $scope.files = data.files;
                 $scope.current_file = $scope.files[0];

                 if($scope.filesCount != data.total) {
                     $scope.filesCount = data.total;
                     $scope.filterCriteria.currentPage = data.currentPage;
                     $scope.totalPages = Math.ceil($scope.filesCount / $scope.filterCriteria.pageSize);
                 }
             }, function (errResponse) {
                 $scope.files = [];
                 $scope.totalPages = 0;
                 $scope.filesCount = 0;
                 if($route.current.params.page > 0) {
                     $scope.filterCriteria.currentPage = parseInt($route.current.params.page);
                 }
                 else{
                     $scope.filterCriteria.currentPage = 1;
                 }
             });
         }

         $scope.changePageSize = function (pageSize) {
             $scope.filterCriteria.pageSize = pageSize;
             $scope.fetchResult();
         }

         $scope.remove = function(index) {
             var recipe = $scope.files[index];
             recipe.$delete();
             $scope.files.splice(index, 1);
         };
         //called when navigate to another page in the pagination
         $scope.selectPage = function (page) {
             $scope.filterCriteria.currentPage = page;
             $scope.fetchResult();
         };

         //Will be called when filtering the grid, will reset the page number to one
         $scope.filterResult = function () {
             $scope.fetchResult();
         };

         //call back function that we passed to our custom directive sortBy, will be called when clicking on any field to sort
         $scope.onSort = function (sortedBy, sortDir) {
             /*
             angular.forEach($scope.filterCriteria.orders,function(value,key){
                 $scope.filterCriteria.orders[key] = '';
             });
             */
             $scope.filterCriteria.orders[sortedBy] = sortDir;
             $scope.fetchResult();
         };

         //manually select a page to trigger an ajax request to populate the grid on page load
         $scope.selectPage($scope.filterCriteria.currentPage);

         $scope.showDetail = function(file){
        	 $scope.current_file = file;
         }

         $scope.editCurrentFile = function(current_file){
        	 $scope.edit_current_file = angular.copy($scope.current_file);
        	 $scope.show_edit_current_file = !$scope.show_edit_current_file;
         };

         $scope.updateCurrentFile = function(edit_current_file){
        	 angular.copy($scope.edit_current_file, $scope.current_file);
         }
        //Uploader
        var uploader = $scope.uploader = new FileUploader({
            url: BASE_URL + '/admin/file/upload'
        });

        // CALLBACKS
        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };

    }]);