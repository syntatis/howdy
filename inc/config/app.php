<?php

return [
	/**
	 * The plugin name.
	 *
	 * The plugin name config is required and has to be unique, since it will
	 * be used as an identifier for the plugin in various occasions, such
	 * as when enqueueing scripts and styles, registering settings, and
	 * more.
	 */
	'name' => 'plugin-name',

	/**
	 * The plugin text domain.
	 *
	 * The text domain will be used to translate the plugin's strings. It has
	 * to match with the text domain used in the plugin header.
	 */
	'text_domain' => 'plugin-name',

	/**
	 * The option name prefix.
	 *
	 * Prefixing the option name helps to avoid conflicts with other plugins,
	 * so make sure that it's very unique to the plugin.
	 */
	'option_prefix' => 'plugin_name_',

	/**
	 * The plugin blocks directory.
	 *
	 * The value defines the path to the directory where the blocks are added
	 * with each sub-directory representing a block. Each block should have
	 * a `block.json` file that defines the block's metadata, and their
	 * respective CSS, and JavaScript files already compiled.
	 *
	 * The value should be a relative path to the plugin's root directory.
	 *
	 * @see https://developer.wordpress.org/block-editor/getting-started/fundamentals/
	 */
	'blocks_path' => 'dist/assets',
];
