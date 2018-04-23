<?php

namespace Dilab\EventSauceLaravel;


use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;

class QueueMessageDispatcher implements MessageDispatcher
{
    public function dispatch(Message ...$messages)
    {
        // TODO: Implement dispatch() method.
    }

}