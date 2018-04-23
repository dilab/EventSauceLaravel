<?php

namespace Dilab\EventSauceLaravel;


use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;

class QueueMessageDispatcher implements MessageDispatcher
{
    /**
     * @var Consumer[]
     */
    private $consumers;

    public function __construct(Consumer ...$consumers)
    {
        $this->consumers = $consumers;
    }

    public function dispatch(Message ...$messages)
    {
        foreach ($messages as $message) {
            foreach ($this->consumers as $consumer) {
                QueueJob::dispatch($consumer, $message);
            }
        }
    }

}