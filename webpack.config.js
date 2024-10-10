const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
// eslint-disable-next-line import/no-extraneous-dependencies
const glob = require( 'glob' );
const fs = require( 'fs' );

/**
 * Generates an object of file entries based on the provided paths.
 *
 * @param {string[]} paths - An array of file paths.
 * @return {Object} - An object containing file entries.
 */
const fileEntries = ( paths ) => {
	const entries = {};
	paths.forEach( function ( dirPath ) {
		const name = dirPath
			.split( '/' )
			.filter( ( value ) => value !== '.' && value !== 'src' )
			.join( '/' );

		if ( ! name.startsWith( '_' ) ) {
			const indexFile = [ 'index.tsx', 'index.ts', 'index.js' ]
				.map( ( fileName ) => path.join( dirPath, fileName ) )
				.find( ( filePath ) => fs.existsSync( filePath ) );

			if ( indexFile ) {
				entries[ `${ name }/index` ] = path.resolve(
					process.cwd(),
					indexFile
				);
			}
		}
	} );
	return entries;
};

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry(),
		...fileEntries( glob.sync( './src/*' ) ),
	},
};
