<?php

declare(strict_types=1);

namespace PluginName;

use function trim;

/**
 * Retrieve the path to a file or directory within the plugin.
 *
 * @param string $path The path to a file or directory within the plugin, added with leading slash e.g. `/dist`.
 *
 * @return string The full path to the file or directory, withtout the trailingslash
 *                e.g. `/wp-content/plugins/plugin-name/dist`.
 */
function plugin_dir_path(string $path = ''): string
{
	$path = trim($path);

	if ($path === '') {
		return PLUGIN_DIR;
	}

	return untrailingslashit(wp_normalize_path(PLUGIN_DIR . $path));
}

/**
 * Retrieve the URL to a file or directory within the plugin.
 *
 * @param string $path The path to a file or directory within the plugin, added with leading slash e.g. `/dist`.
 *
 * @return string The full URL to the file or directory, withtout the trailingslash
 *                e.g. `https://example.com/wp-content/plugins/plugin-name/dist`.
 */
function plugin_dir_url(string $path = ''): string
{
	$dirUrl = plugins_url('', PLUGIN_FILE);
	$path = trim($path);

	if ($path !== '') {
		$dirUrl .= $path;
	}

	return untrailingslashit($dirUrl);
}
