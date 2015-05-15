angular.module('core')
       .service('globalconfigService', ['$http', '$q', '$location', function ($http, $q, $location) {
           var serviceBase = window.base_dir + 'Service/equery/';

           return {

               getKeyValue: function (key) {
                   var req = {
                       method: 'GET',
                       ignoreLoadingBar: true,
                       url: serviceBase + '100?ckey=' + key,
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
                      return false;
                  });
               }
           }
       } ]);