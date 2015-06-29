<?php namespace FullRent\Core\Application\Providers;

use FullRent\Core\Company\Projection\Subscribers\MysqlCompanySubscriber;
use FullRent\Core\Deposit\Listeners\DepositMySqlListenerV2;
use FullRent\Core\Property\Read\Subscribers\MysqlPropertySubscriber;
use FullRent\Core\RentBook\Listeners\RentBookAuthorizedListener;
use FullRent\Core\RentBook\Listeners\RentBookContractListener;
use FullRent\Core\RentBook\Listeners\RentBookMysqlListener;
use FullRent\Core\User\Projections\Subscribers\UserMysqlSubscriber;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use FullRent\Core\Application\Infrastructure\WriteEventsToElasticSearch;
use FullRent\Core\Application\Listeners\ApplicationMysqlListener;
use FullRent\Core\Company\Projection\Subscribers\ApplicationEventListener;
use FullRent\Core\Contract\Listeners\ContractApplicationListener;
use FullRent\Core\Contract\Listeners\ContractMailListener;
use FullRent\Core\Contract\Listeners\ContractMysqlListener;
use FullRent\Core\Deposit\Listeners\ContractListener;
use FullRent\Core\Deposit\Listeners\DepositMysqlListener;
use FullRent\Core\Infrastructure\Email\ApplicationEmails;
use FullRent\Core\Property\Read\Subscribers\PropertyHistorySubscriber;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        DepositMySqlListenerV2::class,
        /**
         * Rent Book
         */
        RentBookContractListener::class,
        RentBookMysqlListener::class,
        RentBookAuthorizedListener::class,

        /**
         * Company
         */
        MysqlCompanySubscriber::class,

        /**
         * User
         */
        UserMysqlSubscriber::class,

        /**
         * Properties
         */
        MysqlPropertySubscriber::class,
        PropertyHistorySubscriber::class,

        /**
         * Applications
         */
        ApplicationMysqlListener::class,
        ApplicationEmails::class,
        ContractApplicationListener::class,
        ApplicationEventListener::class,


        /**
         * Contracts
         */
        ContractMysqlListener::class,
        ContractMailListener::class,



    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);


    }

}
