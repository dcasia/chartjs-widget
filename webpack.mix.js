const mix = require('laravel-mix')

require('./nova.mix')
require('mix-tailwindcss')

mix.setPublicPath('dist')
    .js('resources/js/widget.js', 'js')
    .vue({ version: 3 })
    .postCss('resources/css/widget.css', 'css')
    .tailwind()
    .nova('digital-creative/chartjs-widget')
