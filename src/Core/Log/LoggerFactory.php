<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 15:59
 */

namespace Src\Core\Log;



use Src\Core\Config\Config;

class LoggerFactory
{
    const LOG_PATH_PARAM = 'log.path';
    
    public static function create(Config $config) : Logger
    {
        $logger =  new Logger($config->get(self::LOG_PATH_PARAM));
        return $logger;
    }

}