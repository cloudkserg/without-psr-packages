<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 18:14
 */

namespace Src\Core\Error;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Src\Core\Exception\AuthException;
use Src\Core\Exception\ErrorDataException;
use Src\Core\Exception\NotFoundException;
use Src\Core\Exception\ValidateException;
use Throwable;
use Zend\Diactoros\Response;

class ErrorResponseGenerator
{
    const ERROR_CODE = '500';

    /**
     * @var bool
     */
    private $isDevelopmentMode;

    /**
     * @param bool $isDevelopmentMode
     */
    public function __construct($isDevelopmentMode = false)
    {
        $this->isDevelopmentMode = (bool) $isDevelopmentMode;
    }

    /**
     * Create/update the response representing the error.
     *
     * @param Throwable|Exception $e
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function generateResponse($e, ServerRequestInterface $request)
    {
        if ($e instanceof NotFoundException) {
            return (new NotFoundGenerator())->generateResponse($e->getMessage());
        }
        if ($e instanceof ValidateException) {
            return (new ValidateErrorGenerator($this->isDevelopmentMode))
                ->generateResponse($request, $e->getMessage());
        }
        if ($e instanceof AuthException) {
            return (new AuthErrorGenerator())
                ->generateResponse();
        }
        return $this->generateCoreErrorResponse($e);
    }

    private function generateCoreErrorResponse(Throwable $e)
    {
        $response = new Response();
        $response = $response->withStatus(self::ERROR_CODE);
        $body = $response->getBody();
        if ($this->isDevelopmentMode) {
            $response = new Response\HtmlResponse(
                $e->getMessage() . "<br /><br />" . $e->getTraceAsString()
            );
            $response->withStatus(self::ERROR_CODE);
            return $response;
        }

        $body->write($response->getReasonPhrase() ?: 'Unknown Error');
        return $response;
    }
}