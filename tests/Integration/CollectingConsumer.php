<?php

namespace Dilab\EventSauceLaravel\Test\Integration;

use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;

class CollectingConsumer implements Consumer
{
    public $message;

    public function handle(Message $message)
    {
        $this->message = $message;
    }
}