<?php

require_once __DIR__ . '/vendor/autoload.php';

use Chiroruxx\PaizaEnvPhp\Commands\CompilePaizaCodeCommand;
use Chiroruxx\PaizaEnvPhp\Commands\MakeStubCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new CompilePaizaCodeCommand());
$application->add(new MakeStubCommand());
$application->run();
