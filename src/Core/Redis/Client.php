<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 09.02.18
 * Time: 15:41
 */

namespace Src\Core\Redis;


use Src\Core\Config\Config;

class Client
{

    /**
     * @var \Redis
     */
    private $client;

    public function __construct(Config $config)
    {
        $redisString = $config->getRedisString();
        $this->client = new \Redis();
    }


    public function incr($key)
    {
        $this->client->incr($key);
    }


    public function expire($key, $timeout)
    {
        $this->client->expire($key, $timeout);
    }

    public function keys($template) : array
    {
        return $this->client->keys($template);
    }

    public function mget(array $keys) : array
    {
        return $this->client->mget($keys);
    }

    public function decrby($key, $count)
    {
        $this->client->decrBy($key, $count);
    }

    public function zincrby($key, $range, $field)
    {
        $this->client->zIncrBy($key, $range, $field);
    }

    public function zrevrange($key, $start, $limit) : array
    {
        return $this->client->zRevRange($key, $start, $limit);
    }


}