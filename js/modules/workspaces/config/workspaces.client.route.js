// Setting up route
angular.module('workspaces').config(['$routeProvider',
	function ($routeProvider) {
        var viewBase = window.base_dir + 'js/modules/workspaces/views/';

	    $routeProvider
            .when('/workspacelist', {
                controller: 'workspaceController',
                templateUrl: viewBase + 'workspaceListView.html',
                authorize: true
            })
            .when('/editworkspace/:workspacegid', {
                controller: 'workspaceController',
                templateUrl: viewBase + 'workspaceEditView.html',
                authorize: true
            })
            .when('/createworkspace', {
                controller: 'workspaceController',
                templateUrl: viewBase + 'workspaceCreateView.html',
                authorize: true
            });
	}
]);