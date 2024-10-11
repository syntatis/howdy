<?php

declare(strict_types=1);

namespace PluginName;

use PluginName\Vendor\Codex\Contracts\Extendable;
use PluginName\Vendor\Codex\Settings\Settings;
use PluginName\Vendor\Psr\Container\ContainerInterface;

/**
 * The `Plugin` class.
 *
 * Serves as the main entry point for plugin, handling the initialization
 * of core functionalities manages activation, deactivation and update
 * processes.
 */
class Plugin implements Extendable
{
	/**
	 * Provide the plugin's feature to instantiate.
	 *
	 * The `ContainerInstance` passed in this method is the service container
	 * that manages the "services" registered in the plugin. A service may
	 * be any value, like a string, a number, an object, or a "factory"
	 * that you can retrieve and pass on the classes or functions in
	 * the plugin that depends on the "service".
	 *
	 * @see https://www.php-fig.org/psr/psr-11/ For specification of the ContainerInterface.
	 *
	 * @param ContainerInstance $container The container instance.
	 *
	 * @return iterable<object>
	 */
	public function getInstances(ContainerInterface $container): iterable
	{
		yield new SettingPage($container->get(Settings::class));
	}
}
