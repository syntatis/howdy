<?php

/**
 * Service Providers Configuration
 *
 * Define an array of service provider classes that will be registered with
 * the plugin's service container. Service providers are responsible for
 * bootstrapping and configuring various plugin services.
 */

// If this file is called directly, abort.
if (! defined('ABSPATH')) {
	exit;
}

return [
	\PluginName\Vendor\Codex\Settings\Provider::class,
];
