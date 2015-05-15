angular.module('core')
       .service('authService', ['$cookieStore', '$http', '$q', '$location', 'sessionService', function ($cookieStore, $http, $q, $location, sessionService) {
           var serviceBase = window.base_dir + 'users/';

           return {

               //Login user with provided credentials
               login: function (user) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + 'login',
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                       data: $.param(user)
                   }

                   return $http(req).success(function (response, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       if (response.authenticated) {
                           sessionService.create(response, user.pwd);
                           return response;
                       }
                   }).
                  error(function (response, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.
                  });
               },

               //Recover password
               forgotpassword: function (user) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + 'forgotpassword',
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                       data: $.param(user)
                   }

                   return $http(req).success(function (response, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       return response;
                   }).
                  error(function (response, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.
                  });
               },

               IsLoggedIn: function () {

                   var users = $cookieStore.get('globals');

                   if (!angular.isUndefined(users) && !angular.isUndefined(users.currentUser)) {

                       var req = {
                           method: 'GET',
                           url: serviceBase + 'IsLoggedIn/' + users.currentUser.email,
                           headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                           data: $.param(users)
                       }

                       return $http(req).success(function (response, status, headers, config) {
                           // this callback will be called asynchronously
                           // when the response is available
                           return response.success;
                       }).
                      error(function (response, status, headers, config) {
                          // called asynchronously if an error occurs
                          // or server returns response with an error status.
                          var response = {};
                          response.success = false;
                          return response.success;
                      });
                   }
                   else {
                       var response = {};
                       response.success = false;

                       return response.success;
                   }
               }
           }
       } ]);