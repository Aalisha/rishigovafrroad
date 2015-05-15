angular.module('formulas')
       .service('formulaService', ['$http', '$q', '$location', '$filter', function ($http, $q, $location, $filter) {
           var serviceBase = window.base_dir + 'Service/query/';


           return {

               CreateFormula: function (workspacegid) {
                   var req = {
                       method: 'GET',
                       url: serviceBase + '106?workspacegid=' + workspacegid,
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

               GetFormula: function (formula_gid) {
                   var req = {
                       method: 'GET',
                       url: serviceBase + '108?formula_gid=' + formula_gid,
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

               SaveFormula: function (formula) {

                   var req = {
                       method: 'POST',
                       url: serviceBase + '107',
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

               SaveSourceFormula: function (formula) {

                   var req = {
                       method: 'POST',
                       url: serviceBase + '115?formula_gid=' + formula.formula_gid,
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

               GetAllFormulas: function (workspacegid) {
                   var req = {
                       method: 'GET',
                       url: serviceBase + '109?workspacegid=' + workspacegid,
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

               DeleteFormula: function (formula_gid) {
                   var req = {
                       method: 'GET',
                       url: serviceBase + '110?formula_gid=' + formula_gid,
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

               //Test Connection
               TestConnection: function (formula) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + '113?formula_gid=' + formula.formula_gid,
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

               //Save Connection
               SaveConnection: function (formula) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + '111?formula_gid=' + formula.formula_gid,
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

               //Get Indicator List for the given formula gid and database ID.
               IndicatorsList: function (formula_gid, databaseid) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + '112?formula_gid=' + formula_gid + '&databaseid=' + databaseid,
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

               //Get Indicator List for the given formula gid and database ID.
               SubGroupList: function (Indicator, databaseid, IsSourceIndicator, formula_gid) {
                   var req = {
                       method: 'POST',
                       url: serviceBase + '114?Indicator_GId=' + Indicator.Ind_GID + '&Unit_GId=' + Indicator.Unit_GID + '&databaseid=' + databaseid + '&IsSourceIndicator=' + IsSourceIndicator + '&formula_gid=' + formula_gid,
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

               CreateIndicatorSubGroupTree: function (Indicatorlist) {
                   var deferred = $q.defer();
                   var result = [], ArrayIndicators = [];

                   angular.forEach(Indicatorlist, function (value, key) {
                       var found = $filter('filter')(ArrayIndicators, { id: (value.Ind_GID + '{~}' + value.Unit_GID) }, true);

                       if (!found.length) {
                           var Subgroup = [];

                           var Indicators = $filter('filter')(Indicatorlist, { Ind_GID: value.Ind_GID, Unit_GID: value.Unit_GID }, true);

                           ArrayIndicators.push({ id: (value.Ind_GID + '{~}' + value.Unit_GID) });

                           angular.forEach(Indicators, function (value, key) {
                               Subgroup.push({ src_subgroup: value.src_subgroup, id: value.id, src_ius_symbol: value.src_ius_symbol, weight: value.weight, normalization: value.normalization, high_is_good: value.high_is_good });
                           });

                           result.push({ id: value.id, subgroup: Subgroup, src_indicator: value.src_indicator, src_unit: value.src_unit, src_iu_symbol: value.src_iu_symbol });
                       }
                   });
                   deferred.resolve(result);

                   return deferred.promise;
               }

               
           }
       } ]);