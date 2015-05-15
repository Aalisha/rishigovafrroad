angular.module('calcdirectives')
.directive('ngcustomNumber', ['$compile', '$templateCache', function ($compile, $templateCache) {
    var TEMPLATE_URL = '/customnumber/index.html';
    var Template = '<div class="wrapper">' +
              '  <input type="text" data-ng-model="model.weight" data-ng-blur="onBlurHandler()">' +
              '  <button ng-click="Increase(model.weight)" style="cursor:pointer; background-color: transparent">INC</button>' +
              '  <button ng-click="Decrease(model.weight)" style="cursor:pointer; background-color: transparent">DEC</button>' +
              '</div>';

    // Set the default template for this directive
    $templateCache.put(TEMPLATE_URL, Template);

    return {
        restrict: "E",
        scope: {
            model: '=',
            onblurevent: '&'
        },
        replace: true,
        templateUrl: function (element, attrs) {
            return attrs.templateUrl || TEMPLATE_URL;
        },
        link: function (scope, element, attributes) {
            scope.onBlurHandler = function () {
                if (scope.onblurevent) {
                    scope.onblurevent();
                }
            };

            scope.Increase = function (value) {
                 value = parseInt(value);

                if (angular.isDefined(value) && !isNaN(value) && angular.isNumber(value)) {
                    scope.model.weight = parseInt(value) + 1;
                }
            };
            scope.Decrease = function (value) {
                 value = parseInt(value);

                if (angular.isDefined(value) && !isNaN(value) && angular.isNumber(value)) {
                    scope.model.weight = parseInt(value) - 1;
                }
            };
        }
    };
} ]);





