angular.module('app').directive('loading', ['$http' ,function ($http)
    {
        return {
            restrict: 'E',
            link: function (scope, elm, attrs)
            {
                scope.isLoading = function(){
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (v)
                {
                    var t;
                    if(v){
                        t = setTimeout(function(){
                            if(scope.isLoading()){
                                $('#loadingModal').show();
                            }
                            clearTimeout(t);
                        }, 500);
                    }else{
                        $('#loadingModal').hide();
                        clearTimeout(t);
                    }
                });
            }
        };

    }]);