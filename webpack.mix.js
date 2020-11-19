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

mix.js('resources/js/app.js', 'public/js').sourceMaps()
    .css('vendor/bootstrap-treeview-1.2.0/src/css/bootstrap-treeview.css','public/css')
    .js('vendor/bootstrap-treeview-1.2.0/src/js/bootstrap-treeview.js','public/js')
    // .less('node_modules/font-awesome/less/font-awesome.less', 'public/css' )
    .sass('resources/sass/app.scss', 'public/css');
