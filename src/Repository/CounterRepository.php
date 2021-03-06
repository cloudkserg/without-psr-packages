<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 17:39
 */

namespace Src\Repository;


use Src\Core\Config\Config;
use Src\Core\Redis\Client;
use Src\Model\Counter;
use Src\Model\Event;
use Src\Model\EventCountry;

class CounterRepository
{
    const DATE_KEY = 'counter:%s:%s:%s';

    const LAST_KEY = 'last:%s:%s';
    const LAST_LIMIT_CONFIG = 'counters.lastDays';

    /**
     * @var Client
     */
    private $client;

    private $lastLimit;




    public function __construct(Client $client, Config $config)
    {
        $this->lastLimit = (int)$config->get(self::LAST_LIMIT_CONFIG);
        $this->client = $client;
    }


    public function getLastDaysLimit()
    {
        return $this->lastLimit;
    }

    private function getDateTimeout() : int
    {
        return (($this->lastLimit + 1) * 24 * 60 * 60);
    }


    private function getLastKey(string $country, Event $event)
    {
        return sprintf(self::LAST_KEY, $country, (string)$event);
    }
    private function getDateKey(string $country, $event, \DateTime $date)
    {
        return sprintf(self::DATE_KEY, $country, (string)$event, $date->getTimestamp());
    }

    public function incrementsDateCounter(string $country, Event $event, \DateTime $date)
    {
        $key = $this->getDateKey($country, $event, $date);
        $this->client->incr($key);
        if ($key == 1) {
            $this->client->expire($key, $this->getDateTimeout());
        }
    }


    public function incrementsLastCounter(string $country, Event $event)
    {
        $key = $this->getLastKey($country, $event);
        $this->client->incr($key);
    }


    private function getLastCounterKeys(array $topCountries) : array
    {
        return array_map(function (EventCountry $country) {
            return $this->getLastKey($country->getCountry(), $country->getEvent());
        }, $topCountries);
    }



    private function getDateKeys(\DateTime $date) : array
    {
        return $this->client->keys($this->getDateKey('*', '*', $date));
    }


    private function buildCounters(array $eventCountries, array $values) : array
    {
        return array_map(function (EventCountry $eventCountry, $countryIndex) use ($values) {
            return new Counter(
                $eventCountry->getEvent(), $eventCountry->getCountry(), $values[$countryIndex]
            );
        }, $eventCountries, array_keys($eventCountries));
    }

    /**
     * @param EventCountry[] $topCountries
     * @return Counter[]
     */
    public function getLastCounters(array $topCountries) : array
    {
        $topCountryKeys = $this->getLastCounterKeys($topCountries);
        if (empty($topCountryKeys)) {
            return [];
        }
        $lastCounterValues = $this->client->mget($topCountryKeys);
        return $this->buildCounters($topCountries, $lastCounterValues);

    }

    public function decrDateCounters(\DateTime $date)
    {
        $dateKeys = $this->getDateKeys($date);
        if (empty($dateKeys)) {
            return;
        }

        $dateValues = $this->client->mget($dateKeys);
        foreach ($dateKeys as $dateIndex => $dateKey) {
            $counter = $this->buildDateCounter($dateKey, $dateValues[$dateIndex]);

            $lastKey = $this->getLastKey($counter->getCountry(), $counter->getEvent());
            $this->client->decrby($lastKey, $counter->getCount());
        }
    }

    private function buildDateCounter(string $dateKey, $value) : Counter
    {
        list($mask, $country, $type, $date) = explode(':', $dateKey);
        return new Counter(new Event($type), $country, (int)$value);
    }




}
