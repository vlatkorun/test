(function () {

    var app = angular.module('app.products');

    app.factory('ProductsService', ProductsService);

    ProductsService.$inject = ['$http', '$q', 'APP_CONFIG'];

    function ProductsService($http, $q, APP_CONFIG){

        function getProducts(params)
        {
            var deferred = $q.defer();

            var result = {
                status: false,
                message: '',
                products: []
            };

            var url = APP_CONFIG.ROUTES.PRODUCTS;

            if(params)
            {
                url += '?' + $.param(params);
            }

            $http.get(url).
                then(function(response) {

                    result.status = true;
                    result.products = response.data.data;
                    result.message = response.data.message;
                    deferred.resolve(result);

                }, function(response) {
                    result.message = response.data.error.message;
                    deferred.resolve(result);
                });

            return deferred.promise;
        }

        function getProduct(id, params)
        {
            var deferred = $q.defer();

            var result = {
                status: false,
                message: '',
                order: {}
            };

            var url = APP_CONFIG.ROUTES.PRODUCTS + '/' + id;

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
            getProducts: getProducts,
            getProduct: getProduct,
        };
    }
})();