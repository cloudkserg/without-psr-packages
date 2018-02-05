<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 27.01.18
 * Time: 23:59
 */

namespace Src\Core\Error;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class ErrorMiddleware implements MiddlewareInterface
{

    /**
     * @var ErrorResponseGenerator
     */
    private $generator;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(ErrorResponseGenerator $generator, LoggerInterface $logger)
    {
        $this->generator = $generator;
        $this->logger = $logger;
    }




    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        set_error_handler($this->createErrorHandler());

        try {
            $response = $handler->handle($request);

            if (! $response instanceof ResponseInterface) {
                throw new \Exception('Application did not return a response');
            }

        } catch (\Exception $e) {
            $response = $this->handleThrowable($e, $request);
         } catch (\Throwable $e) {
            $response = $this->handleThrowable($e, $request);
        }

        restore_error_handler();

        return $response;
    }


    private function handleThrowable($e, ServerRequestInterface $request)
    {
        $response = $this->generator->generateResponse($e, $request);
        $this->logError($e, $request);
        return $response;
    }

    private function createErrorHandler() : callable
    {
        return function ($errno, $errstr, $errfile, $errline) {
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        };
    }


    private function logError(\Throwable $e, $request)
    {
            $message = sprintf(
                '[%s] %s %s: %s %s',
                date('Y-m-d H:i:s'),
                $request->getMethod(),
                (string) $request->getUri(),
                $e->getMessage(),
                $e->getTraceAsString()
            );
            $this->logger->error($message);
    }

}