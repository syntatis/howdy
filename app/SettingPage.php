<?php

declare(strict_types=1);

namespace PluginName;

use WP_REST_Request;

use function in_array;
use function is_readable;
use function sprintf;

/**
 * The `SettingPage` class.
 *
 * Serves as an example on how to manage the plugin setting. It shows how
 * to add a submenu on WordPress admin, enqueue the scripts and styles,
 * and rendering the setting page.
 *
 * Feel free to remove this or modify it to suit your needs.
 */
final class SettingPage
{
	public function init(): void
	{
		add_action('admin_init', [$this, 'registerSettings']);
		add_action('rest_api_init', [$this, 'registerSettings']);
		add_action('admin_menu', [$this, 'addMenu']);
		add_action('admin_enqueue_scripts', [$this, 'enqueueAdminScripts']);
	}

	public function registerSettings(): void
	{
		register_setting(
			'plugin-name',
			'greeting',
			[
				'type' => 'string',
				'show_in_rest' => true,
				'sanitize_callback' => 'sanitize_text_field',
				'default' => 'Hello World!',
			],
		);
	}

	/**
	 * Add the settings menu on WordPress admin.
	 */
	public function addMenu(): void
	{
		add_submenu_page(
			'options-general.php', // Parent slug.
			__('Plugin Name Settings', 'plugin-name'),
			__('Plugin Name', 'plugin-name'),
			'manage_options',
			'plugin-name',
			static fn () => include_once PLUGIN_DIR . '/inc/views/setting-page.php',
		);
	}

	/** @param string $adminPage The current admin page. */
	public function enqueueAdminScripts(string $adminPage): void
	{
		/**
		 * List of admin pages where the plugin scripts and stylesheet should load.
		 */
		$adminPages = [
			'settings_page_plugin-name',
			'post.php',
			'post-new.php',
		];

		if (! in_array($adminPage, $adminPages, true)) {
			return;
		}

		$handle = 'plugin-name';
		$assets = PLUGIN_DIR . '/dist/assets/setting-page/index.asset.php';
		$assets = is_readable($assets) ? require $assets : [];
		$version = $assets['version'] ?? null;
		$dependencies = $assets['dependencies'] ?? [];

		wp_enqueue_style(
			$handle,
			plugin_dir_url(PLUGIN_FILE) . '/dist/assets/setting-page/index.css',
			[],
			$version,
		);

		wp_enqueue_script(
			$handle,
			plugin_dir_url(PLUGIN_FILE) . '/dist/assets/setting-page/index.js',
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
	 * Load the inital data to show on the admin page.
	 */
	public function getInlineScript(): string
	{
		$request = new WP_REST_Request('GET', '/wp/v2/settings');
		$response = rest_do_request($request);
		$data = $response->get_data();

		return sprintf(
			'wp.apiFetch.use( wp.apiFetch.createPreloadingMiddleware( %s ) )',
			wp_json_encode([
				'/wp/v2/settings' => [
					'body' => [
						'greeting' => $data['greeting'],
					],
				],
			]),
		);
	}
}
