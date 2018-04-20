<?php

namespace Dilab\EventSauceLaravel\Test\Integration;


use Dilab\EventSauceLaravel\EloquentMessageRepository;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\Header;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Time\TestClock;
use EventSauce\EventSourcing\UuidAggregateRootId;
use Ramsey\Uuid\Uuid;

class EloquentMessageRepositoryTest extends TestCase
{
    /**
     * @var EloquentMessageRepository
     */
    private $repository;

    /**
     * @var TestClock
     */
    private $clock;

    /**
     * @var MessageDecorator
     */
    private $decorator;

    public function setUp()
    {
        parent::setUp();

        $serializer = new ConstructingMessageSerializer();
        $this->clock = new TestClock();
        $this->decorator = new DefaultHeadersDecorator(null, $this->clock);
        $this->repository = new EloquentMessageRepository($serializer);
    }

    /**
     * @test
     */
    public function it_works()
    {
        $aggregateRootId = UuidAggregateRootId::create();
        $this->repository->persist();
        $this->assertEmpty(iterator_to_array($this->repository->retrieveAll($aggregateRootId)));

        $eventId = Uuid::uuid4()->toString();
        $message = $this->decorator->decorate(new Message(new TestEvent(), [
            Header::EVENT_ID => $eventId,
            Header::AGGREGATE_ROOT_ID => $aggregateRootId->toString(),
        ]));
        $this->repository->persist($message);
        $retrievedMessage = iterator_to_array($this->repository->retrieveAll($aggregateRootId), false)[0];
        $this->assertEquals($message, $retrievedMessage);
    }

    /**
     * @test
     */
    public function persisting_events_without_aggregate_root_ids()
    {
        $eventId = Uuid::uuid4();
        $message = $this->decorator->decorate(new Message(new TestEvent((new TestClock())->pointInTime()), [
            Header::EVENT_ID => $eventId->toString(),
        ]));
        $this->repository->persist($message);
        $persistedMessages = iterator_to_array($this->repository->retrieveEverything());
        $this->assertCount(1, $persistedMessages);
        $this->assertEquals($message, $persistedMessages[0]);
    }

    /**
     * @test
     */
    public function persisting_events_without_event_ids()
    {
        $message = $this->decorator->decorate(new Message(new TestEvent((new TestClock())->pointInTime())));
        $this->repository->persist($message);
        $persistedMessages = iterator_to_array($this->repository->retrieveEverything());
        $this->assertCount(1, $persistedMessages);
        $this->assertNotEquals($message, $persistedMessages[0]);
    }
}
