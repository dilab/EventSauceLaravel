<?php

namespace Dilab\EventSauceLaravel\Test\Integration;

use Dilab\EventSauceLaravel\QueueJob;
use Dilab\EventSauceLaravel\QueueMessageDispatcher;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\Message;
use Illuminate\Support\Facades\Bus;

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
        Bus::fake();

        $collector = new CollectingConsumer();
        $dispatcher = new QueueMessageDispatcher($collector);
        $event = new TestEvent();
        $message = (new DefaultHeadersDecorator())->decorate(new Message($event));

        // Act
        $dispatcher->dispatch($message);

        // Assert
        Bus::assertDispatched(QueueJob::class, function (QueueJob $job) use ($collector, $message) {
            return $job->message == $message && $job->consumer == $collector;
        });
    }

}
