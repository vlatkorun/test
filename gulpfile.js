const elixir = require('laravel-elixir');

require('laravel-elixir-wiredep');
require('laravel-elixir-useref');
require("laravel-elixir-ng-templates");
require('laravel-elixir-angularjs');

var templateCache = require('gulp-angular-templatecache');
elixir.extend('ngTemplates', function(source, output, options) {
    new elixir.Task('ngTemplates', function() {
        return gulp.src(source)
            .pipe(templateCache(options))
            .pipe(gulp.dest(output));
    }).watch(source).ignore(output);
});


/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.wiredep({src: 'app.blade.php'}).useref({src: 'app.blade.php'}, { searchPath: 'public' });

    mix.ngTemplates('resources/assets/js/app/**/*.html', 'resources/assets/js/app', {
        filename: 'templates.js',
        module: 'app'
    });

    mix.angular("resources/assets/js/app", "public/js/", "app.js");
});
