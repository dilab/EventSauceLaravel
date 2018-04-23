<?php

namespace Dilab\EventSauceLaravel;


use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;

class QueueJob implements ShouldQueue
{
    use Dispatchable;

    /**
     * @var Consumer
     */
    protected $consumer;

    /**
     * @var Message
     */
    protected $message;
    
    /**
     * QueueJob constructor.
     * @param Consumer $consumer
     * @param Message $message
     */
    public function __construct(Consumer $consumer, Message $message)
    {
        $this->consumer = $consumer;
        $this->message = $message;
    }

    public function handle()
    {
        return $this->consumer->handle($this->message);
    }

}