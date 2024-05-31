import domReady from '@wordpress/dom-ready';
import { createRoot } from 'react-dom/client';
import { Form } from './Form';

const container = document.querySelector( '#wp-starter-plugin-settings' );

if ( container ) {
	domReady( () => createRoot( container ).render( <Form /> ) );
}
