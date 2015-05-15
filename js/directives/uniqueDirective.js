angular.module('calcdirectives')
.directive('wcUnique', ['$q', 'userService', function ($q, userService) {

    var link = function (scope, element, attrs, ngModel) {
        ngModel.$asyncValidators.unique = function (modelValue, viewValue) {

            var deferred = $q.defer(),
                currentValue = modelValue || viewValue,
                property = attrs.wcUniqueProperty;

            if (property) {
                userService.checkUniqueValue(property, currentValue)
                        .then(function (unique) {
                            if (unique) {
                                deferred.resolve(); //It's unique
                            }
                            else {
                                deferred.reject(); //Add unique to $errors
                            }
                        }); 

                return deferred.promise;
            }
            else {
                return $q.when(true);
            }
        };
    };

    return {
        restrict: 'A',
        require: 'ngModel',
        link: link
    };
} ]);


