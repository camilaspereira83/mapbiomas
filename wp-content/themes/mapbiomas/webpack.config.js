const path = require('path');
const webpack = require('webpack');

module.exports = {
  mode: 'production',
  entry: './js/main.js',
  output: {
    path: path.resolve(__dirname),
    filename: 'script.js',
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: path.resolve(path.join(__dirname, 'node_modules/jquery')),
      jQuery: path.resolve(path.join(__dirname, 'node_modules/jquery')),
      'window.jQuery': path.resolve(path.join(__dirname, 'node_modules/jquery')),
    }),
  ]
};
