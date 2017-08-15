angular.module('app').controller('SettingController', ['$scope', '$timeout', '$http', '$location', '$rootScope','BASE_URL', '$state', '$cookies',
function($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state, $cookies){

	// Setting File category
	$scope.getFileCategories= function(){
		$http.post(BASE_URL + '/fileCategory/getAll', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.file_categories = data.file_categories;
		    }
		    else{
		    	$state.go('404');
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	};
	$scope.getFileCategories();


	// Edit File categories
	$scope.editFileCategory = function(category){
		category.is_edit = true;
	};

	$scope.removeFileCategory = function(category, index){
		if(category.id == undefined){
			$scope.file_categories.splice(index, 1);
		}
		else{
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
				var information_post = category;
				$http.post(BASE_URL + '/fileCategory/removeFileCategory', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.file_categories.splice(index, 1);
		                category.is_edit = false;
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
	};

	$scope.saveFileCategory = function(category){
		var information_post= category;
		$http.post(BASE_URL + '/fileCategory/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	category.is_edit = false;
               	category.id = data.id;
		    	swal(data.message, "", "success");
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
	};

	$scope.addFileCategory = function(){
		$scope.file_categories.push({
			name : '',
			status: 1,
			is_edit: true,
    	});
	};

	/************ Setting Tier in unit ***********/

	$scope.getTiers = function(){
		$http.post(BASE_URL + '/tier/getAll', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.tiers = data.tiers;
		    }
		    else{
		    	$state.go('404');
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	};
	$scope.getTiers();

	// Edit Tier
	$scope.editTier = function(tier){
		tier.is_edit = true;
	};

	$scope.removeTier = function(tier, index){
		if(tier.id == undefined){
			$scope.tiers.splice(index, 1);
		}
		else{
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
				var information_post = tier;
				$http.post(BASE_URL + '/tier/removeTier', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.tiers.splice(index, 1);
		                tier.is_edit = false;
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
	};

	$scope.saveTier = function(tier){
		var information_post= tier;
		$http.post(BASE_URL + '/tier/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	tier.is_edit = false;
               	tier.id = data.id;
		    	swal(data.message, "", "success");
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
	};

	$scope.addTier = function(){
		$scope.tiers.push({
			name : '',
			status: 1,
			is_edit: true,
    	});
	};

	/************** Setting Fixture category **************/
	$scope.getFixtureCategories= function(){
		$http.post(BASE_URL + '/fixtureCategory/getAll', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.fixture_categories = data.fixture_categories;
		    }
		    else{
		    	$state.go('404');
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	};
	$scope.getFixtureCategories();

	// Edit Fixture categories
	$scope.editFixtureCategory = function(category){
		category.is_edit = true;
	};

	$scope.removeFixtureCategory = function (category, index) {
            if (category.id == undefined) {
                $scope.fixture_categories.splice(index, 1);
            } else {
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
                        function () {
                            var information_post = category;
                            $http.post(BASE_URL + '/fixtureCategory/removeFixtureCategory', information_post)
                                    .success(function (data) {
                                        if (data.success) {
                                            swal(data.message, "", "success");
                                            $scope.fixture_categories.splice(index, 1);
                                            category.is_edit = false;
                                        } else {
                                            swal({
                                                title: '',
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
        };
        
        $scope.removeGeneralCategory = function (category, index, type) {
            if (category.id == undefined) {
                if(type === "fixture"){
                    $scope.fixture_general_categories.splice(index, 1);
                }
                else{
                    $scope.signage_general_categories.splice(index, 1);
                }
            } else {
                var hasSpecific = checkHasSpecific(type, category);
                if(hasSpecific){
                    swal({
                        title: '',
                        text: "This general category has some specific categories!",
                        type: 'error',
                        html: true
                    });
                }
                else{
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
                    function () {
                        if(type === "fixture"){
                            var url = '/fixtureCatGen/removeCategory';
                        }
                        else{
                            var url = '/signageCatGen/removeCategory';
                        }
                        var information_post = category;
                        $http.post(BASE_URL + url, information_post)
                            .success(function (data) {
                                if (data.success) {
                                    swal(data.message, "", "success");
                                    if(type === "fixture"){
                                        $scope.fixture_general_categories.splice(index, 1);
                                    }
                                    else{
                                        $scope.signage_general_categories.splice(index, 1);
                                    }
                                    category.is_edit = false;
                                } else {
                                    swal({
                                        title: '',
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
            }
        };

	$scope.saveFixtureCategory = function(category){
            var information_post= category;
            $http.post(BASE_URL + '/fixtureCategory/update', information_post)
	    .success(function(data) {
                if(data.success) {
                    category.is_edit = false;
                    category.id = data.id;
                    category.general_name = data.fixture_category.general_name;
                    swal(data.message, "", "success");
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
	};
        
        function updateCategoryGeneral(type, general){
            if(type === "fixture"){
                angular.forEach($scope.fixture_categories, function(value, i) {
                    if($scope.fixture_categories[i]['general_id'] === general.id){
                        $scope.fixture_categories[i]['general_name'] = general.name;
                    }
                });
            }
            else if(type === "signage"){
                angular.forEach($scope.signage_categories, function(value, i) {
                    if($scope.signage_categories[i]['general_id'] === general.id){
                        $scope.signage_categories[i]['general_name'] = general.name;
                    }
                });
            }
        }
        
        function checkHasSpecific(type, general){
            var result = false;
            if(type === "fixture"){
                angular.forEach($scope.fixture_categories, function(value, i) {
                    if($scope.fixture_categories[i]['general_id'] === general.id){
                        result = true;
                    }
                });
            }
            else if(type === "signage"){
                angular.forEach($scope.signage_categories, function(value, i) {
                    if($scope.signage_categories[i]['general_id'] === general.id){
                        result = true;
                    }
                });
            }
            return result;
        }
        
        $scope.saveFixtureGeneralCategory = function(category){
            var information_post= category;
            $http.post(BASE_URL + '/fixtureCatGen/update', information_post)
	    .success(function(data) {
                if(data.success) {
                    category.is_edit = false;
                    category.id = data.id;
                    updateCategoryGeneral("fixture", category);
                    swal(data.message, "", "success");
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
	};
        
        $scope.saveSignageGeneralCategory = function(category){
            var information_post= category;
            $http.post(BASE_URL + '/signageCatGen/update', information_post)
	    .success(function(data) {
                if(data.success) {
                    category.is_edit = false;
                    category.id = data.id;
                    updateCategoryGeneral("signage", category);
                    swal(data.message, "", "success");
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
	};

	$scope.addFixtureCategory = function(){
            $scope.fixture_categories.push({
                name : '',
                status: 1,
                general_id: 1,
                general_name: "",
                is_edit: true,
            });
	};
        
        $scope.addFixtureGeneralCategory = function(){
            $scope.fixture_general_categories.push({
                name : '',
                status: 1,
                is_edit: true,
            });
	};
        
        $scope.addSignageGeneralCategory = function(){
            $scope.signage_general_categories.push({
                name : '',
                status: 1,
                is_edit: true,
            });
	};
        
        $scope.getFixtureGeneralCategories= function(){
            $http.post(BASE_URL + '/fixtureCatGen/getAll', {})
	    .success(function(data) {
                if(data.success) {
                    $scope.fixture_general_categories = data.categories;
                }
                else{
                    $state.go('404');
                }
            })
            .error(function(data, status, headers, config) {
            $state.go('404');
            });
	};
	$scope.getFixtureGeneralCategories();

	/************** Setting Signage category **************/
	$scope.getSignageCategories= function(){
		$http.post(BASE_URL + '/signageCategory/getAll', {})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.signage_categories = data.signage_categories;
                    }
		    else{
		    	$state.go('404');
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	};
	$scope.getSignageCategories();

	// Edit Signage categories
	$scope.editSignageCategory = function(category){
		category.is_edit = true;
	};

	$scope.removeSignageCategory = function(category, index){
		if(category.id == undefined){
			$scope.signage_categories.splice(index, 1);
		}
		else{
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
				var information_post = category;
				$http.post(BASE_URL + '/signageCategory/removeSignageCategory', information_post)
			    .success(function(data) {
				    if(data.success) {
				    	swal(data.message, "", "success");
		                $scope.signage_categories.splice(index, 1);
		                category.is_edit = false;
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
	};

	$scope.saveSignageCategory = function(category){
		var information_post= category;
		$http.post(BASE_URL + '/signageCategory/update', information_post)
	    .success(function(data) {
		    if(data.success) {
               	category.is_edit = false;
               	category.id = data.id;
                category.general_name = data.signage_category.general_name;
		    	swal(data.message, "", "success");
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
	};

	$scope.addSignageCategory = function(){
		$scope.signage_categories.push({
			name : '',
			status: 1,
                        general_id: 1,
                        general_name: "",
			is_edit: true,
    	});
	};
        
        $scope.getSignageGeneralCategories= function(){
            $http.post(BASE_URL + '/signageCatGen/getAll', {})
	    .success(function(data) {
                if(data.success) {
                    $scope.signage_general_categories = data.categories;
                }
                else{
                    $state.go('404');
                }
            })
            .error(function(data, status, headers, config) {
            $state.go('404');
            });
	};
	$scope.getSignageGeneralCategories();

	// Other settings
	$scope.tax = {};
	$scope.getTax = function(){
		$http.post(BASE_URL + '/setting/get', {name: 'TAX'})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.tax = data.value;
		    }
		    else{
		    	$state.go('404');
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	};
	$scope.getTax();

	$scope.setTax = function(){
		$http.post(BASE_URL + '/setting/set', {name: 'TAX', value: $scope.tax})
	    .success(function(data) {
		    if(data.success) {
		    	$('#Setting_tax').removeClass('ng-dirty');
		    	swal({
		    		title: 'Success',
		    		text: data.message,
		    		type: 'success',
		    		html: true
		    	});
		    }
		    else{
		    	swal({
		    		title: 'Error',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	}

	$scope.system_email = {};
	$scope.getSystemEmail = function(){
		$http.post(BASE_URL + '/setting/get', {name: 'SYSTEM_EMAIL'})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.system_email = data.value;
		    }
		    else{
		    	$state.go('404');
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	};
	$scope.getSystemEmail();

	$scope.setSystemEmail = function(){
		$http.post(BASE_URL + '/setting/set', {name: 'SYSTEM_EMAIL', value: $scope.system_email})
	    .success(function(data) {
		    if(data.success) {
		    	$('#Setting_system_email').removeClass('ng-dirty');
		    	swal({
		    		title: 'Success',
		    		text: data.message,
		    		type: 'success',
		    		html: true
		    	});
		    }
		    else{
		    	swal({
		    		title: 'Error',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	}

	$scope.system_email_cc = {};
	$scope.getSystemEmailCc = function(){
		$http.post(BASE_URL + '/setting/get', {name: 'SYSTEM_EMAIL_CC'})
	    .success(function(data) {
		    if(data.success) {
		    	$scope.system_email_cc = data.value;
		    }
		    else{
		    	$state.go('404');
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	};
	$scope.getSystemEmailCc();

	$scope.setSystemEmailCc = function(){
		$http.post(BASE_URL + '/setting/set', {name: 'SYSTEM_EMAIL_CC', value: $scope.system_email_cc})
	    .success(function(data) {
		    if(data.success) {
		    	$('#Setting_system_email_cc').removeClass('ng-dirty');
		    	swal({
		    		title: 'Success',
		    		text: data.message,
		    		type: 'success',
		    		html: true
		    	});
		    }
		    else{
		    	swal({
		    		title: 'Error',
		    		text: data.message,
		    		type: 'error',
		    		html: true
		    	});
		    }
		})
		.error(function(data, status, headers, config) {
    		$state.go('404');
  		});
	}

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
}]);
