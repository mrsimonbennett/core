<?php
namespace FullRent\Core\Company\ServiceProviders;

use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\Projection\CompanyReadRepository;
use FullRent\Core\Company\Projection\MySqlCompanyReadRepository;
use FullRent\Core\Company\Projection\Subscribers\ApplicationEventListener;
use FullRent\Core\Company\Projection\Subscribers\MysqlCompanySubscriber;
use FullRent\Core\Company\SmoothCompanyRepository;
use Illuminate\Support\ServiceProvider;
use SmoothPhp\Contracts\EventDispatcher\EventDispatcher;

/**
 * Class LaravelServiceProvider
 * @package FullRent\Core\Company\ServiceProviders
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
        $this->app->bind(CompanyRepository::class, SmoothCompanyRepository::class);
        $this->app->bind(CompanyReadRepository::class, MysqlCompanyReadRepository::class);



    }
    public function boot()
    {
        /** @var EventDispatcher $dispatcher */
        $dispatcher = $this->app->make(EventDispatcher::class);

        $dispatcher->addSubscriber($this->app->make(MysqlCompanySubscriber::class));
        $dispatcher->addSubscriber($this->app->make(ApplicationEventListener::class));
    }
}