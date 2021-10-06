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

// base
mix.js('resources/js/base.js', 'public/js')
// login
mix.js('resources/js/login.js', 'public/js')
// logout
mix.js('resources/js/logout.js', 'public/js')

// dashboard
mix.js('resources/js/dashboard.js', 'public/js')
// basic
mix.js('resources/js/basic.js', 'public/js')
mix.sass('resources/scss/basic.scss', 'public/css')
// user
mix.js('resources/js/user.js', 'public/js')
// role
mix.js('resources/js/role.js', 'public/js')
mix.sass('resources/scss/role.scss', 'public/css')
// sms
mix.js('resources/js/sms.js', 'public/js')
mix.sass('resources/scss/sms.scss', 'public/css')
// banners
mix.js('resources/js/banners.js', 'public/js')
// news-types
mix.js('resources/js/news-types.js', 'public/js')
// news
mix.js('resources/js/news.js', 'public/js')
mix.sass('resources/scss/news.scss', 'public/css')
// cooking-types
mix.js('resources/js/cooking-types.js', 'public/js')
// cooking
mix.js('resources/js/cooking.js', 'public/js')
mix.sass('resources/scss/cooking.scss', 'public/css')
// product-types
mix.js('resources/js/product-types.js', 'public/js')
// product
mix.js('resources/js/product.js', 'public/js')
mix.sass('resources/scss/product.scss', 'public/css')
// directory
mix.js('resources/js/directory.js', 'public/js')
// put-on
mix.js('resources/js/put-on.js', 'public/js')
mix.sass('resources/scss/put-on.scss', 'public/css')

// components search
mix.sass('resources/scss/components/search.scss', 'public/css/components')

mix.alias({
    vue$: 'node_modules/vue/dist/vue.esm-bundler.js',
});
