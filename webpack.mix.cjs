let mix = require('laravel-mix');

mix.styles([
    'resources/admin/src/css/bootstrap.rtl.min.css',
    'resources/admin/src/css/style.css',
    'resources/css/select2.min.css',
], 'public/css/admin.css')

mix.scripts([
    'resources/admin/src/js/bootstrap.bundle.js',
    'resources/js/select2.min.js',
    'resources/admin/src/js/chart.js',
    'resources/admin/src/js/sweetalert2.js',
    'resources/admin/src/js/style.js',
], 'public/js/admin.js')

mix.scripts([
    'resources/admin/src/js/ajax.js',
], 'public/js/ajax.js')
