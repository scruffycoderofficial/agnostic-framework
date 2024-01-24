let mix = require('laravel-mix');

mix
    .js('resources/assets/js/app.js', 'js/app.js')
    .css('resources/assets/css/styles.css', 'css/app.css')
    .setPublicPath('public');