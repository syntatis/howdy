<?php

declare(strict_types=1);

namespace PluginName;

use IteratorAggregate;
use Traversable;

/**
 * The `Plugin` class.
 *
 * Serves as the main entry point for plugin, handling the initialization
 * of core functionalities manages activation, deactivation and update
 * processes.
 *
 * Feel free to modify it to suit your needs.
 */
final class Plugin implements IteratorAggregate
{
	private string $basename;

	public function __construct()
	{
		load_plugin_textdomain('plugin-name', false, plugin_basename(PLUGIN_FILE) . '/inc/languages/');
		register_activation_hook(PLUGIN_FILE, fn () => $this->activate());
		register_deactivation_hook(PLUGIN_FILE, fn () => $this->deactivate());
	}

	/**
	 * Return a list of object to initialize.
	 *
	 * @return Traversable<object>
	 */
	public function getIterator(): Traversable
	{
		yield new Blocks();
		yield new SettingPage();
	}

	/**
	 * Perform actions required when the plugin is activated.
	 *
	 * @see https://developer.wordpress.org/plugins/plugin-basics/activation-deactivation-hooks/
	 * @see https://developer.wordpress.org/reference/functions/register_activation_hook/
	 */
	private function activate(): void
	{
		/**
		 * Do something, such as creating database tables, performing compatibility checks,
		 * adding options, and flushing caches.
		 */
	}

	/**
	 * Perform actions required when the plugin is deactivated.
	 *
	 * @see https://developer.wordpress.org/plugins/plugin-basics/activation-deactivation-hooks/
	 * @see https://developer.wordpress.org/reference/functions/register_deactivation_hook/
	 */
	private function deactivate(): void
	{
		/**
		 * Do something, such as flushing caches and permalinks.
		 */
	}
}
