angular.module('app').directive('fileUploader',[ '$rootScope', '$http', '$state', 'BASE_URL', function ($rootScope, $http, $state, BASE_URL) {
  return {
    restrict: 'E',
    replace: true,
    scope:{ fileIds: "=", modelId: "=", disabled: "=", optionStyle: "=", sendemail: "=", emailFiles: "="},
    templateUrl: "amp/views/partials/_fileUploader.html",
    controller: ['$scope', '$rootScope', 'FileUploader', function ($scope, $rootScope, FileUploader){
      $scope.root = $rootScope;
      var uploader = $scope.uploader = new FileUploader({
        url: BASE_URL + '/file/upload',
      });

      $scope.file_cat_ids = [];
      $scope.file_restricteds = [];

      $scope.uploadItem = function(item, $index){
        if( $scope.file_cat_ids[$index] == undefined){
          sweetAlert("Oops...", "Please select file category!", "error");
        }
        else{
            console.log(item);
          item.upload();
        }
      }

      uploader.onBeforeUploadItem = function (item) {
          index = uploader.getIndexOfItem(item);
          if(typeof $scope.file_cat_ids[index] != 'undefined'){
            item.formData.push({file_cat_id: $scope.file_cat_ids[index]});
            $('#loadingModal').show();
          }
          else{
            uploader.cancelItem(item);
          }

          if(typeof $scope.file_restricteds[index] != 'undefined'){
            item.formData.push({file_restricted: $scope.file_restricteds[index]});
            $('#loadingModal').show();
          }
          else{
            uploader.cancelItem(item);
          }
      }

      uploader.onSuccessItem = function(item, response, status, headers) {
        $('#loadingModal').hide();
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


      $scope.changeFileCategory = function(category_id){
        var num_file = $scope.uploader.queue.length;
        for (var i = 0; i < num_file; i++) {
          $scope.file_cat_ids[i] = category_id;
        };
      };

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
            var stateName = $state.current.name;
            var urlParams = {
                file_id: item.id,
                model_id: $scope.modelId,
                related: ""
            };
            if(stateName === "store-detail"){
                urlParams.related = "store_file";
            }
            else if(stateName === "signage-detail"){
                urlParams.related = "signage_file";
            }
            else if(stateName === "fixture-detail"){
                urlParams.related = "fixture_file";
            }
            else if(stateName === "customer-detail"){
                urlParams.related = "customer_file";
            }
            else if(stateName === "project-detail"){
                urlParams.related = "project_file";
            }
//            $http.post(BASE_URL + '/file/deleteFileById', {id: item.id})
            $http.post(BASE_URL + '/file/deleterelated', urlParams)
              .success(function(data) {
                if(data.success) {
                  $scope.files.splice(index, 1);
                  swal("Deleted!",
                  "Your file has been deleted.",
                  "success");
                }
                else{
                    swal("Error!",
                        data.message,
                        "error");
                }
            })
            .error(function(data, status, headers, config) {
                $state.go('404');
            });
          });
        }
      }
      
      // Add fancy box
      $('.files .uploaded_file').fancybox();
      
      // search files
      $scope.restricted_list = [
          {id: "1", name: "Yes"},
          {id: "0", name: "No"}
      ];
      $scope.search_form = {
            ids: "",
            name: "",
            cat_id: "",
            restricted: "",
            limitstart: 0,
            limitnum: 10
      };
      $scope.searchFile = function(){
          $scope.search_form.ids = $scope.fileIds;
          $http.post(BASE_URL + '/file/getFilesByIds', $scope.search_form)
            .success(function (data) {
                if (data.success) {
                    $scope.files = data.files;
                    $scope.filePages.totalresults = data.totalresults;
                    $scope.filePages.pages = [];
                    for (var p = 0; p < Math.ceil(data.totalresults / $scope.search_form.limitnum); p++)
                        $scope.filePages.pages.push(p + 1);
                    $scope.filePages.start_file = data.start_file;
                    $scope.filePages.end_file = data.end_file;
                }
                else {
                    $scope.files = [];
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
      };

      /* email */
        $scope.emailFiles = [];
        $scope.emailDocument = function (file) {
            $scope.emailFiles = [];
            $scope.emailFiles.push(file);

            $('#sendEmailModal').modal('show');
        }

        $scope.emailDocuments = function () {
            $scope.emailFiles = [];
            $.each($scope.files, function (i, v) {
                if ($scope.selected_document_ids.indexOf(v.id) > -1) {
                    $scope.emailFiles.push(v);
                }
            })

            $('#sendEmailModal').modal('show');
        }

/*
        $scope.sendEmail = function () {
            var information_post = {'email': $scope.email, 'type': 'document'};
            $http.post(BASE_URL + '/email/send', information_post)
            .success(function (data) {
                if (data.success) {
                    swal(data.message, "", "success");
                    $('#sendEmailModal').modal('hide');
                    $scope.email.content = "";
                    $scope.email.subject = "";
                    $scope.email.to = "";
                }
                else {
                    swal(data.message, "", "error");
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
*/
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
        
        $scope.showListDocument = function showListDocument() {
            $('#listDocumentModal').modal('show');
            $scope.checkRelatedDocument = function(checked_document){
              for(var i in $scope.files){
                var related_signage = $scope.files[i];
                if(related_signage.id == checked_document.id){
                  return true;
                }
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
                {
                    value: 50,
                    name: 50
                },
                {
                    value: 100,
                    name: 100
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

//            $scope.getDocumentCategories = function (post_information) {
//                $http.post(BASE_URL + '/fileCategory/getAll', [])
//                .success(function (data) {
//                    if (data.success) {
//                        $scope.document_categories = data.file_categories;
//                    }
//                    else {
//                        swal('Can not get document category list', '', 'error');
//                    }
//                })
//                .error(function (data, status, headers, config) {
//                    $state.go('404');
//                });
//            };
//            $scope.getDocumentCategories(post_information);

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
                $scope.files.push(document);
//                $scope.fileIds += ',' + document.id;
                $scope.fileIds = document.id + "," + $scope.fileIds;
            }
        };
    }],
    link: function(scope, iElement, iAttrs){
        scope.filePages = {
            pages: [],
            totalresults: "",
            start_file: 0,
            end_file: 0,
            itemsByPages: [],
            currentPage: 1,
            selectPage: null
        };
      scope.$watch('fileIds', function(newValue, oldValue) {
        $http.post(BASE_URL + '/file/getFilesByIds', {ids: scope.fileIds, limitstart: 0, limitnum: 10})
          .success(function(data) {
            if(data.success){
              scope.files = data.files;
              scope.filePages.totalresults = data.totalresults;
              scope.filePages.pages = [];
              for (var p = 0; p < Math.ceil(data.totalresults / scope.search_form.limitnum); p++)
                    scope.filePages.pages.push(p + 1);
              scope.filePages.start_file = data.start_file;
              scope.filePages.end_file = data.end_file;
            }
            else{
              scope.files = [];
            }
        })
        .error(function(data, status, headers, config) {
            $state.go('404');
        });
      });

      scope.$watch('modelId', function(newValue, oldValue) {
          scope.uploader.clearQueue();
      });
      
      scope.filePages.itemsByPages = [
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
                {
                    value: 50,
                    name: 50
                },
                {
                    value: 100,
                    name: 100
                },
                
            ];
        scope.filePages.selectPage = function (page) {
            scope.filePages.currentPage = page;
            scope.search_form.limitstart = (page - 1) * scope.search_form.limitnum;
            scope.searchFile();
        };
    }
  };
}]);
