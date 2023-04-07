const mixx = require('laravel-mix');
const tailwindcss = require('tailwindcss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mixx.js('resources/js/frontend.js', 'public/js')
    .js('resources/js/adminend.js', 'public/js')
    .js('resources/js/sellercenter.js', 'public/js')
    .sass('resources/scss/frontend.scss', 'public/css')
    .sass('resources/scss/adminend.scss', 'public/css')
    .sass('resources/scss/sellercenter.scss', 'public/css')
    .options({
        postCss: [tailwindcss('./tailwind.config.js')],
    })
    .webpackConfig(require('./webpack.config'));

if (mixx.inProduction()) {
    mixx.version();
}
mixx.browserSync('127.0.0.1:8000');
