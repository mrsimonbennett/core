<?php
namespace FullRent\Core\Infrastructure;

use Illuminate\Support\ServiceProvider;
use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

/**
 * Class FullRentServiceProvider
 * @package FullRent\Core\Infrastructure
 * @author Simon Bennett <simon@bennett.im>
 */
abstract class FullRentServiceProvider extends ServiceProvider
{

    /**
     *
     */
    public function boot()
    {
        /** @var EventDispatcher $eventDispatcher */
        $eventDispatcher = $this->app->make(EventDispatcher::class);

        foreach ($this->getEventSubscribers() as $eventSubscriber) {
            $eventDispatcher->addSubscriber($this->app->make($eventSubscriber));
        }

    }

    /**
     * @return array
     */
    abstract function getEventSubscribers();
}