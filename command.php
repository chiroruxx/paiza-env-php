<?php

require_once __DIR__ . '/vendor/autoload.php';

use Chiroruxx\PaizaEnvPhp\Commands\CompilePaizaCodeCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new CompilePaizaCodeCommand());
$application->run();
