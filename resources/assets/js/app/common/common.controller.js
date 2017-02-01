(function() {
    'use strict';

    angular.module('app.common')
        .controller('Common', CommonController);

    CommonController.$inject = ['$state', 'toaster', 'UserService', 'AuthService'];

    function CommonController($state, toaster, UserService, AuthService){

        var vm = this;

        initControllerData();

        vm.logout = function()
        {
            AuthService.logout().then(function(result){
                toaster.success(result.message);
                vm.$state.go('login');
            });
        };

        function initControllerData(){
            vm.$state = $state;
            vm.user = UserService.getProfile().then(function(result) {return result.user;});
        }
    }
})();