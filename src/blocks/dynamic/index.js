/**
 * Registers a new block provided a unique name and an object defining its
 * behaviors.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import Edit from './edit.js';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: Edit,
} );
