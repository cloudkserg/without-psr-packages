<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 18:16
 */

namespace Src\Core\Error;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

class ValidateErrorGenerator
{
    const CODE = '404';
    /**
     * @var bool
     */
    private $devMode;

    public function __construct(bool $devMode)
    {
        $this->devMode = $devMode;
    }


    public function generateResponse(ServerRequestInterface $request, string $message) :ResponseInterface
    {
        if (!$this->devMode) {
            $referer = isset($request->getServerParams()['HTTP_REFERER']) ? $request->getServerParams()['HTTP_REFERER'] : '/';
            return new Response\RedirectResponse($referer);
        }
        $response = new Response\HtmlResponse($message, self::CODE);
        return $response;
    }

}