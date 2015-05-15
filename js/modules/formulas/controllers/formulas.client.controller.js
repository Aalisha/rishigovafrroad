angular.module('formulas')
       .controller('formulaController', ['$scope', '$rootScope', '$window', '$location', '$routeParams', '$filter', '$route', '$q', 'formulaService', 'executionService', function ($scope, $rootScope, $window, $location, $routeParams, $filter, $route, $q, formulaService, executionService) {

           $scope.ShowHideError = false;
           $scope.formula = {};
           $scope.formulatypelist = {};
           $scope.formula.selecteddatabaseid = null;
           $scope.formula.SourceIndicatorSubgroupTree = [];


           $scope.IsShown = function (formula_type) {
               $scope.formuladesc = formula_type;
           };

           if (!angular.isUndefined($routeParams.workspacegid)) {
               $scope.workspacegid = $routeParams.workspacegid;
           }

           //Load all the formulas and there formula list for the given workspacegid.
           $scope.LoadAllFormulas = function () {

               if (!angular.isUndefined($routeParams.workspacegid)) {
                   formulaService.GetAllFormulas($routeParams.workspacegid).then(function (response) {

                       if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                           if (!angular.isUndefined(response.data.formulatypelist)) {
                               $scope.formulatypelist = response.data.formulatypelist;
                           }

                           $rootScope.workspace.workspacename = response.data.workspacename;
                           $rootScope.workspace.workspacegid = response.data.workspacegid;

                           $rootScope.App.Tittle = " - " + response.data.workspacename;
                       }
                       else {
                           $window.location.href = window.base_dir + "#/?loggedout=true";
                       }
                   });
               }
           };

           //Create a dummy entry for formula for the given workspacegid at Step 0.
           $scope.CreateForumula = function (workspacegid) {
               if (!angular.isUndefined($routeParams.workspacegid)) {
                   formulaService.CreateFormula($routeParams.workspacegid).then(function (response) {

                       if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                           if ($.parseJSON(response.data.success)) {
                               $location.path("/formulasettings/" + response.data.formula_gid + "/" + true);
                           }
                       }
                       else {
                           $window.location.href = window.base_dir + "#/?loggedout=true";
                       }
                   });
               }
           };

           //Load a formula for the given formula gid in the workspace
           $scope.LoadFormula = function () {
               if (!angular.isUndefined($routeParams.formulagid)) {
                   formulaService.GetFormula($routeParams.formulagid).then(function (response) {

                       if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                           if (!angular.isUndefined(response.data) && !angular.isUndefined(response.data.formula)) {
                               $scope.formula = response.data.formula;
                               $scope.formuladesc = response.data.formula.formula_type;
                               $rootScope.workspace.workspacename = response.data.formula.workspacename;
                               $rootScope.workspace.workspacegid = response.data.formula.workspacegid;
                               $scope.workspacegid = response.data.formula.workspacegid;
                               $rootScope.App.Tittle = " - " + response.data.formula.workspacename;
                               $scope.formula.SourceIndicatorSubgroupTree = [];
                               $scope.formula.TargetTooltip = $scope.formula.tgt_Indicator + ", " + $scope.formula.tgt_Unit + ", " + $scope.formula.tgt_Subgroup;

                               if ($scope.formula.formulatypeselected.type_shortname == 'UDF') {
                                   $scope.HideCalcualtorPanel = true;
                               }
                               else {
                                   $scope.HideCalcualtorPanel = false;
                               }
                           }
                       }
                       else {
                           //$window.location.href = window.base_dir + "#/?loggedout=true";
                       }
                   }).then(function (response) {
                       $scope.TargetIndicator();
                   }).then(function (response) {
                       $scope.SourceIndicator();
                   }).then(function (response) {
                       $scope.CreateSourceSubgroupTree();
                   }).then(function (response) {
                       $scope.ProcessNormalization();
                   });
               }
           };

           //Save formula.
           $scope.SaveFormula = function () {
               //if ($scope.form.modified) {
               $scope.formula.formulastep = $scope.FomulaStep;
               formulaService.SaveFormula($scope.formula).then(function (response) {

                   if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                       if ($.parseJSON(response.data.success)) {
                           //$scope.form.$setPristine();
                       }
                       else {
                           $scope.ShowHideError = true;
                       }
                   }
                   else {
                       $window.location.href = window.base_dir + "#/?loggedout=true";
                   }
               });
               //}
           };

           $scope.SelectedTargetDatabase = function (selecteddatabase) {

               if (!angular.isUndefined(selecteddatabase) && !angular.isUndefined(selecteddatabase.originalObject)) {

                   $scope.ClearSelection();

                   $scope.formula.tgt_devinfo_db_id = selecteddatabase.originalObject.id;

                   $scope.TargetIndicator();
               }
           };

           $scope.SelectedSourceDatabase = function (selecteddatabase) {

               if (!angular.isUndefined(selecteddatabase) && !angular.isUndefined(selecteddatabase.originalObject)) {

                   $scope.formula.src_devinfo_db_id = selecteddatabase.originalObject.id;

                   $scope.SourceIndicator();
               }
           };

           $scope.TargetIndicator = function () {
               if (!angular.isUndefined($scope.formula.tgt_devinfo_db_id) && ($scope.formula.tgt_devinfo_db_id > 0)) {
                   $scope.Indicators($scope.formula.formula_gid, $scope.formula.tgt_devinfo_db_id).then(function (response) {
                       $scope.formula.TargetIndicatorList = response;
                   });
               }
           };

           $scope.SourceIndicator = function () {
               if (!angular.isUndefined($scope.formula.src_devinfo_db_id) && ($scope.formula.src_devinfo_db_id > 0)) {
                   $scope.Indicators($scope.formula.formula_gid, $scope.formula.src_devinfo_db_id).then(function (response) {
                       $scope.formula.SourceIndicatorList = response;
                   });
               }
           };

           //Get Indicators List for the given formula GID and Database ID
           $scope.Indicators = function (formula_gid, databaseid) {

               return formulaService.IndicatorsList(formula_gid, databaseid).then(function (response) {

                   if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                       if (!angular.isUndefined(response.data.indicator_list)) {
                           return response.data.indicator_list;
                       }
                   }
                   else {
                       $window.location.href = window.base_dir + "#/?loggedout=true";
                   }
               });
           };

           //Save formula type popup.
           $scope.SaveFormulaType = function (formula) {

               var FormulaCreation = false;
               if (!angular.isUndefined($routeParams.FormulaCreation)) {
                   FormulaCreation = $routeParams.FormulaCreation;
               }

               if (!FormulaCreation) {

                   $("#dialog-confirm").removeClass('hidden');
                   $scope.message = "Are you sure you want to change the Formula Type?";

                   $("#dialog-confirm").dialog({
                       resizable: false,
                       height: 200,
                       width: 400,
                       modal: true,
                       buttons: {
                           No: function () {
                               $scope.$apply(function () {
                                   $route.reload();
                               });

                               $("#dialog-confirm").addClass('hidden');
                               $(this).dialog("close");
                           },
                           Yes: function () {
                               $scope.SaveFormula();
                               $("#dialog-confirm").addClass('hidden');
                               $(this).dialog("close");
                           }
                       }
                   });
               }
               else {
                   $scope.SaveFormula();
               }
           };

           //Delete formula
           $scope.DeleteFormula = function (formula) {
               $("#dialog-confirm").removeClass('hidden');
               $scope.message = "Are you sure you want to delete?";
               //dialog(formula_gid);
               $("#dialog-confirm").dialog({
                   resizable: false,
                   height: 200,
                   width: 400,
                   modal: true,
                   buttons: {
                       Cancel: function () {
                           $("#dialog-confirm").addClass('hidden');
                           $(this).dialog("close");
                       },

                       Delete: function () {
                           $scope.$apply(function () {
                               formulaService.DeleteFormula(formula.formula_gid).then(function (response) {

                                   if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                                       if (!angular.isUndefined(response.data.success) && response.data.success) {
                                           var index = $scope.formulatypelist.indexOf(formula)
                                           $scope.formulatypelist.splice(index, 1);
                                       }
                                       else {
                                           $scope.ShowHideError = true;
                                       }
                                   }
                                   else {
                                       $window.location.href = window.base_dir + "#/?loggedout=true";
                                   }
                               });
                           });

                           $("#dialog-confirm").addClass('hidden');
                           $(this).dialog("close");
                       }
                   }
               });
           };

           //Delete Execution
           $scope.DeleteExecution = function (formula, execution) {
               $("#dialog-confirm").removeClass('hidden');

               $scope.message = "Are you sure you want to delete execution?";

               $("#dialog-confirm").dialog({
                   resizable: false,
                   height: 200,
                   width: 400,
                   modal: true,
                   buttons: {
                       Cancel: function () {
                           $("#dialog-confirm").addClass('hidden');
                           $(this).dialog("close");
                       },

                       Delete: function () {
                           $scope.$apply(function () {
                               executionService.DeleteExecution(execution.MFormulaExecutionPlan.execution_gid).then(function (response) {

                                   if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                                       if (!angular.isUndefined(response.data.success) && response.data.success) {

                                           var index = $scope.formulatypelist.indexOf(formula);
                                           var executionindex = $scope.formulatypelist[index].executionlist.indexOf(execution);
                                           $scope.formulatypelist[index].executionlist.splice(executionindex, 1);
                                       }
                                   }
                                   else {
                                       $window.location.href = window.base_dir + "#/?loggedout=true";
                                   }
                               });
                           });
                           $("#dialog-confirm").addClass('hidden');
                           $(this).dialog("close");
                       }
                   }
               });
           };

           $scope.searchformula = function (formula) {
               var keyword = new RegExp($scope.searchfilter, 'i');
               return keyword.test(formula.formula_name);
           };

           //Show Popup
           $scope.popup = function (popupid, PopupSource) {
               $scope.PopupSource = PopupSource;

               $('#' + popupid).fadeIn();
               $('body').append('<div id="fade"></div>');
               $('#fade').css({ 'filter': 'alpha(opacity=80)' }).fadeIn();
               var popuptopmargin = ($('#' + popupid).height() + 10) / 2;
               var popupleftmargin = ($('#' + popupid).width() + 10) / 2;
               $('#' + popupid).css({
                   'margin-top': -popuptopmargin,
                   'margin-left': -popupleftmargin
               });
           };

           //Close Popup
           $scope.ClosePopUp = function () {
               $scope.formula.db_name = null;
               $scope.formula.db_host = null;
               $scope.formula.db_login = null;
               $scope.formula.db_password = null;
               $scope.formula.db_port = null;
               $scope.formula.db_database = null;

               $('#fade, .popupbox').fadeOut();

               $scope.testconnection = null;
               $scope.connectionclass = null;
               $scope.connectioncolor = null;

               return false;
           };

           //Test Connection
           $scope.TestConnection = function () {
               formulaService.TestConnection($scope.formula).then(function (response) {

                   if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                       if ($.parseJSON(response.data.success)) {
                           $scope.testconnection = true;
                           $scope.connectionclass = "fa fa-check";
                           $scope.connectioncolor = "color: green";
                       }
                       else {
                           $scope.testconnection = false;
                           $scope.connectionclass = "fa fa-close";
                           $scope.connectioncolor = "color: red";
                       }
                   }
                   else {
                       $window.location.href = window.base_dir + "#/?loggedout=true";
                   }
               });
           };

           //Save Database.
           $scope.SaveConnection = function () {
               formulaService.SaveConnection($scope.formula).then(function (response) {

                   if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                       if ($.parseJSON(response.data.success)) {
                           //Push into database dropdown list
                           $scope.formula.databaselist.push({ id: response.data.database_id, name: $scope.formula.db_name });

                           if ($scope.PopupSource == 'TargetPopup') {
                               $scope.formula.tgt_devinfo_db_name = $scope.formula.db_name;
                               $scope.formula.tgt_devinfo_db_id = response.data.database_id;
                               $scope.$broadcast('angucomplete-alt:setInput', $scope.formula.tgt_devinfo_db_name, 'ddlTargetDatabase');
                               $scope.TargetIndicator();
                           }
                           else {
                               $scope.formula.src_devinfo_db_name = $scope.formula.db_name;
                               $scope.formula.src_devinfo_db_id = response.data.database_id;
                               $scope.$broadcast('angucomplete-alt:setInput', $scope.formula.src_devinfo_db_name, 'ddlSourceDatabase');
                               $scope.SourceIndicator();
                           }
                           $scope.ClosePopUp();
                       }
                       else {
                           $scope.testconnection = false;
                           $scope.connectionclass = "fa fa-close";
                           $scope.connectioncolor = "color: red";
                       }
                   }
                   else {
                       $window.location.href = window.base_dir + "#/?loggedout=true";
                   }
               });
           };

           $scope.SaveSubGroup = function (subgroup) {
               $scope.formula.tgt_Subgroup = subgroup.tgt_subgroup;
               $scope.formula.subgroupgid = subgroup.Subgroup_Val_GID;
               $scope.formula.Ind_GID = subgroup.Ind_GID;
               $scope.formula.tgt_Indicator = subgroup.tgt_indicator;
               $scope.formula.tgt_Unit = subgroup.tgt_unit;
               $scope.formula.Unit_GID = subgroup.Unit_GID;

               $scope.SaveFormula();
           };

           $scope.SaveSourceSubGroup = function (subgroup) {
               $scope.formula.formula = null;
               $scope.SaveFormula();
               $scope.CreateSourceSubgroupTree();
           };

           $scope.compareFn = function (obj1, obj2) {
               return obj1.src_ius_gid === obj2.src_ius_gid;
           };

           $scope.ClearSelection = function (IsSave) {
               $scope.formula.tgt_Subgroup = null;
               $scope.formula.subgroupgid = null;
               $scope.formula.Ind_GID = null;
               $scope.formula.tgt_Indicator = null;
               $scope.formula.tgt_Unit = null;
               $scope.formula.Unit_GID = null;
               $scope.formula.tgt_IUS_GID = null;

               if (IsSave) {
                   $scope.SaveFormula();
               }
           };

           $scope.ClearSourceSelection = function (IsSave, src_indicator, src_unit) {
               if (IsSave) {
                   var Index = 0;

                   for (var group = $scope.formula.selectedsourcesubgroup.length - 1; group >= 0; group--) {
                       if ($scope.formula.selectedsourcesubgroup[group].src_indicator == src_indicator && $scope.formula.selectedsourcesubgroup[group].src_unit == src_unit) {
                           $scope.formula.selectedsourcesubgroup.splice(group, 1);
                       }
                   }

                   $scope.SaveFormula();
                   $scope.CreateSourceSubgroupTree();
               }
               else {
                   $scope.formula.selectedsourcesubgroup = null;
               }
           };

           $scope.CreateSourceSubgroupTree = function () {
               var Indicators = [];
               var Index = 0;
               $scope.formula.IndicatorSubgroupTree = [];
               angular.forEach($scope.formula.selectedsourcesubgroup, function (value, key) {
                   var found = $filter('filter')($scope.formula.IndicatorSubgroupTree, { uniqueid: (value.Ind_GID + '{src}' + value.Unit_GID) }, true);

                   //For unique Indicators
                   if (found != null && found.length) {
                       var SubGroup = [];
                       SubGroup.push({ src_devinfo_db_id: value.src_devinfo_db_id, formula_id: value.formula_id, id: value.id, src_ius_gid: value.src_ius_gid, src_ius_symbol: value.src_ius_symbol, src_subgroup: value.src_subgroup, minimum: value.min_value, maximum: value.max_value, AutoCalculate: value.auto_calculate_min_max, high_is_good: value.high_is_good, weight: value.weight, normalization: value.normalization, value_margin: value.value_margin });
                       $scope.formula.IndicatorSubgroupTree[found[0].Index].SubGroup.push(SubGroup[0]);
                   }
                   else {
                       var SubGroup = [];

                       SubGroup.push({ src_devinfo_db_id: value.src_devinfo_db_id, formula_id: value.formula_id, id: value.id, src_ius_gid: value.src_ius_gid, src_ius_symbol: value.src_ius_symbol, src_subgroup: value.src_subgroup, minimum: value.min_value, maximum: value.max_value, AutoCalculate: value.auto_calculate_min_max, high_is_good: value.high_is_good, weight: value.weight, normalization: value.normalization, value_margin: value.value_margin });
                       $scope.formula.IndicatorSubgroupTree.push({ uniqueid: (value.Ind_GID + '{src}' + value.Unit_GID), src_iu_symbol: value.src_iu_symbol, src_indicator: value.src_indicator, src_unit: value.src_unit, SubGroup: SubGroup, Index: Index });
                       Index = parseInt(Index) + 1;
                   }
               });

           };

           $scope.AddOperator = function (Operator) {
               var caretPos = document.getElementById("MathInput").selectionStart;
               var textAreaTxt = jQuery("#MathInput").val();
               jQuery("#MathInput").val(textAreaTxt.substring(0, caretPos) + Operator + textAreaTxt.substring(caretPos));

               document.getElementById("MathInput").setSelectionRange(caretPos + Operator.length, caretPos + Operator.length);

               $scope.formula.formula = jQuery("#MathInput").val();

               $scope.UpdateMath();
           };

           $scope.UpdateMath = function () {

               $scope.formula.Normalizedformula = $scope.formula.formula;

               var HIDEBOX = function () { box.style.visibility = "hidden" };
               var SHOWBOX = function () { box.style.visibility = "visible" };

               MathJax.Hub.Config({
                   asciimath2jax: {
                       delimiters: [['`', '`'], ['$', '$']]
                   },
                   menuSettings: { menuSettings: "None" }
               });

               MathJax.Hub.Queue(HIDEBOX, ["Typeset", MathJax.Hub, $scope.formula.Normalizedformula], SHOWBOX);
               $scope.ProcessNormalization();
               $scope.SaveFormula();
           };

           $scope.ProcessNormalization = function () {
               $scope.formula.Normalizedformula = $scope.formula.formula;

               angular.forEach($scope.formula.IndicatorSubgroupTree, function (value, key) {

                   angular.forEach(value.SubGroup, function (subgroupvalue, key) {

                       var found = $filter('filter')($scope.formula.normalization_types, { id: subgroupvalue.normalization }, true);
                       var expression = null;
                       if (found != null && found.length) {
                           expression = found[0].type_expression;
                       }

                       if (found != null && found.length && expression != null && expression != undefined) {
                           var Symbol = subgroupvalue.src_ius_symbol;
                           var SymbolNumber = subgroupvalue.src_ius_symbol.split('')[1];
                           var SymbolCharacter = subgroupvalue.src_ius_symbol.split('')[0];

                           if (subgroupvalue.src_ius_symbol != undefined && subgroupvalue.src_ius_symbol != null) {
                               var regex = new RegExp('X', "g");
                               expression = found[0].type_expression.replace(regex, subgroupvalue.src_ius_symbol);
                           }

                           if (subgroupvalue.maximum != undefined && subgroupvalue.maximum != null && subgroupvalue.maximum != "") {
                               var regex = new RegExp(Symbol + "_max", "g");
                               expression = expression.replace(regex, subgroupvalue.maximum);
                           }

                           if (subgroupvalue.minimum != undefined && subgroupvalue.minimum != null && subgroupvalue.minimum != "") {
                               var regex = new RegExp(Symbol + "_min", "g");
                               expression = expression.replace(regex, subgroupvalue.minimum);
                           }
                           if (subgroupvalue.weight != undefined && subgroupvalue.weight != null && subgroupvalue.weight != "") {
                               var regex = new RegExp('W' + Symbol, "g");
                               $scope.formula.Normalizedformula = $scope.formula.Normalizedformula.replace(regex, subgroupvalue.weight);
                           }
                           if (expression != undefined && expression != null) {
                               var regex = new RegExp(Symbol, "g");
                               $scope.formula.Normalizedformula = $scope.formula.Normalizedformula.replace(regex, expression);
                           }
                       }
                   });
               });
               $scope.SaveFormula();
           };


           $scope.ProcessAutoCalculate = function (sub) {
               sub.maximum = null;
               sub.minimum = null;

               if (!sub.AutoCalculate) {
                   sub.value_margin = null;
               }

               $scope.ProcessNormalization();
           };


           $scope.ExecuteFromWorkspace = function (execution, IsSchedule) {
               $scope.frmexecute = {};
               $scope.frmexecute.execution_gid = execution.execution_gid;
               $scope.frmexecute.workspacegid = $scope.workspacegid;
               $scope.frmexecute.IsSchedule = IsSchedule;

               if (IsSchedule) {
                   execution.scheduled = IsSchedule;
               }

               executionService.SaveArea($scope.frmexecute).then(function (response) {

                   if (!angular.isUndefined(response.data.IsLoggedIn) && response.data.IsLoggedIn) {

                       if ($.parseJSON(response.data.success)) {
                           if (IsSchedule) {
                               $rootScope.ShowAlert('Execution scheduled successfully');
                           }
                           else {
                               $rootScope.ShowAlert('Formula executed successfully');
                           }
                       }
                   }
                   else {
                       $window.location.href = window.base_dir + "#/?loggedout=true";
                   }
               });
           };

           $scope.ShowAutoComplete = function (id) {
               $scope.$broadcast('angucomplete-alt:NotchClick', id);
           };

           $scope.ClearSearchIndicator = function (id) {
               if (id == 'TargetIndicatorFilter') {
                   $scope.TargetIndicatorFilter = null;
               }
               else {
                   $scope.SourceIndicatorFilter = null;
               }
           };
       } ]);

     
