const { mix } = require('laravel-mix');


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

let glob = require('glob')

mix.js('resources/assets/web/vue/2-vue-app.js', 'public/web/vue').sourceMaps();


mix.sass('resources/assets/web/sass/styles.scss','public/web/css/combine.css')
    .sass('resources/assets/web/sass/mobile.scss','public/web/css/mob-combine.css')
    .styles(glob.sync('resources/assets/web/css/*.css'), 'public/web/css/assets.css').sourceMaps();

mix.sass('resources/assets/admin/sass/styles.scss','public/admin/css/combine.css').sourceMaps();
// mix.sass('resources/assets/admin/sass/mobile.scss','public/admin/css/mob-combine.css').sourceMaps();


if (mix.inProduction()) {
  mix.babel(glob.sync('resources/assets/web/js/*.js'), 'public/web/js/combine.js')
  mix.version();
} else {
  mix.scripts(glob.sync('resources/assets/web/js/*.js'), 'public/web/js/combine.js')
}


/*
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
*/
