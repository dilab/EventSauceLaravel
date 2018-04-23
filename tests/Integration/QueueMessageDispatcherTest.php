<?php

namespace Dilab\EventSauceLaravel\Test\Integration;

use Dilab\EventSauceLaravel\QueueMessageDispatcher;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\Message;

class QueueMessageDispatcherTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_works()
    {
        // Arrange
        $collector = new CollectingConsumer();
        $dispatcher = new QueueMessageDispatcher($collector);
        $event = new TestEvent();
        $message = (new DefaultHeadersDecorator())->decorate(new Message($event));

        // Act
        $dispatcher->dispatch($message);

        // Assert
        $this->assertEquals($message, $collector->message);
    }
}
