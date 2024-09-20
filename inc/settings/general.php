<?php

declare(strict_types=1);

use PluginName\Vendor\Codex\Foundation\Settings\Setting;
use PluginName\Vendor\Syntatis\Utils\Val;

/**
 * Defines the options to be used by the plugin. Aside the name and type,
 * each option may also define some constraints and default. Feel free
 * modify it to suit your needs.
 */
return [
	(new Setting('greeting'))
		->withDefault('Hello World!')
		->withConstraints(
			static fn (string $value) => Val::isBlank($value)
				? __('This field cannot be empty.', 'plugin-name')
				: true,
		),
];
