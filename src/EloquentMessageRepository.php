<?php

namespace Dilab\EventSauceLaravel;


use EventSauce\EventSourcing\Header;
use Generator;
use EventSauce\EventSourcing\Message;
use Illuminate\Database\Eloquent\Model;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class EloquentMessageRepository extends Model implements MessageRepository
{
    protected $table = 'domain_messages';

    /**
     * @var MessageSerializer
     */
    private $serializer;

    public function __construct(MessageSerializer $serializer, array $attributes = [])
    {
        parent::__construct($attributes);
        $this->serializer = $serializer;
    }

    public function persist(Message ...$messages)
    {
        $data = array_map(function (Message $message) {

            $payload = $this->serializer->serializeMessage($message);

            return [
                'event_id' => $payload['headers'][Header::EVENT_ID] = $payload['headers'][Header::EVENT_ID] ?? Uuid::uuid4()->toString(),
                'event_type' => $payload['headers'][Header::EVENT_TYPE],
                'aggregate_root_id' => $payload['headers'][Header::AGGREGATE_ROOT_ID] ?? null,
                'time_of_recording' => $payload['headers'][Header::TIME_OF_RECORDING],
                'payload' => json_encode($payload, JSON_PRETTY_PRINT)
            ];

        }, $messages);


        DB::transaction(function () use ($data) {
            self::insert($data);
        });
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        $messages = DB::table('domain_messages')
            ->select('payload')
            ->where('aggregate_root_id', $id->toString())
            ->orderBy('time_of_recording', 'ASC')
            ->get();

        foreach ($messages as $message) {
            yield from $this->serializer->unserializePayload(json_decode($message->payload, true));
        }
    }

    public function retrieveEverything(): Generator
    {
        $messages = DB::table('domain_messages')
            ->select('payload')
            ->orderBy('time_of_recording', 'ASC')
            ->get();

        foreach ($messages as $message) {
            yield from $this->serializer->unserializePayload(json_decode($message->payload, true));
        }
    }
}