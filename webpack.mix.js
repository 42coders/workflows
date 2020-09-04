let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.webpackConfig({
    resolve: {
        alias: {
            jquery: 'jquery/src/jquery'
        }
    }
});

mix.autoload({
    jquery: ['$', 'window.jQuery']
});

mix.config.fileLoaderDirs.fonts = 'public/fonts';

mix.js([
        'node_modules/jquery/dist/jquery.js',
        'resources/js/workflow.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
    ], 'public/js/workflow.js')
    .sass('resources/sass/workflow.scss', 'public/css/workflow.css');
