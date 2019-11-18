const webpack = require('webpack');
const path = require('path');

const config = {
  entry: './example/index.js',
  output: {
    path: path.resolve(__dirname, 'example/dist'),
    filename: 'example.js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        use: 'babel-loader',
        exclude: /node_modules/
      }
    ]
  },
  resolve: {
    extensions: [
      '.js'
    ]
  }
};

module.exports = config;