<?php
$rootDir = './';

require $rootDir . '/vendor/autoload.php';

//load environment
$dotenv = new Dotenv\Dotenv($rootDir, '.env');
$dotenv->load();

//load config
$config = new \Src\Core\Config\Config($rootDir . '/config/config.php');

//dependencyInjection container
$container = (new \Src\DI\ContainerFactory())->create($config);

$service = $container->get(\Src\Service\CounterService::class);
$service->deleteExpiredDateCounters();
