<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 18:01
 */

namespace Src\Action;


use Src\Core\Response\CsvResponse;
use Src\Core\Response\JsonResponse;
use Src\Core\Response\ResponseInterface;
use Src\Formatter\CountriesFormatter;
use Src\Model\Format;
use Src\Request\IndexRequest;
use Src\Service\CounterService;
use Src\Service\TotalService;

class IndexAction
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


    public function handle(array $get) : ResponseInterface
    {
        $format = (new IndexRequest($get))->getFormat();
        $topEventCountries = $this->totalService->getTopEventCountries();
        $counters = $this->service->getLastCounters($topEventCountries);

        if ($format->isJson()) {
            return new JsonResponse($this->formatter->format($counters));
        }
        return new CsvResponse($this->formatter->formatCsv($counters));

    }


}