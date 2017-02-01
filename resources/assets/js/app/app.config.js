(function() {
    'use strict';

    var app = angular.module('app');

    app.$inject = ['$stateProvider', '$urlRouterProvider', 'APP_CONFIG', '$locationProvider', '$httpProvider', '$provide'];

    app.config(function($stateProvider, $urlRouterProvider, APP_CONFIG, $locationProvider, $httpProvider, $provide){
        $httpProvider.interceptors.push('AuthInterceptor');
        $httpProvider.interceptors.push('ValidationInterceptor');
        //$httpProvider.interceptors.push('LoadingInterceptor');
        $urlRouterProvider.otherwise("/");

        $stateProvider.state('home', {
                url: '/',
                views: {
                    'content@': {
                        templateUrl: 'products/products.list.html',
                        controller: 'ProductsList as vm'
                    },
                    'header@': {
                        templateUrl: 'common/header.html',
                        controller: 'Common as vm'
                    }
                },
                resolve: {
                    products: ['ProductsService', function(ProductsService){
                        return ProductsService.getProducts().then(function(result){
                            return result.products;
                        });
                    }]
                }
            });
    });
})();