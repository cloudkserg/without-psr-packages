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

class Application
{

    /**
     * @var Config
     */
    private $config;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MiddlewareDispatcher
     */
    private $dispatcher;

    /**
     * Application constructor.
     * @param ContainerInterface $container
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->config = $container->get(Config::class);
        $this->logger = $container->get(LoggerInterface::class);

        $this->dispatcher = $this->container->get(MiddlewareDispatcher::class);
    }


    public function listen()
    {
        if ($this->config->isDev()) {
            error_reporting(E_ALL ^ E_NOTICE);
            ini_set('display_errors', true);
        }


        $server = \Zend\Diactoros\Server::createServer($this->dispatcher, $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
        $server->listen();

    }

}