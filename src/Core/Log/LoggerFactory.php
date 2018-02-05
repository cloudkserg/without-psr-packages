<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 15:59
 */

namespace Src\Core\Log;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Src\Core\Config\Config;

class LoggerFactory
{
    const LOGGER_NAME = 'default';
    const LOG_LEVEL_PARAM = 'log.level';
    const LOG_PATH_PARAM = 'log.path';
    
    public static function create(Config $config) : LoggerInterface
    {
        $logger =  new Logger(self::LOGGER_NAME);
        $logger->pushHandler(new StreamHandler(
            $config->get(self::LOG_PATH_PARAM),
            $config->get(self::LOG_LEVEL_PARAM)
        ));

        return $logger;
    }

}