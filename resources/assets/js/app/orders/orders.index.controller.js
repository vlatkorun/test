(function () {

    angular.module('app.orders').controller('OrdersList', OrdersListController);

    OrdersListController.$inject = ['$state', 'orders'];

    function OrdersListController($state, orders) {

        var vm = this;

        initControllerData();

        function initControllerData() {
            vm.$state = $state;
            vm.orders = orders;
        }
    }

})();