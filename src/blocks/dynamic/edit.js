/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import { useSettings } from '../../settings/useSettings';

export default function Edit() {
	const { getOption } = useSettings();
	return (
		<p { ...useBlockProps() }>{ getOption( 'plugin_name_greeting' ) }</p>
	);
}
