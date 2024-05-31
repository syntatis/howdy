<?php

// phpcs:disable -- Generic.Files.InlineHTML.Found

declare(strict_types=1);

namespace WPStarterPlugin;

use WPStarterPlugin\Vendor\Syntatis\WPHook\Contract\WithHook;
use WPStarterPlugin\Vendor\Syntatis\WPHook\Hook;
use WPStarterPlugin\Vendor\Syntatis\WPOption\Option;
use WPStarterPlugin\Vendor\Syntatis\WPOption\Registry;

/**
 * This class manages the plugin's settings, including their registration,
 * loading, and rendering within the WordPress admin interface. It handles
 * options initialization, enqueuing scripts and styles, and integrating
 * with the WordPress REST API.
 */
class Settings implements WithHook
{
	private Enqueue $enqueue;

	private Registry $registry;

	/**
     * The option name prefix used to ensure unique and consistent option names.
     */
	private string $optionPrefix = 'wp_starter_plugin_';

	/**
     * The group name for registering plugin settings.
     *
     * @see https://developer.wordpress.org/reference/functions/register_setting/
     */
	private string $group = 'wp_starter_plugin';

	/**
     * The filename of the distribution files (JavaScript and Stylesheet) for the
	 * settings page.
     */
	private string $distFile = 'components-settings';

	/**
     * The initial settings values loaded on page load. Defaults are used if not
	 * set in the database.
     */
	private ?string $values = null;

	public function __construct(Enqueue $enqueue)
	{
		/**
         * Define the plugin options and their default values in the registry.
         * This ensures options are correctly stored, retrieved, and defaulted.
         */
		$this->registry = new Registry([
			(new Option('greeting', 'string'))
				->setDefault('Hello World!')
				->apiEnabled(true)
		]);
		$this->registry->setPrefix($this->optionPrefix);
		$this->enqueue = $enqueue;
	}

	/**
	 * @inheritDoc
	 */
	public function hook(Hook $hook): void
	{
		$register = fn () => $this->registerSettings();
	
		$hook->addAction('rest_api_init', $register);
		$hook->addAction('admin_init', $register);
		$hook->addAction('admin_menu', fn () => $this->addMenu());
		$hook->addAction('admin_enqueue_scripts', fn (string $hook) => $this->enqueueScripts($hook));

		$this->registry->hook($hook);
	}

	/**
     * Add the settings menu to the WordPress admin interface.
     */
	private function addMenu(): void
	{
		add_submenu_page(
			'options-general.php', // Parent slug.
			__('Starter Plugin Settings', 'wp-starter-plugin'),
			__('Starter Plugin', 'wp-starter-plugin'),
			'manage_options',
			WP_STARTER_PLUGIN_NAME,
			fn () => $this->renderPage(),
		);
	}

	 /**
     * Enqueue scripts and styles for the settings page.
     *
     * @param string $adminPage The current admin page.
     */
	private function enqueueScripts(string $adminPage): void
	{
		if (
			$adminPage === 'settings_page_' . WP_STARTER_PLUGIN_NAME ||
			$adminPage === 'post.php' ||
			$adminPage === 'post-new.php'
		) {
			$this->enqueue->addStyle($this->distFile);
			$this->enqueue->addScript($this->distFile);
			$this->enqueue->addInlineScript(
				$this->distFile,
				'window.__wpStarterPlugin = Object.assign(window.__wpStarterPlugin||{},{"settings":' . $this->values . '})',
				'before'
			);
			$this->enqueue->all();
		}
	}

	private function registerSettings(): void
	{
		$this->registry->register($this->group);
		$this->values = json_encode($this->registry);
	}

	private function renderPage(): void
	{
		if (! current_user_can('manage_options')) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<div id="wp-starter-plugin-settings"></div>
		</div>
		<?php
	}
}
