<?php

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder->useAutowiring(false);

$builder->addDefinitions(require __DIR__ . '/dependencies.php');

$container = $builder->build();

return $container;


