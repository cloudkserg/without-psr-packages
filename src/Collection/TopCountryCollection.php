<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 05.02.18
 * Time: 23:38
 */

namespace Src\Collection;


use Src\Model\Event;
use Src\Model\EventCountry;

class TopCountryCollection
{

    private $countries;


    /**
     * TopCountryCollection constructor.
     * @param EventCountry[] $flatCountries
     */
    public function __construct(array $flatCountries)
    {
        $this->countries = $this->buildCountriesbyEvent($flatCountries);
    }


    private function buildCountriesbyEvent(array $flatCountries) : array
    {
        return collect($flatCountries)->reduce(
            function (array $collection, EventCountry $eventCountry) {
                $collection[(string)$eventCountry->getEvent()] = $eventCountry;
            }, []
        );
    }

    public function getCountriesByEvent(Event $event) : array
    {
        return $this->countries[(string) $event] ?? [];
    }
}