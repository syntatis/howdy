import {
	Button,
	Notice,
	Spinner,
	TextField,
} from '@syntatis/wp-classic-components';
import { __ } from '@wordpress/i18n';
import { useSettings } from './useSettings';
import { getOption } from '../../helpers/option';

export const Form = () => {
	const { status, statusText, updateStatus, updateValues, values } =
		useSettings();
	const isUpdating = status === 'updating';

	if ( ! values ) {
		return;
	}

	return (
		<>
			{ ! isUpdating && status && statusText && (
				<Notice
					isDismissable
					level={ status }
					onDismiss={ () => updateStatus( null ) }
				>
					{ statusText }
				</Notice>
			) }
			<form
				method="POST"
				onSubmit={ ( event ) => {
					event.preventDefault();
					updateStatus( null );
					updateValues( new FormData( event.target ) );
				} }
			>
				<fieldset disabled={ isUpdating }>
					<table className="form-table" role="presentation">
						<tbody>
							<tr>
								<th
									id="wp-starter-plugin-settings-greeting"
									scope="row"
								>
									{ __( 'Greeting', 'wp-starter-plugin' ) }
								</th>
								<td>
									<TextField
										aria-labelledby="wp-starter-plugin-settings-greeting"
										className="regular-text"
										defaultValue={ getOption(
											'wp_starter_plugin_greeting'
										) }
										name="wp_starter_plugin_greeting"
									/>
								</td>
							</tr>
						</tbody>
					</table>
				</fieldset>
				<div className="submit">
					<Button
						isDisabled={ isUpdating }
						prefix={ isUpdating && <Spinner /> }
						type="submit"
					>
						{ isUpdating
							? __( 'Updating Settings', 'wp-starter-plugin' )
							: __( 'Update Settings', 'wp-starter-plugin' ) }
					</Button>
				</div>
			</form>
		</>
	);
};
