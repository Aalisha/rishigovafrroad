angular.module('workspaces')
       .service('workspaceService', ['$http', '$q', '$location', function ($http, $q, $location) {
           var serviceBase = window.base_dir + 'Service/query/';

           return {

               GetAllWorkSpaces: function () {
                   var req = {
                       method: 'POST',
                       url: serviceBase + '101',
                       ignoreLoadingBar: true,
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       return data;
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.

                  });
               },

               CreateWorkSpace: function (workspace) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + '102',
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                       data: $.param(workspace)
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       return data;
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.
                  });
               },

               //Save edited workspace.
               EditWorkSpace: function (workspace) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + '104',
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                       data: $.param(workspace)
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       return data;
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.
                  });
               },

               //Get workspace by GID.
               GetWorkSpaceByGID: function (workspacegid) {
                   var req = {
                       method: 'GET',
                       url: serviceBase + '103?workspacegid=' + workspacegid,
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       return data;
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.
                  });
               },

               DeleteWorkSpace: function (workspacegid) {
                   var req = {
                       method: 'GET',
                       url: serviceBase + '105?workspacegid=' + workspacegid,
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       return data;
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.
                  });
               }
           }
       } ]);