<?php

declare(strict_types=1);

namespace WPStarterPlugin;

use RecursiveDirectoryIterator;
use WPStarterPlugin\Vendor\Syntatis\WPHook\Contract\WithHook;
use WPStarterPlugin\Vendor\Syntatis\WPHook\Hook;

class Blocks implements WithHook
{
	private RecursiveDirectoryIterator $blocks;

	public function __construct()
	{
		$this->blocks = new RecursiveDirectoryIterator(
			WP_STARTER_PLUGIN__DIR__ . '/dist/blocks',
			RecursiveDirectoryIterator::SKIP_DOTS,
		);
	}

	public function hook(Hook $hook): void
	{
		$hook->addAction('init', fn () => $this->registerBlocks());
	}

	private function registerBlocks(): void
	{
		foreach ($this->blocks as $block) {
			if (! $block->isDir()) {
				continue;
			}

			register_block_type($block->getRealPath());
		}
	}
}
