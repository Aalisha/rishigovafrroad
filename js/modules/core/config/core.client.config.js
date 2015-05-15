angular.module('core', ['calculateengine.loadingBar']).run(['$rootScope', '$window', '$location', '$route', '$cookieStore', 'authService', 'globalconfigService',
    function ($rootScope, $window, $location, $route, $cookieStore, authService, globalconfigService) {

        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            var authorize = false;

            if (!angular.isUndefined(($route.routes[$location.path()]))) {
                authorize = ($route.routes[$location.path()]).authorize;
            }

            if (authorize) {
                authService.IsLoggedIn().then(function (response) {
                    if (!angular.isUndefined(response) && !angular.isUndefined(response.data) && !response.data.success) {
                        //User is not logged in, redirect it to login page.
                        var path = $location.path();

                        if (path != window.base_dir) {
                            $window.location.href = window.base_dir + "#/?loggedout=true";
                        }
                    }
                });
            }
        });

        $rootScope.Logout = function () {
            $cookieStore.remove('globals');
        }

        //Login pop up ig user is logged out.
        if (!angular.isUndefined($location.search().loggedout)) {
            angular.element('a.popup').trigger('click');
        }

        //Get App name to show in tittle
        globalconfigService.getKeyValue('APP_NAME').then(function (response) {
            if (!angular.isUndefined(response.data)) {
                $rootScope.App = { AppName: response.data, Tittle: '' };
            }
        });

        //Show Alert
        $rootScope.ShowAlert = function (message) {
            $("#dialog-confirm").removeClass('hidden');

            $rootScope.message = message;

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
                    OK: function () {
                        $("#dialog-confirm").addClass('hidden');
                        $(this).dialog("close");
                    }
                }
            });
        };
    } ]);