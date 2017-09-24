(function(e) {
    angular.module('app').directive('ckEditor', [function () {
        return {
            require: '?ngModel',
            scope:{ ckReadonly: "="},
            link: function ($scope, elm, attr, ngModel) {
                setTimeout(function(){
                    var ck = CKEDITOR.replace(elm[0], {
                        height: attr.height
                    }); 

                    if (!ngModel) return;

                    ck.on('pasteState', function () {
                        $scope.$apply(function () {
                            ngModel.$setViewValue(ck.getData());
                        });
                    });

                    ngModel.$render = function (value) {
                        ck.setData(ngModel.$modelValue);
                    };

                    ck.on( 'instanceReady', function( evt ) {
                        ck.setData(ngModel.$viewValue);
                        $scope.$watch('ckReadonly', function(newValue, oldValue) {
                            if(ck != undefined){
                                if(newValue == true){
                                    ck.setReadOnly(true);
                                }

                                if(newValue == false){
                                    ck.setReadOnly(false);
                                }                    
                            }
                        });
                    });

                    function updateModel() {
                        $scope.$apply(function() {
                            ngModel.$setViewValue(ck.getData());
                        });
                    }

                    ck.on('change', updateModel);
                    ck.on('key', updateModel);
                    ck.on('dataReady', updateModel);
                }, 1300);
            }
        };
    }]);
})(angular)