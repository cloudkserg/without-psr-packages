<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 17:03
 */

namespace Src\Model;


use Src\Core\Exception\ValidateException;

class Event
{

    const TYPES = ['view', 'play', 'click'];


    private $type;


    public static function createTypes() : array
    {
        return array_map(function ($type) { return new self($type); }, self::TYPES);
    }

    public function __construct($type)
    {
        if (!in_array($type, self::TYPES)) {
            throw new ValidateException('not valid event type for Event');
        }
        $this->type = $type;
    }


    public function __toString()
    {
        return $this->type;
    }

}
