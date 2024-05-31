import { useBlockProps } from '@wordpress/block-editor';
import { getOption } from '../../helpers/option';

export default function Edit() {
	return (
		<p { ...useBlockProps() }>
			{ getOption( 'wp_starter_plugin_greeting' ) }
		</p>
	);
}
