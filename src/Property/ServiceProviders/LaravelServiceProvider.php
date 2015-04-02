<?php
namespace FullRent\Core\Property\ServiceProviders;

use FullRent\Core\Property\BroadWayPropertyRepository;
use FullRent\Core\Property\PropertyRepository;
use FullRent\Core\Property\Read\MysqlPropertiesReadRepository;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelServiceProvider
 * @package FullRent\Core\Property\ServiceProviders
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PropertyRepository::class, BroadWayPropertyRepository::class);
        $this->app->bind(PropertiesReadRepository::class, MysqlPropertiesReadRepository::class);
    }
}