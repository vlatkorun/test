(function() {
    'use strict';

    var app = angular.module('app');

    app.constant("APP_CONFIG", vlatkorun);

    app.$inject = ['$rootScope', 'toaster', '$state', 'ValidationService'];

    app.run(function($rootScope, toaster, $state, ValidationService){

        $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams){
            //toaster.clear();
            ValidationService.clearErrors();
        });

        $rootScope.$on('login:unauthorized', function(event, data) {
            toaster.error(data.message);
            $state.go('login');
        });

        $rootScope.$on('logout:success', function(event, data) {
            toaster.success(data.message);
            $state.go('login');
        });
    });
})();