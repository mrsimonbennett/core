<?php
namespace FullRent\Core\Application\Infrastructure;

use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class LaravelQueueHandler
 * @package FullRent\Core\Application\Infrastructure
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelQueueHandler
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function fire($job, $data)
    {
        $this->dispatcher->fire($data['type'],
            (call_user_func(
                [
                    str_replace('.', '\\', $data['type']),
                    'deserialize'
                ],
                $data['job']
            )));
        return $job->delete();
    }
}