import apiFetch from '@wordpress/api-fetch';
import { __ } from '@wordpress/i18n';
import { useState } from 'react';
import { getAllOptions } from '../../helpers/option';

const REGISTERED_SETTINGS = [ 'wp_starter_plugin_greeting' ];

const filterValues = ( values ) => {
	for ( const name in values ) {
		if ( ! REGISTERED_SETTINGS.includes( name ) ) {
			delete values[ name ];
		}
	}

	return values;
};

export const useSettings = () => {
	const [ values, setValues ] = useState( getAllOptions() );
	const [ status, setStatus ] = useState();
	const [ statusText, setStatusText ] = useState();

	const updateValues = ( newValues ) => {
		setStatus( 'updating' );
		apiFetch( {
			path: '/wp/v2/settings',
			method: 'POST',
			data: newValues,
		} )
			.then( ( response ) => {
				setValues( filterValues( response ) );
			} )
			.catch( () => {
				setStatusText(
					__( 'Error updating settings.', 'wp-starter-plugin' )
				);
				setStatus( 'error' );
			} )
			.then( () => {
				setStatusText( __( 'Settings updated.', 'wp-starter-plugin' ) );
				setStatus( 'success' );
			} );
	};

	return {
		values,
		status,
		statusText,
		updateValues( formData ) {
			const newValues = {};
			for ( const entry of formData.entries() ) {
				if ( REGISTERED_SETTINGS.includes( entry[ 0 ] ) ) {
					newValues[ entry[ 0 ] ] = entry[ 1 ];
				}
			}
			updateValues( newValues );
		},
		updateStatus: setStatus,
	};
};
