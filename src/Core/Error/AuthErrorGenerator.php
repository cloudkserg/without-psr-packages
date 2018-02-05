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

class AuthErrorGenerator
{
    const CODE = '403';
    const MESSAGE = 'Access denied';

    public function generateResponse() :ResponseInterface
    {
        $response = new Response();
        $response->withStatus(self::CODE, self::MESSAGE);
        $response->getBody()->write(self::MESSAGE);
        return $response;
    }

}