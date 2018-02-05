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
use Src\Model\Format;

class IndexRequest
{


    private $format;



    public function __construct(ServerRequestInterface $request)
    {
        $query = $request->getQueryParams();

        $this->format = new Format(Format::JSON);
        if (isset($query['format'])) {
            $this->format = new Format($query['format']);
        }
    }

    /**
     * @return Format
     */
    public function getFormat(): Format
    {
        return $this->format;
    }





}