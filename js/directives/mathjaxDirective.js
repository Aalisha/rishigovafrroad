angular.module('mathjaxdirectives')
.directive('mathjaxBind', [function () {
    return {
        restrict: "A",
        controller: ["$scope", "$element", "$attrs", function ($scope, $element, $attrs) {
            $scope.$watch($attrs.mathjaxBind, function (value) {
                var $script = angular.element("<script type='math/asciimath'>").html(value == undefined ? "" : value);
                $element.html('');
                $element.append($script);
                MathJax.Hub.Config({
                    asciimath2jax: {
                        delimiters: [['`', '`'], ['$', '$']]
                    },
                    menuSettings: { menuSettings: "None" }
                });
                MathJax.Hub.Queue(["Reprocess", MathJax.Hub, $element[0]]);
            });
        } ]
    };
} ]);



