// Setting up route
angular.module('formulas').config(['$routeProvider',
	function ($routeProvider) {
	    var viewBase = window.base_dir + '/js/modules/formulas/views/';

	    $routeProvider
            .when('/my-formula/:workspacegid', {
                controller: 'formulaController',
                templateUrl: viewBase + 'formulaListView.html',
                authorize: true
            })
            .when('/formulasettings/:formulagid/:FormulaCreation?', {
                controller: 'formulaController',
                templateUrl: viewBase + 'formulaSettingView.html',
                authorize: true
            })
            .when('/saveformula/:formulagid', {
                controller: 'formulaController',
                templateUrl: viewBase + 'formulaSaveView.html',
                authorize: true
            })
            .when('/formulaIndicators/:formulagid', {
                controller: 'formulaController',
                templateUrl: viewBase + 'formulaIndicatorsView.html',
                authorize: true
            })
            .when('/formulaExecution/:formulagid/:executiongid?', {
                controller: 'executionController',
                templateUrl: viewBase + 'executeFormulaView.html',
                authorize: true
            })
            .when('/schedule-formula/:executiongid', {
                controller: 'executionController',
                templateUrl: viewBase + 'scheduleFormulaView.html',
                authorize: true
            })
            .when('/global-schedular/:workspacegid', {
                controller: 'executionController',
                templateUrl: viewBase + 'globalSchedularView.html',
                authorize: true
            });
	}
]);