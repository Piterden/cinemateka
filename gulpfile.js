var elixir = require('laravel-elixir'),
  assetsPath = elixir.config.assetsPath,
  publicPath = elixir.config.publicPath;

require('laravel-elixir-webpack-advanced');
require('laravel-elixir-imagemin');

elixir(function (mix) {

  mix.styles(
    // From:
    [
      './node_modules/material-design-lite/material.min.css',
      './node_modules/vue-swipe/dist/vue-swipe.css'
    ],
    // To:
    'public/css/common.css');

  mix.sass([
    'app.scss'
  ]);



  mix.webpack('main', require('./webpack.config.js'), {
    $: 'jquery',
    jQuery: 'jquery',
    'window.jQuery': 'jquery'
  });

  mix.scripts([
    './node_modules/material-design-lite/material.min.js'
  ]);

  mix.imagemin();

  mix.babel('./resources/assets/js/admin.js');

});

// require('laravel-elixir-fonts');
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
//     ); // End mix.fonts

//   }
// }
