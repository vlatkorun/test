(function() {
    'use strict';

    angular.module('app.auth')
        .controller('Login', LoginController);

    LoginController.$inject = ['$state', 'toaster', 'AuthService'];

    function LoginController($state, toaster, AuthService){

        var vm = this;

        initControllerData();

        vm.login = function()
        {
            AuthService.login(vm.credentials).then(function(result){
                if(result.status)
                {
                    toaster.success(result.message);
                    vm.$state.go('home');
                }

                if(!result.status)
                {
                    toaster.error(result.message);
                }
            });
        };

        function initControllerData(){
            vm.$state = $state;
            vm.credentials = {};
        }
    }
})();