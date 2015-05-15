angular.module('calcdirectives')
.directive('compareTo', [function () {
    var definition = {
        require: "ngModel",
        scope: {
            otherModelValue: "=compareTo"
        },
        link: function (scope, element, attributes, ngModel) {

            ngModel.$validators.compareTo = function (modelValue) {
                if (modelValue == scope.otherModelValue) {
                    return true;
                }
                else {
                    return false;
                }
            };

            scope.$watch('otherModelValue', function () {
                ngModel.$validate();
            });
        }
    };

    return definition;
} ]);



