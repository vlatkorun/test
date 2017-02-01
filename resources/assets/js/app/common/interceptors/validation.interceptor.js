(function () {
    "use strict";

    var app = angular.module('app.common');

    app.factory('ValidationInterceptor', ValidationInterceptor);

    ValidationInterceptor.$inject = ['ValidationService', '$rootScope', '$q'];

    function ValidationInterceptor(ValidationService, $rootScope, $q){

        function clearValidationErrors(config){

            ValidationService.clearErrors();

            return config;
        }

        function captureValidationError(response){

            if (response.status === 422 && response.data.error.hasOwnProperty('validation'))
            {
                ValidationService.setErrors(response.data.error.validation);
            }

            return $q.reject(response);
        }

        return {
            request: clearValidationErrors,
            responseError: captureValidationError
        };
    };
})();