const path = require( 'path' );
const webpack = require( 'webpack' );
const { createHash } = require( 'crypto' );
const { RawSource } = webpack.sources || require( 'webpack-sources' );
const DependencyExtractionWebpackPlugin = require('@wordpress/dependency-extraction-webpack-plugin');

const isWebpack4 = webpack.version.startsWith( '4.' );

function basename( name ) {
	if ( ! name.includes( '/' ) ) {
		return name;
	}
	return name.substr( name.lastIndexOf( '/' ) + 1 );
}

class CustomDependencyExtractionWebpackPlugin extends DependencyExtractionWebpackPlugin {
    addAssets(compilation, compiler) {
        const {
            combineAssets,
            combinedOutputFile,
            injectPolyfill,
            outputFormat,
        } = this.options;

        const combinedAssetsData = {};

        // Process each entry point independently.
        for (const [
            entrypointName,
            entrypoint,
        ] of compilation.entrypoints.entries()) {
            const entrypointExternalizedWpDeps = new Set();
            if (injectPolyfill) {
                entrypointExternalizedWpDeps.add('wp-polyfill');
            }

            const processModule = ({ userRequest }) => {
                if (this.externalizedDeps.has(userRequest)) {
                    const scriptDependency = this.mapRequestToDependency(
                        userRequest
                    );
                    entrypointExternalizedWpDeps.add(scriptDependency);
                }
            };

            // Search for externalized modules in all chunks.
            for (const chunk of entrypoint.chunks) {
                const modulesIterable = isWebpack4
                    ? chunk.modulesIterable
                    : compilation.chunkGraph.getChunkModules(chunk);
                for (const chunkModule of modulesIterable) {
                    processModule(chunkModule);
                    // loop through submodules of ConcatenatedModule
                    if (chunkModule.modules) {
                        for (const concatModule of chunkModule.modules) {
                            processModule(concatModule);
                        }
                    }
                }
            }

            const runtimeChunk = entrypoint.getRuntimeChunk();
            const assetData = {
                // Get a sorted array so we can produce a stable, stringified representation.
                dependencies: Array.from(entrypointExternalizedWpDeps).sort(),
                version: runtimeChunk.hash,
            };

            if( typeof this.options.env != 'undefined' ) {
                assetData.env = this.options.env;
            }
            if( typeof this.options.liveReloadPort != 'undefined' ) {
                assetData.liveReloadPort = this.options.liveReloadPort;
            }

            const assetString = this.stringify(assetData);

            // Determine a filename for the asset file.
            const [filename, query] = entrypointName.split('?', 2);
            const buildFilename = compilation.getPath(
                compiler.options.output.filename,
                {
                    chunk: runtimeChunk,
                    filename,
                    query,
                    basename: basename(filename),
                    contentHash: createHash('md4')
                        .update(assetString)
                        .digest('hex'),
                }
            );

            if (combineAssets) {
                combinedAssetsData[buildFilename] = assetData;
                continue;
            }

            const assetFilename = buildFilename.replace(
                /\.js$/i,
                '.asset.' + (outputFormat === 'php' ? 'php' : 'json')
            );

            // Add source and file into compilation for webpack to output.
            compilation.assets[assetFilename] = new RawSource(assetString);
            runtimeChunk.files[isWebpack4 ? 'push' : 'add'](assetFilename);
        }

        if (combineAssets) {
            // Assert the `string` type for output path.
            // The type indicates the option may be `undefined`.
            // However, at this point in compilation, webpack has filled the options in if
            // they were not provided.
            const outputFolder = /** @type {{path:string}} */ (compiler.options
                .output).path;

            const assetsFilePath = path.resolve(
                outputFolder,
                combinedOutputFile ||
                'assets.' + (outputFormat === 'php' ? 'php' : 'json')
            );
            const assetsFilename = path.relative(
                outputFolder,
                assetsFilePath
            );

            // Add source into compilation for webpack to output.
            compilation.assets[assetsFilename] = new RawSource(
                this.stringify(combinedAssetsData)
            );
        }
    }
}

module.exports = CustomDependencyExtractionWebpackPlugin