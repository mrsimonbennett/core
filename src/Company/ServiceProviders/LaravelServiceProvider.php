<?php
namespace FullRent\Core\Company\ServiceProviders;

use FullRent\Core\Company\CompanyRepository;
use FullRent\Core\Company\EventStoreCompanyRepository;
use FullRent\Core\Company\Projection\CompanyReadRepository;
use FullRent\Core\Company\Projection\MySqlCompanyReadRepository;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(CompanyRepository::class,EventStoreCompanyRepository::class);
        $this->app->bind(CompanyReadRepository::class, MysqlCompanyReadRepository::class);
    }
}