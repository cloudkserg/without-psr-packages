<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 17:06
 */

namespace Src\Model;


use Carbon\Carbon;

class Counter
{



    /**
     * @var Event
     */
    private $event;

    /**
     * @var int
     */
    private $count;

    /**
     * @var string
     */
    private $country;


    public function __construct(Event $event, string $country, int $count)
    {
        $this->event = $event;
        $this->country = $country;
        $this->count = $count;
    }


    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }







}