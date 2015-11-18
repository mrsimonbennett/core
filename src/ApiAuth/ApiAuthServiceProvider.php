<?php
namespace FullRent\Core\ApiAuth;

use Illuminate\Support\ServiceProvider;

/**
 * Class ApiAuthServiceProvider
 * @package FullRent\Core\ApiAuth
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApiAuthServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TokenChecker::class, ConfigBasedTokenChecker::class);
    }
}