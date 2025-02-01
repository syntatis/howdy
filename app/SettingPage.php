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
use function is_readable;
use function sprintf;

use const ARRAY_FILTER_USE_KEY;

/**
 * The `SettingPage` class.
 *
 * Serves as an example on how to manage the plugin setting. It shows how
 * to add a submenu on WordPress admin, enqueue the scripts and styles,
 * and rendering the setting page.
 *
 * Feel free to remove this or modify it to suit your needs.
 */
final class SettingPage implements Hookable
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
			static fn () => include_once App::dir('inc/views/setting-page.php'),
		);
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

		$handle = App::name() . '-settings';
		$assets = App::dir('dist/assets/setting-page/index.asset.php');
		$assets = is_readable($assets) ? require $assets : [];
		$version = $assets['version'] ?? null;
		$dependencies = $assets['dependencies'] ?? [];

		wp_enqueue_style(
			$handle,
			App::url('dist/assets/setting-page/index.css'),
			[],
			$version,
		);

		wp_enqueue_script(
			$handle,
			App::url('dist/assets/setting-page/index.js'),
			$dependencies,
			$version,
			true,
		);

		wp_add_inline_script(
			$handle,
			$this->getInlineScript(),
			'before',
		);

		wp_set_script_translations($handle, 'plugin-name');
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
