(function () {
    "use strict";

    var app = angular.module('app.common');

    app.directive('validation', ['ValidationService', function (ValidationService) {
        return {
            restrict: 'EA', //E = element, A = attribute, C = class, M = comment
            scope: {
                //@ reads the attribute value, = provides two-way binding, & works with functions
                inputName: '@'
            },
            replace: true,
            template: '<p class="alert alert-danger" ng-repeat="error in errors" role="alert"><i class="fa fa-times"></i> {{ error }}</p>',
            link: function (scope, element, attrs) {

                scope.errors = [];

                scope.$watch(
                    function() {
                        return ValidationService.getErrors(scope.inputName);
                    },
                    function(newValue, oldValue) {
                        scope.errors = newValue;
                    },
                    true
                );
            }
        };
    }]);

})();