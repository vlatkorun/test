(function () {
    'use strict';

    angular.module('app', [
        'ngSanitize',
        'ui.router',
        'ui.bootstrap',
        'toaster',

        'app.common',
        'app.orders',
        'app.products',
        'app.auth'
    ]);
})();