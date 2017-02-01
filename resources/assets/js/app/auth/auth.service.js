(function () {

    var app = angular.module('app.auth');

    app.factory('AuthService', AuthService);

    AuthService.$inject = ['$http', '$q', 'APP_CONFIG', 'TokenService', 'UserService'];

    function AuthService($http, $q, APP_CONFIG, TokenService, UserService){

        function login(credentials){

            var deferred = $q.defer();

            var result = {
                status: false,
                message: ''
            };

            $http.post(APP_CONFIG.ROUTES.LOGIN, credentials)
                .then(function(response){
                    TokenService.setToken(response.data.token);
                    result.status = true;
                    result.message = response.data.message;
                    deferred.resolve(result);
                }, function(response){
                    result.message = response.data.error.message;
                    deferred.resolve(result);
                });

            return deferred.promise;
        }

        function logout(){

            var user = UserService.getUser();

            var deferred = $q.defer();

            var result = {
                status: false,
                message: ''
            };

            if(!user)
            {
                console.log('No user found in localStorage');

                result.message = 'No user found in localStorage';
                deferred.reject(result);

                return deferred.promise;
            }

            $http.get(APP_CONFIG.ROUTES.LOGOUT)
                .then(function(response){

                    TokenService.setToken(false);
                    UserService.setUser(false);

                    result.status = true;
                    result.message = response.data.message;

                    deferred.resolve(result);
                }, function(response){

                    result.message = response.data.error.message;

                    deferred.resolve(result);
                });

            return deferred.promise;
        }

        return {
            login: login,
            logout: logout
        };
    }
})();