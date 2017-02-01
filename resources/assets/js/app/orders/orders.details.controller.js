(function () {

    angular.module('app.orders').controller('OrdersDetails', OrdersDetailsController);

    OrdersDetailsController.$inject = ['$state', 'order'];

    function OrdersDetailsController($state, order) {

        var vm = this;

        initControllerData();

        function initControllerData() {
            vm.$state = $state;
            vm.order = order;
        }
    }

})();