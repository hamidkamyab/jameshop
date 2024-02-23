let mix = require('laravel-mix');

mix.styles([
    'resources/css/bootstrap.rtl.min.css',
    'resources/admin/src/css/style.css',
    'resources/css/select2.min.css',
], 'public/css/admin.css')

mix.scripts([
    'resources/js/bootstrap.bundle.js',
    'resources/js/select2.min.js',
    'resources/admin/src/js/chart.js',
    'resources/js/sweetalert2.js',
    'resources/admin/src/js/style.js',
], 'public/js/admin.js')

mix.scripts([
    'resources/admin/src/js/ajax.js',
], 'public/js/ajax.js')



mix.styles([
    'resources/css/bootstrap.rtl.min.css',
    'resources/digistyle/css/style.css',
    'resources/css/select2.min.css',
], 'public/css/client.css')

mix.scripts([
    'resources/js/bootstrap.bundle.js',
    'resources/js/select2.min.js',
    'resources/js/sweetalert2.js',
    'resources/digistyle/js/style.js',
], 'public/js/client.js')