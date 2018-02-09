<?php
$rootDir = './';

//load config
$config = new \Src\Core\Config\Config($rootDir . '/config/config.php');

//dependencyInjection container
$container = new \Src\Core\DI\Container($config);
$service = $container->getCounterService();
$service->deleteExpiredDateCounters();
