<?php

declare(strict_types=1);

use Syntatis\Codex\Companion\Clients\PHPScoperInc;

require __DIR__ . '/vendor/autoload.php';

/**
 * Generate the PHP-Scoper configuration.
 */
return (new PHPScoperInc(__DIR__))->get();
