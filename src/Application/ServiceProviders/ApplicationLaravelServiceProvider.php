<?php
namespace FullRent\Core\Application\ServiceProviders;

use FullRent\Core\Application\ApplicationRepository;
use FullRent\Core\Application\BoardWayApplicationRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class ApplicationLaravelServiceProvider
 * @package FullRent\Core\Application\ServiceProviders
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApplicationLaravelServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApplicationRepository::class, BoardWayApplicationRepository::class);
    }
}