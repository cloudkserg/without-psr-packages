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
    const REDIS_KEY = 'redis.string';

    private $config = [];

    public function __construct(string $configPath)
    {
        if (!file_exists($configPath)) {
            throw new \Exception('not exist config');
        }
        $this->config = require($configPath);
    }

    public function get($name, $default = null)
    {
        if (!isset($this->config[$name])) {
            return $default;
        }
        return $this->config[$name];
    }



    public function getRedisString()
    {
        return $this->get(self::REDIS_KEY);
    }


}