<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 28.01.18
 * Time: 0:04
 */

namespace Src\Core\Error;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NotFoundMiddleware implements MiddlewareInterface
{

    /**
     * @var NotFoundGenerator
     */
    private $generator;

    public function __construct(NotFoundGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->generator->generateResponse('Not found page');
    }


}