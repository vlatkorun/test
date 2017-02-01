(function() {
    'use strict';

    var app = angular.module('app.auth');

    app.$inject = ['$stateProvider'];

    app.config(function($stateProvider){

        $stateProvider.state('login', {
            url: '/login',
            views: {
                'content@': {
                    templateUrl: 'auth/login.html',
                    controller: 'Login as vm'
                },
                'header@': {
                    templateUrl: 'common/header.html',
                    controller: 'Common as vm'
                }
            }
        });
    });
})();