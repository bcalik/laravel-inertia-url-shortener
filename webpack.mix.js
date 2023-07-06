const mix = require('laravel-mix');
const path = require('path');

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

mix.options({
  hmrOptions: {
      host: '0.0.0.0',
      port: 8002
  }
})

mix.webpackConfig({
    devServer: {
        host: '0.0.0.0',
        port: 8002
    },
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
});

mix.js('resources/js/app.js', 'dist/js')
    .react()
    .postCss('resources/css/app.css', 'dist/css', [])
    .sourceMaps();
