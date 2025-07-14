const { merge } = require("webpack-merge");
const commonConfig = require("./webpack.common");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

const host = 'new-start-theme.local'

module.exports = merge(commonConfig, {
  mode: 'development',
  devtool: 'inline-source-map',
  plugins: [
    new BrowserSyncPlugin({
      host: `${host}`, //Changes the name depending on the local domain of the project
      port: 3000,
      proxy: `http://${host}`, //Changes the name depending on the local domain of the project
      open: true
    })
  ]
});

