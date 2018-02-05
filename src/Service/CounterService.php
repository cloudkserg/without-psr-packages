<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 17:34
 */

namespace Src\Service;


use Carbon\Carbon;
use Src\Model\Counter;
use Src\Model\Event;
use Src\Model\EventCountry;
use Src\Repository\CounterRepository;
use Src\Repository\TotalRepository;

class CounterService
{

    /**
     * @var CounterRepository
     */
    private $repo;
    /**
     * @var TotalRepository
     */
    private $totalRepo;

    public function __construct(CounterRepository $repo, TotalRepository $totalRepo)
    {

        $this->repo = $repo;
        $this->totalRepo = $totalRepo;
    }


    public function incrementsCounter(string $country, Event $event)
    {
        $currentDate = new Carbon();
        $this->totalRepo->incrementsTotalCounter($country, $event);
        $this->repo->incrementsLastCounter($country, $event);
        $this->repo->incrementsDateCounter($country, $event, $currentDate);
    }



    /**
     * @param EventCountry[] $topCountries
     * @return Counter[]
     */
    public function getLastCounters(array $topCountries) : array
    {
        return $this->repo->getLastCounters($topCountries);
    }


    public function deleteExpiredDateCounters()
    {
        $lastDaysLimit = $this->repo->getLastDaysLimit();
        $date = Carbon::create()->subDays($lastDaysLimit);
        $this->repo->decrDateCounters($date);
    }

}
