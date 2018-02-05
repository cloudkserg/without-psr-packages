<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 18:16
 */

namespace Src\Core\Error;


use Psr\Http\Message\ResponseInterface;
use Src\Core\Exception\NotFoundException;
use Zend\Diactoros\Response;

class NotFoundGenerator
{
    const CODE = '404';
    const MESSAGE = 'Page not found';

    public function generateResponse($message) :ResponseInterface
    {
        $response = new Response();
        $response->withStatus(self::CODE, self::MESSAGE);
        $response->getBody()->write(self::MESSAGE);
        return $response;
    }

}