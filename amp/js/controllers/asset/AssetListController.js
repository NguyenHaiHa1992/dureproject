angular.module('app').controller('AssetListController', ['$scope', '$timeout', '$http', '$location', '$rootScope', 'BASE_URL', '$state',
    function ($scope, $timeout, $http, $location, $rootScope, BASE_URL, $state) {
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
                'category_id': $scope.search_asset.category_id,
                'code': $scope.search_asset.code,
                'description': $scope.search_asset.description,
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
                'category_id': $scope.search_asset.category_id,
                'code': $scope.search_asset.code,
                'description': $scope.search_asset.description,
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
                'category_id': $scope.search_asset.category_id,
                'code': $scope.search_asset.code,
                'description': $scope.search_asset.description,
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
                'category_id': $scope.search_asset.category_id,
                'code': $scope.search_asset.code,
                'description': $scope.search_asset.description,
                'created': $scope.search_asset.created,
            };
            $scope.getAssets(post_information);
        };

        $scope.search = function () {
            post_information.category_id = $scope.search_asset.category_id;
            post_information.code = $scope.search_asset.code;
            post_information.description = $scope.search_asset.description;

            $scope.getAssets(post_information);
        }
    }
]);
