/**
 * `useBlockProps` hook helps manage and apply essential props on the block
 * wrapper element, such as the class names, styles, and other attributes.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import { useSettings } from '../setting-page/useSettings';

export default function Edit() {
	const { getOption } = useSettings();
	return (
		<p { ...useBlockProps() }>{ getOption( 'greeting' ) }</p>
	);
}
