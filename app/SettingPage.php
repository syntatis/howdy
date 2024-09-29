<?php

declare(strict_types=1);

namespace PluginName;

use PluginName\Vendor\Codex\Contracts\Hookable;
use PluginName\Vendor\Codex\Facades\App;
use PluginName\Vendor\Codex\Foundation\Hooks\Hook;
use PluginName\Vendor\Codex\Settings\Settings;
use WP_REST_Request;

use function array_filter;
use function array_keys;
use function in_array;
use function sprintf;

use const ARRAY_FILTER_USE_KEY;

/**
 * The SettingPage class.
 *
 * This class serves as an example on how to manage the plugins settings.
 * It shows how to register the options, enqueuing the scripts and
 * the styles, and rendering the settings page. Feel free to
 * remove the class or modify it to suit your needs.
 */
class SettingPage implements Hookable
{
	private Settings $settings;

	public function __construct(Settings $settings)
	{
		$this->settings = $settings;
	}

	public function hook(Hook $hook): void
	{
		$hook->addAction('admin_menu', [$this, 'addMenu']);
		$hook->addAction('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
	}

	/**
	 * Add the settings menu on WordPress admin.
	 */
	public function addMenu(): void
	{
		add_submenu_page(
			'options-general.php', // Parent slug.
			__('Howdy Settings', 'plugin-name'),
			__('Howdy', 'plugin-name'),
			'manage_options',
			App::name(),
			[$this, 'render'],
		);
	}

	/**
	 * Render the plugin settings page.
	 *
	 * Called when user navigates to the plugin settings page. It will render
	 * only with these HTML. The settings form, inputs, buttons will be
	 * rendered with React components.
	 *
	 * @see ./src/settings/Page.jsx
	 */
	public function render(): void
	{
		// phpcs:disable Generic.Files.InlineHTML.Found
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
		<?php
		// phpcs:enable
	}

	/** @param string $adminPage The current admin page. */
	public function enqueueAdminScripts(string $adminPage): void
	{
		/**
		 * List of admin pages where the plugin scripts and stylesheet should load.
		 */
		$adminPages = [
			'settings_page_' . App::name(),
			'post.php',
			'post-new.php',
		];

		if (! in_array($adminPage, $adminPages, true)) {
			return;
		}

		$scriptHandle = App::name() . '-settings';
		$scriptAsset = include plugin_dir_path('/dist/settings/index.asset.php');

		wp_enqueue_style(
			$scriptHandle,
			plugin_dir_url('/dist/settings/index.css'),
			[],
			$scriptVersion ?? null,
		);

		wp_enqueue_script(
			$scriptHandle,
			plugin_dir_url('/dist/settings/index.js'),
			$scriptAsset['dependencies'] ?? [],
			$scriptVersion ?? null,
			true,
		);

		wp_add_inline_script(
			$scriptHandle,
			$this->getInlineScript(),
			'before',
		);

		wp_set_script_translations($scriptHandle, 'plugin-name');
	}

	/**
	 * Provide the inline script content.
	 */
	public function getInlineScript(): string
	{
		$request = new WP_REST_Request('GET', '/wp/v2/settings');
		$response = rest_do_request($request);

		/**
		 * Filter the response data to only include those registered in the plugin
		 * settings.
		 */
		$keys = array_keys($this->settings->get('general'));
		$data = array_filter(
			$response->get_data(),
			static fn ($key): bool => in_array($key, $keys, true),
			ARRAY_FILTER_USE_KEY,
		);

		return sprintf(
			'wp.apiFetch.use( wp.apiFetch.createPreloadingMiddleware( %s ) )',
			wp_json_encode(['/wp/v2/settings' => ['body' => $data]]),
		);
	}
}
