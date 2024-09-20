import { useBlockProps } from '@wordpress/block-editor';
import { useSettings } from '../../settings/useSettings';

export default function Edit() {
	const { getOption } = useSettings();
	return (
		<p { ...useBlockProps() }>{ getOption( 'plugin_name_greeting' ) }</p>
	);
}
