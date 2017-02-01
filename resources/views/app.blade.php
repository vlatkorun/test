<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @if(config('app.debug'))
        <!-- build:css(public) css/vendor.css -->
        <!-- bower:css -->
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css" />
        <link rel="stylesheet" href="/bower_components/AngularJS-Toaster/toaster.css" />
        <!-- endbower -->
        <!-- endbuild -->
    @else
        <link rel="stylesheet" href="{{ elixir("css/vendor.css") }}">
    @endif

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app" ng-app="app">
        <ui-view name="header"></ui-view>

        <div class="container">
            <ui-view name="content"></ui-view>
        </div>

        <toaster-container toaster-options="{'position-class': 'toast-bottom-right'}"></toaster-container>
    </div>

    <!-- Scripts -->
@if(config('app.debug'))
    <!-- build:js(public) js/vendor.js -->
    <!-- bower:js -->
    <script src="/bower_components/jquery/dist/jquery.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/bower_components/angular/angular.js"></script>
    <script src="/bower_components/angular-sanitize/angular-sanitize.js"></script>
    <script src="/bower_components/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="/bower_components/angular-animate/angular-animate.js"></script>
    <script src="/bower_components/AngularJS-Toaster/toaster.js"></script>
    <script src="/bower_components/angular-bootstrap/ui-bootstrap-tpls.js"></script>
    <!-- endbower -->
    <!-- endbuild -->
@else
    <script src="{{ elixir("js/vendor.js") }}"></script>
@endif

    <script src="{{ elixir("js/app.js") }}"></script>
</body>
</html>
