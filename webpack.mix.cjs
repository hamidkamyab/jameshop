let mix = require('laravel-mix');

mix.styles([
    'resources/admin/src/css/bootstrap.rtl.min.css',
    'resources/admin/src/css/style.css',
], 'public/css/admin.css')

mix.scripts([
    'resources/admin/src/js/jquery-3.7.1.min.js',
    'resources/admin/src/js/bootstrap.bundle.js',
    'resources/admin/src/js/chart.js',
    'resources/admin/src/js/style.js',
], 'public/js/admin.js')