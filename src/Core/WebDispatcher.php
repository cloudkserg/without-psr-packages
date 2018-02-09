<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 09.02.18
 * Time: 15:37
 */

namespace Src\Core;


use Src\Action\IncrementAction;
use Src\Action\IndexAction;
use Src\Core\DI\Container;
use Src\Core\Response\CsvResponse;
use Src\Core\Response\ResponseInterface;
use Src\Formatter\CountriesFormatter;

class WebDispatcher
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    public function dispatch()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = $this->callPost();
        } else {
            $response = $this->callGet();
        }

        $response->emit();
    }





    private function callPost() : ResponseInterface
    {
        $action = new IncrementAction($this->container->getCounterService());
        return $action->handle(file_get_contents('php://input'));
    }

    private function callGet() : ResponseInterface
    {


        $formatter = new CountriesFormatter();
        $action = new IndexAction(
            $this->container->getCounterService(),
            $this->container->getTotalService(),
            $formatter
        );
        return $action->handle($_GET);
    }

}