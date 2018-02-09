<?php
$rootPath = dirname(__DIR__);

spl_autoload_register(function ($class) use ($rootPath) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    $file = $rootPath . '/' . str_replace('Src', 'src', $file);
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});


//load config
$config = new \Src\Core\Config\Config($rootPath . '/config/config.php');


$logger = \Src\Core\Log\LoggerFactory::create($config);
$application = new \Src\Core\Application($logger, $config);
$application->listen();



