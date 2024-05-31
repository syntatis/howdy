<?php

declare(strict_types=1);

namespace WPStarterPlugin;

use function array_merge;
use function is_file;
use function WPStarterPlugin\Vendor\Syntatis\Utils\kebabcased;

class Enqueue
{
	/** @var array<string,array{url:string,handle:string,dependencies:string[],version:string|null,localized:bool}> */
	private array $scripts = [];

	/** @var array<string,array{handle:string,data:string,position:'after'|'before'}> */
	private array $inlineScripts = [];

	/** @var array<string,array{url:string,handle:string,dependencies:string[],version:string|null}> */
	private array $styles = [];

	/**
	 * Add script to enqueue.
	 *
	 * @param array{localized:bool,dependencies:array<string>} $options
	 */
	public function addScript(string $name, array $options = []): void
	{
		$manifest = $this->getManifest($name);

		$this->scripts[$name] = array_merge(
			$manifest,
			[
				'handle' => $manifest['handle'],
				'url' => $manifest['path'] . '.js',
				'localized' => $options['localized'] ?? false,
				'dependencies' => array_merge($manifest['dependencies'] ?? [], $options['dependencies'] ?? []),
			],
		);
	}

	public function addInlineScript(string $name, string $data, string $position = 'after'): void
	{
		$this->inlineScripts[$name] = [
			'handle' => kebabcased(WP_STARTER_PLUGIN_NAME . '-' . $name),
			'data' => $data,
			'position' => $position,
		];
	}

	/**
	 * Add stylesheet to enqueue.
	 *
	 * @param array{localized:bool,dependencies:array<string>} $options
	 */
	public function addStyle(string $name, array $options = []): void
	{
		$manifest = $this->getManifest($name);

		$this->styles[$name] = array_merge(
			$manifest,
			[
				'handle' => $manifest['handle'],
				'url' => $manifest['path'] . ( is_rtl() ? '-rtl' : '' ) . '.css',
				'dependencies' => $options['dependencies'] ?? [],
			],
		);
	}

	public function all(): void
	{
		$this->styles();
		$this->scripts();
		$this->inlineScripts();
	}

	private function scripts(): void
	{
		foreach ($this->scripts as $script) {
			wp_enqueue_script(
				$script['handle'],
				$script['url'],
				$script['dependencies'],
				$script['version'],
				true,
			);

			if (! $script['localized']) {
				continue;
			}

			wp_set_script_translations(
				$script['handle'],
				WP_STARTER_PLUGIN_NAME,
				plugin_dir_path(WP_STARTER_PLUGIN__DIR__) . 'languages',
			);
		}
	}

	private function inlineScripts(): void
	{
		foreach ($this->inlineScripts as $script) {
			if (! $script['data']) {
				continue;
			}

			wp_add_inline_script(
				$script['handle'],
				$script['data'],
				$script['position'],
			);
		}
	}

	private function styles(): void
	{
		foreach ($this->styles as $style) {
			wp_enqueue_style(
				$style['handle'],
				$style['url'],
				$style['dependencies'],
				$style['version'],
			);
		}
	}

	/** @return array<string,string|array<string>|null> */
	private function getManifest(string $name): array
	{
		$asset = [];
		$dist = 'dist/';
		$assetFile = WP_STARTER_PLUGIN__DIR__ . '/' . $dist . $name . '.asset.php';

		if (is_file($assetFile)) {
			$asset = include $assetFile;
		}

		$dependencies = $asset['dependencies'] ?? [];
		$version = $asset['version'] ?? null;

		return [
			'dependencies' => $dependencies,
			'version' => $version,
			'handle' => kebabcased(WP_STARTER_PLUGIN_NAME . '-' . $name),
			'path' => plugin_dir_url(WP_STARTER_PLUGIN__FILE__) . $dist . $name,
		];
	}
}
