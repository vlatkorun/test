(function () {

    var app = angular.module('app.common');

    app.factory('UserService', UserService);

    UserService.$inject = ['$window', '$http', '$q', 'APP_CONFIG'];

    function UserService($window, $http, $q, APP_CONFIG){

        var store = $window.localStorage;
        var userKey = 'user';

        function setUser(user){

            if( ! user)
            {
                store.removeItem(userKey);
                return;
            }

            store.setItem(userKey, JSON.stringify(user));
        }

        function getUser(){
            return JSON.parse(store.getItem(userKey));
        }

        function getProfile(params){

            var deferred = $q.defer();

            var result = {
                status: false,
                message: '',
                user: {}
            };

            var url = APP_CONFIG.ROUTES.PROFILE;

            if(params)
            {
                url += '?' + $.param(params);
            }

            $http.get(url).
                then(function(response) {
                    result.status = true;
                    result.user = response.data;

                    setUser(result.user);

                    deferred.resolve(result);
                }, function(response) {
                    result.message = response.data.error.message;
                    deferred.resolve(result);
                });

            return deferred.promise;
        }

        return {
            setUser: setUser,
            getUser: getUser,
            getProfile: getProfile,
        };
    }
})();