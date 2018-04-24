# EventSauceLaravel
Laravel Package for EventSauce

## About
This is the Laravel package for [EventSauce](https://github.com/eventsaucephp/eventsauce)

## Install
```composer require dilab/event-sauce-laravel```

## Usage

### EloquentMessageRepository
This is a message storage (database) using Eloquent. 
It implements **MessageRepository** interface.

### QueueMessageDispatcher
This is a message dispatcher using queue provided by Laravel Queue system. 
It implements **MessageDispatcher** interface.