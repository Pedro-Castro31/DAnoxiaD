<?php

declare(strict_types=1);

// Ensure the working directory is always the project root (anoxia/),
// regardless of where PHPUnit was invoked from (e.g. IDE runners that
// launch from the repo root instead of the subdirectory).
chdir(dirname(__DIR__));

require 'vendor/codeigniter4/framework/system/Test/bootstrap.php';
