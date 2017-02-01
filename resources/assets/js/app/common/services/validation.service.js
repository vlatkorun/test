(function () {

    var app = angular.module('app.common');

    app.factory('ValidationService', ValidationService);

    ValidationService.$inject = [];

    function ValidationService(){

        var errors = [];

        function setErrors(errorsInput)
        {
            errors = errorsInput;
        }

        function getErrors(inputName)
        {
            var inputErrors = [];

            if(!inputHasErrors(inputName))
            {
                return inputErrors;
            }

            for(var i = 0; i < errors.length; i++)
            {
                if(!errors[i].hasOwnProperty(inputName))
                {
                    continue;
                }

                inputErrors = errors[i][inputName];
            }

            return inputErrors;
        }

        function clearErrors()
        {
            setErrors([]);
        }

        function hasErrors()
        {
            return errors.length !== 0;
        }

        function inputHasErrors(inputName)
        {
            if(!hasErrors())
            {
                return false;
            }

            var errorsFound = false;

            for(var i = 0; i < errors.length; i++)
            {
                if(!errors[i].hasOwnProperty(inputName))
                {
                    continue;
                }

                errorsFound = true;
            }

            return errorsFound;
        }

        return {
            setErrors: setErrors,
            getErrors: getErrors,
            clearErrors: clearErrors,
            hasErrors: hasErrors,
            inputHasErrors: inputHasErrors
        }
    }

})();