<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 09.02.18
 * Time: 16:17
 */

namespace Src\Core\Response;


class CsvResponse implements ResponseInterface
{
    private $string;

    public function __construct(string $objects)
    {
        $this->string = $objects;
    }

    public function emit()
    {
        header('Content-Type: application/text');
        echo $this->string;
    }

}