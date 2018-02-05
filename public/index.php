<?php
$rootPath = dirname(__DIR__);
require_once($rootPath . '/vendor/autoload.php');

//load environment
$dotenv = new Dotenv\Dotenv($rootPath);
$dotenv->load();

//load config
$config = new \Src\Core\Config\Config($rootPath . '/config/config.php');

//dependencyInjection container
$container = (new \Src\DI\ContainerFactory())->create($config);

//core
$app = new \Src\Core\Application($container);
$app->listen();



