<?php
namespace FullRent\Core\Application;

use SmoothPhp\EventSourcing\EventSourcedRepository;

/**
 * Class SmoothApplicationRepository
 * @package FullRent\Core\Application
 * @author Simon Bennett <simon@bennett.im>
 */
final class SmoothApplicationRepository extends EventSourcedRepository implements ApplicationRepository
{
    /**
     * @return string
     */
    protected function getPrefix()
    {
        return 'application-';
    }

    protected function getAggregateType()
    {
        return Application::class;
    }
}