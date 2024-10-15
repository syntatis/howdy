<?php

declare(strict_types=1);

/**
 * Plugin bootstrap file.
 *
 * This file is read by WordPress to display the plugin's information in the admin area.
 *
 * @wordpress-plugin
 * Plugin Name:       Plugin Name
 * Plugin URI:        https://example.org
 * Description:       The plugin short description.
 * Version:           0.1.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Author Name
 * Author URI:        https://example.org
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /inc/languages
 */

namespace PluginName;

use function defined;

// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

/**
 * Define the current version of the plugin.
 *
 * Following Semantic Versioning ({@link https://semver.org}) is encouraged.
 * It provides a clear understanding of the impact of changes between
 * versions.
 */
const PLUGIN_VERSION = '0.1.0';

/**
 * Define the directory path to the plugin file.
 *
 * This constant provides a convenient reference to the plugin's directory path,
 * useful for including or requiring files relative to this directory.
 */
const PLUGIN_DIR = __DIR__;

/**
 * Define the path to the plugin file.
 *
 * This path can be used in various contexts, such as managing the activation
 * and deactivation processes, loading the plugin text domain, adding action
 * links, and more.
 */
const PLUGIN_FILE = __FILE__;

/**
 * Load and initialize the WordPress plugin application.
 */
require PLUGIN_DIR . '/inc/bootstrap/app.php';
