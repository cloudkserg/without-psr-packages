<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 16:58
 */

namespace Src\Worker;


use Bunny\Message;

interface WorkerInterface
{

    public function handle(Message $message);

}