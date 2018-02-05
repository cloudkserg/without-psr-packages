<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 05.02.18
 * Time: 23:07
 */

namespace Src\Model;


class EventCountry
{

    private $event;

    private $country;


    public function __construct(Event $event, string $country)
    {
        $this->event = $event;
        $this->country = $country;
    }


    /**
     * @return Event
     */
    public function getEvent() : Event
    {
        return $this->event;
    }

    /**
     * @return string
     */
    public function getCountry() : string
    {
        return $this->country;
    }




}