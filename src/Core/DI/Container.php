<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 09.02.18
 * Time: 16:01
 */

namespace Src\Core\DI;


use Src\Core\Config\Config;
use Src\Core\Redis\Client;
use Src\Repository\CounterRepository;
use Src\Repository\TotalRepository;
use Src\Service\CounterService;
use Src\Service\TotalService;

class Container
{

    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getConfig() : Config
    {
        return $this->config;
    }


    private function getRedis() : Client
    {
        return new Client($this->config);
    }

    public function getCounterService() : CounterService
    {
        $redis = $this->getRedis();
        $counterRepo = new CounterRepository($redis, $this->config);
        $totalRepo = new TotalRepository($redis);
        return new CounterService($counterRepo, $totalRepo);
    }

    public function getTotalService(): TotalService
    {
        $redis = $this->getRedis();
        $counterRepo = new CounterRepository($redis, $this->config);
        $totalRepo = new TotalRepository($redis);

        return new CounterService($counterRepo, $totalRepo);
    }


}