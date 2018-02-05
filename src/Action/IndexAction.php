<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 18:01
 */

namespace Src\Action;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Src\Formatter\CountriesFormatter;
use Src\Model\Format;
use Src\Request\IndexRequest;
use Src\Service\CounterService;
use Src\Service\TotalService;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\TextResponse;

class IndexAction implements RequestHandlerInterface
{
    /**
     * @var CounterService
     */
    private $service;

    /**
     * @var CountriesFormatter
     */
    private $formatter;
    /**
     * @var TotalService
     */
    private $totalService;

    public function __construct(CounterService $service, TotalService $totalService, CountriesFormatter $formatter)
    {
        $this->service = $service;
        $this->formatter = $formatter;
        $this->totalService = $totalService;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $format = (new IndexRequest($request))->getFormat();
        $topEventCountries = $this->totalService->getTopEventCountries();
        $counters = $this->service->getLastCounters($topEventCountries);

        if ($format->isJson()) {
            return new JsonResponse($this->formatter->format($counters));
        }
        return new TextResponse($this->formatter->formatCsv($counters));

    }


}