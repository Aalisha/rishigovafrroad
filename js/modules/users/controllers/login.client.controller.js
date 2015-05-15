angular.module('users')
       .controller('loginController', ['$scope', '$window', 'authService', 'globalconfigService', function ($scope, $window, authService, globalconfigService) {

           $scope.user = {
               email: '',
               pwd: ''
           };

           $scope.IsAuthenticatedError = false;
           $scope.HideRegisterationLink = false;

           $scope.Login = function (user) {

               if ($scope.form.$valid) {
                   authService.login(user).then(function (response) {
                       if (response.data.authenticated) {
                           $scope.IsAuthenticatedError = false;
                           $window.location.href = window.base_dir + "Workspaces#/workspacelist";
                       }
                       else {
                           //Show error
                           $scope.IsAuthenticatedError = true;
                       }
                   });
               }
           };

           globalconfigService.getKeyValue('RegisterationLink').then(function (response) {
               if (response.data) {
                   $scope.HideRegisterationLink = $.parseJSON(response.data); //Return true or false..
               }
           });

       } ]);
