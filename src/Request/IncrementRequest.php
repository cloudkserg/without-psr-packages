<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 17:48
 */

namespace Src\Request;


use Psr\Http\Message\ServerRequestInterface;
use Src\Core\Exception\ValidateException;
use Src\Model\Event;

class IncrementRequest
{


    private $country;

    private $event;


    public function __construct(ServerRequestInterface $request)
    {
        $params = $this->parse($request->getBody()->getContents());

        $this->country = $params['country'];
        $this->event = new Event($params['event']);
    }


    private function parse(string $body) : array
    {
        try {
            $params = (array)json_decode($body);
        } catch(\Exception $e) {
            throw new ValidateException('not decode json body');
        }
        if (!isset($params['country']) or !isset($params['event'])) {
            throw new ValidateException('Не заданы верные параметры');
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }



}