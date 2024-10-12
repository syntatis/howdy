/**
 * This hook serves as an example to use WordPress REST API to connect to
 * retrieve settings, handle the response, parse the error message and
 * update the state. Feel free to modify or remove it, if it doesn't
 * fit your needs.
 */

import apiFetch from '@wordpress/api-fetch';
import { useEffect, useState } from '@wordpress/element';

const preloaded = await apiFetch( {
	path: '/wp/v2/settings',
	method: 'GET',
} );

const filterValues = ( v ) => {
	// Remove any options that are not in the preloaded object.
	for ( const name in v ) {
		if ( ! Object.keys( preloaded ).includes( name ) ) {
			delete v[ name ];
		}
	}

	return v;
};

function parseExceptionMessage( errorString ) {
	const regex = /: \[(.*?)\] (.+) in/;
	const match = errorString.match( regex );

	if ( match ) {
		return { [ match[ 1 ] ]: match[ 2 ] };
	}

	return null;
}

export const useSettings = () => {
	const [ values, setValues ] = useState( preloaded );
	const [ status, setStatus ] = useState( null );
	const [ updating, setUpdating ] = useState( false );
	const [ errorMessages, setErrorMessages ] = useState( {} );

	/**
	 * @param {string} name The option name.
	 */
	function getOption( name ) {
		return values[ name ];
	}

	useEffect( () => {
		if ( updating ) {
			setErrorMessages( {} );
		}
	}, [ updating ] );

	const updateValues = ( newValues ) => {
		setUpdating( true );
		apiFetch( {
			path: '/wp/v2/settings',
			method: 'POST',
			data: newValues,
		} )
			.then( ( response ) => {
				setValues( filterValues( response ) );
				setStatus( 'success' );
			} )
			.catch( ( response ) => {
				const errorMessage = parseExceptionMessage(
					response?.data?.error?.message
				);
				setErrorMessages( ( currentErrorMessages ) => {
					if ( ! errorMessage ) {
						return;
					}

					return { ...currentErrorMessages, ...errorMessage };
				} );
				setStatus( 'error' );
			} )
			.finally( () => {
				setUpdating( false );
			} );
	};

	return {
		values,
		status,
		updating,
		errorMessages,
		updateValues( formData ) {
			const newValues = {};
			for ( const entry of formData.entries() ) {
				if ( Object.keys( preloaded ).includes( entry[ 0 ] ) ) {
					newValues[ entry[ 0 ] ] = entry[ 1 ];
				}
			}
			updateValues( newValues );
		},
		updateStatus: setStatus,
		getOption,
	};
};
