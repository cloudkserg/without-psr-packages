<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 17:44
 */

namespace Src\Action;


use Src\Core\Response\JsonResponse;
use Src\Core\Response\ResponseInterface;
use Src\Request\IncrementRequest;
use Src\Service\CounterService;

class IncrementAction
{
    /**
     * @var CounterService
     */
    private $service;

    public function __construct(CounterService $service)
    {
        $this->service = $service;
    }


    public function handle($post) : ResponseInterface
    {
        $request = new IncrementRequest($post);
        $this->service->incrementsCounter($request->getCountry(), $request->getEvent());


        return new JsonResponse([]);
    }


}