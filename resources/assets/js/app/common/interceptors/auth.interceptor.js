(function () {
    "use strict";

    var app = angular.module('app.common');

    app.factory('AuthInterceptor', AuthInterceptor);

    AuthInterceptor.$inject = ['TokenService', '$rootScope', '$q'];

    function AuthInterceptor(TokenService, $rootScope, $q){

        "use strict";

        function addToken(config){

            var token = TokenService.getToken();

            if(token)
            {
                config.headers = config.headers || {};
                config.headers['Authorization'] = 'Bearer ' + token;
            }

            return config;
        }

        function captureUnathorized(response){

            if(response.status === 401)
            {
                $rootScope.$broadcast('login:unauthorized', {message: response.data.message});
            }

            return $q.reject(response);
        }

        return {
            request: addToken,
            responseError: captureUnathorized
        };
    };
})();