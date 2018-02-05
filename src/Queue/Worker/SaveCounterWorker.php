<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 16:58
 */

namespace Src\Worker;


use Bunny\Message;
use Src\Model\Counter;

class SaveCounterWorker implements WorkerInterface
{
    /**
     * @var CounterService
     */
    private $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }


    private function getCounter(Message $message) : Counter
    {
        return unserialize($message);
    }


    public function handle(Message $message)
    {
        $counter = $this->getCounter($message);
        $this->counterService->incrementCounter($counter);
    }


}