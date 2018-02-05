<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 06.02.18
 * Time: 1:21
 */

namespace Src\Model;


class Format
{
    const CSV = 'csv';
    const JSON = 'json';

    private $format;

    public function __construct(string $format)
    {
        $this->format = ($format == self::CSV ? self::CSV : self::JSON);
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    public function isJson() : bool
    {
        return $this->format == self::JSON;
    }



}