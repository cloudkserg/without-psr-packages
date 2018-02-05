<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 06.02.18
 * Time: 0:00
 */

namespace Src\Repository;



use Predis\Client;
use Src\Collection\TopCountryCollection;
use Src\Core\Config\Config;
use Src\Model\Event;
use Src\Model\EventCountry;

class TotalRepository
{
    const TOTAL_KEY = 'total:%s';


    /**
     * @var Client
     */
    private $client;


    public function __construct(Client $client)
    {

        $this->client = $client;
    }

    private function getTotalKey($event)
    {
        return sprintf(self::TOTAL_KEY, (string)$event);
    }


    public function incrementsTotalCounter(string $country, Event $event)
    {
        $key = $this->getTotalKey($event);
        $this->client->zincrby($key, 1, $country);
    }


    /**
     * @return EventCountry[]
     */
    public function getEventCountries(Event $event, int $limitTopCountries) : array
    {
        $countries = $this->client->zrevrange($this->getTotalKey($event), 0, $limitTopCountries);
        return $this->buildEventCountries($event, $countries);
    }

    private function buildEventCountries(Event $event, array $countries) : array
    {
        return collect($countries)->map(function ($country) use ($event) {
            return new EventCountry($event, $country);
        })->toArray();
    }

}