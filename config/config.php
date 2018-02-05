<?php
$rootPath = dirname(__DIR__);

return [
    'name' => getenv('APP_NAME'),
    'middlewares' => [
       \Middlewares\FastRoute::class,
        \Middlewares\RequestHandler::class
    ],

    'log' => [
        'level' => 'warning',
        'path' => $rootPath . '/runtime/logs/application.log'
    ],

    'routes' => [
        ['GET', '/', \Src\Action\IndexAction::class],
        ['POST', '/', \Src\Action\IncrementAction::class],
    ],

    'counters' => [
        'lastDays' => 7,
        'topCountries' => 5
    ]
];
