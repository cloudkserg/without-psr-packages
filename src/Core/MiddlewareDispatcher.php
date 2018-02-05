<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 23:02
 */

namespace Src\Core;


use Equip\Dispatch\MiddlewareCollection;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Log\LoggerInterface;
use Src\Core\Config\Config;
use Src\Core\Error\ErrorMiddleware;
use Src\Core\Error\NotFoundGenerator;
use Src\Core\Error\NotFoundMiddleware;
use Zend\Diactoros\Response;

class MiddlewareDispatcher
{
    const PATH_MIDDLEWARE_INDEX = 0;
    const CLASS_MIDDLEWARE_INDEX = 1;


    /**
     * @var Config
     */
    private $config;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var MiddlewareCollection
     */
    private $collection;

    public function __construct(Config $config, LoggerInterface $logger, ContainerInterface $container)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->container = $container;

        $this->collection = $this->createDispatcher();
    }


    private function createDispatcher()
    {
        $middlewares = array_merge(
            [$this->container->get(ErrorMiddleware::class)],
            $this->getConfigMiddlewares(),
            [$this->container->get(NotFoundMiddleware::class)]
        );
        return new MiddlewareCollection($middlewares);
    }


    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        return $this->collection->dispatch($request, function () {
            return (new NotFoundGenerator())->generateResponse('not found page');
        });
    }


    /**
     * @return MiddlewareInterface[]
     */
    private function getConfigMiddlewares() : array
    {
        return collect($this->config->getMiddlewares())->map(function ($middlewareClass) {
            return $this->createMiddleware($middlewareClass);
        })->toArray();
    }

    private function createMiddleware(string $middlewareClass) : MiddlewareInterface
    {
        $middleware = $this->container->get($middlewareClass);
        if (!$middleware instanceof MiddlewareInterface) {
            throw new \Exception('Not found middleware' . $middlewareClass);
        }

        return $middleware;
    }

}