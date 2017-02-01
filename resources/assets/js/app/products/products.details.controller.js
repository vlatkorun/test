(function () {

    angular.module('app.products').controller('ProductsDetails', ProductsDetailsController);

    ProductsDetailsController.$inject = ['$state', 'product'];

    function ProductsDetailsController($state, product) {

        var vm = this;

        initControllerData();

        function initControllerData() {
            vm.$state = $state;
            vm.product = product;
        }
    }

})();