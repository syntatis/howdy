import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';
import Edit from './edit.js';

registerBlockType( metadata.name, {
	edit: Edit,
} );
