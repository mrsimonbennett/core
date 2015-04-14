<?php
namespace FullRent\Core\Application\Providers;

use Collective\Annotations\AnnotationsServiceProvider as ServiceProvider;
use FullRent\Core\Application\Listeners\ApplicationMysqlListener;
use FullRent\Core\Company\Projection\Subscribers\MysqlCompanySubscriber;
use FullRent\Core\Infrastructure\Email\ApplicationEmails;
use FullRent\Core\Property\Read\Subscribers\MysqlPropertySubscriber;
use FullRent\Core\Property\Read\Subscribers\PropertyHistorySubscriber;
use FullRent\Core\User\Projections\Subscribers\UserMysqlSubscriber;

class AnnotationsServiceProvider extends ServiceProvider {

    /**
     * The classes to scan for event annotations.
     *
     * @var array
     */
    protected $scanEvents = [
        MysqlCompanySubscriber::class,
        UserMysqlSubscriber::class,
        MysqlPropertySubscriber::class,
        PropertyHistorySubscriber::class,
        ApplicationMysqlListener::class,
        ApplicationEmails::class
    ];

    /**
     * The classes to scan for route annotations.
     *
     * @var array
     */
    protected $scanRoutes = [];

    /**
     * The classes to scan for model annotations.
     *
     * @var array
     */
    protected $scanModels = [];

    /**
     * Determines if we will auto-scan in the local environment.
     *
     * @var bool
     */
    protected $scanWhenLocal = true;

    /**
     * Determines whether or not to automatically scan the controllers
     * directory (App\Http\Controllers) for routes
     *
     * @var bool
     */
    protected $scanControllers = false;

    /**
     * Determines whether or not to automatically scan all namespaced
     * classes for event, route, and model annotations.
     *
     * @var bool
     */
    protected $scanEverything = false;


}