angular.module('app').controller('AssetDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams) {
        $scope.init_loaded = false;

        $scope.createInit = function () {
            var post_information = {};

            $http.post(BASE_URL + '/asset/createInit', post_information)
                    .success(function (data) {
                        $scope.init_loaded = true;
                        if (data.success) {
                            $scope.asset_empty = data.asset_empty;
                            $scope.asset_error = data.asset_error;
                            $scope.asset_error_empty = data.asset_error_empty;
                            $scope.asset_categories = data.asset_categories;

                            $scope.is_update = true;
                        }
                        else {
                            $state.go('404');
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };
        $scope.createInit();

        $scope.getAssetById = function () {
            $http.post(BASE_URL + '/asset/getAssetById', {id: $stateParams.id})
                    .success(function (data) {
                        if (data.success) {
                            $scope.asset = data.asset;
                            $scope.asset_code = $scope.asset.asset_code;
                            $scope.asset_error = data.asset_error;
                        }
                        else {
                            $state.go('404');
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };
        $scope.getAssetById();

        $scope.update = function () {
            var information_post = $scope.asset;
            $http.post(BASE_URL + '/asset/update', information_post)
                    .success(function (data) {
                        if (data.success) {
                            swal('Asset updated!', "", "success");
                            $scope.asset = data.asset;
                            $scope.asset_error = $scope.asset_error_empty;

                            $("input").removeClass("ng-dirty");
                        }
                        else {
                            swal({
                                title: '',
                                text: 'Asset update failed!',
                                type: 'error',
                                html: true
                            });
                            $scope.asset_error = data.asset_error;
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };

        $scope.copyAsset = function () {
            $rootScope.view_detail_asset_id = $scope.asset.id;
            $rootScope.is_copy_asset = true;
            $state.go('asset-create');
        }

        // Remove related assets
        $scope.removeRelatedAsset = function(removed_asset, index){
          var information_post = {removed_asset_id: removed_asset.id, asset_id: $scope.asset.id};
          $http.post(BASE_URL + '/asset/removeRelatedAsset', information_post)
          .success(function (data) {
              if (data.success) {
                  swal('Asset removed!', "", "success");
                  $scope.asset.related_graphics = data.related_graphics;
                  $scope.asset.related_assets = data.related_assets;
              }
              else {
                  swal({
                      title: 'Remove asset failed!',
                      text: data.message,
                      type: 'error',
                      html: true
                  });
              }
          })
          .error(function (data, status, headers, config) {
              $state.go('404');
          });
        }

        // Popup
        $scope.showListAsset = function(){
        		$('#listAssetModal').modal('show');

            $scope.checkRelatedAsset = function(checked_asset){
              for(var i in $scope.asset.related_assets){
                var related_asset = $scope.asset.related_assets[i];
                if(related_asset.id == checked_asset.id){
                  return true;
                }
              }

              return false;
            };

            $scope.assets = [];
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
            $scope.start_asset = 1;
            $scope.end_asset = 1;
            $scope.totalresults = 0;
            $scope.sort = {
                attribute: 'created_time',
                type: 'DESC',
            };
            $scope.search_asset = {
                id: '',
                name: '',
                email: '',
                created: '',
                category_id: ''
            };
            var post_information = {
                'limitstart': 0,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
            };

            $scope.getAssets = function (post_information) {
                $http.post(BASE_URL + '/asset/getAll', post_information)
                .success(function (data) {
                    if (data.success) {
                        $scope.totalresults = parseInt(data.totalresults);
                        $scope.start_asset = data.start_asset;
                        $scope.end_asset = data.end_asset;
                        $scope.pages = [];
                        for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                            $scope.pages.push(p + 1);
                        //$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
                        $scope.assets = [];
                        $scope.assets = data.assets;
                        // for(var i= 0; i< data.assets.length; i++)
                        // $scope.assets.push(data.email_templates[i]);
                    }
                    else {
                        $state.go('404');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getAssets(post_information);

            $scope.getAssetCategories = function (post_information) {
                $http.post(BASE_URL + '/assetCategory/getAll', [])
                .success(function (data) {
                    if (data.success) {
                        $scope.asset_categories = data.asset_categories;
                    }
                    else {
                        swal('Can not get asset category list', '', 'error');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getAssetCategories(post_information);

            $scope.selectPage = function (page) {
                $scope.currentPage = page;
                var post_information = {
                    'limitstart': (page - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_asset.id,
                    'name': $scope.search_asset.name,
                    'category_id': $scope.search_asset.category_id,
                    'email': $scope.search_asset.email,
                    'created': $scope.search_asset.created,
                };
                $scope.getAssets(post_information);
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
                    'id': $scope.search_asset.id,
                    'name': $scope.search_asset.name,
                    'category_id': $scope.search_asset.category_id,
                    'email': $scope.search_asset.email,
                    'created': $scope.search_asset.created,
                };
                if ($scope.itemsByPage_change_number > 1)
                    $scope.getAssets(post_information);
            }, true);

            $scope.search_change_number = 0;
            $scope.$watch('search', function () {
                $scope.search_change_number++;
                var post_information = {
                    'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_asset.id,
                    'name': $scope.search_asset.name,
                    'category_id': $scope.search_asset.category_id,
                    'email': $scope.search_asset.email,
                    'created': $scope.search_asset.created,
                };
                if ($scope.search_change_number > 1)
                    $scope.getAssets(post_information);
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
                    'id': $scope.search_asset.id,
                    'name': $scope.search_asset.name,
                    'category_id': $scope.search_asset.category_id,
                    'email': $scope.search_asset.email,
                    'created': $scope.search_asset.created,
                };
                $scope.getAssets(post_information);
            };

            $scope.search = function () {
                post_information.category_id = $scope.search_asset.category_id;
                post_information.name = $scope.search_asset.name;
                post_information.email = $scope.search_asset.email;

                $scope.getAssets(post_information);
            }

            $scope.addRelatedAsset = function(added_asset){
              var information_post = {added_asset_id: added_asset.id, asset_id: $scope.asset.id};
              $http.post(BASE_URL + '/asset/addRelatedAsset', information_post)
              .success(function (data) {
                  if (data.success) {
                      swal('Asset added!', "", "success");
                      $scope.asset.related_graphics = data.related_graphics;
                      $scope.asset.related_assets = data.related_assets;
                  }
                  else {
                      swal({
                          title: 'Add asset failed!',
                          text: data.message,
                          type: 'error',
                          html: true
                      });
                  }
              })
              .error(function (data, status, headers, config) {
                  $state.go('404');
              });
            }

        }

        // Remove related graphics
        $scope.removeRelatedGraphic = function(removed_graphic, index){
          var information_post = {removed_graphic_id: removed_graphic.id, asset_id: $scope.asset.id};
          $http.post(BASE_URL + '/asset/removeRelatedGraphic', information_post)
          .success(function (data) {
              if (data.success) {
                  swal('Graphic removed!', "", "success");
                  $scope.asset.related_graphics = data.related_graphics;
                  $scope.asset.related_assets = data.related_assets;
              }
              else {
                  swal({
                      title: 'Remove graphic failed!',
                      text: data.message,
                      type: 'error',
                      html: true
                  });
              }
          })
          .error(function (data, status, headers, config) {
              $state.go('404');
          });
        }

        // Popup
        $scope.showListGraphic = function(){
        		$('#listGraphicModal').modal('show');

            $scope.checkRelatedGraphic = function(checked_graphic){
              for(var i in $scope.asset.related_graphics){
                var related_graphic = $scope.asset.related_graphics[i];
                if(related_graphic.id == checked_graphic.id){
                  return true;
                }
              }

              return false;
            };

            $scope.graphics = [];
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
            $scope.start_graphic = 1;
            $scope.end_graphic = 1;
            $scope.totalresults = 0;
            $scope.sort = {
                attribute: 'created_time',
                type: 'DESC',
            };
            $scope.search_graphic = {
                id: '',
                name: '',
                email: '',
                created: '',
                category_id: ''
            };
            var post_information = {
                'limitstart': 0,
                'limitnum': $scope.itemsByPage,
                'sort_attribute': $scope.sort.attribute,
                'sort_type': $scope.sort.type,
            };

            $scope.getGraphics = function (post_information) {
                $http.post(BASE_URL + '/graphic/getAll', post_information)
                .success(function (data) {
                    if (data.success) {
                        $scope.totalresults = parseInt(data.totalresults);
                        $scope.start_graphic = data.start_graphic;
                        $scope.end_graphic = data.end_graphic;
                        $scope.pages = [];
                        for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                            $scope.pages.push(p + 1);
                        //$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
                        $scope.graphics = [];
                        $scope.graphics = data.graphics;
                        // for(var i= 0; i< data.graphics.length; i++)
                        // $scope.graphics.push(data.email_templates[i]);
                    }
                    else {
                        $state.go('404');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getGraphics(post_information);

            $scope.getGraphicCategories = function (post_information) {
                $http.post(BASE_URL + '/graphicCategory/getAll', [])
                .success(function (data) {
                    if (data.success) {
                        $scope.graphic_categories = data.graphic_categories;
                    }
                    else {
                        swal('Can not get graphic category list', '', 'error');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getGraphicCategories(post_information);

            $scope.selectPage = function (page) {
                $scope.currentPage = page;
                var post_information = {
                    'limitstart': (page - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_graphic.id,
                    'name': $scope.search_graphic.name,
                    'category_id': $scope.search_graphic.category_id,
                    'email': $scope.search_graphic.email,
                    'created': $scope.search_graphic.created,
                };
                $scope.getGraphics(post_information);
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
                    'id': $scope.search_graphic.id,
                    'name': $scope.search_graphic.name,
                    'category_id': $scope.search_graphic.category_id,
                    'email': $scope.search_graphic.email,
                    'created': $scope.search_graphic.created,
                };
                if ($scope.itemsByPage_change_number > 1)
                    $scope.getGraphics(post_information);
            }, true);

            $scope.search_change_number = 0;
            $scope.$watch('search', function () {
                $scope.search_change_number++;
                var post_information = {
                    'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_graphic.id,
                    'name': $scope.search_graphic.name,
                    'category_id': $scope.search_graphic.category_id,
                    'email': $scope.search_graphic.email,
                    'created': $scope.search_graphic.created,
                };
                if ($scope.search_change_number > 1)
                    $scope.getGraphics(post_information);
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
                    'id': $scope.search_graphic.id,
                    'name': $scope.search_graphic.name,
                    'category_id': $scope.search_graphic.category_id,
                    'email': $scope.search_graphic.email,
                    'created': $scope.search_graphic.created,
                };
                $scope.getGraphics(post_information);
            };

            $scope.search = function () {
                post_information.category_id = $scope.search_graphic.category_id;
                post_information.name = $scope.search_graphic.name;
                post_information.email = $scope.search_graphic.email;

                $scope.getGraphics(post_information);
            }

            $scope.addRelatedGraphic = function(added_graphic){
              var information_post = {added_graphic_id: added_graphic.id, asset_id: $scope.asset.id};
              $http.post(BASE_URL + '/asset/addRelatedGraphic', information_post)
              .success(function (data) {
                  if (data.success) {
                      swal('Graphic added!', "", "success");
                      $scope.asset.related_graphics = data.related_graphics;
                      $scope.asset.related_assets = data.related_assets;
                  }
                  else {
                      swal({
                          title: 'Add graphic failed!',
                          text: data.message,
                          type: 'error',
                          html: true
                      });
                  }
              })
              .error(function (data, status, headers, config) {
                  $state.go('404');
              });
            }

        }
    }
]);
