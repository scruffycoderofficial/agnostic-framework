let mix = require('laravel-mix');

mix
    .js('resources/assets/js/app.js', 'js/app.js')
    .css('resources/assets/css/styles.css', 'css/app.css')
    .css('resources/assets/css/views/auth.css', 'css/auth.css')
    .setPublicPath('public');