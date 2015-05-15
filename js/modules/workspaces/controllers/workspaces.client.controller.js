angular.module('workspaces')
       .controller('workspaceController', ['$scope', '$rootScope', '$window', '$routeParams', 'workspaceService', function ($scope, $rootScope, $window, $routeParams, workspaceService) {

           $scope.ShowHideError = false;
           $scope.workspace = {};
           $rootScope.workspace.workspacename = null;

           //Create workspace
           $scope.Create = function (workspace) {

               if ($scope.form.$valid) {
                   workspaceService.CreateWorkSpace(workspace).then(function (response) {
                       if (!angular.isUndefined(response.data.workspacegid)) {
                           workspace.workspacegid = response.data.workspacegid;

                           if (!angular.isUndefined($rootScope.workspaceslist) && $rootScope.workspaceslist != null) {
                               $rootScope.workspaceslist.workspaces.push(workspace);
                           }
                           $window.location.href = "#/workspacelist";
                       }
                       else {
                           $scope.ShowHideError = true;
                       }
                   });
               }
           };

           //Edit Workspace

           $scope.EditWorkspaces = function () {
               //Get Workspace by workspace gid for Edit view.
               if (!angular.isUndefined($routeParams.workspacegid)) {
                   workspaceService.GetWorkSpaceByGID($routeParams.workspacegid).then(function (response) {
                       if (!angular.isUndefined(response.data.workspacegid)) {
                           $scope.workspace = response.data;
                       }
                       else {
                           $scope.ShowHideError = true;
                       }
                   });
               };
           };


           //Save workspace edit form.
           $scope.Edit = function (workspace) {

               if ($scope.form.$valid) {
                   workspaceService.EditWorkSpace(workspace).then(function (response) {
                       if (!angular.isUndefined(response.data.workspacegid)) {

                           for (var wspace = $scope.$parent.workspaceslist.workspaces.length - 1; wspace >= 0; wspace--) {
                               if ($scope.$parent.workspaceslist.workspaces[wspace].workspacegid == response.data.workspacegid) {
                                   $scope.$parent.workspaceslist.workspaces[wspace] = workspace;
                               }
                           }

                           $window.location.href = "#/workspacelist";
                       }
                       else {
                           $scope.ShowHideError = true;
                       }
                   });
               }
           };


           //Delete
           $scope.Delete = function (workspace) {

               $("#dialog-confirm").removeClass('hidden');

               $("#dialog-confirm").dialog({
                   resizable: false,
                   height: 200,
                   modal: true,
                   buttons: {
                       Cancel: function () {
                           $("#dialog-confirm").addClass('hidden');
                           $(this).dialog("close");
                       },

                       Delete: function () {
                           workspaceService.DeleteWorkSpace(workspace.workspacegid).then(function (response) {
                               if (response.data) {
                                   var index = $scope.$parent.workspaceslist.workspaces.indexOf(workspace)
                                   $scope.$parent.workspaceslist.workspaces.splice(index, 1);
                               }
                               else {
                                   $scope.ShowHideError = true;
                               }
                           });

                           $("#dialog-confirm").addClass('hidden');
                           $(this).dialog("close");
                       }
                   }
               });
           };
       } ]);


