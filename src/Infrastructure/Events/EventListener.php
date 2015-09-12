<?php
namespace FullRent\Core\Infrastructure\Events;

/**
 * Class EventListener
 * @package FullRent\Core\Infrastructure\Events
 * @author Simon Bennett <simon@bennett.im>
 */
abstract class EventListener
{
    protected $priority = 0;

    /**
     * @return array
     */
    protected function registerOnce()
    {
        return [];
    }

    /**
     * @return array
     */
    protected abstract function register();

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $dispatcher
     * @return array
     */
    public function subscribe($dispatcher)
    {
        if (app()->environment() !== 'replay') {
            $this->registerEvents($this->registerOnce(), $dispatcher);
        }

        $this->registerEvents($this->register(), $dispatcher);
    }

    /**
     * Covert the class name to dots for event listeners
     * @param string $className
     * @return string
     */
    private function transform($className)
    {
        return str_replace('\\', '.', $className);
    }

    /**
     * @param $subscribers
     * @param \Illuminate\Events\Dispatcher $dispatcher
     */
    private function registerEvents($subscribers, $dispatcher)
    {
        foreach ($subscribers as $method => $name) {
            $dispatcher->listen([0 => $this->transform($name)],
                                get_class($this) . '@' . $method,$this->priority);
        }
    }
}