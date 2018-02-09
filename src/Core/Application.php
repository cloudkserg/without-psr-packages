<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 17:26
 */

namespace Src\Core;


use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Src\Core\Config\Config;
use Src\Core\DI\Container;
use Src\Core\Log\Logger;

class Application
{




    /**
     * @var Logger
     */
    private $logger;
    /**
     * @var Config
     */
    private $config;


    public function __construct(Logger $logger, Config $config)
    {
        $this->logger = $logger;
        $this->config = $config;
    }


    public function listen()
    {
        $container = new Container($this->config);
        $dispatcher = new WebDispatcher($container);
        try {
            $dispatcher->dispatch();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage() . ": " . $e->getTraceAsString());
            throw $e;
        }
    }

}