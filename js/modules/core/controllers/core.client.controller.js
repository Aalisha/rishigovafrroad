angular.module('core').controller('ApplicationController', 
         ['$scope', '$rootScope', 'workspaceService', function ($scope, $rootScope, workspaceService) {

    $rootScope.workspace = {};
    $rootScope.workspace.workspacename = null;
    $rootScope.workspace.workspacegid = null;

    workspaceService.GetAllWorkSpaces().then(function (response) {
        if (!angular.isUndefined(response.data) && !angular.isUndefined(response.data.workspaces) && response.data.workspaces.length > 0) {
            $rootScope.workspaceslist = response.data;
        }
        else {
            $rootScope.workspaceslist = {};
            $rootScope.workspaceslist = { workspaces: [] };
        }
    });

}]);
