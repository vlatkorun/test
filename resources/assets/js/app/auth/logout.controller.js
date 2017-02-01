(function() {
    'use strict';

    angular.module('app.auth')
        .controller('Logout', LogoutController);

    LogoutController.$inject = ['$state', 'toaster', 'AuthService'];

    function LogoutController($state, toaster, AuthService){

        var vm = this;

        initControllerData();

        vm.logout = function()
        {
            AuthService.logout({}).then(function(){

            });
        };

        function initControllerData(){
            vm.$state = $state;
        }
    }
})();