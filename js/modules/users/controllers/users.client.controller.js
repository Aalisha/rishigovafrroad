angular.module('users').controller('adduserController', ['$scope', '$window', 'userService',
	function ($scope, $window, userService) {
	    $scope.submissionerror = false;

	    $scope.SignUp = function () {

	        if ($scope.form.$valid) {
	            userService.adduser($scope.user).then(function (response) {
	                if (response) {
	                    $window.location.href = window.base_dir + "Workspaces#/workspacelist";
	                }
	                else {
	                    $scope.submissionerror = true;
	                }
	            });
	        }
	    };
	}
]);