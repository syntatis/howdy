<?php

declare(strict_types=1);

use PluginName\Vendor\Codex\Settings\Setting;

/**
 * Defines the plugin options through WordPress Settings API.
 *
 * Defining the settings in this file requires `codex-settings-provider`.
 * It is wrapper around the WordPress Settings API to make registering
 * settings in WordPress easier and more readable.
 *
 * Each setting that is defined here will be registered in WordPress with
 * the Settings API and available in the `/wp/v1/settings` endpoint.
 *
 * Feel free modify it or add more settings to suit your needs.
 *
 * @see https://developer.wordpress.org/plugins/settings/settings-api/
 * @see https://github.com/syntatis/codex-settings-provider
 */
return [
	(new Setting('greeting'))
		->withDefault('Hello World!'),
];
