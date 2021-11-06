const { join } = require("path");
const webpack = require("webpack");

// Set default entry before loading wp webpack.config
process.env.WP_ENTRY = JSON.stringify({ index: join(__dirname, "src/index.ts") });

/** @type {webpack.Configuration} */
const config = require("@wordpress/scripts/config/webpack.config");
const CustomDependencyExtractionWebpackPlugin = require('./scripts/custom-dependency-extraction-plugin');

// Add Shortcut import path @/ as src/
config.resolve = config.resolve || {};
config.resolve.extensions = config.resolve.extensions || [];
config.resolve.extensions.push('.ts', '.tsx', '.js', '.jsx');
config.resolve.alias = config.resolve.alias || {};
config.resolve.alias['@'] = join(__dirname, 'src');

// Disable source map
delete config.devtool;

// Add ts & tsx support
const babelLoader = config.module.rules.find(v => v.test instanceof RegExp && v.test.test('.jsx'));
if (babelLoader) {
    babelLoader.test = /\.t|jsx?/
}

// Add custom options to start liveReload
const liveReload = config.plugins.find((v) => v.constructor.name == 'LiveReloadPlugin');
if (liveReload) {
    const idx = config.plugins.findIndex((v) => v.constructor.name == 'DependencyExtractionWebpackPlugin');
    config.plugins.splice(idx, 1, new CustomDependencyExtractionWebpackPlugin({
        // injectPolyfill: true,
        // outputFormat: 'json',
        liveReloadPort: liveReload.options.port
    }))
}



module.exports = config;