<?php
$rootDir = '.';

spl_autoload_register(function ($class) use ($rootDir) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    $file = $rootDir . '/' . str_replace('Src', 'src', $file);
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});

//load config
$config = new \Src\Core\Config\Config($rootDir . '/config/config.php');

//dependencyInjection container
$container = new \Src\Core\DI\Container($config);
$service = $container->getCounterService();
$service->deleteExpiredDateCounters();
