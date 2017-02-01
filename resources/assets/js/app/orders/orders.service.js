(function () {

    var app = angular.module('app.orders');

    app.factory('OrdersService', OrdersService);

    OrdersService.$inject = ['$http', '$q', 'APP_CONFIG'];

    function OrdersService($http, $q, APP_CONFIG){

        function getOrders(params)
        {
            var deferred = $q.defer();

            var result = {
                status: false,
                message: '',
                orders: []
            };

            var url = APP_CONFIG.ROUTES.ORDERS;

            if(params)
            {
                url += '?' + $.param(params);
            }

            $http.get(url).
            then(function(response) {

                result.status = true;
                result.orders = response.data.data;
                result.message = response.data.message;
                deferred.resolve(result);

            }, function(response) {
                result.message = response.data.error.message;
                deferred.resolve(result);
            });

            return deferred.promise;
        }

        function getOrder(id, params)
        {
            var deferred = $q.defer();

            var result = {
                status: false,
                message: '',
                order: {}
            };

            var url = APP_CONFIG.ROUTES.ORDERS + '/' + id;

            if(params)
            {
                url =+ '/?' +  $.param(params);
            }

            $http.get(url).
            then(function(response) {

                result.status = true;
                result.order = response.data.data;
                result.message = response.data.message;

                deferred.resolve(result);

            }, function(response) {
                result.message = response.data.error.message;
                deferred.resolve(result);
            });

            return deferred.promise;
        }

        return {
            getOrders: getOrders,
            getOrder: getOrder,
        };
    }
})();