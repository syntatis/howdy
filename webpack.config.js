const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );
// eslint-disable-next-line import/no-extraneous-dependencies
const glob = require( 'glob' );

/**
 * Generates an object of file entries based on the provided paths.
 *
 * @param {string[]} paths - An array of file paths.
 * @return {Object} - An object containing file entries.
 */
const fileEntries = ( paths ) => {
	const entries = {};
	paths.forEach( function ( filePath ) {
		const name = path
			.dirname( filePath )
			.split( '/' )
			.filter( ( value ) => value !== '.' && value !== 'src' )
			.map( ( value ) => value.toLowerCase() )
			.join( '-' );

		if ( ! name.startsWith( '_' ) ) {
			entries[ name ] = path.resolve( process.cwd(), filePath );
		}
	} );

	return entries;
};

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry(),
		...fileEntries( glob.sync( './src/components/*/index.js' ) ),
	},
};
