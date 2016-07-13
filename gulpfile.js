var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

 // Jquery Files
 elixir(function(mix) {
     mix.copy('bower_components/jquery/dist/jquery.js', 'resources/assets/js/jquery.js');
     mix.copy('bower_components/jquery-ui/jquery-ui.js', 'resources/assets/js/jquery-ui.js');
 });

 // Bootstrap Files
elixir(function(mix) {
    mix.copy('bower_components/bootstrap/dist/css/bootstrap.css', 'resources/assets/css/bootstrap.css');
    mix.copy('bower_components/bootstrap/dist/js/bootstrap.js', 'resources/assets/js/bootstrap.js');
});

// Font Awesome Files
elixir(function(mix) {
    mix.copy('bower_components/font-awesome/css/font-awesome.css', 'resources/assets/css/font-awesome.css');
    mix.copy('bower_components/font-awesome/fonts/', 'public/fonts/');
});

elixir(function(mix) {
    mix.styles([
        'bootstrap.css',
        'font-awesome.css'
    ]);
});

elixir(function(mix) {
    mix.scripts([
        'jquery.js',
        'bootstrap.js',
        'jquery-ui.js'
    ]);
});
