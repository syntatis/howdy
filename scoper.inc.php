<?php

declare(strict_types=1);

use Syntatis\Codex\Companion\Clients\PHPScoperInc;

require __DIR__ . '/vendor/autoload.php';

return (new PHPScoperInc(__DIR__))
	->getAll();
