<?php
$rootPath = dirname(__DIR__);

return [
    'redis.string' => ['127.0.0.1', '6379'],

    'log.path' => $rootPath . '/runtime/logs/application.log',

    'counters.lastDays' => 7,
    'counters.topCountries' => 5
];
