<?php

use App\Exceptions\Handler;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use FullRent\Core\CommandBus\CommandBus;

/**
 * @property CommandBus bus
 */
class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {

        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $this->bus = $app->make(CommandBus::class);

        return $app;


    }

    public function setUp()
    {
        parent::setUp();

    }

    /**
     * @param EventSourcedAggregateRoot $eventSourcedAggregateRoot
     * @return ArrayIterator
     */
    protected function events(EventSourcedAggregateRoot $eventSourcedAggregateRoot)
    {
        return $eventSourcedAggregateRoot->getUncommittedEvents()->getIterator();
    }

    /**
     * @param ArrayIterator $events
     * @param int $key
     * @param string $fullClassName
     */
    protected function checkCorrectEvent(ArrayIterator $events, $key, $fullClassName)
    {
        $this->assertInstanceOf($fullClassName, $events[$key]->getPayload());
    }
}