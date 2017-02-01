(function () {

    angular.module('app.products').controller('ProductsList', ProductsListController);

    ProductsListController.$inject = ['$state', 'products'];

    function ProductsListController($state, products) {

        var vm = this;

        initControllerData();

        vm.makeOrder = function(product){

        };
        
        function initControllerData() {
            vm.$state = $state;
            vm.products = products;
        }
    }

})();