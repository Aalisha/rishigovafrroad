angular.module('formulas')
       .controller('executionController', ['$scope', '$rootScope', '$window', '$location', '$routeParams', '$filter', '$route', '$q', 'formulaService', 'executionService', function ($scope, $rootScope, $window, $location, $routeParams, $filter, $route, $q, formulaService, executionService) {

           $scope.frmexecute = {};

           //Load Executuion for the given formula gid in the workspace
           $scope.LoadExecution = function () {
               if (!angular.isUndefined($routeParams.formulagid)) {
                   formulaService.GetFormula($routeParams.formulagid)
                      .then(function (response) {

                          if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                              if (!angular.isUndefined(response.data) && !angular.isUndefined(response.data.formula)) {
                                  $scope.formula = response.data.formula;

                                  $scope.formuladesc = response.data.formula.formula_type;
                                  $rootScope.workspace.workspacename = response.data.formula.workspacename;
                                  $rootScope.workspace.workspacegid = response.data.formula.workspacegid;
                                  $scope.workspacegid = response.data.formula.workspacegid;
                                  $rootScope.App.Tittle = " - " + response.data.formula.workspacename;


                                  if (angular.isUndefined($scope.frmexecute.timeperiod_type)) {
                                      //Most recent data by default.
                                      $scope.frmexecute.timeperiod_type = 'MRD';
                                  }
                              }
                          }
                          else {
                              $window.location.href = window.base_dir + "#/?loggedout=true";
                          }
                      }).then(function (response) {
                          executionService.GetTimePeriods($scope.formula.formula_gid).then(function (res) {
                              $scope.formula.TimePeriods = res.data.tps;
                          });

                          executionService.GetAreaList($scope.formula.formula_gid, '', -1, 2).then(function (res) {
                              $scope.formula.Areas = res.data.areas;
                              $scope.formula.Levels = res.data.levels;
                          });

                          if (!angular.isUndefined($routeParams.executiongid)) {
                              executionService.GetExecution($routeParams.executiongid).then(function (res) {
                                  $scope.frmexecute = res.data.MFormulaExecutionPlan;
                              });
                          }
                      });
               }
           };

           //Save the Execute Formula
           $scope.SaveExecuteFormula = function (IsSchedule) {

               $scope.frmexecute.IsSchedule = IsSchedule;
               $scope.frmexecute.formula_gid = $scope.formula.formula_gid;
               $scope.frmexecute.workspacegid = $scope.formula.workspacegid;
               $scope.frmexecute.IsReexecute = false;

               var IsValid = true, message = null;

               if (!$scope.frmexecute.area_selected) {
                   IsValid = false;
                   message = 'Please select the area.';
               }
               else if (!$scope.frmexecute.time_periods && $scope.frmexecute.timeperiod_type == 'MTP') {
                   IsValid = false;
                   message = 'Please select the time periods.';
               }

               if (IsValid) {
                   executionService.SaveArea($scope.frmexecute).then(function (response) {

                       if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                           if ($.parseJSON(response.data.success)) {

                               if (IsSchedule) {
                                   $rootScope.ShowAlert('Execution scheduled successfully');
                               }
                               else {
                                   $rootScope.ShowAlert('Formula executed successfully');
                               }

                               $scope.frmexecute.execution_gid = response.data.execution_gid;
                               $scope.frmexecute.logurl = response.data.logurl;
                           }
                       }
                       else {
                           $window.location.href = window.base_dir + "#/?loggedout=true";
                       }
                   });
               }
               else {
                   $rootScope.ShowAlert(message);
               }
           };

           $scope.GetGlobalSchedular = function () {

               if (!angular.isUndefined($routeParams.workspacegid)) {

                   executionService.GetGlobalSchedular($routeParams.workspacegid).then(function (response) {

                       if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                           if ($.parseJSON(response.data.success)) {

                               $scope.globalScheduler = response.data.globalScheduler;
                           }
                       }
                       else {
                           $window.location.href = window.base_dir + "#/?loggedout=true";
                       }
                   }).then(function () {
                       formulaService.GetAllFormulas($routeParams.workspacegid).then(function (response) {

                           if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                               if (!angular.isUndefined(response.data.formulatypelist)) {
                                   $scope.formulatypelist = response.data.formulatypelist;
                               }
                           }
                           else {
                               $window.location.href = window.base_dir + "#/?loggedout=true";
                           }
                       });
                   });
               }
           };

           $scope.GlobalScheduleAction = function (Actiontype) {
               if (!angular.isUndefined(Actiontype)) {
                   $scope.globalScheduler.scheduler_status = Actiontype;

                   executionService.GlobalScheduleAction($scope.globalScheduler).then(function (response) {

                       if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                           if ($.parseJSON(response.data.success)) {

                               if (Actiontype == 'ACTIVE') {
                                   $rootScope.ShowAlert('Global Scheduler activated successfully.');
                               }
                               else {
                                   $rootScope.ShowAlert('Global Scheduler stopped successfully.');
                               }
                           }
                       }
                       else {
                           $window.location.href = window.base_dir + "#/?loggedout=true";
                       }
                   });
               }
           }

           //Add Child tree from server to the parent tree node.
           $scope.AddNewSubItem = function (scope) {
               var nodeData = scope.$modelValue;
               if (nodeData.nodes != undefined && nodeData.nodes != null && !nodeData.nodes.length) {
                   var data = null;
                   executionService.GetAreaList($scope.formula.formula_gid, '', nodeData.nid, 1).then(function (res) {
                       data = res.data.areas;

                       for (var area = data.length - 1; area >= 0; area--) {
                           nodeData.nodes.push(data[area]);
                       }

                       scope.toggle();
                   });
               }
               else {
                   scope.toggle();
               }
           };

           //The tree will be visisble only if there is any list present
           $scope.IsTreeVisible = function (item, scope) {
               if ($scope.query && $scope.query.length > 0 && item.title.indexOf($scope.query) == -1) {
                   return false;
               }
               return true;
           };

           //Used for Check box compare and marked them checked in the view.
           $scope.CompareAreaCheckbox = function (obj1, obj2) {
               return obj1 === obj2;
           };

           //Used for Check box compare and marked them checked in the view.
           $scope.CompareTimePeriodCheckbox = function (obj1, obj2) {
               return obj1 === obj2;
           };

           //Enable all the checboxes if Time period radio button is selected
           $scope.isTimePeriodSelected = function (index) {
               return index === $scope.frmexecute.timeperiod_type;
           };
       } ]);