<?php
namespace FullRent\Core\Listeners\Email;

use FullRent\Core\Infrastructure\FullRentServiceProvider;

/**
 * Class EmailListenersServiceProvider
 * @package FullRent\Core\Listeners\Email
 * @author Simon Bennett <simon@bennett.im>
 */
final class EmailListenersServiceProvider extends FullRentServiceProvider
{

    /**
     * @return array
     */
    function getEventSubscribers()
    {
        return [TenancyEmailListener::class];
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