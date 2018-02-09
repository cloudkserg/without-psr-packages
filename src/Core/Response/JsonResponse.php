<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 09.02.18
 * Time: 16:17
 */

namespace Src\Core\Response;


class JsonResponse implements ResponseInterface
{
    private $string;

    public function __construct($object)
    {
        $this->string = json_encode($object);
    }

    public function emit()
    {
        header('Content-Type: application/json');
        echo $this->string;
    }


}