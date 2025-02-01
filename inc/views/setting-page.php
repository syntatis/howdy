<?php

/**
 * Template to render the plugin setting page root in WordPress admin area.
 * The form, inputs, buttons will be rendered with React components.
 *
 * @see ./app/SettingPage.php
 * @see ./src/setting-page/Page.jsx
 */

declare(strict_types=1);

use PluginName\Vendor\Codex\Facades\App;

?>
<div class="wrap">
	<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
	<div id="<?php echo esc_attr(App::name()); ?>-settings"></div>
	<noscript>
		<p>
			<?php esc_html_e('This setting page requires JavaScript to be enabled in your browser. Please enable JavaScript and reload the page.', 'plugin-name'); ?>
		</p>
	</noscript>
</div>
