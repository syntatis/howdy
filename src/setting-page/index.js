import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import { Page } from './Page';

domReady( () => {
	const container = document.querySelector( '#plugin-name-settings' );
	if ( container ) {
		createRoot( container ).render( <Page /> );
	}
} );
