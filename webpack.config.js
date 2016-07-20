/* global module __dirname */
/* eslint-disable no-unused-vars */

var path = require('path'),
  webpack = require('webpack'),
  ExtractTextPlugin = require('extract-text-webpack-plugin');

// Export the webpack configuration
module.exports = {
  entry: {
    vendor: ['jquery', '../../../node_modules/material-design-lite/material.min.js'],
    admin: ['../admin/admin']
  },

  // Output controls the settings for file generation.
  output: {
    filename: '[name].js',
    path: path.join(__dirname, 'public/js'),
    chunkFilename: '[id].js'
  },

  // Module settings.
  module: {
    loaders: [{
      test: /\.css$/,
      loaders: [
        ExtractTextPlugin.loader({
          extract: true,
          omit: 1
        }),
        'style',
        'css',
        'sass'
      ]
    }, {
      test: /\.scss$/,
      loaders: [
        ExtractTextPlugin.loader({
          extract: true,
          omit: 1
        }),
        'style',
        'css',
        'sass'
      ]
    }, {
      test: /\.vue$/, // a regex for matching all files that end in `.vue`
      loader: 'vue' // loader to use for matched files
    }, {
      test: /\.js$/,
      exclude: /node_modules|admin/,
      loader: 'babel'
    }]
  },

  plugins: [
    new ExtractTextPlugin('[name].min.css')
  ]
};
