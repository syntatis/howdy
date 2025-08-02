<?php

declare(strict_types=1);

namespace PluginName;

use RecursiveDirectoryIterator;

use function is_dir;

/**
 * The `Blocks` class.
 *
 * Serves as the entry point for registering custom blocks in the plugin.
 *
 * Feel free to modify it to suit your needs.
 */
final class Blocks
{
	private RecursiveDirectoryIterator $blocks;

	public function __construct()
	{
		add_action('init', fn () => $this->registerBlocks());
	}

	private function registerBlocks(): void
	{
		if (! is_dir(PLUGIN_DIR . '/dist/assets')) {
			return;
		}

		$blocks = new RecursiveDirectoryIterator(
			PLUGIN_DIR . '/dist/assets',
			RecursiveDirectoryIterator::SKIP_DOTS,
		);

		foreach ($blocks as $block) {
			if (! $block->isDir()) {
				continue;
			}

			register_block_type($block->getRealPath());
		}
	}
}
