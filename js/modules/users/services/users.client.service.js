angular.module('users')
       .service('userService', ['$http', '$q', '$location', function ($http, $q, $location) {
           var serviceBase = window.base_dir + 'users/';

           return {

               checkUniqueValue: function (property, value) {

                   return $http.get(serviceBase + 'userExists/' + property + '/' + escape(value)).then(
                            function (results) {
                                return  $.parseJSON(results.data);
                            });
               },

               adduser: function (user) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + 'addUser',
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                       data: $.param(user)
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