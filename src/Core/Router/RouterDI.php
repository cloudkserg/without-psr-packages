<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 23:11
 */

namespace Src\Core\Router;


use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Psr\Container\ContainerInterface;
use Src\Core\Config\Config;
use Zend\Diactoros\Request;

class RouterDI
{
    const METHOD_ROUTE_INDEX = 0;
    const PATH_ROUTE_INDEX = 1;
    const HANDLER_ROUTE_INDEX = 2;


    public function getDI()
    {
        return [
            Dispatcher::class => function ($c) {
                $routes = $c->get(Config::class)->getRoutes();
                return simpleDispatcher(function (RouteCollector $r) use ($routes, $c) {
                    $this->addRoutes($r, $routes, $c);
                });
            }
        ];
    }


    private function addRoutes(RouteCollector &$r, array $routes, ContainerInterface $container)
    {
        collect($routes)->each(function (array $route) use (&$r, $container) {
            $handler = $container->get($route[self::HANDLER_ROUTE_INDEX]);
            $r->addRoute(
                $route[self::METHOD_ROUTE_INDEX],
                $route[self::PATH_ROUTE_INDEX],
                $handler
            );
        });
    }

}