const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    // .postCss('resources/css/app.css', 'public/css', [
    //     //
    // ])
    .sass('resources/scss/app.scss', 'public/css')
    .sass('resources/scss/login.scss', 'public/css');

// user
mix.js('resources/js/user.js', 'public/js')

mix.alias({
    vue$: 'node_modules/vue/dist/vue.esm-bundler.js',
});
