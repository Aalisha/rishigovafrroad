angular.module('calcdirectives')
.directive('popOver', [function () {
    return {
        restrict: "A",
        scope: {
            popOver: '@'
        },
        link: function (scope, element, attributes) {

            element.on('mouseenter', function (e) {
                element.tooltipster({
                    content: $('<span>'+scope.popOver+'</span>'),
                    contentAsHTML: true,
                    interactive: true,
                    maxWidth:300,
                    theme: 'tooltipster-light'
                });
                element.tooltipster('show');
            });

            element.on('mouseleave', function (e) {
                element.tooltipster('hide');
            });
        }
    };
} ]);



var CEDirectives = angular.module('calcdirectives')
.directive('popupOver', ['$compile', function ($compile) {
    return {
        restrict: "A",
        scope: {
            popupOver: '='
        },
        link: function (scope, element, attributes) {

            var LI = "";
            angular.forEach(scope.popupOver, function (value, key) {
                LI +=  "<li>" + value.src_indicator + ", " + value.src_unit + ", " + value.src_subgroup + "</li>";
            });
            var html = "<ul>" + LI + "</ul>";

            element.on('mouseenter', function (e) {
                element.tooltipster({
                    content: $('<span>' + html + '</span>'),
                    contentAsHTML: true,
                    interactive: true,
                    maxWidth: 300,
                    theme: 'tooltipster-light'
                });
                element.tooltipster('show');
            });

            element.on('mouseleave', function (e) {
                element.tooltipster('hide');
            });
        }
    };
} ]);

var CEDirectives = angular.module('calcdirectives')
.directive('popOversrc', ['$compile', function ($compile) {
    return {
        restrict: "A",
        scope: {
            popOversrc: '='
        },
        link: function (scope, element, attributes) {

            var LI = "";
            var value = scope.popOversrc;
            
            var Unit = " ";
            angular.forEach(value.SubGroup, function (value, key) {
                Unit += "<span>" + value.src_subgroup + "</span><br>";
            });
            LI = "<span>" + value.src_indicator + ", " + value.src_unit + "</span> <div class='subgroup-list'>" + Unit + "</div>";
            var html = "<ul>" + LI + "</ul>";

            element.on('mouseenter', function (e) {
                element.tooltipster({
                    content: $('<span>' + html + '</span>'),
                    contentAsHTML: true,
                    interactive: true,
                    maxWidth: 300,
                    theme: 'tooltipster-light'
                });
                element.tooltipster('show');
            });

            element.on('mouseleave', function (e) {
                element.tooltipster('hide');
            });
        }
    };
} ]);




