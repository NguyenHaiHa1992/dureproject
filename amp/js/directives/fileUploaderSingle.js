angular.module('app').directive('fileUploaderSingle',[ '$http', '$state', 'BASE_URL', '$rootScope', function ($http, $state, BASE_URL, $rootScope) {
  return {
    restrict: 'E',
    replace: true,
    scope:{ fileId: "=", modelId: "=", disabled: "=", optionStyle: "=", fieldId: "="},
    templateUrl: "amp/views/partials/_fileUploaderSingle.html",
    controller: ['$scope','FileUploader', '$rootScope', function ($scope, FileUploader, $rootScope){
      $scope.root = $rootScope;
      var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL + '/file/upload',
        autoUpload : true,
      });

      $scope.uploadItem = function(item, $index){
        item.upload();
      }

      uploader.onSuccessItem = function(item, response, status, headers) {
        $('#loadingModal').hide();
        if(response.success){
          if(typeof response.file.id != 'undefined'){
            item.remove();
            $scope.fileId = response.file.id;
          }
        }
        else{
          item.remove();
          sweetAlert({
            title: response.message,
            text: "",
            type: "error",
            html: true
          });
        }
      }

      uploader.onBeforeUploadItem = function(item, response, status, headers) {
        console.log('uploading');
        $('#loadingModal').show();
      }

      $scope.remove = function(item) {
          $scope.fileId = 0;
          $scope.has_file = false;
          
//        if(item.id == undefined || item.id == 0 || item.id == ''){
//          console.log('No file to delete');
//          $scope.fileId = 0;
//          $scope.has_file = false;
//        }
//        else{
//          sweetAlert({
//            title: "Are you sure?",
//            text: "You will not be able to recover this file!",
//            type: "warning",
//            showCancelButton: true,
//            confirmButtonColor: "#DD6B55",
//            confirmButtonText: "Yes, delete it!",
//            closeOnConfirm: false,
//            html: false
//          },
//          function(){
//            $http.post(BASE_URL + '/file/deleteFileById', {id: item.id})
//              .success(function(data) {
//                if(data.success) {
//                  $scope.fileId = 0;
//                  $scope.has_file = false;
//                  swal("Deleted!",
//                  "Your file has been deleted.",
//                  "success");
//                }
//                else{
//                  swal(data.message,"","error");
//                }
//            })
//            .error(function(data, status, headers, config) {
//                $state.go('404');
//            });
//          });
//        }
      }

      // Config style
      // Default style

      switch($scope.optionStyle) {
          case 'simple':
              $scope.is_show_file_name = false;
              break;
          case 'full':
              $scope.is_show_image = false;
              $scope.is_show_file_name = true;
              break;
          case 'image':
              $scope.is_show_file_name = true;
              $scope.is_show_image = true;

              break;
          default:
            $scope.is_show_file_name = false;
            break;
      }
      
      // Add fancy box
      $('.uploaded_file.image_file').fancybox();
      
      
        
        $scope.showListDocumentSingle = function showListDocumentSingle() {
            $('#'+$scope.fieldId+'listDocumentModalSingle').modal('show');
            $scope.checkRelatedDocument = function(checked_document){
                if($scope.fileId == checked_document.id){
                  return true;
                }
                return false;
            };
            
            $scope.documents = [];
            $scope.itemsByPage = 10;
            $scope.itemsByPages = [
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
            $scope.pages = [];
            $scope.currentPage = 1;
            $scope.start_document = 1;
            $scope.end_document = 1;
            $scope.totalresults = 0;
            $scope.sort = {
                attribute: 'created_time',
                type: 'DESC',
            };
            $scope.search_document = {
                id: '',
                filename: '',
                restricted: '',
                created: '',
                cat_id: ''
            };
            $scope.restricted_list = [
                {id: "1", name: "Yes"},
                {id: "0", name: "No"}
            ];
            var post_information = {
                'limitstart': 0,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
            };

            $scope.getDocuments = function (post_information) {
                $http.post(BASE_URL + '/file/getAll', post_information)
                .success(function (data) {
                    if (data.success) {
                        $scope.totalresults = parseInt(data.totalresults);
                        $scope.start_document = data.start_file;
                        $scope.end_document = data.end_file;
                        $scope.pages = [];
                        for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                            $scope.pages.push(p + 1);
                        //$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
                        $scope.documents = [];
                        $scope.documents = data.files;
                        // for(var i= 0; i< data.fixtures.length; i++)
                        // $scope.fixtures.push(data.email_templates[i]);
                    }
                    else {
                        $state.go('404');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getDocuments(post_information);
            
            $scope.file_categories = [];
            $scope.getDocumentCategories = function (post_information) {
                $http.post(BASE_URL + '/fileCategory/getAll', [])
                .success(function (data) {
                    if (data.success) {
                        $scope.file_categories = data.file_categories;
                    }
                    else {
                        swal('Can not get document category list', '', 'error');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getDocumentCategories(post_information);

            $scope.selectPage = function (page) {
                $scope.currentPage = page;
                var post_information = {
                    'limitstart': (page - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_document.id,
                    'filename': $scope.search_document.filename,
                    'cat_id': $scope.search_document.cat_id,
                    'restricted': $scope.search_document.restricted,
                };
                $scope.getDocuments(post_information);
            };

            $scope.itemsByPage_change_number = 0;
            $scope.$watch('itemsByPage', function () {
                $scope.itemsByPage_change_number++;
                if ($scope.itemsByPage == 0 || $scope.itemsByPage == '0' || $scope.itemsByPage == '' || $scope.itemsByPage == null)
                    $scope.itemsByPage = 1;
                var post_information = {
                    'limitstart': 0,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_document.id,
                    'filename': $scope.search_document.filename,
                    'cat_id': $scope.search_document.cat_id,
                    'restricted': $scope.search_document.restricted,
                };
                if ($scope.itemsByPage_change_number > 1)
                    $scope.getDocuments(post_information);
            }, true);

            $scope.search_change_number = 0;
            $scope.$watch('search', function () {
                $scope.search_change_number++;
                var post_information = {
                    'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_document.id,
                    'filename': $scope.search_document.filename,
                    'cat_id': $scope.search_document.cat_id,
                    'restricted': $scope.search_document.restricted,
                };
                if ($scope.search_change_number > 1)
                    $scope.getDocuments(post_information);
            }, true);

            $scope.sort = function (sort_attribute) {
                if ($scope.sort.attribute == sort_attribute)
                    if ($scope.sort.type == 'DESC')
                        $scope.sort.type = 'ASC';
                    else
                        $scope.sort.type = 'DESC';
                else {
                    $scope.sort.attribute = sort_attribute;
                    $scope.sort.type = 'DESC';
                }
                var post_information = {
                    'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_document.id,
                    'filename': $scope.search_document.filename,
                    'cat_id': $scope.search_document.cat_id,
                    'restricted': $scope.search_document.restricted,
                };
                $scope.getDocuments(post_information);
            };

            $scope.search = function () {
                post_information.cat_id = $scope.search_document.cat_id;
                post_information.filename = $scope.search_document.filename;
                post_information.restricted = $scope.search_document.restricted;

                $scope.getDocuments(post_information);
            }

            $scope.addRelatedDocument = function(document){
                $scope.fileId = document.id;
            }
        };
    }],
    link: function(scope, iElement, iAttrs){
      scope.has_file = false;
      scope.$watch('fileId', function(newValue, oldValue) {

        if(scope.fileId != undefined && scope.fileId != '' && scope.fileId != 0){
          $http.post(BASE_URL + '/file/getFileById', {id: scope.fileId})
            .success(function(data) {
              if(data.success){
                scope.file = data.file;
                scope.has_file = true;
              }
              else{
                scope.file = '';
              }
          })
          .error(function(data, status, headers, config) {
              $state.go('404');
          });
        }
        else{
          scope.has_file = false;
        }
      });

      scope.$watch('modelId', function(newValue, oldValue) {
          scope.uploader.clearQueue();
      });
    }
  };
}]);
