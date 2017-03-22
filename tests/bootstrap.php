<?php

use Nette\Configurator;
use Tester\Environment;

require __DIR__ . '/../vendor/autoload.php';

Environment::setup();

$configurator = new Configurator();
$configurator->setDebugMode(false);
$configurator->setTempDirectory(__DIR__ . '/../temp');
$configurator->createRobotLoader()
    ->addDirectory(__DIR__)
    ->addDirectory(__DIR__ . '/../src')
    ->register();

$configurator->addConfig(__DIR__ . '/Config/config.local.neon');
return $configurator->createContainer();
