angular.module('calcdirectives')
   .directive('ngsubgrouplist', ['$q', '$compile', 'formulaService', function ($q, $compile, formulaService) {

       return {
           restrict: 'E',
           replace: true,
           link: function (scope, element, attrs) {
               scope.elementtype = attrs.elementtype;

               scope.updateSubGroup = function (indicatorgid, databaseid) {
                   scope.selected = !scope.selected;

                   //Keeps the HTML of Subgroup template.  
                   var SourceSubgroupTemplate = '<div id="SourceSubgroupTemplate">    <ul>        <li data-ng-repeat="subgroup in SubgroupList">            <label style="cursor: pointer">                <input type="{{elementtype}}" class="rc-btn" checklist-model="formula.selectedsourcesubgroup" checklist-value="subgroup" checklist-comparator="compareFn" checklist-change="SaveSourceSubGroup(subgroup)">                {{subgroup.src_subgroup}}            </label>        </li>    </ul></div>';
                   var TargetSubgroupTemplate = '<div id="TargetSubgroupTemplate">    <ul>        <li data-ng-repeat="subgroup in SubgroupList">            <label style="cursor: pointer">                <input type="{{elementtype}}" class="rc-btn" data-ng-model="formula.tgt_IUS_GID"  data-ng-value="GetValue(subgroup)" data-ng-change="SaveSubGroup(subgroup)" name="selectedsubgroup">                {{subgroup.tgt_subgroup}}            </label>        </li>    </ul></div>';
                   var formula_gid = scope.$parent.formula.formula_gid;

                   if (element.find('ul').length == 0) {
                       var IsSourceIndicator = 'false';

                       if (scope.elementtype == "checkbox") {
                           IsSourceIndicator = 'true';
                       }

                       formulaService.SubGroupList(indicatorgid, databaseid, IsSourceIndicator, formula_gid).then(function (response) {

                           scope.SubgroupList = response.data.SubgroupList;

                           angular.forEach(scope.SubgroupList, function (value, key) {
                               response.data.SubgroupList[key].src_devinfo_db_id = databaseid;
                           });

                           scope.SubgroupList = response.data.SubgroupList;

                           if (scope.elementtype == "checkbox") {
                               element.append(SourceSubgroupTemplate).show();
                           }
                           else if (scope.elementtype == "radio") {
                               element.append(TargetSubgroupTemplate).show();
                           }
                           $compile(element.contents())(scope);
                       });
                   }

                   if (scope.selected) {
                       element.find('ul').show();
                   }
                   else {
                       element.find('ul').hide();
                   }
               };

               scope.GetValue = function (subgroup) {
                   return subgroup.Ind_GID + '{~}' + subgroup.Unit_GID + '{~}' + subgroup.Subgroup_Val_GID;
               };
           }
       }
   } ]);



angular.module('calcdirectives')
   .directive('onFinishRender', ['$timeout', function ($timeout) {
       return {
           restrict: 'A',
           link: function (scope, element, attr) {
               if (scope.$last === true) {
                   $timeout(function () {
                       if (angular.element(document.getElementById((scope.$parent.formula.Ind_GID +'{tgt}'+ scope.$parent.formula.Unit_GID))).length > 0) {
                           angular.element(document.getElementById((scope.$parent.formula.Ind_GID +'{tgt}'+ scope.$parent.formula.Unit_GID))).trigger('click');
                       }
                   });
               }
           }
       }
   } ]);



angular.module('calcdirectives')
   .directive('onSourceFinishRender', ['$timeout', '$filter', function ($timeout, $filter) {
       return {
           restrict: 'A',
           link: function (scope, element, attr) {
               if (scope.$last === true) {
                   $timeout(function () {
                       var Indicators = [];

                       angular.forEach(scope.$parent.formula.selectedsourcesubgroup, function (value, key) {

                           var found = $filter('filter')(Indicators, { id: (value.Ind_GID +'{src}'+ value.Unit_GID) }, true);

                           //Trigger for unique Indicators
                           if (!found.length) {
                               Indicators.push({ id: (value.Ind_GID +'{src}'+ value.Unit_GID) });
                               if (angular.element(document.getElementById((value.Ind_GID +'{src}'+ value.Unit_GID))).length > 0) {
                                   angular.element(document.getElementById((value.Ind_GID +'{src}'+ value.Unit_GID))).trigger('click');
                               }
                           }
                       });
                   });
               }
           }
       }
   } ]);

   