<?php
namespace FullRent\Core\Application\Providers;

use FullRent\Core\Services\DirectDebit\DirectDebit;
use FullRent\Core\Services\DirectDebit\DirectDebitAccountAuthorisation;
use FullRent\Core\Services\DirectDebit\GoCardLess\GoCardLessAuthorisation;
use FullRent\Core\Services\DirectDebit\GoCardLess\GoCardlessDirectDebit;
use Illuminate\Support\ServiceProvider;

/**
 * Class DirectDebitServiceProvider
 * @package FullRent\Core\Application\Providers
 * @author Simon Bennett <simon@bennett.im>
 */
final class DirectDebitServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DirectDebitAccountAuthorisation::class,GoCardLessAuthorisation::class);
        $this->app->bind(DirectDebit::class, GoCardlessDirectDebit::class);
    }
}