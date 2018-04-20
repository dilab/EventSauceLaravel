<?php
/**
 * Created by PhpStorm.
 * User: xu
 * Date: 19/4/18
 * Time: 11:57 AM
 */

namespace Dilab\EventSauceLaravel;


use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\MessageRepository;
use Generator;

class EloquentMessageRepository implements MessageRepository
{
    public function persist(Message ...$messages)
    {
        // TODO: Implement persist() method.
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        // TODO: Implement retrieveAll() method.
    }

}