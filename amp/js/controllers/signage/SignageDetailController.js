angular.module('app').controller('SignageDetailController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state', '$stateParams', '$window', '$anchorScroll', 
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $stateParams, $window, $anchorScroll) {
        $scope.root = $rootScope;
        $scope.init_loaded = false;

        $scope.createInit = function () {
            var post_information = {};

            $http.post(BASE_URL + '/signage/createInit', post_information)
                    .success(function (data) {
                        $scope.init_loaded = true;
                        if (data.success) {
                            $scope.signage_empty = data.signage_empty;
                            $scope.signage_error = data.signage_error;
                            $scope.signage_error_empty = data.signage_error_empty;
                            $scope.signage_categories = data.signage_categories;

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

        $scope.getSignageById = function () {
            $http.post(BASE_URL + '/signage/getSignageById', {id: $stateParams.id})
                    .success(function (data) {
                        if (data.success) {
                            $scope.languages = data.languages;
                            $scope.signage = data.signage;
                            $scope.signage_code = $scope.signage.signage_code;
                            $scope.signage_error = data.signage_error;
                            var open = $scope.openCollapse(); 
                            if(open){
                                $anchorScroll();
                            }
                            $scope.fsPagination.getParams.group_number = data.signage.group_number;
                            $scope.getFixturePagination(data.signage.fsPagination);
                            $scope.fsPagination.categories = data.signage.related_fixtures_categories;
                            $scope.getStorePagination(data.signage.storePagination);
                        }
                        else {
                            $state.go('404');
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };
        $scope.getSignageById();

        $scope.update = function () {
            var information_post = $scope.signage;
            $http.post(BASE_URL + '/signage/update', information_post)
                    .success(function (data) {
                        if (data.success) {
                            swal('Signage updated!', "", "success");
                            $scope.signage = data.signage;
                            $scope.signage_error = $scope.signage_error_empty;

                            $("input").removeClass("ng-dirty");
                        }
                        else {
                            swal({
                                title: '',
                                text: 'Signage update failed!',
                                type: 'error',
                                html: true
                            });
                            $scope.signage_error = data.signage_error;
                        }
                    })
                    .error(function (data, status, headers, config) {
                        $state.go('404');
                    });
        };

        $scope.copySignage = function () {
//            $rootScope.view_detail_signage_id = $scope.signage.id;
//            $rootScope.is_copy_signage = true;
//            $state.go('signage-create');
            $http.post(BASE_URL + '/signage/copy', {id: $scope.signage.id})
            .success(function (data) {
                if (data.success) {
                    $state.go('signage-detail', {id: data.id});
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        }

        // Remove related signages
        $scope.removeRelatedSignage = function(removed_signage, index){
          var information_post = {removed_signage_id: removed_signage.id, signage_id: $scope.signage.id};
          $http.post(BASE_URL + '/signage/removeRelatedSignage', information_post)
          .success(function (data) {
              if (data.success) {
                  swal('Signage removed!', "", "success");
                  $scope.signage.related_fixtures = data.related_fixtures;
                  $scope.signage.related_signages = data.related_signages;
              }
              else {
                  swal({
                      title: 'Remove signage failed!',
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
        $scope.showListSignage = function(){
        		$('#listSignageModal').modal('show');

            $scope.checkRelatedSignage = function(checked_signage){
              for(var i in $scope.signage.related_signages){
                var related_signage = $scope.signage.related_signages[i];
                if(related_signage.id == checked_signage.id){
                  return true;
                }
              }

              return false;
            };

            $scope.signages = [];
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
            $scope.start_signage = 1;
            $scope.end_signage = 1;
            $scope.totalresults = 0;
            $scope.sort = {
                attribute: 'created_time',
                type: 'DESC',
            };
            $scope.search_signage = {
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

            $scope.getSignages = function (post_information) {
                $http.post(BASE_URL + '/signage/getAll', post_information)
                .success(function (data) {
                    if (data.success) {
                        $scope.totalresults = parseInt(data.totalresults);
                        $scope.start_signage = data.start_signage;
                        $scope.end_signage = data.end_signage;
                        $scope.pages = [];
                        for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                            $scope.pages.push(p + 1);
                        //$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
                        $scope.signages = [];
                        $scope.signages = data.signages;
                        // for(var i= 0; i< data.signages.length; i++)
                        // $scope.signages.push(data.email_templates[i]);
                    }
                    else {
                        $state.go('404');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getSignages(post_information);

            $scope.getSignageCategories = function (post_information) {
                $http.post(BASE_URL + '/signageCategory/getAll', [])
                .success(function (data) {
                    if (data.success) {
                        $scope.signage_categories = data.signage_categories;
                    }
                    else {
                        swal('Can not get signage category list', '', 'error');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getSignageCategories(post_information);

            $scope.selectPage = function (page) {
                $scope.currentPage = page;
                var post_information = {
                    'limitstart': (page - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_signage.id,
                    'name': $scope.search_signage.name,
                    'category_id': $scope.search_signage.category_id,
                    'email': $scope.search_signage.email,
                    'created': $scope.search_signage.created,
                };
                $scope.getSignages(post_information);
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
                    'id': $scope.search_signage.id,
                    'name': $scope.search_signage.name,
                    'category_id': $scope.search_signage.category_id,
                    'email': $scope.search_signage.email,
                    'created': $scope.search_signage.created,
                };
                if ($scope.itemsByPage_change_number > 1)
                    $scope.getSignages(post_information);
            }, true);

            $scope.search_change_number = 0;
            $scope.$watch('search', function () {
                $scope.search_change_number++;
                var post_information = {
                    'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_signage.id,
                    'name': $scope.search_signage.name,
                    'category_id': $scope.search_signage.category_id,
                    'email': $scope.search_signage.email,
                    'created': $scope.search_signage.created,
                };
                if ($scope.search_change_number > 1)
                    $scope.getSignages(post_information);
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
                    'id': $scope.search_signage.id,
                    'name': $scope.search_signage.name,
                    'category_id': $scope.search_signage.category_id,
                    'email': $scope.search_signage.email,
                    'created': $scope.search_signage.created,
                };
                $scope.getSignages(post_information);
            };

            $scope.search = function () {
                post_information.category_id = $scope.search_signage.category_id;
                post_information.name = $scope.search_signage.name;
                post_information.email = $scope.search_signage.email;

                $scope.getSignages(post_information);
            }

            $scope.addRelatedSignage = function(added_signage){
              var information_post = {added_signage_id: added_signage.id, signage_id: $scope.signage.id};
              $http.post(BASE_URL + '/signage/addRelatedSignage', information_post)
              .success(function (data) {
                  if (data.success) {
                      swal('Signage added!', "", "success");
                      $scope.signage.related_fixtures = data.related_fixtures;
                      $scope.signage.related_signages = data.related_signages;
                  }
                  else {
                      swal({
                          title: 'Add signage failed!',
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

        // Remove related fixtures
        $scope.removeRelatedFixture = function(removed_fixture, index){
          var information_post = {removed_fixture_id: removed_fixture.id, signage_id: $scope.signage.id};
          $http.post(BASE_URL + '/signage/removeRelatedFixture', information_post)
          .success(function (data) {
              if (data.success) {
                  swal('Fixture removed!', "", "success");
                  $scope.signage.related_fixtures = data.related_fixtures;
                  $scope.signage.related_signages = data.related_signages;
              }
              else {
                  swal({
                      title: 'Remove fixture failed!',
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
        $scope.showListFixture = function(){
            $('#listFixtureModal').modal('show');

            $scope.checkRelatedFixture = function(checked_fixture){
              for(var i in $scope.signage.related_fixtures){
                var related_fixture = $scope.signage.related_fixtures[i];
                if(related_fixture.id == checked_fixture.id){
                  return true;
                }
              }

              return false;
            };

            $scope.fixtures = [];
            $scope.itemsByPage = 10;
            
            $scope.pages = [];
            $scope.currentPage = 1;
            $scope.start_fixture = 1;
            $scope.end_fixture = 1;
            $scope.totalresults = 0;
            $scope.sort = {
                attribute: 'created_time',
                type: 'DESC',
            };
            $scope.search_fixture = {
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

            $scope.getFixtures = function (post_information) {
                $http.post(BASE_URL + '/fixture/getAll', post_information)
                .success(function (data) {
                    if (data.success) {
                        $scope.totalresults = parseInt(data.totalresults);
                        $scope.start_fixture = data.start_fixture;
                        $scope.end_fixture = data.end_fixture;
                        $scope.pages = [];
                        for (var p = 0; p < Math.ceil(data.totalresults / $scope.itemsByPage); p++)
                            $scope.pages.push(p + 1);
                        //$scope.pages= Math.ceil(data.totalresults/$scope.itemsByPage);
                        $scope.fixtures = [];
                        $scope.fixtures = data.fixtures;
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
            $scope.getFixtures(post_information);

            $scope.getFixtureCategories = function (post_information) {
                $http.post(BASE_URL + '/fixtureCategory/getAll', [])
                .success(function (data) {
                    if (data.success) {
                        $scope.fixture_categories = data.fixture_categories;
                    }
                    else {
                        swal('Can not get fixture category list', '', 'error');
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });
            };
            $scope.getFixtureCategories(post_information);

            $scope.selectPage = function (page) {
                $scope.currentPage = page;
                var post_information = {
                    'limitstart': (page - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_fixture.id,
                    'name': $scope.search_fixture.name,
                    'category_id': $scope.search_fixture.category_id,
                    'email': $scope.search_fixture.email,
                    'created': $scope.search_fixture.created,
                };
                $scope.getFixtures(post_information);
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
                    'id': $scope.search_fixture.id,
                    'name': $scope.search_fixture.name,
                    'category_id': $scope.search_fixture.category_id,
                    'email': $scope.search_fixture.email,
                    'created': $scope.search_fixture.created,
                };
                if ($scope.itemsByPage_change_number > 1)
                    $scope.getFixtures(post_information);
            }, true);

            $scope.search_change_number = 0;
            $scope.$watch('search', function () {
                $scope.search_change_number++;
                var post_information = {
                    'limitstart': ($scope.currentPage - 1) * $scope.itemsByPage,
                    'limitnum': $scope.itemsByPage,
                    'sort_attribute': $scope.sort.attribute,
                    'sort_type': $scope.sort.type,
                    'id': $scope.search_fixture.id,
                    'name': $scope.search_fixture.name,
                    'category_id': $scope.search_fixture.category_id,
                    'email': $scope.search_fixture.email,
                    'created': $scope.search_fixture.created,
                };
                if ($scope.search_change_number > 1)
                    $scope.getFixtures(post_information);
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
                    'id': $scope.search_fixture.id,
                    'name': $scope.search_fixture.name,
                    'category_id': $scope.search_fixture.category_id,
                    'email': $scope.search_fixture.email,
                    'created': $scope.search_fixture.created,
                };
                $scope.getFixtures(post_information);
            };

            $scope.search = function () {
                post_information.category_id = $scope.search_fixture.category_id;
                post_information.name = $scope.search_fixture.name;
                post_information.email = $scope.search_fixture.email;

                $scope.getFixtures(post_information);
            }

            $scope.addRelatedFixture = function(added_fixture){
              var information_post = {added_fixture_id: added_fixture.id, signage_id: $scope.signage.id};
              $http.post(BASE_URL + '/signage/addRelatedFixture', information_post)
              .success(function (data) {
                  if (data.success) {
                      swal('Fixture added!', "", "success");
                      $scope.signage.related_fixtures = data.related_fixtures;
                      $scope.signage.related_signages = data.related_signages;
                      $scope.signage.group_number = data.group_number;
                  }
                  else {
                      swal({
                          title: 'Add fixture failed!',
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
        
        // Export PDF and Email
        $scope.exportPdf = function(){
            $http.get(BASE_URL + '/signage/exportPdf?id=' + $scope.signage.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Signage Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export EXCEL and Email
        $scope.exportExcel = function(){
            $http.get(BASE_URL + '/signage/exportExcelItem?id=' + $scope.signage.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Signage Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };

        $scope.initEmail = function () {
            var post_information = {type: 'document'};
            $http.post(BASE_URL + '/email/init', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.email = data.email;
                    $scope.email_title = data.email_title;
                    $scope.email_empty = data.email_empty;
                    $scope.email_error = data.email_error_empty;
                    $scope.email_error_empty = data.email_error_empty;
                }
                else {
                    if (data.type == 'nothing') {
                    }
                    else if (data.type == 'alert') {
                        swal(data.message, "", "error");

                        return false;
                    }
                    else {
                        $state.go('404');
                    }
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.initEmail();

        $scope.email = {};
        $scope.email.documents = [];
        $scope.emailFile = function (file) {
            $scope.email.documents = [];
            $scope.email.documents.push(file);
            $scope.$apply();
            $('#sendEmailModal').modal('show');
        }

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

	// Jquery
	jQuery("[data-widget='collapse']").click(function() {
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
        
        $scope.updateRelatedStore = function(store){
            $scope.store_form.store = {
                id: store.store_signage_id,
                signage_id: $stateParams.id,
                note: store.store_signage_note,
                store_id: store.id,
                name: store.name,
                signage_quantity: store.signage_quantity
            };

        	$('#formStoreModal').modal('show');
        }

        // Popup
        $scope.store_form = {};
        $scope.store_form.store = {
          signage_id: $stateParams.id
        };

        $scope.store_form.addStore = function(){
            $scope.store_form.store = {
                signage_id: $stateParams.id,
                signage_quantity: 1
            };
            $('#formStoreModal').modal('show');
        }

        $scope.store_form.saveStoreSignage = function(){
            var information_post = $scope.store_form.store;
            $http.post(BASE_URL + '/storeSignage/update', information_post)
            .success(function (data) {
                if (data.success) {
                    swal('Store saved!', "", "success");
                    $('#formStoreModal').modal('hide');
                    $scope.store_form.store_error = {};
                    $scope.getStores({signage_id: $stateParams.id});
                }
                else {
                    swal({
                        title: '',
                        text: 'Signage save failed!',
                        type: 'error',
                        html: true
                    });
                    $scope.store_form.store_error = data.errors;
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.removeStoreSignage = function(store_signage_id){
          sweetAlert({
            title: "Are you sure?",
            text: "Store Signage will be deleted?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, do it!",
            closeOnConfirm: true,
            html: true
        },
        function(){
            var information_post = {id: store_signage_id};

            $http.post(BASE_URL + '/storeSignage/delete', information_post)
            .success(function (data) {
                if (data.success) {
//                    swal(data.message, "", "success");
                    $scope.getStores({signage_id: $stateParams.id});
                }
                else {
                    swal({
                        title: 'Oop...',
                        text: data.message,
                        type: 'error',
                        html: true
                    });
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
  		    });
        }
        
        $scope.copyStore = function (store) {
//            $rootScope.view_detail_store_id = store.id;
//            $rootScope.is_copy_store = true;
//            $state.go('store-create');
            $http.post(BASE_URL + '/store/copy', {id: store.id})
            .success(function (data) {
                if (data.success) {
                    $state.go('store-detail', {id: data.id});
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export Signage PDF and Email
        $scope.exportPdfItemStore = function(store){
            $http.get(BASE_URL + '/store/exportPdf?id=' + store.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Store Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // Export Signage Excel and Email
        $scope.exportExcelItemStore = function(store){
            $http.get(BASE_URL + '/store/exportExcelItem?id=' + store.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Store Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.selectedStoreIds = [];
	$scope.toggleStoreSelection = function toggleStoreSelection(id) {
	    var idx = $scope.selectedStoreIds.indexOf(id);

	    if (idx > -1) {
	      $scope.selectedStoreIds.splice(idx, 1);
	    }
	    else {
	      $scope.selectedStoreIds.push(id);
	    }
	};
        
        $scope.exportExcelListStore = function(type){
            var search_information = 'tier_id=' + $('#search_store_final').attr('data-tier_id') 
                                    + '&name=' + $('#search_store_final').attr('data-name')
                                    + '&country=' + $('#search_store_final').attr('data-country')
                                    + '&signage_id=' + $stateParams.id
                                    + '&related_name='+$scope.signage.code;
            var post_information = "";
            $( "input[name^='ExportStoreExcelColumn']" ).each(function(i){
                var checkedValue = $(this).prop('checked') ? 1 : 0;
                post_information += encodeURIComponent("ExportExcelColumn[")+$(this).attr('data-column')+encodeURIComponent("]")+"="+checkedValue+"&";
            });
            post_information += search_information;
            if($scope.selectedStoreIds.length){
                post_information += "&ids="+$scope.selectedStoreIds.toString();
            }
            if(typeof type !== 'undefined'){
                post_information += "&type="+type;
            }
            $http.get(BASE_URL + '/store/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Related store DB exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });
                    
                    $('.sweet-alert .email').click(function(){
                        console.log('email')
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        $window.open(data.result.file_url);
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.getTiers = function () {
            $http.post(BASE_URL + '/tier/getAll', [])
            .success(function (data) {
                if (data.success) {
                    $scope.tiers = data.tiers;
                }
                else {
                    swal('Can not get tier list', '', 'error');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        $scope.getTiers();
        
        $scope.search_store = {
            signage_id: $stateParams.id,
            id: '',
            tier_id: '',
            name: '',
            country: '',
            limitstart: 0,
            limitnum: 10,
        };
        
        $scope.searchStore = function(){
            $scope.getStores($scope.search_store);
            $('#search_store_final').attr('data-tier_id', $scope.search_store.tier_id);
            $('#search_store_final').attr('data-name', $scope.search_store.name);
            $('#search_store_final').attr('data-country', $scope.search_store.country);
        };
        
        $scope.getStores = function (post_information) {
            $http.post(BASE_URL + '/store/getAll', post_information)
            .success(function (data) {
                if (data.success) {
                    $scope.getStorePagination(data);
                    $scope.signage.related_stores = data.stores;
                    $scope.selectedStoreIds = [];
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        // for fixture
        $scope.copyFixture = function (fixture) {
//            $rootScope.view_detail_fixture_id = fixture.id;
//            $rootScope.is_copy_fixture = true;
//            $state.go('fixture-create');
            $http.post(BASE_URL + '/fixture/copy', {id: fixture.id})
            .success(function (data) {
                if (data.success) {
                    $state.go('fixture-detail', {id: data.id});
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.exportPdfItemFixture = function(fixture){
            $http.get(BASE_URL + '/fixture/exportPdf?id=' + fixture.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Fixture Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        if(data.result){
                            $window.open(data.result.file_url);
                        }
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.exportExcelItemFixture = function(fixture){
            $http.get(BASE_URL + '/fixture/exportExcelItem?id=' + fixture.id)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Fixture Detail exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });

                    $('.sweet-alert .email').click(function(){
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        if(data.result){
                            $window.open(data.result.file_url);
                        }
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.selectedFixtureIds = [];
	$scope.toggleFixtureSelection = function toggleFixtureSelection(id) {
	    var idx = $scope.selectedFixtureIds.indexOf(id);

	    if (idx > -1) {
	      $scope.selectedFixtureIds.splice(idx, 1);
	    }
	    else {
	      $scope.selectedFixtureIds.push(id);
	    }
	};
        
        $scope.exportExcelListFixture = function(type){
            var post_information = "";
            $( "input[name^='ExportExcelFixtureColumn']" ).each(function(i){
                var checkedValue = $(this).prop('checked') ? 1 : 0;
                post_information += encodeURIComponent("ExportExcelColumn[")+$(this).attr('data-column')+encodeURIComponent("]")+"="+checkedValue+"&";
            });
            if($scope.selectedFixtureIds.length){
                post_information += "&ids="+$scope.selectedFixtureIds.toString();
            }
            else if($scope.signage.related_fixtures.length){
                var rfIds = [];
                angular.forEach($scope.signage.related_fixtures, function(v,i){
                    rfIds.push(v.id);
                });
                post_information += "&ids="+rfIds.toString();
            }
            post_information += "&related_name="+$scope.signage.code;
            if(typeof type !== 'undefined'){
                post_information += "&type="+type;
            }
            $http.get(BASE_URL + '/fixture/exportExcel?' + post_information)
            .success(function (data) {
                if (data.success) {
                    swal({
                        title: "Store's fixture DB exported",
                        text: "<button class='email bg-green'><i class='fa fa-envelope'></i> Email it</button> <button class='download bg-blue'><i class='fa fa-download'></i> Download it</button>",
                        type: "info",
                        showConfirmButton: false,
                        showCancelButton: true,
                        closeOnCancel: true,
                        html: true,
                    });
                    
                    $('.sweet-alert .email').click(function(){
                        console.log('email')
                        var file = {
                            'dirname': data.result.dirname,
                            'absolute_url': data.result.file_absolute_url,
                            'filename': data.result.file_name,
                            'extension': data.result.extension,
                        };
                        $scope.emailFile(file);
                        swal.close();
                    });

                    $('.sweet-alert .download').click(function(){
                        if(data.result){
                            $window.open(data.result.file_url);
                            swal.close();
                        }
                    }); 
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        };
        
        $scope.openCollapse = function(){
            var hash = window.location.hash.substr(1);
            if(hash && jQuery('#'+hash).length){
                var box = jQuery('#'+hash).find(".box").first();
                var bf = box.find(".box-body, .box-footer");
                box.find(".fa-plus").first().removeClass("fa-plus").addClass("fa-minus");
                bf.slideDown();
                return true;
            }
            return false;
        };
        
        $scope.delete = function () {
            sweetAlert({
                title: "Are you sure?",
                text: "You will not be able to recover it!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: true
            },
            function(){
                var information_post = {'id': $scope.signage.id};
                $http.post(BASE_URL + '/signage/delete', information_post)
                .success(function (data) {
                    if (data.success) {
                        swal(data.message, "", "success");
                        swal.close();
                        $state.go('signage-list');
                    }
                    else {
                        swal(data.message, "", "error");
                        swal.close();
                    }
                })
                .error(function (data, status, headers, config) {
                    $state.go('404');
                });     
            });
        };
        
        // pagination for Fixture
        $scope.fsPagination = {
            itemsByPage_change_number: 0,
            fsByPage: 10,
            start: 0,
            end: 0,
            totalresults: 0,
            pages: [],
            currentPage: 1,
            selectPage: null,
            getFixtures: null,
            getParams: {
                limitstart: 0,
                limitnum: 10,
                group_number: "",
                category_id: 0,
                code: "",
            },
            categories: [],
        };
        
        $scope.getFixturePagination = function(data){
            $scope.fsPagination.start = data.start_fixture;
            $scope.fsPagination.end = data.end_fixture;
            $scope.fsPagination.totalresults = data.totalresults;
            $scope.fsPagination.pages = [];
            for (var p = 0; p < Math.ceil(data.totalresults / $scope.fsPagination.fsByPage); p++)
                $scope.fsPagination.pages.push(p + 1);
        };
        
        $scope.$watch('fsPagination.fsByPage', function () {
            $scope.fsPagination.itemsByPage_change_number++;
            if ($scope.fsPagination.fsByPage == 0 || $scope.fsPagination.fsByPage == '0' || $scope.fsPagination.fsByPage == '' || $scope.fsPagination.fsByPage == null)
                $scope.fsPagination.fsByPage = 1;
            $scope.fsPagination.getParams.limitstart = 0;
            $scope.fsPagination.getParams.limitnum = $scope.fsPagination.fsByPage;
            if ($scope.fsPagination.itemsByPage_change_number > 1){
                $scope.fsPagination.currentPage = 1;
                $scope.fsPagination.getFixtures();
            }
        }, true);
        
        $scope.fsPagination.getFixtures = function(){
            $http.post(BASE_URL + '/fixture/getAll', $scope.fsPagination.getParams)
            .success(function (data) {
                if (data.success) {
                    $scope.getFixturePagination(data);
                    $scope.signage.related_fixtures = [];
                    $scope.signage.related_fixtures = data.fixtures;
                }
                else {
                    $state.go('404');
                }
            })
            .error(function (data, status, headers, config) {
                $state.go('404');
            });
        }
        
        $scope.fsPagination.selectPage = function(page){
            $scope.fsPagination.currentPage = page;
            $scope.fsPagination.getParams.limitstart = (parseInt(page) - 1) * parseInt($scope.fsPagination.fsByPage);
            $scope.fsPagination.getFixtures();
        };
        
        // pagination for Store
        $scope.storePagination = {
            itemsByPage_change_number: 0,
            fsByPage: 10,
            start: 0,
            end: 0,
            totalresults: 0,
            pages: [],
            currentPage: 1,
            selectPage: null,
        };
        
        $scope.getStorePagination = function(data){
            $scope.storePagination.start = data.start_store;
            $scope.storePagination.end = data.end_store;
            $scope.storePagination.totalresults = data.totalresults;
            $scope.storePagination.pages = [];
            for (var p = 0; p < Math.ceil(data.totalresults / $scope.storePagination.fsByPage); p++)
                $scope.storePagination.pages.push(p + 1);
        };
        
        $scope.$watch('storePagination.fsByPage', function () {
            $scope.storePagination.itemsByPage_change_number++;
            if ($scope.storePagination.fsByPage == 0 || $scope.storePagination.fsByPage == '0' || $scope.storePagination.fsByPage == '' || $scope.storePagination.fsByPage == null)
                $scope.storePagination.fsByPage = 1;
            $scope.search_store.limitstart = 0;
            $scope.search_store.limitnum = $scope.storePagination.fsByPage;
            if ($scope.storePagination.itemsByPage_change_number > 1){
                $scope.storePagination.currentPage = 1;
                $scope.searchStore();
            }
        }, true);
        
        $scope.storePagination.selectPage = function(page){
            $scope.storePagination.currentPage = page;
            $scope.search_store.limitstart = (parseInt(page) - 1) * parseInt($scope.storePagination.fsByPage);
            $scope.searchStore();
        };
    }
]);
