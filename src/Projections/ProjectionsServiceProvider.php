<?php
namespace FullRent\Core\Projections;

use FullRent\Core\Projections\AuthProjection\AuthMysqlProjection;
use SmoothPhp\LaravelAdapter\AggregateServiceProvider;

/**
 * Class ProjectionsServiceProvider
 * @package FullRent\Core\Projections
 * @author Simon Bennett <simon@bennett.im>
 */
final class ProjectionsServiceProvider extends AggregateServiceProvider
{

    /**
     * @return array
     */
    public function getEventSubscribers()
    {
        return [
            AuthMysqlProjection::class,
        ];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}