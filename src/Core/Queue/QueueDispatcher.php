<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 16:49
 */

namespace Src\Core\Queue;


use Bunny\Channel;
use Bunny\Client;
use Bunny\Message;
use Psr\Log\LoggerInterface;

class QueueDispatcher
{

    /**
     * @var \Bunny\Channel|\React\Promise\PromiseInterface
     */
    private $channel;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(Client $coreClient, LoggerInterface $logger)
    {
        $coreClient->connect();
        $this->channel = $coreClient->channel();
        $this->channel->queueDeclare(QueueBroker::NAME_QUEUE,
            false, true, false,false);
        $this->channel->qos(0, 1);
        $this->logger = $logger;
    }



    public function processMessage(Message $message, Channel $channel, Client $client)
    {
        $this->logger->info('get message for worker: ' . $message->content);

        $task = $this->
    }




    public function dispatch()
    {
        $this->channel->run( [$this, processMessage], QueueBroker::NAME_QUEUE);
            function (Message $message, Channel $channel, Client $client) {
                echo " [x] Received ", $message->content, "\n";
                sleep(substr_count($message->content, '.'));
                echo " [x] Done", "\n";
                $channel->ack($message);
            },
            'task_queue'
        );
    }

}