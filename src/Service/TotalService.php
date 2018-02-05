<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 18:10
 */

namespace Src\Service;
use Src\Core\Config\Config;
use Src\Model\Event;

use Src\Model\EventCountry;
use Src\Repository\TotalRepository;

class TotalService
{
    const MAX_COUNTRIES_CONFIG = 'counters.topCountries';

    /**
     * @var TotalRepository
     */
    private $totalRepo;
    /**
     * @var Config
     */
    private $config;


    /**
     * TotalService constructor.
     * @param TotalRepository $totalRepo
     * @param Config $config
     */
    public function __construct(TotalRepository $totalRepo, Config $config)
    {
        $this->totalRepo = $totalRepo;
        $this->config = $config;
    }


    /**
     * @return EventCountry[]
     */
    public function getTopEventCountries() : array
    {
        $limitTopCountries = (int)$this->config->get(self::MAX_COUNTRIES_CONFIG) - 1;


        return collect(Event::createTypes())->reduce(
            function (array $eventCountries, Event $event) use ($limitTopCountries) {
                return array_merge($eventCountries,
                    $this->totalRepo->getEventCountries($event, $limitTopCountries)
                );
            }, []
        );
    }



}
