(function () {

    var app = angular.module('app.common');

    app.factory('TokenService', TokenService);

    TokenService.$inject = ['$window'];

    function TokenService($window){

        var store = $window.localStorage;
        var tokenKey = 'auth-token';

        function setToken(token){

            if( ! token)
            {
                store.removeItem(tokenKey);
                return;
            }

            store.setItem(tokenKey, JSON.stringify(token));
        }

        function getToken(){
            return JSON.parse(store.getItem(tokenKey));
        }

        return {
            setToken: setToken,
            getToken: getToken
        };
    }
})();