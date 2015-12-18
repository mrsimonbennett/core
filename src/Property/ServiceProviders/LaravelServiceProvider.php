<?php
namespace FullRent\Core\Property\ServiceProviders;

use FullRent\Core\Infrastructure\FullRentServiceProvider;
use FullRent\Core\Property\Listener\PropertyApplicationEmailListener;
use FullRent\Core\Property\Listener\PropertyMysqlListenerV2;
use FullRent\Core\Property\Listener\PropertyDocumentsMySqlListener;
use FullRent\Core\Property\PropertyRepository;
use FullRent\Core\Property\Read\MysqlPropertiesReadRepository;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use FullRent\Core\Property\Read\Subscribers\MysqlPropertySubscriber;
use FullRent\Core\Property\Read\Subscribers\PropertyHistorySubscriber;
use FullRent\Core\Property\Read\Subscribers\PropertyImagesSubscriber;
use FullRent\Core\Property\SmoothPropertyRepository;

/**
 * Class LaravelServiceProvider
 * @package FullRent\Core\Property\ServiceProviders
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelServiceProvider extends FullRentServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PropertyRepository::class, SmoothPropertyRepository::class);
        $this->app->bind(PropertiesReadRepository::class, MysqlPropertiesReadRepository::class);
    }

    /**
     * @return array
     */
    function getEventSubscribers()
    {
        return [
            PropertyMysqlListenerV2::class,
            MysqlPropertySubscriber::class,
            PropertyHistorySubscriber::class,
            PropertyApplicationEmailListener::class,
            PropertyImagesSubscriber::class,
            PropertyDocumentsMySqlListener::class,
        ];
    }
}