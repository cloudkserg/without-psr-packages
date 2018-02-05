<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 16:19
 */

namespace Src\Core\Config;


class Config
{

    const PROD_MODE = 'production';
    const MIDDLEWARE_KEY = 'middlewares';
    const ROUTES_KEY = 'routes';

    private $config;

    public function __construct(string $configPath)
    {
        $this->config = new \Noodlehaus\Config($configPath);
    }

    public function get($name, $default = null)
    {
        return $this->config->get($name, $default);
    }

    public function getMiddlewares()
    {
        return $this->config->get(self::MIDDLEWARE_KEY, []);
    }

    public function getRoutes()
    {
        return $this->config->get(self::ROUTES_KEY, []);
    }

    public function isDev()
    {
        return (getenv('ENV') !== self::PROD_MODE);
    }

    public function getRedisString()
    {
        return getenv('REDIS_STRING');
    }


}