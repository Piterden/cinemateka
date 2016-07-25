var elixir = require('laravel-elixir')
// var _ = require('underscore')
  /*,
    assetsPath = elixir.config.assetsPath,
    publicPath = elixir.config.publicPath*/

// require('laravel-elixir-coffeescript')
// require('laravel-elixir-ngtemplatecache')
require('laravel-elixir-webpack-advanced')
require('laravel-elixir-imagemin')

elixir(function (mix) {

  // var namespace = 'console'
  // var instances = [
  //   { name: 'admin' }
  //   //add more instance here
  // ]

  // _.each(instances, function (instance) {
  //   mix.coffee(
  //     [
  //       namespace + '/' + instance.name + '/app.coffee',
  //       namespace + '/' + instance.name + '/**/**'
  //     ],
  //     elixir.config.get('public.js.outputFolder') + '/'
  //     + namespace + '/' + instance.name + '/app.js')

  //   mix.sass(
  //     [namespace + '/' + instance.name + '/app.sass'],
  //     elixir.config.get('public.css.outputFolder') + '/'
  //     + namespace + '/' + instance.name
  //   )

  //   mix.ngTemplateCache(
  //     '/' + namespace + '/' + instance.name + '/**/*.html',
  //     elixir.config.get('public.js.outputFolder') + '/'
  //     + namespace + '/' + instance.name,
  //     null, {
  //       templateCache: {
  //         standalone: true
  //       },
  //       htmlmin: {
  //         collapseWhitespace: true,
  //         removeComments: true
  //       }
  //     })
  // })

  mix.styles(
    // From:
    [
      './node_modules/material-design-lite/material.min.css',
      './node_modules/vue-swipe/dist/vue-swipe.css'
    ],
    // To:
    'public/css/common.css')

  mix.sass([
    'app.scss'
  ])

  // mix.scripts('./node_modules/material-design-lite/material.min.js')

  mix.webpack('main', require('./webpack.config.js'), {
    $: 'jquery',
    jQuery: 'jquery',
    'window.jQuery': 'jquery'
  })

  mix.imagemin()

})

// require('laravel-elixir-fonts')
/**
 * Icon font from SVG generator
 */
// for (var font in fonts) {
//   if (fonts.hasOwnProperty(font)) {

//     mix.fonts(
//       [assetsPath + '/fonts/' + fonts[font] + '/' + fonts[font] + '.svg'],
//       publicPath + '/fonts/', {

//         font: {
//           fontName: fonts[font], // required
//           prependUnicode: true // recommended option
//         },

//         css: {
//           fontName: fonts[font],
//           // targetPath: '../../' + config.css.sass.folder + '/' + fontName + '.scss',
//           fontPath: '../fonts/'
//         }

//       }
//     ) // End mix.fonts

//   }
// }

