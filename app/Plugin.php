<?php

declare(strict_types=1);

namespace PluginName;

use PluginName\Vendor\Codex\Contracts\Extendable;
use PluginName\Vendor\Psr\Container\ContainerInterface;

/**
 * The Plugin class.
 *
 * Serves as the main entry point for plugin, handling the initialization
 * of core functionalities manages activation, deactivation, and update
 * processes.
 */
class Plugin implements Extendable
{
	/**
	 * Provide the plugin's feature to instantiate.
	 *
	 * @return iterable<object>
	 */
	public function getInstances(ContainerInterface $container): iterable
	{
		yield new Settings();
	}
}
