const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .version()
    .copyDirectory('resources/editor/js', 'public/js')
    .copyDirectory('resources/editor/css', 'public/css');


// Mix v6
const path = require('path');

mix.alias({
    ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue'), // or 'vendor/tightenco/ziggy/dist/vue' if you're using the Vue plugin
});


mix.postCss('resources/css/font.css', 'public/css')
    .postCss("resources/css/tail.css", "public/css", [
        require("tailwindcss"),
    ]);



