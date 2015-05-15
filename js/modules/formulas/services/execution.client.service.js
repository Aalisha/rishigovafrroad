angular.module('formulas')
       .service('executionService', ['$http', '$q', '$location', '$filter', function ($http, $q, $location, $filter) {
           var serviceBase = window.base_dir + 'Service/query/';

           return {
               GetAreaList: function (formula_gid, areaLevel, parentAreaNID, numberOfLevels) {
                   var deferred = $q.defer();

                   var req = {
                       method: 'POST',
                       url: serviceBase + '116?formula_gid=' + formula_gid + '&areaLevel=' + areaLevel + '&parentAreaNID=' + parentAreaNID + '&numberOfLevels=' + numberOfLevels,
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       deferred.resolve(data);
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.

                  });
                   return deferred.promise;
               },

               SaveArea: function (formula) {

                   var req = {
                       method: 'POST',
                       url: serviceBase + '118',
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                       data: $.param(formula)
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

               GetTimePeriods: function (formula_gid) {
                   var deferred = $q.defer();

                   var req = {
                       method: 'POST',
                       url: serviceBase + '117?formula_gid=' + formula_gid,
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       deferred.resolve(data);
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.

                  });
                   return deferred.promise;
               },

               ExecuteFormula: function (key) {
                   return $http.get(serviceBase + '100?ckey=' + key).then(function (response) {
                       return true;
                   });
               },

               GetExecution: function (executiongid) {
                   var deferred = $q.defer();

                   var req = {
                       method: 'GET',
                       url: serviceBase + '119?execution_gid=' + executiongid,
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       deferred.resolve(data);
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.

                  });
                   return deferred.promise;
               },

               DeleteExecution: function (executiongid) {
                   var deferred = $q.defer();

                   var req = {
                       method: 'GET',
                       url: serviceBase + '120?execution_gid=' + executiongid,
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       deferred.resolve(data);
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.

                  });
                   return deferred.promise;
               },

               GetGlobalSchedular: function (workspacegid) {
                   var deferred = $q.defer();

                   var req = {
                       method: 'GET',
                       url: serviceBase + '121?workspacegid=' + workspacegid,
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       deferred.resolve(data);
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.

                  });
                   return deferred.promise;
               },

               GlobalScheduleAction: function (globalScheduler) {
                   var deferred = $q.defer();

                   var req = {
                       method: 'POST',
                       url: serviceBase + '122',
                       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                       data: $.param(globalScheduler)
                   }

                   return $http(req).success(function (data, status, headers, config) {
                       // this callback will be called asynchronously
                       // when the response is available
                       deferred.resolve(data);
                   }).
                  error(function (data, status, headers, config) {
                      // called asynchronously if an error occurs
                      // or server returns response with an error status.

                  });
                   return deferred.promise;
               }
           };
       } ]);