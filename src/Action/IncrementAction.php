<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 17:44
 */

namespace Src\Action;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Request\IncrementRequest;
use Src\Service\CounterService;
use Zend\Diactoros\Response\JsonResponse;

class IncrementAction implements RequestHandlerInterface
{
    /**
     * @var CounterService
     */
    private $service;

    public function __construct(CounterService $service)
    {
        $this->service = $service;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $request = new IncrementRequest($request);
        $this->service->incrementsCounter($request->getCountry(), $request->getEvent());


        return new JsonResponse([]);
    }


}